<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shise-Cal') }}@hasSection('title') - @yield('title')@endif</title>
    
    <!-- Accessibility meta tags -->
    <meta name="description" content="施設管理システム - 施設情報の一元管理">
    <meta name="theme-color" content="#00B4E3">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=noto-sans-jp:400,500,600,700" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <!-- Skip links for keyboard navigation -->
    <a href="#main-content" class="skip-link">メインコンテンツへスキップ</a>
    <a href="#sidebar-nav" class="skip-link">ナビゲーションへスキップ</a>
    
    <div class="shise-cal-layout">
        <!-- Header -->
        <header class="shise-header" role="banner">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Logo -->
                    <div class="shise-logo">
                        <a href="{{ route('dashboard') }}" aria-label="Shise-Cal ホームページに戻る">
                            <img src="{{ asset('images/shise-cal-logo.png') }}" alt="Shise-Cal ロゴ" class="logo-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="logo-fallback" style="display: none;">
                                <div class="logo-icon">
                                    <i class="bi bi-building-fill" aria-hidden="true"></i>
                                </div>
                                <span class="logo-text">Shise-Cal</span>
                            </div>
                        </a>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar" aria-label="ナビゲーションメニューを開く">
                        <i class="bi bi-list" aria-hidden="true"></i>
                        <span class="sr-only">メニュー</span>
                    </button>

                    <!-- User/Approver Section -->
                    <div class="approver-section ms-auto">
                        @if(session('user'))
                            <!-- Logged in user dropdown -->
                            <div class="dropdown">
                                <button class="btn approver-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @php $user = session('user'); @endphp
                                    {{ is_array($user) ? $user['name'] : $user->name }}
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
            @include('partials.sidebar')

            <!-- Main Content -->
            <main class="shise-content" id="main-content" role="main" tabindex="-1">
                <!-- Alert Messages - Using Design System Alert Components -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
                        <i class="bi bi-check-circle me-2" aria-hidden="true"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="成功メッセージを閉じる"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" aria-live="assertive">
                        <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="エラーメッセージを閉じる"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" aria-live="polite">
                        <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>{{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="警告メッセージを閉じる"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert" aria-live="polite">
                        <i class="bi bi-info-circle me-2" aria-hidden="true"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="情報メッセージを閉じる"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>