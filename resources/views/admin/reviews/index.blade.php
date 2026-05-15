@extends('admin.layouts.app')
@section('title', 'التقييمات')
@section('page-title', 'إدارة تقييمات العملاء')

@section('content')

<!-- Filter Section -->
<div class="table-card animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-funnel-fill me-2"></i> تصفية التقييمات
        </h6>
        <span class="badge bg-primary">{{ $reviews->total() }} تقييم</span>
    </div>
    
    <form method="GET" class="row g-3">
        <div class="col-md-3">
            <label class="form-label small fw-semibold">حالة التقييم</label>
            <select name="status" class="form-select">
                <option value="">كل الحالات</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                    ⏳ قيد المراجعة
                </option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                    ✅ مقبول
                </option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                    ❌ مرفوض
                </option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">بحث عن منتج</label>
            <input type="text" name="search" class="form-control" placeholder="اسم المنتج..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-search me-1"></i> بحث
                </button>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i> مسح
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4 mt-2">
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="icon bg-warning-light mx-auto mb-2" style="width: 50px; height: 50px;">
                <i class="bi bi-clock-history fs-3"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $reviews->where('status', 'pending')->count() }}</h3>
            <small class="text-muted">قيد المراجعة</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="icon bg-success-light mx-auto mb-2" style="width: 50px; height: 50px;">
                <i class="bi bi-check-circle fs-3"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $reviews->where('status', 'approved')->count() }}</h3>
            <small class="text-muted">مقبولة</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="icon bg-danger-light mx-auto mb-2" style="width: 50px; height: 50px;">
                <i class="bi bi-x-circle fs-3"></i>
            </div>
            <h3 class="fw-bold mb-0">{{ $reviews->where('status', 'rejected')->count() }}</h3>
            <small class="text-muted">مرفوضة</small>
        </div>
    </div>
</div>

<!-- Reviews Table -->
<div class="table-card animate-fade-in">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="bg-light">
                    <th><i class="bi bi-person me-1"></i> العميل</th>
                    <th><i class="bi bi-box me-1"></i> المنتج</th>
                    <th><i class="bi bi-star-fill text-warning me-1"></i> التقييم</th>
                    <th><i class="bi bi-chat-dots me-1"></i> التعليق</th>
                    <th><i class="bi bi-calendar me-1"></i> التاريخ</th>
                    <th><i class="bi bi-flag me-1"></i> الحالة</th>
                    <th><i class="bi bi-gear me-1"></i> الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr class="animate-fade-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" 
                                 style="width: 40px; height: 40px; font-weight: bold;">
                                {{ mb_substr($review->user?->name ?? 'مستخدم', 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $review->user?->name ?? 'مستخدم محذوف' }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ $review->user?->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($review->product?->image)
                                <img src="{{ asset('storage/' . $review->product->image) }}" 
                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">📦</div>
                            @endif
                            <div>
                                <div class="small fw-semibold">{{ Str::limit($review->product?->name ?? 'منتج محذوف', 25) }}</div>
                                <div class="text-muted" style="font-size: 11px;">ID: {{ $review->product_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}" 
                                   style="font-size: 14px;"></i>
                            @endfor
                            <span class="text-muted small ms-1">({{ $review->rating }}/5)</span>
                        </div>
                    </td>
                    <td>
                        <div class="small text-muted" style="max-width: 200px;">
                            "{{ Str::limit($review->body ?? 'لا يوجد تعليق', 50) }}"
                        </div>
                    </td>
                    <td>
                        <div class="small">
                            <div class="fw-semibold">{{ $review->created_at->format('Y/m/d') }}</div>
                            <div class="text-muted" style="font-size: 10px;">{{ $review->created_at->format('H:i') }}</div>
                        </div>
                    </td>
                    <td>
                        @switch($review->status)
                            @case('pending')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    <i class="bi bi-clock me-1"></i> قيد المراجعة
                                </span>
                                @break
                            @case('approved')
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i> مقبول
                                </span>
                                @break
                            @case('rejected')
                                <span class="badge bg-danger px-3 py-2 rounded-pill">
                                    <i class="bi bi-x-circle me-1"></i> مرفوض
                                </span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            @if($review->status !== 'approved')
                                <form method="POST" action="{{ route('admin.reviews.status', $review) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button name="status" value="approved" 
                                            class="btn btn-sm btn-outline-success rounded-pill me-1"
                                            title="قبول التقييم">
                                        <i class="bi bi-check-lg"></i> قبول
                                    </button>
                                </form>
                            @endif
                            
                            @if($review->status !== 'rejected')
                                <form method="POST" action="{{ route('admin.reviews.status', $review) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button name="status" value="rejected" 
                                            class="btn btn-sm btn-outline-warning rounded-pill me-1"
                                            title="رفض التقييم">
                                        <i class="bi bi-x-lg"></i> رفض
                                    </button>
                                </form>
                            @endif
                            
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" 
                                  class="d-inline" 
                                  onsubmit="return confirm('⚠️ هل أنت متأكد من حذف هذا التقييم؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill" title="حذف التقييم">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-chat-square-text fs-1 text-muted mb-3 d-block"></i>
                        <h6 class="text-muted">لا توجد تقييمات متاحة</h6>
                        <small class="text-muted">سيظهر هنا تقييمات العملاء عند إضافتها</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($reviews->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $reviews->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection

@push('styles')
<style>
    .bg-warning-light {
        background: rgba(255, 193, 7, 0.15);
    }
    .bg-success-light {
        background: rgba(25, 135, 84, 0.15);
    }
    .bg-danger-light {
        background: rgba(220, 53, 69, 0.15);
    }
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        background: white;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .table tbody tr {
        transition: all 0.2s;
    }
    .table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
    }
    .btn-group .btn {
        transition: all 0.2s;
    }
    .btn-group .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush