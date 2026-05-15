@extends('admin.layouts.app')
@section('title', 'تفاصيل العميل')
@section('page-title', $customer->name)

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="table-card text-center">
            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center
                        text-white fw-bold mx-auto mb-3"
                 style="width:70px;height:70px;font-size:1.8rem">
                {{ mb_substr($customer->name, 0, 1) }}
            </div>
            <h6 class="fw-bold mb-1">{{ $customer->name }}</h6>
            <div class="text-muted small mb-3">{{ $customer->email }}</div>
            <div class="d-flex justify-content-center gap-2">
                @if($customer->is_active)
                    <span class="badge bg-success rounded-pill px-3 py-2 text-white shadow-sm">
                        <i class="bi bi-check-circle-fill me-1"></i> نشط
                    </span>
                @else
                    <span class="badge bg-danger rounded-pill px-3 py-2 text-white shadow-sm">
                        <i class="bi bi-x-circle-fill me-1"></i> محظور
                    </span>
                @endif
            </div>
            <hr>
            <div class="text-start small">
                <div class="mb-2">
                    <i class="bi bi-phone me-2 text-muted"></i>
                    {{ $customer->phone ?? 'لا يوجد' }}
                </div>
                <div class="mb-2">
                    <i class="bi bi-geo-alt me-2 text-muted"></i>
                    {{ $customer->address ?? 'لا يوجد' }}
                </div>
                <div>
                    <i class="bi bi-calendar me-2 text-muted"></i>
                    {{ $customer->created_at->format('Y/m/d') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="table-card">
            <h6 class="fw-semibold mb-3">آخر الطلبات</h6>
            @forelse($orders as $order)
            <div class="d-flex align-items-center justify-content-between
                        border-bottom pb-2 mb-2">
                <div>
                    <span class="small fw-semibold">#{{ $order->id }}</span>
                    <span class="text-muted small ms-2">
                        {{ $order->created_at->format('Y/m/d') }}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-semibold small">
                        ${{ number_format($order->total, 0) }}
                    </span>
                    <span class="badge badge-{{ $order->status }}">
                        @switch($order->status)
                            @case('pending')    معلّق       @break
                            @case('processing') قيد التنفيذ @break
                            @case('shipped')    تم الشحن    @break
                            @case('delivered')  مُسلَّم     @break
                            @case('cancelled')  ملغي        @break
                        @endswitch
                    </span>
                    <a href="{{ route('admin.orders.show', $order) }}"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
            </div>
            @empty
                <p class="text-muted small text-center py-3">لا توجد طلبات</p>
            @endforelse
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-right me-1"></i> العودة للعملاء
    </a>
</div>
@endsection
