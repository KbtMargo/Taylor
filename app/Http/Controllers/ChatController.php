<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use App\Events\MessageDeleted; // Новий івент для видалення повідомлень
use App\Events\ChatDeleted; // Новий івент для видалення чатів

class ChatController extends Controller
{
    /**
     * Завантажує чат (або створює новий) і його повідомлення
     */
    public function loadChat(Request $request)
    {
        $recipientId = $request->input('recipient_id');
        $chatIdRequest = $request->input('chat_id');
        $currentUser = Auth::user();

        $chat = null;

        if ($chatIdRequest) {
            $chat = $currentUser->chats()->with('participants')->find($chatIdRequest);
            if (!$chat || $chat->type !== 'group') {
                 Log::warning('Attempt to load non-existent or non-group chat', ['chatId' => $chatIdRequest, 'userId' => $currentUser->id]);
                 return response()->json(['error' => 'Group chat not found or you are not a participant.'], 404);
            }
        }
        elseif ($recipientId) {
            if (empty($recipientId) || !is_numeric($recipientId) || $recipientId == $currentUser->id) {
                 Log::error('Invalid recipientId received in loadChat', ['recipientId' => $recipientId, 'userId' => $currentUser->id]);
                 return response()->json(['error' => 'Invalid recipient ID provided.'], 400);
            }
            $recipientId = (int)$recipientId;

            $recipientUser = User::find($recipientId);
            if (!$recipientUser) {
                 Log::warning('Recipient user not found', ['recipientId' => $recipientId, 'userId' => $currentUser->id]);
                 return response()->json(['error' => 'Recipient user not found.'], 404);
            }

            $chat = $currentUser->chats()
                ->where('type', 'private')
                ->whereHas('participants', function ($query) use ($recipientId) {
                    $query->where('user_id', $recipientId);
                })
                ->with('participants')
                ->first();

            if (!$chat) {
                 Log::info('Creating new private chat', ['user1' => $currentUser->id, 'user2' => $recipientId]);
                try {
                    $chat = Chat::create(['type' => 'private']);
                    $chat->participants()->attach([$currentUser->id, $recipientId]);
                    $chat->load('participants');
                     Log::info('New private chat created successfully', ['chatId' => $chat->id]);
                } catch (\Exception $e) {
                     Log::error('Failed to create private chat or attach participants', ['error' => $e->getMessage(), 'user1' => $currentUser->id, 'user2' => $recipientId]);
                     return response()->json(['error' => 'Failed to create chat.'], 500);
                }
            }
        }
        else {
             Log::warning('Missing recipient_id or chat_id in loadChat request', ['userId' => $currentUser->id]);
            return response()->json(['error' => 'Missing recipient_id or chat_id.'], 400);
        }

        if (!$chat) {
             Log::error('Chat object is null after loading/creation attempt', ['userId' => $currentUser->id, 'recipientId' => $recipientId, 'chatIdRequest' => $chatIdRequest]);
             return response()->json(['error' => 'Chat could not be loaded or created.'], 500);
        }

        $messages = $chat->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'chat' => $chat,
            'messages' => $messages
        ]);
    }

    /**
     * Зберігає нове повідомлення в базі даних.
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required|string|max:1000',
        ]);

        $currentUser = Auth::user();
        $chatId = $validated['chat_id'];
        $content = $validated['content'];

        $chat = $currentUser->chats()->find($chatId);
        if (!$chat) {
             Log::warning('Unauthorized attempt to send message', ['chatId' => $chatId, 'userId' => $currentUser->id]);
            return response()->json(['error' => 'Unauthorized or Chat not found'], 403);
        }

        try {
            $message = $chat->messages()->create([
                'user_id' => $currentUser->id,
                'content' => $content,
            ]);

            $message->load('user');

             Log::info('Broadcasting MessageSent event', ['messageId' => $message->id, 'chatId' => $chatId]);
            broadcast(new MessageSent($message))->toOthers();

            return response()->json($message);

        } catch (\Exception $e) {
             Log::error('Failed to send message or broadcast event', ['error' => $e->getMessage(), 'chatId' => $chatId, 'userId' => $currentUser->id]);
             return response()->json(['error' => 'Failed to send message.'], 500);
        }
    }

    /**
     * Створює новий груповий чат.
     */
    public function createGroupChat(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'user_ids' => 'required|array|min:2',
            'user_ids.*' => 'exists:users,id',
        ]);

        $currentUser = Auth::user();
        $participantIds = $validated['user_ids'];

        if (!in_array($currentUser->id, $participantIds)) {
            $participantIds[] = $currentUser->id;
        }
        $uniqueParticipantIds = array_unique($participantIds);

        $otherUserIds = array_filter($uniqueParticipantIds, fn($id) => $id != $currentUser->id);
        if (count($otherUserIds) < 2) {
             Log::warning('Attempt to create group with less than 3 participants', ['userId' => $currentUser->id, 'selectedIds' => $validated['user_ids']]);
             return response()->json(['error' => 'Група має містити щонайменше 2 інших учасників.'], 422);
        }

        try {
            $chat = Chat::create([
                'title' => $validated['title'],
                'type' => 'group',
            ]);

            $chat->participants()->attach($uniqueParticipantIds);
             Log::info('Group chat created successfully', ['chatId' => $chat->id, 'title' => $chat->title, 'creatorId' => $currentUser->id]);

            return response()->json($chat->load('participants'));
        } catch (\Exception $e) {
             Log::error('Failed to create group chat', ['error' => $e->getMessage(), 'userId' => $currentUser->id, 'title' => $validated['title']]);
             return response()->json(['error' => 'Failed to create group chat.'], 500);
        }
    }

    /**
     * Видаляє повідомлення (тільки власне)
     */
    public function deleteMessage(Request $request, $messageId)
    {
        $currentUser = Auth::user();
        
        try {
            $message = Message::where('user_id', $currentUser->id)
                ->where('id', $messageId)
                ->firstOrFail();

            $chatId = $message->chat_id;
            $message->delete();

            // Транслюємо інформацію про видалення всім учасникам чату
            broadcast(new MessageDeleted($messageId, $chatId))->toOthers();

            Log::info('Message deleted successfully', ['messageId' => $messageId, 'userId' => $currentUser->id]);
            return response()->json(['success' => true, 'message' => 'Повідомлення видалено']);

        } catch (\Exception $e) {
            Log::error('Failed to delete message', ['error' => $e->getMessage(), 'messageId' => $messageId, 'userId' => $currentUser->id]);
            return response()->json(['error' => 'Повідомлення не знайдено або у вас немає прав на його видалення.'], 403);
        }
    }

    /**
     * Видаляє чат (тільки для приватних чатів або якщо користувач є учасником групового чату)
     */
    public function deleteChat(Request $request, $chatId)
    {
        $currentUser = Auth::user();
        
        try {
            $chat = $currentUser->chats()->findOrFail($chatId);

            // Для приватних чатів - видаляємо зв'язок учасника
            if ($chat->type === 'private') {
                $chat->participants()->detach($currentUser->id);
                
                // Якщо в чаті не залишилося учасників - видаляємо чат повністю
                if ($chat->participants()->count() === 0) {
                    $chat->messages()->delete();
                    $chat->delete();
                    broadcast(new ChatDeleted($chatId))->toOthers();
                }
                
                Log::info('User left private chat', ['chatId' => $chatId, 'userId' => $currentUser->id]);
                return response()->json(['success' => true, 'message' => 'Чат видалено']);
            }
            
            // Для групових чатів - тільки адміністратор може видалити (тут можна додати перевірку на роль)
            elseif ($chat->type === 'group') {
                // Проста перевірка - якщо користувач є учасником, він може "покинути" групу
                $chat->participants()->detach($currentUser->id);
                
                Log::info('User left group chat', ['chatId' => $chatId, 'userId' => $currentUser->id]);
                return response()->json(['success' => true, 'message' => 'Ви вийшли з групи']);
            }

        } catch (\Exception $e) {
            Log::error('Failed to delete chat', ['error' => $e->getMessage(), 'chatId' => $chatId, 'userId' => $currentUser->id]);
            return response()->json(['error' => 'Чат не знайдено або у вас немає прав на його видалення.'], 403);
        }
    }
}