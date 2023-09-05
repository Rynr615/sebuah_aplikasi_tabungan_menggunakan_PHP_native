<?php
include 'functions.php';

// Memeriksa apakah form transfer telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_rekening_pengirim = $_POST['nomor_rekening_pengirim'];
    $nomor_rekening_penerima = $_POST['nomor_rekening_penerima'];
    $jumlah_transfer = $_POST['jumlah_transfer'];

    // Memeriksa apakah tombol "Cek Saldo Pengirim" ditekan
    if (isset($_POST['cek_saldo_pengirim'])) {
        // Memeriksa saldo pengirim
        $saldo_pengirim = cekSaldoPengirim($nomor_rekening_pengirim);
    }

    // Memeriksa apakah tombol "Cek Saldo Penerima" ditekan
    if (isset($_POST['cek_saldo_penerima'])) {
        // Memeriksa saldo penerima
        $saldo_penerima = cekSaldoPenerima($nomor_rekening_penerima);
    }

    // Memeriksa apakah tombol "Transfer" ditekan
    if (isset($_POST['transfer'])) {
        // Memanggil fungsi transferSaldo untuk melakukan transfer
        $transfer_berhasil = transferSaldo($nomor_rekening_pengirim, $nomor_rekening_penerima, $jumlah_transfer);

        if ($transfer_berhasil) {

            echo "<script>alert('Transfer berhasil');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transfer Uang</title>
    <!-- logo -->
    <link rel="icon" href="./img/Element_Cryo.svg" type="logo">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- link CSS -->
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
                <div class="d-flex">
                    <a href="transfer.php" class="btn btn-secondary"><i class="fa-solid fa-money-bill-transfer"></i> Transfer</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="card" style="width: 24rem;margin: auto;">
            <div class="card-body">
                <h5 class="card-title">Transfer Uang</h5>
                <form method="POST" action="" autocomplete="off">
                    <div class="mb-3">
                        <label for="nomor_rekening_pengirim" class="form-label">Nomor Rekening Pengirim:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nomor_rekening_pengirim" name="nomor_rekening_pengirim" value="<?php echo isset($_POST['nomor_rekening_pengirim']) ? $_POST['nomor_rekening_pengirim'] : ''; ?>">
                            <button style="color: white;" class="btn btn-info" type="submit" name="cek_saldo_pengirim">Cek Saldo</button>
                        </div>
                        <?php if (isset($_POST['cek_saldo_pengirim']) && isset($saldo_pengirim)): ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Saldo : Rp. <?php echo $saldo_pengirim; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_rekening_penerima" class="form-label">Nomor Rekening Penerima:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nomor_rekening_penerima" name="nomor_rekening_penerima" value="<?php echo isset($_POST['nomor_rekening_penerima']) ? $_POST['nomor_rekening_penerima'] : ''; ?>">
                            <button style="color: white;" class="btn btn-info" type="submit" name="cek_saldo_penerima">Cek Saldo</button>
                        </div>
                        <?php if (isset($_POST['cek_saldo_penerima']) && isset($saldo_penerima)): ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Saldo : Rp. <?php echo $saldo_penerima; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_transfer" class="form-label">Jumlah Transfer:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="jumlah_transfer" name="jumlah_transfer">
                        </div>
                        <div class="input-group mt-3">
                            <button style="margin: 0 auto;" class="btn btn-primary" type="submit" name="transfer">Transfer</button>
                        </div>
                        <?php if (isset($transfer_berhasil) && $transfer_berhasil): ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Transfer berhasil
                            </div>
                            <script>window.location.href = 'index.php';</script>
                        <?php elseif (isset($transfer_berhasil) && !$transfer_berhasil): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Transfer gagal
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
