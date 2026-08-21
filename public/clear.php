<?php
// Standalone Cache, Git Pull & OPcache Cleaner Script for SmartSip Web

$clearedFiles = [];

// 0. Reset OPcache if active
$opcacheReset = false;
if (function_exists('opcache_reset')) {
    $opcacheReset = @opcache_reset();
}

// 1. Delete all files in bootstrap/cache/ except .gitignore
$bootstrapCacheDir = __DIR__ . '/../bootstrap/cache/';
if (is_dir($bootstrapCacheDir)) {
    $files = glob($bootstrapCacheDir . '*.php');
    if (is_array($files)) {
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
                $clearedFiles[] = 'bootstrap/cache/' . basename($file);
            }
        }
    }
}

// 2. Delete all compiled views in storage/framework/views/
$viewsCacheDir = __DIR__ . '/../storage/framework/views/';
if (is_dir($viewsCacheDir)) {
    $files = glob($viewsCacheDir . '*');
    if (is_array($files)) {
        foreach ($files as $file) {
            if (is_file($file) && basename($file) !== '.gitignore') {
                @unlink($file);
                $clearedFiles[] = 'storage/framework/views/' . basename($file);
            }
        }
    }
}

// 3. Try git pull with multiple binary paths & shell exec functions
$gitOutput = 'Shell functions disabled or git command not found';
$projectRoot = escapeshellarg(__DIR__ . '/..');

$gitCommands = [
    "cd {$projectRoot} && git pull origin main 2>&1",
    "cd {$projectRoot} && /usr/bin/git pull origin main 2>&1",
    "cd {$projectRoot} && /usr/local/bin/git pull origin main 2>&1",
    "cd {$projectRoot} && /usr/bin/env git pull origin main 2>&1"
];

foreach ($gitCommands as $cmd) {
    if (function_exists('shell_exec')) {
        $res = @shell_exec($cmd);
        if ($res && (stristr($res, 'Updating') || stristr($res, 'Already up to date') || stristr($res, 'Fast-forward'))) {
            $gitOutput = trim($res);
            break;
        } elseif ($res) {
            $gitOutput = trim($res);
        }
    } elseif (function_exists('exec')) {
        $out = [];
        @exec($cmd, $out);
        $res = implode("\n", $out);
        if ($res) {
            $gitOutput = trim($res);
            if (stristr($res, 'Updating') || stristr($res, 'Already up to date')) break;
        }
    }
}

// 4. Bootstrap Laravel and run Artisan clear commands
$artisanOutput = [];
try {
    if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        require __DIR__ . '/../vendor/autoload.php';
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        \Illuminate\Support\Facades\Artisan::call('view:clear');
        $artisanOutput[] = trim(\Illuminate\Support\Facades\Artisan::output());

        \Illuminate\Support\Facades\Artisan::call('config:clear');
        $artisanOutput[] = trim(\Illuminate\Support\Facades\Artisan::output());

        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        $artisanOutput[] = trim(\Illuminate\Support\Facades\Artisan::output());

        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $artisanOutput[] = trim(\Illuminate\Support\Facades\Artisan::output());
    }
} catch (\Throwable $e) {
    $artisanOutput[] = 'Error running Artisan: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Cache files, OPcache, views, and routes successfully cleared & pulled!',
    'opcache_reset' => $opcacheReset,
    'cleared_files_count' => count($clearedFiles),
    'git_output' => $gitOutput,
    'artisan_output' => implode(" | ", array_filter($artisanOutput)),
    'timestamp' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT);

