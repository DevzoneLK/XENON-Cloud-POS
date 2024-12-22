<?php

namespace App\Modules\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Platform\Enums\StatusCode;
use App\Modules\Product\DTOs\CategoryDTO;
use App\Http\DTOs\Response\ResponseDTO;
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
            $categoryDTOs = $this->categoryService->getAllCategories();

            $categories = $categoryDTOs->map(function (CategoryDTO $categoryDTO): array {
                return $categoryDTO->toJsonResponse();
            });

            return $this->handleSuccessResponse($categories->toArray(), 'Categories retrieved successfully.');
        } catch (\Exception $exception) {
            return $this->handleFailedResponse($exception);
        }
    }

    // Store a new category
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|unique:category,name',
                'is-enabled' => 'boolean',
            ]);

            $categoryDTO = new CategoryDTO($validatedData);

            $categoryResponseDTO = $this->categoryService->createCategory($categoryDTO);

            return $this->handleSuccessResponse($categoryResponseDTO->toJsonResponse(), 'Category created successfully.', StatusCode::CREATED);
        } catch (\Exception $exception) {
            return $this->handleFailedResponse($exception, 'Failed to create category.');
        }
    }

    // Update a category
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'string|unique:category,name,' . $id,
                'is-enabled' => 'boolean',
            ]);

            $categoryDTO = new CategoryDTO($validatedData);

            $categoryResponseDTO = $this->categoryService->updateCategory($id, $categoryDTO);

            return $this->handleSuccessResponse($categoryResponseDTO->toJsonResponse(), 'Category updated successfully.');

        } catch (\Exception $exception) {
            return $this->handleFailedResponse($exception, 'Failed to update category.');

        }
    }

    // Show a specific category
    public function show($id)
    {
        try {
            $categoryResponseDTO = $this->categoryService->getCategoryById($id);

            return $this->handleSuccessResponse($$categoryResponseDTO->toJsonResponse(), 'Category retrieved successfully.');
        } catch (\Exception $exception) {
            return $this->handleFailedResponse($exception, 'Category not found.');
        }
    }

    // Delete a category
    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return $this->handleSuccessResponse([], 'Category deleted successfully.');
        } catch (\Exception $exception) {
            return $this->handleFailedResponse($exception, 'Failed to delete category.');
        }
    }
}