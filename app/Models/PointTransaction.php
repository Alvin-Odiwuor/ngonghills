<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Sale\Entities\Sale;

class PointTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'loyalty_account_id',
        'sale_id',
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

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }
}
