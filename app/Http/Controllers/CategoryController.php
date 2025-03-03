<?php

namespace App\Http\Controllers;

use App\Actions\GetCategoryAction;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Queries\GetQuery;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(GetCategoryAction $getCategoryAction): JsonResponse
    {
        return response()->json($getCategoryAction->handle(new GetQuery(['search' => request('search')])));
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        Category::create($request->validated());

        return response()->json(['message' => 'Category created successfully'], 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return response()->json(['message' => 'Category updated successfully']);
    }

    public function destroy(Category $category): JsonResponse
    {
        return response()->json(null, $category->delete() ? 200 : 404);
    }
}
