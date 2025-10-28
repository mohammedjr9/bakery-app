<?php

namespace App\Http\Controllers;

use App\Models\RolePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RolePageController extends Controller
{
    public function index()
    {
        $data['role_pages'] = RolePage::all();
        return view('role_page.index', $data);
    }
    public function insert_role_page(Request $request)
    {
        // dd($request);
        $role = [
            'name' => 'required|string',
            'url' => 'required|string',
            'follow_to_id' => 'sometimes|nullable|exists:role_pages,id',
            'notes' => 'nullable|string',
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
            $data['url'] = $request->url;
            $data['follow_to_id'] = $request->follow_to_id;
            $data['notes'] = $request->notes;
            RolePage::create($data);

        } catch (\Exception $exception) {
            return Response::json(array('success' => false, 'results' => ['message' => $exception . 'يوجد خطأ في عملية الإدخال']));

        }
        return Response::json(array('success' => true, 'results' => ['message' => 'تمت عملية الإدخال بنجاح']));
    }
    public function update_role_page(Request $request)
    {
        // dd($request);
        $role = [
            'id' => 'required|exists:role_pages,id',
            'name' => 'required|string',
            'url' => 'required|string',
            'follow_to_id' => 'sometimes|nullable|exists:role_pages,id',
            'notes' => 'nullable|string',
        ];
        $validator = Validator::make($request->all(), $role);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        try {
            $role_page = RolePage::findOrFail($request->id);
            $data['name'] = $request->name;
            $data['url'] = $request->url;
            $data['follow_to_id'] = $request->follow_to_id;
            $data['notes'] = $request->notes;
            $role_page->update($data);
        } catch (\Exception $exception) {
            return Response::json(array('success' => false, 'results' => ['message' => $exception . 'يوجد خطأ في عملية التعديل']));
        }
        return Response::json(array('success' => true, 'results' => ['message' => 'تمت عملية التعديل بنجاح']));
    }

}
