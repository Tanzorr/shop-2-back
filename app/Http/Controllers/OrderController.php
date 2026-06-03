<?php

namespace App\Http\Controllers;

use App\Actions\OrderItemsCreateAction;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderApplicationService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Order::with('items')->get());
    }

    public function store(StoreOrderRequest $request, OrderItemsCreateAction $actions): JsonResponse
    {
        $order = Order::create($request->validated());

        $actions->handle([
            'order_id' => $order->id,
            'items' => $request->items,
        ]);

        return response()->json($order->load('items'), 201);
    }

    public function show(Order $order): JsonResponse
    {
        return response()->json($order->load('items'));
    }

    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $order->update($request->validated());

        return response()->json($order);
    }

    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }

    public function pay(int $order, OrderApplicationService $service): JsonResponse
    {
        try {
            $order = $service->markAsPaid($order);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'Payment accepted', 'order' => $order], 202);
    }
}
