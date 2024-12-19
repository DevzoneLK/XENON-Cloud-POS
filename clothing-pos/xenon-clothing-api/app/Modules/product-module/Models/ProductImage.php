<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'image_link';

    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}