<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    use HasFactory;
    protected $table = 'products';


    protected $fillable = [
        'name',
        'description',
        'selling_price',
        'special_note',
        'is_enabled',
        'code',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the product batches for the product.
     */
    public function batches()
    {
        return $this->hasMany(ProductBatch::class, 'product_id');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
