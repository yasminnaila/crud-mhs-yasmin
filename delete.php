<?php
require_once 'config/database.php';

// Cek apakah ada ID yang dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Cek apakah data ada
$check_query = "SELECT id FROM mahasiswa WHERE id = '$id'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    header("Location: index.php");
    exit();
}

// Hapus data
$query = "DELETE FROM mahasiswa WHERE id = '$id'";

if (mysqli_query($conn, $query)) {
    header("Location: index.php?success=hapus");
} else {
    header("Location: index.php?error=hapus");
}

mysqli_close($conn);
exit();
?>
