<?php

namespace Avcodewizard\LaravelBackup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BackupCommand extends Command
{
    protected $signature = 'backup:run';
    protected $description = 'Run database and storage backup, deleting old backups';

    public function handle()
    {
        $backupPath = config('laravelBackup.backup_path');
        $keepDays = config('laravelBackup.keep_days');

        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Database Backup
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST');
        $fileName = $backupPath . '/' . date('Y-m-d-H-i-s');
        $backupFile = $fileName . '_database.sql.gz';
        $command = "mysqldump -h $dbHost -u $dbUser --password=$dbPass $dbName | gzip > $backupFile";
        exec($command);

        $this->info("Database backup completed: {$backupFile}");

        // Storage Backup
        if(config('laravelBackup.backup_storage_folder')) {
            $storageZip = $fileName . '_storage.zip';
            if (File::exists(public_path('storage'))) {
                exec("zip -r {$storageZip} " . 'public/storage');
            } else {
                exec("zip -r {$storageZip} " . 'storage/app/public');
            }
            $this->info("Storage backup completed: {$storageZip}");
        }
       

        
        $this->deleteOldBackups($backupPath, $keepDays);
    }

    private function deleteOldBackups($backupPath, $days)
    {
        $files = glob($backupPath . '/*');
        $now = time();

        foreach ($files as $file) {
            // if (is_file($file) && $now - filemtime($file) >= 10) {
            if (is_file($file) && $now - filemtime($file) >= $days * 86400) {
                unlink($file);
                $this->info("Deleted old backup: {$file}");
            }
        }
    }
}
