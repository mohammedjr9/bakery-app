@extends('layouts.main')
@section('title', 'الأزرار')

@section('content')
    <!-- Add CSRF token meta tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* تنسيقات قائمة الإجراءات */
        .dropdown-menu {
            min-width: 150px;
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            color: #5a5c69;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
        }

        .dropdown-item:hover {
            background-color: #eaecf4;
            color: #2e2f37;
        }

        .dropdown-item:active {
            background-color: #d1d3e2;
            color: #2e2f37;
        }
    </style>

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-0">الأزرار</h5>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end">
                    @if (IsPermissionBtn(2))
                    <button class="btn btn-primary" type="button" onclick="clearField()">
                        <i class="menu-icon tf-icons fa-solid fa-square-plus"></i>
                        إضافة زر
                    </button>
                    @endif
                </div>

                <div class="d-flex justify-content-end align-items-center d-none" data-kt-role-page-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-role-page-table-select="selected_count"></span>Selected
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-role-page-table-select="delete_selected">Delete
                        Selected</button>
                </div>
                <!--end::Group actions-->
                <!--begin::Modal - Add role_btn-->
                <div class="modal fade" id="kt_modal_add_role_btn" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_add_role_btn_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">إضافة زر</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                                rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                transform="rotate(45 7.41422 6)" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="add_role_btn_form" class="form">
                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_btn_scroll"
                                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                        data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_add_role_btn_header"
                                        data-kt-scroll-wrappers="#kt_modal_add_role_btn_scroll" data-kt-scroll-offset="300px">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">اسم الزر</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name"
                                                class="form-control form-control-solid mb-3 mb-lg-0" id="name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group=-->
                                        <div class="fv-row mb-10">
                                            <label class="form-label fw-bolder text-dark fs-6"> تابع لشاشة</label>
                                            <select id="follow_to_page" data-control="select2" data-placeholder="اختر ..."
                                                class="form-select form-select-lg fw-bold mb-3 mb-lg-0">
                                                <option value="" disabled selected>اختر...</option>
                                                @foreach ($role_pages as $role_page)
                                                    <option value="{{ $role_page->id }}">{{ $role_page->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input group=-->
                                           <!--begin::Input group-->
                                           <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">ملاحظات </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea name="notes" class="form-control form-control-solid mb-3 mb-lg-0" id="notes"></textarea>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Scroll-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <button type="button" id="kt_new_role_btn_submit"
                                            class="btn btn-lg btn-primary fw-bolder">
                                            <span class="indicator-label ">حفظ</span>
                                            <span class="indicator-progress d-none">الرجاء الانتظار...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - Add task-->
                <!--begin::Modal - update role_btn-->
                <div class="modal fade" id="kt_modal_update_role_btn" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_update_role_btn_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">تعديل بيانات الزر</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                                rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                transform="rotate(45 7.41422 6)" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="update_role_btn_form" class="form">
                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_btn_scroll"
                                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                        data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_add_role_btn_header"
                                        data-kt-scroll-wrappers="#kt_modal_add_role_btn_scroll" data-kt-scroll-offset="300px">
                                        <input type="hidden" name="u_id_role_btn" id="u_id_role_btn" />
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">اسم الزر</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="u_name"
                                                class="form-control form-control-solid mb-3 mb-lg-0" id="u_name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <label class="form-label fw-bolder text-dark fs-6"> تابع لشاشة</label>
                                            <select id="u_follow_to_page" data-control="select2" data-placeholder="اختر ..."
                                                class="form-select form-select-lg fw-bold mb-3 mb-lg-0">
                                                <option value="" disabled selected>اختر...</option>
                                                @foreach ($role_pages as $role_page)
                                                    <option value="{{ $role_page->id }}">{{ $role_page->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">ملاحظات </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea name="u_notes" class="form-control form-control-solid mb-3 mb-lg-0" id="u_notes"></textarea>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Scroll-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <button type="button" id="kt_update_role_btn_submit" onclick="updateRoleBtn()"
                                            class="btn btn-lg btn-primary fw-bolder">
                                            <span class="indicator-label">حفظ</span>
                                            <span class="indicator-progress d-none">الرجاء الانتظار...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">إغلاق</button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - update role_btn-->
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="role_btns_tb">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">#</th>
                        <th class="min-w-125px">اسم الزر</th>
                        <th class="min-w-125px"> تابع لشاشة</th>
                        <th class="min-w-125px">ملاحظات</th>
                        <th class="min-w-125px">تاريخ الإدخال</th>
                        <th class="text-end min-w-100px">الإجراءات</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="text-gray-600 fw-bold">
                    <!--begin::Table row-->
                    @foreach ($role_btns as $role_btn)
                        <tr>
                            <!--begin::role_btn=-->
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $role_btn->name }}</td>
                            <td>{{ $role_btn->FollowToPage->name }}</td>
                            <td>{{ $role_btn->notes }}</td>
                            <td>{{ $role_btn->created_at }}</td>

                            <!--begin::Action=-->
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        الإجراءات

                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"
                                                onclick="getDataRoleBtn({{ $role_btn->id }},'{{ $role_btn->name }}','{{ $role_btn->notes }}','{{ $role_btn->follow_to_page }}')">تعديل</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <!--end::Action=-->
                        </tr>
                    @endforeach
                    <!--end::Table row-->
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection
@push('scripts')
    <script>


        var datatable;
        var form;
        var submitButton;


        $(document).ready(function() {
            form = document.querySelector('#add_role_btn_form');
            submitButton = document.querySelector('#kt_new_role_btn_submit');

            handleForm();
            datatable = $('#role_btns_tb').DataTable();
            $('#search').on('keyup', function(e) {
                datatable.search(e.target.value).draw();
            });

            // Add real-time validation feedback
            $('#name , #notes, #follow_to_page').on('input', function() {
                $(this).removeClass('is-invalid');
            });

            // إغلاق قوائم الإجراءات عند النقر خارجها
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });

            // إغلاق قائمة الإجراءات عند النقر على أي عنصر فيها
            $('.dropdown-item').on('click', function() {
                $(this).closest('.dropdown-menu').removeClass('show');
            });
        });

        var handleForm = function(e) {
            // Simple jQuery validation instead of FormValidation
            submitButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Clear previous error messages
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');

                var isValid = true;
                var errorMessages = [];

                // Validate ID Number
                var name = $('#name').val();
                if (!name) {
                    $('#name').addClass('is-invalid');
                    errorMessages.push('اسم الزر مطلوب');
                    isValid = false;
                }
                var notes = $('#notes').val();
                if (!notes) {
                    $('#notes').addClass('is-invalid');
                    errorMessages.push('الملاحظات مطلوبة');
                    isValid = false;
                }
                var follow_to_page = $('#follow_to_page').val();
                if (!follow_to_page) {
                    $('#follow_to_page').addClass('is-invalid');
                    errorMessages.push('يجب ان تختار شاشة');
                    isValid = false;
                }

                if (isValid) {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    // Call the insert function
                    insert_new_role_btn();
                } else {
                    // Show error popup
                    Swal.fire({
                        text: errorMessages.join('\n'),
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "حسناً، فهمت!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        }

        function toggle_loading() {
            $('.indicator-label').toggleClass('d-none');
            $('.indicator-progress').toggleClass('d-none');
        }

        function insert_new_role_btn() {
            const name = $('#name').val();
            const notes = $('#notes').val();
            const follow_to_page = $('#follow_to_page').val();

            var submit_url = "{{ route('role_btn.insert_role_btn') }}";
            toggle_loading();
            $.ajax({
                url: submit_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    'name': name,
                    'notes': notes,
                    'follow_to_page': follow_to_page
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        if (response.success == 1) {
                            $('#kt_modal_add_role_btn').modal('hide');
                            Swal.fire({
                                title: 'تمت العملية بنجاح !',
                                text: response.results.message,
                                icon: "success",
                                confirmButtonText: 'موافق'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'خطأ !',
                                text: response.results.message,
                                icon: 'error',
                                confirmButtonText: 'موافق'
                            });
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
                            title: 'خطأ !',
                            text: $message,
                            icon: 'error',
                            confirmButtonText: 'موافق'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire({
                        title: 'خطأ في الاتصال !',
                        text: 'حدث خطأ أثناء الاتصال بالخادم',
                        icon: 'error',
                        confirmButtonText: 'موافق'
                    });
                },
                complete: function() {
                    toggle_loading();
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            });
        }

        function clearField() {
            $('#add_role_btn_form')[0].reset();
            $('#name').val('');
            $('#notes').val('');
            $('#follow_to_page').val('');
            $('.is-invalid').removeClass('is-invalid');
            $('.error-message').remove();
            $('#kt_modal_add_role_btn').modal('show');
        }

        function getDataRoleBtn(id, name, notes, follow_to_page) {
            $('#u_id_role_btn').val(id);
            $('#u_name').val(name);
            $('#u_notes').val(notes);
            $('#u_follow_to_page').val(follow_to_page).trigger('change');
            $('#kt_modal_update_role_btn').modal('show');
        }

        function updateRoleBtn() {
            var u_id_role_btn = $('#u_id_role_btn').val();
            var name = $('#u_name').val();
            var notes = $('#u_notes').val();
            var follow_to_page = $('#u_follow_to_page').val();
            var submit_url = "{{ route('role_btn.update_role_btn') }}";
            var updateBtn = $('#kt_update_role_btn_submit');
            updateBtn.prop('disabled', true);
            toggle_loading();
            $.ajax({
                url: submit_url,
                type: 'POST',
                dataType: 'json',
                data: { //'status':status,
                    'id': u_id_role_btn,
                    'name': name,
                    'notes': notes,
                    'follow_to_page': follow_to_page
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        if (response.success == 1) {
                            $('#kt_modal_update_role_btn').modal('hide');
                            Swal.fire({
                                title: 'تمت العملية بنجاح !',
                                text: response.results.message,
                                icon: "success",
                                confirmButtonText: 'موافق'
                            });

                            location.reload();
                        } else {
                            Swal.fire({
                                title: 'خطأ !',
                                text: response.results.message,
                                icon: 'error',
                                confirmButtonText: 'موافق'
                            });
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
                            title: 'خطأ !',
                            text: $message,
                            icon: 'error',
                            confirmButtonText: 'موافق'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire({
                        title: 'خطأ في الاتصال !',
                        text: 'حدث خطأ أثناء الاتصال بالخادم',
                        icon: 'error',
                        confirmButtonText: 'موافق'
                    });
                },
                complete: function() {
                    toggle_loading();
                    updateBtn.prop('disabled', false);
                }
            });
        }
    </script>
@endpush
