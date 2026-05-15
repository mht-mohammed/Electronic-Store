@extends('admin.layouts.app')
@section('title', 'تفاصيل الطلب')
@section('page-title', 'تفاصيل الطلب #' . $order->id)

@section('content')
<div class="row g-3">

    {{-- معلومات الطلب --}}
    <div class="col-lg-8">
        <div class="table-card mb-3">
            <h6 class="fw-semibold mb-3">المنتجات</h6>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($item->product?->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                             style="width:36px;height:36px;object-fit:cover;border-radius:6px">
                                    @endif
                                    <span class="small fw-semibold">
                                        {{ $item->product?->name ?? 'منتج محذوف' }}
                                    </span>
                                </div>
                            </td>
                            <td>${{ number_format($item->unit_price, 0) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="fw-semibold">
                                ${{ number_format($item->unit_price * $item->quantity, 0) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-semibold">المجموع الكلي:</td>
                            <td class="fw-bold text-success fs-6">
                                ${{ number_format($order->total, 0) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- تحديث الحالة ومعلومات العميل --}}
    <div class="col-lg-4">

        {{-- تحديث الحالة --}}
        <div class="table-card mb-3">
            <h6 class="fw-semibold mb-3">تحديث الحالة</h6>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf @method('PATCH')
                <select name="status" class="form-select form-select-sm mb-2">
                    @foreach(['pending' => 'معلّق', 'processing' => 'قيد التنفيذ',
                              'shipped' => 'تم الشحن', 'delivered' => 'مُسلَّم',
                              'cancelled' => 'ملغي'] as $val => $label)
                        <option value="{{ $val }}" {{ $order->status == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-success btn-sm w-100">
                    <i class="bi bi-check-lg me-1"></i> تحديث
                </button>
            </form>
        </div>

        {{-- معلومات العميل --}}
        <div class="table-card">
            <h6 class="fw-semibold mb-3">معلومات العميل</h6>
            <div class="small">
                <div class="mb-2">
                    <span class="text-muted">الاسم: </span>
                    <span class="fw-semibold">{{ $order->user->name }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-muted">الإيميل: </span>
                    {{ $order->user->email }}
                </div>
                <div class="mb-2">
                    <span class="text-muted">الهاتف: </span>
                    {{ $order->user->phone ?? '—' }}
                </div>
                <div class="mb-2">
                    <span class="text-muted">عنوان الشحن: </span>
                    {{ $order->shipping_address ?? '—' }}
                </div>
                @if($order->coupon_code)
                <div class="mb-2">
                    <span class="text-muted">كوبون: </span>
                    <span class="badge bg-success bg-opacity-10 text-success">
                        {{ $order->coupon_code }}
                    </span>
                    (-${{ number_format($order->discount_amount, 0) }})
                </div>
                @endif
                <div class="mb-2">
                    <span class="text-muted">تاريخ الطلب: </span>
                    {{ $order->created_at->format('Y/m/d H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-right me-1"></i> العودة للطلبات
    </a>
</div>
@endsection
