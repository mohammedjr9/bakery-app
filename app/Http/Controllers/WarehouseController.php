<?php

namespace App\Http\Controllers;

use App\Models\TypeCoupon;
use App\Models\warehouses;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
public function index()
{
     $warehouses = warehouses::with('type_coupon')->get();
    return view('warehouses.index', compact('warehouses'));
}

public function create()
{
    $types = TypeCoupon::all();
    return view('warehouses.create', compact('types'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'location' => 'nullable|string',
    ]);

    warehouses::create([
        'name' => $request->name,
        'location' => $request->location,
        'type_coupon_id' => null,
        'total_packages' => 0,
        'remaining_packages' => 0,
    ]);

    return redirect()->route('warehouses.index')->with('success', 'تم حفظ المخزن بنجاح');
}


public function edit($id)
{
    $warehouse = warehouses::findOrFail($id);
    $types = TypeCoupon::all();
    return view('warehouses.edit', compact('warehouse', 'types'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'nullable|string',
        'type_coupon_id' => 'required|exists:type_coupons,id',
        'total_packages' => 'required|integer|min:0',
        'remaining_packages' => 'required|integer|min:0|max:' . $request->total_packages,
    ]);

    $warehouse = warehouses::findOrFail($id);
    $warehouse->update($request->all());

    return redirect()->route('warehouses.index')->with('success', 'تم تعديل المخزن بنجاح');
}

public function destroy($id)
{
    $warehouse = warehouses::findOrFail($id);
    $warehouse->delete();

    return redirect()->route('warehouses.index')->with('success', 'تم حذف المخزن');
}

public function show($id)
{
    $warehouse = warehouses::findOrFail($id);
    return view('warehouses.show', compact('warehouse'));
}

}

