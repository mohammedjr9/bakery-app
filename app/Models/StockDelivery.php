<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDelivery extends Model
{
      protected $fillable = ['stock_movement_id', 'delivered_quantity', 'notes'];

    public function stockMovement()
    {
        return $this->belongsTo(StockMovement::class);
    }
}
