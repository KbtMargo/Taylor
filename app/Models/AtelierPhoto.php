<?php
namespace App\Models; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class AtelierPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'atelier_id','title','slug','image_path','description',
        'status','published_at','sort_order'
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function atelier()
    { 
        return $this->belongsTo(Atelier::class); 
    }
    
    public function scopePublished($q)
    {
        return $q->where('status','published')
                 ->whereNotNull('published_at')
                 ->where('published_at','<=',now());
    }

    public function getUrlAttribute()
    {
     return $this->image_path 
        ? Storage::disk('public')->url($this->image_path) 
        : null;
    }    
    
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if (empty($this->attributes['slug']) && !empty($value)) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
}