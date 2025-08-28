<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shise-Cal') }}@hasSection('title') - @yield('title')@endif</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=noto-sans-jp:400,500,600,700" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="shise-cal-layout">
        <!-- Header -->
        <header class="shise-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Logo -->
                    <div class="shise-logo">
                        <img src="{{ asset('images/shise-cal-logo.png') }}" alt="Shise-Cal" class="logo-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="logo-fallback" style="display: none;">
                            <div class="logo-icon">
                                <i class="bi bi-building-fill"></i>
                            </div>
                            <span class="logo-text">Shise-Cal</span>
                        </div>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                        <i class="bi bi-list"></i>
                    </button>

                    <!-- User/Approver Section -->
                    <div class="approver-section ms-auto">
                        @if(session('user'))
                            <!-- Logged in user dropdown -->
                            <div class="dropdown">
                                <button class="btn approver-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @php $user = session('user'); @endphp
                                    @if($user['role'] === 'approver')
                                        承認者 {{ $user['name'] }}
                                    @elseif($user['role'] === 'facility')
                                        {{ $user['name'] }}
                                    @else
                                        {{ $user['name'] }}
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline" id="logout-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item" onclick="return confirm('ログアウトしますか？')">
                                                <i class="bi bi-box-arrow-right me-2"></i>ログアウト
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <!-- Not logged in - show login button -->
                            <a href="{{ route('login') }}" class="btn approver-btn">
                                ログイン
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <div class="shise-main-container">
            <!-- Sidebar -->
            <nav class="shise-sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
                <div class="offcanvas-header d-lg-none">
                    <h5 class="offcanvas-title" id="sidebarLabel">メニュー</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Close"></button>
                </div>
                
                <div class="offcanvas-body p-0">
                    <ul class="nav flex-column shise-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door me-2"></i>
                                HOME
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('facilities') ? 'active' : '' }}" href="#">
                                <i class="bi bi-list-ul me-2"></i>
                                施設一覧
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('facilities/create') ? 'active' : '' }}" href="#">
                                <i class="bi bi-plus-circle me-2"></i>
                                施設登録
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('facilities/register') ? 'active' : '' }}" href="#">
                                <i class="bi bi-plus-square me-2"></i>
                                施設登録
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="shise-content">
                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    
    <!-- Bootstrap JavaScript for dropdown functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
            
            // Handle logout form submission
            const logoutForm = document.getElementById('logout-form');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    console.log('Logout form submitted');
                });
            }
        });
    </script>
</body>
</html>