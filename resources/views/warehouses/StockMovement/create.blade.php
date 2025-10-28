@extends('layouts.main')
@section('title', 'إضافة طرد وارد إلى المخزن')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">إضافة طرد وارد جديد</div>
        <div class="card-body">
            <form action="{{ route('stock_movements.store') }}" method="POST">
                @csrf

                {{-- المخزن --}}
                <input type="hidden" name="warehouse_id" value="{{ $warehouse->id }}">
                <input type="hidden" name="type" value="in"> {{-- تحديد النوع ثابت (وارد) --}}
                <p class="mb-3"><strong>المخزن:</strong> {{ $warehouse->name }}</p>

                {{-- نوع الطرد --}}
                <div class="form-group mb-3">
                    <label for="type_coupon_id">نوع الطرد</label>
                    <select name="type_coupon_id" id="type_coupon_id" class="form-control" required>
                        <option disabled selected>اختر نوع الطرد</option>
                        @foreach ($typeCoupons as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- الكمية --}}
                <div class="form-group mb-3">
                    <label for="quantity">الكمية</label>
                    <input type="number" name="quantity" class="form-control" min="1" required>
                </div>

                {{-- ملاحظات --}}
                <div class="form-group mb-3">
                    <label for="notes">ملاحظات</label>
                    <textarea name="notes" class="form-control"></textarea>
                </div>

                {{-- زر الإضافة --}}
                <button type="submit" class="btn btn-primary">حفظ الطرد</button>
            </form>
        </div>
    </div>
</div>
@endsection
