<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
    public function receipts_chech()
    {
        return $this->hasMany(Receipt::class)->whereNotNull('receipt_date');
    }
    public function types_coupons()
    {
        return $this->belongsTo(type_coupons::class, 'type_coupon_id', 'id');
    }

    public function clothing_packages()
{
    return $this->hasMany(ClothingPackage::class);
}


}
