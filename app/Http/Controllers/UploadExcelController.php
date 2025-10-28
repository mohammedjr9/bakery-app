<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Work;
use App\Models\Worker;
use App\Rules\CheckId;
use App\Models\Beneficiary;
use App\Imports\ExcelImport;
use Illuminate\Http\Request;
use App\Models\ClothingPackage;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UploadExcelController extends Controller
{
    public function index(Request $request)
    {
        return view('import-excel');
    }
    public function importExcel(Request $request)
    {
        $files = $request->file('file');

        // if ($files->isValid())
        // {
        //     return redirect()->route('upload_bulk_excel')->withErrors(["لا يوجد ملف اكسل باسم (upload.xlsx)"]);
        // }

        $array = Excel::toArray(new ExcelImport, $files);
        if (count($array[0]) <= 1) {
            return redirect()->route('upload_bulk_excel')->withErrors(["يجب أن يحتوي الكشف على سجل واحد على الأقل."]);
        }
        $error = [];
        $success_count = 0;
        foreach ($array[0] as $key => $item) {
            if ($key == 0) {
                continue;
            }
            if ($item[1] == null) {
                continue;
            }
            $data['name'] = $item[0];
            $data['id_num'] = $item[1];
            $data['type_coupon_id'] = $item[3];

            try {
                if (is_int($item[2])) {
                    $new_date = ($item[2] - 25569) * 86400;
                    $data['due_date'] = gmdate("Y-m-d", $new_date);
                } else {
                    $data['due_date'] = Carbon::createFromFormat('Y-m-d', $item[2])->format('Y-m-d');
                }
            } catch (\Exception $exception) {
                $result['mess'] =  'خطأ في صيغة تاريخ الاستحقاق';
                array_push($error, $result);
                continue;
            }

            $rules = $this->rules();
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                array_push($error, array($key + 1, $validator->errors()->all()));
                continue;
            }

            Beneficiary::create($data);
            $success_count++;
        }
        $data_result['success_count'] = $success_count;
        $data_result['error'] = $error;
        return view('result-import-excel', $data_result);
        //
    }
    protected function rules()
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'id_num' => [
                'required',
                'numeric',
                'digits:9',
                new CheckId()
            ],
            'type_coupon_id' => [
                'required',
                'numeric',
                'exists:type_coupons,id',
            ],
            'due_date' => [
                'required',
                Rule::date()->format('Y-m-d'),
                Rule::date()->afterOrEqual(date('Y-m-d'))
            ],
        ];

        return $rules;
    }

    function CheckFile($file, $file_name)
    {
        foreach ($file as $value) {
            if ($value->getClientOriginalName() == $file_name) {
            }
        }
        return false;
    }

    public function uploadClothing()
    {
        return view('clothing_packages.import-clothing-excel');
    }

    public function importClothing(Request $request)
    {
        $file = $request->file('file');
        $array = Excel::toArray([], $file);

        if (count($array[0]) <= 1) {
            return redirect()->route('upload_clothing_excel')
                ->withErrors(["الملف فارغ أو لا يحتوي على بيانات."]);
        }

        $errors = [];
        $success_count = 0;

        foreach ($array[0] as $key => $row) {
            if ($key == 0 || empty($row[1])) continue;

            // try {
            //     $date = is_int($row[5])
            //         ? gmdate("Y-m-d", ($row[5] - 25569) * 86400)
            //         : \Carbon\Carbon::parse($row[5])->format('Y-m-d');
            // } catch (\Exception $e) {
            //     dd($row);
            //     $errors[] = ["السطر " . ($key + 1), ["صيغة التاريخ غير صالحة"]];
            //     continue;
            // }
            if (!isset($row[5]) || trim($row[5]) === '') {
                $errors[] = ["السطر " . ($key + 1), ["التاريخ غير موجود"]];
                continue;
            }

            $date = $this->normalizeDate($row[5]);

            if (!$date) {
                $errors[] = ["السطر " . ($key + 1), ["صيغة التاريخ غير صالحة", (string)$row[5]]];
                continue;
            }


            $exists = ClothingPackage::where('name', $row[1])
                ->where('id_num', $row[2])
                ->where('due_date', $date)
                ->exists();

            if ($exists) {
                $errors[] = ["السطر " . ($key + 1), ["تم تجاهل السطر لأنه مكرر (نفس الاسم، الهوية، وتاريخ الاستحقاق)"]];
                continue;
            }

            try {
                ClothingPackage::create([
                    'code' => $row[0],
                    'name' => $row[1],
                    'id_num' => $row[2],
                    'children_count' => $row[3],
                    'amount' => $row[4],
                    'due_date' => $date,
                    'distribution_place_id' => $row[6] ?? null,
                    'project_id' => $row[7] ?? null,
                    'notes' => $row[8] ?? null,
                ]);
                $success_count++;
            } catch (\Exception $e) {
                $errors[] = ["السطر " . ($key + 1), [$e->getMessage()]];
            }
        }

        return view('clothing_packages.result-import-excel', [
            'success_count' => $success_count,
            'error' => $errors
        ]);
    }

    function normalizeDate($value): ?string
    {
        try {
            // إزالة المسافات وتحويل الأرقام العربية إلى إنجليزية
            $value = is_string($value) ? trim($value) : $value;

            $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            $westernDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            if (is_string($value)) {
                $value = str_replace($arabicDigits, $westernDigits, $value);
            }

            // 1. إذا كانت القيمة رقمية وتشبه Serial Number من Excel
            if (is_numeric($value) && (float)$value > 30000) {
                $timestamp = (int) round(((float)$value - 25569) * 86400);
                return \Carbon\Carbon::createFromTimestampUTC($timestamp)->format('Y-m-d');
            }

            // 2. إذا كانت نصًا بصيغة تاريخ معروفة
            $formats = ['d/m/Y', 'd-m-Y', 'Y/m/d', 'Y-m-d', 'm/d/Y', 'm-d-Y', 'd.m.Y'];
            foreach ($formats as $format) {
                try {
                    return \Carbon\Carbon::createFromFormat($format, $value)->format('Y-m-d');
                } catch (\Exception $e) {
                    // جرّب التنسيق التالي
                }
            }

            // 3. محاولة التحليل التلقائي (قد يسبب أخطاء في بعض الحالات الغامضة)
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null; // تاريخ غير صالح
        }
    }
}
