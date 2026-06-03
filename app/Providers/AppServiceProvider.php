<?php

namespace App\Providers;

use App\Contracts\MediaServiceInterface;
use App\Events\OrderPaid;
use App\Listeners\DispatchWarehouseNotification;
use App\Models\Order;
use App\Observers\OrderObserver;
use App\Services\MediaService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            MediaServiceInterface::class,
            MediaService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);

        Event::listen(OrderPaid::class, DispatchWarehouseNotification::class);
    }
}
