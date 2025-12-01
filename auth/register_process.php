<?php
// auth/register_process.php
session_start();
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data
    $nama         = trim($_POST['nama'] ?? '');
    $npm          = trim($_POST['npm'] ?? '');
    $fakultas     = trim($_POST['fakultas'] ?? '');
    $programstudi = trim($_POST['programstudi'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '';
    $confirm      = $_POST['confirm_password'] ?? '';

    // Validasi data wajib
    if (
        $nama === '' || $npm === '' || $fakultas === '' || $programstudi === '' ||
        $email === '' || $password === '' || $confirm === ''
    ) {
        $_SESSION['error'] = "Semua field wajib diisi.";
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

    // Handle upload foto (opsional)
    $fotoName = NULL;

    if (!empty($_FILES['foto']['name'])) {

        $tmp    = $_FILES['foto']['tmp_name'];
        $file   = time() . "_" . basename($_FILES['foto']['name']);
        $target = "../uploads/" . $file;

        if (!move_uploaded_file($tmp, $target)) {
            $_SESSION['error'] = "Gagal mengupload foto.";
            header("Location: ../register.php");
            exit;
        }

        $fotoName = $file;
    }

    // Insert data user baru
    $stmt = $conn->prepare("
        INSERT INTO users (nama, npm, fakultas, programstudi, email, password, role, foto)
        VALUES (?, ?, ?, ?, ?, ?, 'user', ?)
    ");

    $stmt->bind_param("sssssss", $nama, $npm, $fakultas, $programstudi, $email, $hash, $fotoName);

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
