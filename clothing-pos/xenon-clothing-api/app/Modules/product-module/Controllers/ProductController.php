<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Http\DTOs\Response\ResponseDTO;
use App\Platform\Enums\StatusCode;

use Illuminate\Http\Request;
use App\Modules\Product\Services\ProductService;

class ProductController extends Controller
{

    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $response = new ResponseDTO(StatusCode::SUCCESS, 'User API verified successfully.');

        return $response->toJson();
    }

    public function store(Request $request)
    {

        try {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'selling_price' => 'required|numeric',
                'special_note' => 'nullable|string',
                'is_enabled' => 'required|boolean',
                'code' => 'required|string|unique:products,code',
                'batches' => 'nullable|array',
                'sizes' => 'nullable|array',
                'colors' => 'nullable|array',
                'images' => 'nullable|array',
            ]);

            $product = $this->productService->createProduct($validatedData);
            $response = new ResponseDTO(StatusCode::SUCCESS, 'Product added successfully.', $product->toArray());
            return response()->$response;

        } catch (\Exception $e) {
            $response = new ResponseDTO(
                StatusCode::BAD_REQUEST,
                'Failed add Product.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }
}
