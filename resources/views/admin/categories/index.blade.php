@extends('layouts.admin')

@section('title', 'Click Shop')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">ប្រភេទផលិតផល</h4>
    <a href="{{ route('admin.categories.create') ?? '#' }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>បន្ថែមប្រភេទថ្មី
    </a>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex" style="max-width: 400px;">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 bg-light" name="search" placeholder="ស្វែងរកប្រភេទ..." value="{{ request('search') }}">
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>លេខរៀង (ID)</th>
                    <th>ឈ្មោះប្រភេទ</th>
                    <th>ចំនួនផលិតផល</th>
                    <th class="text-end">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td class="fw-medium">{{ $category->name }}</td>
                    <td>{{ $category->products()->count() }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil"></i> កែប្រែ</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបប្រភេទនេះមែនទេ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i> លុប</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">មិនមានទិន្នន័យប្រភេទនៅឡើយទេ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
