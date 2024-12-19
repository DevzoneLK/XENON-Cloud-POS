<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = 'product_colors';


    protected $fillable = [
        'product_id',
        'color_code',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}