@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary-theme text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold">ចូលគណនី</h4>
                        <p class="text-muted">សូមស្វាគមន៍មកកាន់ហាងរបស់យើង</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">អុីមែល</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 bg-light @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="បញ្ចូលអុីមែលរបស់អ្នក">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">លេខសម្ងាត់</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control border-start-0 bg-light @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="បញ្ចូលលេខសម្ងាត់">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    ចងចាំខ្ញុំ
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-primary-theme text-decoration-none small" href="{{ route('password.request') }}">
                                    ភ្លេចលេខសម្ងាត់?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary-theme w-100 py-2 rounded-pill fw-bold mb-4">
                            ចូលគណនី
                        </button>

                        <div class="text-center text-muted">
                            មិនទាន់មានគណនីមែនទេ? <a href="{{ route('register') }}" class="text-primary-theme text-decoration-none fw-bold">ចុះឈ្មោះទីនេះ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
