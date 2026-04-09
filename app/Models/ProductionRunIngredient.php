<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionRunIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_run_id',
        'ingredient_id',
        'quantity_used',
        'unit_cost_at_time',
        'total_cost',
    ];

    protected $casts = [
        'quantity_used' => 'decimal:3',
        'unit_cost_at_time' => 'decimal:4',
        'total_cost' => 'decimal:4',
    ];

    public function productionRun()
    {
        return $this->belongsTo(ProductionRun::class, 'production_run_id', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id');
    }
}
