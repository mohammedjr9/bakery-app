<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                @if($typeName)
                    <th>نوع الطرد</th>
                @endif
                <th>إجمالي الوارد</th>
                <th>إجمالي الصادر</th>
                <th>المتبقي</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if($typeName)
                    <td>{{ $typeName }}</td>
                @endif
                <td>{{ $totalIn }}</td>
                <td>{{ $totalOut }}</td>
                <td>{{ $remaining }}</td>
            </tr>
        </tbody>
    </table>
</div>

@if ($stockMovements->count())
    <hr>
    <h6>تفاصيل الحركات:</h6>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>نوع الطرد</th>
                    <th>نوع الحركة</th>
                    <th>الكمية</th>
                    <th>المستلم</th>
                    <th>تاريخ الإضافة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stockMovements as $index => $stock)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $stock->typeCoupon->name ?? 'غير معروف' }}</td>
                        <td>
                            @if ($stock->type === 'in')
                                <span class="badge bg-success">وارد</span>
                            @else
                                <span class="badge bg-danger">صادر</span>
                            @endif
                        </td>
                        <td>{{ $stock->quantity ?? 0 }}</td>
                        <td>
                            @if ($stock->type === 'out')
                                {{ $stock->recipient ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $stock->created_at->format('Y-m-d') }}</td>
                        <td>
                            <form action="{{ route('stock_movements.destroy', $stock->id) }}" method="POST" class="delete-form d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-item="{{ $stock->typeCoupon->name ?? 'هذا الطرد' }}">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-muted mb-0">لا توجد حركات مسجلة لهذا المخزن حالياً.</p>
@endif
