{{--
    施設管理システム - パスワードリセット要求画面
    
    【機能概要】
    - パスワードリセットリンクの送信要求
    - メールアドレスによる本人確認
    - セキュアなリセットリンク生成
    
    【使用方法】
    1. 登録済みメールアドレスを入力
    2. 送信ボタンをクリック
    3. メールでリセットリンクを受信
    4. リンクからパスワードリセット画面へ
    
    【技術仕様】
    - Laravel Blade テンプレート
    - Bootstrap + カスタムCSS
    - Laravel標準のパスワードリセット機能
--}}

@extends('layouts.login')

@section('title', 'パスワードリセット要求')

@section('content')
<div class="login-main-wrapper">
    <div class="login-form-container">
        <!-- Logo -->
        <div class="login-logo">
            <img src="{{ asset('images/shise-cal-logo.png') }}" alt="Shise-Cal" style="width: 100%; height: 100%; object-fit: contain;" onerror="this.style.display='none';">
        </div>
        
        <!-- Password Reset Request Form -->
        <div class="login-form">
            <div class="form-header mb-4">
                <h4 class="text-center mb-2">パスワードリセット</h4>
                <p class="text-center text-muted small">登録されているメールアドレスにリセットリンクを送信します</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" 
                           placeholder="登録済みメールアドレスを入力" 
                           value="{{ old('email') }}" 
                           autocomplete="email" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Send Reset Link Button -->
                <button type="submit" class="login-button">
                    リセットリンクを送信
                </button>
                
                <!-- Back to Login Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>ログイン画面に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Password Reset Instructions Panel -->
    <div class="login-instructions">
        <div class="instructions-card">
            <div class="instructions-header">
                <i class="bi bi-envelope me-2"></i>
                <span>リセット手順</span>
            </div>
            <div class="instructions-content">
                <div class="instruction-item">
                    <div class="step-number">1</div>
                    <div class="step-text">
                        <strong>メールアドレス入力</strong><br>
                        <small>システムに登録されているメールアドレスを入力</small>
                    </div>
                </div>
                <div class="instruction-item">
                    <div class="step-number">2</div>
                    <div class="step-text">
                        <strong>リンク送信</strong><br>
                        <small>パスワードリセット用のリンクをメールで送信</small>
                    </div>
                </div>
                <div class="instruction-item">
                    <div class="step-number">3</div>
                    <div class="step-text">
                        <strong>メール確認</strong><br>
                        <small>受信したメールのリンクをクリック</small>
                    </div>
                </div>
                <div class="instruction-item">
                    <div class="step-number">4</div>
                    <div class="step-text">
                        <strong>パスワード設定</strong><br>
                        <small>新しいパスワードを設定して完了</small>
                    </div>
                </div>
            </div>
            <div class="security-notes">
                <div class="security-item">
                    <i class="bi bi-info-circle text-info me-2"></i>
                    <span>リセットリンクは24時間で無効になります</span>
                </div>
                <div class="security-item">
                    <i class="bi bi-info-circle text-info me-2"></i>
                    <span>メールが届かない場合は管理者にお問い合わせください</span>
                </div>
                <div class="security-item">
                    <i class="bi bi-shield-check text-success me-2"></i>
                    <span>セキュリティのため登録済みアドレスのみ有効</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Messages -->
@if (session('status'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 1050;">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 1050;">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            入力されたメールアドレスを確認してください。
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
@endsection