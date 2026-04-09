<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientStockAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'outlet_id',
        'adjustment_type',
        'quantity',
        'reason',
        'reference_id',
        'reference_type',
        'notes',
        'adjusted_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'adjusted_by', 'id');
    }

    public function reference()
    {
        return $this->morphTo();
    }
}
