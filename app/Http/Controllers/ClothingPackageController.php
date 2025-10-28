<?php

namespace App\Http\Controllers;

use App\Models\Constant;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use App\Models\ClothingPackage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DeliveredClothingExport;

class ClothingPackageController extends Controller
{
    public function index()
    {
        $places = Constant::where('parent_id', 1)
            ->where('status', 1)
            ->pluck('name', 'id');

        return view('clothing_packages.index', compact('places'));
    }



    public function result_search(Request $request)
    {
        $query = ClothingPackage::with('distributionPlace')->orderBy('id', 'desc');

        if ($request->filled('s_code')) {
            //$formattedCode = str_pad($request->s_code, 3, '0', STR_PAD_LEFT);
            $formattedCode = $request->s_code;
            $query->where('code', $formattedCode);
        }

        if ($request->filled('s_id_no')) {
            $query->where('id_num', $request->s_id_no);
        }

        if ($request->filled('s_name')) {
            $query->where('name', 'LIKE', "%$request->s_name%");
        }

        if ($request->filled('s_place') && $request->s_place !== 'none') {
            $query->where('distribution_place_id', $request->s_place);
        } elseif ($request->s_place === 'none') {
            $query->whereRaw('1 = 0');
        }


        $Beneficiaries = $query->get();

        return view('clothing_packages.result_search', compact('Beneficiaries'));
    }

    public function change_status(Request $request)
    {
        $clothing = ClothingPackage::where('id', $request->b_id)->first();

        if (!$clothing) {
            return response()->json([
                'status' => 'fail',
                'message' => 'لا يوجد مستفيد بهذا الرقم'
            ]);
        }

        if ($clothing->receipt_date) {
            return response()->json([
                'status' => 'fail',
                'message' => 'تم التسليم مسبقاً بتاريخ ' . $clothing->receipt_date->format('Y-m-d H:i')
            ]);
        }

        if (now()->format('Y-m-d') >= $clothing->due_date) {
            $clothing->update([
                'receipt_date' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'تم التسليم بنجاح',
                'date' => $clothing->receipt_date->format('Y-m-d H:i')
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'لا يمكن التسليم قبل موعد الاستحقاق'
            ]);
        }
    }


    public function report(Request $request)
    {
        $places = Constant::where('parent_id', 1)
            ->where('status', '1')
            ->pluck('name', 'id');
        $projects = \App\Models\Constant::where('parent_id', 4)->where('status', 1)->pluck('name', 'id');


        return view('clothing_packages.report', compact('places', 'projects'));
    }

    public function report_ajax(Request $request)
    {
        // dd($request->all());
        $query = ClothingPackage::query();

        if ($request->filled('s_place') && $request->s_place !== 'none') {
            $query->where('distribution_place_id', $request->s_place);
        } elseif ($request->s_place === 'none') {
            $query->whereRaw('1 = 0');
        }
        if ($request->filled('project_id') && $request->project_id !== 'none') {
            $query->where('project_id', $request->project_id);
        } elseif ($request->project_id === 'none') {
            $query->whereRaw('1 = 0');
        }


        if ($request->filled('due_date')) {
            $query->whereDate('receipt_date', $request->due_date);
        }

        $allData = $query->with('project')->get();

        $results = collect();
        $sum_people = 0;
        $sum_delivered = 0;
        $sum_not_delivered = 0;

        $grouped = $allData->groupBy(function ($item) {
            return $item->due_date . '||' . $item->receipt_date . '||' . ($item->project->name ?? '---');
        });

        foreach ($grouped as $key => $items) {
            [$due_date, $receipt_date, $projectName] = explode('||', $key);

            $total_people = $items->count();
            $delivered = $items->whereNotNull('receipt_date')->count();
            $not_delivered = $total_people - $delivered;

            $results->push((object)[
                'due_date' => $due_date,
                'receipt_date' => $receipt_date,
                'project_name' => $projectName,
                'total_people' => $total_people,
                'delivered' => $delivered,
                'not_delivered' => $not_delivered,
            ]);


            $sum_people += $total_people;
            $sum_delivered += $delivered;
            $sum_not_delivered += $not_delivered;
        }

        return view('clothing_packages.report_result', compact(
            'results',
            'sum_people',
            'sum_delivered',
            'sum_not_delivered'
        ));
    }
    public function deliveredList(Request $request)
    {
        $query = ClothingPackage::whereNotNull('receipt_date');

        if ($request->filled('project_id') && $request->project_id !== 'none') {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('place') && $request->place !== 'none') {
            $query->where('distribution_place_id', $request->place);
        }

        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }

        $delivered = $query->with(['project', 'distributionPlace'])->orderBy('receipt_date', 'desc')->get();

        return view('clothing_packages.delivered_list', compact('delivered'));
    }



    public function exportDelivered(Request $request)
    {
        $query = ClothingPackage::whereNotNull('receipt_date');

        if ($request->filled('project_id') && $request->project_id !== 'none') {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('place') && $request->place !== 'none') {
            $query->where('distribution_place_id', $request->place);
        }

        if ($request->filled('due_date')) {
            $query->whereDate('receipt_date', $request->due_date);
        }

        $data = $query->with(['project', 'distributionPlace'])->get();

        return Excel::download(new DeliveredClothingExport($data), 'delivered_clothing_filtered.xlsx');
    }

    public function last_update()
    {
        $items = ClothingPackage::orderBy('updated_at', 'desc')->limit(20)->get();
        return view('clothing_packages.last_update', compact('items'));
    }
}
