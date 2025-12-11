<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // ✅ ضيف هذا السطر في الأعلى

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ⏱️ بداية القياس
        $start = microtime(true);

        $data['beneficiaries_count'] = Beneficiary::count();

        // ⏱️ نهاية القياس
        $end = microtime(true);
        $executionTime = $end - $start;

        // 🧾 سجل الوقت في ملف اللوج
        Log::info("⏱️ Dashboard load time: {$executionTime} seconds");

        return view('dashboard', $data);
    }
}
