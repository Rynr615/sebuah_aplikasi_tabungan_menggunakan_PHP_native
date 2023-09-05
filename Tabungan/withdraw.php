<?php
// Menghubungkan dengan database dan menginisialisasi sesi

session_start();

require_once 'functions.php';

// Mendapatkan ID data nasabah dari URL
$id = $_GET['id'];

// Memeriksa apakah form deposit telah disubmit
// if (isset($_POST['deposit'])) {
//     // Mengambil data dari form
//     $jumlah = $_POST['jumlah'];

//     // Menambahkan saldo pada data nasabah
//     if (tambahSaldo($id, $jumlah)) {
//         echo "<script>alert('Saldo berhasil ditambahkan'); window.location.href = 'index.php';</script>"; // Menampilkan notifikasi dan mengarahkan kembali ke halaman index
//         exit();
//     } else {
//         echo "<script>alert('Gagal menambahkan saldo');</script>";
//     }
// }

// Memeriksa apakah form withdraw telah disubmit
if (isset($_POST['withdraw'])) {
    // Mengambil data dari form
    $jumlah = $_POST['jumlah'];

    // Menarik saldo dari data nasabah
    if (tarikSaldo($id, $jumlah)) {
        echo "<script>alert('Saldo berhasil ditarik'); window.location.href = 'index.php';</script>"; // Menampilkan notifikasi dan mengarahkan kembali ke halaman index
        exit();
    } else {
        echo "<script>alert('Gagal menarik saldo');</script>";
    }
}

// Mendapatkan data nasabah dari database
$query = "SELECT * FROM nasabah WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $data = $result->fetch_assoc();
    $nama = $data['nama'];
    $saldo = $data['saldo'];
    $nomor_rekening = $data['nomor_rekening'];
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
    <title>Tarik Saldo</title>
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
    <!-- Form deposit -->
    <div class="container">
        <div class="card mx-auto" style="max-width: 28rem;">
            <div class="card-header">
                <h5><?= $nama; ?></h5>
            </div>
            <div class="card-body">
                <ul class="list-group mb-4">
                    <li class="list-group-item">Rekening: <?= $nomor_rekening ?></li>
                    <li class="list-group-item">Saldo: <?= $saldo ?></li>
                </ul>
                <form method="POST" action="" autocomplete="off">
                    <div class="input-group mb-3">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" aria-label="Jumlah" aria-describedby="basic-addon1">
                    </div>
                    <div class="d-grid gap-2">
                        <input class="btn btn-primary" type="submit" name="withdraw" value="Tarik Saldo">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form withdraw -->
    <!-- <form method="POST" action="" autocomplete="off">
        <label for="withdraw">Tarik Saldo:</label>
        <input type="number" name="jumlah" required>
        <input type="submit" name="withdraw" value="Withdraw">
    </form> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
