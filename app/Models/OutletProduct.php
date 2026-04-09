<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

class OutletProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'product_id',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:4',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
