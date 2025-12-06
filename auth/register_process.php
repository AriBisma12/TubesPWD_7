<?php
// auth/register_process.php
session_start();
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data
    $nama         = trim($_POST['nama'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '';
    $confirm      = $_POST['confirm_password'] ?? '';

    // Validasi data wajib
    if ($nama === '' || $email === '' || $password === '' || $confirm === '') {
        $_SESSION['error'] = "Nama, email, dan password wajib diisi.";
        header("Location: ../register.php");
        exit;
    }

    if ($password !== $confirm) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak sama.";
        header("Location: ../register.php");
        exit;
    }

    // Cek email sudah dipakai
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email sudah digunakan.";
        $stmt->close();
        header("Location: ../register.php");
        exit;
    }
    $stmt->close();

    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert data user baru (tanpa npm/fakultas/prodi/foto karena tidak dipakai)
    $stmt = $conn->prepare("
        INSERT INTO users (nama, email, password, role)
        VALUES (?, ?, ?, 'user')
    ");

    $stmt->bind_param("sss", $nama, $email, $hash);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: ../index.php");
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . $conn->error;
        header("Location: ../register.php");
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../register.php");
}
?>
