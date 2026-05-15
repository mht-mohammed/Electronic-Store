@extends('admin.layouts.app')
@section('title', 'العملاء')
@section('page-title', 'إدارة العملاء')

@section('content')
<div class="table-card mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control form-control-sm"
                   placeholder="بحث بالاسم أو الإيميل...">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">كل العملاء</option>
                <option value="active"  {{ request('status') == 'active'  ? 'selected' : '' }}>نشط</option>
                <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>محظور</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-funnel"></i> فلتر
            </button>
            <a href="{{ route('admin.customers.index') }}"
               class="btn btn-sm btn-outline-danger ms-1">مسح</a>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>العميل</th>
                    <th>الهاتف</th>
                    <th>عدد الطلبات</th>
                    <th>الحالة</th>
                    <th>تاريخ التسجيل</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-success d-flex align-items-center
                                        justify-content-center text-white fw-bold"
                                 style="width:36px;height:36px;font-size:.9rem">
                                {{ mb_substr($customer->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $customer->name }}</div>
                                <div class="text-muted" style="font-size:.75rem">
                                    {{ $customer->email }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="small">{{ $customer->phone ?? '—' }}</td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary">
                            {{ $customer->orders_count }}
                        </span>
                    </td>
                    <td>
                        @if($customer->is_active)
                            <span class="badge bg-success rounded-pill px-3 py-2 text-white">
                                <i class="bi bi-check-circle-fill me-1"></i> نشط
                            </span>
                        @else
                            <span class="badge bg-danger rounded-pill px-3 py-2 text-white">
                                <i class="bi bi-x-circle-fill me-1"></i> محظور
                            </span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $customer->created_at->format('Y/m/d') }}</td>
                    <td>
                        <a href="{{ route('admin.customers.show', $customer) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('admin.customers.toggle', $customer) }}"
                              class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm {{ $customer->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                    title="{{ $customer->is_active ? 'حظر' : 'تفعيل' }}">
                                <i class="bi bi-{{ $customer->is_active ? 'slash-circle' : 'check-circle' }}"></i>
                            </button>
                        </form>
                        <form method="POST"
                              action="{{ route('admin.customers.destroy', $customer) }}"
                              class="d-inline"
                              onsubmit="return confirm('حذف هذا العميل؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">لا يوجد عملاء</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
