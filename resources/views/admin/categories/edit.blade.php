@extends('admin.layouts.app')
@section('title', 'تعديل تصنيف')
@section('page-title', 'تعديل: ' . $category->name)

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="table-card">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}"
          enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">اسم التصنيف *</label>
            <input type="text" name="name"
                   value="{{ old('name', $category->name) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">التصنيف الأب</label>
            <select name="parent_id" class="form-select">
                <option value="">بدون تصنيف أب</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}"
                        {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">صورة جديدة (اختياري)</label>
            @if($category->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $category->image) }}"
                         class="rounded" style="max-height:70px">
                </div>
            @endif
            <input type="file" name="image" class="form-control"
                   accept="image/*" onchange="previewImage(this)">
            <img id="preview" src="#" class="mt-2 rounded d-none"
                 style="max-height:100px">
        </div>

        <div class="mb-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active"
                       id="is_active" {{ $category->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">نشط</label>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-check-lg me-1"></i> حفظ التغييرات
            </button>
            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-outline-secondary">إلغاء</a>
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
