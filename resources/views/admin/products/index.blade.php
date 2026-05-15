@extends('admin.layouts.app')
@section('title', 'المنتجات')
@section('page-title', 'إدارة المنتجات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="text-muted small">{{ $products->total() }} منتج</div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> منتج جديد
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>المنتج</th>
                    <th>السعر</th>
                    <th>المخزون</th>
                    <th>التصنيف</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 style="width:50px;height:50px;object-fit:cover;border-radius:8px">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                 style="width:50px;height:50px">📦</div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ Str::limit($product->name, 35) }}</div>
                        <div class="text-muted small">{{ Str::limit($product->description, 45) }}</div>
                    </td>
                    <td class="fw-semibold text-success">${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->stock > 10)
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning">{{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">نفد</span>
                        @endif
                    </td>
                    <td class="small">{{ $product->category->name ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $product->is_active ? 'نشط' : 'مخفي' }}
                        </span>
                        @if($product->is_featured)
                            <span class="badge bg-warning ms-1">مميز</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('حذف المنتج؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">لا توجد منتجات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection