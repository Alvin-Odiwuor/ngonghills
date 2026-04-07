<?php

namespace Modules\People\Entities;

use App\Models\LoyaltyAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{

    use HasFactory;

    protected $guarded = [];

    protected static function newFactory() {
        return \Modules\People\Database\factories\CustomerFactory::new();
    }

    public function loyaltyAccount() {
        return $this->hasOne(LoyaltyAccount::class, 'customer_id', 'id');
    }

}
