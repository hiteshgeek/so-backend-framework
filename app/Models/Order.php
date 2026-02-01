<?php

namespace App\Models;

use Core\Model\Model;
use Core\Model\Traits\HasStatusField;

/**
 * Order Model - Example demonstrating HasStatusField trait
 *
 * This model demonstrates how to use the HasStatusField trait
 * with integer-based status fields that have non-standard naming.
 *
 * Example table structure:
 * - order_id: Primary key
 * - customer_id: Foreign key to customers
 * - total_amount: Order total
 * - order_status_id: Status field (osid)
 *   - 1 = Pending
 *   - 2 = Processing
 *   - 3 = Shipped
 *   - 4 = Delivered
 *   - 5 = Cancelled
 *   - 6 = Refunded
 */
class Order extends Model
{
    use HasStatusField;

    // ============================================
    // TABLE CONFIGURATION
    // ============================================

    protected static string $table = 'orders';
    protected static string $primaryKey = 'order_id';

    // ============================================
    // MASS ASSIGNMENT PROTECTION
    // ============================================

    protected array $fillable = [
        'order_id',
        'customer_id',
        'total_amount',
        'order_status_id',  // Status field
        'payment_method',
        'shipping_address',
        'notes',
    ];

    // ============================================
    // STATUS FIELD CONFIGURATION (HasStatusField trait)
    // ============================================

    /**
     * The status field column name (non-standard naming)
     */
    protected string $statusField = 'order_status_id';

    /**
     * Active status values (orders in progress)
     * 1 = Pending
     * 2 = Processing
     * 3 = Shipped
     * 4 = Delivered
     */
    protected array $activeStatusValues = [1, 2, 3, 4];

    /**
     * Inactive status values (completed/cancelled orders)
     * 5 = Cancelled
     * 6 = Refunded
     */
    protected array $inactiveStatusValues = [5, 6];

    /**
     * Don't auto-filter inactive orders (we want to see all orders by default)
     */
    protected bool $autoFilterInactive = false;

    // ============================================
    // CUSTOM STATUS NAMES
    // ============================================

    /**
     * Override to provide custom status labels
     */
    public function getStatusName(): string
    {
        return match ($this->getStatusValue()) {
            1 => 'Pending',
            2 => 'Processing',
            3 => 'Shipped',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Refunded',
            default => 'Unknown',
        };
    }

    // ============================================
    // CUSTOM QUERY SCOPES (in addition to trait scopes)
    // ============================================

    /**
     * Scope to get orders pending shipment
     */
    public function scopePendingShipment($query)
    {
        return $query->withStatus([1, 2]); // Pending or Processing
    }

    /**
     * Scope to get shipped orders
     */
    public function scopeShipped($query)
    {
        return $query->withStatus([3, 4]); // Shipped or Delivered
    }

    /**
     * Scope to get completed orders (successfully delivered)
     */
    public function scopeCompleted($query)
    {
        return $query->withStatus(4); // Delivered
    }

    /**
     * Scope to get cancelled orders
     */
    public function scopeCancelled($query)
    {
        return $query->withStatus([5, 6]); // Cancelled or Refunded
    }
}
