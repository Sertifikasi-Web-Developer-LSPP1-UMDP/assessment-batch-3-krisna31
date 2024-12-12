[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/UwpJJG2e)

# Yokla University

**Yokla University** adalah aplikasi berbasis web untuk pendaftaran mahasiswa baru, dimulai dari pembuatan akun, pengisian formulir pendaftaran, hingga pengelolaan status mahasiswa oleh admin. Aplikasi ini dikembangkan menggunakan framework **Laravel**.

## Spesifikasi Proyek

- **Nama Proyek**: Yokla University
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
     DB_DATABASE=yokla_university
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

| Library                           | Versi   | Deskripsi                              |
|---------------------------------|---------|----------------------------------------|
| `laravel/framework`             | ^10.10  | Laravel Framework                      |
| `jeroennoten/laravel-adminlte`  | ^3.14   | Template AdminLTE untuk Laravel        |
| `yajra/laravel-datatables`      | ^10     | Tabel interaktif                       |
| `santigarcor/laratrust`         | ^8.3    | Manajemen role dan hak akses           |
| `laravel/sanctum`               | ^3.3    | Autentikasi API berbasis token         |
| `rap2hpoutre/laravel-log-viewer`| ^2.4    | Melihat log aplikasi                   |

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
