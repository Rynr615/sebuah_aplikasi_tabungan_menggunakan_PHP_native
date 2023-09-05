<?php

date_default_timezone_set('Asia/Jakarta');


$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tabungan';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Menyimpan data ke database
function generateUniqueAccountNumber() {
    $timestamp = time();
    $random_number = mt_rand(100000, 999999);
    $account_number = $timestamp . $random_number;

    return $account_number;
}

function tambahData($nama, $nomor_telepon, $email, $alamat, $tanggal, $waktu, $saldo) {
    global $conn;

    $nomor_rekening = generateUniqueAccountNumber();

    $query = "INSERT INTO nasabah (nomor_rekening, nama, nomor_telepon, email, alamat, tanggal, waktu, saldo) VALUES ('$nomor_rekening', '$nama', '$nomor_telepon', '$email', '$alamat', '$tanggal', '$waktu', '$saldo')";
    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}



// edit data
function updateData($id, $nama, $nomor_telepon, $email, $alamat, $tanggal, $waktu) {
    global $conn;

    // Mendapatkan waktu saat ini
    $waktu = date('Y-m-d H:i:s');

    // Mengonversi format tanggal dari "YYYY-MM-DD" ke "YYYY-MM-DD"
    $tanggalFormatted = date('Y-m-d', strtotime($tanggal));

    $query = "UPDATE nasabah SET nama = '$nama', nomor_telepon = '$nomor_telepon', email = '$email', alamat = '$alamat', tanggal = '$tanggalFormatted', waktu = '$waktu' WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk melakukan tarik tunai (withdraw)
function tarikSaldo($id, $jumlah) {
    global $conn;

    // Mendapatkan saldo nasabah sebelum tarik tunai
    $saldoSebelum = getSaldo($id);

    // Memastikan saldo cukup untuk tarik tunai
    if ($saldoSebelum >= $jumlah) {
        // Mengurangi saldo sesuai jumlah yang ditarik
        $saldoSesudah = $saldoSebelum - $jumlah;

        // Mendapatkan waktu saat ini
        $waktu = date('Y-m-d H:i:s');

        // Update saldo dan waktu pada database
        $query = "UPDATE nasabah SET saldo = '$saldoSesudah', waktu = '$waktu' WHERE id = $id";
        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Fungsi untuk mendapatkan saldo nasabah berdasarkan ID
function getSaldo($id) {
    global $conn;

    $query = "SELECT saldo FROM nasabah WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $data = $result->fetch_assoc();
        $saldo = $data['saldo'];
        return $saldo;
    } else {
        return false;
    }
}


// Fungsi untuk melakukan deposit
function tambahSaldo($id, $jumlah) {
    global $conn;

    // Mendapatkan saldo nasabah sebelum deposit
    $saldoSebelum = getSaldo($id);

    // Menambahkan saldo sesuai jumlah deposit
    $saldoSesudah = $saldoSebelum + $jumlah;

    // Mendapatkan waktu saat ini
    $waktu = date('Y-m-d H:i:s');

    // Update saldo dan waktu pada database
    $query = "UPDATE nasabah SET saldo = '$saldoSesudah', waktu = '$waktu' WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function riwayatTransaksi($id) {

    global $conn;

    $query = "SELECT * FROM nasabah  WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // Mengembalikan data sebagai array asosiatif
        return $result->fetch_assoc();
    } else {
        return false; // Data tidak ditemukan
    }
}

function transferSaldo($nomor_rekening_pengirim, $nomor_rekening_penerima, $jumlah_transfer) {
    global $conn;

    // mengecek nomor rekening
    if ($nomor_rekening_pengirim === $nomor_rekening_penerima) {
        echo "<script>alert('Tidak dapat transfer uang ke nomor rekening yang sama.')</script>";
        return false;
    }

    // Mendapatkan data saldo pengirim sebelum transfer
    $query_saldo_pengirim = "SELECT saldo FROM nasabah WHERE nomor_rekening = '$nomor_rekening_pengirim'";
    $result_saldo_pengirim = $conn->query($query_saldo_pengirim);

    if ($result_saldo_pengirim->num_rows == 1) {
        $data_saldo_pengirim = $result_saldo_pengirim->fetch_assoc();
        $saldo_pengirim_sebelum = $data_saldo_pengirim['saldo'];
    } else {
        return false; // Nomor rekening pengirim tidak valid
    }

    // Mendapatkan data saldo penerima sebelum transfer
    $query_saldo_penerima = "SELECT saldo FROM nasabah WHERE nomor_rekening = '$nomor_rekening_penerima'";
    $result_saldo_penerima = $conn->query($query_saldo_penerima);

    if ($result_saldo_penerima->num_rows == 1) {
        $data_saldo_penerima = $result_saldo_penerima->fetch_assoc();
        $saldo_penerima_sebelum = $data_saldo_penerima['saldo'];
    } else {
        return false; // Nomor rekening penerima tidak valid
    }

    // Memastikan saldo pengirim cukup untuk transfer
    if ($saldo_pengirim_sebelum >= $jumlah_transfer) {
        // Mengurangi saldo pengirim sesuai jumlah transfer
        $saldo_pengirim_setelah = $saldo_pengirim_sebelum - $jumlah_transfer;

        // Menambah saldo penerima sesuai jumlah transfer
        $saldo_penerima_setelah = $saldo_penerima_sebelum + $jumlah_transfer;

        // Mendapatkan waktu saat ini
        $waktu = date('Y-m-d H:i:s');

        // Update saldo, tanggal, dan waktu pengirim pada database
        $query_update_pengirim = "UPDATE nasabah SET saldo = '$saldo_pengirim_setelah', tanggal = '$waktu', waktu = '$waktu' WHERE nomor_rekening = '$nomor_rekening_pengirim'";
        $result_update_pengirim = $conn->query($query_update_pengirim);

        // Update saldo, tanggal, dan waktu penerima pada database
        $query_update_penerima = "UPDATE nasabah SET saldo = '$saldo_penerima_setelah', tanggal = '$waktu', waktu = '$waktu' WHERE nomor_rekening = '$nomor_rekening_penerima'";
        $result_update_penerima = $conn->query($query_update_penerima);

        if ($result_update_pengirim && $result_update_penerima) {
            return true; // Transfer berhasil
        } else {
            return false; // Gagal memperbarui data
        }
    } else {
        return false; // Saldo pengirim tidak mencukupi
    }
}

// Fungsi untuk memeriksa saldo pengirim berdasarkan nomor rekening
function cekSaldoPengirim($nomor_rekening_pengirim) {
    global $conn;

    // Mendapatkan data saldo pengirim dari basis data berdasarkan nomor rekening
    $query_saldo_pengirim = "SELECT saldo FROM nasabah WHERE nomor_rekening = '$nomor_rekening_pengirim'";
    $result_saldo_pengirim = $conn->query($query_saldo_pengirim);

    if ($result_saldo_pengirim !== false && $result_saldo_pengirim->num_rows == 1) {
        $data_saldo_pengirim = $result_saldo_pengirim->fetch_assoc();
        $saldo_pengirim = $data_saldo_pengirim['saldo'];
        return $saldo_pengirim;
    } else {
        return false; // Nomor rekening pengirim tidak valid atau terjadi kesalahan
    }
}

// Fungsi untuk memeriksa saldo penerima berdasarkan nomor rekening
function cekSaldoPenerima($nomor_rekening_penerima) {
    global $conn;

    // Mendapatkan data saldo penerima dari basis data berdasarkan nomor rekening
    $query_saldo_penerima = "SELECT saldo FROM nasabah WHERE nomor_rekening = '$nomor_rekening_penerima'";
    $result_saldo_penerima = $conn->query($query_saldo_penerima);

    if ($result_saldo_penerima !== false && $result_saldo_penerima->num_rows == 1) {
        $data_saldo_penerima = $result_saldo_penerima->fetch_assoc();
        $saldo_penerima = $data_saldo_penerima['saldo'];
        return $saldo_penerima;
    } else {
        return false; // Nomor rekening penerima tidak valid atau terjadi kesalahan
    }
}

function convertToDollar($amount) {
    // Rate konversi rupiah ke dollar
    $rate = 0.000071; // Contoh rate, sesuaikan dengan rate yang sesuai

    // Konversi saldo rupiah ke dollar
    $saldo_dollar = $amount * $rate;

    return $saldo_dollar;
}





?>