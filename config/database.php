<?php
// Konfigurasi Database
// Deteksi environment (Azure atau Localhost)
if (getenv('WEBSITE_SITE_NAME')) {
    // Azure Environment
    define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
    define('DB_USER', getenv('DB_USER') ?: 'root');
    define('DB_PASS', getenv('DB_PASS') ?: '');
    define('DB_NAME', getenv('DB_NAME') ?: 'crud_yasmin');
} else {
    // Local Environment
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'crud_yasmin');
}

// Membuat koneksi dengan SSL
$conn = mysqli_init();

// Set SSL options untuk Azure MySQL
if (getenv('WEBSITE_SITE_NAME')) {
    mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
    mysqli_real_connect($conn, DB_HOST, DB_USER, DB_PASS, DB_NAME, 3306, NULL, MYSQLI_CLIENT_SSL);
} else {
    // Local connection tanpa SSL
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset UTF-8
mysqli_set_charset($conn, "utf8");
?>
