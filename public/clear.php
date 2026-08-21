<?php
// Standalone Cache & Route Cleaner Script for SmartSip Web

$clearedFiles = [];

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

// 3. Try git pull if exec/shell_exec is enabled
$gitOutput = 'Shell exec disabled or not executed';
if (function_exists('shell_exec')) {
    $gitOutput = @shell_exec('cd ' . escapeshellarg(__DIR__ . '/..') . ' && git pull origin main 2>&1');
} elseif (function_exists('exec')) {
    $out = [];
    @exec('cd ' . escapeshellarg(__DIR__ . '/..') . ' && git pull origin main 2>&1', $out);
    $gitOutput = implode("\n", $out);
}

// 4. Bootstrap Laravel and run Artisan clear commands
$artisanOutput = '';
try {
    if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        require __DIR__ . '/../vendor/autoload.php';
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $artisanOutput = \Illuminate\Support\Facades\Artisan::output();
    }
} catch (\Throwable $e) {
    $artisanOutput = 'Error running Artisan: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Cache files in bootstrap/cache and storage/framework/views successfully removed!',
    'cleared_files_count' => count($clearedFiles),
    'git_output' => $gitOutput,
    'artisan_output' => trim($artisanOutput),
    'timestamp' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT);
