<?php
include_once("koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT id, email, password FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $db_email, $db_password);
    $stmt->fetch();

    if ($db_email) {
        if (password_verify($password, $db_password)) {
            session_start();
            $_SESSION["user_id"] = $user_id;
            header("location: index.php"); 
        } else {
            echo "Login gagal. Password tidak sesuai.";
        }
    } else {
        echo "Login gagal. Email tidak terdaftar.";
    }
}
?>
