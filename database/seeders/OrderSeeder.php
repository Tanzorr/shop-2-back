<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($count): void
    {
        Order::factory($count)->create()->each(function ($order) {
            OrderItem::factory(rand(1, 100))->create([
                'order_id' => $order->id,
            ]);
        });

        $orders = Order::all();

        foreach ($orders as $order) {
            $orderItems = OrderItem::where('order_id', $order->id)->get();
            $orderTotalPrice = 0;

            foreach ($orderItems as $orderItem) {
                $orderTotalPrice += ($orderItem->price * $orderItem->quantity);
            }
            $order->update([
                'total_price' => $orderTotalPrice,
            ]);
        }
    }
}
