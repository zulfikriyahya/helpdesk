# Hesk - Help Desk Software

Hesk adalah perangkat lunak help desk yang mudah digunakan untuk mengelola permintaan bantuan dan mengotomatisasi tugas layanan pelanggan. Hesk menyediakan antarmuka yang sederhana namun kuat yang dapat digunakan oleh tim kecil maupun besar.

## Fitur

- **Manajemen Tiket Dukungan**  
  Kelola tiket dukungan pelanggan dengan mudah, pantau status tiket, dan atur prioritas.

- **Penugasan dan Pelacakan**  
  Tugaskan tiket ke staf tertentu dan lacak progres penyelesaian tiket secara real-time.

- **Basis Pengetahuan**  
  Sediakan artikel bantuan dan panduan untuk pelanggan dan staf untuk mengurangi volume tiket yang masuk.

- **Laporan dan Statistik**  
  Buat laporan dan analisis statistik untuk mengevaluasi kinerja tim dan mengidentifikasi area perbaikan.

- **Notifikasi Email**  
  Kirim notifikasi email otomatis kepada pelanggan dan staf mengenai pembaruan status tiket.

## Persyaratan

- Web Server (misalnya, Apache atau Nginx)
- PHP 7.3 atau lebih baru
- MySQL 5.0 atau lebih baru (atau MariaDB)
- Hak akses untuk membuat dan mengubah tabel di database

## Instalasi

Berikut adalah langkah-langkah untuk menginstal Hesk:

1. **Unduh Hesk**

   Unduh versi terbaru Hesk dari [situs resmi Hesk](https://www.hesk.com).

2. **Unggah ke Server**

   Unggah semua file ke direktori di server web Anda.

3. **Atur Hak Akses**

   Pastikan direktori `hesk_settings.inc.php` memiliki izin tulis (CHMOD 666) selama proses instalasi.

4. **Jalankan Instalasi**

   Akses URL tempat Anda mengunggah Hesk di peramban web untuk memulai proses instalasi. Ikuti petunjuk instalasi untuk mengonfigurasi database dan akun admin.

5. **Konfigurasikan Hesk**

   Setelah instalasi selesai, sesuaikan pengaturan Hesk sesuai kebutuhan Anda melalui panel admin.

6. **Amankan File Konfigurasi**

   Setelah instalasi, ubah izin file `hesk_settings.inc.php` menjadi hanya-baca (CHMOD 644) untuk meningkatkan keamanan.

## Lisensi

Hesk dilisensikan di bawah [Lisensi GNU GPL](https://www.gnu.org/licenses/gpl-3.0.html).

Untuk informasi lebih lanjut tentang Hesk, kunjungi [situs resmi Hesk](https://www.hesk.com).
