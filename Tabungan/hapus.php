

<?php
// Mengimpor koneksi ke database
require_once 'functions.php';

// Periksa apakah parameter id telah dikirim
if (isset($_GET['id'])) {
    // Ambil nilai id dari URL
    $id = $_GET['id'];

    // Buat query untuk menghapus data berdasarkan id
    $query = "DELETE FROM nasabah WHERE id = $id";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika berhasil menghapus data, kembalikan ke halaman index.php dengan parameter success=delete
        header("Location: index.php?success=delete");
        exit();
    } else {
        // Jika gagal menghapus data, kembalikan ke halaman index.php dengan parameter error=delete
        header("Location: index.php?error=delete");
        exit();
    }
} else {
    // Jika parameter id tidak tersedia, kembalikan ke halaman index.php
    header("Location: index.php");
    exit();
}
?>
