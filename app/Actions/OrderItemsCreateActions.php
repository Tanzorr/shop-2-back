<?php

namespace App\Actions;

use App\Contracts\MutationActionInterface;
use App\Models\OrderItem;

class OrderItemsCreateActions implements MutationActionInterface
{
    public function handle(array $data): mixed
    {
        try {
            foreach ($data['items'] as $item) {
                OrderItem::create([
                    'order_id' => $data['order_id'],
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }
}
