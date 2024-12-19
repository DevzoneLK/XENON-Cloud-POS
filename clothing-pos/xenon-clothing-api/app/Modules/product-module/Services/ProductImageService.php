<?php

namespace App\Modules\Product\Services;
use App\Modules\Product\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductImageService
{
    /**
     * Store a new product image.
     *
     * @param  array  $data
     * @return ProductImage
     */
    public function store(array $data): ProductImage
    {
        return DB::transaction(function () use ($data) {
            ProductImage::create($data);
        });
    }

    public function addImages(int $product_id, array $paths)
    {
        foreach ($paths['images'] as $imagePath) {
            $this->store([
                'product_id' => $product_id,
                'image_path' => $imagePath,
            ]);
        }
    }

    /**
     * Update an existing product image.
     *
     * @param  int  $id
     * @param  array  $data
     * @return ProductImage|null
     */
    public function update(int $id, array $data): ?ProductImage
    {
        $image = ProductImage::find($id);

        if ($image) {
            $image->update($data);
        }

        return $image;
    }

    /**
     * Delete a product image.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return ProductImage::destroy($id) > 0;
    }

    /**
     * Get all images for a specific product.
     *
     * @param  int  $productId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getImagesByProduct(int $productId)
    {
        return ProductImage::where('product_id', $productId)->get();
    }
}