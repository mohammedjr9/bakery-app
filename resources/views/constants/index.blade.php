@extends('layouts.main')

@section('content')
<div id="laravel-alert-placeholder"></div>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">إدارة التصنيفات الرئيسية</h3>
                <button class="btn btn-success" id="btn-add-constant">
                    <i class="fas fa-plus"></i> إضافة ثابت رئيسي جديد
                </button>
            </div>
            <div class="card-body" id="parents-table">
                @include('constants.partials.parents-table', ['parents' => $parents])
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">إدارة القيم التابعة</h3>
                <button class="btn btn-success" id="btn-add-child">
                    <i class="fas fa-plus"></i> إضافة قيمة تابعة
                </button>
            </div>
            <div class="card-body" id="children-table">
                @include('constants.partials.children-table', ['children' => $children])
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="constantModal" tabindex="-1" aria-labelledby="constantModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="constantModalLabel">إضافة/تعديل ثابت</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body" id="constantModalBody">
        <div class="text-center p-5">
            <div class="spinner-border text-info"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // إضافة ثابت رئيسي
    $('#btn-add-constant').click(function() {
        openModal("{{ route('constants.create') }}", 'إضافة ثابت رئيسي');
    });

    // إضافة قيمة تابعة
    $('#btn-add-child').click(function() {
        openModal("{{ route('constants.create') }}?child=1", 'إضافة قيمة تابعة');
    });

    // تعديل
    $(document).on('click', '.btn-edit-constant', function() {
        var id = $(this).data('id');
        openModal("/constants/" + id + "/edit", 'تعديل ثابت');
    });

   $(document).on('click', '.btn-delete-constant', function() {
    var id = $(this).data('id');

    Swal.fire({
        title: 'تأكيد الحذف',
        text: 'هل أنت متأكد أنك تريد الحذف؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/constants/' + id,
                type: 'DELETE',
                data: {"_token": "{{ csrf_token() }}"},
                success: function() {
                    refreshTables();
                    Swal.fire(
                        'تم الحذف!',
                        'تم حذف العنصر بنجاح.',
                        'success'
                    );
                },
                error: function() {
                    Swal.fire(
                        'خطأ!',
                        'حدث خطأ أثناء الحذف.',
                        'error'
                    );
                }
            });
        }
    });
});

});

function openModal(url, title) {
    $('#constantModalLabel').text(title);
    $('#constantModal').modal('show');
    $('#constantModalBody').html('<div class="text-center p-5"><div class="spinner-border text-info"></div></div>');

    $.get(url, function(data) {
        $('#constantModalBody').html(data);
    });
}

function refreshTables() {
    $.get("{{ route('constants.index') }}", function(data) {
        $('#parents-table').html($(data).find('#parents-table').html());
        $('#children-table').html($(data).find('#children-table').html());
    });
}

function showLaravelStyleAlert(message, type = 'info') {
    let alertBox = `
        <div id="laravel-alert" class="alert alert-${type} alert-dismissible fade show text-center mt-3">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    $('#laravel-alert').remove();
    $('#laravel-alert-placeholder').html(alertBox);

    setTimeout(() => {
        $('#laravel-alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}
</script>
@endpush
