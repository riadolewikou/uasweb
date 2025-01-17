<?php
include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan!'); window.location='index.php';</script>";
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id = $id");
$data = $result->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Data</h2>
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="umur" class="form-label">Umur</label>
                    <input type="number" name="umur" id="umur" class="form-control" value="<?= $data['umur'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                        <option value="Laki-laki" <?= $data['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" required><?= $data['alamat'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="hobi" class="form-label">Hobi</label>
                    <input type="text" name="hobi" id="hobi" class="form-control" value="<?= $data['hobi'] ?>" required>
                </div>
                <div class="text-end">
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </div>
            </form>

            <?php
            if (isset($_POST['update'])) {
                $nama = $_POST['nama'];
                $umur = $_POST['umur'];
                $jenis_kelamin = $_POST['jenis_kelamin'];
                $alamat = $_POST['alamat'];
                $hobi = $_POST['hobi'];

                $conn->query("UPDATE users SET nama='$nama', umur='$umur', jenis_kelamin='$jenis_kelamin', alamat='$alamat', hobi='$hobi' WHERE id=$id");
                echo "<script>alert('Data berhasil diperbarui'); window.location='index.php';</script>";
            }
            ?>
        </div>
    </div>
</div>
<script src="style/bootstrap.bundle.min.js"></script>
</body>
</html>
