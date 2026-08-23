@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>កន្ត្រកទំនិញរបស់អ្នក</h3>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">ផលិតផល</th>
                                    <th scope="col">តម្លៃ</th>
                                    <th scope="col">ចំនួន</th>
                                    <th scope="col">សរុប</th>
                                    <th scope="col" class="pe-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $key => $details)
                                    @php $total += ($details['price'] ?? 0) * ($details['quantity'] ?? 1); @endphp
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ isset($details['image']) && $details['image'] ? asset('assets/uploads/products/' . $details['image']) : 'https://via.placeholder.com/80' }}" class="rounded object-fit-cover me-3" width="80" height="80" alt="{{ $details['name'] ?? '' }}">
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $details['name'] ?? 'N/A' }}</h6>
                                                    @if(!empty($details['size']))
                                                    <span class="badge bg-secondary">ទំហំ: {{ $details['size'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($details['price'] ?? 0, 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.update', $key) ?? '#' }}" method="POST" class="d-flex align-items-center">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $details['quantity'] ?? 1 }}" min="1" class="form-control form-control-sm text-center me-2" style="width: 70px;" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="fw-bold text-danger">${{ number_format(($details['price'] ?? 0) * ($details['quantity'] ?? 1), 2) }}</td>
                                        <td class="pe-4 text-end">
                                            <form action="{{ route('cart.remove', $key) ?? '#' }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="លុបចោល"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">សរុបការបញ្ជាទិញ</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
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

                    <a href="{{ route('checkout.index') ?? '#' }}" class="btn btn-primary-theme w-100 py-3 rounded-pill fw-bold fs-5">
                        បន្តទៅបង់ប្រាក់
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div class="text-center py-5 bg-white rounded shadow-sm">
        <i class="bi bi-cart-x text-muted opacity-50 mb-4" style="font-size: 8rem;"></i>
        <h4 class="text-muted mb-4">កន្ត្រកទំនិញរបស់អ្នកទទេ</h4>
        <a href="{{ route('home') }}" class="btn btn-primary-theme px-5 py-2 rounded-pill">
            <i class="bi bi-arrow-left me-2"></i>បន្តការទិញទំនិញ
        </a>
    </div>
    @endif
</div>
@endsection
