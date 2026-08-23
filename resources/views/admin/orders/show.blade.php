@extends('layouts.admin')

@section('title', 'ព័ត៌មានលម្អិតការបញ្ជាទិញ')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-end">
    <div>
        <a href="{{ route('admin.orders.index') ?? '#' }}" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i>ត្រលប់ទៅបញ្ជីការបញ្ជាទិញ
        </a>
        <h4 class="mb-0 fw-bold">ព័ត៌មានលម្អិតការបញ្ជាទិញ: <span class="text-primary">#{{ $order->order_number }}</span></h4>
    </div>
    <div>
        <button class="btn btn-outline-secondary"><i class="bi bi-printer me-2"></i>បោះពុម្ពវិក្កយបត្រ</button>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <!-- Invoice-style order detail card -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">ផលិតផលដែលបានកុម្ម៉ង់</h5>
                @if($order->status == 'pending')
                    <span class="badge bg-warning text-dark fs-6">កំពុងរង់ចាំ</span>
                @elseif($order->status == 'processing')
                    <span class="badge bg-info text-dark fs-6">កំពុងរៀបចំ</span>
                @elseif($order->status == 'delivered')
                    <span class="badge bg-success fs-6">បានដឹកជញ្ជូន</span>
                @else
                    <span class="badge bg-danger fs-6">បានលុបចោល</span>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ផលិតផល</th>
                            <th class="text-center">បរិមាណ</th>
                            <th class="text-end">តម្លៃរាយ</th>
                            <th class="text-end">សរុប</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $item->product && $item->product->image ? asset('assets/uploads/products/' . $item->product->image) : 'https://ui-avatars.com/api/?name=P&background=random' }}" class="rounded object-fit-cover" width="50" height="50">
                                    <div>
                                        <div class="fw-medium">{{ $item->product ? $item->product->name : 'ផលិតផលដែលបានលុប' }}</div>
                                        @if($item->size)
                                        <small class="text-muted">ទំហំ: {{ $item->size }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->price, 2) }}</td>
                            <td class="text-end fw-medium">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-medium">សរុបរង:</td>
                            <td class="text-end fw-medium">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-medium">សេវាដឹកជញ្ជូន:</td>
                            <td class="text-end fw-medium">ឥតគិតថ្លៃ</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold fs-5">តម្លៃសរុបទាំងអស់:</td>
                            <td class="text-end fw-bold fs-5 text-primary">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <!-- Update Status -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">ផ្លាស់ប្តូរស្ថានភាព</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select class="form-select" name="status">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>កំពុងរង់ចាំ</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>កំពុងរៀបចំ</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>បានដឹកជញ្ជូន</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>បានលុបចោល</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">ធ្វើបច្ចុប្បន្នភាព</button>
                </form>
            </div>
        </div>

        <!-- Customer info card -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">ព័ត៌មានអតិថិជន</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user ? $order->user->name : 'ភ្ញៀវ') }}&background=random" class="rounded-circle" width="50" height="50">
                    <div>
                        <div class="fw-bold fs-5">{{ $order->user ? $order->user->name : 'ភ្ញៀវ' }}</div>
                        <div class="text-muted">អតិថិជន</div>
                    </div>
                </div>
                
                <h6 class="fw-bold mb-3 text-uppercase fs-7 text-muted">ព័ត៌មានទំនាក់ទំនង</h6>
                <div class="mb-2"><i class="bi bi-envelope text-muted me-2"></i> {{ $order->user ? $order->user->email : 'គ្មានអ៊ីមែល' }}</div>
                <div class="mb-4"><i class="bi bi-telephone text-muted me-2"></i> {{ $order->phone ?? 'គ្មានលេខទូរស័ព្ទ' }}</div>

                <h6 class="fw-bold mb-3 text-uppercase fs-7 text-muted">អាសយដ្ឋានដឹកជញ្ជូន</h6>
                <div class="d-flex gap-2">
                    <i class="bi bi-geo-alt text-muted mt-1"></i>
                    <div>
                        {{ $order->shipping_address ?? 'មិនមានអាសយដ្ឋានដឹកជញ្ជូន' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
