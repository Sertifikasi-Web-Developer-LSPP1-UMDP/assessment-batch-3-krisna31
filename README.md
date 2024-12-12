# Yoklah University

**Yoklah University** adalah aplikasi berbasis web untuk pendaftaran mahasiswa baru, dimulai dari pembuatan akun, pengisian formulir pendaftaran, hingga pengelolaan status mahasiswa oleh admin. Aplikasi ini dikembangkan menggunakan framework **Laravel**.

## Spesifikasi Proyek

- **Nama Proyek**: Yoklah University
- **Framework**: Laravel 10.x
- **Bahasa Pemrograman**: PHP 8.2.4 atau > 8.x
- **Database**: MySQL 8.0.30-winx64
- **Lisensi**: MIT

## Fitur Utama

- Melihat pengumuman.
- Melakukan login dan pendaftaran akun.
- Formulir pendaftaran mahasiswa baru.
- Dashboard admin untuk verifikasi, pengubahan data mahasiswa, dan pengelolaan data pengumuman.
- Manajemen role dan hak akses menggunakan `Laratrust`.
- Tabel interaktif menggunakan `DataTables`.
- `Log viewer` untuk debugging saat website mengalami error bagi developer.

---

## Instalasi

1. **Clone repository**:
   ```bash
   git clone https://github.com/Sertifikasi-Web-Developer-LSPP1-UMDP/assessment-batch-3-krisna31
   cd assessment-batch-3-krisna31
   ```

2. **Install dependensi menggunakan Composer**:
   ```bash
   composer install
   ```

3. **Salin file `.env` dan sesuaikan konfigurasi**:
   ```bash
   cp .env.example .env
   ```

   - Isi detail database sesuai yang dibutuhkan:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=yoklah_university
     DB_USERNAME=root
     DB_PASSWORD=your_password
     ```

4. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

5. **Jalankan migrasi database dan seeder**:
   ```bash
   php artisan migrate --seed
   ```

6. **Install front-end dependencies**:
   ```bash
   npm i
   npm run dev
   ```

7. **Jalankan server lokal**:
   ```bash
   php artisan serve
   ```

8. **Akses web di [localhost:8000](localhost:8000)**

---

## Dependensi Utama

| Library                         | Versi      | Deskripsi                              |
|---------------------------------|------------|----------------------------------------|
| `laravel/framework`             | 10.10      | Laravel Framework                      |
| `jeroennoten/laravel-adminlte`  | 3.14       | Template AdminLTE untuk Laravel        |
| `yajra/laravel-datatables`      | 10         | Tabel interaktif                       |
| `santigarcor/laratrust`         | 8.3        | Manajemen role dan hak akses           |
| `laravel/sanctum`               | 3.3        | Autentikasi API berbasis token         |
| `rap2hpoutre/laravel-log-viewer`| 2.4        | Melihat log aplikasi                   |

---

## Plugin Frontend yang Digunakan

| Plugin           | Versi      | Deskripsi                                                                 |
|------------------|------------|---------------------------------------------------------------------------|
| `DataTables`     | 1.10.19    | Menampilkan tabel yang dinamis dan interaktif                             |
| `Sweetalert2`    | 11.10.5    | Membuat alert yang interaktif untuk pengalaman pengguna yang lebih baik.  |
| `Jquery-Throttle`| 1.1        | Mempermudah proses debounce dan throttle pada event di JavaScript.        |
| `Moment`         | 2.30.1     | Mengolah tanggal secara mudah di JavaScript dengan fitur lengkap.         |
| `NotifyJs`       | 3.0.0      | Menampilkan notifikasi sederhana di browser.                              |
| `Select2`        | 4.1.0-rc.0 | Membuat input select lebih interaktif dengan pencarian dan styling.       |
| `jquery-ui`      | 1.13.2     | Menyediakan fitur drag-and-drop untuk elemen UI seperti modal.            |
| `Flatpickr`      | 4.6.13     | Menyediakan datepicker interaktif dengan berbagai opsi konfigurasi.       |

---

## Spesifikasi Minimum

- **PHP**: 8.2 atau lebih baru
- **Composer**: 2.2.5 atau lebih baru
- **Node**: 18.16.1 atau lebih baru
- **NPM**: 9.5.1 atau lebih baru
- **MySQL**: 8.0.30-winx64 atau lebih baru

---

## Kontribusi

1. **Fork repo ini**.
2. Buat branch fitur baru:
   ```bash
   git checkout -b fitur/nama_fitur_yang_akan_dibuat
   ```
3. Buat PR setelah fitur berhasil dibuat.

---

## Lisensi

Proyek ini dilisensikan di bawah lisensi **MIT**. Silakan lihat file [LICENSE](LICENSE) untuk detailnya.

---

## Copyright
Copyright ©2024 Universitas Yoklah. All right reserved.
