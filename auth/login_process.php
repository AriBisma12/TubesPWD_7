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

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama']    = $user['nama'];
    $_SESSION['role']    = $user['role'];

    if ($user['role'] === "admin") {
        header("Location: ../admin/index.php");
    } else {
        header("Location: ../mahasiswa/index.php");
    }
    exit;

} else {
    $_SESSION['error'] = "Email atau password salah.";
    header("Location: ../login.php");
    exit;
}
