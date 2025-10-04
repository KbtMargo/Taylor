<?php
namespace App\Models; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atelier extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','phone','address','description'];

    public function getRouteKeyName(): string { return 'slug'; }

    protected static function booted()
    {
        static::creating(function ($atelier) {
            if (empty($atelier->slug)) {
                $atelier->slug = static::makeUniqueSlug($atelier->name);
            }
        });
    }

    protected static function makeUniqueSlug(string $name): string
    {
        $base = Str::slug($name ?: 'atelier');
        $slug = $base;
        $suffix = 1;
        while (static::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix++;
        }
        return $slug;
    }

    public function photos(){ return $this->hasMany(\App\Models\AtelierPhoto::class); }
    public function comments() { return $this->morphMany(Comment::class, 'commentable'); }
    public function categories(){ return $this->belongsToMany(\App\Models\Category::class, 'atelier_category'); }
}
