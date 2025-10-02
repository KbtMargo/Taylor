<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    use SoftDeletes;
    use HasFactory;


    protected $fillable = [
        'user_id','category_id','title','slug','excerpt','body','published_at'
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function author()  { return $this->belongsTo(User::class, 'user_id'); }
    public function category(){ return $this->belongsTo(Category::class); }
    public function tags()    { return $this->belongsToMany(Tag::class); }
    public function comments(){ return $this->hasMany(Comment::class)->latest(); }

    public function scopePublished($q){ return $q->whereNotNull('published_at')->where('published_at','<=',now()); }
}
