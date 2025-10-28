@extends('layouts.main')
@section('title', 'منح الصلاحيات')

<style>
    .modern-dropdown {
        border-radius: 0.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.10);
        overflow: hidden;
        background: #fff;
        border: 1px solid #e3e6f0;
        margin-top: 2px;
        max-height: 260px;
        transition: box-shadow 0.2s;
    }

    .modern-dropdown .list-group-item {
        border: none;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background 0.15s;
    }

    .modern-dropdown .list-group-item:hover,
    .modern-dropdown .list-group-item.active {
        background: #f1f3f9;
        color: #1a1a2e;
    }
</style>

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        // Pass all role pages and buttons to JS
        window.allRolePages = @json($role_pages);
        // Pass permission toggle URLs to JS
        window.toggleRolePageUrl = "{{ route('permissions.toggle_role_page') }}";
        window.toggleRoleBtnUrl = "{{ route('permissions.toggle_role_btn') }}";
    </script>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center ">
            <h5 class="card-title mb-0">منح الصلاحيات</h5>
            <div class="w-50">
                <label for="user_search" class="form-label fw-bold mb-1">ابحث عن مستخدم</label>
                <div class="position-relative">
                    <input type="text" id="user_search" class="form-control" placeholder="ابحث عن مستخدم...">
                    <input type="hidden" id="user_id" name="user_id" />
                    <ul id="user_search_list" class="list-group position-absolute w-100 modern-dropdown"
                        style="z-index:1050; display:none;"></ul>
                </div>
            </div>
        </div>
        <div class="card-body py-4" id="permissions-area">
            <div id="role-pages-list">
                <div class="text-center text-muted">يرجى اختيار مستخدم لعرض الصلاحيات</div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let searchTimeout = null;
        let lastSearchTerm = '';
        let lastSearchResults = [];

        function highlightMatch(name, val) {
            if (!val) return name;
            const regex = new RegExp('(' + val.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'ig');
            return name.replace(regex, '<span class="text-primary fw-bold">$1</span>');
        }

        function showUserSearchList(users, val) {


            let html = '';
            users.forEach(u => {

                let name = highlightMatch(u.name, val);
                html +=
                    `<li class="list-group-item list-group-item-action d-flex align-items-center" data-id="${u.id}" data-name="${u.name}"><span class='me-2 text-muted small'>ID: ${u.id}</span><span>${name}</span></li>`;
            });
            if (html) {
                $('#user_search_list').html(html).show();
            } else {
                $('#user_search_list').hide();
            }
        }

        $('#user_search').on('input', function() {
            const val = $(this).val().trim();
            if (searchTimeout) clearTimeout(searchTimeout);
            if (!val) {
                $('#user_search_list').hide();
                return;
            }
            searchTimeout = setTimeout(function() {
                if (val === lastSearchTerm) {
                    showUserSearchList(lastSearchResults, val);
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: '{{ route('user.search') }}',
                    data: {
                        'term': val
                    },
                    success: function(data) {

                        if (data && data.length > 0) {
                            lastSearchTerm = val;
                            lastSearchResults = data;
                            showUserSearchList(data, val);
                        } else {
                            $('#user_search_list').html(
                                '<li class="list-group-item text-danger"> المستخدم غير موجود  </li>'
                            ).show();
                        }
                    },
                    error: function(xhr) {
                        $('#user_search_list').html(
                            '<li class="list-group-item text-danger">حدث خطأ أثناء البحث</li>'
                        ).show();
                    }
                });
            }, 300);
        });

        $('#user_search').on('focus', function() {
            const val = $(this).val().trim();
            if (val && lastSearchResults.length > 0) {
                showUserSearchList(lastSearchResults, val);
            }
        });

        // Select user from dropdown
        $('#user_search_list').on('click', 'li', function() {
            const userId = $(this).data('id');
            // Only set the user name (not the ID) in the input
            const userName = $(this).data('name');
            $('#user_id').val(userId);
            $('#user_search').val(userName);
            $('#user_search_list').hide();
            selectedUser = userId;
            loadUserPermissions(userId);
        });

        // Hide dropdown if click outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#user_search, #user_search_list').length) {
                $('#user_search_list').hide();
            }
        });

        // Define the object before using it
        var userRoles = {
            pages: [],
            btns: []
        };

        function loadUserPermissions(userId) {
            $.ajax({
                type: 'GET',
                url: '{{ route('permissions.user.permissions') }}',
                data: {
                    'userId': userId
                },
                success: function(data) {
                    userRoles.pages = data.role_pages;
                    userRoles.btns = data.role_btns;
                    renderPermissions();
                    $('#permissions-area').show();
                },
                error: function() {
                    $('#role-pages-list').html(
                        '<div class="alert alert-danger">حدث خطأ أثناء تحميل الصلاحيات</div>');
                }
            });
        }

        function renderPermissions() {
            let html = '';
            window.allRolePages.forEach(page => {
                html += `<div class="mb-3 border rounded p-3">
            <div class="form-check form-switch mb-2">
                <input class="form-check-input toggle-role-page" type="checkbox" data-page-id="${page.id}" id="page_${page.id}"
                    ${userRoles.pages && userRoles.pages.includes(page.id) ? 'checked' : ''}>
                <label class="form-check-label fw-bold" for="page_${page.id}">${page.name}</label>
            </div>
            <div class="row ms-4">`;
                (page.buttons || []).forEach(btn => {
                    html += `<div class="col-md-3 col-6 mb-2">
                <div class="form-check">
                    <input class="form-check-input toggle-role-btn" type="checkbox" data-btn-id="${btn.id}" id="btn_${btn.id}"
                        ${userRoles.btns && userRoles.btns.includes(btn.id) ? 'checked' : ''}>
                    <label class="form-check-label" for="btn_${btn.id}">${btn.name}</label>
                </div>
            </div>`;
                });
                html += `</div></div>`;
            });
            $('#role-pages-list').html(html);
        }

        // Delegate event for dynamic checkboxes
        $('#role-pages-list').on('change', '.toggle-role-page', function() {
            let userId = $('#user_id').val();
            let pageId = $(this).data('page-id');
            $.ajax({
                url: window.toggleRolePageUrl,
                type: 'POST',
                data: {
                    user_id: userId,
                    role_page_id: pageId,
                },
                success: function(resp) {
                    Swal.fire({
                        title: 'تمت العملية بنجاح !',
                        text: resp.message,
                        icon: "success",
                        confirmButtonText: 'موافق'
                    });
                    loadUserPermissions(userId);
                },
                error: function(xhr) {
                    let errorMsg = 'حدث خطأ';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        errorMsg = xhr.responseText;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: errorMsg
                    });
                }
            });
        });
        $('#role-pages-list').on('change', '.toggle-role-btn', function() {
            let userId = $('#user_id').val();
            let btnId = $(this).data('btn-id');
            $.ajax({
                url: window.toggleRoleBtnUrl,
                type: 'POST',
                data: {
                    user_id: userId,
                    role_btn_id: btnId,

                },
                success: function(resp) {
                    Swal.fire({
                        title: 'تمت العملية بنجاح !',
                        text: resp.message,
                        icon: "success",
                        confirmButtonText: 'موافق'
                    });
                    loadUserPermissions(userId);
                },
                error: function(xhr) {
                    let errorMsg = 'حدث خطأ';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        errorMsg = xhr.responseText;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: errorMsg
                    });
                }
            });
        });
    </script>
@endpush
