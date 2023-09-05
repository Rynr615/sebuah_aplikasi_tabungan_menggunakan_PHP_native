<?php
// Membuat koneksi ke database
include "functions.php";

// Memulai sesi
session_start();

// Memeriksa apakah form login telah disubmit
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Melakukan query untuk mencocokkan username dan password
    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // Login berhasil
        $_SESSION['username'] = $username; // Menyimpan username dalam sesi

        // Set cookie dengan nama 'username' dan nilai username
        setcookie('username', $username, time() + (86400 * 30), '/'); // Cookie berlaku selama 30 hari

        echo "<script>alert('Login berhasil!'); window.location.href = 'index.php';</script>"; // Menampilkan notifikasi dan mengarahkan ke halaman index
        exit();
    } else {
        // Login gagal
        echo "<script>alert('Login Gagal'); window.location.href = 'login.php'</script>";
    }
}

// Memeriksa apakah pengguna sudah login, jika ya, langsung arahkan ke halaman index
if (isset($_SESSION['username'])) {
    echo "<script> window.location.href = 'index.php';</script>";
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>LogIn</title>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleButton = document.getElementById("toggleButton");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            } else {
                passwordInput.type = "password";
                toggleButton.innerHTML = '<i class="fa-solid fa-eye"></i>';
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

</head>
<body>
    <!-- <div class="container">
        <form method="POST" action="login.php" autocomplete="off">
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Username</span>
                        <input name="username" id="username" required type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Password</span>
                        <input style="width: 400px;" name="password" id="password" required type="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1">
                        <button style="border-radius: 0px 10px 8px 0px;" type="button" class="form-control input-group-text" id="toggleButton" onclick="togglePasswordVisibility()"><i class="fa-solid fa-eye"></i></button><br>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 col-3 mx-auto">
                <input class="btn btn-primary" type="submit" name="submit" value="Login">
            </div>
        </form>
    </div> -->
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-bold fs-5">Login</h5>
                        <div class="text-center mb-5">
                            <img width="180px" src="./img/Element_Cryo.svg" alt="Gambar Login" class="img-fluid">
                        </div>
                        <form method="post" action="login.php" autocomplete="off">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" aria-label="Username" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-label="Password" required>
                                    <button class="input-group-text" type="button" id="toggleButton" onclick="togglePasswordVisibility()">
                                        <i class="fas fa-eye" id="show_eye"></i>
                                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-grid">
                                <input class="btn btn-primary" type="submit" name="submit" value="Login">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

