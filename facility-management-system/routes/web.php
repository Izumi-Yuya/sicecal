<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 施設管理システム - Web Routes
|--------------------------------------------------------------------------
|
| 【システム概要】
| - 施設情報管理システムのルート定義
| - セッションベースの簡易認証システム
| - 4つの役割（管理者、マネージャー、一般ユーザー、閲覧者）
| 
| 【認証仕様】
| - デモ用：任意のユーザー名・パスワードでログイン可能
| - 役割選択機能付き
| - セッション情報にユーザー情報を保存
|
| 【ルート構成】
| - / : ルートページ（ログイン済みならダッシュボードへリダイレクト）
| - /login : ログインページ
| - /dashboard : ダッシュボード（要ログイン）
| - /logout : ログアウト処理
|
*/

// Root route - redirect to dashboard if logged in, otherwise show login
Route::get('/', function () {
    if (session('user')) {
        return redirect('/dashboard');
    }
    return view('auth.login');
});

// Dashboard route - require login
Route::get('/dashboard', function () {
    if (!session('user')) {
        return redirect('/')->with('error', 'ログインが必要です');
    }
    return view('dashboard');
})->name('dashboard');

Route::get('/test-bootstrap', function () {
    return view('test-bootstrap');
});

// Authentication routes
Route::get('/login', function () {
    if (session('user')) {
        return redirect('/dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    /*
     * デモ用ログイン処理
     * 
     * 【機能】
     * - 任意のユーザー名・パスワードを受け入れ
     * - 役割選択必須（admin, manager, user, viewer）
     * - バリデーション機能付き
     * - セッションにユーザー情報を保存
     * 
     * 【セッション情報】
     * - name: ユーザー名
     * - role: 役割コード
     * - role_display: 役割表示名
     * - logged_in_at: ログイン時刻
     */
    $request->validate([
        'user_type' => 'required|in:system_admin,editor,approver,viewer_executive,viewer_department,viewer_district,viewer_facility',
        'name' => 'required|string|max:255',
        'password' => 'required|min:1'
    ], [
        'user_type.required' => '役割を選択してください',
        'user_type.in' => '有効な役割を選択してください',
        'name.required' => 'ユーザー名を入力してください',
        'password.required' => 'パスワードを入力してください'
    ]);
    
    // Role display names - 要件定義に基づく7つのロール
    $roleNames = [
        'system_admin' => 'システム管理者',
        'editor' => '編集者',
        'approver' => '承認者',
        'viewer_executive' => '閲覧者（役員・本社）',
        'viewer_department' => '閲覧者（部門責任者）',
        'viewer_district' => '閲覧者（地区担当）',
        'viewer_facility' => '閲覧者（事業所）'
    ];
    
    session(['user' => [
        'name' => $request->name,
        'role' => $request->user_type,
        'role_display' => $roleNames[$request->user_type],
        'logged_in_at' => now()
    ]]);
    
    return redirect('/dashboard')->with('success', $roleNames[$request->user_type] . 'として' . $request->name . 'さんがログインしました');
})->name('login.post');

Route::post('/logout', function () {
    session()->forget('user');
    return redirect('/')->with('success', 'ログアウトしました');
})->name('logout');
