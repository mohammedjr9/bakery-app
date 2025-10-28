@extends('layouts.main')

@section('title', 'تفاصيل المخزن')

@section('content')
<div class="container mt-4">

    {{-- بطاقة تفاصيل المخزن --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">تفاصيل المخزن</h5>
        </div>
        <div class="card-body">
            <p><strong>اسم المخزن:</strong> {{ $warehouse->name }}</p>
            <p><strong>الموقع:</strong> {{ $warehouse->location ?? 'غير محدد' }}</p>
            <p><strong>تاريخ الإضافة:</strong> {{ $warehouse->created_at->format('Y-m-d') }}</p>
        </div>
    </div>

    {{-- أزرار أعلى الجدول --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('warehouse.stock.add', $warehouse->id) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> إضافة طرد
        </a>
        <a href="{{ route('warehouse.stock.deliver', $warehouse->id) }}" class="btn btn-sm btn-success">
            <i class="fas fa-truck"></i> تسليم طرد
        </a>
    </div>

    {{-- أزرار الفلترة --}}
    <div class="mb-3 d-flex gap-2 flex-wrap">
        <button class="btn btn-outline-secondary btn-sm filter-btn active" data-type="all">الكل</button>
        <button class="btn btn-outline-success btn-sm filter-btn" data-type="in">الوارد</button>
        <button class="btn btn-outline-danger btn-sm filter-btn" data-type="out">الصادر</button>

        <select id="typeCouponFilter" class="form-select form-select-sm w-auto">
            <option value="all">كل الأنواع</option>
            @foreach(App\Models\TypeCoupon::all() as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- جدول الحركات --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">سجل حركات المخزن</h5>
        </div>
        <div class="card-body" id="filtered-table">
            @include('warehouses.partials.stock_movements_table', [
                'stockMovements' => $warehouse->stockMovements,
                'totalIn' => $totalIn ?? 0,
                'totalOut' => $totalOut ?? 0,
                'remaining' => $remaining ?? 0,
                'typeName' => $typeName ?? null
            ])
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const itemName = $(this).data('item') ?? 'هذا الطرد';
        Swal.fire({
            title: 'تأكيد الحذف',
            text: `هل أنت متأكد أنك تريد حذف ${itemName}؟ لا يمكنك التراجع بعد ذلك.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        runFilter();
    });

    $('#typeCouponFilter').on('change', function() {
        runFilter();
    });

    function runFilter() {
        const warehouseId = "{{ $warehouse->id }}";
        const activeType = $('.filter-btn.active').data('type') ?? 'all';
        const type_coupon_id = $('#typeCouponFilter').val() ?? 'all';

        $.ajax({
            url: `/warehouses/${warehouseId}/stock/filter`,
            type: 'GET',
            data: {
                type: activeType,
                type_coupon_id: type_coupon_id
            },
            beforeSend: function() {
                $('#filtered-table').html('<p class="text-center">جاري التحميل...</p>');
            },
            success: function(data) {
                $('#filtered-table').html(data);
            },
            error: function() {
                Swal.fire('خطأ!', 'حدث خطأ أثناء جلب البيانات', 'error');
            }
        });
    }
});
</script>
@endpush
