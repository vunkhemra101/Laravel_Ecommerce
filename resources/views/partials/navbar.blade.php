@php
    $cartItemCount = 0;
    if (session()->has('cart')) {
        foreach (session('cart') as $item) {
            $cartItemCount += (int)($item['quantity'] ?? 1);
        }
    }

    if (class_exists('\App\Models\Category')) {
        $navCategories = \App\Models\Category::withCount(['products' => function($q) {
            $q->active();
        }])->orderBy('name')->get();
        $totalActiveProducts = \App\Models\Product::active()->count();
    } else {
        $navCategories = collect();
        $totalActiveProducts = 0;
    }
@endphp

<nav class="navbar navbar-expand-lg custom-navbar sticky-top">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center text-decoration-none py-1" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo12.png') }}" alt="Click Shop" class="navbar-brand-logo">
        </a>

        <!-- Mobile Action Buttons (Visible only on mobile/tablet < 992px) -->
        <div class="d-flex align-items-center gap-2 d-lg-none">
            <!-- Mobile Cart Button (Always visible) -->
            <a href="{{ route('cart.index') }}" class="mobile-action-btn position-relative" aria-label="កន្ត្រកទំនិញ" title="កន្ត្រកទំនិញ">
                <i class="bi bi-bag fs-5"></i>
                <span class="cart-badge badge rounded-pill bg-danger position-absolute" id="cartBadgeMobile" style="{{ $cartItemCount == 0 ? 'display: none;' : '' }}">
                    {{ $cartItemCount }}
                </span>
            </a>

            <!-- Mobile Hamburger Toggler with 3-line animated icon -->
            <button class="navbar-toggler custom-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainCollapse" aria-controls="navbarMainCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-bar top-bar"></span>
                <span class="toggler-bar mid-bar"></span>
                <span class="toggler-bar bot-bar"></span>
            </button>
        </div>

        <!-- Collapsible Content -->
        <div class="collapse navbar-collapse" id="navbarMainCollapse">
            <!-- Desktop Nav Links (Home & Categories) -->
            <ul class="navbar-nav me-lg-3 mb-2 mb-lg-0 align-items-lg-center d-none d-lg-flex">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('home') && !request('category') && !request('q') && !request('search') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i>ទំព័រដើម
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-custom dropdown-toggle {{ request()->filled('category') ? 'active' : '' }}" href="#" id="desktopCatDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-grid me-1"></i>ប្រភេទទំនិញ
                    </a>
                    <ul class="dropdown-menu custom-dropdown-menu shadow-lg border-0 py-2 mt-2" aria-labelledby="desktopCatDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center justify-content-between py-2 {{ !request('category') ? 'active-item' : '' }}" href="{{ route('home') }}">
                                <span><i class="bi bi-collection me-2 text-primary-theme"></i>ទាំងអស់</span>
                                <span class="badge bg-light text-dark rounded-pill">{{ $totalActiveProducts }}</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        @foreach($navCategories as $cat)
                        <li>
                            <a class="dropdown-item d-flex align-items-center justify-content-between py-2 {{ request('category') == $cat->id ? 'active-item' : '' }}" href="{{ route('home', ['category' => $cat->id]) }}">
                                <span><i class="bi bi-tag me-2 text-muted"></i>{{ $cat->name }}</span>
                                <span class="badge bg-light text-muted rounded-pill">{{ $cat->products_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <!-- Unified Search Bar (Centered on Desktop, Prominent on Mobile) -->
            <div class="navbar-search-wrapper mx-lg-auto my-3 my-lg-0 w-100 position-relative">
                <form action="{{ route('home') }}" method="GET" class="search-form" autocomplete="off">
                    <div class="search-input-group">
                        <i class="bi bi-search search-icon text-muted"></i>
                        <input class="form-control search-input" type="search" name="q" id="searchInput"
                               value="{{ request('q') ?? request('search') }}"
                               placeholder="ស្វែងរកផលិតផល..."
                               autocomplete="off" aria-label="Search">
                        <button type="button" class="btn-clear-search d-none" aria-label="Clear search">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                        <button type="submit" class="btn-search-submit" id="searchBtn">
                            ស្វែងរក
                        </button>
                    </div>
                </form>

                <!-- Live Search Results Floating Card -->
                <div class="search-dropdown-results shadow-lg" id="searchResults" style="display: none;">
                    <div class="search-results-content"></div>
                </div>
            </div>

            <!-- Mobile Navigation Links (< 992px) -->
            <div class="mobile-nav-section d-lg-none pt-2 border-top">
                <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') && !request('category') && !request('q') && !request('search') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-house-door fs-5 text-primary-theme"></i>
                        <span class="fw-medium">ទំព័រដើម</span>
                    </div>
                    <i class="bi bi-chevron-right text-muted small"></i>
                </a>

                <!-- Mobile Categories Accordion -->
                <div class="mobile-cat-accordion mt-1">
                    <a class="mobile-nav-item d-flex align-items-center justify-content-between text-decoration-none"
                       data-bs-toggle="collapse" href="#mobileCategoriesCollapse" role="button" aria-expanded="{{ request()->filled('category') ? 'true' : 'false' }}" aria-controls="mobileCategoriesCollapse">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-grid fs-5 text-primary-theme"></i>
                            <span class="fw-medium">ប្រភេទទំនិញ</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary-subtle text-dark rounded-pill">{{ $navCategories->count() }}</span>
                            <i class="bi bi-chevron-down text-muted small accordion-arrow"></i>
                        </div>
                    </a>
                    <div class="collapse {{ request()->filled('category') ? 'show' : '' }} ps-3 mt-1" id="mobileCategoriesCollapse">
                        <a href="{{ route('home') }}" class="mobile-subnav-item {{ !request('category') ? 'active-subnav' : '' }}">
                            <span>ទាំងអស់</span>
                            <span class="badge bg-light text-muted">{{ $totalActiveProducts }}</span>
                        </a>
                        @foreach($navCategories as $cat)
                        <a href="{{ route('home', ['category' => $cat->id]) }}" class="mobile-subnav-item {{ request('category') == $cat->id ? 'active-subnav' : '' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="badge bg-light text-muted">{{ $cat->products_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Actions (Desktop Cart & User Menu) -->
            <div class="d-flex align-items-lg-center gap-2 ms-lg-3 mt-3 mt-lg-0">
                <!-- Desktop Cart Button -->
                <div class="d-none d-lg-block">
                    <a class="nav-action-btn position-relative" href="{{ route('cart.index') }}" title="កន្ត្រកទំនិញ" aria-label="កន្ត្រកទំនិញ">
                        <i class="bi bi-bag fs-5"></i>
                        <span class="cart-badge badge rounded-pill bg-danger position-absolute" id="cartBadge" style="{{ $cartItemCount == 0 ? 'display: none;' : '' }}">
                            {{ $cartItemCount }}
                        </span>
                    </a>
                </div>

                <!-- Guest Links -->
                @guest
                    <!-- Desktop Auth Buttons -->
                    <div class="d-none d-lg-flex align-items-center gap-2">
                        <a class="btn btn-ghost-dark rounded-pill px-3 py-1.5 fw-medium" href="{{ route('login') }}">
                            ចូលគណនី
                        </a>
                        <a class="btn btn-primary-theme rounded-pill px-3 py-1.5 fw-medium shadow-sm" href="{{ route('register') }}">
                            ចុះឈ្មោះ
                        </a>
                    </div>

                    <!-- Mobile Auth Buttons -->
                    <div class="d-lg-none w-100 pt-3 border-top mt-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <a class="btn btn-outline-dark w-100 rounded-pill py-2 fw-medium text-center" href="{{ route('login') }}">
                                    ចូលគណនី
                                </a>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-primary-theme w-100 rounded-pill py-2 fw-medium text-center" href="{{ route('register') }}">
                                    ចុះឈ្មោះ
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Authenticated User (Desktop Dropdown) -->
                    <div class="dropdown d-none d-lg-block">
                        <button class="user-pill-btn dropdown-toggle d-flex align-items-center gap-2" type="button" id="userMenuDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('assets/uploads/profiles/' . Auth::user()->profile_image) }}" class="rounded-circle object-fit-cover user-avatar" width="30" height="30" alt="Avatar">
                            @else
                                <div class="user-avatar-initials">
                                    {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="fw-semibold text-dark text-truncate user-name-label">
                                {{ Auth::user()->name }}
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu shadow-lg border-0 py-2 mt-2" aria-labelledby="userMenuDesktop">
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-bold text-dark text-truncate">{{ Auth::user()->name }}</div>
                                <div class="small text-muted text-truncate">{{ Auth::user()->email }}</div>
                                @if(Auth::user()->isAdmin())
                                    <span class="badge bg-primary-subtle text-primary mt-1">អ្នកគ្រប់គ្រង (Admin)</span>
                                @endif
                            </li>
                            @if(Auth::user()->isAdmin())
                                <li>
                                    <a class="dropdown-item py-2 text-primary fw-medium" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>ផ្ទាំងគ្រប់គ្រង Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                            @endif
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.index') }}">
                                    <i class="bi bi-person me-2 text-muted"></i>គណនីរបស់ខ្ញុំ
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item py-2 text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>ចាកចេញ
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <!-- Authenticated User (Mobile Card) -->
                    <div class="mobile-user-card d-lg-none w-100 pt-3 border-top mt-3">
                        <div class="d-flex align-items-center gap-3 p-2.5 bg-light rounded-3 mb-2">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('assets/uploads/profiles/' . Auth::user()->profile_image) }}" class="rounded-circle object-fit-cover user-avatar" width="42" height="42" alt="Avatar">
                            @else
                                <div class="user-avatar-initials" style="width: 42px; height: 42px; font-size: 1.1rem;">
                                    {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="fw-bold text-dark text-truncate">{{ Auth::user()->name }}</div>
                                <div class="small text-muted text-truncate">{{ Auth::user()->email }}</div>
                                @if(Auth::user()->isAdmin())
                                    <span class="badge bg-primary-subtle text-primary">អ្នកគ្រប់គ្រង (Admin)</span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-1">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-item text-primary fw-semibold">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-speedometer2 fs-5"></i>
                                        <span>ផ្ទាំងគ្រប់គ្រង Admin</span>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted small"></i>
                                </a>
                            @endif
                            <a href="{{ route('profile.index') }}" class="mobile-nav-item">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-person fs-5 text-muted"></i>
                                    <span>គណនីរបស់ខ្ញុំ</span>
                                </div>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 d-flex align-items-center justify-content-center gap-2 fw-medium">
                                    <i class="bi bi-box-arrow-right"></i>ចាកចេញ
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<style>
    /* ===== Navbar Root & Container ===== */
    .custom-navbar {
        background-color: #ffffff;
        border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 4px 20px -2px rgba(1, 14, 40, 0.05);
        padding: 0.65rem 0;
        transition: all 0.25s ease;
        z-index: 1030;
    }

    /* ===== Brand Logo ===== */
    .navbar-brand-logo {
        height: 44px;
        width: auto;
        object-fit: contain;
        display: block;
        transition: transform 0.2s ease;
    }
    .navbar-brand:hover .navbar-brand-logo {
        transform: scale(1.03);
    }
    @media (max-width: 575.98px) {
        .navbar-brand-logo {
            height: 36px;
        }
    }

    /* ===== Navigation Links (Desktop) ===== */
    .nav-link-custom {
        color: #334155 !important;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 0.85rem !important;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .nav-link-custom:hover {
        color: var(--primary-color) !important;
        background-color: #f8fafc;
    }
    .nav-link-custom.active {
        color: var(--primary-color) !important;
        font-weight: 600;
        background-color: #f1f5f9;
    }

    /* ===== Custom Dropdown Menu ===== */
    .custom-dropdown-menu {
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.08) !important;
        box-shadow: 0 16px 36px -8px rgba(1, 14, 40, 0.16) !important;
        min-width: 220px;
        animation: dropFadeIn 0.2s ease forwards;
    }
    @keyframes dropFadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .custom-dropdown-menu .dropdown-item {
        font-size: 0.92rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        margin: 1px 6px;
        width: auto;
        transition: all 0.15s ease;
    }
    .custom-dropdown-menu .dropdown-item:hover {
        background-color: #f1f5f9;
        color: var(--primary-color);
    }
    .custom-dropdown-menu .dropdown-item.active-item {
        background-color: #eff6ff;
        color: var(--primary-color);
        font-weight: 600;
    }

    /* ===== Search Bar ===== */
    .navbar-search-wrapper {
        max-width: 440px;
    }
    .search-input-group {
        display: flex;
        align-items: center;
        background-color: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 9999px;
        padding: 3px 4px 3px 14px;
        transition: all 0.2s ease;
    }
    .search-input-group:focus-within {
        background-color: #ffffff;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(1, 14, 40, 0.08);
    }
    .search-icon {
        font-size: 0.95rem;
        margin-right: 8px;
        pointer-events: none;
    }
    .search-input {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 0.4rem 0.25rem !important;
        font-size: 0.92rem;
        color: #0f172a;
    }
    .search-input::placeholder {
        color: #94a3b8;
    }
    .btn-clear-search {
        background: transparent;
        border: none;
        color: #94a3b8;
        padding: 0 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        font-size: 1rem;
        transition: color 0.15s ease;
    }
    .btn-clear-search:hover {
        color: #64748b;
    }
    .btn-search-submit {
        background-color: var(--primary-color);
        color: #ffffff;
        border: none;
        border-radius: 9999px;
        padding: 0.42rem 1.15rem;
        font-size: 0.88rem;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .btn-search-submit:hover {
        background-color: var(--primary-hover);
        color: #ffffff;
    }

    /* ===== Search Dropdown Results ===== */
    .search-dropdown-results {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 16px 40px -8px rgba(1, 14, 40, 0.18);
        max-height: 400px;
        overflow-y: auto;
        z-index: 1050;
    }
    .search-result-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        transition: background-color 0.15s ease;
    }
    .search-result-item:last-child {
        border-bottom: none;
    }
    .search-result-item:hover, .search-result-item:focus {
        background-color: #f8fafc;
    }
    .search-result-thumb {
        width: 44px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px;
        background-color: #f1f5f9;
        flex-shrink: 0;
    }
    .search-result-title {
        font-size: 0.92rem;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.3;
    }
    .search-result-price {
        font-size: 0.85rem;
        font-weight: 700;
        color: #ef4444;
    }

    /* ===== Cart Buttons & Badges ===== */
    .nav-action-btn, .mobile-action-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0f172a;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .nav-action-btn:hover, .mobile-action-btn:hover {
        background-color: #f1f5f9;
        color: var(--primary-color);
        transform: translateY(-1px);
    }
    .cart-badge {
        top: -3px;
        right: -3px;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.25em 0.55em;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
        transition: transform 0.2s ease;
    }
    .cart-badge.badge-pop {
        animation: badgePop 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    @keyframes badgePop {
        0% { transform: scale(0.6); }
        50% { transform: scale(1.35); }
        100% { transform: scale(1); }
    }

    /* ===== Mobile Toggler Animation ===== */
    .custom-toggler {
        width: 40px;
        height: 40px;
        padding: 9px 8px;
        border-radius: 10px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        box-shadow: none !important;
        transition: background 0.2s ease;
    }
    .custom-toggler:hover {
        background-color: #f1f5f9;
    }
    .custom-toggler .toggler-bar {
        display: block;
        width: 20px;
        height: 2px;
        background-color: #0f172a;
        border-radius: 2px;
        transition: transform 0.25s ease, opacity 0.25s ease;
    }
    .custom-toggler:not(.collapsed) .top-bar {
        transform: translateY(7px) rotate(45deg);
    }
    .custom-toggler:not(.collapsed) .mid-bar {
        opacity: 0;
    }
    .custom-toggler:not(.collapsed) .bot-bar {
        transform: translateY(-7px) rotate(-45deg);
    }

    /* ===== User Profile Pills & Avatars ===== */
    .user-pill-btn {
        background-color: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 9999px;
        padding: 4px 12px 4px 6px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .user-pill-btn:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }
    .user-avatar-initials {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), #4f46e5);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .user-name-label {
        max-width: 130px;
        font-size: 0.92rem;
    }
    .btn-ghost-dark {
        color: #0f172a;
        background: transparent;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    .btn-ghost-dark:hover {
        background-color: #f1f5f9;
        color: var(--primary-color);
    }

    /* ===== Mobile Navigation Menu Items ===== */
    .mobile-nav-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 0.85rem;
        border-radius: 10px;
        color: #0f172a;
        text-decoration: none;
        transition: background-color 0.15s ease;
    }
    .mobile-nav-item:hover, .mobile-nav-item:focus {
        background-color: #f8fafc;
        color: var(--primary-color);
    }
    .mobile-nav-item.active {
        background-color: #eff6ff;
        color: var(--primary-color);
        font-weight: 600;
    }
    .mobile-subnav-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.55rem 0.75rem;
        font-size: 0.9rem;
        color: #475569;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.15s ease;
    }
    .mobile-subnav-item:hover {
        background-color: #f8fafc;
        color: var(--primary-color);
    }
    .mobile-subnav-item.active-subnav {
        background-color: #eff6ff;
        color: var(--primary-color);
        font-weight: 600;
    }
    .accordion-arrow {
        transition: transform 0.2s ease;
    }
    [aria-expanded="true"] .accordion-arrow {
        transform: rotate(180deg);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== 1. Cart Badge Synchronization =====
    const desktopBadge = document.getElementById('cartBadge');
    const mobileBadge = document.getElementById('cartBadgeMobile');

    function syncCartBadges() {
        if (!desktopBadge || !mobileBadge) return;
        const text = desktopBadge.textContent.trim();
        const display = desktopBadge.style.display;
        mobileBadge.textContent = text;
        mobileBadge.style.display = display;
    }

    if (desktopBadge && mobileBadge) {
        const badgeObserver = new MutationObserver(syncCartBadges);
        badgeObserver.observe(desktopBadge, {
            childList: true,
            characterData: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['style', 'class']
        });
    }

    // Expose global updater function
    window.updateCartBadgeCount = function(count) {
        document.querySelectorAll('.cart-badge').forEach(b => {
            if (count > 0) {
                b.textContent = count;
                b.style.display = '';
                b.classList.remove('badge-pop');
                void b.offsetWidth;
                b.classList.add('badge-pop');
            } else {
                b.style.display = 'none';
            }
        });
    };

    // ===== 2. Search Autocomplete Functionality =====
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const resultsContent = searchResults ? searchResults.querySelector('.search-results-content') : null;
    const btnClearSearch = document.querySelector('.btn-clear-search');

    if (searchInput && searchResults && resultsContent) {
        let debounceTimer = null;

        function toggleClearBtn() {
            if (btnClearSearch) {
                if (searchInput.value.trim().length > 0) {
                    btnClearSearch.classList.remove('d-none');
                } else {
                    btnClearSearch.classList.add('d-none');
                }
            }
        }
        toggleClearBtn();

        if (btnClearSearch) {
            btnClearSearch.addEventListener('click', function() {
                searchInput.value = '';
                toggleClearBtn();
                searchResults.style.display = 'none';
                searchInput.focus();
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        searchInput.addEventListener('input', function() {
            toggleClearBtn();
            const query = this.value.trim();

            clearTimeout(debounceTimer);

            if (query.length < 2) {
                searchResults.style.display = 'none';
                resultsContent.innerHTML = '';
                return;
            }

            // Show loading placeholder
            resultsContent.innerHTML = `
                <div class="p-3 text-center text-muted small">
                    <span class="spinner-border spinner-border-sm text-primary-theme me-2" role="status"></span>
                    កំពុងស្វែងរក...
                </div>
            `;
            searchResults.style.display = 'block';

            debounceTimer = setTimeout(() => {
                fetch(`/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (!Array.isArray(data) || data.length === 0) {
                            resultsContent.innerHTML = `
                                <div class="p-4 text-center text-muted">
                                    <i class="bi bi-search fs-3 d-block mb-2 text-secondary opacity-50"></i>
                                    <div class="fw-semibold text-dark">រកមិនឃើញផលិតផលទេ</div>
                                    <small class="text-secondary">សូមសាកល្បងពាក្យគន្លឹះផ្សេងទៀត</small>
                                </div>
                            `;
                            searchResults.style.display = 'block';
                            return;
                        }

                        let html = '<div class="py-1">';
                        data.forEach(item => {
                            html += `
                                <a class="search-result-item" href="${item.url}">
                                    <img src="${item.image_url}" class="search-result-thumb" alt="${escapeHtml(item.name)}" onerror="this.src='/assets/images/logo12.png'">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="search-result-title text-truncate">${escapeHtml(item.name)}</div>
                                        <div class="d-flex align-items-center gap-2 mt-0.5">
                                            <span class="search-result-price">$${item.price}</span>
                                            ${item.category_name ? `<span class="badge bg-light text-secondary small">${escapeHtml(item.category_name)}</span>` : ''}
                                        </div>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted small"></i>
                                </a>
                            `;
                        });
                        html += `
                            <div class="p-2 text-center border-top bg-light">
                                <a href="/?q=${encodeURIComponent(query)}" class="btn btn-sm btn-link text-decoration-none text-primary-theme fw-semibold p-0">
                                    មើលលទ្ធផលទាំងអស់ (${data.length}) <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>`;

                        resultsContent.innerHTML = html;
                        searchResults.style.display = 'block';
                    })
                    .catch(() => {
                        searchResults.style.display = 'none';
                    });
            }, 250);
        });

        // Close search results on outside click
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchResults.style.display = 'none';
            }
        });
    }

    // ===== 3. Close mobile collapse on navigation link clicks =====
    const collapseEl = document.getElementById('navbarMainCollapse');
    if (collapseEl) {
        collapseEl.querySelectorAll('a:not([data-bs-toggle])').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992 && typeof bootstrap !== 'undefined') {
                    const bsCollapse = bootstrap.Collapse.getInstance(collapseEl);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });
    }
});
</script>