# Panduan Penggunaan KEDAI-CKCK

Panduan ini menjelaskan alur penggunaan aplikasi setelah proses setup selesai. Untuk instalasi dan konfigurasi awal, ikuti terlebih dahulu langkah-langkah pada `SETUP_TUTORIAL.md`.

## 1. Alur Pelanggan di Meja
- **Scan QR meja** → pelanggan diarahkan ke `/order?meja=XX`.
- **Lengkapi data**: nama, nomor HP, keterangan opsional.
- **Pilih menu**: atur kuantitas, tekan `Tambah ke Keranjang`.
- **Kelola keranjang**: hapus item bila salah, pastikan total sesuai.
- **Submit Order**: pesanan berubah ke status `submitted` dan menampilkan invoice.

## 2. Pembayaran & Bukti
- Dari invoice tekan `Lanjut ke Pembayaran`.
- Pilih metode `QRIS`, `Transfer Bank`, `E-Wallet`, atau `Tunai` lalu tekan `Proses Pembayaran`.
- Ikuti instruksi yang muncul (nominal, nomor rekening/ewallet, atau konfirmasi kasir).
- Tekan `Konfirmasi Pembayaran` untuk menandai order sebagai `paid` dan status dapur `preparing`.
- Kembali ke invoice untuk mengunduh struk PDF jika diperlukan.

## 3. Histori Pesanan Pelanggan
- Akses `/order-history` atau tombol `Cek Histori Pesanan` pada halaman order.
- Masukkan nomor HP yang sama dengan saat pemesanan.
- Riwayat menampilkan daftar order, total belanja, status pembayaran, dan akses cepat ke invoice/pembayaran.

## 4. Panel Admin Filament
1. Buat akun admin dengan `php artisan make:filament-user` (gunakan nama `admin` agar semua menu terlihat).
2. Login di `/admin` dan kelola menu berikut:
   - **Menu**: tambah/edit menu, unggah foto, atur harga & stok, aktif/nonaktifkan status.
   - **Pesanan**: pantau order masuk, cek status pembayaran, hapus input salah, unduh laporan `orders.xlsx` via `/sales/export`.
   - **Table**: buat nomor meja, tekan `Generate QR` untuk membentuk file SVG, `Download QR` untuk dicetak.
   - **User**: buat akun tambahan (mis. dapur), isi `no_hp`, tentukan `role`.

## 5. Panel Dapur
- Berikan akun Filament non-admin (role `dapur` atau nama lain) untuk akses terbatas.
- Login di `/admin`, buka menu `Dapur`:
  - Lihat seluruh order berstatus `paid` beserta ringkasan item.
  - Gunakan aksi `Lihat Invoice` bila perlu detail tambahan.
  - Tekan `Edit` untuk memperbarui `Status Makanan` dari `pesanan sedang diproses` menjadi `pesanan selesai` setelah makanan siap.

## 6. Catatan Operasional
- Stok menu otomatis berkurang saat item ditambahkan dan kembali bertambah saat item dihapus; cek stok rutin.
- Status order bergerak: `pending` → `submitted` → `paid`; status makanan dimulai dengan `pesanan diterima` dan diperbarui dapur.
- Form order hanya dapat diakses dengan parameter `?meja=XX`; pastikan QR code mengarah ke URL yang benar.
- Nomor HP menjadi kunci riwayat dan layanan purna jual, verifikasi input pelanggan sebelum menyimpan order.

## 7. Rekomendasi Implementasi
- Uji alur lengkap (pelanggan → kasir → dapur) di lingkungan staging sebelum go-live.
- Cetak dan tempel QR code di setiap meja, sertakan instruksi singkat bagi pelanggan.
- Siapkan SOP singkat untuk kasir dan dapur berdasarkan panduan ini sebagai materi onboarding tim.
