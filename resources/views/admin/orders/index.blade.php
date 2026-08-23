@extends('layouts.admin')

@section('title', 'ការបញ្ជាទិញ')

@section('styles')
<style>
    .filter-chip {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 2rem;
        background-color: #f1f5f9;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        margin-right: 0.5rem;
        transition: all 0.2s;
    }
    .filter-chip:hover {
        background-color: #e2e8f0;
    }
    .filter-chip.active {
        background-color: var(--accent-color);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">ការបញ្ជាទិញទាំងអស់</h4>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <div class="d-flex flex-wrap gap-2 mb-3">
            <a href="{{ route('admin.orders.index') }}" class="filter-chip {{ request('status') == null ? 'active' : '' }}">ទាំងអស់ (All)</a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="filter-chip {{ request('status') == 'pending' ? 'active' : '' }}">កំពុងរង់ចាំ (Pending)</a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="filter-chip {{ request('status') == 'processing' ? 'active' : '' }}">កំពុងរៀបចំ (Processing)</a>
            <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="filter-chip {{ request('status') == 'delivered' ? 'active' : '' }}">បានដឹកជញ្ជូន (Delivered)</a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="filter-chip {{ request('status') == 'cancelled' ? 'active' : '' }}">បានលុបចោល (Cancelled)</a>
        </div>
        <form action="#" method="GET" class="d-flex" style="max-width: 400px;">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 bg-light" name="search" placeholder="ស្វែងរកលេខកូដបញ្ជាទិញ...">
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>លេខបញ្ជាទិញ</th>
                    <th>អតិថិជន</th>
                    <th>ផលិតផល</th>
                    <th>កាលបរិច្ឆេទ</th>
                    <th>តម្លៃសរុប</th>
                    <th>ស្ថានភាព</th>
                    <th class="text-end">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-medium text-primary">#{{ $order->order_number }}</td>
                    <td>
                        <div class="fw-medium">{{ $order->user ? $order->user->name : 'ភ្ញៀវ' }}</div>
                        <small class="text-muted">{{ $order->phone ?? ($order->user->phone ?? 'N/A') }}</small>
                    </td>
                    <td>
                        <div class="text-truncate" style="max-width: 200px;">
                            @foreach($order->orderItems->take(2) as $item)
                                {{ $item->product ? $item->product->name : 'N/A' }} ({{ $item->size ?? '-' }})<br>
                            @endforeach
                        </div>
                        <small class="text-muted">សរុប {{ $order->orderItems->count() }} មុខ</small>
                    </td>
                    <td>{{ $order->created_at->format('d-M-Y') }}</td>
                    <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark">កំពុងរង់ចាំ</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info">កំពុងរៀបចំ</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-success">បានដឹកជញ្ជូន</span>
                        @else
                            <span class="badge bg-danger">បានលុបចោល</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-light text-primary"><i class="bi bi-eye"></i> មើលលម្អិត</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">មិនមានការបញ្ជាទិញទេ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white py-3">
        <!-- Pagination -->
        <div class="d-flex justify-content-end">
            {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
