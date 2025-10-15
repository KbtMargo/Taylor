<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Atelier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'city',
        'address',
        'email',
        'phone',
        'tags',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::creating(function (Atelier $atelier) {
            if (empty($atelier->slug)) {
                $atelier->slug = static::createUniqueSlug($atelier->name);
            }
        });
    }

    protected static function createUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'LIKE', "{$slug}%")->count();
        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }
}