<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Receipt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['beneficiaries_count'] = Beneficiary::count();
        // $data['benef_day_count'] = Beneficiary::whereHas('receipts', function($q) use($request){
        //     $q->where('due_date', now()->format('Y-m-d'));
        // })->count();
        // $data['receipts_day_count'] = Beneficiary::whereHas('receipts', function($q) use($request){
        //     $q->whereDate('receipt_date', date('Y-m-d'));
        // })->count();
        // $data['not_receipts_day_count'] = Beneficiary::whereHas('receipts', function($q) use($request){
        //     $q->where('due_date', now()->format('Y-m-d'))
        //         ->whereNull('receipt_date');
        // })->count();
        return view('dashboard',$data);
    }

}
