<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $messageId;
    public $chatId;

    public function __construct($messageId, $chatId)
    {
        $this->messageId = $messageId;
        $this->chatId = $chatId;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->chatId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.deleted';
    }
}