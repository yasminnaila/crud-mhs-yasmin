-- Membuat Database
CREATE DATABASE IF NOT EXISTS crud_yasmin;

-- Menggunakan Database
USE crud_yasmin;

-- Membuat Tabel Mahasiswa
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

-- Insert data contoh
INSERT INTO mahasiswa (nim, nama, email, jurusan, alamat) VALUES
('2021001', 'Ahmad Fauzi', 'ahmad@email.com', 'Teknik Informatika', 'Jakarta'),
('2021002', 'Siti Nurhaliza', 'siti@email.com', 'Sistem Informasi', 'Bandung'),
('2021003', 'Budi Santoso', 'budi@email.com', 'Teknik Komputer', 'Surabaya');
