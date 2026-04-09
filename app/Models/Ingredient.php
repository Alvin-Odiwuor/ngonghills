<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'unit',
        'current_stock',
        'reorder_level',
        'cost_per_unit',
        'status',
    ];

    protected $casts = [
        'current_stock' => 'decimal:3',
        'reorder_level' => 'decimal:3',
        'cost_per_unit' => 'decimal:4',
    ];

    public function outletIngredientStocks()
    {
        return $this->hasMany(OutletIngredientStock::class, 'ingredient_id', 'id');
    }
}
