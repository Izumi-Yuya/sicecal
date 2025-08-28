<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('facilities.index') }}">施設一覧</a></li>
                <li class="breadcrumb-item active" aria-current="page">施設詳細</li>
            </ol>
        </nav>
        <h1 class="h3 mb-0">
            <i class="bi bi-building me-2"></i>{{ $facility->name }}
        </h1>
    </div>
    
    @php $user = session('user'); @endphp
    <div class="btn-group">
        @if($user && in_array($user['role'], ['system_admin', 'editor']))
            <button type="button" class="btn btn-warning" id="editModeBtn">
                <i class="bi bi-pencil me-2"></i>編集モード
            </button>
            <button type="button" class="btn btn-success d-none" id="saveModeBtn">
                <i class="bi bi-check me-2"></i>保存
            </button>
            <button type="button" class="btn btn-secondary d-none" id="cancelModeBtn">
                <i class="bi bi-x me-2"></i>キャンセル
            </button>
        @endif
        @if($user && in_array($user['role'], ['system_admin', 'approver']))
            <button type="button" class="btn btn-info">
                <i class="bi bi-check-circle me-2"></i>承認
            </button>
        @endif
        @if($user && in_array($user['role'], ['viewer_executive', 'viewer_department', 'viewer_regional']))
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-download me-2"></i>出力
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-text me-2"></i>CSV出力</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-pdf me-2"></i>PDF出力</a></li>
                </ul>
            </div>
        @endif
        <a href="{{ route('facilities.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>一覧に戻る
        </a>
    </div>
</div>