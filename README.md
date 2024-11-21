langkah-langkah

- Buat project laravel
- Siapkan database (web-keuangan)
- Setting konfigurasi database di .env
- Jalankan migration (php artisan migrate)
- install filament (composer require filament/filament:"^3.2" -W)
- install panel filament (php artisan filament:install --panels)
- Buat user untuk filament panel / admin (php artisan make:filament-user)



Modul baru
- buat model
- isi model dengan fillable columns (php artisan make:model NamaModelnya -m)
- isi migration table
- jalankan php migrate
- buat filament resource (php artisan make:filament-resource NamaModulnya --generate)


 Cara Pasang Filter dan Custumize Dashboard
 - Buat folder Pages di app/filament
 - Buat file Dashboard.php
 - Copy basicnya di https://github.com/filamentphp/demo/blob/main/app/Filament/Pages/Dashboard.php
 - Lalu hapus object pages di app/provider/filament/adminPanelProvider
       ->pages([
                Pages\Dashboard::class,
            ])

        jadi seperti ini

        ->pages([])
 - Tambahkan start dan dan end date menggunakan carbon sebagai handlernya
  $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();
            
 - lalu tambahkan use InteractsWithPageFilters di paling atas