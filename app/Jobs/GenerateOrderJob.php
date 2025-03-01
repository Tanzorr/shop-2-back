<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class GenerateOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $request = DB::select('SELECT c.name, p.name, month(orders.created_at), sum(oi.quantity) as total
                                    FROM orders
                                             join laravel.order_items oi on orders.id = oi.order_id
                                             join products p on oi.product_id = p.id
                                             join laravel.categories c on p.category_id = c.id
                                             where month(orders.created_at) = 6
                                    group by c.id, p.id, month(orders.created_at)');

        file_put_contents(__DIR__.'/report.json', json_encode($request));
    }
}
