<?php

namespace App\Http\Controllers;

use App\Exports\BeneficiariesExport;
use App\Models\Beneficiary;
use App\Models\Receipt;
use App\Models\type_coupons;
use App\Rules\CheckId;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
class BeneficiaryController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }
    public function add_beneficiary(Request $request)
    {
        $data['coupons'] = type_coupons::get();

        return view('add_beneficiary', $data);
    }
    public function export()
    {
        //return Excel::download(new BeneficiariesExport, 'Beneficiary.xlsx');
    }
    public function result_search(Request $request)
    {
        $query = Beneficiary::orderBy('id', 'desc');
        if ($request->s_id_no != '') {
            $query->where('id_num', $request->s_id_no);
        }
        if ($request->s_name != '') {
            $query->where('name', 'LIKE', "%$request->s_name%");
        }

        $Beneficiaries = $query->get();
        // $result['data'] = [];
        // if ($Beneficiaries) {

        //     foreach ($Beneficiaries as $key => $value) {

        //         $result['data'][] = array(
        //             $value['id_num'],
        //             $value['name'],
        //             $value['type_coupon_id'],
        //            // $value->types_coupons->name,
        //             $value['due_date'],
        //             $value['receipt_date'],
        //         );
        //     }
        // }
        return view('result_search', compact('Beneficiaries'));
    }
    public function change_status(Request $request)
    {

        if ($request->b_id) {
            $beneficiary = Beneficiary::where('id', $request->b_id)->first();
            if (!$beneficiary) {
                return response()->json(['status' => 'fail', 'message' => 'لا يوجد مستفيد بهذا الرقم']);
            }
            if ($beneficiary->receipt_date) {
                return response()->json(['status' => 'fail', 'message' => 'المستفيد (' . $beneficiary->name . ') استلم بتاريخ ' . $beneficiary->receipt_date]);
            }
            if ($beneficiary->due_date >= now()->format('Y-m-d')) {
                $beneficiary->update(['receipt_date' => now()]);
                return response()->json(['status' => 'success', 'message' => 'تمت تسليم المستفيد ( ' . $beneficiary->name . ') بنجاح ']);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'لا يمكن تسليم المستفيد بالوقت الحالي']);
            }
        }
        return response()->json(['status' => 'fail']);
    }
    public function cancel_receipt(Request $request)
    {
        if ($request->receipt_id) {
            $receipt = Receipt::findOrFail($request->receipt_id);
            if ($receipt == null) {
                return response()->json(['status' => 'fail']);
            }
            if (is_null($receipt->receipt_date)) {
                return response()->json(['status' => 'fail', 'message' => 'المستفيد لم يستلم في هذا اليوم']);
            } else {
                $receipt->update(['receipt_date' => null]);
                return response()->json(['status' => 'success', 'message' => '  تمت علمية إلغاء تسليم المستفيد رقم #' . $request->num_code . ' بنجاح ']);
            }
        }
        return response()->json(['status' => 'fail']);
    }

    public function insert(Request $request)
    {
        $query = Beneficiary::where('code_num', '>', 8000)->where('num_family', 2)->get();
        foreach ($query as $key => $value) {
            $data['beneficiary_id'] = $value->id;
            $data['due_date'] = '2024-06-02';
            Receipt::create($data);
            $data['due_date'] = '2024-06-04';
            Receipt::create($data);
            $data['due_date'] = '2024-06-06';
            Receipt::create($data);
            $data['due_date'] = '2024-06-08';
            Receipt::create($data);
            $data['due_date'] = '2024-06-10';
            Receipt::create($data);
            $data['due_date'] = '2024-06-12';
            Receipt::create($data);
            $data['due_date'] = '2024-06-14';
            Receipt::create($data);
        }
        dd(1);
    }
    public function save_beneficiary_info(Request $request)
    {
        $role = [

            'id_num' =>  ['required',
            'numeric',
            'digits:9',
            new CheckId()],
            'name' => 'required',
            'type_coupon_id' => 'required',
            'due_date' => 'required',
            'receipt_date' => 'nullable',


        ];

        $validator = Validator::make($request->all(), $role);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => implode('-', $validator->errors()->all())

            )); // 400 being the HTTP code for an invalid request.
        }
        $data = $request->all();

        $results = Beneficiary::create($data);
        return Response::json(array('success' => true,'results'=>$results));

    }
}
