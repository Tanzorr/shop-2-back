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
    public function run(): void
    {
        Order::factory(10)->create()->each(function ($order) {
            OrderItem::factory(rand(1, 100))->create([
                'order_id' => $order->id
            ]);
        });
    }
}
