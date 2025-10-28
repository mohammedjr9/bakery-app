<?php

namespace App\Http\Controllers;

use App\Models\Constant;
use Illuminate\Http\Request;

class ConstantController extends Controller
{

   public function index(Request $request)
{
    $parents = Constant::whereNull('parent_id')->orderBy('id', 'desc')->get();
    $children = Constant::whereNotNull('parent_id')->with('parent')->orderBy('id', 'desc')->get();

    if ($request->ajax()) {
        return view('constants.index', compact('parents', 'children'))->render();
    }

    return view('constants.index', compact('parents', 'children'));
}


    public function create()
    {
        $parents = Constant::whereNull('parent_id')->get();
        return view('constants.create', compact('parents'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:constants,id',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);

        Constant::create([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('constants.index')->with('success', 'تمت الإضافة بنجاح.');
    }

    public function edit(Constant $constant)
    {
        $parents = Constant::whereNull('parent_id')->where('id', '!=', $constant->id)->get();
        return view('constants.edit', compact('constant', 'parents'));
    }


    public function update(Request $request, Constant $constant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:constants,id',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);

        $constant->update([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('constants.index')->with('success', 'تم التحديث بنجاح.');
    }


    public function destroy(Request $request, Constant $constant)
    {
        $constant->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('constants.index')->with('success', 'تم الحذف بنجاح.');
    }
}
