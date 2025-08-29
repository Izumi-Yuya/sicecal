<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request (demo version).
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:3',
            'role' => 'required|string|in:system_admin,editor,approver,viewer_executive,viewer_department,viewer_regional,viewer_facility',
        ], [
            'username.required' => 'ユーザー名を入力してください。',
            'username.min' => 'ユーザー名は3文字以上で入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは3文字以上で入力してください。',
            'role.required' => '役割を選択してください。',
        ]);

        // Create demo user based on selected role and input
        $roleDisplayNames = [
            'system_admin' => 'システム管理者',
            'editor' => '編集者',
            'approver' => '承認者',
            'viewer_executive' => '閲覧者（役員）',
            'viewer_department' => '閲覧者（部門）',
            'viewer_regional' => '閲覧者（地区）',
            'viewer_facility' => '閲覧者（事業所）',
        ];

        $user = (object) [
            'id' => 1,
            'name' => $request->username, // Use the entered username
            'role' => $request->role,
            'role_display' => $roleDisplayNames[$request->role],
            'logged_in_at' => now(),
        ];

        // Store user in session
        Session::put('user', (array) $user);

        return redirect()->intended('/dashboard');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Session::forget('user');
        Session::flush();

        return redirect('/login');
    }
}