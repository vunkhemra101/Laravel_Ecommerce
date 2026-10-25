@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-bag-check me-2"></i>ទូទាត់ប្រាក់</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') ?? '#' }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row">
            <!-- Shipping Details -->
            <div class="col-lg-7 mb-4">kt
                <div class="card border-0 shadow-sm rounded h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">ព័ត៌មានដឹកជញ្ជូន</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">ឈ្មោះពេញ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">លេខទូរស័ព្ទ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::check() ? Auth::user()->phone : '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">អុីមែល</label>
                                <input type="email" class="form-control" id="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">អាសយដ្ឋានដឹកជញ្ជូន <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', Auth::check() ? Auth::user()->address : '') }}</textarea>
                        </div>

                        <h5 class="fw-bold mb-3 mt-4">វិធីសាស្រ្តបង់ប្រាក់</h5>
                        <div class="form-check border p-3 rounded mb-2">
                            <input class="form-check-input ms-1 me-2" type="radio" name="payment_method" id="payment_cod" value="COD" checked>
                            <label class="form-check-label fw-bold d-flex align-items-center" for="payment_cod">
                                <i class="bi bi-cash-stack text-success fs-4 me-2"></i> បង់ប្រាក់ពេលទទួលអីវ៉ាន់ (Cash on Delivery)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Review -->
            <div class="col-lg-5 mb-4">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">ការបញ្ជាទិញរបស់អ្នក</h5>

                        <div class="mb-4">
                            @php $total = 0; @endphp
                            @if(session('cart'))
                                @foreach(session('cart') as $key => $details)
                                    @php $total += ($details['price'] ?? 0) * ($details['quantity'] ?? 1); @endphp
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="{{ isset($details['image']) && $details['image'] ? asset('assets/uploads/products/' . $details['image']) : 'https://via.placeholder.com/60' }}" class="rounded object-fit-cover" width="60" height="60">
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">
                                                    {{ $details['quantity'] ?? 1 }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold fs-6">{{ $details['name'] ?? '' }}</h6>
                                                @if(!empty($details['size']))
                                                <small class="text-muted">ទំហំ: {{ $details['size'] }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="fw-bold">${{ number_format(($details['price'] ?? 0) * ($details['quantity'] ?? 1), 2) }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">តម្លៃសរុបបណ្តោះអាសន្ន</span>
                            <span class="fw-bold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">សេវាដឹកជញ្ជូន</span>
                            <span class="text-success">ឥតគិតថ្លៃ</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">តម្លៃសរុបទាំងអស់</span>
                            <span class="fw-bold fs-4 text-danger">${{ number_format($total, 2) }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary-theme w-100 py-3 rounded-pill fw-bold fs-5" id="placeOrderBtn">
                            បញ្ជាក់ការបញ្ជាទិញ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('checkoutForm').addEventListener('submit', function() {
        let btn = document.getElementById('placeOrderBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>កំពុងដំណើរការ...';
    });
</script>
@endsection
