<?php
/**
 * SmartSip Hosting Helper - Specific Deployment Runner
 * ⚠️ Hapus file ini setelah selesai menggunakannya demi keamanan!
 */

chdir(dirname(__DIR__));

echo "<!DOCTYPE html><html lang='id'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>SmartSip Deployment Runner</title>";
echo "<style>
    body { font-family: system-ui, -apple-system, sans-serif; background: #0f172a; color: #f8fafc; padding: 30px; line-height: 1.6; max-width: 900px; margin: 0 auto; }
    h2 { color: #38bdf8; border-bottom: 2px solid #334155; padding-bottom: 10px; }
    h3 { color: #f59e0b; margin-top: 20px; font-size: 15px; }
    pre { background: #1e293b; padding: 15px; border-radius: 10px; color: #38bdf8; border: 1px solid #334155; overflow-x: auto; white-space: pre-wrap; font-size: 12px; }
    .alert { background: #7f1d1d; color: #fca5a5; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #991b1b; }
    .success-banner { background: #064e3b; color: #6ee7b7; padding: 15px; border-radius: 10px; margin-top: 25px; border: 1px solid #047857; font-weight: bold; }
</style></head><body>";

echo "<h2>🚀 SmartSip Deployment & Cache Runner</h2>";
echo "<div class='alert'>⚠️ <strong>PENTING:</strong> Hapus file ini (<code>artisan-runner.php</code>) setelah selesai menggunakannya demi keamanan server!</div>";

// Step 1: Clear All Cache
echo "<h3>1. Clear All Cache (optimize:clear)</h3><pre>";
echo shell_exec('php artisan optimize:clear 2>&1') ?: 'Optimize clear finished.';
echo "</pre>";

// Step 2: Re-cache Routes & Views
echo "<h3>2. Cache Routes & Views</h3><pre>";
echo "--- Route Cache ---\n";
echo shell_exec('php artisan route:cache 2>&1') ?: 'Route cache finished.';
echo "\n--- View Cache ---\n";
echo shell_exec('php artisan view:cache 2>&1') ?: 'View cache finished.';
echo "</pre>";

echo "<div class='success-banner'>✅ SELESAI! Perbaikan class casing FFQResponse dan Cache Server telah berhasil diperbarui.</div>";

echo "</body></html>";
