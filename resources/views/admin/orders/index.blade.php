@extends('admin.layouts.app')
@section('title', 'الطلبات')
@section('page-title', 'إدارة الطلبات')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> طباعة
        </button>
        <button class="btn btn-outline-secondary" id="exportBtn">
            <i class="bi bi-download me-1"></i> تصدير
        </button>
    </div>
    <div class="text-muted small">
        <i class="bi bi-cart-check me-1"></i> {{ $orders->total() }} طلب
    </div>
</div>

<!-- Filters -->
<div class="table-card mb-4">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">بحث باسم العميل</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="🔍 بحث باسم العميل أو الإيميل...">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">حالة الطلب</label>
            <select name="status" class="form-select">
                <option value="">جميع الحالات</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                    ⏳ معلق
                </option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                    ⚙️ قيد التنفيذ
                </option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>
                    🚚 تم الشحن
                </option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                    ✅ مكتمل
                </option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                    ❌ ملغي
                </option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="d-flex gap-2 w-100">
                <button type="submit" class="btn btn-primary-custom flex-grow-1">
                    <i class="bi bi-search me-1"></i> بحث
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i>
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 8%">رقم الطلب</th>
                    <th style="width: 20%">العميل</th>
                    <th style="width: 12%">المبلغ</th>
                    <th style="width: 15%">طريقة الدفع</th>
                    <th style="width: 15%">الحالة</th>
                    <th style="width: 15%">التاريخ</th>
                    <th style="width: 15%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-semibold text-primary">#{{ $order->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white"
                                 style="width: 35px; height: 35px; font-size: 14px;">
                                {{ mb_substr($order->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $order->user->name }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ $order->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="fw-bold text-success">${{ number_format($order->total, 2) }}</td>
                    <td>
                        @php
                        $paymentMethod = $order->payment_method;
                        $paymentClass = $paymentMethod == 'cash' ? 'success' : 'primary';
                        $paymentIcon = $paymentMethod == 'cash' ? 'bi-cash-stack' : 'bi-credit-card';
                        $paymentText = $paymentMethod == 'cash' ? 'كاش' : 'بطاقة';
                         @endphp
                        <span class="badge bg-{{ $paymentClass }} rounded-pill px-3 py-2 text-white">
                           <i class="bi {{ $paymentIcon }} me-1"></i> {{ $paymentText }}
                        </span>
                    </td>
                    <td>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                    <i class="bi bi-clock me-1"></i> معلق
                                </span>
                                @break
                            @case('processing')
                                <span class="badge bg-info rounded-pill px-3 py-2">
                                    <i class="bi bi-gear me-1"></i> قيد التنفيذ
                                </span>
                                @break
                            @case('shipped')
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    <i class="bi bi-truck me-1"></i> تم الشحن
                                </span>
                                @break
                            @case('delivered')
                                <span class="badge bg-success rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle me-1"></i> مكتمل
                                </span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                    <i class="bi bi-x-circle me-1"></i> ملغي
                                </span>
                                @break
                        @endswitch
                    </td>
                    <td class="text-muted small">
                        <i class="bi bi-calendar3 me-1"></i> {{ $order->created_at->format('Y/m/d') }}
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="btn btn-sm btn-outline-primary rounded-pill"
                               title="عرض التفاصيل">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" 
                                  class="d-inline" 
                                  onsubmit="return confirm('⚠️ هل أنت متأكد من حذف الطلب رقم #{{ $order->id }}؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill ms-1" title="حذف">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                 </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                        <h6 class="text-muted">لا توجد طلبات</h6>
                        <small class="text-muted">سيظهر هنا الطلبات عند إضافتها</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<!-- Statistics Cards -->
<div class="row g-4 mt-2">
    <div class="col-md-2 col-sm-4">
        <div class="stat-card text-center">
            <div class="icon bg-warning mx-auto mb-2" style="width: 40px; height: 40px;">
                <i class="bi bi-clock fs-4 text-white"></i>
            </div>
            <h5 class="fw-bold mb-0">{{ $orders->where('status', 'pending')->count() }}</h5>
            <p class="text-muted small mb-0">معلق</p>
        </div>
    </div>
    <div class="col-md-2 col-sm-4">
        <div class="stat-card text-center">
            <div class="icon bg-info mx-auto mb-2" style="width: 40px; height: 40px;">
                <i class="bi bi-gear fs-4 text-white"></i>
            </div>
            <h5 class="fw-bold mb-0">{{ $orders->where('status', 'processing')->count() }}</h5>
            <p class="text-muted small mb-0">قيد التنفيذ</p>
        </div>
    </div>
    <div class="col-md-2 col-sm-4">
        <div class="stat-card text-center">
            <div class="icon bg-primary mx-auto mb-2" style="width: 40px; height: 40px;">
                <i class="bi bi-truck fs-4 text-white"></i>
            </div>
            <h5 class="fw-bold mb-0">{{ $orders->where('status', 'shipped')->count() }}</h5>
            <p class="text-muted small mb-0">تم الشحن</p>
        </div>
    </div>
    <div class="col-md-2 col-sm-4">
        <div class="stat-card text-center">
            <div class="icon bg-success mx-auto mb-2" style="width: 40px; height: 40px;">
                <i class="bi bi-check-circle fs-4 text-white"></i>
            </div>
            <h5 class="fw-bold mb-0">{{ $orders->where('status', 'delivered')->count() }}</h5>
            <p class="text-muted small mb-0">مكتمل</p>
        </div>
    </div>
    <div class="col-md-2 col-sm-4">
        <div class="stat-card text-center">
            <div class="icon bg-danger mx-auto mb-2" style="width: 40px; height: 40px;">
                <i class="bi bi-x-circle fs-4 text-white"></i>
            </div>
            <h5 class="fw-bold mb-0">{{ $orders->where('status', 'cancelled')->count() }}</h5>
            <p class="text-muted small mb-0">ملغي</p>
        </div>
    </div>
    <div class="col-md-2 col-sm-4">
        <div class="stat-card text-center">
            <div class="icon bg-secondary mx-auto mb-2" style="width: 40px; height: 40px;">
                <i class="bi bi-cart-check fs-4 text-white"></i>
            </div>
            <h5 class="fw-bold mb-0">{{ $orders->total() }}</h5>
            <p class="text-muted small mb-0">إجمالي</p>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .btn-primary-custom {
        background: linear-gradient(135deg, #ff6b35, #ff5722);
        border: none;
        color: white;
        transition: 0.3s;
    }
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,107,53,0.4);
        color: white;
    }
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 12px;
        transition: all 0.3s;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .stat-card .icon {
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table tbody tr:hover {
        background: #f8f9fa;
    }
    .badge {
        font-weight: 500;
        font-size: 12px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('exportBtn')?.addEventListener('click', function() {
        // تصدير الجدول إلى CSV
        let csv = [];
        let rows = document.querySelectorAll('.table tbody tr');
        
        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            let rowData = [];
            row.querySelectorAll('td').forEach(cell => {
                rowData.push('"' + cell.innerText.replace(/"/g, '""') + '"');
            });
            csv.push(rowData.join(','));
        });
        
        let blob = new Blob([csv.join('\n')], { type: 'text/csv' });
        let link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'orders_' + new Date().toISOString().slice(0,19) + '.csv';
        link.click();
    });
</script>
@endpush