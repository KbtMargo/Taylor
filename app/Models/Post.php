<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts'; 
    protected $fillable = ['title','slug','body','status','published_at','category_id']; 
    protected $casts = ['published_at' => 'datetime'];

    public function scopePublished($q){ return $q->whereNotNull('published_at')->where('published_at','<=',now()); }
    public function scopeSearch($q,$s){ return $s ? $q->where('title','like',"%$s%") : $q; }
}
