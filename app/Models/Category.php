<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    public $timestamps = false;
    protected $fillable = ['name','slug'];

    public function getRouteKeyName(): string { return 'slug'; }

    protected static function booted()
    {
        static::creating(function (Category $cat) {
            if (empty($cat->slug)) {
                $cat->slug = static::makeUniqueSlug($cat->name);
            }
        });
        static::updating(function (Category $cat) {
            if ($cat->isDirty('name') && empty($cat->slug)) {
                $cat->slug = static::makeUniqueSlug($cat->name);
            }
        });
    }

    protected static function makeUniqueSlug(string $name): string
    {
        $base = Str::slug($name ?: 'category');
        $slug = $base ?: 'category';
        $i=1;
        while (static::query()->where('slug',$slug)->exists()) {
            $slug = ($base ?: 'category').'-'.$i++;
        }
        return $slug;
    }

    public function ateliers()
    {
        return $this->belongsToMany(\App\Models\Atelier::class, 'atelier_category');
    }
}
