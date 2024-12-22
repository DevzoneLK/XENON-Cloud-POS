<?php

namespace App\Modules\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Product\Services\ProductImageService;
use App\Http\DTOs\Response\ResponseDTO;
use App\Platform\Enums\StatusCode;

class ImageLinkController extends Controller
{
    protected $imageLinkService;

    /**
     * Constructor to initialize the ImageLinkService.
     *
     * @param ProductImageService $imageLinkService
     */
    public function __construct(ProductImageService $imageLinkService)
    {
        $this->imageLinkService = $imageLinkService;
    }

    /**
     * Retrieve all image links.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $imageLinks = $this->imageLinkService->getAllImageLinks();
            return (new ResponseDTO(StatusCode::SUCCESS, 'Image links retrieved successfully.', $imageLinks->toArray()))->toJson();
        } catch (\Exception $e) {
            return (new ResponseDTO(StatusCode::INTERNAL_SERVER_ERROR, 'Failed to retrieve image links.', [], ['error' => $e->getMessage()]))->toJson();
        }
    }

    /**
     * Create a new image link.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url',
        ]);

        try {
            $imageLink = $this->imageLinkService->createImageLink($request->all());
            return (new ResponseDTO(StatusCode::CREATED, 'Image link created successfully.', $imageLink->toArray()))->toJson();
        } catch (\Exception $e) {
            return (new ResponseDTO(StatusCode::INTERNAL_SERVER_ERROR, 'Failed to create image link.', [], ['error' => $e->getMessage()]))->toJson();
        }
    }

    /**
     * Retrieve a specific image link by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $imageLink = $this->imageLinkService->getImageLinkById($id);
            return (new ResponseDTO(StatusCode::SUCCESS, 'Image link retrieved successfully.', $imageLink->toArray()))->toJson();
        } catch (\Exception $e) {
            return (new ResponseDTO(StatusCode::NOT_FOUND, 'Image link not found.', [], ['error' => $e->getMessage()]))->toJson();
        }
    }

    /**
     * Update an existing image link.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'link' => 'sometimes|url',
        ]);

        try {
            $imageLink = $this->imageLinkService->updateImageLink($id, $request->all());
            return (new ResponseDTO(StatusCode::SUCCESS, 'Image link updated successfully.', $imageLink->toArray()))->toJson();
        } catch (\Exception $e) {
            return (new ResponseDTO(StatusCode::INTERNAL_SERVER_ERROR, 'Failed to update image link.', [], ['error' => $e->getMessage()]))->toJson();
        }
    }

    /**
     * Delete an existing image link by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->imageLinkService->deleteImageLink($id);
            return (new ResponseDTO(StatusCode::SUCCESS, 'Image link deleted successfully.'))->toJson();
        } catch (\Exception $e) {
            return (new ResponseDTO(StatusCode::NOT_FOUND, 'Failed to delete image link.', [], ['error' => $e->getMessage()]))->toJson();
        }
    }
}