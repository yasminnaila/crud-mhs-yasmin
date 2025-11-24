# CRUD Sederhana - PHP Native & MySQL

Aplikasi CRUD (Create, Read, Update, Delete) sederhana untuk manajemen data mahasiswa menggunakan PHP Native dan MySQL.

## 📋 Fitur

- ✅ Tambah data mahasiswa
- ✅ Lihat daftar mahasiswa
- ✅ Edit data mahasiswa
- ✅ Hapus data mahasiswa
- ✅ Validasi form
- ✅ Responsive design

## 🛠️ Teknologi

- PHP Native (tanpa framework)
- MySQL Database
- HTML5 & CSS3

## 📦 Instalasi

### 1. Persiapan

Pastikan Anda sudah menginstal:
- XAMPP/WAMP/LAMP (PHP & MySQL)
- Web Browser

### 2. Setup Database

1. Buka phpMyAdmin (http://localhost/phpmyadmin)
2. Import file `database.sql` atau jalankan query berikut:

```sql
CREATE DATABASE IF NOT EXISTS crud_yasmin;
USE crud_yasmin;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 3. Konfigurasi Database

Edit file `config/database.php` sesuai dengan konfigurasi MySQL Anda:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // Sesuaikan dengan username MySQL Anda
define('DB_PASS', '');              // Sesuaikan dengan password MySQL Anda
define('DB_NAME', 'crud_yasmin');
```

### 4. Jalankan Aplikasi

1. Copy folder proyek ke folder `htdocs` (untuk XAMPP) atau `www` (untuk WAMP)
2. Start Apache dan MySQL dari XAMPP/WAMP Control Panel
3. Buka browser dan akses: `http://localhost/crud-yasmin`

## 📁 Struktur Proyek

```
crud-yasmin/
│
├── config/
│   └── database.php          # Konfigurasi koneksi database
│
├── assets/
│   └── css/
│       └── style.css         # Styling CSS
│
├── index.php                 # Halaman utama (Read)
├── create.php                # Halaman tambah data (Create)
├── update.php                # Halaman edit data (Update)
├── delete.php                # Proses hapus data (Delete)
├── database.sql              # File SQL untuk setup database
└── README.md                 # Dokumentasi proyek
```

## 🚀 Cara Penggunaan

### Menambah Data
1. Klik tombol "➕ Tambah Data"
2. Isi form dengan data mahasiswa
3. Klik "💾 Simpan"

### Melihat Data
- Data mahasiswa akan ditampilkan dalam bentuk tabel di halaman utama

### Mengedit Data
1. Klik tombol "✏️ Edit" pada data yang ingin diubah
2. Ubah data yang diperlukan
3. Klik "💾 Update"

### Menghapus Data
1. Klik tombol "🗑️ Hapus" pada data yang ingin dihapus
2. Konfirmasi penghapusan
3. Data akan terhapus

## 🔒 Keamanan

Aplikasi ini sudah menggunakan:
- `mysqli_real_escape_string()` untuk mencegah SQL Injection
- `htmlspecialchars()` untuk mencegah XSS
- Validasi input form

## 📝 Catatan

- Aplikasi ini dibuat untuk tujuan pembelajaran
- Pastikan XAMPP/WAMP sudah berjalan sebelum mengakses aplikasi
- Database akan otomatis dibuat saat import file SQL

## 👨‍💻 Developer

Dibuat dengan ❤️ menggunakan PHP Native

## 📄 Lisensi

Free to use untuk keperluan pembelajaran
