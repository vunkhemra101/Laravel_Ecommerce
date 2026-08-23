@extends('layouts.admin')

@section('title', 'របាយការណ៍')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1 fw-bold">របាយការណ៍</h4>
        <p class="text-muted mb-0">របាយការណ៍ស្តុកនិងកំណត់ហេតុលក់</p>
    </div>
    <button class="btn btn-outline-primary"><i class="bi bi-printer me-2"></i>បោះពុម្ព</button>
</div>

<!-- Low Stock Warning -->
<div class="card mb-4 border-danger border-top border-3">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>ផលិតផលជិតអស់ពីស្តុក (Stock < 10)</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>លេខកូដ (ID)</th>
                    <th>ឈ្មោះផលិតផល</th>
                    <th>ប្រភេទ</th>
                    <th>ទំហំ</th>
                    <th>បរិមាណស្តុក</th>
                    <th>ស្ថានភាព</th>
                    <th class="text-end">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lowStockProducts as $product)
                <tr>
                    <td>#{{ $product->id }}</td>
                    <td class="fw-medium">{{ $product->name }}</td>
                    <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                    <td>{{ $product->size ?? 'N/A' }}</td>
                    <td class="fw-bold @if($product->stock_qty == 0) text-danger @else text-warning @endif">{{ $product->stock_qty }}</td>
                    <td>
                        @if($product->stock_qty == 0)
                            <span class="badge bg-danger">អស់ពីស្តុក</span>
                        @else
                            <span class="badge bg-warning text-dark">ទាប</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">បន្ថែមស្តុក</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">មិនមានផលិតផលជិតអស់ពីស្តុកទេ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Sales Items Log -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">កំណត់ហេតុលក់ថ្មីៗ</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>លេខបញ្ជាទិញ</th>
                    <th>កាលបរិច្ឆេទ</th>
                    <th>ផលិតផល</th>
                    <th>បរិមាណ</th>
                    <th>តម្លៃរាយ</th>
                    <th>តម្លៃសរុប</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                <tr>
                    <td class="fw-medium">#{{ $sale->order->order_number ?? $sale->order_id }}</td>
                    <td>{{ $sale->created_at->format('d-M-Y H:i') }}</td>
                    <td>{{ $sale->product ? $sale->product->name : 'N/A' }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>${{ number_format($sale->price, 2) }}</td>
                    <td class="fw-bold text-success">${{ number_format($sale->quantity * $sale->price, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">មិនមានកំណត់ហេតុលក់ទេ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
