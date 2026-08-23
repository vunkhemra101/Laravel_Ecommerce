<nav class="navbar navbar-expand-lg navbar-dark bg-primary-theme shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
            <i class="bi bi-shop me-2 fs-3"></i>
            ហាងរបស់ខ្ញុំ
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Search Bar -->
            <form class="d-flex mx-auto position-relative" style="max-width: 400px; width: 100%;" onsubmit="return false;">
                <div class="input-group">
                    <input class="form-control rounded-start-pill border-0" type="search" placeholder="ស្វែងរកផលិតផល..." id="searchInput" aria-label="Search" autocomplete="off">
                    <button class="btn btn-light rounded-end-pill" type="button" id="searchBtn">
                        <i class="bi bi-search text-primary-theme"></i>
                    </button>
                </div>
                <!-- Search Results Dropdown -->
                <div class="dropdown-menu w-100 position-absolute mt-1 shadow" id="searchResults" style="display: none; top: 100%;">
                    <!-- Results will be injected here via AJAX -->
                </div>
            </form>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <!-- Categories Dropdown -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ប្រភេទទំនិញ
                    </a>
                    <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('home') }}">ទាំងអស់</a></li>
                        @php
                            if(class_exists('\App\Models\Category')){
                                $navbarCategories = \App\Models\Category::all();
                            } else {
                                $navbarCategories = [];
                            }
                        @endphp
                        @foreach($navbarCategories as $cat)
                        <li><a class="dropdown-item" href="{{ route('home', ['category' => $cat->id]) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <!-- Cart -->
                <li class="nav-item me-3">
                    <a class="nav-link position-relative text-white" href="{{ route('cart.index') ?? '#' }}">
                        <i class="bi bi-cart3 fs-5"></i>
                        @php
                            $cartItemCount = 0;
                            if(session()->has('cart')) {
                                foreach(session('cart') as $item) {
                                    $cartItemCount += $item['quantity'] ?? 1;
                                }
                            }
                        @endphp
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadge" style="{{ $cartItemCount == 0 ? 'display: none;' : '' }}">
                            {{ $cartItemCount }}
                        </span>
                    </a>
                </li>

                <!-- User Menu -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">ចូលគណនី</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm ms-2 rounded-pill px-3" href="{{ route('register') }}">ចុះឈ្មោះ</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('assets/uploads/profiles/' . Auth::user()->profile_image) }}" class="rounded-circle me-1 object-fit-cover" width="30" height="30" alt="Avatar">
                            @else
                                <i class="bi bi-person-circle fs-5 me-1"></i>
                            @endif
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
                            @if(Auth::user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>  </a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-person me-2"></i>គណនីរបស់ខ្ញុំ</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right me-2"></i>ចាកចេញ</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
