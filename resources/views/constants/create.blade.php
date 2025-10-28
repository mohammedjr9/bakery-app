<form id="constantCreateForm">
    @csrf

    <div class="mb-3">
        <label class="form-label">اسم الثابت</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">الوصف (اختياري)</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">التصنيف الرئيسي</label>
        <select name="parent_id" class="form-control">
            <option value="">- بدون -</option>
            @foreach($parents as $parent)
            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="1" name="status" id="statusCheck" checked>
        <label class="form-check-label" for="statusCheck">
            فعال
        </label>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-success">حفظ</button>
    </div>
</form>
<script>
    $(document).ready(function(){
    $('#constantCreateForm').on('submit', function(e){
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('constants.store') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                $('#constantModal').modal('hide');
                refreshTables();
                showLaravelStyleAlert('تمت الإضافة بنجاح', 'success');
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    $.each(errors, function(key, value) {
                        errorMessages += value + '<br>';
                    });
                    showLaravelStyleAlert(errorMessages, 'danger');
                } else {
                    showLaravelStyleAlert('حدث خطأ أثناء الإضافة', 'danger');
                }
            }
        });
    });
});
</script>
