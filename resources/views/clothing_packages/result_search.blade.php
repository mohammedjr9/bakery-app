<div class="card">

    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>رقم الكود</th>
                    <th>رقم الهوية</th>
                    <th>الاسم</th>
                    <th>عدد الأطفال</th>
                    <th>مكان التسليم</th>
                    <th>تاريخ الاستحقاق</th>
                    <th>تاريخ التسليم</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Beneficiaries as $item)
                <tr>
                    <td>{{ $item->code ?? '---' }}</td>
                    <td>{{ $item->id_num }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->children_count ?? '---' }}</td>
                    <td>{{ $item->distributionPlace->name ?? '---' }}</td>
                    <td>{{ $item->due_date }}</td>
                    <td id="receipt-date-{{ $item->id }}">
                        {{ $item->receipt_date }}
                    </td>
                    <td>
                        <span id="action-{{ $item->id }}">
                            @if (!$item->receipt_date)
                            <button type="button" class="btn btn-info btn-sm"
                                onclick="checked({{ $item->id }})">تسليم</button>
                            @endif
                        </span>
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
