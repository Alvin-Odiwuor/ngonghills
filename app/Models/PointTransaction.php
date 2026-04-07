<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Purchase\Entities\Purchase;

class PointTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'loyalty_account_id',
        'order_id',
        'type',
        'points',
        'description',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function loyaltyAccount()
    {
        return $this->belongsTo(LoyaltyAccount::class, 'loyalty_account_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Purchase::class, 'order_id', 'id');
    }
}
