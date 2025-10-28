@extends('layouts.main')

@section('title', 'تعديل مخزن')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5>تعديل بيانات المخزن</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">اسم المخزن</label>
                    <input type="text" name="name" class="form-control" value="{{ $warehouse->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">نوع الطرد</label>
                    <select name="type_coupon_id" class="form-select" required>
                        <option disabled>اختر نوع الطرد</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ $warehouse->type_coupon_id == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">عدد الطرود الكلي</label>
                    <input type="number" name="total_packages" class="form-control" value="{{ $warehouse->total_packages }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">المتبقي من الطرود</label>
                    <input type="number" name="remaining_packages" class="form-control" value="{{ $warehouse->remaining_packages }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">الموقع</label>
                    <textarea name="location" class="form-control" rows="2">{{ $warehouse->location }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">تحديث</button>
                <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection
