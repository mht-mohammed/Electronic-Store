@extends('admin.layouts.app')
@section('title', 'التصنيفات')
@section('page-title', 'إدارة التصنيفات')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex gap-2">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-lg me-1"></i> تصنيف جديد
        </a>
    </div>
    <div class="text-muted small">
        <i class="bi bi-tags me-1"></i> {{ $categories->total() }} تصنيف
    </div>
</div>

<!-- Search & Filter -->
<div class="table-card mb-4">
    <div class="row g-3">
        <div class="col-md-4">
            <input type="text" class="form-control" id="searchInput" placeholder="🔍 بحث باسم التصنيف...">
        </div>
        <div class="col-md-4">
            <select class="form-select" id="statusFilter">
                <option value="">جميع الحالات</option>
                <option value="1">نشط</option>
                <option value="0">غير نشط</option>
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                <i class="bi bi-arrow-repeat me-1"></i> إعادة تعيين
            </button>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="categoriesTable">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 30%">التصنيف</th>
                    <th style="width: 20%">التصنيف الأب</th>
                    <th style="width: 20%">عدد المنتجات</th>
                    <th style="width: 15%">الحالة</th>
                    <th style="width: 10%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr data-category-name="{{ $category->name }}" data-category-status="{{ $category->is_active }}">
                    <td class="text-muted small">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     class="rounded-3" 
                                     style="width: 45px; height: 45px; object-fit: cover;">
                            @else
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-white" 
                                     style="width: 45px; height: 45px; background: linear-gradient(135deg, #ff6b35, #ff5722);">
                                    <i class="bi bi-folder fs-4"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $category->name }}</h6>
                                <small class="text-muted">{{ $category->slug }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($category->parent)
                            <span class="badge bg-secondary bg-opacity-15 text-secondary px-3 py-2 rounded-pill">
                                <i class="bi bi-folder-symlink me-1"></i> {{ $category->parent->name }}
                            </span>
                        @else
                            <span class="text-muted">
                                <i class="bi bi-dash-circle me-1"></i> رئيسي
                            </span>
                        @endif
                    </td>
                    
                    {{-- ===== قسم عدد المنتجات المطور ===== --}}
                    <td>
                        @php
                            $count = $category->products_count;
                            $color = $count > 10 ? 'success' : ($count > 0 ? 'warning' : 'secondary');
                            $icon = $count > 0 ? 'bi-box-seam' : 'bi-box';
                        @endphp
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-{{ $color }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 38px; height: 38px;">
                                <i class="bi {{ $icon }} text-{{ $color }} fs-5"></i>
                            </div>
                            <div>
                                <span class="fw-bold fs-3 text-{{ $color }}">{{ $count }}</span>
                                <small class="text-muted d-block" style="font-size: 10px; line-height: 1.2;">منتج</small>
                            </div>
                        </div>
                    </td>
                    {{-- ===== نهاية القسم ===== --}}
                    
                    <td>
                        @if($category->is_active)
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i> نشط
                            </span>
                        @else
                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                <i class="bi bi-x-circle me-1"></i> غير نشط
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                  class="d-inline" 
                                  onsubmit="return confirm('⚠️ هل أنت متأكد من حذف التصنيف: {{ $category->name }}؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill ms-1">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="bi bi-folder-x fs-1 text-muted d-block mb-2"></i>
                        <h6 class="text-muted">لا توجد تصنيفات</h6>
                    </td>
                </td>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $categories->links() }}
        </div>
    @endif
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
    .table tbody tr:hover {
        background: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const rows = document.querySelectorAll('#categoriesTable tbody tr');
        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            const categoryName = row.getAttribute('data-category-name') || '';
            const categoryStatus = row.getAttribute('data-category-status');
            const matchesSearch = categoryName.includes(searchTerm);
            const matchesStatus = !statusFilter || categoryStatus === statusFilter;
            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        filterTable();
    }
    document.getElementById('searchInput')?.addEventListener('keyup', filterTable);
    document.getElementById('statusFilter')?.addEventListener('change', filterTable);
</script>
@endpush