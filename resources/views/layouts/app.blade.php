<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Click Shop')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Kantumruy+Pro:wght@400;500;600;700&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-color: #010E28;
            --primary-hover: #021a4a;
            --secondary-color: #f8f9fa;
        }
        body {
            font-family: 'Kantumruy Pro', 'Noto Sans Khmer', 'Inter', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .text-primary-theme {
            color: var(--primary-color) !important;
        }
        .bg-primary-theme {
            background-color: var(--primary-color) !important;
            color: #fff;
        }
        .btn-primary-theme {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }
        .btn-primary-theme:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            color: #fff;
        }

        /* ===== Progress Bar ===== */
        #page-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #010E28, #4f6df5, #818cf8);
            z-index: 99999;
            transition: width 0.4s ease, opacity 0.3s ease;
            box-shadow: 0 0 10px rgba(79, 109, 245, 0.7);
            opacity: 0;
        }
        #page-progress-bar.active {
            opacity: 1;
        }

        /* ===== Smooth Page Transitions ===== */
        main.py-4 {
            transition: opacity 0.25s ease;
        }
        main.page-leaving {
            opacity: 0.3;
        }
        main.page-entering {
            animation: fadeInUp 0.3s ease forwards;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== Toast Notifications ===== */
        #toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 99998;
            display: flex;
            flex-direction: column-reverse;
            gap: 10px;
            pointer-events: none;
        }
        .app-toast {
            pointer-events: auto;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            max-width: 420px;
            padding: 14px 20px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            color: #fff;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
            transform: translateX(120%);
            animation: toastSlideIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .app-toast.removing {
            animation: toastSlideOut 0.35s ease forwards;
        }
        .app-toast.success {
            background: linear-gradient(135deg, #059669, #10b981);
        }
        .app-toast.error {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }
        .app-toast .toast-icon {
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        .app-toast .toast-message {
            flex: 1;
        }
        .app-toast .toast-close {
            flex-shrink: 0;
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 0 2px;
            transition: color 0.2s;
        }
        .app-toast .toast-close:hover {
            color: #fff;
        }
        .app-toast .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: rgba(255,255,255,0.4);
            border-radius: 0 0 12px 12px;
            animation: toastCountdown 3s linear forwards;
        }
        @keyframes toastSlideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0); opacity: 1; }
        }
        @keyframes toastSlideOut {
            from { transform: translateX(0); opacity: 1; }
            to   { transform: translateX(120%); opacity: 0; }
        }
        @keyframes toastCountdown {
            from { width: 100%; }
            to   { width: 0%; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Progress Bar -->
    <div id="page-progress-bar"></div>

    @include('partials.navbar')

    <main class="py-4 page-entering">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Toast Container -->
    <div id="toast-container"></div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // ===== Progress Bar =====
        const progressBar = document.getElementById('page-progress-bar');

        function startProgress() {
            progressBar.style.width = '0';
            progressBar.classList.add('active');
            // Quick jump to ~30%
            requestAnimationFrame(() => {
                progressBar.style.width = '30%';
            });
            // Then slowly crawl to ~80%
            setTimeout(() => { progressBar.style.width = '60%'; }, 300);
            setTimeout(() => { progressBar.style.width = '80%'; }, 800);
        }

        function finishProgress() {
            progressBar.style.width = '100%';
            setTimeout(() => {
                progressBar.classList.remove('active');
                progressBar.style.width = '0';
            }, 350);
        }

        // ===== Smooth Navigation Interception =====
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href');
            // Skip non-navigating links
            if (!href || href === '#' || href.startsWith('javascript:') ||
                link.hasAttribute('target') || link.hasAttribute('data-bs-toggle') ||
                link.hasAttribute('data-no-transition') || link.onclick) return;

            // Only intercept same-origin navigations
            try {
                const url = new URL(href, window.location.origin);
                if (url.origin !== window.location.origin) return;
            } catch { return; }

            // Start smooth exit
            startProgress();
            document.querySelector('main.py-4').classList.add('page-leaving');
        });

        // Handle form submissions (non-AJAX forms that navigate)
        document.addEventListener('submit', function(e) {
            const form = e.target;
            // Don't intercept AJAX forms or forms marked to skip
            if (form.hasAttribute('data-ajax') || form.hasAttribute('data-no-transition')) return;
            startProgress();
            document.querySelector('main.py-4').classList.add('page-leaving');
        });

        // On page load complete
        window.addEventListener('load', function() {
            finishProgress();
        });

        // On back/forward navigation
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                // Page restored from bfcache
                document.querySelector('main.py-4').classList.remove('page-leaving');
                finishProgress();
            }
        });

        // ===== Global Toast Function =====
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'app-toast ' + type;

            const icon = type === 'success' ? 'bi-check-lg' : 'bi-x-lg';
            toast.innerHTML = `
                <span class="toast-icon"><i class="bi ${icon}"></i></span>
                <span class="toast-message">${message}</span>
                <button class="toast-close" onclick="dismissToast(this)"><i class="bi bi-x"></i></button>
                <div class="toast-progress"></div>
            `;

            container.appendChild(toast);

            // Auto-remove after 3s
            setTimeout(() => {
                if (toast.parentNode) dismissToast(toast.querySelector('.toast-close'));
            }, 3000);
        }

        function dismissToast(closeBtn) {
            const toast = closeBtn.closest('.app-toast');
            if (!toast || toast.classList.contains('removing')) return;
            toast.classList.add('removing');
            setTimeout(() => toast.remove(), 350);
        }

        // Show flash messages from server as toasts
        @if(session('success'))
            showToast(@json(session('success')), 'success');
        @endif
        @if(session('error'))
            showToast(@json(session('error')), 'error');
        @endif
    </script>
    @yield('scripts')
</body>
</html>
