@extends('admin.layouts.app')
@section('title', 'الرئيسية')
@section('page-title', 'لوحة التحكم')

@section('content')

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="icon bg-primary mx-auto mb-3">
                <i class="bi bi-cart-check fs-2 text-white"></i>
            </div>
            <h3 class="fw-bold mb-1">{{ $stats['total_orders'] }}</h3>
            <p class="text-muted mb-0 small">إجمالي الطلبات</p>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="icon bg-success mx-auto mb-3">
                <i class="bi bi-currency-dollar fs-2 text-white"></i>
            </div>
            <h3 class="fw-bold mb-1">${{ number_format($stats['total_revenue'], 2) }}</h3>
            <p class="text-muted mb-0 small">إجمالي الإيرادات</p>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="icon bg-info mx-auto mb-3">
                <i class="bi bi-people fs-2 text-white"></i>
            </div>
            <h3 class="fw-bold mb-1">{{ $stats['total_customers'] }}</h3>
            <p class="text-muted mb-0 small">العملاء المسجلين</p>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="icon bg-warning mx-auto mb-3">
                <i class="bi bi-box-seam fs-2 text-white"></i>
            </div>
            <h3 class="fw-bold mb-1">{{ $stats['total_products'] }}</h3>
            <p class="text-muted mb-0 small">المنتجات</p>
        </div>
    </div>
</div>

<!-- Alerts -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="table-card bg-warning bg-opacity-10 border-0">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-warning rounded-circle p-3">
                    <i class="bi bi-clock-history fs-4 text-white"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">طلبات معلقة</h6>
                    <h3 class="fw-bold mb-0">{{ $stats['pending_orders'] }}</h3>
                    <small class="text-muted">بحاجة للمراجعة</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="table-card bg-danger bg-opacity-10 border-0">
            <div class="d-flex align-items-center gap-3">
                <div class="icon bg-danger rounded-circle p-3">
                    <i class="bi bi-exclamation-triangle fs-4 text-white"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">منتاجت منخفضة المخزون</h6>
                    <h3 class="fw-bold mb-0">{{ $stats['low_stock'] }}</h3>
                    <small class="text-muted">بحاجة لإعادة تخزين</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Orders Table -->
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-receipt me-2"></i> أحدث الطلبات
        </h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
            عرض الكل <i class="bi bi-arrow-left"></i>
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>رقم الطلب</th>
                    <th>العميل</th>
                    <th>المبلغ</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestOrders as $order)
                <tr>
                    <td class="fw-semibold">#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td class="fw-bold text-success">${{ number_format($order->total, 2) }}</td>
                    <td>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge bg-warning text-dark rounded-pill px-3">
                                    <i class="bi bi-clock me-1"></i> معلق
                                </span>
                                @break
                            @case('processing')
                                <span class="badge bg-info rounded-pill px-3">
                                    <i class="bi bi-gear me-1"></i> قيد التنفيذ
                                </span>
                                @break
                            @case('shipped')
                                <span class="badge bg-primary rounded-pill px-3">
                                    <i class="bi bi-truck me-1"></i> تم الشحن
                                </span>
                                @break
                            @case('delivered')
                                <span class="badge bg-success rounded-pill px-3">
                                    <i class="bi bi-check-circle me-1"></i> مكتمل
                                </span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger rounded-pill px-3">
                                    <i class="bi bi-x-circle me-1"></i> ملغي
                                </span>
                                @break
                        @endswitch
                    </td>
                    <td class="text-muted">{{ $order->created_at->format('Y/m/d') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        لا توجد طلبات حالياً
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Products -->
<div class="row mt-4">
    <div class="col-12">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-star me-2 text-warning"></i> أفضل المنتجات مبيعاً
                </h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    إدارة المنتجات <i class="bi bi-arrow-left"></i>
                </a>
            </div>
            
            <div class="row">
                @forelse($topProducts as $product)
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center gap-3 p-2 rounded-3 hover-bg">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 style="width: 55px; height: 55px; object-fit: cover; border-radius: 12px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="width: 55px; height: 55px; border-radius: 12px;">
                                <i class="bi bi-box text-secondary fs-3"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-semibold">{{ Str::limit($product->name, 30) }}</h6>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <span class="text-success fw-bold">${{ number_format($product->price, 2) }}</span>
                                <span class="text-muted small">
                                    <i class="bi bi-cart"></i> {{ $product->sold_count ?? 0 }} مبيعة
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted py-4">
                    لا توجد منتجات لعرضها
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .stat-card .icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .hover-bg:hover {
        background: #f8f9fa;
    }
    
    .table-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .badge {
        font-weight: 500;
        font-size: 12px;
    }
</style>
@endpush