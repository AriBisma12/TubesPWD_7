<?php
// auth/register_process.php
session_start();
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm) {
        $_SESSION['error'] = "Password dan konfirmasi tidak sama.";
        header("Location: ../register.php");
        exit;
    }

    if ($nama === '' || $email === '' || $password === '') {
        $_SESSION['error'] = "Semua field wajib diisi.";
        header("Location: ../register.php");
        exit;
    }

    // cek email sudah dipakai atau belum
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email sudah digunakan.";
        header("Location: ../register.php");
        exit;
    }
    $stmt->close();

    // hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $email, $hash);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil, silakan login.";
        header("Location: ../login.php");
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . $conn->error;
        header("Location: ../register.php");
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../register.php");
}
