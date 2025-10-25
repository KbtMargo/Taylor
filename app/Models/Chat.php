<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    /**
     * Поля, які можна заповнювати.
     */
    protected $fillable = [
        'title',
        'type',
    ];

    /**
     * Учасники цього чату.
     */
    public function participants(): BelongsToMany
    {
        // Зв'язок "багато-до-багатьох" через таблицю 'participants'
        return $this->belongsToMany(User::class, 'participants', 'chat_id', 'user_id');
    }

    /**
     * Повідомлення в цьому чаті.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}