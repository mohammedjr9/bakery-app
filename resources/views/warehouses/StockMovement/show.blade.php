@extends('layouts.main')
@section('title', 'تفاصيل الطرد')

@section('content')
<div class="container mt-4">
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card-header">تفاصيل الطرد</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>المخزن</th>
                            <td>{{ $stock_movement->warehouse->name }}</td>
                        </tr>
                        <tr>
                            <th>نوع الطرد</th>
                            <td>{{ $stock_movement->typeCoupon->name ?? 'غير معروف' }}</td>
                        </tr>
                        <tr>
                            <th>النوع</th>
                            <td>{{ $stock_movement->type === 'in' ? 'إدخال' : 'إخراج' }}</td>
                        </tr>
                        <tr>
                            <th>الكمية الواردة</th>
                            <td>{{ $stock_movement->quantity }}</td>
                        </tr>
                        <tr>
                            <th>ملاحظات</th>
                            <td>{{ $stock_movement->notes ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>تاريخ الإضافة</th>
                            <td>{{ $stock_movement->created_at->format('Y-m-d') }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- زر فتح المودال -->
                <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#deliverModal">
                    تسليم الطرد
                </button>

                <!-- المودال -->
                <div class="modal fade" id="deliverModal" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('stock_movements.deliver', $stock_movement->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">تسليم الطرد</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>الكمية المسلّمة</label>
                                        <input type="number" name="delivered_quantity" class="form-control" required min="1" max="{{ $stock_movement->quantity }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>ملاحظات</label>
                                        <textarea name="notes" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">تأكيد التسليم</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- عمليات التسليم السابقة -->
                @if($deliveries->count())
                    <div class="mt-5">
                        <h5>عمليات التسليم السابقة</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>الكمية المسلّمة</th>
                                        <th>ملاحظات</th>
                                        <th>تاريخ التسليم</th>
                                        <th> النوع</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deliveries as $index => $delivery)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $delivery->delivered_quantity }}</td>
                                            <td>{{ $delivery->notes ?? '-' }}</td>
                                            <td>{{ $delivery->created_at->format('Y-m-d H:i') }}</td>
                                            <td>الاخراج</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
