<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'price',
        'product_description',
        'product_image',
        'manufacturer',
        'jan_code',
        'category',
        'tags',
        'remarks',
        'store_id',
        'public_flg',
        'is_deleted',
        'created_by',
        'updated_by',
    ];
}
