@extends('layouts.admin')

@section('title', 'Click Shop')

@section('styles')
<style>
    .kpi-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">ទិដ្ឋភាពទូទៅនៃផ្ទាំងគ្រប់គ្រង</h4>
    <div class="text-muted"><i class="bi bi-calendar3 me-2"></i>{{ date('d-M-Y') }}</div>
</div>

<!-- KPI Cards -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="text-muted fw-medium">ចំណូលសរុប</div>
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">${{ number_format($revenueSum, 2) }}</h3>
                <div class="text-success small fw-medium">
                    <i class="bi bi-graph-up me-1"></i>សរុបរហូតដល់ពេលនេះ
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="text-muted fw-medium">ការបញ្ជាទិញ</div>
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <i class="bi bi-cart-check"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($ordersCount) }}</h3>
                <div class="text-success small fw-medium">
                    <i class="bi bi-graph-up me-1"></i>សរុបរហូតដល់ពេលនេះ
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="text-muted fw-medium">ផលិតផលសរុប</div>
                    <div class="icon-box bg-info bg-opacity-10 text-info">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($productsCount) }}</h3>
                <div class="text-muted small fw-medium">
                    <i class="bi bi-box me-1"></i>សរុបក្នុងឃ្លាំង
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 kpi-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="text-muted fw-medium">អតិថិជន</div>
                    <div class="icon-box bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($usersCount) }}</h3>
                <div class="text-success small fw-medium">
                    <i class="bi bi-people-fill me-1"></i>គណនីអតិថិជនសរុប
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">និន្នាការចំណូល ៧ថ្ងៃចុងក្រោយ</h5>
            </div>
            <div class="card-body">
                <div style="height: 300px; width: 100%;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">ស្ថានភាពការបញ្ជាទិញ</h5>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center">
                <div style="height: 250px; width: 100%;">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">ការបញ្ជាទិញថ្មីៗ</h5>
        <a href="{{ route('admin.orders.index') ?? '#' }}" class="btn btn-sm btn-outline-primary">មើលទាំងអស់</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>លេខកូដ</th>
                    <th>អតិថិជន</th>
                    <th>កាលបរិច្ឆេទ</th>
                    <th>តម្លៃសរុប</th>
                    <th>ស្ថានភាព</th>
                    <th class="text-end">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td class="fw-medium">#{{ $order->order_number }}</td>
                    <td>{{ $order->user ? $order->user->name : 'ភ្ញៀវ' }}</td>
                    <td>{{ $order->created_at->format('d-M-Y') }}</td>
                    <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark">កំពុងរង់ចាំ</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-success">បានដឹកជញ្ជូន</span>
                        @else
                            <span class="badge bg-danger">បានលុបចោល</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">មិនមានការបញ្ជាទិញថ្មីៗទេ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        // Revenue Chart
        const ctxRev = document.getElementById('revenueChart');
        if(ctxRev) {
            new Chart(ctxRev.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_keys($dailyRevenue)) !!},
                    datasets: [{
                        label: 'ចំណូល ($)',
                        data: {!! json_encode(array_values($dailyRevenue)) !!},
                        borderColor: '#818cf8',
                        backgroundColor: 'rgba(129, 140, 248, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#e2e8f0' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // Order Chart
        const ctxOrd = document.getElementById('orderChart');
        if(ctxOrd) {
            new Chart(ctxOrd.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['កំពុងរង់ចាំ', 'កំពុងរៀបចំ', 'បានដឹកជញ្ជូន', 'បានលុបចោល'],
                    datasets: [{
                        data: [{{ $orderStatuses['pending'] }}, {{ $orderStatuses['processing'] }}, {{ $orderStatuses['delivered'] }}, {{ $orderStatuses['cancelled'] }}],
                        backgroundColor: ['#f59e0b', '#0ea5e9', '#10b981', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    })();
</script>
@endsection
