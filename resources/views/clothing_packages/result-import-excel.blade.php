@extends('layouts.main')

@section('title', 'نتائج استيراد قسائم الملابس')

@section('content')
<div class="card card-flush">
    <div class="card-body">
        <h4>✅ تم استيراد {{ $success_count }} قسيمة بنجاح</h4>

        @if (count($error))
        <h5 class="text-danger">❌ أخطاء في بعض السطور:</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>السطر</th>
                    <th>الخطأ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($error as $item)
                <tr>
                    <td>{{ $item[0] }}</td>
                    <td>
                        <ul>
                            @foreach ($item[1] as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
