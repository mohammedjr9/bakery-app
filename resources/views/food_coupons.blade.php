@extends('layouts.main')
@section('content')
<!-- Users List Table -->
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between">
        <h5 class="card-title mb-0">أنواع الطرود</h5>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                {{-- <a class="add-new btn btn-primary waves-effect waves-light" onclick="add_new_package();">
                    <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block"> إضافة
                        جديد</span>
                </a> --}}
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"
                    aria-controls="offcanvasEnd">إضافة بيانات طرد جديد</button>
            </div>
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table data-table" id="coupons_table">
            <thead class="border-top">
                <tr>
                    <th>#</th>
                    <th>نوع الطرد</th>
                    <th>الوصف</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Start Offcanvas -->
<!-- Offcanvas to add new user -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">إضافة بيانات طرد جديد<h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
        <form class="add-new-user pt-0" id="addNewUserForm" onsubmit="return false">
            <div class="mb-6">
                <label class="form-label" for="P_PACKAGE_NAME">اسم الطرد</label>
                <input type="text" class="form-control" id="P_PACKAGE_NAME"
                    name="P_PACKAGE_NAME" />
            </div>
            <div class="mb-6">
                <label class="form-label" for="P_PACKAGE_DETAILS">تفاصيل الطرد</label>
                <textarea id="P_PACKAGE_DETAILS" name="P_PACKAGE_DETAILS" rows="4" cols="66" class="form-control"></textarea>

            </div>
            <button type="button" class="btn btn-primary me-3 data-submit" onclick="insert_new_package();">Submit</button>
            <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>

<!-- / Content -->

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="CouponeModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة بيانات طرد جديد</h5>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="svg-icon svg-icon-2x">&times;</span>

                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <label class="col-form-label fw-bold col-lg-2">اسم الطرد</label>
                    <div class="col-lg-8">
                        <input id="P_PACKAGE_NAME" type="text" class="form-control form-control-solid ps-10" />
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-form-label fw-bold col-lg-2">تفاصيل الطرد</label>
                    <div class="col-lg-8">
                        <input id="P_PACKAGE_DETAILS" type="text" class="form-control form-control-solid ps-10" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" onclick="insert_new_package();">حفظ</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function() {

            get_coupons_data();
        });

        function add_new_package() {
            $('#CouponeModal').modal('show');
        }

        function insert_new_package() {
            var name = $('#P_PACKAGE_NAME').val();
            var description = $('#P_PACKAGE_DETAILS').val();

            var url = "{{ route('insert_food_package') }}";
            $.ajax({
                url: url,
                type: 'json',
                method: 'post',
                data: {
                    'name': name,
                    'description': description,
                },
            }).done(function(response) {
                console.log(response);
                if (response.success) {
                    if (response.success == 1) {
                        Swal.fire({
                            title: 'تمت عمليةالإضافة بنجاح !',
                            text: response.results.message,
                            icon: "success",
                            confirmButtonText: 'موافق'
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                get_coupons_data();
                                //   clear_form();
                                $('#P_PACKAGE_NAME').val('');
                                $('#P_PACKAGE_DETAILS').val('');

                            }
                        });

                    } else {

                        toastr["error"](response.results.message);
                    }
                } else {
                    console.log(response);
                    $message = "";
                    $.each(response.errors, function(key, value) {
                        console.log(value);
                        console.log(key);
                        $message += value.join('-') + "\r\n";
                    });
                    Swal.fire({
                        title: 'يوجد خطأ في عملية الإدخال !',
                        text: 'تأكد من البيانات المدخلة!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });

        }

        function get_coupons_data() {

            var url = "{{ route('getCouponsInfo') }}";
            console.log(1);
            $("#coupons_table").DataTable({

                destroy: true,
                processing: true,
                serverSide: false,
                ordering: false,
                ajax: {
                    url: url,
                    method: 'post',
                    data: {

                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                    ],
                },
                initComplete: function(result) {
                    if (result.json.success == false) {
                        Swal.fire({
                            title: 'خطأ !',
                            text: result.json.errors,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                }

            });

        }
</script>
@endpush
