<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
    ];

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'participants', 'chat_id', 'user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}