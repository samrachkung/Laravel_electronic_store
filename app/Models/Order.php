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
       'stripe_session_id',
       'khqr_code',
       'khqr_md5',
       'khqr_expires_at'
    ];

    // Use casts property (not $dates - deprecated in Laravel 10+)
    protected $casts = [
        'grand_total' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'khqr_expires_at' => 'datetime',  // This is crucial!
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function isKHQRExpired()
    {
        return $this->khqr_expires_at && now()->isAfter($this->khqr_expires_at);
    }

    public function isKHQRPayment()
    {
        return $this->payment_method === 'khqr';
    }
}
