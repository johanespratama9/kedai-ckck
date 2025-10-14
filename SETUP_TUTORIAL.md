# Tutorial Setup KEDAI-CKCK

## 1. Persiapan Lingkungan
- PHP 8.2 atau lebih baru
- Composer 2
- Node.js 18+ dan npm (untuk Vite)
- MySQL 8 / MariaDB 10.4+ (atau database lain yang kompatibel dengan Laravel)
- Git (opsional, jika ingin clone langsung dari repository)

## 2. Clone dan Install Dependensi
```bash
cd KEDAI-CKCK
composer install
npm install
```
Jika Anda tidak menggunakan git, unduh source code lalu ekstrak ke folder kerja dan jalankan dua perintah terakhir.

## 3. Konfigurasi File Environment
```bash
cp .env.example .env
```
Edit `.env` dan sesuaikan nilai berikut:
- `APP_NAME`, `APP_URL` (misalnya `http://localhost:8000`)
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Atur kredensial mail/storage bila diperlukan

Lalu generate application key:
```bash
php artisan key:generate
```

## 4. Siapkan Database
1. Buat database kosong dengan nama yang sama seperti `DB_DATABASE` pada `.env`.
2. Jalankan migrasi:
   ```bash
   php artisan migrate
   ```
3. (Opsional) Seed contoh data order untuk laporan/riwayat:
   ```bash
   php artisan db:seed --class=OrderSeeder
   ```
   atau jalankan semua seeder default:
   ```bash
   php artisan db:seed
   ```

> Catatan: Seeder bawaan akan membuat satu user contoh (`test@example.com`). Anda bebas menghapus atau menyesuaikan data tersebut.

## 5. Membuat Admin Panel Filament
Laravel sudah terpasang Filament v3 dan panel admin dapat diakses melalui `/admin`.

1. Jalankan perintah berikut untuk membuat akun admin:
   ```bash
   php artisan make:filament-user
   ```
2. Masukkan data user sesuai prompt. Untuk mengaktifkan seluruh menu navigasi admin, gunakan `admin` sebagai nama pengguna.
3. Setelah user dibuat, login di `http://localhost:8000/admin` dengan email & password yang baru saja Anda masukkan.
4. Lengkapi kolom tambahan seperti `no_hp` langsung dari panel Filament (menu User) setelah login.

## 6. Menjalankan Aplikasi
Untuk backend Laravel + API:
```bash
php artisan serve
```
Untuk asset front-end via Vite (opsional saat pengembangan):
```bash
npm run dev
```
Aplikasi kini dapat diakses di `http://localhost:8000`.

## 7. Perintah Berguna Lainnya
- `php artisan migrate:fresh --seed` — mengulang migrasi dan seeder dari awal
- `php artisan storage:link` — membuat symbolic link ke storage publik jika Anda ingin meng-upload file menu
- `php artisan test` — menjalankan test bawaan Laravel

Selesai! Dengan langkah di atas, base code KEDAI-CKCK siap dijalankan lengkap dengan database dan admin panel Filament.
