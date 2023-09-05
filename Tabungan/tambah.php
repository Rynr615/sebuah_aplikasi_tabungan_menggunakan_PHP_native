<?php
// tambah.php

// Mulai session (jika belum dimulai)
session_start();

// Mengimpor functions.php
require_once 'functions.php';

// Memeriksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Mendapatkan nilai dari inputan form
    $nama = $_POST['nama'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $saldo = $_POST['saldo'];

    // Memanggil fungsi untuk menyimpan data ke database
    $result = tambahData($nama, $nomor_telepon, $email, $alamat, $tanggal, $waktu, $saldo);

    // Setelah berhasil menambahkan data
    if ($result) {
        // Redirect ke halaman index.php dengan parameter success=true
        echo "<script>alert('Data berhasil ditambahkan.'); window.location.href = 'index.php';</script>";
        exit();
        // Pastikan kode di bawah tidak dijalankan setelah melakukan redirect
    } else {
        echo '<script>alert("Gagal menambahkan data.");</script>';
    }
};




?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
    <!-- logo -->
    <link rel="icon" href="./img/Element_Cryo.svg" type="logo">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- css -->
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 800px;
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center mt-2">Tambah Data</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="" autocomplete="off">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="col">
                            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                        </div>
                        <div class="col">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="col">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="col">
                            <label for="waktu" class="form-label">Waktu</label>
                            <input type="time" class="form-control" id="waktu" name="waktu" required>
                        </div>
                        <div class="col">
                            <label for="saldo" class="form-label">Total Uang</label>
                            <input type="text" class="form-control" id="saldo" name="saldo" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 col-3 mx-auto mt-3">
                        <input class="btn btn-primary" type="submit" name="submit" value="Tambah Data">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function validateEmail() {
            const emailInput = document.getElementById('email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(emailInput)) {
                alert('Email yang Anda masukkan tidak valid.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
