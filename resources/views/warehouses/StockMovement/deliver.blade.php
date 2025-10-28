@extends('layouts.main')

@section('title', 'تسليم طرد من المخزن')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">تسليم طرد جديد</div>
        <div class="card-body">
            <form action="{{ route('warehouse.stock.deliver.store', $warehouse->id) }}" method="POST">
                @csrf

                <p><strong>المخزن:</strong> {{ $warehouse->name }}</p>

                <div class="form-group mb-3">
                    <label for="type_coupon_id">نوع الطرد</label>
                    <select name="type_coupon_id" class="form-control" required>
                        <option disabled selected>اختر نوع الطرد</option>
                        @foreach ($typeCoupons as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="quantity">الكمية المسلمة</label>
                    <input type="number" name="quantity" class="form-control" min="1" required>
                </div>

                <div class="form-group mb-3">
                    <label for="recipient">المستلم</label>
                    <input type="text" name="recipient" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="notes">ملاحظات</label>
                    <textarea name="notes" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-success">تأكيد التسليم</button>
            </form>
        </div>
    </div>
</div>
@endsection
