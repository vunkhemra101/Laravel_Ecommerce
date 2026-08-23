@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary-theme text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-plus-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold">ចុះឈ្មោះគណនីថ្មី</h4>
                        <p class="text-muted">ចូលរួមជាមួយយើងថ្ងៃនេះ</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-medium">ឈ្មោះពេញ <span class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control bg-light @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="បញ្ចូលឈ្មោះពេញ">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-medium">លេខទូរស័ព្ទ</label>
                                <input id="phone" type="text" class="form-control bg-light @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="បញ្ចូលលេខទូរស័ព្ទ">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">អុីមែល <span class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control bg-light @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="បញ្ចូលអុីមែល">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-medium">លេខសម្ងាត់ <span class="text-danger">*</span></label>
                                <input id="password" type="password" class="form-control bg-light @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="យ៉ាងតិច ៨ តួអក្សរ">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password-confirm" class="form-label fw-medium">បញ្ជាក់លេខសម្ងាត់ <span class="text-danger">*</span></label>
                                <input id="password-confirm" type="password" class="form-control bg-light" name="password_confirmation" required autocomplete="new-password" placeholder="បញ្ចូលលេខសម្ងាត់ម្តងទៀត">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label fw-medium">អាសយដ្ឋាន</label>
                            <textarea class="form-control bg-light @error('address') is-invalid @enderror" id="address" name="address" rows="2" placeholder="បញ្ចូលអាសយដ្ឋានរបស់អ្នក">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary-theme w-100 py-2 rounded-pill fw-bold mb-4">
                            បង្កើតគណនី
                        </button>

                        <div class="text-center text-muted">
                            មានគណនីរួចហើយ? <a href="{{ route('login') }}" class="text-primary-theme text-decoration-none fw-bold">ចូលគណនីទីនេះ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
