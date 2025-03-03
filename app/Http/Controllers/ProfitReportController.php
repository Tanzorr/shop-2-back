<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateProfitReportRequest;
use App\Jobs\CalculateAnnualReportJob;
use App\Services\ProfitReportService;
use DateTime;
use Illuminate\Http\JsonResponse;

class ProfitReportController extends Controller
{
    public function __construct(private readonly ProfitReportService $profitReportService) {}

    public function generateTotalReport(GenerateProfitReportRequest $request): JsonResponse
    {
        $paramsData = $request->validated();
        $totalProfit = $this->profitReportService->getTotalProfit($paramsData);

        return response()->json([
            'total_profit' => $totalProfit->total_profit ?? 0,
            'total_quantity' => $totalProfit->total_quantity ?? 0,
            'profit_by_category' => $this->profitReportService->getProfitByCategories($paramsData),
        ]);
    }

    public function getAnnualUsersSpend(
        $userId,
        DateTime $startDate,
        DateTime $endDate,
        ?array $categories = null
    ): void {
        $job = new CalculateAnnualReportJob($userId, new DateTime('2024-01-01'), new DateTime('2024-12-31'), [10, 11, 23]);
        $job->handle($this->profitReportService);
    }
}
