<?php

namespace App\Services;

use App\Domain\Order\OrderPaymentConfirmed;
use App\Domain\Order\OrderStatus;
use App\Events\OrderPaid;
use App\Models\Order;

readonly class OrderApplicationService
{
    public function markAsPaid(int $orderId): Order
    {
        $order = Order::findOrFail($orderId);

        $current = OrderStatus::from($order->payment_status);

        if (! $current->canTransitionTo(OrderStatus::Paid)) {
            throw new \DomainException(
                "Order #{$orderId} cannot transition from {$current->value} to paid."
            );
        }

        $order->payment_status = OrderStatus::Paid->value;
        $order->save();

        $domainEvent = new OrderPaymentConfirmed(
            orderId:               $order->id,
            userId:                $order->user_id,
            reservationExternalId: $order->reservation_id ?? '',
            totalPrice:            (float) $order->total_price,
            occurredAt:            new \DateTimeImmutable(),
        );

        event(new OrderPaid($domainEvent));

        return $order;
    }
}
