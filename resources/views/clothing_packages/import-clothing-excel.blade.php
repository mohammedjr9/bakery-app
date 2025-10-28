@extends('layouts.main')

@section('title','استيراد قسائم كسوة الملابس')

@section('content')
<div class="card card-flush">
    @if (session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
    @endif

    <div class="card-body p-0">

        <form action="{{ route('import_clothing_excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h5>ملاحظات:</h5>
                    <ul>
                        <li>يجب أن يحتوي الملف على الأعمدة: الكود ،الاسم ، رقم الهوية ، عدد الأطفال ، المبلغ ، تاريخ الاستحقاق ،رقم مكان الاستلام ،رقم المشروع ،ملاحظة.</li>
                        <li>صيغة التاريخ: إما Excel format أو yyyy-mm-dd</li>
                    </ul>
                    <div class="mb-3">
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">استيراد</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
