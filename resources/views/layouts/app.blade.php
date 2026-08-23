<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ហាងលក់ទំនិញអនឡាញ')</title>
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
    </style>
    @yield('styles')
</head>
<body>
    @include('partials.navbar')

    <main class="py-4">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @yield('scripts')
</body>
</html>
