<?php
session_start();
require "../config/db.php";

$email    = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user  = mysqli_fetch_assoc($query);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama']    = $user['nama'];
    $_SESSION['role']    = $user['role'];

    if ($user['role'] == "admin") {
        header("Location: ../admin/index.php");
    } else {
        header("Location: ../mahasiswa/index.php");
    }

} else {
    echo "<script>alert('Login gagal! Periksa email & password.');window.location='../login.php'</script>";
}

?>
