<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'otp',
        'type',
        'expires_at',
        'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    public function scopeValid($query, $email, $type)
    {
        return $query->where('email', $email)
                    ->where('type', $type)
                    ->where('is_used', false)
                    ->where('expires_at', '>', now());
    }

    public function markAsUsed()
    {
        $this->update(['is_used' => true]);
    }
}
