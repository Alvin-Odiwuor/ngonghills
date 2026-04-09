<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletIngredientStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'ingredient_id',
        'current_stock',
    ];

    protected $casts = [
        'current_stock' => 'decimal:3',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id');
    }
}
