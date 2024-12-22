<?php

namespace App\Modules\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Product\Models\SizeGuide;
use App\Http\DTOs\Response\ResponseDTO;
use App\Platform\Enums\StatusCode;

class SizeGuideController extends Controller
{
    /**
     * Display a listing of the size guides.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Fetch all size guides from the database
            $sizeGuides = SizeGuide::all();

            // Return success response with data
            $response = new ResponseDTO(
                StatusCode::SUCCESS,
                'Size guides fetched successfully.',
                ['size_guides' => $sizeGuides]
            );

            return $response->toJson();
        } catch (\Exception $e) {
            // Return error response if fetching fails
            $response = new ResponseDTO(
                StatusCode::BAD_REQUEST,
                'Failed to fetch size guides.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }

    /**
     * Display a listing of sorted size guides under given parameters.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSizeGuide(Request $request)
    {
        try {
            // Validate input parameters
            $request->validate([
                'category' => 'required|string',
                'size' => 'required|string',
            ]);

            // Fetch matching records
            $sizeGuide = SizeGuide::where('category', $request->category)
                ->where('size', $request->size)
                ->get();

            // If no data found
            if ($sizeGuide->isEmpty()) {
                $response = new ResponseDTO(
                    StatusCode::NOT_FOUND,
                    'No size guide found for the given criteria.',
                    []
                );
            } else {
                // Return success response with data
                $response = new ResponseDTO(
                    StatusCode::SUCCESS,
                    'Size guide fetched successfully.',
                    $sizeGuide->toArray()
                );
            }

            return $response->toJson();

        } catch (\Exception $e) {
            // Handle error and return a structured error response
            $response = new ResponseDTO(
                StatusCode::BAD_REQUEST,
                'Failed to fetch size guide.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }

    /**
     * Store a newly created size guide in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'category' => 'required|string|max:255',
                'size' => 'required|string|max:255',
                'value' => 'required|string|max:255',
            ]);

            // Create a new size guide record
            $sizeGuide = SizeGuide::create($validatedData);

            // Return success response with the created size guide
            $response = new ResponseDTO(
                StatusCode::SUCCESS,
                'Size guide created successfully.',
                ['size_guide' => $sizeGuide]
            );

            return $response->toJson();
        } catch (\Exception $e) {
            // Return error response if creation fails
            $response = new ResponseDTO(
                StatusCode::BAD_REQUEST,
                'Failed to create size guide.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }

    /**
     * Update the specified size guide in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'category' => 'nullable|string|max:255',
                'size' => 'nullable|string|max:255',
                'value' => 'nullable|string|max:255',
            ]);

            // Find the size guide by ID or throw a 404 error
            $sizeGuide = SizeGuide::findOrFail($id);

            // Update the size guide with validated data
            $sizeGuide->update($validatedData);

            // Return success response with updated size guide
            $response = new ResponseDTO(
                StatusCode::SUCCESS,
                'Size guide updated successfully.',
                ['size_guide' => $sizeGuide]
            );

            return $response->toJson();
        } catch (\Exception $e) {
            // Return error response if update fails
            $response = new ResponseDTO(
                StatusCode::BAD_REQUEST,
                'Failed to update size guide.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }

    /**
     * Remove the specified size guide from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Find the size guide by ID or throw a 404 error
            $sizeGuide = SizeGuide::findOrFail($id);

            // Delete the size guide
            $sizeGuide->delete();

            // Return success response
            $response = new ResponseDTO(
                StatusCode::SUCCESS,
                'Size guide deleted successfully.'
            );

            return $response->toJson();
        } catch (\Exception $e) {
            // Return error response if deletion fails
            $response = new ResponseDTO(
                StatusCode::BAD_REQUEST,
                'Failed to delete size guide.',
                [],
                ['error' => $e->getMessage()]
            );

            return $response->toJson();
        }
    }
}