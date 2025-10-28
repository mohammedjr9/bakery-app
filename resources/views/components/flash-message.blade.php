@props([
'name' => 'success', 'class' => 'success'
])

@if(Session::has($name))
    <!--begin::Alert-->
    <div class="alert alert-{{ $class }} d-flex align-items-center p-5">
        <!--begin::Icon-->
        <i class="ki-duotone ki-shield-tick fs-2hx text-{{ $class }} me-4"><span class="path1"></span><span class="path2"></span></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 text-dark">{{ Session::get($name) }}</h4>
            <!--end::Title-->
        </div>
        <!--end::Wrapper-->
    </div>
<!--end::Alert-->
@endif

@push('scripts')
    <script>
        $(document).ready(function() {
            window.setTimeout(function() {
                $('.alert').alert('close')
            }, 7000);
        });
    </script>
@endpush
