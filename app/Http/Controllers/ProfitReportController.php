<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfitReportController extends Controller
{
    public function generateReport(Request $request): JsonResponse
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $profitReport = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('order_items.created_at', [$startDate, $endDate])
            ->selectRaw('SUM((order_items.price - products.purchase_price) * order_items.quantity) as total_profit')
            ->first();

        return response()->json([
            'profit' => $profitReport,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}
