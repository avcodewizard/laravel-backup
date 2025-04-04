
# 📦 Laravel Backup Package

A simple Laravel package to automatically **backup your database and storage folder**, with a Blade-based UI to view, download, and delete backups.

---

## 🚀 Features

- 🔄 Daily backup of database and storage (`storage/app/public`)
- 🧼 Auto-delete backups older than configurable days
- 🧾 List, download, and delete backups via Blade UI
- 👤 Access control using roles and middleware
- 🛠 Configurable via `config/laravelBackup.php`

---

## 📥 Installation

Install the package via composer:

```bash
composer require avcodewizard/laravel-backup
```

### ✅ Publish Config & Views

```bash
php artisan vendor:publish --tag=laravel-backup
```

This will publish:

- `config/laravelBackup.php`
- Blade views to `resources/views/vendor/laravel-backup/`

---

## ⚙️ Configuration

Edit the config file at: `config/laravelBackup.php`

```php
return [
    'backup_path' => storage_path('backups'),
    'keep_days' => 5, // Automatically delete backups older than 5 days
    'database' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
    ],
    'check_access' => false, // Enable/disable role-based access to UI
    'allowed_roles' => ['Admin', 'Super-Admin'], // List of allowed roles
];
```

---

## 🛡️ Access Control

To enable UI access control based on user roles:

1. Set `'check_access' => true`
2. Add roles in `'allowed_roles' => ['Admin']`
3. Ensure your `User` model has a `hasRole()` method (e.g., using [spatie/laravel-permission](https://github.com/spatie/laravel-permission))

Middleware used:  
`Avcodewizard\LaravelBackup\Http\Middleware\CheckLaravelBackupAccess`

---

## 🖥️ Web Interface

Access the UI at:

```
/laravel-backup
```

Example route setup (already included in the package):

```php
Route::prefix('laravel-backup')
    ->middleware(['web', \Avcodewizard\LaravelBackup\Http\Middleware\CheckLaravelBackupAccess::class])
    ->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('laravel-backup.index');
        Route::get('/create', [BackupController::class, 'create'])->name('laravel-backup.create');
        Route::get('/download', [BackupController::class, 'download'])->name('laravel-backup.download');
        Route::delete('/delete', [BackupController::class, 'delete'])->name('laravel-backup.delete');
    });
```

---

## 🛠 Usage

### Create Backup via Web

1. Go to `/laravel-backup`
2. Click **Create Backup**

### Create Backup via Terminal

```bash
php artisan backup:run
```

---

## 🧹 Automatic Cleanup

Backups older than `keep_days` will be deleted automatically.

### Add to Scheduler

In `app/Console/Kernel.php`, add:

```php
$schedule->command('backup:run')->daily();
```

---

## 📂 Backup Storage

Backups are saved in:

```
storage/backups/
```

Each backup includes:

- `YYYY-MM-DD-HH-MM-SS_database.sql`
- `YYYY-MM-DD-HH-MM-SS_storage.zip`

---

## 🧑‍💻 Developer Notes

### Middleware Logic

The package uses a configurable middleware to restrict access:

```php
if (!config('laravelBackup.check_access')) return $next($request);
if (!$user || !$user->hasRole('Admin')) abort(403);
```

You can customize access logic using roles or your own permission methods.

---

## 📄 License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

© 2025 [Avcodewizard](https://github.com/avcodewizard)
