<?php

namespace App\Modules\Product\Services;

use App\Modules\Product\Models\ProductColor;

class ProductColorService
{
    public function getAll()
    {
        // Logic for retrieving all records
    }

    public function create(int $productId, string $colorCode)
    {
        // Logic for creating a record
        ProductColor::create([
            'product_id' => $productId,
            'color_code' => $colorCode,
        ]);
    }

    public function addColors(int $productId, array $colors)
    {
        foreach ($colors as $colorCode) {
            $this->create($productId, $colorCode);
        }
    }

    public function findById(int $id)
    {
        // Logic for retrieving a record by ID
    }

    public function update(int $id, array $data)
    {
        // Logic for updating a record
    }

    public function delete(int $id)
    {
        // Logic for deleting a record
    }
}