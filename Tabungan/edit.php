<?php
// Menghubungkan dengan database dan menginisialisasi sesi

session_start();

require_once 'functions.php';

// Mendapatkan ID data yang akan diubah dari URL
$id = $_GET['id'];

// Memeriksa apakah form edit telah disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu']; // Menambahkan variabel waktu

    // Update data pada database
    if (updateData($id, $nama, $nomor_telepon, $email, $alamat, $tanggal, $waktu)) { // Menambahkan parameter waktu pada function updateData
        echo "<script>alert('Data berhasil diubah'); window.location.href = 'index.php';</script>"; // Menampilkan notifikasi dan mengarahkan kembali ke halaman index
        exit();
    } else {
        echo "<script>alert('Gagal mengubah data');</script>";
    }
}

// Mendapatkan data yang akan diubah dari database
$query = "SELECT * FROM nasabah WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $data = $result->fetch_assoc();
    $nama = $data['nama'];
    $nomor_telepon = $data['nomor_telepon'];
    $email = $data['email'];
    $alamat = $data['alamat'];
    $tanggal = $data['tanggal'];
    $waktu = $data['waktu']; // Mengambil nilai waktu dari database
} else {
    echo "<script>alert('Data tidak ditemukan'); window.location.href = 'index.php';</script>"; // Jika data tidak ditemukan, kembali ke halaman index
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <!-- logo -->
    <link rel="icon" href="./img/Element_Cryo.svg" type="logo">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
        <img src="./img/Element_Cryo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
        Tabungan
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                    <a href="tambah.php" class="me-2 btn btn-success">Tambah Data</a>
                    </li>
                    <li class="nav-item">
                    <a href="logout.php" class="me-2 btn btn-danger">LogOut</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Form edit data -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Edit Data</h5>
                <form method="POST" action="" autocomplete="off">
                    <div class="mb-3">
                        <input type="text" name="nama" value="<?php echo $nama; ?>" class="form-control" placeholder="Nama" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="nomor_telepon" value="<?php echo $nomor_telepon; ?>" class="form-control" placeholder="Nomor Telepon" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="alamat" value="<?php echo $alamat; ?>" class="form-control" placeholder="Alamat" required>
                    </div>
                    <div class="mb-3">
                        <input type="date" name="tanggal" value="<?php echo $tanggal; ?>" class="form-control" placeholder="Tanggal" required>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit" name="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
