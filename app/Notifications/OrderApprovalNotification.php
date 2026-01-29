<?php

namespace App\Notifications;

use Core\Notifications\Notification;

/**
 * Order Approval Notification
 *
 * Notification sent when an order requires approval
 * Example of ERP workflow notification
 */
class OrderApprovalNotification extends Notification
{
    protected int $orderId;
    protected string $orderNumber;
    protected float $amount;

    public function __construct(int $orderId, string $orderNumber, float $amount)
    {
        $this->orderId = $orderId;
        $this->orderNumber = $orderNumber;
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels
     */
    public function via(): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification
     */
    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Order Requires Approval',
            'message' => "Order #{$this->orderNumber} for $" . number_format($this->amount, 2) . " requires your approval.",
            'action_url' => '/orders/' . $this->orderId . '/approve',
            'action_text' => 'Review Order',
            'type' => 'approval_required',
            'order_id' => $this->orderId,
            'order_number' => $this->orderNumber,
            'amount' => $this->amount,
            'priority' => 'high',
        ];
    }
}
