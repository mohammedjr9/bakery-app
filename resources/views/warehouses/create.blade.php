@extends('layouts.main')

@section('title', 'إضافة مخزن')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5>إضافة مخزن جديد</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('warehouses.store') }}" method="POST">
                @csrf

                {{-- اسم المخزن نص حر --}}
                <div class="mb-3">
                    <label class="form-label">اسم المخزن</label>
                    <input type="text" name="name" class="form-control" placeholder="اكتب اسم المخزن" required>
                </div>

                {{-- الموقع --}}
                <div class="mb-3">
                    <label class="form-label">الموقع</label>
                    <textarea name="location" class="form-control" rows="2" placeholder="اكتب موقع المخزن"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">حفظ المخزن</button>
            </form>
        </div>
    </div>
</div>
@endsection
