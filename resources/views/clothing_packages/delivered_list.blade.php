@extends('layouts.main')

@section('title', 'قائمة المستلمين حسب الفلاتر')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">قائمة المستلمين (حسب نتائج البحث)</h3>

        <form action="{{ route('clothing.export_delivered') }}" method="GET">
            <input type="hidden" name="project_id" value="{{ request('project_id') }}">
            <input type="hidden" name="place" value="{{ request('place') }}">
            <input type="hidden" name="due_date" value="{{ request('due_date') }}">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> تحميل ملف Excel
            </button>
        </form>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>رقم الهوية</th>
                <th>عدد الأطفال</th>
                <th>المبلغ</th>
                <th>اسم المشروع</th>
                <th>مكان التسليم</th>
                <th>تاريخ الاستحقاق</th>
                <th>تاريخ الاستلام</th>
                <th>ملاحظات</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @forelse ($delivered as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->id_num }}</td>
                    <td>{{ $item->children_count }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ optional($item->project)->name }}</td>
                    <td>{{ optional($item->distributionPlace)->name }}</td>
                    <td>{{ $item->due_date }}</td>
                    <td>{{ $item->receipt_date }}</td>
                    <td>{{ $item->notes }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-danger">لا يوجد مستلمين ضمن هذه الفلاتر.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
