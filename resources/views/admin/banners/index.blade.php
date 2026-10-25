@extends('layouts.admin')

@section('title', 'Click Shop')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1 fw-bold">គ្រប់គ្រងផ្ទាំងផ្សព្វផ្សាយ (Banners)</h4>
        <p class="text-muted mb-0">បន្ថែម ឬលុបផ្ទាំងរូបភាពលើទំព័រដើម</p>
    </div>
</div>

<div class="row">
    <!-- Upload Form -->
    <div class="col-xl-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">បន្ថែមផ្ទាំងថ្មី</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">ជ្រើសរើសរូបភាព</label>
                        <input type="file" class="form-control" name="image" accept="image/*" required>
                        <div class="form-text">ទំហំដែលណែនាំ: 1920x600 pixels (អតិបរមា 2MB)</div>
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="isActive" name="is_active" checked>
                            <label class="form-check-label" for="isActive">បង្ហាញនៅលើគេហទំព័រ</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-upload me-2"></i>បង្ហោះរូបភាព</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Banner List -->
    <div class="col-xl-8 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">បញ្ជីផ្ទាំងផ្សព្វផ្សាយ</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>រូបភាព</th>
                            <th>ចំណងជើង</th>
                            <th>ស្ថានភាព</th>
                            <th class="text-end">សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banners as $banner)
                        <tr>
                            <td>
                                <div class="border rounded overflow-hidden" style="width: 120px; height: 40px; background-color: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('assets/uploads/banners/' . $banner->image) }}" class="w-100 h-100 object-fit-cover" alt="Banner">
                                </div>
                            </td>
                            <td>{{ $banner->image }}</td>
                            <td>
                                @if($banner->is_active == 'active')
                                    <span class="badge bg-success">កំពុងបង្ហាញ</span>
                                @else
                                    <span class="badge bg-secondary">បានលាក់</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <form action="{{ route('admin.banners.toggle', $banner->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $banner->is_active == 'active' ? 'secondary' : 'success' }}" title="{{ $banner->is_active == 'active' ? 'បិទការបង្ហាញ' : 'បើកការបង្ហាញ' }}">
                                            <i class="bi {{ $banner->is_active == 'active' ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបផ្ទាំងនេះមែនទេ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="លុប"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">មិនមានផ្ទាំងផ្សព្វផ្សាយទេ</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
