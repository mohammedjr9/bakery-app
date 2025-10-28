<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleBtn extends Model
{
    use HasFactory;
     protected $guarded = [];
    public function FollowToPage()
    {
        return $this->hasOne(RolePage::class,'id', 'follow_to_page');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_btn_user');
    }
    public function scopeByUser(Builder $query,$user_id)
    {
        $query->whereHas('users',function($q) use ($user_id){
            $q->where('users.id',$user_id);
        });
    }
}
