<!DOCTYPE html>
{{-- <html direction="rtl" dir="rtl" style="direction: rtl"> --}}
<html lang="ar" class="light-style layout-navbar-fixed layout-menu-fixed " dir="rtl" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template-starter" data-style="light">

<!--begin::Head-->
@include('layouts.header')
<!--end::Head-->
<!--begin::Body-->

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @php
                $HeaderMenu = HeaderMenu();
            @endphp
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold">IHH</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
                        <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>
{{--
                <ul class="menu-inner py-1">
                    @php
                        $sidebarMenu = HeaderMenu();
                    @endphp

                    @foreach ($sidebarMenu as $item)
                        @if (empty($item->follow_to_id))
                            @php
                                $children = $sidebarMenu->filter(function ($sub) use ($item) {
                                    return $sub->follow_to_id == $item->id && $sub->id != $item->id;
                                });

                            @endphp

                            @if ($children->isNotEmpty())
                                <li
                                    class="menu-item {{ request()->routeIs($item->url) ? 'active' : '' }} {{ $children->isNotEmpty() ? 'menu-toggle' : '' }}">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon tf-icons ti ti-circle-dashed"></i>
                                        <div>{{ $item->name }}1</div>
                                    </a>
                                    <ul class="menu-sub">
                                        @foreach ($children as $sub)
                                            <li class="menu-item {{ request()->routeIs($sub->url) ? 'active' : '' }}">
                                                @if (Route::has($sub->url))
                                                    <a href="{{ route($sub->url) }}" class="menu-link"><div>{{ $sub->name }}</div></a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>

                                </li>
                            @else
                                <li class="menu-item {{ request()->routeIs($item->url) ? 'active' : '' }}">
                                    @if (Route::has($item->url))
                                        <a href="{{ route($item->url) }}"
                                        class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-circle"></i>
                                        <div>{{ $item->name }}</div>
                                        </a>
                                    @endif
                                </li>
                            @endif
                        @endif
                    @endforeach


                </ul> --}}
                <ul class="menu-inner py-1">
                     <li class="menu-item">
                        <a href="{{ route('home') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-home"></i>
                            <div>الصفحة الرئيسية</div>
                        </a>
                    </li>
                    @php
                        $sidebarMenu = HeaderMenu();
                    @endphp

                    @foreach ($sidebarMenu as $item)
                        @if (empty($item->follow_to_id))
                            @include('components.sidebar-menu-item', ['item' => $item, 'sidebarMenu' => $sidebarMenu])
                        @endif
                    @endforeach
                </ul>


            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ti ti-menu-2 ti-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        {{-- <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper mb-0">
                            <a class="nav-item nav-link search-toggler d-flex align-items-center px-0"
                                href="javascript:void(0);">
                                <i class="ti ti-search ti-md me-2 me-lg-4 ti-lg"></i>
                                <span class="d-none d-md-inline-block text-muted fw-normal">Search (Ctrl+/)</span>
                            </a>
                        </div>
                    </div> --}}
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Language -->
                            {{-- <li class="nav-item dropdown-language dropdown">
                            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                                href="javascript:void(0);" data-bs-toggle="dropdown">
                                <i class="ti ti-language rounded-circle ti-md"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">

                            </ul>
                        </li> --}}
                            <!--/ Language -->

                            <!-- Style Switcher -->
                            <li class="nav-item dropdown-style-switcher dropdown">
                                <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                                    href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class="ti ti-md" id='icon'></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            onclick="applyTheme('light')" data-theme="light">
                                            <span class="align-middle"><i class="ti ti-sun ti-md me-3"></i>Light</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="applyTheme('dark')"
                                            data-theme="dark">
                                            <span class="align-middle"><i
                                                    class="ti ti-moon-stars ti-md me-3"></i>Dark</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            onclick="applyTheme('system')" data-theme="system">
                                            <span class="align-middle"><i
                                                    class="ti ti-device-desktop-analytics ti-md me-3"></i>System</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- / Style Switcher-->
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item mt-0" href="pages-account-settings-account.html">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                                            class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ auth()->user()->id_no }}</h6>
                                                    <small class="text-muted">{{ auth()->user()->type_user }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1 mx-n2"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">
                                                الملف الشخصي</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="d-grid px-2 pt-2 pb-1">
                                            <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <small class="align-middle">تسجيل الخروج</small>
                                                <i class="ti ti-logout ms-2 ti-14px"></i>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                        <input type="text" class="form-control search-input container-fluid border-0 "
                            placeholder="Search..." aria-label="Search..." />
                        <i class="ti ti-x search-toggler cursor-pointer"></i>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-fluid flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <!-- / Content -->
                    <!-- Footer -->
                    {{-- <footer class="content-footer footer bg-footer-theme">
                    <div class="container-fluid">
                        <div
                            class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                            <div class="text-body">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with ❤️ by <a href="https://pixinvent.com" target="_blank"
                                    class="footer-link">Pixinvent</a>
                            </div>

                        </div>
                    </div>
                </footer> --}}
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->
    <!--begin::Javascript-->
    @include('layouts.footer')
</body>
<!--end::Body-->

</html>
