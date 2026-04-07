<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\People\Entities\Customer;

class LoyaltyAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'points_balance',
        'total_points_earned',
        'total_points_redeemed',
        'tier',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
