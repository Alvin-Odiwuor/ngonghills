<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

class ProductionRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'product_id',
        'outlet_id',
        'quantity_produced',
        'production_date',
        'batch_number',
        'notes',
        'produced_by',
        'status',
    ];

    protected $casts = [
        'quantity_produced' => 'decimal:3',
        'production_date' => 'date',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'produced_by', 'id');
    }
}
