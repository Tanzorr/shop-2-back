<?php

namespace App\Services;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProfitReportService
{
    public function getTotalProfit($startDate, $endDate, $categoryId = null, $productId = null)
    {
        $query = OrderItem::selectRaw('SUM((order_items.price - products.purchase_price) * order_items.quantity) as total_profit')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('order_items.created_at', [$startDate, $endDate]);

        if ($categoryId) {
            $query->where('products.category_id', $categoryId);
        }

        if ($productId) {
            $query->where('order_items.product_id', $productId);
        }

        return $query->first();
    }

    public function getProfitByCategory($startDate, $endDate): Collection
    {
        return OrderItem::select(
            'categories.id as category_id',
            'categories.name as category_name',
            DB::raw('SUM((order_items.price - products.purchase_price) * order_items.quantity) as category_profit')
        )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('order_items.created_at', [$startDate, $endDate])
            ->groupBy('categories.id', 'categories.name')
            ->get();
    }
}
