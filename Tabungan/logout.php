<?php
// logout.php

// Memulai sesi
session_start();

// Memeriksa apakah pengguna sudah login, jika tidak, arahkan kembali ke halaman login
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = $username; 
    // Menyimpan username dalam sesi
    echo "<script>alert('Apakah anda yakin untuk Logout!'); window.location.href = 'index.php';</script>"; // Menampilkan notifikasi dan mengarahkan ke halaman index
    exit();
}

// Memeriksa apakah pengguna mengkonfirmasi logout
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // Menghapus semua data sesi
    session_unset();

    // Menghancurkan sesi
    session_destroy();

    // Arahkan pengguna kembali ke halaman login
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Logout</title>
    <script>
        function confirmLogout() {
            var logout = confirm("Sampai Jumpa");
            if (logout) {
                window.location.href = "logout.php?logout=true";
            }
        }
    </script>
    <!-- logo -->
    <link rel="icon" href="./img/Element_Cryo.svg" type="logo">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- css -->
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .container {
            max-width: 400px;
            margin-top: 100px;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo img {
            width: 120px;
        }
        
        .btn-logout {
            width: 100%;
            padding: 12px 0;
            font-size: 16px;
        }

        .btn-back {
            width: 100%;
            padding: 12px 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">       
        <div class="card">
            <div class="mt-3 logo">
                <img src="./img/Element_Cryo.svg" alt="Logo">
            </div>
            <div class="card-body">
                <h3 class="card-title text-center">Konfirmasi Logout</h3>
                <p class="card-text text-center">Apakah Anda yakin ingin logout?</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-danger btn-logout" onclick="confirmLogout()"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                    <a class="btn btn-back btn-primary" href="index.php"><i class="fa-solid fa-backward"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
