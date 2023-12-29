<?php
include_once("koneksi.php");

// Inisialisasi variabel pesan error
$pesan_error = '';

// Memeriksa jika ada pengiriman formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeat_password = $_POST["repeat_password"];

    // Memeriksa apakah password dan ulang password sesuai
    if ($password !== $repeat_password) {
        $pesan_error = "Password dan Ulang Password tidak sesuai.";
    } else {
        // Memeriksa apakah email sudah terdaftar dalam database
        $query = "SELECT id FROM user WHERE email = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $pesan_error = "Email sudah terdaftar. Gunakan email lain.";
        } else {
            // Jika semua validasi berhasil, masukkan data ke dalam database
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $query_insert = "INSERT INTO user (email, password) VALUES (?, ?)";
            $stmt_insert = $mysqli->prepare($query_insert);
            $stmt_insert->bind_param("ss", $email, $password_hash);

            if ($stmt_insert->execute()) {
                // Pendaftaran berhasil, alihkan ke halaman login atau halaman lainnya
                header("location: login.php"); // Ganti dengan halaman tujuan setelah pendaftaran berhasil
                exit();
            } else {
                $pesan_error = "Terjadi kesalahan saat mendaftarkan akun. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                                    <form method="post" action="register.php">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" name="email" class="form-control" />
                                                <label class="form-label" for="form3Example3c">Your Email</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="password" class="form-control" />
                                                <label class="form-label" for="form3Example4c">Password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="repeat_password" class="form-control" />
                                                <label class="form-label" for="form3Example4cd">Repeat your password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                        </div>
                                        <?php
                                        if (!empty($pesan_error)) {
                                            echo '<div class="alert alert-danger" role="alert">' . $pesan_error . '</div>';
                                        }
                                        ?>
                                    </form>
                                </div>
