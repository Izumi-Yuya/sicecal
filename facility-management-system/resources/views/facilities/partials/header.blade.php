<!-- Facility Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('facilities.index') }}">施設一覧</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $facility->name }}</li>
            </ol>
        </nav>
        <h1 class="h3 mb-0">
            <i class="bi bi-building me-2"></i>{{ $facility->name }}
            <small class="text-muted">（{{ $facility->facility_code }}）</small>
        </h1>
    </div>
    
    <div class="d-flex gap-2">
        @php $user = session('user'); @endphp
        @if($user && in_array((is_array($user) ? $user['role'] : $user->role), ['system_admin', 'editor']))
            <button type="button" class="btn btn-outline-primary" id="editToggleBtn">
                <i class="bi bi-pencil me-2"></i>編集モード
            </button>
            <button type="button" class="btn btn-primary d-none" id="saveBtn">
                <i class="bi bi-check-circle me-2"></i>保存
            </button>
            <button type="button" class="btn btn-outline-secondary d-none" id="cancelBtn">
                <i class="bi bi-x-circle me-2"></i>キャンセル
            </button>
        @endif
        
        <a href="{{ route('facilities.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>一覧に戻る
        </a>
    </div>
</div>