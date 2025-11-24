<?php
require_once 'config/database.php';

$error = '';

// Proses form ketika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    
    // Validasi
    if (empty($nim) || empty($nama) || empty($email) || empty($jurusan)) {
        $error = "Semua field wajib diisi kecuali alamat!";
    } else {
        // Cek apakah NIM sudah ada
        $check_query = "SELECT id FROM mahasiswa WHERE nim = '$nim'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = "NIM sudah terdaftar!";
        } else {
            // Insert data
            $query = "INSERT INTO mahasiswa (nim, nama, email, jurusan, alamat) 
                      VALUES ('$nim', '$nama', '$email', '$jurusan', '$alamat')";
            
            if (mysqli_query($conn, $query)) {
                header("Location: index.php?success=tambah");
                exit();
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>➕ Tambah Data Mahasiswa</h1>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="nim" required value="<?php echo isset($_POST['nim']) ? htmlspecialchars($_POST['nim']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan:</label>
                <select id="jurusan" name="jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="Teknik Informatika" <?php echo (isset($_POST['jurusan']) && $_POST['jurusan'] == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                    <option value="Sistem Informasi" <?php echo (isset($_POST['jurusan']) && $_POST['jurusan'] == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                    <option value="Teknik Komputer" <?php echo (isset($_POST['jurusan']) && $_POST['jurusan'] == 'Teknik Komputer') ? 'selected' : ''; ?>>Teknik Komputer</option>
                    <option value="Manajemen Informatika" <?php echo (isset($_POST['jurusan']) && $_POST['jurusan'] == 'Manajemen Informatika') ? 'selected' : ''; ?>>Manajemen Informatika</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat" rows="3"><?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="index.php" class="btn btn-secondary">↩️ Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
