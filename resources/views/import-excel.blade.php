

@extends('layouts.main')

@section('title', 'استيراد ملف اكسل')

@section('content')

<x-flash-message class="success" />

@section('content')
<div class="card card-flush">
    <!--begin::Card body-->
    <div class="card-body p-0">
        <x-flash-error />
        <form action="{{ route('import_excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!--begin::Card-->
            <div class="card ">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Advance form-->
                    <div class="row mb-6">
                        <span class="fs-6">ملاحظات</span>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5"></span>يجب ان يكون اسم ملف الاكسل (upload.xlsx).
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5"></span>يجب أن تكون الأرقام في العمود الأول من الملف مع استثناء الصف الأول الذي سيحتوي على اسم العمود
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5"></span>يجب الالتزام بالنموذج المرفق في عملية رفع السجلات
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5"></span> لتحميل نموذج رفع البيانات انقر <a href="{{env('APP_URL').Storage::url('download/upload.xlsx') }}" target="_blank"> &nbsp;هنا </a>
                        </li>
                    </div>
                    <div class="row mb-6">
                        <input type="file" name="file" class="form-control"  required>
                    </div>
                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-light btn-primary me-2">استيراد</button>
                    </div>
                    <!--end::Advance form-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </form>
    </div>
    <!--end::Card body-->
</div>

@endsection

@endsection
@push('scripts')
<script>

</script>
@endpush
