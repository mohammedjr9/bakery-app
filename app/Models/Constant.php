<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'status',
    ];


    public function parent()
    {
        return $this->belongsTo(Constant::class, 'parent_id');
    }


    public function children()
    {
        return $this->hasMany(Constant::class, 'parent_id');
    }


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
