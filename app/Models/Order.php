<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_id',
       'grand_total',
       'payment_method',
       'payment_status',
       'status',
       'currency',
       'shipping_amount',
       'shipping_method',
       'expected_arrival',
       'notes',
       'stripe_session_id' // ADD THIS
    ];

    protected $casts = [
        'grand_total' => 'decimal:2', // Changed from total_amount to grand_total
        'shipping_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Change this from items() to orderItems() to match your OrderItem model
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    // Status helpers
    public function isNew()
    {
        return $this->status === 'new';
    }

    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    public function isShipped()
    {
        return $this->status === 'shipped';
    }

    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    public function isCanceled()
    {
        return $this->status === 'canceled';
    }

    // Payment status helper
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function isRefunded()
    {
        return $this->payment_status === 'refunded';
    }
}
