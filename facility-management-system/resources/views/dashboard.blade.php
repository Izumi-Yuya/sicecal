{{--
    施設管理システム - ダッシュボード
    
    【機能概要】
    - ログインユーザーのウェルカム表示
    - システム統計情報の表示
    - 最近の活動履歴
    - クイックアクション
    - 各種通知（お知らせ、コメント、承認）
    - 契約期限アラート
    
    【表示内容】
    - ユーザー情報（名前、役割、ログイン時刻）
    - 施設数、承認待ち、期限切れ契約、未読コメント数
    - お知らせ一覧（システム障害、新機能、メンテナンス情報）
    - コメント通知・承認通知
    - 最近の活動履歴
    - クイックアクションボタン
    
    【技術仕様】
    - Bootstrap グリッドシステム使用
    - セッション情報からユーザー情報取得
    - レスポンシブデザイン対応
--}}

@extends('layouts.app')

@section('title', 'ダッシュボード')

@section('content')
{{-- ユーザーウェルカムセクション - ログインユーザー情報と役割を表示 --}}
@if($user)
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, rgba(0, 180, 227, 0.1) 0%, rgba(242, 124, 166, 0.1) 100%);">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 text-dark">
                            <i class="bi bi-person-circle me-2"></i>
                            <span data-user-name>{{ $user->name }}さん、おかえりなさい</span>
                        </h5>
                        <p class="mb-0 text-muted">
                            <span class="badge bg-primary me-2" data-user-role>{{ $user->role_display }}</span>
                            <span data-login-time>最終ログイン: {{ $user->logged_in_at->format('Y年m月d日 H:i') }}</span>
                        </p>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">施設管理システム</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- System Notifications Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">システムお知らせ</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-3">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-info-circle me-2 mt-1"></i>
                        <div>
                            <strong>システム障害のお知らせ</strong> - 2週間前<br>
                            <small class="text-muted">現在、一部のお客様においてシステムの接続が不安定な状況が発生しております。復旧対応中です。</small>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-success mb-3">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-star me-2 mt-1"></i>
                        <div>
                            <strong>新機能リリース予告</strong> - 3週間前<br>
                            <small class="text-muted">7月15日に新機能「自動集計機能」をリリース予定です。</small>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mb-0">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-tools me-2 mt-1"></i>
                        <div>
                            <strong>サービスメンテナンスのお知らせ</strong> - 3週間前<br>
                            <small class="text-muted">7月1日 01:00-05:00にメンテナンスを実施いたします。</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            @if($user->role === 'viewer_facility')
                                担当施設数
                            @else
                                総施設数
                            @endif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['total_facilities'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-building text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(in_array($user->role, ['system_admin', 'editor', 'approver', 'viewer_executive', 'viewer_department', 'viewer_regional']))
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            承認待ち
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['pending_approvals'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(in_array($user->role, ['system_admin', 'editor', 'approver', 'viewer_executive', 'viewer_department', 'viewer_regional']))
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            期限切れ契約
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['expiring_contracts'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(in_array($user->role, ['system_admin', 'editor', 'approver', 'viewer_executive', 'viewer_department', 'viewer_regional']))
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            未読コメント
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['unread_comments'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-chat-dots text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Recent Activities and Quick Actions -->
<div class="row">
    <!-- Recent Activities -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">最近の活動</h6>
                <a href="#" class="btn btn-sm btn-outline-primary">すべて見る</a>
            </div>
            <div class="card-body">
                @if(count($recentActivities) > 0)
                <div class="list-group list-group-flush">
                    @foreach($recentActivities as $activity)
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">{{ $activity['title'] }}</div>
                            <small class="text-muted">{{ $activity['description'] }}</small>
                        </div>
                        <small class="text-muted">{{ $activity['time'] }}</small>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                    <p class="mt-2">最近の活動はありません</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">クイックアクション</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if(in_array($user->role, ['system_admin', 'editor']))
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle me-2"></i>新規施設登録
                    </a>
                    @endif
                    
                    <a href="#" class="btn btn-outline-success">
                        <i class="bi bi-search me-2"></i>施設検索
                    </a>
                    
                    @if(in_array($user->role, ['system_admin', 'approver']))
                    <a href="#" class="btn btn-outline-warning">
                        <i class="bi bi-check-circle me-2"></i>承認待ち確認
                    </a>
                    @endif
                    
                    @if(in_array($user->role, ['system_admin', 'editor', 'approver', 'viewer_executive', 'viewer_department', 'viewer_regional']))
                    <a href="#" class="btn btn-outline-info">
                        <i class="bi bi-file-earmark-spreadsheet me-2"></i>レポート出力
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contract Alerts -->
        @if(count($contractAlerts) > 0)
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">契約期限アラート</h6>
            </div>
            <div class="card-body">
                <div class="small">
                    @foreach($contractAlerts as $alert)
                    <div class="alert alert-{{ $alert['alert_level'] }} py-2 mb-2">
                        <strong>{{ $alert['facility_name'] }}</strong><br>
                        {{ $alert['contract_type'] }}: {{ $alert['expiry_date'] }}まで
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Pending Comments for Primary Responders -->
        @if(count($pendingComments) > 0)
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">対応待ちコメント</h6>
            </div>
            <div class="card-body">
                @foreach($pendingComments as $comment)
                <div class="border-bottom pb-2 mb-2">
                    <div class="fw-bold small">{{ $comment['facility_name'] }}</div>
                    <div class="text-muted small">{{ $comment['content'] }}</div>
                    <div class="text-muted small">{{ $comment['posted_by'] }} - {{ $comment['posted_at'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Pending Approvals for Approvers -->
        @if(count($pendingApprovals) > 0)
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">承認待ち</h6>
            </div>
            <div class="card-body">
                @foreach($pendingApprovals as $approval)
                <div class="border-bottom pb-2 mb-2">
                    <div class="fw-bold small">{{ $approval['facility_name'] }}</div>
                    <div class="text-muted small">{{ $approval['type'] }}</div>
                    <div class="text-muted small">{{ $approval['requested_by'] }} - {{ $approval['requested_at'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection