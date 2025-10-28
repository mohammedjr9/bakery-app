@if($children->count() > 0)
<table class="table table-bordered text-center align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>التصنيف الرئيسي</th>
            <th>الوصف</th>
            <th>الحالة</th>
            <th>العمليات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($children as $child)
            <tr>
                <td>{{ $child->id }}</td>
                <td>{{ $child->name }}</td>
                <td>{{ $child->parent->name ?? '-' }}</td>
                <td>{{ $child->description ?? '-' }}</td>
                <td>
                    @if($child->status)
                        <span class="badge bg-success">فعال</span>
                    @else
                        <span class="badge bg-danger">غير فعال</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-primary btn-edit-constant" data-id="{{ $child->id }}">تعديل</button>
                    <button class="btn btn-sm btn-danger btn-delete-constant" data-id="{{ $child->id }}">حذف</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-warning text-center">لا توجد قيم تابعة حتى الآن.</div>
@endif
