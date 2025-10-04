<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug'];

    public function ateliers(){ return $this->belongsToMany(\App\Models\Atelier::class, 'atelier_category'); }
}
