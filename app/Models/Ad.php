<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'status',
        'user_id',
        'category_id'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        $searchTerm = '%' . strtolower($search) . '%';
        
        return $query->where(function($query) use ($searchTerm) {
            $query->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                  ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['category'] ?? false, fn($query, $category) =>
            $query->whereHas('category', fn($query) =>
                $query->where('id', $category)
            )
        );

        $query->when($filters['min_price'] ?? false, fn($query, $minPrice) =>
            $query->where('price', '>=', $minPrice)
        );

        $query->when($filters['max_price'] ?? false, fn($query, $maxPrice) =>
            $query->where('price', '<=', $maxPrice)
        );
    }
}