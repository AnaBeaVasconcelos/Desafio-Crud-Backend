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
        'category_id',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Categories\Categories');
    }
}
