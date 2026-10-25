@extends('layouts.admin')

@section('title', 'Click Shop')

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
    <h4 class="mb-0 fw-bold">អ្នកប្រើប្រាស់</h4>
    <a href="{{ route('admin.users.create') ?? '#' }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>បង្កើតអ្នកប្រើប្រាស់ថ្មី
    </a>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <div class="d-flex flex-wrap gap-2 mb-3">
            <a href="{{ route('admin.users.index') }}" class="filter-chip {{ request('role') == null ? 'active' : '' }}">ទាំងអស់ (All)</a>
            <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" class="filter-chip {{ request('role') == 'customer' ? 'active' : '' }}">អតិថិជន (Customers)</a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="filter-chip {{ request('role') == 'admin' ? 'active' : '' }}">អ្នកគ្រប់គ្រង (Admins)</a>
        </div>
        <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex" style="max-width: 400px;">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0 bg-light" name="search" placeholder="ស្វែងរកឈ្មោះ ឬអ៊ីមែល...">
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>អ្នកប្រើប្រាស់</th>
                    <th>ទំនាក់ទំនង</th>
                    <th>អាសយដ្ឋាន</th>
                    <th>តួនាទី</th>
                    <th class="text-end">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $user->profile_image ? asset($user->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}" class="rounded-circle" width="40" height="40">
                            <div>
                                <div class="fw-medium">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                    <td><div class="text-truncate" style="max-width: 150px;">{{ $user->address ?? 'N/A' }}</div></td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge bg-primary">អ្នកគ្រប់គ្រង</span>
                        @else
                            <span class="badge bg-secondary">អតិថិជន</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil"></i></a>
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបគណនីនេះមែនទេ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">មិនមានអ្នកប្រើប្រាស់ទេ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-end">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
