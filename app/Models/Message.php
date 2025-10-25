<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    /**
     * Поля, які можна заповнювати.
     */
    protected $fillable = [
        'user_id',
        'chat_id',
        'content',
    ];

    /**
     * Користувач (відправник), якому належить повідомлення.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Чат, якому належить повідомлення.
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}