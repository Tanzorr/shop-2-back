<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{

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
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return response()->json([
            'message' => 'Page created successfully',
            'user' => Page::create(array_merge(
                $validated,
                ['author_id' => auth()->id()]
            )),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page): JsonResponse
    {
        return response()->json($page);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page): JsonResponse
    {
        $validated = $request->validated();

        return response()->json([
            'message' => 'Page updated successfully',
            'user' => $page->update($validated), 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): JsonResponse
    {
        return response()->json(null, $page->delete() ? 200 : 404);
    }
}
