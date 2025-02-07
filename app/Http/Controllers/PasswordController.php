<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Endpoint;

class PasswordController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::paginate(20));
    }

    public function store(StorePasswordRequest $request): JsonResponse
    {
        return response()->json(Product::create($request->validated()));
    }

    public function show(Product $password): JsonResponse
    {
        return response()->json($password);
    }

    public function update(UpdatePasswordRequest $request, Product $password): JsonResponse
    {
        return response()->json($password->update($request->validated()));
    }

    public function destroy(Product $password): JsonResponse
    {
        return response()->json(null, $password->delete() ? 200 : 404);
    }
}
