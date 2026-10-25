@extends('layouts.admin')

@section('title', 'Click Shop')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">គ្រប់គ្រងផលិតផល</h4>
    <a href="{{ route('admin.products.create') ?? '#' }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>បន្ថែមផលិតផលថ្មី
    </a>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex" style="max-width: 400px;">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 bg-light" name="search" placeholder="ស្វែងរកផលិតផល..." value="{{ request('search') }}">
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>រូបភាព</th>
                    <th>ឈ្មោះផលិតផល / ប្រភេទ</th>
                    <th>តម្លៃ</th>
                    <th>ទំហំ</th>
                    <th>បរិមាណស្តុក</th>
                    <th>ស្ថានភាព</th>
                    <th class="text-end">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('assets/uploads/products/' . $product->image) }}" class="rounded" width="48" height="48" alt="Product" style="object-fit: cover;"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($product->name) }}&background=random'">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($product->name) }}&background=random" class="rounded" width="48" height="48" alt="Product">
                        @endif
                    </td>
                    <td>
                        <div class="fw-medium mb-1">{{ $product->name }}</div>
                        <small class="text-muted">{{ $product->category->name ?? 'N/A' }}</small>
                    </td>
                    <td class="fw-bold">${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->size ?: '-' }}</td>
                    <td>
                        @if($product->stock_qty > 10)
                            <span class="badge bg-success bg-opacity-10 text-success">{{ $product->stock_qty }}</span>
                        @elseif($product->stock_qty > 0)
                            <span class="badge bg-warning bg-opacity-10 text-warning">{{ $product->stock_qty }}</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger">0</span>
                        @endif
                    </td>
                    <td>
                        @if($product->is_active == 'active')
                            <span class="badge bg-success">ដាក់លក់</span>
                        @else
                            <span class="badge bg-secondary">លាក់</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបផលិតផលនេះមែនទេ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">មិនមានទិន្នន័យផលិតផលនៅឡើយទេ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
