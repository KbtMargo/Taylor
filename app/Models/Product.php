<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'category_id','name','slug','description','price_per_m','stock_m',
        'color','width_cm','material','sku','is_active'
    ];

    public function getRouteKeyName(): string { return 'slug'; }

    protected static function booted()
    {
        static::creating(function (Product $p) {
            if (empty($p->slug)) {
                $p->slug = static::makeUniqueSlug($p->name);
            }
        });
    }

    protected static function makeUniqueSlug(string $name): string
    {
        $base = Str::slug($name ?: 'product');
        $slug = $base ?: 'product';
        $i=1;
        while (static::query()->where('slug',$slug)->exists()) {
            $slug = ($base ?: 'product').'-'.$i++;
        }
        return $slug;
    }

    public function category(){ return $this->belongsTo(Category::class, 'category_id', 'category_id'); }
    public function images(){ return $this->hasMany(ProductImage::class, 'product_id', 'product_id')->orderBy('sort_order'); }

    public function getFirstImageUrlAttribute()
    {
        return optional($this->images->first())->url ?? '/images/placeholder.jpg';
    }
}
