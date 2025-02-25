<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {}
    public function index(ProductFilterRequest $request): JsonResponse
    {
        $products = Product::query()
            ->search($request->input('search'))
            ->filterByCategory($request->input('category_id'))
            ->filterByTags($request->input('tag_ids', []))
            ->paginate(10);

        return response()->json($products);
    }

    /**
     * @throws \Exception
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        return response()->json($this->productService->storeProduct($request->validated())->load('tags'));
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product->load('tags'));
    }

    /**
     * @throws \Exception
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        return response()->json($this->productService->updateProduct($product, $request->validated())->load('tags') );
    }

    public function destroy(Product $product): JsonResponse
    {
        return response()->json(null, $product->delete() ? 200 : 404);
    }
}
