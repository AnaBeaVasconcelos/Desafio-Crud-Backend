<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'is_active',
    ];
}
