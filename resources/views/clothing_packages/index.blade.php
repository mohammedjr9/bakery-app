@extends('layouts.main')
@section('content')
<div id="laravel-alert-placeholder"></div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">بحث عن مستلمي كسوة </h3>
                <div class="card-tools">
                    <a class="btn btn-info" href="{{ route('clothing.report') }}" target="_blank">الإحصائيات</a>
                    <a class="btn btn-info" href="{{ route('clothing.last_update') }}" target="_blank">أخر الحركات</a>
                    {{-- <a class="btn btn-info" href="{{ route('upload_clothing_excel') }}" target="_blank">استيراد ملف
                        كسوة</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <form id="formSearch">
                        <div class="row g-3 align-items-end">

                            <div class="col-md-3">
                                <label>رقم الكود</label>
                                <input type="text" id="s_code" name="s_code" class="form-control"
                                    value="{{ request('s_code') }}">
                            </div>

                            <div class="col-md-3">
                                <label>رقم الهوية</label>
                                <input type="text" id="s_id_no" name="s_id_no" class="form-control"
                                    value="{{ request('s_id_no') }}">
                            </div>

                            <div class="col-md-3">
                                <label>الاسم</label>
                                <input type="text" id="s_name" name="s_name" class="form-control"
                                    value="{{ request('s_name') }}">
                            </div>

                            <div class="col-md-3">
                                <label>المكان</label>
                                <select id="s_place" name="s_place" class="form-control">
                                    <option value="none">— اختر المكان —</option>

                                    <option value="">كل الأماكن</option>

                                    @foreach ($places as $id => $name)
                                    <option value="{{ $id }}" {{ request('s_place')==$id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-2 mt-2 d-grid">
                                <button type="button" class="btn btn-info btn-block"
                                    onclick="getBeneficiaries()">بحث</button>
                            </div>

                            <div class="col-md-2 mt-2 d-grid">
                                <button type="reset" class="btn btn-default btn-block">تفريغ</button>
                            </div>
                        </div>
                    </form>


                </div>
                <div id="resultDiv"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var Toast;
    $(function() {
    Toast = Swal.mixin({
        toast: true,
        position: 'top-start',
        showConfirmButton: false,
        timer: 3000
    });
});

function getBeneficiaries() {
    var s_code = $('#s_code').val();
    var s_id_no = $('#s_id_no').val();
    var s_name = $('#s_name').val();
    var s_place = $('#s_place').val();

    var url = "{{ route('clothing.result_search') }}";

    $.ajax({
        url: url,
        type: 'get',
        data: {
            's_code': s_code,
            's_id_no': s_id_no,
            's_name': s_name,
            's_place': s_place
        },
    }).done(function(response) {
        $('#resultDiv').html(response);
    });
}




    function setChecked() {
        var s_num_code = $('#s_num_code').val();
        if (s_num_code && s_num_code.length > 3) {
            checked(s_num_code);
        } else {
            Toast.fire({
                icon: 'error',
                title: 'أدخل رقم صحيح'
            });
        }
    }
function showLaravelStyleAlert(message, type = 'info') {
    let alertBox = `
        <div id="laravel-alert" class="alert alert-${type} alert-dismissible fade show text-center mt-3"
             role="alert" style="font-size: 16px; border-radius: 10px; background-color: #e9f5ff; color: #2c3e50; border: 1px solid #bee5eb;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    $('#laravel-alert').remove();
    $('#laravel-alert-placeholder').html(alertBox);

    setTimeout(() => {
        $('#laravel-alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}

function checked(b_id) {
    let url = "{{ route('clothing.change_status') }}";

    $.ajax({
        url: url,
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            b_id: b_id,
        },
        success: function(response) {
            if (response.status !== 'fail') {
                $('#receipt-date-' + b_id).html(response.date);
                $('#action-' + b_id).html('');
                showLaravelStyleAlert(response.message, 'success');
            } else {
                showLaravelStyleAlert(response.message, 'danger');
            }
        },
        error: function() {
            showLaravelStyleAlert('حدث خطأ أثناء الاتصال بالسيرفر.', 'danger');
        },
    });
}



</script>
@endpush
