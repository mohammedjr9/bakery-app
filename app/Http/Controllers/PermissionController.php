<?php

namespace App\Http\Controllers;

use App\Models\RoleBtn;
use App\Models\RolePage;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $role_pages = RolePage::with('buttons')->get();
        return view('permissions.index', compact ('role_pages'));
    }



    public function toggle_role_page(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_page_id' => 'required|exists:role_pages,id',
        ]);
        $user = User::findOrFail($request->user_id);
        if ($user->rolePages()->where('role_page_id', $request->role_page_id)->exists()) {
            $user->rolePages()->detach($request->role_page_id);
            return response()->json(['success' => true, 'action' => 'detached', 'message' => 'تم حذف الشاشة من المستخدم']);
        } else {
            $user->rolePages()->syncWithoutDetaching([$request->role_page_id]);
            return response()->json(['success' => true, 'action' => 'attached', 'message' => 'تم إضافة الشاشة للمستخدم']);
        }
    }

    public function toggle_role_btn(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_btn_id' => 'required|exists:role_btns,id',
        ]);
        $user = User::findOrFail($request->user_id);
        if ($user->roleBtns()->where('role_btn_id', $request->role_btn_id)->exists()) {
            $user->roleBtns()->detach($request->role_btn_id);
            return response()->json(['success' => true, 'action' => 'detached', 'message' => 'تم حذف الزر من المستخدم']);
        } else {
            $user->roleBtns()->syncWithoutDetaching([$request->role_btn_id]);
            return response()->json(['success' => true, 'action' => 'attached', 'message' => 'تم إضافة الزر للمستخدم']);
        }

    }

    public function userPermissions(Request $request)
    {

        // Get role pages and buttons for the user
        $rolePages = RolePage::ByUser($request->userId)->pluck('id')->toArray();
        $roleBtns = RoleBtn::ByUser($request->userId)->pluck('id')->toArray();

        return response()->json([
            'role_pages' => $rolePages,
            'role_btns' => $roleBtns,
        ]);
    }
}
