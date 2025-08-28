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
@if(session('user'))
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, rgba(0, 180, 227, 0.1) 0%, rgba(242, 124, 166, 0.1) 100%);">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 text-dark">
                            <i class="bi bi-person-circle me-2"></i>
                            {{ session('user.name') }}さん、おかえりなさい
                        </h5>
                        <p class="mb-0 text-muted">
                            <span class="badge bg-primary me-2">{{ session('user.role_display') }}</span>
                            最終ログイン: {{ session('user.logged_in_at')->format('Y年m月d日 H:i') }}
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

<!-- Notification Section -->
<div class="notification-section mb-4">
    <div class="notification-title">お知らせ（こちらはダミーの文です。）</div>
    
    <!-- System Issue Notification -->
    <div class="notification-item">
        <div class="notification-avatar"></div>
        <div class="notification-content">
            <div class="notification-header">システム障害のお知らせ（例）；2 週間前</div>
            <div class="notification-body">
                現在、一部のお客様においてシステムの接続が不安定な状況が発生しております。ご迷惑をおかけして申し訳ありません。<br>
                ■ 障害発生時刻：2025年6月16日 10:30～<br>
                ■ 状況：復旧対応中<br>
                ■ 今後の対応：復旧次第、本お知らせ欄にて改めてご案内いたします。
            </div>
        </div>
    </div>
    
    <div class="horizontal-divider"></div>
    
    <!-- New Feature Announcement -->
    <div class="notification-item">
        <div class="notification-avatar"></div>
        <div class="notification-content">
            <div class="notification-header">新機能リリース予告；3 週間前</div>
            <div class="notification-body">
                いつも当サイトをご利用いただきありがとうございます。●月●日に、新機能「○○機能」をリリース予定です！ぜひご活用ください。<br>
                ■ リリース日：2025 年7月15日（火）<br>
                ■ 機能概要<br>
                • 機能A：△△の自動集計機能<br>
                • 機能B：□□の出力フォーマット追加<br>
                詳細はリリース後に改めてご案内いたします。
            </div>
        </div>
    </div>
    
    <div class="horizontal-divider"></div>
    
    <!-- Maintenance Notice -->
    <div class="notification-item">
        <div class="notification-avatar"></div>
        <div class="notification-content">
            <div class="notification-header">サービスメンテナンスのお知らせ；3 週間前</div>
            <div class="notification-body">
                いつも当サイトをご利用いただき、誠にありがとうございます。下記日程におきまして、サービス向上のためのメンテナンスを実施いたします。ご利用の皆様 にはご不便をおかけしますが、何卒ご理解とご協力をお願い申し上げます。<br>
                ■ メンテナンス日時<br>
                2025年7月1日（火） 01:00 ～ 05:00<br>
                ■ 内容<br>
                ・システムの安 定化対策<br>
                ・セキュリティ強化<br>
                ■ 影響範囲<br>
                メンテナンス中は全サービスがご利用いただけません。ご迷惑をおかけしますが、よろしくお願いいたします。
            </div>
        </div>
    </div>
</div>

<!-- Comment Section -->
<div class="comment-section mb-4">
    <div class="comment-title">コメント通知</div>
    
    <div class="comment-item">
        <div class="comment-badge"></div>
        <div class="comment-text">事業所：コメント内容</div>
    </div>
    
    <div class="comment-item">
        <div class="comment-badge"></div>
        <div class="comment-text">事業所：コメント内容</div>
    </div>
    
    <div class="comment-item">
        <div class="comment-badge"></div>
        <div class="comment-text">事業所：コメント内容</div>
    </div>
    
    <div class="comment-item">
        <div class="comment-badge"></div>
        <div class="comment-text">事業所：コメント内容</div>
    </div>
</div>

<!-- Approval Section -->
<div class="approval-section">
    <div class="approval-title">承認通知</div>
    
    <div class="approval-item">
        <div class="approval-badge"></div>
        <div class="approval-text">事業所：承認</div>
        <button class="approval-button">
            <i class="button-icon">check</i>
            <span class="button-text">承認内容確認</span>
        </button>
    </div>
    
    <div class="horizontal-divider"></div>
    
    <div class="approval-item">
        <div class="approval-badge"></div>
        <div class="approval-text">事業所：差戻し</div>
        <button class="approval-button">
            <i class="button-icon">undo</i>
            <span class="button-text">差戻し内容確認</span>
        </button>
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
                            総施設数
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">245</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-building text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            承認待ち
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            期限切れ契約
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            未読コメント
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-chat-dots text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">施設情報が更新されました</div>
                            <small class="text-muted">東京第一事業所 - 住所情報の変更</small>
                        </div>
                        <small class="text-muted">2時間前</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">承認が完了しました</div>
                            <small class="text-muted">大阪支店 - 契約情報の承認</small>
                        </div>
                        <small class="text-muted">4時間前</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">新しいコメントが投稿されました</div>
                            <small class="text-muted">名古屋営業所 - 修繕に関する質問</small>
                        </div>
                        <small class="text-muted">6時間前</small>
                    </div>
                </div>
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
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle me-2"></i>新規施設登録
                    </a>
                    <a href="#" class="btn btn-outline-success">
                        <i class="bi bi-search me-2"></i>施設検索
                    </a>
                    <a href="#" class="btn btn-outline-warning">
                        <i class="bi bi-check-circle me-2"></i>承認待ち確認
                    </a>
                    <a href="#" class="btn btn-outline-info">
                        <i class="bi bi-file-earmark-spreadsheet me-2"></i>レポート出力
                    </a>
                </div>
            </div>
        </div>

        <!-- Contract Alerts -->
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">契約期限アラート</h6>
            </div>
            <div class="card-body">
                <div class="small">
                    <div class="alert alert-warning py-2 mb-2">
                        <strong>横浜事業所</strong><br>
                        賃貸借契約: 2024/03/31まで
                    </div>
                    <div class="alert alert-danger py-2 mb-2">
                        <strong>福岡支店</strong><br>
                        火災保険: 2024/02/15まで
                    </div>
                    <div class="alert alert-warning py-2 mb-0">
                        <strong>仙台営業所</strong><br>
                        地震保険: 2024/04/10まで
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection