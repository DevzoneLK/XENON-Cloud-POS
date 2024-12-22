<?php

namespace App\Modules\Product\Mappers;

use App\Modules\Product\DTOs\CategoryDTO;
use App\Modules\Product\Models\Category;

class CategoryMapper
{
    /**
     * Convert Category model to CategoryDTO
     *
     * @param Category $category
     * @return CategoryDTO
     */
    public static function toDTO($category): CategoryDTO
    {
        $categoryData = [
            "id" => $category['id'],
            "name" => $category['name'],
            "is-enabled" => $category["is_enabled"]
        ];

        return new CategoryDTO($categoryData);
    }

    public static function toModel(CategoryDTO $categoryDTO)
    {
        return [
            'name' => $categoryDTO->getName(),
            'is_enabled' => $categoryDTO->isEnabled()
        ];
    }
}
