@if(isset($results) && count($results))
<div class="table-responsive">
    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>تاريخ الاستحقاق</th>
                <th>تاريخ التسليم</th>
                <th>عدد الاشخاص</th>
                <th>اسم المشروع</th>
                <th>عدد المستلمين</th>
                <th>غير المستلمين</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $row)
            <tr>
                <td>{{ $row->due_date }}</td>
                <td>{{ $row->receipt_date }}</td>
                <td>{{ $row->total_people }}</td>
                <td>{{ $row->project_name }}</td>
                <td>{{ $row->delivered }}</td>
                <td>{{ $row->not_delivered }}</td>
            </tr>
            @endforeach
            <tr class="table-secondary fw-bold">
                <td colspan="2">الإجمالي</td>
                <td>{{ $sum_people }}</td>
                <td></td>
                <td>{{ $sum_delivered }}</td>
                <td>{{ $sum_not_delivered }}</td>
            </tr>
        </tbody>

    </table>
</div>
@else
<div class="alert alert-warning">لا توجد نتائج لهذه الفلاتر.</div>
@endif
