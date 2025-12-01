<?php
session_start();
$error  = $_SESSION['error']  ?? '';
$success = $_SESSION['success'] ?? '';

unset($_SESSION['error'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Alert -->
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <div class="form-container">
        <h2>Registrasi Akun</h2>

        <form action="auth/register_process.php" method="POST" enctype="multipart/form-data">

            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>

            <label>NPM</label>
            <input type="text" name="npm" required>

            <label>Fakultas</label>
            <input type="text" name="fakultas" required>

            <label>Program Studi</label>
            <input type="text" name="programstudi" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Konfirmasi Password</label>
            <input type="password" name="confirm_password" required>

            <label>Foto Profil (opsional)</label>
            <input type="file" name="foto" accept="image/*">

            <button class="btn-primary" type="submit">Daftar</button>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>
