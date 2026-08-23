<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ប្រព័ន្ធគ្រប់គ្រង</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Khmer:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --sidebar-bg: #010E28;
            --sidebar-color: #94a3b8;
            --sidebar-hover-bg: rgba(255, 255, 255, 0.05);
            --sidebar-active-bg: rgba(99, 102, 241, 0.1);
            --sidebar-active-color: #ffffff;
            --accent-color: #818cf8;
            --body-bg: #f8fafc;
            --card-border-radius: 1rem;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            --font-family: 'Inter', 'Noto Sans Khmer', sans-serif;
        }
        body { font-family: var(--font-family); background-color: var(--body-bg); color: #1e293b; }
        .sidebar { width: 280px; height: 100vh; position: fixed; top: 0; left: 0; background-color: var(--sidebar-bg); color: var(--sidebar-color); transition: transform 0.3s ease; z-index: 1040; overflow-y: auto; }
        .sidebar-header { padding: 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .sidebar-brand { color: #ffffff; font-size: 1.25rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 0.75rem; }
        .nav-section-title { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #64748b; padding: 1.5rem 1.5rem 0.5rem; font-weight: 600; }
        .sidebar-link { display: flex; align-items: center; padding: 0.75rem 1.5rem; color: var(--sidebar-color); text-decoration: none; transition: all 0.2s; border-left: 3px solid transparent; }
        .sidebar-link i { font-size: 1.25rem; margin-right: 1rem; color: #64748b; transition: color 0.2s; }
        .sidebar-link:hover { color: #ffffff; background-color: var(--sidebar-hover-bg); }
        .sidebar-link:hover i { color: var(--accent-color); }
        .sidebar-link.active { color: var(--sidebar-active-color); background-color: var(--sidebar-active-bg); border-left-color: var(--accent-color); }
        .sidebar-link.active i { color: var(--accent-color); }
        .main-wrapper { margin-left: 280px; min-height: 100vh; display: flex; flex-direction: column; transition: margin-left 0.3s ease; }
        .topbar { height: 70px; background-color: #ffffff; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; padding: 0 1.5rem; position: sticky; top: 0; z-index: 1030; }
        .mobile-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: #475569; cursor: pointer; }
        .content-area { flex: 1; padding: 1.5rem; }
        .card { border: none; border-radius: var(--card-border-radius); box-shadow: var(--card-shadow); margin-bottom: 1.5rem; }
        .table > :not(caption) > * > * { padding: 1rem 1.5rem; border-bottom-color: #f1f5f9; }
        .table th { font-weight: 600; color: #64748b; background-color: #f8fafc; text-transform: uppercase; font-size: 0.75rem; }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .mobile-toggle { display: block; }
            .sidebar-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.5); z-index: 1035; display: none; }
            .sidebar-overlay.show { display: block; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') ?? '#' }}" class="sidebar-brand">
                <i class="bi bi-basket2-fill text-primary" style="color: var(--accent-color) !important;"></i>
                <span>ShopAdmin</span>
            </a>
        </div>
        <div class="sidebar-nav">
            <div class="nav-section-title">ផ្ទាំងគ្រប់គ្រង</div>
            @php $currentRoute = request()->route() ? request()->route()->getName() : ''; @endphp
            
            <a href="{{ route('admin.dashboard') ?? '#' }}" class="sidebar-link {{ $currentRoute == 'admin.dashboard' ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>ទិដ្ឋភាពទូទៅ
            </a>
            <a href="{{ route('admin.analytics') ?? '#' }}" class="sidebar-link {{ $currentRoute == 'admin.analytics' ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i>វិភាគទិន្នន័យ
            </a>
            <a href="{{ route('admin.reports') ?? '#' }}" class="sidebar-link {{ $currentRoute == 'admin.reports' ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>របាយការណ៍
            </a>

            <div class="nav-section-title">ការគ្រប់គ្រង</div>
            <a href="{{ route('admin.orders.index') ?? '#' }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.orders') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i>ការបញ្ជាទិញ
            </a>
            <a href="{{ route('admin.products.index') ?? '#' }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.products') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>ផលិតផល
            </a>
            <a href="{{ route('admin.categories.index') ?? '#' }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.categories') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>ប្រភេទផលិតផល
            </a>
            <a href="{{ route('admin.banners.index') ?? '#' }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.banners') ? 'active' : '' }}">
                <i class="bi bi-images"></i>ផ្ទាំងផ្សព្វផ្សាយ (Banners)
            </a>
            <a href="{{ route('admin.users.index') ?? '#' }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.users') ? 'active' : '' }}">
                <i class="bi bi-people"></i>អ្នកប្រើប្រាស់
            </a>

            <div class="nav-section-title">គណនី</div>
            <a href="/" class="sidebar-link">
                <i class="bi bi-shop"></i>ទៅកាន់ហាង
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link">
                <i class="bi bi-box-arrow-right"></i>ចាកចេញ
            </a>
            <form id="logout-form" action="{{ route('logout') ?? '#' }}" method="POST" class="d-none">@csrf</form>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <button class="mobile-toggle" id="mobileToggle"><i class="bi bi-list"></i></button>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=818cf8&color=fff" alt="Admin" class="rounded-circle me-2" width="32" height="32">
                        <span class="text-dark fw-medium">អ្នកគ្រប់គ្រង</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-person me-2"></i>ប្រវត្តិរូប</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>ចាកចេញ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Global Loading Spinner -->
        <div id="global-loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.7); z-index: 9999; flex-direction: column; justify-content: center; align-items: center;">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h5 class="fw-bold text-primary">កំពុងផ្ទុកទិន្នន័យ...</h5>
        </div>

        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileToggle = document.getElementById('mobileToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
            }
            mobileToggle.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', toggleSidebar);
        });

        // SPA-like navigation for admin panel to prevent page reloads
        function handleAjaxLoad(url) {
            document.getElementById('global-loader').style.display = 'flex';
            document.querySelector('.content-area').style.opacity = '0.7';
            
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    const newContent = doc.querySelector('.content-area');
                    if (newContent) {
                        document.querySelector('.content-area').innerHTML = newContent.innerHTML;
                        document.title = doc.title;
                        
                        // Re-evaluate scripts in new content if necessary (like Chart.js)
                        const scripts = document.querySelector('.content-area').querySelectorAll('script');
                        scripts.forEach(oldScript => {
                            const newScript = document.createElement('script');
                            Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                            newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                            oldScript.parentNode.replaceChild(newScript, oldScript);
                        });
                    }
                    document.querySelector('.content-area').style.opacity = '1';
                    document.getElementById('global-loader').style.display = 'none';
                })
                .catch(() => window.location.href = url);
        }

        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            // Intercept local links, except those with targets, onclicks, or anchors
            if (link && link.href && link.href.startsWith(window.location.origin) && 
                !link.hasAttribute('target') && !link.onclick && 
                link.getAttribute('href') !== '#' && !link.hasAttribute('data-bs-toggle')) {
                
                const url = new URL(link.href);
                if (url.pathname.startsWith('/admin')) {
                    // SPA navigation for admin pages
                    e.preventDefault();
                    history.pushState(null, '', link.href);
                    handleAjaxLoad(link.href);
                } else {
                    // Show loader even when leaving admin panel
                    document.getElementById('global-loader').style.display = 'flex';
                }
            }
        });

        document.addEventListener('submit', function(e) {
            // Intercept GET forms like Search filters
            if (e.target.method && e.target.method.toLowerCase() === 'get') {
                const url = new URL(e.target.action || window.location.href);
                
                // Only intercept admin forms
                if (url.pathname.startsWith('/admin')) {
                    e.preventDefault();
                    const formData = new FormData(e.target);
                    const search = new URLSearchParams(formData);
                    url.search = search.toString();
                    history.pushState(null, '', url.toString());
                    handleAjaxLoad(url.toString());
                }
            }
        });

        window.addEventListener('popstate', function() {
            handleAjaxLoad(window.location.href);
        });
    </script>
    @yield('scripts')
</body>
</html>
