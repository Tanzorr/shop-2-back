<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::paginate(20));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        return response()->json(Product::create($request->validated()));
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        return response()->json($product->update($request->validated()));
    }

    public function destroy(Product $product): JsonResponse
    {
        return response()->json(null, $product->delete() ? 200 : 404);
    }
}
