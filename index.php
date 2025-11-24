<?php
require_once 'config/database.php';

// Ambil semua data mahasiswa
$query = "SELECT * FROM mahasiswa ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Cek apakah ada pesan sukses
$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - CRUD PHP MySQL</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>📚 Data Mahasiswa</h1>
        
        <?php if ($success == 'tambah'): ?>
            <div class="alert success">Data mahasiswa berhasil ditambahkan!</div>
        <?php elseif ($success == 'edit'): ?>
            <div class="alert success">Data mahasiswa berhasil diupdate!</div>
        <?php elseif ($success == 'hapus'): ?>
            <div class="alert success">Data mahasiswa berhasil dihapus!</div>
        <?php endif; ?>

        <div class="actions">
            <a href="create.php" class="btn btn-primary">➕ Tambah Data</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jurusan</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0):
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)): 
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['nim']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                        <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">✏️ Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
                        </td>
                    </tr>
                <?php 
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
