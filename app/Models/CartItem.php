<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'product_id',
        'session_id',
        'quantity',
        'price',
        'name',
        'options'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Get the product that belongs to this cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate the total price for this cart item.
     */
    public function getTotalPrice()
    {
        return $this->price * $this->quantity;
    }
}
