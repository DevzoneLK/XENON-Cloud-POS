<?php

namespace App\Modules\Product\Services;

use App\Modules\Product\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected $batchService;
    protected $sizeService;
    protected $colorService;
    protected $productImageService;

    /**
     * Inject ProductSizeService via dependency injection.
     *
     * @param  \App\Modules\Product\Services\ProductSizeService  $productSizeService
     */
    public function __construct(
        ProductBatchService $batchService,
        ProductSizeService $sizeService,
        ProductColorService $colorService,
        ProductImageService $productImageService
    ) {
        $this->batchService = $batchService;
        $this->sizeService = $sizeService;
        $this->colorService = $colorService;
        $this->productImageService = $productImageService;
    }


    /**
     * Create a new product and associate it with size guides.
     * 
     * @param  array  $data
     * @return \App\Modules\Product\Models\Product
     */
    public function createProduct(array $data)
    {
        // $product = Product::create($data);

        // if (isset($data['batches'])) {
        //     $this->batchService->addBatches($product->id, $data['batches']);
        // }

        // if (isset($data['sizes'])) {
        //     $this->sizeService->addSizes($product->id, $data['sizes']);
        // }

        // if (isset($data['colors'])) {
        //     $this->colorService->addColors($product->id, $data['colors']);
        // }

        // if (isset($data['images'])) {
        //     $this->productImageService->addImages($product->id, $data['images']);
        // }

        return $this->createProductTransaction($data);
    }

    private function createProductTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Step 1: Create the main product record
            $product = Product::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'selling_price' => $data['selling_price'],
                'special_note' => $data['special_note'] ?? null,
                'is_enabled' => $data['is_enabled'],
                'code' => $data['code']
            ]);

            // Step 2: Add product batches (if any)
            if (!empty($data['batches'])) {
                $this->batchService->addBatches($product->id, $data['batches']);
                // foreach ($data['batches'] as $batch) {
                //     ProductBatch::create([
                //         'product_id' => $product->id,
                //         'added_date' => $batch['added_date'],
                //         'quantity' => $batch['quantity'],
                //         'buying_price' => $batch['buying_price'],
                //     ]);
                // }
            }

            // Step 3: Add product sizes (if any)
            if (!empty($data['sizes'])) {
                $this->sizeService->addSizes($product->id, $data['sizes']);
                // foreach ($data['sizes'] as $size) {
                //     ProductSize::create([
                //         'product_id' => $product->id,
                //         'size_guide_id' => $size // Assuming size_guide_id is the ID of the size
                //     ]);
                // }
            }

            // Step 4: Add product colors (if any)
            if (!empty($data['colors'])) {
                $this->colorService->addColors($product->id, $data['colors']);
                // foreach ($data['colors'] as $color) {
                //     ProductColor::create([
                //         'product_id' => $product->id,
                //         'color_code' => $color
                //     ]);
                // }
            }

            // Step 5: Add product images (if any)
            if (!empty($data['images'])) {
                $this->productImageService->addImages($product->id, $data['images']);
                // foreach ($data['images'] as $image) {
                //     ProductImage::create([
                //         'product_id' => $product->id,
                //         'image_path' => $image
                //     ]);
                // }
            }

            // If everything succeeds, commit the transaction and return the product
            return $product;
        });
    }
}
