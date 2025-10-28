@extends('layouts.main')

@section('title', 'تقرير كسوة الملابس')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">تقرير كسوة الملابس</h3>

    <form id="reportSearch" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>اسم المشروع</label>
            <select name="project_id" class="form-control" id="project_id">
                <option value="none">— اختر المشروع —</option>

                <option value="">كل المشاريع</option>
                @foreach ($projects as $id => $name)
                <option value="{{ $id }}" {{ request('project_id')==$id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
                @endforeach
            </select>

        </div>

        <div class="col-md-3">
            <label>المكان</label>
            <select name="place" class="form-control" id="place">
                <option value="none">— اختر المكان —</option>
                <option value="">كل الأماكن</option>
                @foreach ($places as $id => $name)
                <option value="{{ $id }}" {{ request('s_place')==$id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>تاريخ التسليم</label>
            <input type="date" name="due_date" class="form-control" id="due_date">
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="button" class="btn btn-info" onclick="searchReport()">بحث</button>

            {{-- <a href="{{ route('clothing.delivered_list') }}" class="btn btn-primary">
                <i class="fas fa-download"></i> استراد
            </a> --}}
            <a id="exportFilteredBtn" class="btn btn-primary">📥 استيراد المستلمين فقط</a>

        </div>



    </form>

    <div id="resultDiv"></div>
</div>
@endsection
@push('scripts')
<script>
    $('#exportFilteredBtn').on('click', function (e) {
        e.preventDefault();

        let project_id = $('#project_id').val();
        let place = $('#place').val();
        let due_date = $('#due_date').val();

        let url = "{{ route('clothing.delivered_list') }}";
        url += `?project_id=${project_id}&place=${place}&due_date=${due_date}`;

        window.location.href = url;
    });
</script>
@endpush


@push('scripts')
<script>
    function searchReport() {
    var place = $('#place').val();
    var due_date = $('#due_date').val();
    var project_id = $('#project_id').val();


    $.ajax({
        url: "{{ route('clothing.report_ajax') }}",
        type: 'get',
        data: {
            place: place,
            due_date: due_date,
            project_id: project_id

        },
        success: function(data) {
            $('#resultDiv').html(data);
        },
        error: function() {
            alert('حدث خطأ أثناء جلب البيانات');
        }
    });
}



</script>
@endpush
