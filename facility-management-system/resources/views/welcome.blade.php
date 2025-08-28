@extends('layouts.app')

@section('title', '- ホーム')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
            <div class="container">
                <h1 class="display-4">施設カルテシステム</h1>
                <p class="lead">施設情報を一元管理し、効率的な運営をサポートします。</p>
                <a class="btn btn-light btn-lg" href="#" role="button">ログイン</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-building"></i> 施設管理
                </h5>
                <p class="card-text">施設情報の登録、更新、検索機能を提供します。承認ワークフローにより、データの整合性を保ちます。</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-pdf"></i> ドキュメント管理
                </h5>
                <p class="card-text">契約書や図面などの重要書類をPDF形式で安全に保管・管理できます。</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-graph-up"></i> レポート機能
                </h5>
                <p class="card-text">CSV・PDF形式でのデータ出力機能により、効率的なレポート作成が可能です。</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">主な機能</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success"></i> ロールベースアクセス制御</li>
                    <li><i class="bi bi-check-circle text-success"></i> 承認ワークフロー</li>
                    <li><i class="bi bi-check-circle text-success"></i> 修繕履歴管理</li>
                    <li><i class="bi bi-check-circle text-success"></i> 年次情報確認</li>
                    <li><i class="bi bi-check-circle text-success"></i> コメント・通知システム</li>
                    <li><i class="bi bi-check-circle text-success"></i> 監査ログ機能</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">システム情報</h6>
            </div>
            <div class="card-body">
                <p><strong>Laravel:</strong> {{ Illuminate\Foundation\Application::VERSION }}</p>
                <p><strong>PHP:</strong> {{ PHP_VERSION }}</p>
                <p><strong>Bootstrap:</strong> 5.3.x</p>
                <p class="mb-0"><strong>環境:</strong> {{ config('app.env') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection