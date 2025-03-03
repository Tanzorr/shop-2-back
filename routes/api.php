<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EntityMediaController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductExportController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\ProfitReportController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class)->only(['destroy', 'store', 'update']);
    });
    Route::apiResource('users', UserController::class)->only(['index', 'show']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::get('export-products', [ProductExportController::class, 'export']);
    Route::post('import-products', [ProductImportController::class, 'import']);
    Route::get('profit-report', [ProfitReportController::class, 'generateTotalReport']);
    Route::get('annual-user-report/{userId}', [ProfitReportController::class, 'getAnnualUsersSpend']);

    Route::apiResource('orders', OrderController::class);
    Route::apiResource('/medias', MediaController::class);
    Route::prefix('entities/media')->group(function () {
        Route::post('attach', [EntityMediaController::class, 'attach']);
        Route::post('detach', [EntityMediaController::class, 'detach']);
    });
    Route::apiResource('pages', PageController::class);
    Route::apiResource('tags', TagController::class);
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout']);
