<?php

use App\Modules\Product\Controllers\ProductController;
use App\Modules\Product\Controllers\SizeGuideController;
use App\Modules\Product\Controllers\CategoryController;
use App\Modules\Product\Controllers\ImageLinkController;


use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return ['message' => 'Product Module Controller'];
});
Route::get('/Product', [ProductController::class, 'index']);

Route::prefix('Product')->group(function () {
    Route::post('/addProduct', [ProductController::class, 'store']);
});


Route::prefix('SizeGuide')->group(function () {
    Route::get('/getAllSizeGuides', [SizeGuideController::class, 'index']);

    Route::post('/addSizeGuide', [SizeGuideController::class, 'store']);

    Route::post('/updateSizeGuide/{id}', [SizeGuideController::class, 'update']);

    Route::delete('/removeSizeGuide/{id}', [SizeGuideController::class, 'destroy']);

    Route::get('/getSizeGuide', [SizeGuideController::class, 'getSizeGuide']);
});

Route::prefix('Category')->group(function () {
    Route::get('/getAllCategories', [CategoryController::class, 'index']);

    Route::post('/createCategory', [CategoryController::class, 'store']);

    Route::post('/updateCategory/{id}', [CategoryController::class, 'update']);

    Route::delete('/getCategoryById/{id}', [CategoryController::class, 'show']);

    Route::delete('/deleteCategory/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('ImageLink')->group(function () {
    Route::get('/getAllImageLinks', [ImageLinkController::class, 'index']);

    Route::post('/addImageLink', [ImageLinkController::class, 'store']);

    Route::post('/updateImageLink/{id}', [ImageLinkController::class, 'update']);

    Route::delete('/getImageLinkById/{id}', [ImageLinkController::class, 'show']);

    Route::delete('/deleteImageLink/{id}', [ImageLinkController::class, 'destroy']);
});