<!-- Sidebar Navigation -->
<nav class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header d-lg-none">
        <h5 class="offcanvas-title" id="sidebarLabel">メニュー</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body p-0">
        <div class="sidebar-nav">
            <!-- Dashboard -->
            <div class="nav-section">
                <h6 class="nav-section-title">ダッシュボード</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-2"></i>ホーム
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i>ダッシュボード
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Facility Management -->
            <div class="nav-section">
                <h6 class="nav-section-title">施設管理</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities') ? 'active' : '' }}" href="#">
                            <i class="bi bi-building me-2"></i>施設一覧
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities/create') ? 'active' : '' }}" href="#">
                            <i class="bi bi-plus-circle me-2"></i>施設登録
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('facilities/search') ? 'active' : '' }}" href="#">
                            <i class="bi bi-search me-2"></i>施設検索
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Approval Management -->
            <div class="nav-section">
                <h6 class="nav-section-title">承認管理</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('approvals/pending') ? 'active' : '' }}" href="#">
                            <i class="bi bi-check-circle me-2"></i>承認待ち
                            <span class="badge bg-warning rounded-pill ms-auto">5</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('approvals/history') ? 'active' : '' }}" href="#">
                            <i class="bi bi-clock-history me-2"></i>承認履歴
                        </a>
                    </li>
                </ul>
            </div>

            <!-- File Management -->
            <div class="nav-section">
                <h6 class="nav-section-title">ファイル管理</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('documents') ? 'active' : '' }}" href="#">
                            <i class="bi bi-file-earmark-pdf me-2"></i>ドキュメント
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('documents/upload') ? 'active' : '' }}" href="#">
                            <i class="bi bi-upload me-2"></i>ファイルアップロード
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Reports -->
            <div class="nav-section">
                <h6 class="nav-section-title">レポート</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/csv') ? 'active' : '' }}" href="#">
                            <i class="bi bi-file-earmark-spreadsheet me-2"></i>CSV出力
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/pdf') ? 'active' : '' }}" href="#">
                            <i class="bi bi-file-earmark-pdf me-2"></i>PDF出力
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports/favorites') ? 'active' : '' }}" href="#">
                            <i class="bi bi-star me-2"></i>お気に入り設定
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Maintenance -->
            <div class="nav-section">
                <h6 class="nav-section-title">修繕管理</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('maintenance') ? 'active' : '' }}" href="#">
                            <i class="bi bi-tools me-2"></i>修繕履歴
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('annual-verification') ? 'active' : '' }}" href="#">
                            <i class="bi bi-calendar-event me-2"></i>年次確認
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Comments -->
            <div class="nav-section">
                <h6 class="nav-section-title">コミュニケーション</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('comments') ? 'active' : '' }}" href="#">
                            <i class="bi bi-chat-dots me-2"></i>コメント管理
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('meetings') ? 'active' : '' }}" href="#">
                            <i class="bi bi-calendar3 me-2"></i>定例会
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Administration -->
            <div class="nav-section">
                <h6 class="nav-section-title">システム管理</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="#">
                            <i class="bi bi-people me-2"></i>ユーザー管理
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/audit-logs') ? 'active' : '' }}" href="#">
                            <i class="bi bi-shield-check me-2"></i>監査ログ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}" href="#">
                            <i class="bi bi-gear me-2"></i>システム設定
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>