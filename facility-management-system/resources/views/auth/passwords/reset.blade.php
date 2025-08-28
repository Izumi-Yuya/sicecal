{{--
    施設管理システム - パスワードリセット画面
    
    【機能概要】
    - 管理者向けパスワードリセット機能
    - メールアドレスによるパスワードリセット
    - セキュアなトークンベース認証
    
    【使用方法】
    1. メールアドレスを入力
    2. 新しいパスワードを入力
    3. パスワード確認を入力
    4. リセットボタンをクリック
    
    【技術仕様】
    - Laravel Blade テンプレート
    - Bootstrap + カスタムCSS
    - Laravel標準のパスワードリセット機能
--}}

@extends('layouts.login')

@section('title', 'パスワードリセット')

@section('content')
<div class="login-main-wrapper">
    <div class="login-form-container">
        <!-- Logo -->
        <div class="login-logo">
            <img src="{{ asset('images/shise-cal-logo.png') }}" alt="Shise-Cal" style="width: 100%; height: 100%; object-fit: contain;" onerror="this.style.display='none';">
        </div>
        
        <!-- Password Reset Form -->
        <div class="login-form">
            <div class="form-header mb-4">
                <h4 class="text-center mb-2">パスワードリセット</h4>
                <p class="text-center text-muted small">新しいパスワードを設定してください</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" 
                           placeholder="メールアドレスを入力" 
                           value="{{ $email ?? old('email') }}" 
                           autocomplete="email" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">新しいパスワード</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" 
                           placeholder="新しいパスワードを入力" 
                           autocomplete="new-password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password Confirmation Field -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">パスワード確認</label>
                    <input type="password" class="form-control" 
                           id="password_confirmation" name="password_confirmation" 
                           placeholder="パスワードを再入力" 
                           autocomplete="new-password" required>
                </div>
                
                <!-- Reset Button -->
                <button type="submit" class="login-button">
                    パスワードをリセット
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
                <i class="bi bi-shield-lock me-2"></i>
                <span>パスワードリセット</span>
            </div>
            <div class="instructions-content">
                <div class="instruction-item">
                    <div class="step-number">1</div>
                    <div class="step-text">
                        <strong>メールアドレス確認</strong><br>
                        <small>登録されているメールアドレスを入力</small>
                    </div>
                </div>
                <div class="instruction-item">
                    <div class="step-number">2</div>
                    <div class="step-text">
                        <strong>新しいパスワード</strong><br>
                        <small>8文字以上の安全なパスワードを設定</small>
                    </div>
                </div>
                <div class="instruction-item">
                    <div class="step-number">3</div>
                    <div class="step-text">
                        <strong>パスワード確認</strong><br>
                        <small>同じパスワードを再入力して確認</small>
                    </div>
                </div>
            </div>
            <div class="security-notes">
                <div class="security-item">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    <span>パスワードは暗号化されて保存されます</span>
                </div>
                <div class="security-item">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    <span>リセットリンクは24時間で無効になります</span>
                </div>
                <div class="security-item">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    <span>変更後は再ログインが必要です</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Messages -->
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
            パスワードリセットに失敗しました。入力内容を確認してください。
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
@endsection