<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ClothingPackage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }
    public function distributionPlace()
    {
        return $this->belongsTo(Constant::class, 'distribution_place_id');
    }
    public function project()
{
    return $this->belongsTo(Constant::class, 'project_id');
}

}
