<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductBatch extends Model
{
    use HasFactory;

    protected $table = 'product_batches';
    protected $fillable = [
        'product_id',
        'added_date',
        'quantity',
        'buying_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}