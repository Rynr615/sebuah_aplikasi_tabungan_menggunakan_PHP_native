<?php
require_once 'functions.php';

$id = $_GET['id'];

$data = riwayatTransaksi($id);

if (!$data) {
    echo "Data tidak ditemukan";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat</title>
    <!-- logo -->
    <link rel="icon" href="./img/Element_Cryo.svg" type="logo">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- link CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        .list-group-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .list-group-item span {
            margin-right: 5px;
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
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $data['nama']; ?></h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <span>Nomor Telepon</span>
                        <?php echo $data['nomor_telepon']; ?>
                    </li>
                    <li class="list-group-item">
                        <span>Email</span>
                        <?php echo $data['email']; ?>
                    </li>
                    <li class="list-group-item">
                        <span>Alamat</span>
                        <?php echo $data['alamat']; ?>
                    </li>
                    <li class="list-group-item">
                        <span>Tanggal</span>
                        <?php echo $data['tanggal']; ?>
                    </li>
                    <li class="list-group-item">
                        <span>Terakhir diubah</span>
                        <?php echo $data['waktu']; ?> WIB
                    </li>
                    <li class="list-group-item">
                        <span>Sisa Saldo</span>
                        Rp. <?php echo $data['saldo']; ?>
                    </li>
                </ul>
            </div>
        </div>
        <!-- btn export -->
        <div class="text-center mt-4">
            <button id="exportButton" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Export ke PNG</button>
        </div>   
    </div>

    

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        document.getElementById("exportButton").addEventListener("click", function() {
            html2canvas(document.querySelector(".card")).then(function(canvas) {
                var link = document.createElement("a");
                link.href = canvas.toDataURL("image/png");
                link.download = "riwayat.png";
                link.click();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>