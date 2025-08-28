/**
 * 静的サイト用JavaScript
 * GitHub Pages でのログイン機能とナビゲーション
 */

document.addEventListener('DOMContentLoaded', function () {
    // ログインフォームの処理
    const loginForm = document.querySelector('form[action*="login"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const userData = {
                name: formData.get('name'),
                role: formData.get('user_type'),
                logged_in_at: new Date().toISOString()
            };

            // ユーザーデータをローカルストレージに保存
            localStorage.setItem('shise_cal_user', JSON.stringify(userData));

            // ダッシュボードにリダイレクト
            window.location.href = './dashboard.html';
        });
    }

    // ログアウト処理
    const logoutButtons = document.querySelectorAll('button[type="submit"]');
    logoutButtons.forEach(button => {
        if (button.textContent.includes('ログアウト')) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                localStorage.removeItem('shise_cal_user');
                window.location.href = './login.html';
            });
        }
    });

    // ダッシュボードでのユーザー情報表示
    if (window.location.pathname.includes('dashboard.html')) {
        const userData = JSON.parse(localStorage.getItem('shise_cal_user') || '{}');

        if (!userData.name) {
            // ログインしていない場合はログインページにリダイレクト
            window.location.href = './login.html';
            return;
        }

        // ユーザー情報を更新
        updateUserInfo(userData);
    }

    // ナビゲーションリンクの修正
    fixNavigationLinks();
});

function updateUserInfo(userData) {
    // 役割の表示名を取得
    const roleDisplayNames = {
        'system_admin': 'システム管理者',
        'editor': '編集者',
        'approver': '承認者',
        'viewer_executive': '閲覧者（役員・本社）',
        'viewer_department': '閲覧者（部門責任者）',
        'viewer_district': '閲覧者（地区担当）',
        'viewer_facility': '閲覧者（事業所）'
    };

    const roleDisplay = roleDisplayNames[userData.role] || userData.role;

    // ユーザー名を更新
    const userNameElements = document.querySelectorAll('[data-user-name]');
    userNameElements.forEach(el => {
        el.textContent = userData.name + 'さん、おかえりなさい';
    });

    // 役割を更新
    const roleElements = document.querySelectorAll('[data-user-role]');
    roleElements.forEach(el => {
        el.textContent = roleDisplay;
    });

    // ログイン時刻を更新
    const loginTimeElements = document.querySelectorAll('[data-login-time]');
    loginTimeElements.forEach(el => {
        const loginTime = new Date(userData.logged_in_at);
        el.textContent = `最終ログイン: ${loginTime.getFullYear()}年${loginTime.getMonth() + 1}月${loginTime.getDate()}日 ${loginTime.getHours()}:${loginTime.getMinutes().toString().padStart(2, '0')}`;
    });

    // ヘッダーのユーザー名を更新
    const headerUserName = document.querySelector('.approver-btn');
    if (headerUserName) {
        headerUserName.textContent = userData.name;
    }
}

function fixNavigationLinks() {
    // 内部リンクを静的ファイル用に修正
    const links = document.querySelectorAll('a[href]');
    links.forEach(link => {
        const href = link.getAttribute('href');

        // Laravel ルートを静的ファイルパスに変換
        if (href === '/dashboard' || href.includes('dashboard')) {
            link.setAttribute('href', './dashboard.html');
        } else if (href === '/login' || href.includes('login')) {
            link.setAttribute('href', './login.html');
        } else if (href === '/' || href === '') {
            link.setAttribute('href', './index.html');
        }
    });
}

// ページ読み込み時にユーザー認証状態をチェック
function checkAuthStatus() {
    const userData = localStorage.getItem('shise_cal_user');
    const currentPage = window.location.pathname;

    if (!userData && currentPage.includes('dashboard.html')) {
        window.location.href = './login.html';
    }
}

// 認証状態チェックを実行
checkAuthStatus();