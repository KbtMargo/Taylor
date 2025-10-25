<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Chat;               
use App\Models\Message;             
use App\Models\User;
class ChatController extends Controller
{
    /**
     * Завантажує чат (або створює новий) і його повідомлення.
     * * Цей метод спрацює, коли користувач клікне на ім'я 
     * у списку контактів.
     */
    public function loadChat(Request $request)
    {
        // 1. Отримуємо ID того, з ким хочемо почати чат
        $recipientId = $request->input('recipient_id');
        $currentUser = Auth::user();

        // 2. Шукаємо існуючий ПРИВАТНИЙ чат між цими двома
        $chat = $currentUser->chats()
            ->where('type', 'private')
            ->whereHas('participants', function ($query) use ($recipientId) {
                // Де серед учасників є $recipientId
                $query->where('user_id', $recipientId);
            })
            ->first();

        // 3. Якщо чату НЕ існує - створюємо його
        if (!$chat) {
            $chat = Chat::create([
                'type' => 'private',
            ]);
            
            // Прив'язуємо обох користувачів до цього чату
            $chat->participants()->attach([
                $currentUser->id,
                $recipientId
            ]);
        }

        // 4. Завантажуємо повідомлення для цього чату
        // 'with('user')' одразу підтягує інфо про відправника
        $messages = $chat->messages()
            ->with('user') 
            ->orderBy('created_at', 'asc') // Сортуємо (старі вгорі)
            ->get();

        // 5. Повертаємо все у форматі JSON
        return response()->json([
            'chat' => $chat,
            'messages' => $messages
        ]);
    }

    /**
     * Зберігає нове повідомлення в базі даних.
     * * Цей метод спрацює, коли користувач натисне "Відправити".
     */
    public function sendMessage(Request $request)
    {
        // 1. Валідація: нам потрібен ID чату і текст повідомлення
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required|string',
        ]);

        $currentUser = Auth::user();
        $chatId = $request->input('chat_id');
        $content = $request->input('content');

        // 2. Перевірка безпеки: чи є поточний користувач
        //    взагалі учасником цього чату?
        $chat = $currentUser->chats()->find($chatId);

        if (!$chat) {
            // 403 Forbidden - у вас немає доступу до цього чату
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 3. Створюємо повідомлення
        $message = $chat->messages()->create([
            'user_id' => $currentUser->id,
            'content' => $content,
        ]);

        // 4. Завантажуємо інфо про відправника (для JS)
        $message->load('user');

        // TODO: (Майбутній крок за схемою викладача)
        // Тут ми будемо відправляти подію (Event) у Websocket,
        // щоб одержувач побачив повідомлення миттєво.
        // event(new NewMessageSent($message));
        
        // 5. Повертаємо створене повідомлення у JSON
        return response()->json($message);
    }
}