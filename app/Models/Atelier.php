<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atelier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'phone',
        'address',
        'description',
    ];

    public function photos()
    {
        return $this->hasMany(\App\Models\AtelierPhoto::class);
    }

    public function comments()
    {
        return $this->morphMany(\App\Models\Comment::class, 'commentable');
    }

    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'atelier_category');
    }
}
