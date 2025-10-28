<?php

namespace App\Http\Controllers;

use App\Models\RoleBtn;
use App\Models\RolePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RoleBtnController extends Controller
{
    public function index()
    {
        $data['role_btns'] = RoleBtn::all();
        $data['role_pages'] = RolePage::all();
        return view('role_btn.index', $data);
    }
    public function insert_role_btn(Request $request)
    {
        $role = [
            'name' => 'required|string',
            'notes' => 'nullable|string',
            'follow_to_page' => 'required|exists:role_pages,id',
        ];
        $validator = Validator::make($request->all(), $role);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        try {
            $data['name'] = $request->name;
            $data['notes'] = $request->notes;
            $data['follow_to_page'] = $request->follow_to_page;
            RoleBtn::create($data);
        } catch (\Exception $exception) {
            return Response::json(array('success' => false, 'results' => ['message' => $exception . 'يوجد خطأ في عملية الإدخال']));
        }
        return Response::json(array('success' => true, 'results' => ['message' => 'تمت عملية الإدخال بنجاح']));
    }
    public function update_role_btn(Request $request)
    {
        $role = [
            'id' => 'required|exists:role_btns,id',
            'name' => 'required|string',
            'notes' => 'nullable|string',
            'follow_to_page' => 'required|exists:role_pages,id',
        ];
        $validator = Validator::make($request->all(), $role);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        try {
            $role_btn = RoleBtn::findOrFail($request->id);
            $data['name'] = $request->name;
            $data['notes'] = $request->notes;
            $data['follow_to_page'] = $request->follow_to_page;
            $role_btn->update($data);
        } catch (\Exception $exception) {
            return Response::json(array('success' => false, 'results' => ['message' => $exception . 'يوجد خطأ في عملية التعديل']));
        }
        return Response::json(array('success' => true, 'results' => ['message' => 'تمت عملية التعديل بنجاح']));
    }
}