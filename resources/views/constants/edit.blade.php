<form id="constantEditForm">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" value="{{ $constant->id }}">

    <div class="mb-3">
        <label class="form-label">اسم الثابت</label>
        <input type="text" name="name" class="form-control" value="{{ $constant->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">الوصف (اختياري)</label>
        <textarea name="description" class="form-control">{{ $constant->description }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">التصنيف الرئيسي</label>
        <select name="parent_id" class="form-control">
            <option value="">- بدون -</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ $constant->parent_id == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="1" name="status" id="statusCheck" {{ $constant->status ? 'checked' : '' }}>
        <label class="form-check-label" for="statusCheck">
            فعال
        </label>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">تحديث</button>
    </div>
</form>
<script>
$(document).ready(function(){
    $('#constantEditForm').on('submit', function(e){
        e.preventDefault();

        let formData = $(this).serialize();
        let constantId = $('input[name="id"]').val();

        $.ajax({
            url: "/constants/" + constantId,
            method: "POST",
            data: formData,
            success: function(response) {
                $('#constantModal').modal('hide');
                refreshTables();
                showLaravelStyleAlert('تم التحديث بنجاح', 'success');
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
                    showLaravelStyleAlert('حدث خطأ أثناء التحديث', 'danger');
                }
            }
        });
    });
});
</script>

<script>
$(document).ready(function(){
    $('#constantEditForm').on('submit', function(e){
        e.preventDefault();

        let formData = $(this).serialize();
        let constantId = $('input[name="id"]').val();

        $.ajax({
            url: "/constants/" + constantId,
            method: "POST",
            data: formData,
            success: function(response) {
                $('#constantModal').modal('hide');
                refreshConstantsTable();
                showLaravelStyleAlert('تم التحديث بنجاح', 'success');
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
                    showLaravelStyleAlert('حدث خطأ أثناء التحديث', 'danger');
                }
            }
        });
    });
});
</script>
