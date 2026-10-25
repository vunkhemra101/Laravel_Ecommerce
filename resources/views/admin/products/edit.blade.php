@extends('layouts.admin')

@section('title', 'Click Shop')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.products.index') ?? '#' }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i>ត្រលប់ថយក្រោយ
    </a>
    <h4 class="mb-0 fw-bold">កែប្រែផលិតផល</h4>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">ព័ត៌មានទូទៅ</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">ឈ្មោះផលិតផល <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', 'អាវយឺតបុរស') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">តម្លៃ ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', '15.00') }}" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">បរិមាណស្តុក <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock_qty') is-invalid @enderror" name="stock_qty" value="{{ old('stock_qty', '145') }}" required>
                            @error('stock_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">ប្រភេទ <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                            <option value="">ជ្រើសរើសប្រភេទ...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id') ?? $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">ការកំណត់ផ្សេងៗ</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium">ទំហំ (Sizes)</label>
                        @php
                            $selectedSizes = explode(',', $product->size ?? '');
                        @endphp
                        <select class="form-select" name="size[]" multiple aria-label="Multiple select example">
                            <option value="S" {{ in_array('S', $selectedSizes) ? 'selected' : '' }}>Small (S)</option>
                            <option value="M" {{ in_array('M', $selectedSizes) ? 'selected' : '' }}>Medium (M)</option>
                            <option value="L" {{ in_array('L', $selectedSizes) ? 'selected' : '' }}>Large (L)</option>
                            <option value="XL" {{ in_array('XL', $selectedSizes) ? 'selected' : '' }}>Extra Large (XL)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">រូបភាពផលិតផលបច្ចុប្បន្ន</label>
                        <div class="mb-2">
                            <img src="{{ asset('assets/uploads/products/' . $product->image) }}" class="rounded img-thumbnail" width="100" alt="Current Image"
                                 onerror="this.src='https://ui-avatars.com/api/?name=Product&background=random'">
                        </div>
                        <label class="form-label fw-medium text-muted">ប្តូររូបភាពថ្មី</label>
                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="isActive" name="is_active" value="active" {{ $product->is_active == 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">ដាក់លក់ភ្លាមៗ</label>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.index') ?? '#' }}" class="btn btn-light flex-grow-1">បោះបង់</a>
                <button type="submit" class="btn btn-primary flex-grow-1">រក្សាទុកការផ្លាស់ប្តូរ</button>
            </div>
        </div>
    </div>
</form>
@endsection
