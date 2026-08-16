<?php
/**
 * SmartSip Hosting Helper - Run Artisan Commands via Browser
 * ⚠️ Hapus file ini setelah selesai menggunakannya demi keamanan!
 */

chdir(dirname(__DIR__));

echo "<!DOCTYPE html><html lang='id'><head><meta charset='UTF-8'><title>SmartSip Helper</title>";
echo "<style>body{font-family:sans-serif;background:#0f172a;color:#f8fafc;padding:30px;line-height:1.6;} pre{background:#1e293b;padding:15px;border-radius:10px;color:#38bdf8;border:1px solid #334155;}</style></head><body>";

echo "<h2>🚀 SmartSip Artisan Command Runner</h2>";

echo "<h3>1. Storage Link</h3><pre>";
echo shell_exec('php artisan storage:link 2>&1') ?: 'storage:link finished.';
echo "</pre>";

echo "<h3>2. Optimize & Clear All Cache</h3><pre>";
echo shell_exec('php artisan optimize:clear 2>&1') ?: 'optimize:clear finished.';
echo "</pre>";

echo "<h3>3. Route Cache & Clear</h3><pre>";
echo shell_exec('php artisan route:clear 2>&1') ?: 'route:clear finished.';
echo "\n";
echo shell_exec('php artisan route:cache 2>&1') ?: 'route:cache finished.';
echo "</pre>";



echo "<h3>4. View Cache</h3><pre>";
echo shell_exec('php artisan view:cache 2>&1') ?: 'view:cache finished.';
echo "</pre>";

echo "<p style='color:#ef4444;font-weight:bold;'>⚠️ PENTING: Segera hapus file ini (artisan-runner.php) dari server hosting setelah selesai!</p>";
echo "</body></html>";
