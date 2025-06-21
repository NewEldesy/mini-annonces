<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use SoftDeletes;
    
    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'string',
        'deleted_at' => 'datetime'
    ];
}