<?php
/**
 * SmartSip Hosting Helper - Run Artisan Commands via Browser
 * ⚠️ Hapus file ini setelah selesai menggunakannya demi keamanan!
 */

chdir(dirname(__DIR__));

$action = $_GET['action'] ?? null;

echo "<!DOCTYPE html><html lang='id'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>SmartSip Artisan Runner</title>";
echo "<style>
    body { font-family: system-ui, -apple-system, sans-serif; background: #0f172a; color: #f8fafc; padding: 30px; line-height: 1.6; max-width: 900px; margin: 0 auto; }
    h2 { color: #38bdf8; border-bottom: 2px solid #334155; padding-bottom: 10px; }
    .btn { display: inline-block; padding: 12px 20px; margin: 6px 6px 6px 0; border-radius: 10px; text-decoration: none; font-weight: bold; color: white; cursor: pointer; border: none; font-size: 13px; transition: all 0.2s; }
    .btn-danger { background: #ef4444; } .btn-danger:hover { background: #dc2626; }
    .btn-primary { background: #3b82f6; } .btn-primary:hover { background: #2563eb; }
    .btn-success { background: #10b981; } .btn-success:hover { background: #059669; }
    .btn-warning { background: #f59e0b; color: #1e293b; } .btn-warning:hover { background: #d97706; color: white; }
    pre { background: #1e293b; padding: 15px; border-radius: 10px; color: #38bdf8; border: 1px solid #334155; overflow-x: auto; white-space: pre-wrap; font-size: 12px; }
    .alert { background: #7f1d1d; color: #fca5a5; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #991b1b; }
    .btn-group { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 25px; }
</style></head><body>";

echo "<h2>🚀 SmartSip Artisan Command Runner</h2>";
echo "<div class='alert'>⚠️ <strong>PENTING:</strong> Hapus file ini (<code>artisan-runner.php</code>) setelah selesai menggunakannya demi keamanan server!</div>";

echo "<div class='btn-group'>";
echo "<a href='?action=refresh_routes' class='btn btn-warning'>🔀 1. Refresh Route Cache (Perbaiki Error 500 Route)</a> ";
echo "<a href='?action=clear_cache' class='btn btn-primary'>⚡ 2. Clear All Cache & Optimize</a> ";
echo "<a href='?action=migrate_fresh' class='btn btn-danger' onclick='return confirm(\"APAKAH ANDA YAKIN? Ini akan MENGOSONGKAN DATABASE (kecuali Master Data & Admin)?\");'>🔥 3. Reset & Seed Database (Go Live)</a> ";
echo "<a href='?action=db_seed' class='btn btn-success'>🌱 4. Run Seeder Only (db:seed)</a>";
echo "</div>";

if ($action === 'refresh_routes') {
    echo "<h3>🔀 Executing: php artisan route:clear && php artisan route:cache</h3><pre>";
    echo "--- Route Clear ---\n";
    echo shell_exec('php artisan route:clear 2>&1') ?: 'route:clear finished.';
    echo "\n\n--- Route Cache ---\n";
    echo shell_exec('php artisan route:cache 2>&1') ?: 'route:cache finished.';
    echo "</pre>";
} elseif ($action === 'migrate_fresh') {
    echo "<h3>🔥 Executing: php artisan migrate:fresh --seed --force</h3><pre>";
    echo shell_exec('php artisan migrate:fresh --seed --force 2>&1') ?: 'Finished.';
    echo "</pre>";
} elseif ($action === 'db_seed') {
    echo "<h3>🌱 Executing: php artisan db:seed --force</h3><pre>";
    echo shell_exec('php artisan db:seed --force 2>&1') ?: 'Finished.';
    echo "</pre>";
} elseif ($action === 'clear_cache') {
    echo "<h3>1. Storage Link</h3><pre>";
    echo shell_exec('php artisan storage:link 2>&1') ?: 'storage:link finished.';
    echo "</pre>";

    echo "<h3>2. Optimize & Clear Cache</h3><pre>";
    echo shell_exec('php artisan optimize:clear 2>&1') ?: 'optimize:clear finished.';
    echo "</pre>";

    echo "<h3>3. Route Cache</h3><pre>";
    echo shell_exec('php artisan route:cache 2>&1') ?: 'route:cache finished.';
    echo "</pre>";

    echo "<h3>4. View Cache</h3><pre>";
    echo shell_exec('php artisan view:cache 2>&1') ?: 'view:cache finished.';
    echo "</pre>";
} else {
    echo "<p style='color:#94a3b8;'>Silakan klik tombol di atas untuk menjalankan perintah Artisan di server hosting.</p>";
}

echo "</body></html>";
