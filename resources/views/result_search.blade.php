<div class="card">

    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>رقم الهوية</th>
                    <th>الاسم</th>
                    <th>نوع الطرد</th>
                    <th>تاريخ الاستحقاق</th>
                    <th>تاريخ التسليم</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Beneficiaries as $item)
                <tr>
                    <td>{{$item->id_num}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->types_coupons->name}}</td>
                    <td>{{$item->due_date}}</td>
                    <td>{{$item->receipt_date}}</td>
                    <td>
                        @if (!$item->receipt_date)
                            <button type="button" class="btn btn-info " onclick="checked({{$item->id}})">تسليم</button>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "searching": true,
            language: {
                url: "{{ asset('dist/ar.json') }}",
            },
        });
    });
</script>
@push('scripts')
<script>

</script>
@endpush
