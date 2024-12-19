<?php

namespace App\Modules\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\DTOs\Response\ResponseDTO;
use App\Utility\Enums\StatusCode;

use App\Modules\Product\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // Fetch all categories
    public function index()
    {
        try {
            $categories = $this->categoryService->getAllCategories();

            $response = new ResponseDTO(
                StatusCode::SUCCESS,
                'Categories retrieved successfully.',
                $categories->toArray()
            );

            return $response->toJson();
        } catch (\Exception $e) {
            $response = new ResponseDTO(
                StatusCode::INTERNAL_SERVER_ERROR,
                'Failed to retrieve categories.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }

    // Store a new category
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:category,name',
                'is_enabled' => 'boolean',
            ]);

            $category = $this->categoryService->createCategory($request->only(['name', 'is_enabled']));

            $response = new ResponseDTO(
                StatusCode::CREATED,
                'Category created successfully.',
                $category->toArray()
            );

            return $response->toJson();
        } catch (\Exception $e) {
            $response = new ResponseDTO(
                StatusCode::BAD_REQUEST,
                'Failed to create category.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }

    // Update a category
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string|unique:category,name,' . $id,
                'is_enabled' => 'boolean',
            ]);

            $category = $this->categoryService->updateCategory($id, $request->only(['name', 'is_enabled']));

            $response = new ResponseDTO(
                StatusCode::SUCCESS,
                'Category updated successfully.',
                $category->toArray()
            );

            return $response->toJson();
        } catch (\Exception $e) {
            $response = new ResponseDTO(
                StatusCode::BAD_REQUEST,
                'Failed to update category.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }

    // Show a specific category
    public function show($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);

            $response = new ResponseDTO(
                StatusCode::SUCCESS,
                'Category retrieved successfully.',
                $category->toArray()
            );

            return $response->toJson();
        } catch (\Exception $e) {
            $response = new ResponseDTO(
                StatusCode::NOT_FOUND,
                'Category not found.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }

    // Delete a category
    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);

            $response = new ResponseDTO(
                StatusCode::SUCCESS,
                'Category deleted successfully.'
            );

            return $response->toJson();
        } catch (\Exception $e) {
            $response = new ResponseDTO(
                StatusCode::BAD_REQUEST,
                'Failed to delete category.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }
}