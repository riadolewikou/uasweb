<?php
// Mulai output buffering untuk menghindari error "headers already sent"
ob_start();

// Koneksi database
$conn = new mysqli('localhost', 'root', '', 'db_crud');

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tambah data
if (isset($_POST['add'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $umur = (int)$_POST['umur'];
    $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $hobi = $conn->real_escape_string($_POST['hobi']);

    $sql = "INSERT INTO person (nama, umur, jenis_kelamin, alamat, hobi) VALUES ('$nama', '$umur', '$jenis_kelamin', '$alamat', '$hobi')";
    if ($conn->query($sql) === TRUE) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Edit data
if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama = $conn->real_escape_string($_POST['nama']);
    $umur = (int)$_POST['umur'];
    $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $hobi = $conn->real_escape_string($_POST['hobi']);

    $sql = "UPDATE person SET nama='$nama', umur='$umur', jenis_kelamin='$jenis_kelamin', alamat='$alamat', hobi='$hobi' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Hapus data
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM person WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center">CRUD Bootstrap 5 dan DataTables</h2>

    <!-- Tombol Tambah Data -->
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>

    <!-- Tabel Data -->
    <table id="personTable" class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Umur</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Hobi</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Ambil data dari database
        $sql = "SELECT * FROM person";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['umur']}</td>
                    <td>{$row['jenis_kelamin']}</td>
                    <td>{$row['alamat']}</td>
                    <td>{$row['hobi']}</td>
                    <td>
                        <button class='btn btn-warning btn-sm editBtn' 
                            data-id='{$row['id']}' 
                            data-nama='{$row['nama']}' 
                            data-umur='{$row['umur']}' 
                            data-jenis_kelamin='{$row['jenis_kelamin']}' 
                            data-alamat='{$row['alamat']}' 
                            data-hobi='{$row['hobi']}'>Edit</button>
                        <a href='?delete={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">Hapus</a>
                    </td>
                </tr>";
            }
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="umur" class="form-label">Umur</label>
                        <input type="number" class="form-control" name="umur" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" name="jenis_kelamin" required>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="hobi" class="form-label">Hobi</label>
                        <input type="text" class="form-control" name="hobi" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="edit_nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_umur" class="form-label">Umur</label>
                        <input type="number" class="form-control" name="umur" id="edit_umur" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" name="jenis_kelamin" id="edit_jenis_kelamin" required>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="edit_alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_hobi" class="form-label">Hobi</label>
                        <input type="text" class="form-control" name="hobi" id="edit_hobi" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="edit_id">
                    <button type="submit" name="edit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#personTable').DataTable({
            destroy: true
        });

        // Modal Edit
        $('.editBtn').on('click', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const umur = $(this).data('umur');
            const jenis_kelamin = $(this).data('jenis_kelamin');
            const alamat = $(this).data('alamat');
            const hobi = $(this).data('hobi');

            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_umur').val(umur);
            $('#edit_jenis_kelamin').val(jenis_kelamin);
            $('#edit_alamat').val(alamat);
            $('#edit_hobi').val(hobi);

            $('#editModal').modal('show');
        });
    });
</script>
</body>
</html>
