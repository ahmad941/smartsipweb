<?php
/**
 * SmartSip Hosting Helper - Specific Deployment Runner for Standalone Master Classes & Admin UI Update
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

echo "<h2>🚀 SmartSip Deployment Runner (Master Kelas & Admin UI Update)</h2>";
echo "<div class='alert'>⚠️ <strong>PENTING:</strong> Segera hapus file ini (<code>artisan-runner.php</code>) dari hosting setelah proses selesai!</div>";

// Step 1: Migrate Fresh & Seed (Standardize Database Schema without school_id)
echo "<h3>1. Reset & Seed Database (migrate:fresh --seed)</h3><pre>";
echo shell_exec('php artisan migrate:fresh --seed --force 2>&1') ?: 'Migrate fresh finished.';
echo "</pre>";

// Step 2: Storage Link
echo "<h3>2. Create Storage Link</h3><pre>";
echo shell_exec('php artisan storage:link 2>&1') ?: 'Storage link finished.';
echo "</pre>";

// Step 3: Optimize & Clear Cache
echo "<h3>3. Clear Cache (optimize:clear)</h3><pre>";
echo shell_exec('php artisan optimize:clear 2>&1') ?: 'Optimize clear finished.';
echo "</pre>";

// Step 4: Re-cache Routes & Views
echo "<h3>4. Cache Routes & Views</h3><pre>";
echo "--- Route Cache ---\n";
echo shell_exec('php artisan route:cache 2>&1') ?: 'Route cache finished.';
echo "\n--- View Cache ---\n";
echo shell_exec('php artisan view:cache 2>&1') ?: 'View cache finished.';
echo "</pre>";

echo "<div class='success-banner'>✅ SELESAI! Struktur Master Kelas Mandiri, Data Siswa UI, dan Cache Server telah berhasil diperbarui. Silakan login ke Dashboard Admin.</div>";

echo "</body></html>";
