@extends('admin.layouts.app')
@section('title', 'الخصومات')
@section('page-title', 'إدارة الخصومات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="text-muted small">{{ $discounts->total() }} خصم</div>
    <a href="{{ route('admin.discounts.create') }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> خصم جديد
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>النوع</th>
                    <th>القيمة</th>
                    <th>تاريخ البداية</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($discounts as $discount)
                <tr>
                    <td class="small fw-semibold">
                        {{ Str::limit($discount->product?->name, 30) }}
                    </td>
                    <td class="small">
                        {{ $discount->type === 'percent' ? 'نسبة مئوية' : 'مبلغ ثابت' }}
                    </td>
                    <td class="fw-semibold text-danger">
                        {{ $discount->type === 'percent'
                            ? $discount->value . '%'
                            : '$' . $discount->value }}
                    </td>
                    <td class="small text-muted">
                        {{ $discount->starts_at?->format('Y/m/d') ?? '—' }}
                    </td>
                    <td class="small text-muted">
                        {{ $discount->ends_at?->format('Y/m/d') ?? '—' }}
                    </td>
                    <td>
                    <span class="badge {{ $discount->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 py-2 text-white shadow-sm">
                    <i class="bi bi-{{ $discount->is_active ? 'check-circle-fill' : 'pause-circle-fill' }} me-1"></i>
                     {{ $discount->is_active ? 'فعّال' : 'متوقف' }}
                    </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.discounts.edit', $discount) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('admin.discounts.destroy', $discount) }}"
                              class="d-inline"
                              onsubmit="return confirm('حذف هذا الخصم؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">لا توجد خصومات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($discounts->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $discounts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

