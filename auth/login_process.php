<?php
session_start();
require "../config/db.php";

$email    = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();

// cek user
if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama']    = $user['nama'];

    // RULE KHUSUS: email dengan @admin.com selalu jadi admin
    if (strpos($email, '@admin.com') !== false) {
        $_SESSION['role'] = "admin";
        header("Location: ../admin/index.php");
    } else {
        $_SESSION['role'] = "mahasiswa";
        header("Location: ../mahasiswa/index.php");
    }

    exit;
} else {
    $_SESSION['error'] = "Email atau password salah.";
    header("Location: ../login.php");
    exit;
}
