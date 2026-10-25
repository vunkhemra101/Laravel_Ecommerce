@extends('layouts.admin')

@section('title', 'Click Shop')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.categories.index') ?? '#' }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i>ត្រលប់ថយក្រោយ
    </a>
    <h4 class="mb-0 fw-bold">កែប្រែប្រភេទ</h4>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-medium">ឈ្មោះប្រភេទ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', 'សម្លៀកបំពាក់បុរស') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.categories.index') ?? '#' }}" class="btn btn-light">បោះបង់</a>
                        <button type="submit" class="btn btn-primary">រក្សាទុកការផ្លាស់ប្តូរ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
