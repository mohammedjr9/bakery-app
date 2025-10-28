<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePage extends Model
{
    use HasFactory;
     protected $guarded = [];
    public function follow_to()
    {
        return $this->hasOne(RolePage::class,'id', 'follow_to_id');
    }
    public function getFollowNameAttribute()
    {
        return $this->follow_to->name ?? '';
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_page_user');
    }
    public function buttons()
    {
        return $this->hasMany(RoleBtn::class, 'follow_to_page');
    }
    public function scopeByUser(Builder $query,$user_id)
    {
        $query->whereHas('users',function($q) use ($user_id){
            $q->where('users.id',$user_id);
        });
    }


}
