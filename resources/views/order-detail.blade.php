@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('profile.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> ត្រឡប់ទៅប្រវត្តិទិញ
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-start mb-5 border-bottom pb-4">
                <div>
                    <h3 class="fw-bold mb-1">វិក្កយបត្របញ្ជាទិញ</h3>
                    <p class="text-muted mb-0">លេខកូដ: <span class="fw-bold text-dark">#{{ $order->order_number ?? 'N/A' }}</span></p>
                    <p class="text-muted mb-0">កាលបរិច្ឆេទ: {{ isset($order->created_at) ? $order->created_at->format('d M Y, h:i A') : '' }}</p>
                </div>
                <div class="text-end">
                    <div class="mb-2">ស្ថានភាព: 
                        @if(($order->status ?? '') == 'pending')
                            <span class="badge bg-warning text-dark fs-6">រង់ចាំ</span>
                        @elseif(($order->status ?? '') == 'processing')
                            <span class="badge bg-info text-dark fs-6">កំពុងរៀបចំ</span>
                        @elseif(($order->status ?? '') == 'shipped')
                            <span class="badge bg-primary fs-6">កំពុងដឹកជញ្ជូន</span>
                        @elseif(($order->status ?? '') == 'completed')
                            <span class="badge bg-success fs-6">រួចរាល់</span>
                        @else
                            <span class="badge bg-danger fs-6">លុបចោល</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-6">
                    <h6 class="fw-bold text-muted text-uppercase mb-3">ព័ត៌មានអ្នកទិញ</h6>
                    <h6 class="fw-bold">{{ $order->name ?? 'N/A' }}</h6>
                    <div><i class="bi bi-telephone me-2 text-muted"></i>{{ $order->phone ?? '' }}</div>
                    <div><i class="bi bi-geo-alt me-2 text-muted"></i>{{ $order->address ?? '' }}</div>
                </div>
                <div class="col-sm-6 text-sm-end mt-4 mt-sm-0">
                    <h6 class="fw-bold text-muted text-uppercase mb-3">វិធីសាស្រ្តបង់ប្រាក់</h6>
                    <div><i class="bi bi-cash-stack me-2 text-success"></i>បង់ប្រាក់ពេលទទួលអីវ៉ាន់ (COD)</div>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 ps-4">ផលិតផល</th>
                            <th class="py-3 text-center">ចំនួន</th>
                            <th class="py-3 text-end">តម្លៃរាយ</th>
                            <th class="py-3 text-end pe-4">សរុប</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($order->items))
                            @foreach($order->items as $item)
                            <tr>
                                <td class="py-3 ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ isset($item->product) && $item->product->image ? asset('assets/uploads/products/' . $item->product->image) : 'https://via.placeholder.com/50' }}" class="rounded me-3 object-fit-cover" width="50" height="50">
                                        <div>
                                            <div class="fw-bold">{{ $item->product_name ?? 'N/A' }}</div>
                                            @if($item->size ?? false)
                                            <small class="text-muted">ទំហំ: {{ $item->size }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-center align-middle">{{ $item->quantity ?? 1 }}</td>
                                <td class="py-3 text-end align-middle">${{ number_format($item->price ?? 0, 2) }}</td>
                                <td class="py-3 text-end pe-4 align-middle fw-bold text-danger">${{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 2) }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-lg-4 col-md-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">តម្លៃសរុបបណ្តោះអាសន្ន:</span>
                        <span>${{ number_format($order->total_amount ?? 0, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                        <span class="text-muted">សេវាដឹកជញ្ជូន:</span>
                        <span class="text-success">ឥតគិតថ្លៃ</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold fs-5">សរុបទាំងអស់:</span>
                        <span class="fw-bold fs-4 text-danger">${{ number_format($order->total_amount ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
