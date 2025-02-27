<?php

namespace App\Services;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ProfitReportService
{
    public function getTotalProfit(array $dataParams)
    {
        $query = OrderItem::selectRaw('SUM((order_items.price - products.purchase_price) * order_items.quantity) as total_profit')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id');

        if ($dataParams['start_date'] && $dataParams['end_date']) {
            $query->whereBetween('order_items.created_at', [$dataParams['start_date'], $dataParams['end_date']]);
        }

        if ($dataParams['category_id']) {
            $query->where('products.category_id', $dataParams['category_id']);
        }

        if ($dataParams['product_id']) {
            $query->where('order_items.product_id', $dataParams['product_id']);
        }

        $query->where('orders.payment_status', 'paid');

        return $query->first();
    }

    public function getProfitByCategories(array $dataParams)
    {
        $query =  OrderItem::select(
            'categories.id as category_id',
            'categories.name as category_name',
            DB::raw('SUM((order_items.price - products.purchase_price) * order_items.quantity) as category_profit')
        )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        if($dataParams['start_date'] && $dataParams['end_date'] ){
            $query->whereBetween('order_items.created_at', [$dataParams['start_date'], $dataParams['end_date']]);
        }

        return $query->all();
    }
}
