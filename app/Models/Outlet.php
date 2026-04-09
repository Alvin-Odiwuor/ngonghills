<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductionRun;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\Sale;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'location',
        'manager_id',
        'phone_extension',
        'opening_time',
        'closing_time',
        'status',
    ];

    protected $casts = [
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }

    public function outletProducts()
    {
        return $this->hasMany(OutletProduct::class, 'outlet_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'outlet_products', 'outlet_id', 'product_id')
            ->withPivot(['price', 'status'])
            ->withTimestamps();
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'outlet_id', 'id');
    }

    public function productionRuns()
    {
        return $this->hasMany(ProductionRun::class, 'outlet_id', 'id');
    }

    public function ingredientPurchases()
    {
        return $this->hasMany(IngredientPurchase::class, 'outlet_id', 'id');
    }

    public function staff()
    {
        return $this->hasMany(User::class, 'outlet_id', 'id');
    }

    public function ingredientStocks()
    {
        return $this->hasMany(OutletIngredientStock::class, 'outlet_id', 'id');
    }
}
