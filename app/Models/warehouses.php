<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class warehouses extends Model
{
protected $fillable = [
    'name',
    'location',
    'type_coupon_id',
    'total_packages',
    'remaining_packages',
];
   public function type_coupon()
{
    return $this->belongsTo(TypeCoupon::class);
}

public function stockMovements()
{
    return $this->hasMany(StockMovement::class, 'warehouse_id');
}

}
