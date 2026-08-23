@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Banner Carousel -->
    @php
        if(class_exists('\App\Models\Banner')){
            $banners = \App\Models\Banner::where('is_active', 'active')->get();
        } else {
            $banners = collect();
        }
    @endphp
    @if($banners->count() > 0)
    <div id="heroCarousel" class="carousel slide mb-5 rounded overflow-hidden shadow-sm" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($banners as $index => $banner)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }} position-relative">
                <img src="{{ asset('assets/uploads/banners/' . $banner->image) }}" class="d-block w-100 object-fit-cover" alt="Banner" style="height: 400px;">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center position-absolute top-0 bottom-0 start-0 end-0" style="background: rgba(0,0,0,0.3);">
                    <h1 class="fw-bold text-white display-5 mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">ស្វាគមន៍មកកាន់ហាងយើងខ្ញុំ</h1>
                    <p class="fs-5 text-white mb-0" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">ទំនិញមានគុណភាព ម៉ូដទាន់សម័យ និងតម្លៃសមរម្យបំផុត</p>
                </div>
            </div>
            @endforeach
        </div>
        @if($banners->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif
    </div>
    @endif

    <!-- Announcement Ticker -->
    <div class="bg-primary text-white py-2 px-3 mb-4 rounded shadow-sm d-flex align-items-center overflow-hidden">
        <div class="bg-danger text-white px-3 py-1 rounded-pill fw-bold text-nowrap me-3 z-1 shadow-sm position-relative">
            <i class="bi bi-megaphone-fill"></i><span class="d-none d-md-inline ms-1">ដំណឹងពិសេស</span>
        </div>
        <div class="ticker-wrap flex-grow-1 overflow-hidden position-relative d-flex align-items-center" style="height: 24px;">
            <div class="ticker-move d-flex text-nowrap w-auto">
                <!-- Original Content -->
                <div class="ticker-item pe-5"><i class="bi bi-star-fill text-warning me-1"></i>សូមស្វាគមន៍មកកាន់ហាងរបស់យើង! ទទួលបានការបញ្ចុះតម្លៃពិសេសសម្រាប់អតិថិជនថ្មី។</div>
                <div class="ticker-item pe-5"><i class="bi bi-truck text-warning me-1"></i>សេវាកម្មដឹកជញ្ជូនរហ័សទាន់ចិត្ត និងឥតគិតថ្លៃសម្រាប់ការកម្ម៉ង់ចាប់ពី $50 ឡើងទៅ!</div>
                <div class="ticker-item pe-5"><i class="bi bi-gift-fill text-warning me-1"></i>ទិញទំនិញថ្ងៃនេះ ដើម្បីទទួលបានកាដូពិសេសពីហាងយើងខ្ញុំ!</div>
                
                <!-- Duplicate for seamless loop -->
                <div class="ticker-item pe-5"><i class="bi bi-star-fill text-warning me-1"></i>សូមស្វាគមន៍មកកាន់ហាងរបស់យើង! ទទួលបានការបញ្ចុះតម្លៃពិសេសសម្រាប់អតិថិជនថ្មី។</div>
                <div class="ticker-item pe-5"><i class="bi bi-truck text-warning me-1"></i>សេវាកម្មដឹកជញ្ជូនរហ័សទាន់ចិត្ត និងឥតគិតថ្លៃសម្រាប់ការកម្ម៉ង់ចាប់ពី $50 ឡើងទៅ!</div>
                <div class="ticker-item pe-5"><i class="bi bi-gift-fill text-warning me-1"></i>ទិញទំនិញថ្ងៃនេះ ដើម្បីទទួលបានកាដូពិសេសពីហាងយើងខ្ញុំ!</div>
            </div>
        </div>
    </div>

    <!-- Category Filter Pills -->
    @php
        if(class_exists('\App\Models\Category')){
            $categories = \App\Models\Category::all();
        } else {
            $categories = collect();
        }
    @endphp
    
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">សូមជ្រើសរើសប្រភេទទំនិញ</h5>
    </div>
    
    <div class="d-flex overflow-auto mb-4 pb-2 gap-2" style="white-space: nowrap; scrollbar-width: none;">
        <a href="{{ route('home') }}" class="btn {{ !request('category') ? 'btn-primary-theme' : 'btn-outline-secondary bg-white' }} rounded-pill px-4">ទាំងអស់</a>
        @foreach($categories as $category)
        <a href="{{ route('home', ['category' => $category->id]) }}" class="btn {{ request('category') == $category->id ? 'btn-primary-theme' : 'btn-outline-secondary bg-white' }} rounded-pill px-4">
            {{ $category->name }}
        </a>
        @endforeach
    </div>

    <!-- Product Grid -->
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
        @php
            if(class_exists('\App\Models\Product')){
                $query = \App\Models\Product::with('category');
                if(request('category')) {
                    $query->where('category_id', request('category'));
                }
                $products = $query->latest()->paginate(12);
            } else {
                $products = collect();
            }
        @endphp
        @forelse($products as $product)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm product-card transition-hover">
                <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none">
                    <div class="position-relative">
                        <img src="{{ $product->image ? asset('assets/uploads/products/' . $product->image) : 'https://via.placeholder.com/300' }}" class="card-img-top object-fit-cover" alt="{{ $product->name }}" style="height: 250px;">
                        @if($product->stock_qty <= 0)
                        <span class="position-absolute top-0 end-0 bg-danger text-white px-2 py-1 m-2 rounded small">អស់ពីស្តុក</span>
                        @endif
                    </div>
                </a>
                <div class="card-body d-flex flex-column">
                    <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-dark">
                        <h6 class="card-title text-truncate mb-1">{{ $product->name }}</h6>
                    </a>
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3">
                        <span class="fs-5 fw-bold text-danger">${{ number_format($product->price, 2) }}</span>
                        @if($product->size)
                        <span class="badge bg-secondary">មានទំហំ</span>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-3 pt-0">
                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-primary w-100 rounded-pill {{ $product->stock_qty <= 0 ? 'disabled' : '' }}">
                        <i class="bi bi-cart-plus me-1"></i> មើលព័ត៌មានលម្អិត
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-box-seam fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">មិនមានផលិតផលនៅទីនេះទេ</h5>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        @if(method_exists($products, 'links'))
            {{ $products->links('pagination::bootstrap-5') }}
        @endif
    </div>
</div>

<style>
    .product-card, .feature-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover, .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    @keyframes ticker {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .ticker-wrap {
        mask-image: linear-gradient(to right, transparent, black 2%, black 98%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 2%, black 98%, transparent);
    }
    .ticker-move {
        animation: ticker 25s linear infinite;
        width: max-content;
    }
    .ticker-move:hover {
        animation-play-state: paused;
        cursor: default;
    }
</style>
@endsection
