<?php

namespace App\Http\Controllers\Auth;


use App\Models\user;
use App\Models\RoleBtn;
use App\Models\RolePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        // return Auth::check() ? redirect()->back() : view('auth.login');
        return view('auth.login');
    }
    public function login(Request $request)
    {
        // dd(Hash::make(123456));
        // dd($request->all());
        try {
            DB::connection()->getPdo();
            $validator = Validator::make($request->all(), [
                'user_name' => ['required', 'exists:users,id_no'],
                'password' => ['required'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors(["اسم المستخدم أو كلمة المرور خاطئة ،يرجى المحاولة فيما بعد"]);
            }

            if (Auth::attempt(['id_no' => $request->user_name, 'password' => $request->password])) {
                session(['permission' => $this->getRolesUser()]);
                session(['permission_btn' => $this->getRolesBtnUser()]);
                // dd(session());

                return redirect()->intended(route('dashboard'));
            }

            return redirect()->back()->withErrors(["كلمة المرور خطأ"]);

        } catch (\Exception $e) {
            dd($e);
            $message = "خطأ في الاتصال بقاعدة البيانات - يرجى المحاولة فيما بعد";
            return redirect()->back()->withErrors([$message]);

        }

    }

    public function getRolesUser()
    {
        $roles = RolePage::ByUser(Auth()->id())->orderBy('id')->get();
        return $roles;
    }

    public function getRolesBtnUser()
    {
        $roles = RoleBtn::ByUser(Auth()->id())->orderBy('id')->pluck('id')->toArray();
        //ByUserwhere('user_id',Auth()->id())->pluck('role_btns_id')->toArray();
        return $roles;
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
