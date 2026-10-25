@extends('layouts.app')

@section('title', 'Click Shop')

@section('styles')
<style>
    :root {
        --surface: #ffffff;
        --surface-muted: #f4f6f9;
        --ink: #0f172a;
        --ink-muted: #64748b;
        --line: #e6e9ef;
        --radius-lg: 18px;
        --radius: 14px;
        --radius-sm: 10px;
        --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
        --shadow: 0 10px 30px -12px rgba(15, 23, 42, 0.18);
        --shadow-lg: 0 24px 60px -24px rgba(1, 14, 40, 0.35);
    }

    /* ===== Section headings ===== */
    .section-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    .section-head .eyebrow {
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: .25rem;
    }
    .section-head h2 {
        font-size: clamp(1.15rem, 2.4vw, 1.5rem);
        font-weight: 700;
        color: var(--ink);
        margin: 0;
        position: relative;
        padding-left: .85rem;
    }
    .section-head h2::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 1.15em;
        border-radius: 999px;
        background: var(--primary-color);
    }

    /* ===== Hero ===== */
    .hero {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow);
        background: var(--primary-color);
    }
    .hero .carousel-item img {
        width: 100%;
        height: clamp(260px, 42vw, 500px);
        object-fit: cover;
        display: block;
    }
    .hero .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(1, 14, 40, .82) 0%, rgba(1, 14, 40, .45) 55%, rgba(1, 14, 40, .1) 100%);
    }
    .hero .hero-caption {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: clamp(1.25rem, 5vw, 4rem);
        max-width: 720px;
    }
    .hero .hero-caption h1 {
        font-size: clamp(1.4rem, 4.2vw, 2.75rem);
        font-weight: 700;
        line-height: 1.25;
        color: #fff;
        text-shadow: 0 2px 18px rgba(0, 0, 0, .35);
        margin-bottom: .75rem;
    }
    .hero .hero-caption p {
        font-size: clamp(.9rem, 1.6vw, 1.05rem);
        color: rgba(255, 255, 255, .88);
        margin-bottom: 1.5rem;
    }
    .hero .carousel-indicators [data-bs-target] {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        border: 0;
        opacity: .5;
    }
    .hero .carousel-indicators .active { opacity: 1; width: 26px; }

    /* ===== Feature strip ===== */
    .feature-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 1.25rem;
        box-shadow: var(--shadow-sm);
    }
    .feature-strip .feature {
        display: flex;
        align-items: center;
        gap: .85rem;
        min-width: 0;
    }
    .feature-strip .feature i {
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        font-size: 1.25rem;
        color: var(--primary-color);
        background: rgba(1, 14, 40, .06);
    }
    .feature-strip .feature h6 {
        margin: 0;
        font-weight: 700;
        font-size: .92rem;
        color: var(--ink);
    }
    .feature-strip .feature span {
        font-size: .78rem;
        color: var(--ink-muted);
    }

    /* ===== Ticker ===== */
    .ticker-bar {
        display: flex;
        align-items: center;
        gap: .75rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: .65rem 1rem;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .ticker-bar .ticker-tag {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: var(--primary-color);
        color: #fff;
        font-weight: 700;
        font-size: .78rem;
        border-radius: 999px;
        padding: .35rem .85rem;
        white-space: nowrap;
    }
    .ticker-wrap {
        flex: 1;
        overflow: hidden;
        position: relative;
        height: 24px;
        mask-image: linear-gradient(to right, transparent, #000 3%, #000 97%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, #000 3%, #000 97%, transparent);
    }
    .ticker-move {
        display: flex;
        width: max-content;
        animation: ticker 28s linear infinite;
    }
    .ticker-item {
        padding-right: 3rem;
        white-space: nowrap;
        color: var(--ink-muted);
        font-size: .88rem;
    }
    .ticker-wrap:hover .ticker-move { animation-play-state: paused; }
    @keyframes ticker {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    /* ===== Category pills ===== */
    .pill-row {
        display: flex;
        gap: .6rem;
        overflow-x: auto;
        padding: .25rem .25rem .75rem;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .pill-row::-webkit-scrollbar { display: none; }
    .cat-pill {
        flex-shrink: 0;
        border: 1px solid var(--line);
        background: var(--surface);
        color: var(--ink);
        border-radius: 999px;
        padding: .5rem 1.15rem;
        font-size: .88rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all .18s ease;
    }
    .cat-pill:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-1px);
    }
    .cat-pill.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
        box-shadow: 0 8px 20px -10px rgba(1, 14, 40, .7);
    }

    /* ===== Product cards ===== */
    .product-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow);
        border-color: transparent;
    }
    .product-thumb {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: var(--surface-muted);
    }
    .product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }
    .product-card:hover .product-thumb img { transform: scale(1.06); }
    .product-thumb .cat-tag {
        position: absolute;
        top: .6rem;
        left: .6rem;
        background: rgba(255, 255, 255, .92);
        color: var(--primary-color);
        font-size: .7rem;
        font-weight: 700;
        padding: .25rem .6rem;
        border-radius: 999px;
        backdrop-filter: blur(4px);
    }
    .product-thumb .stock-tag {
        position: absolute;
        top: .6rem;
        right: .6rem;
        background: #ef4444;
        color: #fff;
        font-size: .7rem;
        font-weight: 700;
        padding: .25rem .6rem;
        border-radius: 999px;
    }
    .product-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .product-title {
        font-size: .95rem;
        font-weight: 600;
        color: var(--ink);
        line-height: 1.35;
        margin-bottom: .5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.6em;
    }
    .product-foot {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .5rem;
        padding-top: .75rem;
    }
    .product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #dc2626;
    }
    .btn-view {
        border-radius: 999px;
        border: 1px solid var(--primary-color);
        background: transparent;
        color: var(--primary-color);
        font-size: .82rem;
        font-weight: 600;
        padding: .4rem .95rem;
        text-decoration: none;
        transition: all .18s ease;
        white-space: nowrap;
    }
    .btn-view:hover {
        background: var(--primary-color);
        color: #fff;
    }
    .btn-view.disabled { opacity: .45; pointer-events: none; }

    /* ===== Empty state ===== */
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        border: 1px dashed var(--line);
        border-radius: var(--radius-lg);
        background: var(--surface);
    }
    .empty-state i { font-size: 3rem; color: #cbd5e1; }

    /* ===== Responsive ===== */
    @media (max-width: 991.98px) {
        .feature-strip { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575.98px) {
        .feature-strip { grid-template-columns: 1fr; padding: 1rem; gap: .75rem; }
        .hero .hero-caption { align-items: center; text-align: center; }
        .product-foot { flex-direction: column; align-items: stretch; }
        .btn-view { text-align: center; }
    }
</style>
@endsection

@section('content')
<div class="container">

    {{-- ===== Hero ===== --}}
    @if($banners->count() > 0)
    <div id="heroCarousel" class="carousel slide hero mb-4" data-bs-ride="carousel">
        @if($banners->count() > 1)
        <div class="carousel-indicators mb-2">
            @foreach($banners as $index => $banner)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
                    class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        @endif

        <div class="carousel-inner">
            @foreach($banners as $index => $banner)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ asset('assets/uploads/banners/' . $banner->image) }}" alt="Banner {{ $index + 1 }}">
                <div class="hero-overlay"></div>
                <div class="hero-caption">
                    <span class="badge rounded-pill bg-white text-primary-theme mb-3 px-3 py-2 fw-semibold">
                        <i class="bi bi-stars me-1"></i>បទពិសោធន៍ទិញទំនិញថ្មី
                    </span>
                    <h1>ស្វាគមន៍មកកាន់ហាងយើងខ្ញុំ</h1>
                    <p>ទំនិញមានគុណភាព ម៉ូដទាន់សម័យ និងតម្លៃសមរម្យបំផុត</p>
                    <a href="#products" class="btn btn-light rounded-pill px-4 py-2 fw-semibold text-primary-theme">
                        ទិញទំនិញឥឡូវ <i class="bi bi-arrow-down ms-1"></i>
                    </a>
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

    {{-- ===== Feature strip ===== --}}
    <div class="feature-strip mb-4">
        <div class="feature">
            <i class="bi bi-truck"></i>
            <div><h6>ដឹកជញ្ជូនរហ័ស</h6><span>ឥតគិតថ្លៃចាប់ពី $50</span></div>
        </div>
        <div class="feature">
            <i class="bi bi-patch-check"></i>
            <div><h6>គុណភាពធានា</h6><span>ទំនិញ 100% ពិតប្រាកដ</span></div>
        </div>
        <div class="feature">
            <i class="bi bi-headset"></i>
            <div><h6>ជំនួយ 24/7</h6><span>ឆ្លើយតបគ្រប់ពេល</span></div>
        </div>
        <div class="feature">
            <i class="bi bi-shield-lock"></i>
            <div><h6>ទូទាត់សុវត្ថិភាព</h6><span>ការពារទិន្នន័យ</span></div>
        </div>
    </div>

    {{-- ===== Announcement ticker ===== --}}
    <div class="ticker-bar mb-5">
        <span class="ticker-tag"><i class="bi bi-megaphone-fill"></i><span class="d-none d-md-inline">ដំណឹងពិសេស</span></span>
        <div class="ticker-wrap">
            <div class="ticker-move">
                @for($i = 0; $i < 2; $i++)
                <div class="ticker-item"><i class="bi bi-star-fill text-warning me-2"></i>សូមស្វាគមន៍មកកាន់ហាងរបស់យើង! ទទួលបានការបញ្ចុះតម្លៃពិសេសសម្រាប់អតិថិជនថ្មី។</div>
                <div class="ticker-item"><i class="bi bi-truck text-warning me-2"></i>សេវាកម្មដឹកជញ្ជូនរហ័សទាន់ចិត្ត និងឥតគិតថ្លៃសម្រាប់ការកម្ម៉ង់ចាប់ពី $50 ឡើងទៅ!</div>
                <div class="ticker-item"><i class="bi bi-gift-fill text-warning me-2"></i>ទិញទំនិញថ្ងៃនេះ ដើម្បីទទួលបានកាដូពិសេសពីហាងយើងខ្ញុំ!</div>
                @endfor
            </div>
        </div>
    </div>

    {{-- ===== Categories ===== --}}
    <div class="section-head">
        <div>
            <div class="eyebrow">ប្រភេទទំនិញ</div>
            <h2>សូមជ្រើសរើសប្រភេទទំនិញ</h2>
        </div>
    </div>

    <div class="pill-row mb-4">
        <a href="{{ route('home') }}" class="cat-pill {{ !request('category') ? 'active' : '' }}">ទាំងអស់</a>
        @foreach($categories as $category)
        <a href="{{ route('home', ['category' => $category->id]) }}"
           class="cat-pill {{ request('category') == $category->id ? 'active' : '' }}">
            {{ $category->name }}
        </a>
        @endforeach
    </div>

    {{-- ===== Products ===== --}}
    <div id="products" class="section-head">
        <div>
            <div class="eyebrow">{{ request('q') || request('search') ? 'លទ្ធផលស្វែងរក' : 'បណ្តុំផលិតផល' }}</div>
            <h2>
                @if(request('q') || request('search'))
                    ស្វែងរក: "{{ request('q') ?? request('search') }}"
                @elseif(request('category'))
                    ផលិតផលក្នុងប្រភេទនេះ
                @else
                    ផលិតផលថ្មីៗ
                @endif
            </h2>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if(request('q') || request('search') || request('category'))
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-x-circle me-1"></i>សម្អាត
                </a>
            @endif
            <span class="text-muted small d-none d-sm-block">{{ $products->total() }} មុខទំនិញ</span>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-md-4 mb-5">
        @forelse($products as $product)
        <div class="col">
            <div class="product-card">
                <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none d-block">
                    <div class="product-thumb">
                        <img src="{{ $product->image ? asset('assets/uploads/products/' . $product->image) : 'https://via.placeholder.com/400x300' }}"
                             alt="{{ $product->name }}" loading="lazy">
                        @if($product->category)
                        <span class="cat-tag">{{ $product->category->name }}</span>
                        @endif
                        @if($product->stock_qty <= 0)
                        <span class="stock-tag">អស់ពីស្តុក</span>
                        @endif
                    </div>
                </a>
                <div class="product-body">
                    <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none">
                        <h6 class="product-title">{{ $product->name }}</h6>
                    </a>
                    <div class="product-foot">
                        <span class="product-price">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('product.show', $product->id) }}"
                           class="btn-view {{ $product->stock_qty <= 0 ? 'disabled' : '' }}">
                            <i class="bi bi-eye me-1"></i>មើល
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-box-seam d-block mb-3"></i>
                <h5 class="text-muted mb-1">មិនមានផលិតផលនៅទីនេះទេ</h5>
                <p class="text-muted small mb-3">សូមព្យាយាមជ្រើសរើសប្រភេទផ្សេង</p>
                <a href="{{ route('home') }}" class="btn btn-primary-theme rounded-pill px-4">មើលទំនិញទាំងអស់</a>
            </div>
        </div>
        @endforelse
    </div>

    {{-- ===== Pagination ===== --}}
    @if($products->hasPages())
    <div class="d-flex justify-content-center mb-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
