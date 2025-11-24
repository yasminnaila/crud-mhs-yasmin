<?php
require_once 'config/database.php';

$error = '';
$data = null;

// Cek apakah ada ID yang dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data mahasiswa berdasarkan ID
$query = "SELECT * FROM mahasiswa WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$data = mysqli_fetch_assoc($result);

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
        // Cek apakah NIM sudah ada (kecuali untuk data yang sedang diedit)
        $check_query = "SELECT id FROM mahasiswa WHERE nim = '$nim' AND id != '$id'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = "NIM sudah terdaftar!";
        } else {
            // Update data
            $query = "UPDATE mahasiswa SET 
                      nim = '$nim',
                      nama = '$nama',
                      email = '$email',
                      jurusan = '$jurusan',
                      alamat = '$alamat'
                      WHERE id = '$id'";
            
            if (mysqli_query($conn, $query)) {
                header("Location: index.php?success=edit");
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
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>✏️ Edit Data Mahasiswa</h1>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="nim" required value="<?php echo htmlspecialchars(isset($_POST['nim']) ? $_POST['nim'] : $data['nim']); ?>">
            </div>

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required value="<?php echo htmlspecialchars(isset($_POST['nama']) ? $_POST['nama'] : $data['nama']); ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars(isset($_POST['email']) ? $_POST['email'] : $data['email']); ?>">
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan:</label>
                <select id="jurusan" name="jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <?php 
                    $jurusan_selected = isset($_POST['jurusan']) ? $_POST['jurusan'] : $data['jurusan'];
                    $jurusan_list = ['Teknik Informatika', 'Sistem Informasi', 'Teknik Komputer', 'Manajemen Informatika'];
                    foreach ($jurusan_list as $jurusan_option):
                    ?>
                        <option value="<?php echo $jurusan_option; ?>" <?php echo ($jurusan_selected == $jurusan_option) ? 'selected' : ''; ?>>
                            <?php echo $jurusan_option; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars(isset($_POST['alamat']) ? $_POST['alamat'] : $data['alamat']); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Update</button>
                <a href="index.php" class="btn btn-secondary">↩️ Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
