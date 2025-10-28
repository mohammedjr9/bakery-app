<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
  protected $fillable = [
        'warehouse_id',
        'type_coupon_id',
        'type',
        'original_quantity',
        'quantity',
        'recipient',
        'batch_number',
        'production_date',
        'expiry_date',
        'notes',
    ];

    public function warehouse()
    {
        return $this->belongsTo(warehouses::class);
    }

    public function typeCoupon()
    {
        return $this->belongsTo(TypeCoupon::class, 'type_coupon_id');
    }
}
