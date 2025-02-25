<?php

namespace App\Http\Controllers;

use App\Services\ProfitReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProfitReportController extends Controller
{

    public function __construct(private ProfitReportService $profitReportService)
    {
    }
    public function generateReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryId = $request->input('category_id');
        $productId = $request->input('product_id');

        $totalProfit = $this->profitReportService->getTotalProfit($startDate, $endDate, $categoryId, $productId);
        $profitByCategory = $this->profitReportService->getProfitByCategory($startDate, $endDate);

        return response()->json([
            'total_profit' => $totalProfit->total_profit ?? 0,
            'total_quantity' => $totalProfit->total_quantity ?? 0,
            'profit_by_category' => $profitByCategory,
        ]);
    }
}
