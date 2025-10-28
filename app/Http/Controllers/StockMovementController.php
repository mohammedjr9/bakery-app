<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\TypeCoupon;
use App\Models\warehouses;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function create(warehouses $warehouse)
    {
        $typeCoupons = TypeCoupon::all();
        return view('warehouses.StockMovement.create', compact('warehouse', 'typeCoupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id'    => 'required|exists:warehouses,id',
            'type_coupon_id'  => 'required|exists:type_coupons,id',
            'quantity'        => 'required|integer|min:1',
            'batch_number'    => 'nullable|string',
            'production_date' => 'nullable|date',
            'expiry_date'     => 'nullable|date|after_or_equal:production_date',
            'notes'           => 'nullable|string',
        ]);

        StockMovement::create([
            'warehouse_id'       => $request->warehouse_id,
            'type_coupon_id'     => $request->type_coupon_id,
            'type'               => 'in',
            'original_quantity'  => $request->quantity,
            'quantity'           => $request->quantity,
            'batch_number'       => $request->batch_number,
            'production_date'    => $request->production_date,
            'expiry_date'        => $request->expiry_date,
            'notes'              => $request->notes,
        ]);

        return redirect()->route('warehouses.show', $request->warehouse_id)
                         ->with('success', 'تمت إضافة الطرد بنجاح.');
    }

    public function show($id)
    {
        $warehouse = warehouses::findOrFail($id);

        $totalIn = $warehouse->stockMovements()->where('type', 'in')->sum('quantity');
        $totalOut = $warehouse->stockMovements()->where('type', 'out')->sum('quantity');
        $remaining = $totalIn - $totalOut;
        $typeName = null;

        return view('warehouses.show', compact('warehouse', 'totalIn', 'totalOut', 'remaining', 'typeName'));
    }

    public function destroy($id)
    {
        $stock = StockMovement::findOrFail($id);
        $warehouse_id = $stock->warehouse_id;
        $stock->delete();

        return redirect()->route('warehouses.show', $warehouse_id)
                         ->with('success', 'تم حذف الحركة بنجاح.');
    }

    public function createDeliver(warehouses $warehouse)
    {
        $typeCoupons = TypeCoupon::all();
        return view('warehouses.StockMovement.deliver', compact('warehouse', 'typeCoupons'));
    }

    public function storeDeliver(Request $request, warehouses $warehouse)
    {
        $request->validate([
            'type_coupon_id' => 'required|exists:type_coupons,id',
            'quantity'       => 'required|integer|min:1',
            'recipient'      => 'required|string',
            'notes'          => 'nullable|string',
        ]);

        StockMovement::create([
            'warehouse_id'   => $warehouse->id,
            'type_coupon_id' => $request->type_coupon_id,
            'type'           => 'out',
            'quantity'       => $request->quantity,
            'recipient'      => $request->recipient,
            'notes'          => $request->notes,
        ]);

        return redirect()->route('warehouses.show', $warehouse->id)
                         ->with('success', 'تم تسجيل عملية التسليم بنجاح.');
    }

    public function filter(Request $request, warehouses $warehouse)
    {
        $type = $request->input('type', 'all');
        $type_coupon_id = $request->input('type_coupon_id', 'all');

        $query = $warehouse->stockMovements()->latest();

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        if ($type_coupon_id !== 'all') {
            $query->where('type_coupon_id', $type_coupon_id);
        }

        $stockMovements = $query->get();

        $totalsQuery = $warehouse->stockMovements();

        if ($type_coupon_id !== 'all') {
            $totalsQuery->where('type_coupon_id', $type_coupon_id);
        }

        $totalIn = (clone $totalsQuery)->where('type', 'in')->sum('quantity');
        $totalOut = (clone $totalsQuery)->where('type', 'out')->sum('quantity');
        $remaining = $totalIn - $totalOut;

        $typeName = null;
        if ($type_coupon_id !== 'all') {
            $typeName = optional(TypeCoupon::find($type_coupon_id))->name;
        }

        return view('warehouses.partials.stock_movements_table', compact(
            'stockMovements',
            'totalIn',
            'totalOut',
            'remaining',
            'typeName'
        ))->render();
    }
}
