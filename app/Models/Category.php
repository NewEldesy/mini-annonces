<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import correct de la classe Str

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name); // Utilisation correcte avec l'import
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name); // Mise à jour du slug si le nom change
        });
    }
}