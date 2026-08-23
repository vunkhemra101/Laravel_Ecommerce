@extends('layouts.admin')

@section('title', 'កែប្រែអ្នកប្រើប្រាស់')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') ?? '#' }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i>ត្រលប់ថយក្រោយ
    </a>
    <h4 class="mb-0 fw-bold">កែប្រែព័ត៌មានអ្នកប្រើប្រាស់</h4>
</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body p-4">
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">ឈ្មោះ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', 'សាន បូរី') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">លេខទូរស័ព្ទ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', '012 345 678') }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">អ៊ីមែល <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', 'san.borey@email.com') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">តួនាទី (Role) <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                                <option value="customer" selected>អតិថិជន (Customer)</option>
                                <option value="admin">អ្នកគ្រប់គ្រង (Admin)</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">អាសយដ្ឋាន</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address', 'ផ្ទះលេខ ១២, ផ្លូវ ២០០, សង្កាត់បឹងរាំង, ខណ្ឌដូនពេញ') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr class="mb-4">
                    <h6 class="fw-bold mb-3">ផ្លាស់ប្តូរពាក្យសម្ងាត់ (ទុកទទេបើមិនចង់ដូរ)</h6>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">ពាក្យសម្ងាត់ថ្មី</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">បញ្ជាក់ពាក្យសម្ងាត់ថ្មី</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.users.index') ?? '#' }}" class="btn btn-light">បោះបង់</a>
                        <button type="submit" class="btn btn-primary">រក្សាទុកការផ្លាស់ប្តូរ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
