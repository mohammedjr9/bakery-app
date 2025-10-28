@extends('layouts.main')

@section('title', 'نتائج استيراد الإكسل')

@section('content')

<x-flash-message class="success" />

<div class="card card-flush">
    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <!--begin::Title-->
                <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                <span class="me-2">عدد السجلات التي تم ترحيلها بنجاح
                <span class="position-relative d-inline-block text-danger">{{$success_count}}</span> سجلات </div>
                <!--end::Title-->
            </div>
        </div>
        <!--end::Wrapper-->
    </div>
    <!--begin::Card body-->
    <div class="card-body pt-0">

        <!--begin::Datatable-->
      <tbody class="text-gray-600 fw-semibold">
    @foreach ($error as $key => $item)
        @if (is_array($item) && isset($item[0]) && isset($item[1]))
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item[0] }}</td>
                <td>
                    <ul>
                        @foreach ($item[1] as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @else
            <tr>
                <td colspan="3" class="text-danger">
                    {{ is_array($item) && isset($item['mess']) ? $item['mess'] : 'خطأ غير معروف' }}
                </td>
            </tr>
        @endif
    @endforeach
</tbody>

        <!--end::Datatable-->
    </div>
    <!--end::Card body-->
</div>

@endsection
@push('scripts')
<script>
    let table1;
    $(function () {
        table1 = $('.data-table').DataTable({
            language: {
                "url": "{{ asset('admin/assets/plugins/custom/datatables/ar.json') }}"
            },
        });
    });

</script>
@endpush
