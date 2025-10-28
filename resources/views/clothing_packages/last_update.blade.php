@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">أخر حركات تفعيل وإلغاء</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
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
                            <tbody>
                                @forelse ($items as $item)
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
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>


</div>

@endsection
@push('scripts')
<script>

</script>
@endpush
