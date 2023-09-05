<?php
// koneksi
include "functions.php";

// Memulai sesi
session_start();

// Memeriksa apakah pengguna sudah login, jika tidak, arahkan kembali ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mengambil data dari tabel
$query = "SELECT * FROM nasabah";
$result = $conn->query($query);

// Periksa apakah parameter success bernilai add
if (isset($_GET['success']) && $_GET['success'] == "add") {
    echo '<script>alert("Data berhasil ditambahkan.");</script>';
} elseif (isset($_GET['error']) && $_GET['error'] == "add") {
    echo '<script>alert("Gagal menambahkan data.");</script>';
}

// Periksa apakah parameter success=delete ada dalam URL
if (isset($_GET['success']) && $_GET['success'] == 'delete') {
    echo '<script>alert("Data Berhasil Dihapus")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- logo -->
    <link rel="icon" href="./img/Element_Cryo.svg" type="logo">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
    <style>
        .action-buttons a {
            margin: 5px;
        }
        .link {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        }
        
    </style>
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
                <div class="d-flex">
                    <a href="transfer.php" class="btn btn-secondary"><i class="fa-solid fa-money-bill-transfer"></i> Transfer</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-3">
            <div class="col">
                
            </div>
        </div>

        <table class="table table-striped table-bordered table-paginate" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><i class="fa-solid fa-money-check"></i> Rekening</th>
                    <th><i class="fa-solid fa-signature"></i> Nama</th>
                    <th><i class="fa-solid fa-phone"></i> Telepon</th>
                    <th><i class="fa-solid fa-envelope"></i> Email</th>
                    <th><i class="fa-solid fa-location-dot"></i> Alamat</th>
                    <th><i class="fa-solid fa-calendar-days"></i> Tanggal</th>
                    <th><i class="fa-solid fa-clock"></i> Jam</th>
                    <th><i class="fa-solid fa-money-bill"></i> Saldo</th>
                    <th><i class="fa-solid fa-terminal"></i> Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $row['nomor_rekening'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['nomor_telepon'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['alamat'] ?></td>
                            <td><?= date('d/M/Y', strtotime($row['tanggal'])) ?></td>
                            <td><?= $row['waktu'] ?></td>
                            <td>Rp.<?= $row['saldo'] ?></td>
                            <td class="link action-buttons">
                                <a href="riwayat.php?id=<?= $row['id'] ?>" class="btn btn-info" style="color: white;"><i class="fa-solid fa-book"></i></a>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="deposit.php?id=<?= $row['id'] ?>" class="btn btn-success"><i class="fa-solid fa-plus"></i></a>
                                <a href="withdraw.php?id=<?= $row['id'] ?>" class="btn btn-warning" style="color: white;"><i class="fa-sharp fa-solid fa-hand-holding-dollar"></i></a>
                                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('.table-paginate').DataTable();
        });
    </script>
</body>

</html>

