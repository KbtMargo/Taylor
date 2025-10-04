<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AtelierPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'atelier_id','title','slug','image_path','description','status','published_at','sort_order'
    ];
    protected $casts = ['published_at'=>'datetime'];

    public function atelier(){ return $this->belongsTo(Atelier::class); }
    public function comments(){ return $this->morphMany(Comment::class, 'commentable'); }

    public function scopePublished($q){ return $q->where('status','published')->whereNotNull('published_at')->where('published_at','<=',now()); }
}
