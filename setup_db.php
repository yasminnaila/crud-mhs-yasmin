<?php
// File ini untuk setup database pertama kali
// Hapus file ini setelah database berhasil dibuat!

require_once 'config/database.php';

echo "Testing database connection...<br>";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "✅ Connected successfully!<br><br>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS crud_yasmin";
if (mysqli_query($conn, $sql)) {
    echo "✅ Database created successfully<br>";
} else {
    echo "❌ Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select database
mysqli_select_db($conn, 'crud_yasmin');

// Create table
$sql = "CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "✅ Table created successfully<br>";
} else {
    echo "❌ Error creating table: " . mysqli_error($conn) . "<br>";
}

// Insert sample data
$sql = "INSERT INTO mahasiswa (nim, nama, email, jurusan, alamat) VALUES
('2021001', 'Ahmad Fauzi', 'ahmad@email.com', 'Teknik Informatika', 'Jakarta'),
('2021002', 'Siti Nurhaliza', 'siti@email.com', 'Sistem Informasi', 'Bandung'),
('2021003', 'Budi Santoso', 'budi@email.com', 'Teknik Komputer', 'Surabaya')";

if (mysqli_query($conn, $sql)) {
    echo "✅ Sample data inserted successfully<br>";
} else {
    echo "❌ Error inserting data: " . mysqli_error($conn) . "<br>";
}

echo "<br><strong>Setup complete! Please delete this file (setup_db.php) for security.</strong>";

mysqli_close($conn);
?>
