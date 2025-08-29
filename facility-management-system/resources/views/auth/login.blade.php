@extends('layouts.login')

@section('title', 'ログイン')

@section('content')
<div class="container-fluid h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <!-- Logo Section -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/shise-cal-logo.png') }}" alt="Shise-Cal ロゴ" class="logo-image mb-3" style="max-width: 200px;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div class="logo-fallback" style="display: none;">
                            <h2 class="text-primary mb-0">Shise-Cal</h2>
                            <p class="text-muted">施設管理システム</p>
                        </div>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" data-enhanced-validation>
                        @csrf
                        
                        <!-- Username Field -->
                        <div class="mb-3">
                            <label for="username" class="form-label">ユーザー名</label>
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   placeholder="ユーザー名を入力してください"
                                   required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label">パスワード</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="パスワードを入力してください"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Role Selection -->
                        <div class="mb-4">
                            <label for="role" class="form-label">ログイン役割</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="">役割を選択してください</option>
                                <option value="system_admin" {{ old('role') == 'system_admin' ? 'selected' : '' }}>システム管理者</option>
                                <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>編集者</option>
                                <option value="approver" {{ old('role') == 'approver' ? 'selected' : '' }}>承認者</option>
                                <option value="viewer_executive" {{ old('role') == 'viewer_executive' ? 'selected' : '' }}>閲覧者（役員）</option>
                                <option value="viewer_department" {{ old('role') == 'viewer_department' ? 'selected' : '' }}>閲覧者（部門）</option>
                                <option value="viewer_regional" {{ old('role') == 'viewer_regional' ? 'selected' : '' }}>閲覧者（地区）</option>
                                <option value="viewer_facility" {{ old('role') == 'viewer_facility' ? 'selected' : '' }}>閲覧者（事業所）</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Login Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>ログイン
                            </button>
                        </div>
                    </form>

                    <!-- Demo Notice -->
                    <div class="alert alert-info mt-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>デモ版について</strong><br>
                        このシステムはデモ版です。任意のユーザー名・パスワードと役割を選択してログインしてください。<br>
                        <small class="text-muted">例: ユーザー名「admin」、パスワード「password」</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection