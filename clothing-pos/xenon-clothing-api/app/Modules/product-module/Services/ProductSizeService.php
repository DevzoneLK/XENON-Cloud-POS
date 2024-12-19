<?php

namespace App\Modules\Product\Services;


use App\Modules\Product\Models\ProductSize;
use Illuminate\Support\Facades\DB;

class ProductSizeService
{
    /**
     * Associate a product with multiple sizes in the pivot table.
     * 
     * @param  int    $productId
     * @param  array  $sizeGuideIds
     * @return void
     */
    public function addSizes(int $productId, array $sizes)
    {
        foreach ($sizes as $sizeId) {
            ProductSize::create([
                'product_id' => $productId,
                'size_guide_id' => $sizeId,
            ]);
        }
    }

    /**
     * Remove all sizes associated with a specific product.
     * 
     * @param  int  $productId
     * @return void
     */
    public function detachSizes(int $productId)
    {
        ProductSize::where('product_id', $productId)->delete();
    }

    /**
     * Update the sizes of a product (remove old ones and add new ones).
     * 
     * @param  int    $productId
     * @param  array  $sizeGuideIds
     * @return void
     */
    public function updateSizes(int $productId, array $sizeGuideIds)
    {

    }
}