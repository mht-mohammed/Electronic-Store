@extends('admin.layouts.app')
@section('title', 'إضافة خصم')
@section('page-title', 'إضافة خصم جديد')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="table-card">
    <form method="POST" action="{{ route('admin.discounts.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold">المنتج *</label>
                <select name="product_id"
                        class="form-select @error('product_id') is-invalid @enderror">
                    <option value="">اختر منتج</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} — ${{ $product->price }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">نوع الخصم *</label>
                <select name="type" class="form-select" id="discount-type"
                        onchange="toggleSymbol()">
                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>
                        نسبة مئوية (%)
                    </option>
                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>
                        مبلغ ثابت ($)
                    </option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">قيمة الخصم *</label>
                <div class="input-group">
                    <input type="number" name="value" value="{{ old('value') }}"
                           class="form-control @error('value') is-invalid @enderror"
                           step="0.01" min="0">
                    <span class="input-group-text" id="discount-symbol">%</span>
                </div>
                @error('value')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">تاريخ البداية</label>
                <input type="date" name="starts_at" value="{{ old('starts_at') }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">تاريخ الانتهاء</label>
                <input type="date" name="ends_at" value="{{ old('ends_at') }}"
                       class="form-control">
            </div>

            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox"
                           name="is_active" id="is_active" checked>
                    <label class="form-check-label" for="is_active">فعّال</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-check-lg me-1"></i> حفظ الخصم
            </button>
            <a href="{{ route('admin.discounts.index') }}"
               class="btn btn-outline-secondary">إلغاء</a>
        </div>
    </form>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
function toggleSymbol() {
    const type   = document.getElementById('discount-type').value;
    const symbol = document.getElementById('discount-symbol');
    symbol.textContent = type === 'percent' ? '%' : '$';
}
</script>
@endpush