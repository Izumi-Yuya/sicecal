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

        // Don't overwrite the existing index.html if it exists and is not empty
        $indexPath = "{$outputDir}/index.html";
        if (!File::exists($indexPath) || File::size($indexPath) < 100) {
            $this->info('Generating index page...');
            $indexContent = '<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shise-Cal - 施設管理システム</title>
    <meta http-equiv="refresh" content="0; url=./login.html">
    <link rel="canonical" href="./login.html">
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .loading { font-size: 18px; color: #666; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="loading">
        <h1>Shise-Cal 施設管理システム</h1>
        <p>ログインページにリダイレクトしています...</p>
        <p><a href="./login.html">こちらをクリックしてログインページへ</a></p>
    </div>
</body>
</html>';
            File::put($indexPath, $indexContent);
        }
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