<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::get();
        //    dd($data['users']);
        return view('user.index', $data);
    }
    public function insert_user(Request $request)
    {
        //dd($request->all());
        $role = [
            'password' => 'required|min:6|confirmed', // password_confirmation
            'id_no' => 'required|numeric|digits:9|unique:users,id_no',
            'name'=>'required|string',
            'type_user' => 'required|in:admin,user'
        ];

        $validator = Validator::make($request->all(), $role);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            )); // 400 being the HTTP code for an invalid request.
        }
        try {
            $data['id_no'] = $request->id_no;
            $data['type_user'] = $request->type_user;
            $data['name']=$request->name;
            $data['password'] = Hash::make($request->password);
            User::create($data);
        } catch (\Exception $exception) {
            return Response::json(array('success' => false, 'results' => ['message' => $exception . 'يوجد خطأ في عملية الإدخال']));
        }
        return Response::json(array('success' => true, 'results' => ['message' => 'تمت عملية الإدخال بنجاح']));
    }
    public function update(Request $request)
    {
        $role = [
            'id_user' => 'required|numeric|exists:users,id',
            'type_user' => 'required|in:admin,user',
            'id_no' => 'required|numeric|digits:9|unique:users,id_no,' . $request->id_user,
            'name'=>'required|string',
        ];

        $validator = Validator::make($request->all(), $role);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            )); // 400 being the HTTP code for an invalid request.
        }
        try {
            $user = User::findOrFail($request->id_user);
            $data['id_no'] = $request->id_no;
            $data['type_user'] = $request->type_user;
            $data['name']=$request->name;
            $user->update($data);
        } catch (\Exception $exception) {
            return Response::json(array('success' => false, 'results' => ['message' => $exception . 'يوجد خطأ في عملية التعديل']));
        }
        return Response::json(array('success' => true, 'results' => ['message' => 'تمت عملية التعديل بنجاح']));
    }
    public function update_password(Request $request)
    {
        $role = [
            'id_user' => 'required|numeric|exists:users,id',
            'password' => 'required|min:6|confirmed', // password_confirmation
            //    'type_user' => 'required|in:admin,user'
        ];

        $validator = Validator::make($request->all(), $role);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            )); // 400 being the HTTP code for an invalid request.
        }
        try {
            $user = User::findOrFail($request->id_user);
            $user->password = Hash::make($request->password);
            // $user->type_user = $request->type_user;
            $user->save();

        } catch (\Exception $exception) {
            return Response::json(array('success' => false, 'results' => ['message' => $exception . 'يوجد خطأ في عملية التعديل']));
        }
        return Response::json(array('success' => true, 'results' => ['message' => 'تمت عملية تعديل كلمة المرور بنجاح']));
    }

}
