<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Financial Management Application

Aplikasi manajemen keuangan sederhana yang dibangun dengan Laravel untuk mencatat dan mengelola transaksi, investasi, dan sedekah dengan desain mobile-first dan fitur AJAX.

## Fitur Utama

### 🔐 Autentikasi Manual
- Login dengan username dan password
- Session-based authentication
- Tidak ada fitur register (user dibuat manual)

### 📱 Mobile-First Design
- Bottom navigation untuk mobile
- Responsive design dengan Tailwind CSS
- Desktop navigation untuk layar besar
- Optimized untuk penggunaan mobile

### 📊 Dashboard Publik
- Statistik bulanan (pendapatan, pengeluaran, investasi, sedekah)
- Filter berdasarkan bulan dan tahun
- Grafik pie chart untuk ringkasan kategori
- Grafik line chart untuk tren bulanan
- Dapat diakses tanpa login

### 💰 Manajemen Transaksi
- CRUD lengkap dengan modal popup
- AJAX form submission
- SweetAlert2 untuk notifikasi
- Kategori: Pendapatan dan Pengeluaran
- Validasi form real-time
- Soft delete

### 📈 Manajemen Investasi
- CRUD lengkap dengan modal popup
- AJAX form submission
- SweetAlert2 untuk notifikasi
- Jenis investasi fleksibel (saham, reksadana, emas, dll)
- Validasi form real-time
- Soft delete

### 🤲 Manajemen Sedekah
- CRUD lengkap dengan modal popup
- AJAX form submission
- SweetAlert2 untuk notifikasi
- Informasi penerima dan keterangan
- Validasi form real-time
- Soft delete

### 🎨 UI/UX Modern
- Tailwind CSS untuk styling
- SweetAlert2 untuk notifikasi dan konfirmasi
- Chart.js untuk visualisasi data
- jQuery untuk AJAX functionality
- Mobile-first responsive design

## Struktur Database

### Tabel Users
- `id` - Primary key
- `name` - Nama lengkap user
- `username` - Username untuk login (unique)
- `password` - Password yang di-hash
- `created_at`, `updated_at` - Timestamps

### Tabel Transaksis
- `id` - Primary key
- `user_id` - Foreign key ke users
- `tanggal` - Tanggal transaksi
- `kategori` - Enum: 'pendapatan' atau 'pengeluaran'
- `keterangan` - Deskripsi transaksi
- `jumlah` - Jumlah uang (decimal)
- `created_at`, `updated_at`, `deleted_at` - Timestamps

### Tabel Investasis
- `id` - Primary key
- `user_id` - Foreign key ke users
- `tanggal` - Tanggal investasi
- `jenis` - Jenis investasi (string)
- `keterangan` - Deskripsi investasi
- `jumlah` - Jumlah investasi (decimal)
- `created_at`, `updated_at`, `deleted_at` - Timestamps

### Tabel Sedekahs
- `id` - Primary key
- `user_id` - Foreign key ke users
- `tanggal` - Tanggal sedekah
- `penerima` - Nama penerima sedekah
- `jumlah` - Jumlah sedekah (decimal)
- `keterangan` - Deskripsi sedekah
- `created_at`, `updated_at`, `deleted_at` - Timestamps

## Instalasi

### Prerequisites
- PHP 8.1+
- Composer
- Database (MySQL/PostgreSQL/SQLite)

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd financial
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=financial
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migration dan seeder**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Jalankan server development**
   ```bash
   php artisan serve
   ```

7. **Akses aplikasi**
   Buka browser dan akses `http://localhost:8000`

## Login Default

Setelah menjalankan seeder, Anda dapat login dengan:
- **Username:** `admin`
- **Password:** `password`

## Routing

### Public Routes
- `GET /` - Dashboard utama dengan statistik
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `POST /logout` - Logout

### Protected Routes (memerlukan login)
- `GET /transaksi` - Daftar transaksi
- `POST /transaksi` - Simpan transaksi baru (AJAX)
- `GET /transaksi/{id}/edit` - Get data transaksi untuk edit (AJAX)
- `PUT /transaksi/{id}` - Update transaksi (AJAX)
- `DELETE /transaksi/{id}` - Hapus transaksi (AJAX)

- `GET /investasi` - Daftar investasi
- `POST /investasi` - Simpan investasi baru (AJAX)
- `GET /investasi/{id}/edit` - Get data investasi untuk edit (AJAX)
- `PUT /investasi/{id}` - Update investasi (AJAX)
- `DELETE /investasi/{id}` - Hapus investasi (AJAX)

- `GET /sedekah` - Daftar sedekah
- `POST /sedekah` - Simpan sedekah baru (AJAX)
- `GET /sedekah/{id}/edit` - Get data sedekah untuk edit (AJAX)
- `PUT /sedekah/{id}` - Update sedekah (AJAX)
- `DELETE /sedekah/{id}` - Hapus sedekah (AJAX)

## Teknologi yang Digunakan

- **Backend:** Laravel 11
- **Database:** MySQL/PostgreSQL/SQLite
- **Frontend:** HTML, Tailwind CSS, JavaScript
- **Charts:** Chart.js
- **Notifications:** SweetAlert2
- **AJAX:** jQuery
- **Authentication:** Session-based (manual)

## Fitur AJAX

### Form Submission
- Semua form menggunakan AJAX untuk submission
- Real-time validation feedback
- Modal popup untuk create/edit
- Auto-refresh setelah operasi berhasil

### Delete Confirmation
- SweetAlert2 untuk konfirmasi hapus
- AJAX delete tanpa page reload
- Success/error notifications

### Data Fetching
- AJAX untuk mengambil data edit
- Pre-fill form dengan data existing
- Smooth user experience

## Mobile Features

### Bottom Navigation
- Fixed bottom navigation untuk mobile
- Icon dan label yang jelas
- Active state indication
- Responsive design

### Touch-Friendly
- Large touch targets
- Swipe gestures support
- Mobile-optimized forms
- Fast loading times

## Struktur File Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── TransaksiController.php
│   │   ├── InvestasiController.php
│   │   └── SedekahController.php
│   └── Middleware/
│       └── AuthMiddleware.php
├── Models/
│   ├── User.php
│   ├── Transaksi.php
│   ├── Investasi.php
│   └── Sedekah.php
resources/
└── views/
    ├── layouts/
    │   └── app.blade.php
    ├── auth/
    │   └── login.blade.php
    ├── home.blade.php
    ├── transaksi/
    │   └── index.blade.php
    ├── investasi/
    │   └── index.blade.php
    └── sedekah/
        └── index.blade.php
```

## Kontribusi

1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## License

Distributed under the MIT License. See `LICENSE` for more information.

## Kontak

Jika ada pertanyaan atau saran, silakan buat issue di repository ini.
