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
                                    <th>رقم المستفيد</th>
                                    <th>اسم المستفيد</th>
                                    <th>تاريخ الاستحقاق</th>
                                    <th>تاريخ الاستلام</th>
                                    <th>نوع الحركة</th>
                                    <th>تاريخ الحركة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($receipts as $item)
                                <tr>
                                    <td>{{$item->Beneficiary->code_num}}</td>
                                    <td>{{$item->Beneficiary->name}}</td>
                                    <td>{{$item->due_date}}</td>
                                    <td>{{$item->receipt_date}}</td>
                                    <td>@if ($item->receipt_date)
                                            تسليم
                                        @else
                                            إلغاء تسليم
                                        @endif
                                    </td>
                                    <td>{{$item->updated_at}}</td>
                                </tr>
                                @endforeach
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
    var Toast;
    $(function () {
        $('#formSearch').submit(function(e) {
            e.preventDefault();
            setChecked();
        });

         Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000
            });
        });

    function getBeneficiaries() {
        var datatable;
        var s_num_code = $('#s_num_code').val();
        var s_name= $('#s_name').val();
        var url = "{{route('result_search')}}";

        $.ajax({
            url: url,
            type:'text',
            method: 'get',
            data: {'s_num_code' : s_num_code,'s_name' : s_name },
        }).done(function (response) {
            $('#resultDiv').html(response);
        });

}
function setChecked()
{
    var s_num_code = $('#s_num_code').val();
    if(s_num_code.length > 3){
        checked(s_num_code);
    }else{
        Toast.fire({
            icon: 'error',
            title: 'أدخل رقم صحيح'
        });
    }

}
function checked(b_id)
{
    let url = "{{ route('change_status') }}";
    $.ajax({
        url: url,
        type: "POST",
        data:{
            "_token": "{{ csrf_token() }}",
            b_id:b_id,
        },
        success: function(response) {
            console.log(response);
            if(response.status != 'fail'){
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
            }else{
                Toast.fire({
                    icon: 'error',
                    title: response.message
                });
            }

        },
        error: function(response) {
            Toast.fire({
                icon: 'error',
                title: response.message
            });
            console.log(response);
        },
    });
}
function CancelReceipt(receipt_id,num_code)
{
    if(receipt_id){
        let url = "{{ route('cancel_receipt') }}";
        $.ajax({
            url: url,
            type: "POST",
            data:{
                "_token": "{{ csrf_token() }}",
                receipt_id:receipt_id,num_code:num_code
            },
            success: function(response) {
                console.log(response);
                if(response.status != 'fail'){
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }

            },
            error: function(response) {
                Toast.fire({
                    icon: 'error',
                    title: response.message
                });
                console.log(response);
            },
        });
    }
}
</script>
@endpush
