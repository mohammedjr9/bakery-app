@extends('layouts.main')
@section('content')
<div class="row">
    {{-- <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">إجمالي عدد المستفيدين</span>
          <span class="info-box-number">{{$beneficiaries_count}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div> --}}
    <!-- /.col -->
    {{-- <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">عدد مستفيدين اليوم</span>
          <span class="info-box-number">{{$benef_day_count}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div> --}}
    <!-- /.col -->
    {{-- <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">المستلمين اليوم</span>
          <span class="info-box-number">{{$receipts_day_count}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div> --}}
    <!-- /.col -->
    {{-- <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">الغير مستلمين اليوم</span>
          <span class="info-box-number">{{$not_receipts_day_count}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div> --}}
    <!-- /.col -->
  </div>

@endsection
@push('scripts')
<script>
</script>
@endpush
