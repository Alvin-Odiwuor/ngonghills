<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
}
