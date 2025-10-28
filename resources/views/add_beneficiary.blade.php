@extends('layouts.main')
@section('title', 'إضافة مستفيد جديد')

@section('content')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <form action="#" id="beneficiary_form">
        <!--begin::Card-->
        <div class="card mb-7">
            <div class="card-header">

                <h3 class="card-title">إضافة مستفيد جديد</h3>
            </div>
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Compact form-->
                <div class="d-flex align-items-center">

                    <!--begin::Label-->
                    <label class="col-lg-1 col-form-label required fw-bold fs-6">رقم هوية
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-3">
                        <!--begin::Col-->
                        <input type="number" name="P_ID_NO" id="P_ID_NO" maxLength="9"
                            oninput="this.value=this.value.slice(0,this.maxLength)"
                            class="form-control form-control-lg mb-3 mb-lg-0">
                        <!--end::Col-->
                    </div>
                    <label class="col-lg-2 col-form-label required fw-bold fs-6">الإسم رباعي</label>
                    <div class="col-lg-4 fv-row">
                        <input type="text" name="P_FULL_NAME" id="P_FULL_NAME"
                            class="form-control form-control-lg mb-3 mb-lg-0">
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <!--begin::Label-->
                    <label class="col-lg-1 col-form-label required fw-bold fs-6">نوع الطرد
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-3">
                        <!--begin::Col-->
                        <select id="P_COUPON_NO" data-control="select2" data-placeholder="اختر ..."
                            class="form-select form-select-lg fw-bold mb-3 mb-lg-0">
                            <option value="">اختر...</option>
                            @foreach ($coupons as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <!--end::Col-->
                    </div>
                    <label class="col-lg-2 col-form-label required fw-bold fs-6">تاريخ الاستحقاق</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control text-center form-control-lg mb-3" id="P_DUE_DATE"
                            name="P_DUE_DATE">

                    </div>
                    <label class="col-lg-2 col-form-label required fw-bold fs-6">تاريخ التسليم</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control text-center form-control-lg mb-3" id="P_RECEIPT_DATE"
                            name="P_RECEIPT_DATE">

                    </div>
                </div>
                <div class="float-end">

                    <button type="button" class="btn btn-primary me-5" onclick="save_beneficiary_info();">حفظ</button>


                    <button type="button" class="btn btn-outline-dark me-5" onclick="clear_form();">جديد</button>

                </div>
            </div>
        </div>
    </form>






@endsection
@push('scripts')
    <script>
        $("#P_DUE_DATE").flatpickr({
            dateFormat: "Y-m-d",
            minDate: new Date(),
        });

        function save_beneficiary_info() {

            var id_num = $('#P_ID_NO').val();
            var name = $('#P_FULL_NAME').val();
            var type_coupon_id = $('#P_COUPON_NO').val();
            var due_date = $('#P_DUE_DATE').val();
            var receipt_date = $('#P_RECEIPT_DATE').val();

            var url = "{{ route('save_beneficiary_info') }}";
            $.ajax({
                url: url,
                type: 'json',
                method: 'post',
                data: {
                    'id_num': id_num,
                    'name': name,
                    'type_coupon_id': type_coupon_id,
                    'due_date': due_date,
                    'receipt_date':receipt_date,


                },
            }).done(function(response) {
                console.log(response);
                if (response.success) {
                    if (response.success == 1) {
                        Swal.fire({
                            title: 'تمت إضافة المستفيد بنجاح !',
                            text: response.results.message,
                            icon: "success",
                            confirmButtonText: 'موافق'
                        });

                        //clear_form();

                    } else {

                        toastr["error"](response.results.message);
                    }
                } else {
                    console.log(response);

                    Swal.fire({
                        title: 'يوجد خطأ في عملية الإدخال !',
                        text: response.errors,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }
    </script>
@endpush
