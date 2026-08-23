@extends('layouts.app')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-primary-theme">ទំព័រដើម</a></li>
            @if($product->category ?? false)
            <li class="breadcrumb-item"><a href="{{ route('home', ['category' => $product->category_id]) }}" class="text-decoration-none text-primary-theme">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name ?? 'ផលិតផល' }}</li>
        </ol>
    </nav>

    <div class="row bg-white p-4 rounded shadow-sm mb-5">
        <!-- Product Image -->
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="{{ isset($product->image) && $product->image ? asset('assets/uploads/products/' . $product->image) : 'https://via.placeholder.com/500' }}" class="img-fluid rounded w-100 object-fit-cover" alt="{{ $product->name ?? '' }}" style="max-height: 500px;">
        </div>
        
        <!-- Product Details -->
        <div class="col-md-6">
            @if($product->category ?? false)
            <span class="badge bg-info mb-2">{{ $product->category->name }}</span>
            @endif
            <h2 class="fw-bold mb-3">{{ $product->name ?? 'ឈ្មោះផលិតផល' }}</h2>
            <h3 class="text-danger fw-bold mb-3">${{ number_format($product->price ?? 0, 2) }}</h3>
            
            <div class="mb-3 text-muted">
                <i class="bi bi-box-seam me-1"></i> ស្តុកដែលមាន: 
                <span class="fw-bold {{ ($product->stock_qty ?? 0) > 0 ? 'text-success' : 'text-danger' }}">{{ $product->stock_qty ?? 0 }}</span>
            </div>

            <div class="mb-4">
                <p>{{ $product->description ?? 'មិនមានការពិពណ៌នា។' }}</p>
            </div>

            <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                @if($product->size)
                <div class="mb-4">
                    <label class="form-label fw-bold">ជ្រើសរើសទំហំ:</label>
                    <div class="d-flex gap-2">
                        @foreach(explode(',', $product->size) as $size)
                        <input type="radio" class="btn-check" name="size" id="size_{{ $size }}" value="{{ $size }}" autocomplete="off" {{ $loop->first ? 'checked' : '' }}>
                        <label class="btn btn-outline-dark px-4" for="size_{{ $size }}">{{ $size }}</label>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-4">
                    <label class="form-label fw-bold">ចំនួន:</label>
                    <div class="input-group" style="width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="decrementQty()">-</button>
                        <input type="number" class="form-control text-center" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_qty ?? 10 }}">
                        <button class="btn btn-outline-secondary" type="button" onclick="incrementQty()">+</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-theme btn-lg px-5 py-3 w-100 rounded-pill" {{ ($product->stock_qty ?? 0) <= 0 ? 'disabled' : '' }}>
                    <i class="bi bi-cart-plus fs-5 me-2"></i> 
                    {{ ($product->stock_qty ?? 0) > 0 ? 'បន្ថែមទៅកន្ត្រក' : 'អស់ពីស្តុក' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Related Products -->
    @php
        if(isset($product) && class_exists('\App\Models\Product')){
            $related = \App\Models\Product::where('category_id', $product->category_id)
                        ->where('id', '!=', $product->id)
                        ->take(4)
                        ->get();
        } else {
            $related = collect();
        }
    @endphp
    @if($related->count() > 0)
    <h4 class="fw-bold mb-4">ផលិតផលស្រដៀងគ្នា</h4>
    <div class="row row-cols-2 row-cols-lg-4 g-4">
        @foreach($related as $rel)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm product-card transition-hover">
                <a href="{{ route('product.show', $rel->id) }}" class="text-decoration-none">
                    <img src="{{ $rel->image ? asset('assets/uploads/products/' . $rel->image) : 'https://via.placeholder.com/300' }}" class="card-img-top object-fit-cover" alt="{{ $rel->name }}" style="height: 200px;">
                </a>
                <div class="card-body">
                    <h6 class="card-title text-truncate">{{ $rel->name }}</h6>
                    <div class="text-danger fw-bold">${{ number_format($rel->price, 2) }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
    function incrementQty() {
        let input = document.getElementById('quantity');
        let max = parseInt(input.getAttribute('max'));
        if(parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
    function decrementQty() {
        let input = document.getElementById('quantity');
        if(parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
@endsection
