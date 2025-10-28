@extends('layouts.main')
@section('title', 'المستخدمين')

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
            <h5 class="card-title mb-0">المستخدمين</h5>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end">
                    @if (IsPermissionBtn(1))
                    <button class="btn btn-primary" type="button" onclick="clearField()">
                        <i class="menu-icon tf-icons ti ti-user-plus"></i>
                        إضافة مستخدم
                    </button>
                    @endif
                </div>

                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete
                        Selected</button>
                </div>
                <!--end::Group actions-->
                <!--begin::Modal - Add user-->
                <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_add_user_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">إضافة المستخدم</h2>
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
                                <form id="add_user_form" class="form">
                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                        data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">رقم الهوية (اسم المستخدم)</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" name="p_id_no" maxLength="9"
                                                oninput="this.value=this.value.slice(0,this.maxLength)"
                                                class="form-control form-control-solid mb-3 mb-lg-0" id="p_id_no" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">الاسم </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name"
                                                class="form-control form-control-solid mb-3 mb-lg-0" id="name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7" data-kt-password-meter="true">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">كلمة المرور</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-lg form-control-solid"
                                                    type="password" id="password" name="password" autocomplete="off" />
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                    data-kt-password-meter-control="visibility">
                                                    <i class="bi bi-eye-slash fs-2"></i>
                                                    <i class="bi bi-eye fs-2 d-none"></i>
                                                </span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group=-->
                                        <div class="fv-row mb-10">
                                            <label class="form-label fw-bolder text-dark fs-6">تأكيد كلمة المرور</label>
                                            <input class="form-control form-control-lg form-control-solid" type="password"
                                                placeholder="" id="password_confirmation" name="password_confirmation"
                                                autocomplete="off" />
                                        </div>
                                        <!--end::Input group=-->
                                        <!--begin::Input group=-->
                                        <div class="fv-row mb-10">
                                            <label class="form-label fw-bolder text-dark fs-6">نوع المستخدم</label>
                                            <select id="type_user" data-control="select2" data-placeholder="اختر ..."
                                                class="form-select form-select-lg fw-bold mb-3 mb-lg-0">
                                                <option value="">اختر...</option>
                                                <option value="admin">مسؤول</option>
                                                <option value="user">مستخدم عادي</option>

                                            </select>
                                        </div>
                                        <!--end::Input group=-->
                                    </div>
                                    <!--end::Scroll-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <button type="button" id="kt_new_password_submit"
                                            class="btn btn-lg btn-primary fw-bolder">
                                            <span class="indicator-label ">حفظ</span>
                                            <span class="indicator-progress d-none">الرجاء الانتظار...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
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
                <!--end::Modal - Add task-->
                <!--begin::Modal - update user-->
                <div class="modal fade" id="kt_modal_update_user" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_update_user_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">تعديل بيانات المستخدم</h2>
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
                                <form id="update_user_form" class="form">
                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_user_scroll"
                                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                        data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                                        <input type="hidden" name="u_id_user" id="u_id_user" />
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">رقم الهوية (اسم المستخدم)</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" name="u_id_no" maxLength="9"
                                                oninput="this.value=this.value.slice(0,this.maxLength)"
                                                class="form-control form-control-solid mb-3 mb-lg-0" id="u_id_no" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">الاسم </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="u_name"
                                                class="form-control form-control-solid mb-3 mb-lg-0" id="u_name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <label class="form-label fw-bolder text-dark fs-6">نوع المستخدم</label>
                                            <select id="u_type_user" data-control="select2" data-placeholder="اختر ..."
                                                class="form-select form-select-lg fw-bold mb-3 mb-lg-0">
                                                <option value="">اختر...</option>
                                                <option value="admin">مسؤول</option>
                                                <option value="user">مستخدم عادي</option>
                                            </select>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Scroll-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <button type="button" id="kt_update_user_submit" onclick="updateUser()"
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
                <!--end::Modal - update user-->
                <!--begin::Modal - change password-->
                <div class="modal fade" id="kt_modal_change_password" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_change_password_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">تغيير كلمة المرور</h2>
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
                                <form id="update_password_form" class="form">
                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                        id="kt_modal_change_password_scroll" data-kt-scroll="true"
                                        data-kt-scroll-activate="{default: false, lg: true}"
                                        data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_change_password_header"
                                        data-kt-scroll-wrappers="#kt_modal_change_password_scroll"
                                        data-kt-scroll-offset="300px">
                                        <input type="hidden" name="pass_id_user" id="pass_id_user" />
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7" data-kt-password-meter="true">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">كلمة المرور</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-lg form-control-solid"
                                                    type="password" id="pass_password" name="pass_password"
                                                    autocomplete="off" />
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                    data-kt-password-meter-control="visibility">
                                                    <i class="bi bi-eye-slash fs-2"></i>
                                                    <i class="bi bi-eye fs-2 d-none"></i>
                                                </span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group=-->
                                        <div class="fv-row mb-10">
                                            <label class="form-label fw-bolder text-dark fs-6">تأكيد كلمة المرور</label>
                                            <input class="form-control form-control-lg form-control-solid" type="password"
                                                placeholder="" id="pass_password_confirmation"
                                                name="pass_password_confirmation" autocomplete="off" />
                                        </div>
                                        <!--end::Input group=-->
                                        {{-- <div class="fv-row mb-10">
                                            <label class="form-label fw-bolder text-dark fs-6">نوع المستخدم</label>
                                            <select id="pass_type_user" data-control="select2"
                                                data-placeholder="اختر ..."
                                                class="form-select form-select-lg fw-bold mb-3 mb-lg-0">
                                                <option value="">اختر...</option>
                                                <option value="admin">مسؤول</option>
                                                <option value="user">مستخدم عادي</option>

                                            </select>
                                        </div> --}}
                                        <!--begin::Input group-->
                                    </div>
                                    <!--end::Scroll-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <button type="button" onclick="ChangePassword()"
                                            class="btn btn-lg btn-primary fw-bolder">
                                            <span class="indicator-label">حفظ</span>
                                            <span class="indicator-progress d-none">الرجاء الانتظار...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
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
                <!--end::Modal - change password-->
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="users_tb">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">#</th>
                        <th class="min-w-125px">اسم المستخدم</th>
                        <th class="min-w-125px">الاسم</th>
                        <th class="min-w-125px">تاريخ الإدخال</th>
                        <th class="min-w-125px">نوع المستخدم</th>
                        <th class="text-end min-w-100px">الإجراءات</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="text-gray-600 fw-bold">
                    <!--begin::Table row-->
                    @foreach ($users as $user)
                        <tr>
                            <!--begin::User=-->
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $user->id_no }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->type_user == 'admin' ? 'مسؤول' : 'مستخدم عادي' }}</td>

                            <!--begin::Action=-->
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        الإجراءات

                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"
                                                onclick="getDataUser({{ $user->id }},'{{ $user->id_no }}','{{ $user->name }}','{{ $user->type_user }}')">تعديل</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#"
                                                onclick="ShowChangePassword({{ $user->id }},'{{ $user->id_no }}','{{ $user->type_user }}')">تغيير
                                                كلمة المرور</a></li>
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
            form = document.querySelector('#add_user_form');
            submitButton = document.querySelector('#kt_new_password_submit');

            handleForm();
            datatable = $('#users_tb').DataTable();
            $('#search').on('keyup', function(e) {
                datatable.search(e.target.value).draw();
            });

            // Add real-time validation feedback
            $('#p_id_no, #name , #password, #password_confirmation, #type_user').on('input', function() {
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
                var idNo = $('#p_id_no').val();
                if (!idNo) {
                    $('#p_id_no').addClass('is-invalid');
                    errorMessages.push('رقم الهوية مطلوب');
                    isValid = false;
                } else if (!/^\d{9}$/.test(idNo)) {
                    $('#p_id_no').addClass('is-invalid');
                    errorMessages.push('رقم الهوية يجب أن يكون 9 أرقام');
                    isValid = false;
                }

                // Validate Password
                var password = $('#password').val();
                if (!password) {
                    $('#password').addClass('is-invalid');
                    errorMessages.push('كلمة المرور مطلوبة');
                    isValid = false;
                } else if (password.length < 6) {
                    $('#password').addClass('is-invalid');
                    errorMessages.push('كلمة المرور يجب أن تكون 6 أحرف على الأقل');
                    isValid = false;
                }

                // name
                var name = $('#name').val();
                if (!name) {
                    $('#name').addClass('is-invalid');
                    errorMessages.push('الاسم مطلوب');
                    isValid = false;
                } else if (name.length < 2) {
                    $('#name').addClass('is-invalid');
                    errorMessages.push('الاسم يجب أن يكون حرفين على الأقل');
                    isValid = false;
                }

                // Validate Password Confirmation
                var passwordConfirmation = $('#password_confirmation').val();
                if (!passwordConfirmation) {
                    $('#password_confirmation').addClass('is-invalid');
                    errorMessages.push('تأكيد كلمة المرور مطلوب');
                    isValid = false;
                } else if (password !== passwordConfirmation) {
                    $('#password_confirmation').addClass('is-invalid');
                    errorMessages.push('كلمة المرور وتأكيدها غير متطابقين');
                    isValid = false;
                }

                // Validate User Type
                var typeUser = $('#type_user').val();
                if (!typeUser) {
                    $('#type_user').addClass('is-invalid');
                    errorMessages.push('نوع المستخدم مطلوب');
                    isValid = false;
                }

                if (isValid) {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    // Call the insert function
                    insert_new_user();
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

        function insert_new_user() {
            const id_no = $('#p_id_no').val();
            const name = $('#name').val();
            const password = $('#password').val();
            const password_confirmation = $('#password_confirmation').val();
            const type_user = $('#type_user').val();

            var url = "{{ route('user.insert_user') }}";
            toggle_loading();
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    'password': password,
                    'name': name,
                    'password_confirmation': password_confirmation,
                    'id_no': id_no,
                    'type_user': type_user
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        if (response.success == 1) {
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
                                confirmButtonText: 'Ok'
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
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire({
                        title: 'خطأ في الاتصال !',
                        text: 'حدث خطأ أثناء الاتصال بالخادم',
                        icon: 'error',
                        confirmButtonText: 'Ok'
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
            $('#add_user_form')[0].reset();
            $('#p_id_no').val('');
            $('.is-invalid').removeClass('is-invalid');
            $('.error-message').remove();
            $('#kt_modal_add_user').modal('show');
        }

        function getDataUser(id, id_no, name, type_user) {
            $('#u_id_user').val(id);
            $('#u_id_no').val(id_no);
            $('#u_name').val(name);
            $('#u_type_user').val(type_user).trigger('change');
            $('#kt_modal_update_user').modal('show');
        }

        function updateUser() {
            var u_id_user = $('#u_id_user').val();
            var id_no = $('#u_id_no').val();
            var name = $('#u_name').val();
            var type_user = $('#u_type_user').val();
            //    var status = $('#u_status').is(":checked");
            if (status) {
                status = 1;
            } else {
                status = 0;
            }
            var url = "{{ route('user.update') }}";
            var updateBtn = $('#kt_update_user_submit');
            updateBtn.prop('disabled', true);
            toggle_loading();
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: { //'status':status,
                    'id_no': id_no,
                    'id_user': u_id_user,
                    'name': name,
                    'type_user': type_user
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        if (response.success == 1) {
                            Swal.fire({
                                title: 'تمت العملية بنجاح !',
                                text: response.results.message,
                                icon: "success",
                                confirmButtonText: 'موافق'
                            });
                            $('#kt_modal_update_user').modal('hide');
                            location.reload();
                        } else {
                            Swal.fire({
                                title: 'خطأ !',
                                text: response.results.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
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
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire({
                        title: 'خطأ في الاتصال !',
                        text: 'حدث خطأ أثناء الاتصال بالخادم',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                },
                complete: function() {
                    toggle_loading();
                    updateBtn.prop('disabled', false);
                }
            });
        }

        function ShowChangePassword(id, name, type_user) {
            $('#pass_id_user').val(id);
            // $('#pass_type_user').val(type_user).trigger('change');
            $('#kt_modal_change_password').modal('show');
        }

        function ChangePassword() {
            var u_id_user = $('#pass_id_user').val();
            var pass_password = $('#pass_password').val();
            var pass_password_confirmation = $('#pass_password_confirmation').val();
            // var pass_type_user = $('#pass_type_user').val();

            var url = "{{ route('user.update_password') }}";
            var passBtn = $('#kt_modal_change_password .btn-primary');
            passBtn.prop('disabled', true);
            toggle_loading();
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    'id_user': u_id_user,
                    'password': pass_password,
                    'password_confirmation': pass_password_confirmation,
                    // 'type_user': pass_type_user
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        if (response.success == 1) {
                            Swal.fire({
                                title: 'تمت العملية بنجاح !',
                                text: response.results.message,
                                icon: "success",
                                confirmButtonText: 'موافق'
                            });
                            $('#kt_modal_change_password').modal('hide');
                        } else {
                            Swal.fire({
                                title: 'خطأ !',
                                text: response.results.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
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
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire({
                        title: 'خطأ في الاتصال !',
                        text: 'حدث خطأ أثناء الاتصال بالخادم',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                },
                complete: function() {
                    toggle_loading();
                    passBtn.prop('disabled', false);
                }
            });
        }
    </script>
@endpush
