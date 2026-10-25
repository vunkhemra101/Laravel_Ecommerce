@extends('layouts.admin')

@section('title', 'Click Shop')

@section('content')
<div class="mb-4">
    <h4 class="mb-1 fw-bold">វិភាគទិន្នន័យ</h4>
    <p class="text-muted">របាយការណ៍លម្អិតអំពីការលក់ និងផលិតផល</p>
</div>

<div class="row g-4 mb-4">
    <!-- Top Products -->
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">ផលិតផលលក់ដាច់បំផុតទាំង ៥</h5>
            </div>
            <div class="card-body">
                @php $maxQty = $topProducts->max('total_quantity') ?: 1; $colors = ['primary','info','success','warning','danger']; @endphp
                @forelse($topProducts as $index => $item)
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="{{ $item->product && $item->product->image ? asset('assets/uploads/products/' . $item->product->image) : 'https://ui-avatars.com/api/?name='.urlencode($item->product->name ?? 'P').'&background=random' }}"
                         class="rounded" width="40" height="40" style="object-fit:cover;"
                         onerror="this.src='https://ui-avatars.com/api/?name=P&background=random'">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-medium">{{ $item->product ? $item->product->name : 'N/A' }}</span>
                            <span class="text-muted">{{ $item->total_quantity }} ឯកតា</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-{{ $colors[$index % 5] }}" role="progressbar"
                                 style="width: {{ round(($item->total_quantity / $maxQty) * 100) }}%"></div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-4">មិនមានទិន្នន័យទេ</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Order Status -->
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">ការវិភាគស្ថានភាពបញ្ជាទិញ</h5>
            </div>
            <div class="card-body">
                @php
                    $statusConfig = [
                        'pending'   => ['label'=>'កំពុងរង់ចាំ (Pending)',   'sub'=>'ការបញ្ជាទិញថ្មី',        'icon'=>'hourglass-split', 'color'=>'warning'],
                        'processing'=> ['label'=>'កំពុងរៀបចំ (Processing)', 'sub'=>'កំពុងវេចខ្ចប់',          'icon'=>'box-seam',         'color'=>'info'],
                        'delivered' => ['label'=>'បានដឹកជញ្ជូន (Delivered)', 'sub'=>'បានប្រគល់ជូនអតិថិជន',   'icon'=>'check-circle',     'color'=>'success'],
                        'cancelled' => ['label'=>'បានលុបចោល (Cancelled)',    'sub'=>'បដិសេធ',               'icon'=>'x-circle',         'color'=>'danger'],
                    ];
                    $total = array_sum($orderStatusCounts) ?: 1;
                @endphp
                @foreach($statusConfig as $key => $cfg)
                <div class="d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-{{ $cfg['color'] }} bg-opacity-10 p-2 rounded">
                            <i class="bi bi-{{ $cfg['icon'] }} text-{{ $cfg['color'] }} fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $cfg['label'] }}</h6>
                            <small class="text-muted">{{ $cfg['sub'] }}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <h5 class="mb-0 fw-bold">{{ $orderStatusCounts[$key] ?? 0 }}</h5>
                        <span class="badge bg-{{ $cfg['color'] }} {{ $cfg['color']=='warning' ? 'text-dark' : '' }}">
                            {{ round((($orderStatusCounts[$key] ?? 0) / $total) * 100) }}%
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Sales By Category -->
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">ការលក់តាមប្រភេទផលិតផល</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ប្រភេទ</th>
                            <th>ចំនួនលក់</th>
                            <th>ចំណូលសរុប</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salesByCategory as $categoryName => $qty)
                        <tr>
                            <td class="fw-medium"><i class="bi bi-tag text-primary me-2"></i>{{ $categoryName }}</td>
                            <td>{{ number_format($qty) }}</td>
                            <td class="fw-bold text-success">--</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">មិនមានទិន្នន័យទេ</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Customers -->
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">អតិថិជនថ្មីៗទាំង ៥</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>អតិថិជន</th>
                            <th>ថ្ងៃចុះឈ្មោះ</th>
                            <th>ចំនួនបញ្ជាទិញ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCustomers as $customer)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $customer->profile_image ? asset('assets/uploads/avatars/'.$customer->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($customer->name).'&background=random' }}" class="rounded-circle" width="35" height="35">
                                    <div>
                                        <div class="fw-medium">{{ $customer->name }}</div>
                                        <small class="text-muted">{{ $customer->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->created_at->diffForHumans() }}</td>
                            <td>{{ $customer->orders_count ?? $customer->orders()->count() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">មិនមានអតិថិជនថ្មីទេ</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
