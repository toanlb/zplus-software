<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class License extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'order_item_id',
        'user_id',
        'license_key',
        'status',
        'assigned_at',
        'expires_at',
        'activation_limit',
        'activation_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assigned_at' => 'datetime',
        'expires_at' => 'datetime',
        'activation_limit' => 'integer',
        'activation_count' => 'integer',
    ];

    /**
     * Get the product that owns the license.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the order item that owns the license.
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the user that owns the license.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the license is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'assigned' && 
               ($this->expires_at === null || $this->expires_at->isFuture()) &&
               ($this->activation_limit === null || $this->activation_count < $this->activation_limit);
    }

    /**
     * Generate a unique license key.
     */
    public static function generateLicenseKey(): string
    {
        return strtoupper(Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4));
    }
}
