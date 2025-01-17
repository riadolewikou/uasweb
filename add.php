<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Tambah Data</h2>
    <form action="" method="post">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="umur" class="form-label">Umur</label>
            <input type="number" name="umur" id="umur" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="hobi" class="form-label">Hobi</label>
            <input type="text" name="hobi" id="hobi" class="form-control" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $umur = $_POST['umur'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $hobi = $_POST['hobi'];

        $conn->query("INSERT INTO users (nama, umur, jenis_kelamin, alamat, hobi) VALUES ('$nama', '$umur', '$jenis_kelamin', '$alamat', '$hobi')");
        echo "<script>alert('Data berhasil ditambahkan'); window.location='index.php';</script>";
    }
    ?>
</div>
</body>
</html>
