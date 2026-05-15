@extends('admin.layouts.app')
@section('title', 'تعديل منتج')
@section('page-title', 'تعديل: ' . $product->name)

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="table-card">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">اسم المنتج *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">السعر ($) *</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                       class="form-control @error('price') is-invalid @enderror"
                       step="0.01" min="0">
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">المخزون *</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                       class="form-control @error('stock') is-invalid @enderror"
                       min="0">
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">التصنيف *</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">اختر تصنيف</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">وصف المنتج</label>
                <textarea name="description" rows="4"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">الصورة الحالية</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" class="rounded" style="max-height:100px">
                    </div>
                @endif
                <input type="file" name="image" class="form-control"
                       accept="image/*" onchange="previewImage(this)">
                <img id="preview" src="#" class="mt-2 rounded d-none" style="max-height:150px">
            </div>

            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                           {{ $product->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">نشط</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                           {{ $product->is_featured ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">منتج مميز</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-check-lg me-1"></i> حفظ التغييرات
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">إلغاء</a>
        </div>
    </form>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush