@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded overflow-hidden">
                <div class="card-body text-center p-4 bg-primary-theme text-white">
                    @if(Auth::user()->profile_image)
                        <img src="{{ Auth::user()->profile_image ? asset('assets/uploads/avatars/' . Auth::user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}" class="rounded-circle mb-3 border border-3 border-white object-fit-cover" width="100" height="100">
                    @else
                        <i class="bi bi-person-circle display-1 mb-3"></i>
                    @endif
                    <h5 class="fw-bold">{{ Auth::user()->name }}</h5>
                    <p class="mb-0 text-white-50">{{ Auth::user()->email }}</p>
                </div>
                <div class="list-group list-group-flush rounded-0" role="tablist">
                    <a class="list-group-item list-group-item-action active p-3" id="orders-tab" data-bs-toggle="list" href="#orders" role="tab">
                        <i class="bi bi-box-seam me-2"></i> ប្រវត្តិបញ្ជាទិញ
                    </a>
                    <a class="list-group-item list-group-item-action p-3" id="profile-tab" data-bs-toggle="list" href="#profile" role="tab">
                        <i class="bi bi-person-gear me-2"></i> កែប្រែព័ត៌មានគណនី
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-md-8 col-lg-9">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="tab-content" id="nav-tabContent">
                <!-- Orders Tab -->
                <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-header bg-white p-4 border-bottom">
                            <h5 class="fw-bold mb-0">ប្រវត្តិបញ្ជាទិញរបស់ខ្ញុំ</h5>
                        </div>
                        <div class="card-body p-0">
                            @php
                                if(class_exists('\App\Models\Order')){
                                    $orders = \App\Models\Order::where('user_id', Auth::id())->latest()->paginate(10);
                                } else {
                                    $orders = collect();
                                }
                            @endphp
                            
                            @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4 py-3">លេខកូដ</th>
                                            <th>កាលបរិច្ឆេទ</th>
                                            <th>សរុប</th>
                                            <th>ស្ថានភាព</th>
                                            <th class="pe-4 text-end">សកម្មភាព</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                        <tr>
                                            <td class="ps-4 fw-bold">#{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y h:i A') }}</td>
                                            <td class="fw-bold text-danger">${{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="badge bg-warning text-dark">រង់ចាំ</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="badge bg-info text-dark">កំពុងរៀបចំ</span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="badge bg-primary">កំពុងដឹកជញ្ជូន</span>
                                                @elseif($order->status == 'completed')
                                                    <span class="badge bg-success">រួចរាល់</span>
                                                @else
                                                    <span class="badge bg-danger">លុបចោល</span>
                                                @endif
                                            </td>
                                            <td class="pe-4 text-end">
                                                <a href="{{ route('orders.show', $order->id) ?? '#' }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    មើលលម្អិត
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3">
                                @if(method_exists($orders, 'links'))
                                    {{ $orders->links('pagination::bootstrap-5') }}
                                @endif
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="bi bi-box2 display-4 text-muted mb-3 d-block"></i>
                                <p class="text-muted">អ្នកមិនទាន់មានប្រវត្តិទិញនៅឡើយទេ</p>
                                <a href="{{ route('home') }}" class="btn btn-primary-theme rounded-pill px-4">ទិញឥឡូវនេះ</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Edit Tab -->
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card border-0 shadow-sm rounded mb-4">
                        <div class="card-header bg-white p-4 border-bottom">
                            <h5 class="fw-bold mb-0">កែប្រែព័ត៌មាន</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('profile.update') ?? '#' }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-4 text-center">
                                    <label for="avatar" class="form-label d-block">រូបតំណាង</label>
                                    <input class="form-control" type="file" id="profile_image" name="profile_image" accept="image/*">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">ឈ្មោះ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">លេខទូរស័ព្ទ</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">អាសយដ្ឋាន</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', Auth::user()->address ?? '') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary-theme rounded-pill px-4">រក្សាទុកការប្រែប្រួល</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-header bg-white p-4 border-bottom">
                            <h5 class="fw-bold mb-0">ផ្លាស់ប្តូរលេខសម្ងាត់</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('profile.password') ?? '#' }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">លេខសម្ងាត់បច្ចុប្បន្ន <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">លេខសម្ងាត់ថ្មី <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">បញ្ជាក់លេខសម្ងាត់ថ្មី <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                
                                <button type="submit" class="btn btn-outline-primary rounded-pill px-4">ផ្លាស់ប្តូរលេខសម្ងាត់</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
