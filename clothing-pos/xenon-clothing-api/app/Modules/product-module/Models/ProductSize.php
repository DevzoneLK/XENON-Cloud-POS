<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'product_sizes';

    protected $fillable = [
        'product_id',
        'size_guide_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function sizeGuide()
    {
        return $this->belongsTo(SizeGuide::class, 'size_guide_id');
    }
}