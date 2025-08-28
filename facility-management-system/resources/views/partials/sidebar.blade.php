<!-- Sidebar Navigation -->
<nav class="shise-sidebar" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header d-lg-none">
        <h5 class="offcanvas-title" id="sidebarLabel">メニュー</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body p-0">
        <div class="shise-nav">
            @php
                $user = session('user');
                $userRole = $user['role'] ?? 'viewer_facility';
            @endphp
            
            <!-- Main Navigation -->
            <div class="nav-header">メインメニュー</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') || request()->is('/') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door"></i>HOME
                    </a>
                </li>
            </ul>

            @if($userRole === 'system_admin')
                <!-- システム管理者メニュー -->
                <div class="nav-header">管理機能</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities*') ? 'active' : '' }}" href="{{ route('facilities.index') }}">
                            <i class="bi bi-building"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" href="#">
                            <i class="bi bi-file-earmark-spreadsheet"></i>CSV出力
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/management') ? 'active' : '' }}" href="#">
                            <i class="bi bi-gear"></i>システム管理
                        </a>
                    </li>
                </ul>
            @elseif($userRole === 'editor')
                <!-- 編集者メニュー -->
                <div class="nav-header">編集機能</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities*') ? 'active' : '' }}" href="{{ route('facilities.index') }}">
                            <i class="bi bi-building"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" href="#">
                            <i class="bi bi-file-earmark-spreadsheet"></i>CSV出力
                        </a>
                    </li>
                </ul>
            @elseif($userRole === 'approver')
                <!-- 承認者メニュー -->
                <div class="nav-header">承認機能</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities*') ? 'active' : '' }}" href="{{ route('facilities.index') }}">
                            <i class="bi bi-building"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('approvals') ? 'active' : '' }}" href="#">
                            <i class="bi bi-check-circle"></i>承認待ち
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" href="#">
                            <i class="bi bi-file-earmark-spreadsheet"></i>CSV出力
                        </a>
                    </li>
                </ul>
            @elseif($userRole === 'viewer_facility')
                <!-- 事業所閲覧者メニュー -->
                <div class="nav-header">施設情報</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities/detail') ? 'active' : '' }}" href="#">
                            <i class="bi bi-info-circle"></i>施設詳細
                        </a>
                    </li>
                </ul>
            @else
                <!-- その他の閲覧者メニュー -->
                <div class="nav-header">閲覧機能</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities*') ? 'active' : '' }}" href="{{ route('facilities.index') }}">
                            <i class="bi bi-building"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" href="#">
                            <i class="bi bi-file-earmark-spreadsheet"></i>CSV出力
                        </a>
                    </li>
                </ul>
            @endif


        </div>
    </div>
</nav>