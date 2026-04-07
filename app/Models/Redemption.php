<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'loyalty_account_id',
        'reward_id',
        'points_used',
        'status',
        'redeemed_at',
        'notes',
    ];

    protected $casts = [
        'redeemed_at' => 'datetime',
    ];

    public function loyaltyAccount()
    {
        return $this->belongsTo(LoyaltyAccount::class, 'loyalty_account_id', 'id');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id', 'id');
    }
}
