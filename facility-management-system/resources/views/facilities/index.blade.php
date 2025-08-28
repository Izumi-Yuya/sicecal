@extends('layouts.app')

@section('title', '施設一覧')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-building me-2"></i>施設一覧
        </h1>
        
        @php $user = session('user'); @endphp
        @if($user && in_array($user['role'], ['system_admin', 'editor']))
            <a href="{{ route('facilities.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>新規登録
            </a>
        @endif
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4 facility-search">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-search me-2"></i>検索・絞り込み
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('facilities.index') }}" id="searchForm">
                <div class="row g-3">
                    <!-- Department Filter -->
                    <div class="col-md-3">
                        <label for="department_id" class="form-label">部門</label>
                        <select class="form-select" id="department_id" name="department_id">
                            <option value="">すべての部門</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" 
                                        {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Facility Name Search -->
                    <div class="col-md-3">
                        <label for="facility_name" class="form-label">施設名</label>
                        <input type="text" 
                               class="form-control" 
                               id="facility_name" 
                               name="facility_name" 
                               value="{{ request('facility_name') }}" 
                               placeholder="施設名で検索">
                    </div>

                    <!-- Prefecture Filter -->
                    <div class="col-md-3">
                        <label for="prefecture" class="form-label">県名</label>
                        <select class="form-select" id="prefecture" name="prefecture">
                            <option value="">すべての県</option>
                            @foreach($prefectures as $prefecture)
                                <option value="{{ $prefecture }}" 
                                        {{ request('prefecture') == $prefecture ? 'selected' : '' }}>
                                    {{ $prefecture }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Keyword Search -->
                    <div class="col-md-3">
                        <label for="keyword" class="form-label">キーワード検索</label>
                        <input type="text" 
                               class="form-control" 
                               id="keyword" 
                               name="keyword" 
                               value="{{ request('keyword') }}" 
                               placeholder="キーワードで検索">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-2"></i>検索
                        </button>
                        <a href="{{ route('facilities.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>リセット
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="d-flex justify-content-between align-items-center mb-3 results-summary">
        <div class="text-muted">
            {{ $facilities->count() }}件の施設を表示
            @if(request()->hasAny(['search', 'facility_name', 'prefecture', 'department_id', 'keyword']))
                <span class="text-primary">（検索結果）</span>
            @endif
        </div>
        
        @if($user && in_array($user['role'], ['viewer_executive', 'viewer_department', 'viewer_district']))
            <div class="btn-group">
                <button type="button" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-file-earmark-spreadsheet me-1"></i>CSV出力
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-file-earmark-pdf me-1"></i>PDF出力
                </button>
            </div>
        @endif
    </div>

    <!-- Facilities Table -->
    <div class="card facility-list">
        <div class="card-body p-0">
            @if($facilities->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="30%">施設コード</th>
                                <th width="70%">施設名</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($facilities as $facility)
                                <tr class="facility-row" data-href="{{ route('facilities.show', $facility) }}" style="cursor: pointer;">
                                    <td>
                                        <code class="text-primary fw-bold">{{ $facility->facility_code }}</code>
                                    </td>
                                    <td>
                                        <strong class="text-dark">{{ $facility->name }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-building text-muted" style="font-size: 3rem;"></i>
                    <h5 class="text-muted mt-3">施設が見つかりませんでした</h5>
                    <p class="text-muted">検索条件を変更して再度お試しください。</p>
                </div>
            @endif
        </div>
    </div>


</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change
    const filterSelects = document.querySelectorAll('#department_id, #prefecture');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Auto-submit when filters change for better UX
            document.getElementById('searchForm').submit();
        });
    });

    // Handle CSV/PDF export buttons
    const csvBtn = document.querySelector('.btn-outline-success');
    const pdfBtn = document.querySelector('.btn-outline-danger');
    
    if (csvBtn) {
        csvBtn.addEventListener('click', function() {
            alert('CSV出力機能は今後実装予定です。');
        });
    }
    
    if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
            alert('PDF出力機能は今後実装予定です。');
        });
    }

    // Handle row clicks for facility details
    const facilityRows = document.querySelectorAll('.facility-row');
    facilityRows.forEach(row => {
        row.addEventListener('click', function() {
            const href = this.getAttribute('data-href');
            if (href) {
                window.location.href = href;
            }
        });

        // Add hover effect for better UX
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
            this.style.transform = 'translateX(2px)';
            this.style.transition = 'all 0.2s ease';
        });

        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'translateX(0)';
        });
    });

    // Add search input enhancement for all text inputs
    const searchInputs = document.querySelectorAll('#facility_name, #keyword');
    searchInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('searchForm').submit();
            }
        });
    });

    // Clear search functionality
    const clearBtn = document.querySelector('.btn-outline-secondary');
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Clear all form inputs
            document.querySelectorAll('#searchForm input, #searchForm select').forEach(input => {
                if (input.type === 'text' || input.type === 'search') {
                    input.value = '';
                } else if (input.tagName === 'SELECT') {
                    input.selectedIndex = 0;
                }
            });
            // Submit the cleared form
            document.getElementById('searchForm').submit();
        });
    }
});
</script>
@endpush
@endsection