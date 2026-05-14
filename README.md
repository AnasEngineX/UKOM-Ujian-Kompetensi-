#  Sistem Informasi Pendaftaran Beasiswa (SIBEASISWA)

**Author     :** Anas Atthariq  
**Tanggal    :** 13 Mei 2026  
**Deskripsi  :** Aplikasi web berbasis Laravel untuk mengelola pendaftaran beasiswa mahasiswa, dilengkapi fitur CRUD (Create, Read, Update, Delete) lengkap dengan tampilan antarmuka modern.

---

##  Daftar Isi

- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Fitur Aplikasi](#fitur-aplikasi)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Cara Instalasi dan Menjalankan](#cara-instalasi-dan-menjalankan)
- [Struktur Folder Proyek](#struktur-folder-proyek)
- [Penjelasan File Utama](#penjelasan-file-utama)
- [Daftar Route](#daftar-route)

---

## 🛠️ Teknologi yang Digunakan

| Teknologi         | Versi      | Keterangan                        |
|-------------------|------------|-----------------------------------|
| PHP               | >= 8.2     | Bahasa pemrograman utama          |
| Laravel           | >= 11.x    | Framework PHP backend             |
| MySQL / SQLite    | -          | Database penyimpanan data         |
| Bootstrap         | 5.3.3      | Framework CSS (via CDN)           |
| Font Awesome      | 6.5.0      | Library ikon (via CDN)            |
| Google Fonts      | Poppins    | Tipografi modern (via CDN)        |

---

##  Fitur Aplikasi

- ✅ **Dashboard** — Menampilkan statistik total pendaftar, beasiswa akademik, dan non-akademik
- ✅ **Create** — Form pendaftaran beasiswa baru dengan IPK yang di-generate otomatis
- ✅ **Read** — Tabel seluruh data pendaftar dengan badge status berwarna
- ✅ **Detail (Show)** — Halaman detail read-only untuk mencegah manipulasi data
- ✅ Validasi input di sisi server (Laravel Validation)
- ✅ Upload file (PDF, JPG, PNG, ZIP maks. 5 MB)
- ✅ **Auto-Verifikasi Berwaktu** — Status ajuan memiliki countdown 1 menit, setelah habis otomatis Diterima (IPK ≥ 3.5) atau Ditolak (IPK < 3.5)
- ✅ Tampilan antarmuka dark glassmorphism premium

---

## ⚙️ Persyaratan Sistem

Sebelum instalasi, pastikan perangkat sudah terpasang:

- **PHP** versi 8.2 atau lebih baru
- **Composer** (package manager PHP)
- **MySQL** atau database lain yang didukung Laravel
- **Git** (opsional, untuk clone repository)

---

## Cara Instalasi dan Menjalankan

### 1. Clone atau Salin Proyek

```bash
git clone <url-repository>
cd UKOM-APP
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Buat File Konfigurasi Environment

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Buka file `.env` dan sesuaikan pengaturan database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ukom_app
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migrasi Database

```bash
php artisan migrate
```

> Jika ingin mengulang dari awal (hapus semua tabel lalu buat ulang):
> ```bash
> php artisan migrate:fresh
> ```

### 7. Buat Folder Penyimpanan Berkas Upload

```bash
mkdir public/berkas
```

### 8. Jalankan Server Lokal

```bash
php artisan serve
```

### 9. Buka di Browser

```
http://127.0.0.1:8000
```

---

## Struktur Folder Proyek

```
UKOM-APP/                              ← Root proyek Laravel
│
├── app/                               ← Logika inti aplikasi
│   ├── Http/
│   │   └── Controllers/
│   │       ├── BeasiswaController.php ← Controller CRUD utama beasiswa
│   │       └── Controller.php         ← Base controller Laravel
│   └── Models/
│       └── Beasiswa.php               ← Model Eloquent tabel beasiswa
│
├── database/
│   └── migrations/
│       ├── 2026_05_13_075912_create_beasiswa_table.php  ← Migrasi tabel beasiswa (aktif)
│       └── 2026_05_13_070419_create_beasiswas_table.php ← Migrasi lama (tidak digunakan)
│
├── public/
│   └── berkas/                        ← Folder penyimpanan file upload berkas syarat
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php          ← Layout utama (sidebar, CSS global, navbar)
│       └── dashboard/
│           ├── index.blade.php        ← Halaman dashboard + statistik
│           ├── daftar.blade.php       ← Form pendaftaran beasiswa (Create)
│           ├── hasil.blade.php        ← Tabel data pendaftar (Read)
│           └── show.blade.php         ← Halaman detail data beasiswa (Read-only)
│
├── routes/
│   └── web.php                        ← Definisi semua route HTTP aplikasi
│
├── .env                               ← Konfigurasi environment (database, app key, dll.)
├── .env.example                       ← Template konfigurasi environment
├── composer.json                      ← Daftar dependensi PHP
└── README.md                          ← Dokumentasi proyek ini
```

---

## Penjelasan File Utama

### `routes/web.php`
Mendefinisikan semua URL (route) yang dapat diakses. Menggunakan pola RESTful CRUD:

| Method   | URL                    | Nama Route        | Fungsi                     |
|----------|------------------------|-------------------|----------------------------|
| GET      | `/`                    | —                 | Redirect ke dashboard       |
| GET      | `/dashboard`           | `dashboard`       | Halaman dashboard + statistik |
| GET      | `/dashboard/daftar`    | `dashboard.daftar`| Tampilkan form pendaftaran  |
| POST     | `/dashboard/store`     | `dashboard.store` | Simpan data baru            |
| GET      | `/dashboard/hasil`     | `dashboard.hasil` | Tampilkan semua data        |
| GET      | `/dashboard/{id}/show` | `dashboard.show`  | Tampilkan halaman detail read-only |

---

### `app/Http/Controllers/BeasiswaController.php`
Controller utama yang menangani semua logika CRUD:

| Method      | Fungsi                                                           |
|-------------|------------------------------------------------------------------|
| `autoVerifikasiStatus()` | Menjalankan logika timer verifikasi 1 menit otomatis |
| `index()`   | Ambil statistik dan tampilkan dashboard                          |
| `daftar()`  | Tampilkan form pendaftaran kosong                                 |
| `store()`   | Validasi, upload file, simpan data baru ke database              |
| `hasil()`   | Cek verifikasi, ambil semua data, tampilkan tabel dengan timer   |
| `show()`    | Tampilkan halaman detail data mahasiswa (read-only)              |

---

### `app/Models/Beasiswa.php`
Model Eloquent yang merepresentasikan tabel `beasiswa` di database.  
Kolom yang dapat diisi (`$fillable`):

- `nama` — Nama lengkap pendaftar
- `email` — Alamat email pendaftar
- `no_telepon` — Nomor handphone
- `semester` — Semester aktif (1–8)
- `ipk` — Indeks Prestasi Kumulatif (0.00–4.00)
- `pilihan_beasiswa` — Beasiswa Akademik / Non Akademik
- `file_berkas_syarat` — Nama file berkas yang diupload
- `status_ajuan` — Status: Menunggu Verifikasi / Diterima / Ditolak

---

### `resources/views/layouts/app.blade.php`
Template layout bersama yang diwarisi oleh semua halaman. Berisi:
- Sidebar navigasi dengan active state
- Import Bootstrap 5.3, Font Awesome 6, Google Fonts Poppins
- Sistem CSS premium (dark glassmorphism, animasi, komponen)

---

### `database/migrations/2026_05_13_075912_create_beasiswa_table.php`
Migrasi yang membuat tabel `beasiswa` dengan kolom:
`id`, `nama`, `email`, `no_telepon`, `semester`, `ipk`, `pilihan_beasiswa`, `file_berkas_syarat`, `status_ajuan`, `created_at`, `updated_at`

---

## Daftar Route

Jalankan perintah berikut untuk melihat semua route yang terdaftar:

```bash
php artisan route:list
```

---

*Dokumentasi ini dibuat sebagai bagian dari tugas UKOM — Sistem Informasi Pendaftaran Beasiswa.*
