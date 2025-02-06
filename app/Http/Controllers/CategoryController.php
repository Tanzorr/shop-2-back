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

        return response()->json(['message' => 'Vault created successfully'], 201);
    }
    public function show(Category $vault): JsonResponse
    {
        return response()->json($vault->load(['passwords', 'sharedAccess', 'accessedUsers']));
    }

    public function update(UpdateCategoryRequest $request, Category $vault): JsonResponse
    {
        $vault->update($request->validated());

        return response()->json(['message' => 'Vault updated successfully']);
    }

    public function destroy(Category $vault): JsonResponse
    {
        return response()->json(null, $vault->delete() ? 200 : 404);
    }
}
