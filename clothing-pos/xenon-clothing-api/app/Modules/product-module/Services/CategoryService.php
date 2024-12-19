<?php

namespace App\Modules\Product\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Product\Models\Category;

class CategoryService
{
    /**
     * Retrieve all categories.
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update an existing category.
     *
     * @param int $id
     * @param array $data
     * @return Category
     */
    public function updateCategory(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);

        return $category;
    }

    /**
     * Retrieve a single category by ID.
     *
     * @param int $id
     * @return Category
     */
    public function getCategoryById(int $id): Category
    {
        return Category::findOrFail($id);
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