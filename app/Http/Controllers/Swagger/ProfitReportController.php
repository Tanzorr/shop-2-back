<?php

namespace App\Http\Controllers\Swagger;

class ProfitReportController
{
    /**
     *
     * @OA\Get(
     *     path="/api/profit-report",
     *     tags={"Profit report"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profit report",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="profit", type="integer"),
     *                 @OA\Property(property="total_profit", type="number"),
     *                 @OA\Property(property="total_quantity", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function generateReport()
    {}
}
