<?php

namespace App\Http\Controllers\Swagger;

class PasswordController
{
    /**
     * @OA\Get(
     *     path="/api/passwords",
     *     tags={"Passwords"},
     *     summary="Get a list of passwords for a specific vault",
     *     security={{"bearerAuth": {}}},
     *     operationId="getPasswords",
     *
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of passwords",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */
    public function index() {}

    /**
     * @OA\Post(
     *     path="/api/passwords",
     *     tags={"Passwords"},
     *     summary="Create a new password",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(ref="#/components/schemas/StorePasswordRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Product created successfully")
     *         )
     *     )
     * )
     */
    public function store() {}

    /**
     * @OA\Get(
     *     path="/api/passwords/{password}",
     *     tags={"Passwords"},
     *     security={{"bearerAuth": {}}},
     *     summary="Get details of a specific password",
     *
     *     @OA\Parameter(
     *         name="password",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Product details",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function show() {}

    /**
     * @OA\Put(
     *     path="/api/passwords/{password}",
     *     tags={"Passwords"},
     *     summary="Update a password",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="password",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Product updated successfully")
     *         )
     *     )
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/passwords/{password}",
     *     tags={"Passwords"},
     *     summary="Delete a password",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="password",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Product deleted successfully")
     *         )
     *     )
     * )
     */
    public function destroy() {}
}
