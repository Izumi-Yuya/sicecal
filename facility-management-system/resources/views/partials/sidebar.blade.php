<!-- Sidebar Navigation -->
<nav class="shise-sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
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
            
            <!-- HOME - 全ロール共通 -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') || request()->is('/') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door me-2"></i>HOME
                    </a>
                </li>
            </ul>

            @if($userRole === 'system_admin')
                <!-- システム管理者メニュー -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities') ? 'active' : '' }}" href="#">
                            <i class="bi bi-list-ul me-2"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" href="#">
                            <i class="bi bi-plus-circle me-2"></i>CSV出力
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/management') ? 'active' : '' }}" href="#">
                            <i class="bi bi-plus-circle me-2"></i>管理
                        </a>
                    </li>
                </ul>
            @elseif($userRole === 'editor')
                <!-- 編集者メニュー -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities') ? 'active' : '' }}" href="#">
                            <i class="bi bi-list-ul me-2"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" href="#">
                            <i class="bi bi-plus-circle me-2"></i>CSV出力
                        </a>
                    </li>
                </ul>
            @elseif($userRole === 'approver')
                <!-- 承認者メニュー -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities') ? 'active' : '' }}" href="#">
                            <i class="bi bi-list-ul me-2"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('approvals') ? 'active' : '' }}" href="#">
                            <i class="bi bi-plus-circle me-2"></i>承認
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" href="#">
                            <i class="bi bi-plus-circle me-2"></i>CSV出力
                        </a>
                    </li>
                </ul>
            @elseif($userRole === 'viewer_facility')
                <!-- 事業所閲覧者メニュー -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities/detail') ? 'active' : '' }}" href="#">
                            <i class="bi bi-plus-circle me-2"></i>施設詳細
                        </a>
                    </li>
                </ul>
            @else
                <!-- その他の閲覧者メニュー -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities') ? 'active' : '' }}" href="#">
                            <i class="bi bi-list-ul me-2"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" href="#">
                            <i class="bi bi-plus-circle me-2"></i>CSV出力
                        </a>
                    </li>
                </ul>
            @endif


        </div>
    </div>
</nav>