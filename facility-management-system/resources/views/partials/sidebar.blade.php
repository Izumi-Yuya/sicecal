<!-- Sidebar Navigation -->
<nav class="shise-sidebar" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel" role="navigation">
    <div class="offcanvas-header d-lg-none">
        <h5 class="offcanvas-title" id="sidebarLabel">ナビゲーションメニュー</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="ナビゲーションメニューを閉じる"></button>
    </div>
    
    <div class="offcanvas-body p-0">
        <div class="shise-nav">
            @php
                $user = session('user');
                $userRole = $user ? (is_array($user) ? $user['role'] : $user->role) : 'viewer_facility';
            @endphp
            
            <!-- Main Navigation -->
            <div class="nav-header" role="heading" aria-level="2">メインメニュー</div>
            <ul class="nav flex-column" id="sidebar-nav" role="menubar">
                <li class="nav-item" role="none">
                    <a class="nav-link {{ request()->is('dashboard') || request()->is('/') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}" 
                       role="menuitem"
                       @if(request()->is('dashboard') || request()->is('/')) aria-current="page" @endif>
                        <i class="bi bi-house-door" aria-hidden="true"></i>HOME
                    </a>
                </li>
            </ul>

            @if($userRole === 'system_admin')
                <!-- システム管理者メニュー -->
                <div class="nav-header" role="heading" aria-level="2">管理機能</div>
                <ul class="nav flex-column" role="menubar">
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('facilities*') ? 'active' : '' }}" 
                           href="{{ route('facilities.index') }}" 
                           role="menuitem"
                           @if(request()->is('facilities*')) aria-current="page" @endif>
                            <i class="bi bi-building" aria-hidden="true"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" 
                           href="#" 
                           role="menuitem"
                           @if(request()->is('reports/csv')) aria-current="page" @endif>
                            <i class="bi bi-file-earmark-spreadsheet" aria-hidden="true"></i>CSV出力
                        </a>
                    </li>
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('admin/management') ? 'active' : '' }}" 
                           href="#" 
                           role="menuitem"
                           @if(request()->is('admin/management')) aria-current="page" @endif>
                            <i class="bi bi-gear" aria-hidden="true"></i>システム管理
                        </a>
                    </li>
                </ul>
            @elseif($userRole === 'editor')
                <!-- 編集者メニュー -->
                <div class="nav-header" role="heading" aria-level="2">編集機能</div>
                <ul class="nav flex-column" role="menubar">
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('facilities*') ? 'active' : '' }}" 
                           href="{{ route('facilities.index') }}" 
                           role="menuitem"
                           @if(request()->is('facilities*')) aria-current="page" @endif>
                            <i class="bi bi-building" aria-hidden="true"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" 
                           href="#" 
                           role="menuitem"
                           @if(request()->is('reports/csv')) aria-current="page" @endif>
                            <i class="bi bi-file-earmark-spreadsheet" aria-hidden="true"></i>CSV出力
                        </a>
                    </li>
                </ul>
            @elseif($userRole === 'approver')
                <!-- 承認者メニュー -->
                <div class="nav-header" role="heading" aria-level="2">承認機能</div>
                <ul class="nav flex-column" role="menubar">
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('facilities*') ? 'active' : '' }}" 
                           href="{{ route('facilities.index') }}" 
                           role="menuitem"
                           @if(request()->is('facilities*')) aria-current="page" @endif>
                            <i class="bi bi-building" aria-hidden="true"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('approvals') ? 'active' : '' }}" 
                           href="#" 
                           role="menuitem"
                           @if(request()->is('approvals')) aria-current="page" @endif>
                            <i class="bi bi-check-circle" aria-hidden="true"></i>承認待ち
                        </a>
                    </li>
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" 
                           href="#" 
                           role="menuitem"
                           @if(request()->is('reports/csv')) aria-current="page" @endif>
                            <i class="bi bi-file-earmark-spreadsheet" aria-hidden="true"></i>CSV出力
                        </a>
                    </li>
                </ul>
            @elseif($userRole === 'viewer_facility')
                <!-- 事業所閲覧者メニュー -->
                <div class="nav-header" role="heading" aria-level="2">施設情報</div>
                <ul class="nav flex-column" role="menubar">
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('facilities/detail') ? 'active' : '' }}" 
                           href="#" 
                           role="menuitem"
                           @if(request()->is('facilities/detail')) aria-current="page" @endif>
                            <i class="bi bi-info-circle" aria-hidden="true"></i>施設詳細
                        </a>
                    </li>
                </ul>
            @else
                <!-- その他の閲覧者メニュー -->
                <div class="nav-header" role="heading" aria-level="2">閲覧機能</div>
                <ul class="nav flex-column" role="menubar">
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('facilities*') ? 'active' : '' }}" 
                           href="{{ route('facilities.index') }}" 
                           role="menuitem"
                           @if(request()->is('facilities*')) aria-current="page" @endif>
                            <i class="bi bi-building" aria-hidden="true"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item" role="none">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" 
                           href="#" 
                           role="menuitem"
                           @if(request()->is('reports/csv')) aria-current="page" @endif>
                            <i class="bi bi-file-earmark-spreadsheet" aria-hidden="true"></i>CSV出力
                        </a>
                    </li>
                </ul>
            @endif


        </div>
    </div>
</nav>