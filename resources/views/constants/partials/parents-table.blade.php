@if($parents->count() > 0)
<table class="table table-bordered text-center align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>الوصف</th>
            <th>الحالة</th>
            <th>العمليات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($parents as $parent)
            <tr>
                <td>{{ $parent->id }}</td>
                <td>{{ $parent->name }}</td>
                <td>{{ $parent->description ?? '-' }}</td>
                <td>
                    @if($parent->status)
                        <span class="badge bg-success">فعال</span>
                    @else
                        <span class="badge bg-danger">غير فعال</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-primary btn-edit-constant" data-id="{{ $parent->id }}">تعديل</button>
                    <button class="btn btn-sm btn-danger btn-delete-constant" data-id="{{ $parent->id }}">حذف</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-warning text-center">لا توجد تصنيفات رئيسية.</div>
@endif
