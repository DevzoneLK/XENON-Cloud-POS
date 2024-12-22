<?php

namespace App\Modules\Product\Services;

use Illuminate\Support\Collection;
use App\Modules\Product\Models\Category;
use App\Modules\Product\DTOs\CategoryDTO;
use App\Modules\Product\Mappers\CategoryMapper;
use PHPUnit\TestRunner\TestResult\Collector;

class CategoryService
{
    /**
     * Retrieve all categories.
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        $categories = Category::all();
        return $categories->map(function (Category $category) {
            return CategoryMapper::toDTO($category);
        });
    }

    /**
     * Create a new category.
     *
     * @param CategoryDTO $categoryDTO
     * @return Category
     */
    public function createCategory(CategoryDTO $categoryDTO): CategoryDTO
    {
        return CategoryMapper::toDTO(Category::create(CategoryMapper::toModel($categoryDTO)));
    }

    /**
     * Update an existing category.
     *
     * @param int $id
     * @param CategoryDTO $categoryDTO
     * @return Category
     */
    public function updateCategory(int $id, CategoryDTO $categoryDTO): CategoryDTO
    {
        $category = Category::findOrFail($id);

        $category->update(CategoryMapper::toModel($categoryDTO));

        return CategoryMapper::toDTO($category->fresh());
    }

    /**
     * Retrieve a single category by ID.
     *
     * @param int $id
     * @return Category
     */
    public function getCategoryById(int $id): CategoryDTO
    {
        $category = Category::findOrFail($id);
        return CategoryMapper::toDTO($category);
    }

    /**
     * Delete a category by ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteCategory(int $id): void
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}