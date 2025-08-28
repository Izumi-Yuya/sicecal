<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class GenerateStaticSite extends Command
{
    protected $signature = 'site:generate {--output=docs}';
    protected $description = 'Generate static HTML files for GitHub Pages';

    public function handle()
    {
        $outputDir = $this->option('output');
        
        // Handle special 'root' option for repository root
        if ($outputDir === 'root') {
            $outputDir = base_path('../');
        } elseif (!str_starts_with($outputDir, '/')) {
            $outputDir = base_path('../' . $outputDir);
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
    }

    private function generatePages($outputDir)
    {
        // Generate login page
        $this->info('Generating login page...');
        $loginContent = View::make('auth.login')->render();
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
        File::put("{$outputDir}/dashboard.html", $dashboardContent);

        // Generate index.html redirect
        $this->info('Generating index page...');
        $indexContent = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shise-Cal - 施設管理システム</title>
    <meta http-equiv="refresh" content="0; url=./login.html">
    <link rel="canonical" href="./login.html">
</head>
<body>
    <p>Redirecting to <a href="./login.html">login page</a>...</p>
</body>
</html>';
        File::put("{$outputDir}/index.html", $indexContent);
    }
}