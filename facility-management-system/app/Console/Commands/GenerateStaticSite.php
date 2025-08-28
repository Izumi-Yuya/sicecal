<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

class GenerateStaticSite extends Command
{
    protected $signature = 'site:generate {--output=../docs}';
    protected $description = 'Generate static HTML files for GitHub Pages';

    public function handle()
    {
        $outputDir = $this->option('output');
        
        // Resolve output directory path
        if (!str_starts_with($outputDir, '/')) {
            $outputDir = base_path($outputDir);
        }
        
        // Create output directory if it doesn't exist
        if (!File::exists($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }

        // Copy public assets
        $this->info('Copying public assets...');
        File::copyDirectory(public_path(), $outputDir);

        // Generate pages
        $this->generatePages($outputDir);

        $this->info("Static site generated in {$outputDir}");
        $this->info("Files created:");
        $files = File::allFiles($outputDir);
        foreach ($files as $file) {
            if (str_ends_with($file->getFilename(), '.html')) {
                $this->line("  - " . $file->getRelativePathname());
            }
        }
    }

    private function generatePages($outputDir)
    {
        // Generate login page
        $this->info('Generating login page...');
        
        // Create a mock errors bag for the login view
        $errors = new \Illuminate\Support\ViewErrorBag();
        
        $loginContent = View::make('auth.login', compact('errors'))->render();
        $loginContent = $this->fixStaticPaths($loginContent);
        File::put("{$outputDir}/login.html", $loginContent);

        // Generate dashboard with mock data
        $this->info('Generating dashboard page...');
        session([
            'user' => [
                'name' => 'デモユーザー',
                'role' => 'system_admin',
                'role_display' => 'システム管理者',
                'logged_in_at' => now()
            ]
        ]);
        $dashboardContent = View::make('dashboard')->render();
        $dashboardContent = $this->fixStaticPaths($dashboardContent);
        File::put("{$outputDir}/dashboard.html", $dashboardContent);

        // Generate index page that redirects to login
        $this->info('Generating index page...');
        $indexContent = '<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shise-Cal - 施設管理システム</title>
    <style>
        body {
            font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #666;
            margin-bottom: 1.5rem;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
        .loading {
            margin-top: 1rem;
            font-size: 14px;
            color: #999;
        }
    </style>
    <script>
        // 3秒後に自動リダイレクト
        setTimeout(function() {
            window.location.href = \'./login.html\';
        }, 3000);
    </script>
</head>
<body>
    <div class="container">
        <h1>🏢 Shise-Cal</h1>
        <h2>施設管理システム</h2>
        <p>施設情報を一元管理するWebアプリケーションです。<br>
        権限管理と承認機能により、業務効率と情報の整合性向上を実現します。</p>
        
        <div style="margin: 1.5rem 0;">
            <h3 style="color: #333; font-size: 1.1rem; margin-bottom: 0.5rem;">主な機能</h3>
            <ul style="text-align: left; display: inline-block; color: #666;">
                <li>7つの役割に基づいたアクセス制御</li>
                <li>施設情報の登録・更新・削除</li>
                <li>承認ワークフロー</li>
                <li>CSV/PDF出力機能</li>
            </ul>
        </div>
        
        <a href="./login.html" class="btn">デモサイトを開始</a>
        <div class="loading">
            3秒後に自動的にログインページにリダイレクトします...
        </div>
        
        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee;">
            <small style="color: #999;">
                GitHub Pages デモ版 | 
                <a href="https://github.com/izumi-yuya/sicecal" style="color: #007bff;">ソースコード</a>
            </small>
        </div>
    </div>
</body>
</html>';
        File::put("{$outputDir}/index.html", $indexContent);
    }

    private function fixStaticPaths($content)
    {
        // Fix asset paths for GitHub Pages
        $content = preg_replace('/http:\/\/localhost\/build\/assets\//', './build/assets/', $content);
        
        // Fix image paths
        $content = preg_replace('/http:\/\/localhost\/images\//', './images/', $content);
        
        // Fix form actions to use JavaScript
        $content = preg_replace('/action="http:\/\/localhost\/login"/', 'action="#" onsubmit="return handleLogin(event)"', $content);
        
        // Add JavaScript for login handling if form exists
        if (strpos($content, 'handleLogin') !== false) {
            $jsScript = '
    <script src="./js/static-site.js"></script>
</body>';
            $content = str_replace('</body>', $jsScript, $content);
        }
        
        return $content;
    }
}