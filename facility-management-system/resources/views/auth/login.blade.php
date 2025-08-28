{{--
    施設管理システム - ログイン画面
    
    【機能概要】
    - 任意のユーザー名・パスワードでログイン可能（デモ用）
    - 7つの役割から選択可能：システム管理者、編集者、承認者、閲覧者（役員・本社）、閲覧者（部門責任者）、閲覧者（地区担当）、閲覧者（事業所）
    - マーブル背景デザイン
    - バリデーション機能付き
    
    【使用方法】
    1. 任意のユーザー名を入力
    2. 任意のパスワードを入力
    3. 役割を選択
    4. LOGINボタンをクリック
    
    【技術仕様】
    - Laravel Blade テンプレート
    - Bootstrap + カスタムCSS
    - セッションベース認証
--}}

@extends('layouts.login')

@section('title', 'ログイン')

@section('content')
<div class="login-main-wrapper">
    <div class="login-form-container">
        <!-- Logo -->
        <div class="login-logo">
            <img src="{{ asset('images/shise-cal-logo.png') }}" alt="Shise-Cal" style="width: 100%; height: 100%; object-fit: contain;" onerror="this.style.display='none';">
        </div>
        
        <!-- Login Form -->
        <div class="login-form">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <!-- Username Field -->
                <div class="form-group">
                    <label for="name" class="form-label">UserName</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                           placeholder="任意のユーザー名を入力" 
                           value="{{ old('name') }}" 
                           autocomplete="username" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" 
                           placeholder="任意のパスワードを入力" 
                           autocomplete="current-password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Role Selection Field -->
                {{-- 
                    役割選択フィールド - 要件定義に基づく7つのロール
                    - system_admin: システム管理者（全施設と管理機能へのフルアクセス）
                    - editor: 編集者（全施設情報の編集権限）
                    - approver: 承認者（全施設の変更承認権限）
                    - viewer_executive: 閲覧者（役員・本社）（CSV/PDF出力付きで全施設の閲覧）
                    - viewer_department: 閲覧者（部門責任者）（CSV/PDF出力付きで部門施設のみの閲覧）
                    - viewer_district: 閲覧者（地区担当）（CSV/PDF出力付きで割り当てられた地区施設のみの閲覧）
                    - viewer_facility: 閲覧者（事業所）（自施設情報のみの閲覧）
                --}}
                <div class="form-group">
                    <label for="user_type" class="form-label">Role</label>
                    <select class="form-control @error('user_type') is-invalid @enderror" id="user_type" name="user_type" 
                            autocomplete="organization-title" required>
                        <option value="">役割を選択してください</option>
                        <option value="system_admin" {{ old('user_type') == 'system_admin' ? 'selected' : '' }}>システム管理者</option>
                        <option value="editor" {{ old('user_type') == 'editor' ? 'selected' : '' }}>編集者</option>
                        <option value="approver" {{ old('user_type') == 'approver' ? 'selected' : '' }}>承認者</option>
                        <option value="viewer_executive" {{ old('user_type') == 'viewer_executive' ? 'selected' : '' }}>閲覧者（役員・本社）</option>
                        <option value="viewer_department" {{ old('user_type') == 'viewer_department' ? 'selected' : '' }}>閲覧者（部門責任者）</option>
                        <option value="viewer_district" {{ old('user_type') == 'viewer_district' ? 'selected' : '' }}>閲覧者（地区担当）</option>
                        <option value="viewer_facility" {{ old('user_type') == 'viewer_facility' ? 'selected' : '' }}>閲覧者（事業所）</option>
                    </select>
                    @error('user_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Login Button -->
                <button type="submit" class="login-button">
                    LOGIN
                </button>
                
                <!-- Password Reset Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none text-muted">
                        <i class="bi bi-key me-1"></i>パスワードを忘れた方はこちら
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Login Instructions Panel -->
    <div class="login-instructions">
        <div class="instructions-card">
            <div class="instructions-header">
                <i class="bi bi-info-circle me-2"></i>
                <span>デモ用ログイン</span>
            </div>
            <div class="instructions-content">
                <div class="instruction-item">
                    <div class="step-number">1</div>
                    <div class="step-text">
                        <strong>ユーザー名</strong><br>
                        <small>任意の文字列を入力してください</small>
                    </div>
                </div>
                <div class="instruction-item">
                    <div class="step-number">2</div>
                    <div class="step-text">
                        <strong>パスワード</strong><br>
                        <small>任意の文字列を入力してください</small>
                    </div>
                </div>
                <div class="instruction-item">
                    <div class="step-number">3</div>
                    <div class="step-text">
                        <strong>役割選択</strong><br>
                        <small>システム管理者・編集者・承認者・各種閲覧者から選択</small>
                    </div>
                </div>
            </div>
            <div class="role-descriptions">
                <div class="role-item">
                    <span class="role-badge system-admin">システム管理者</span>
                    <span class="role-desc">全施設・管理機能</span>
                </div>
                <div class="role-item">
                    <span class="role-badge editor">編集者</span>
                    <span class="role-desc">全施設編集</span>
                </div>
                <div class="role-item">
                    <span class="role-badge approver">承認者</span>
                    <span class="role-desc">変更承認</span>
                </div>
                <div class="role-item">
                    <span class="role-badge viewer-executive">役員・本社</span>
                    <span class="role-desc">全施設閲覧・出力</span>
                </div>
                <div class="role-item">
                    <span class="role-badge viewer-department">部門責任者</span>
                    <span class="role-desc">部門施設のみ</span>
                </div>
                <div class="role-item">
                    <span class="role-badge viewer-district">地区担当</span>
                    <span class="role-desc">地区施設のみ</span>
                </div>
                <div class="role-item">
                    <span class="role-badge viewer-facility">事業所</span>
                    <span class="role-desc">自施設のみ</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Messages (positioned outside the form container) -->
@if (session('error'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 1050;">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 1050;">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
@endsection