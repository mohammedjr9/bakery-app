<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Receipt extends Model
{
    use HasFactory;
    protected $guarded = [];

    const day_name = [
        "Saturday" => "السبت",
        "Sunday" => "الأحد",
        "Monday" => "الاثنين",
        "Tuesday" => "الثلاثاء",
        "Wednesday" => "الأربعاء",
        "Thursday" => "الخميس",
        "Friday" => "الجمعة"
    ];
    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function getDayAttribute()
    {
        return self::day_name[Carbon::parse($this->due_date)->Format('l')];
        // return Carbon::parse($this->due_date)->Format('l');
    }
    public function scopeCheck(Builder $query)
    {
        $query->where('due_date', now()->format('Y-m-d'));
    }
    public function scopeNotChecked(Builder $query)
    {
        $query->whereNull('receipt_date');
    }
    public function scopeChecked(Builder $query)
    {
        $query->whereNotNull('receipt_date');
    }
}
