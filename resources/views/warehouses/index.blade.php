@extends('layouts.main')

@section('title', 'المخازن')

@section('content')
<div class="card">
     <!--begin::Card header-->
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-0">المخازن</h5>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end">
                    @if (IsPermissionBtn(1))
                    <a href="{{ route('warehouses.create') }}" class="btn btn-primary me-2">
                        <i class="menu-icon tf-icons ti ti-plus"></i>إضافة المخزن</a>
                    @endif
                </div>
            </div>
        </div>
        <!--end::Card header-->
    {{-- أزرار أعلى الجدول --}}
    {{-- الجدول --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="warehouses-table">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>اسم المخزن</th>
                        <th>الموقع</th>
                        <th>تاريخ الإضافة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warehouses as $warehouse)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $warehouse->name }}</td>
                        <td>{{ $warehouse->location ?? '-' }}</td>
                        <td>{{ $warehouse->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('warehouses.show', $warehouse->id) }}"
                                class="btn btn-sm btn-info">عرض</a>
                            <a href="{{ route('warehouses.edit', $warehouse->id) }}"
                                class="btn btn-sm btn-warning">تعديل</a>

                            <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST"
                                style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">لا يوجد مخازن حالياً.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#warehouses-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
            }
        });
    });
</script>
@endsection
