@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>កន្ត្រកទំនិញរបស់អ្នក</h3>

    @if(session('cart') && count(session('cart')) > 0)
    <div class="row" id="cart-content">
        <!-- Cart Items -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="cart-table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">ផលិតផល</th>
                                    <th scope="col">តម្លៃ</th>
                                    <th scope="col">ចំនួន</th>
                                    <th scope="col">សរុប</th>
                                    <th scope="col" class="pe-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $key => $details)
                                    @php $total += ($details['price'] ?? 0) * ($details['quantity'] ?? 1); @endphp
                                    <tr data-cart-key="{{ $key }}" data-price="{{ $details['price'] ?? 0 }}">
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ isset($details['image']) && $details['image'] ? asset('assets/uploads/products/' . $details['image']) : 'https://via.placeholder.com/80' }}" class="rounded object-fit-cover me-3" width="80" height="80" alt="{{ $details['name'] ?? '' }}">
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $details['name'] ?? 'N/A' }}</h6>
                                                    @if(!empty($details['size']))
                                                    <span class="badge bg-secondary">ទំហំ: {{ $details['size'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($details['price'] ?? 0, 2) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-secondary qty-btn" onclick="changeQty('{{ $key }}', -1, this)">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number"
                                                       value="{{ $details['quantity'] ?? 1 }}"
                                                       min="1"
                                                       class="form-control form-control-sm text-center mx-1 qty-input"
                                                       style="width: 55px;"
                                                       data-cart-key="{{ $key }}"
                                                       onchange="updateQty('{{ $key }}', this.value, this)">
                                                <button type="button" class="btn btn-sm btn-outline-secondary qty-btn" onclick="changeQty('{{ $key }}', 1, this)">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-danger item-subtotal">${{ number_format(($details['price'] ?? 0) * ($details['quantity'] ?? 1), 2) }}</td>
                                        <td class="pe-4 text-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" title="លុបចោល" onclick="removeItem('{{ $key }}', this)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">សរុបការបញ្ជាទិញ</h5>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">តម្លៃសរុបបណ្តោះអាសន្ន</span>
                        <span class="fw-bold" id="cart-subtotal">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">សេវាដឹកជញ្ជូន</span>
                        <span class="text-success">ឥតគិតថ្លៃ</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">តម្លៃសរុបទាំងអស់</span>
                        <span class="fw-bold fs-4 text-danger" id="cart-total">${{ number_format($total, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout.index') ?? '#' }}" class="btn btn-primary-theme w-100 py-3 rounded-pill fw-bold fs-5">
                        បន្តទៅបង់ប្រាក់
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty Cart (hidden by default when cart has items) -->
    <div class="text-center py-5 bg-white rounded shadow-sm" id="empty-cart" style="display: none;">
        <i class="bi bi-cart-x text-muted opacity-50 mb-4" style="font-size: 8rem;"></i>
        <h4 class="text-muted mb-4">កន្ត្រកទំនិញរបស់អ្នកទទេ</h4>
        <a href="{{ route('home') }}" class="btn btn-primary-theme px-5 py-2 rounded-pill">
            <i class="bi bi-arrow-left me-2"></i>បន្តការទិញទំនិញ
        </a>
    </div>

    @else
    <!-- Empty Cart -->
    <div class="text-center py-5 bg-white rounded shadow-sm" id="empty-cart">
        <i class="bi bi-cart-x text-muted opacity-50 mb-4" style="font-size: 8rem;"></i>
        <h4 class="text-muted mb-4">កន្ត្រកទំនិញរបស់អ្នកទទេ</h4>
        <a href="{{ route('home') }}" class="btn btn-primary-theme px-5 py-2 rounded-pill">
            <i class="bi bi-arrow-left me-2"></i>បន្តការទិញទំនិញ
        </a>
    </div>
    @endif
</div>

<style>
    .qty-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s;
    }
    .qty-btn:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
    }
    .qty-input {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    .qty-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.15rem rgba(1, 14, 40, 0.15);
    }
    tr.removing {
        transition: all 0.4s ease;
        opacity: 0;
        transform: translateX(-30px);
        max-height: 0;
    }
    .price-flash {
        animation: priceFlash 0.5s ease;
    }
    @keyframes priceFlash {
        0%   { color: #dc3545; transform: scale(1); }
        50%  { color: #0d6efd; transform: scale(1.15); }
        100% { color: #dc3545; transform: scale(1); }
    }
</style>
@endsection

@section('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ===== Update Quantity via AJAX =====
    function changeQty(cartKey, delta, btn) {
        const row = btn.closest('tr');
        const input = row.querySelector('.qty-input');
        let newQty = parseInt(input.value) + delta;
        if (newQty < 1) newQty = 1;
        input.value = newQty;
        updateQty(cartKey, newQty, input);
    }

    let updateTimeout = {};
    function updateQty(cartKey, quantity, input) {
        quantity = parseInt(quantity);
        if (isNaN(quantity) || quantity < 1) {
            input.value = 1;
            quantity = 1;
        }

        // Debounce: wait 300ms before sending request
        clearTimeout(updateTimeout[cartKey]);
        updateTimeout[cartKey] = setTimeout(() => {
            const row = input.closest('tr');
            const price = parseFloat(row.dataset.price);

            // Optimistic UI update
            const subtotalEl = row.querySelector('.item-subtotal');
            const newSubtotal = price * quantity;
            subtotalEl.textContent = '$' + newSubtotal.toFixed(2);
            subtotalEl.classList.remove('price-flash');
            void subtotalEl.offsetWidth; // force reflow
            subtotalEl.classList.add('price-flash');
            recalculateTotal();

            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ cart_key: cartKey, quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    showToast(data.error, 'error');
                    location.reload(); // revert to server state
                } else {
                    updateCartBadge();
                    showToast('បរិមាណត្រូវបានធ្វើបច្ចុប្បន្នភាព', 'success');
                }
            })
            .catch(() => {
                showToast('មានបញ្ហាក្នុងការធ្វើបច្ចុប្បន្នភាព', 'error');
            });
        }, 300);
    }

    // ===== Remove Item via AJAX =====
    function removeItem(cartKey, btn) {
        const row = btn.closest('tr');

        // Disable button immediately
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';

        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ cart_key: cartKey })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                showToast(data.error, 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-trash"></i>';
                return;
            }

            // Smooth removal animation
            row.classList.add('removing');
            setTimeout(() => {
                row.remove();
                recalculateTotal();
                updateCartBadge();

                // Check if cart is now empty
                const remainingRows = document.querySelectorAll('#cart-table tbody tr');
                if (remainingRows.length === 0) {
                    const cartContent = document.getElementById('cart-content');
                    const emptyCart = document.getElementById('empty-cart');
                    if (cartContent) {
                        cartContent.style.transition = 'opacity 0.3s ease';
                        cartContent.style.opacity = '0';
                        setTimeout(() => {
                            cartContent.style.display = 'none';
                            emptyCart.style.display = 'block';
                            emptyCart.style.opacity = '0';
                            emptyCart.style.transition = 'opacity 0.3s ease';
                            requestAnimationFrame(() => { emptyCart.style.opacity = '1'; });
                        }, 300);
                    }
                }

                showToast('ផលិតផលត្រូវបានដកចេញពីកន្ត្រក', 'success');
            }, 400);
        })
        .catch(() => {
            showToast('មានបញ្ហាក្នុងការលុប', 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-trash"></i>';
        });
    }

    // ===== Recalculate Total =====
    function recalculateTotal() {
        let total = 0;
        document.querySelectorAll('#cart-table tbody tr:not(.removing)').forEach(row => {
            const price = parseFloat(row.dataset.price);
            const qty = parseInt(row.querySelector('.qty-input').value);
            total += price * qty;
        });
        const formatted = '$' + total.toFixed(2);
        document.getElementById('cart-subtotal').textContent = formatted;

        const totalEl = document.getElementById('cart-total');
        totalEl.textContent = formatted;
        totalEl.classList.remove('price-flash');
        void totalEl.offsetWidth;
        totalEl.classList.add('price-flash');
    }

    // ===== Update Navbar Cart Badge =====
    function updateCartBadge() {
        let totalQty = 0;
        document.querySelectorAll('#cart-table tbody tr:not(.removing) .qty-input').forEach(input => {
            totalQty += parseInt(input.value) || 0;
        });
        const badge = document.getElementById('cartBadge');
        if (badge) {
            if (totalQty > 0) {
                badge.textContent = totalQty;
                badge.style.display = '';
            } else {
                badge.style.display = 'none';
            }
        }
    }
</script>
@endsection
