<?php
session_start();
require "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id  = $_SESSION['user_id'];
$u   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));

if (isset($_POST['save'])) {
    $nama = $_POST['nama'];
    mysqli_query($conn, "UPDATE users SET nama='$nama' WHERE id=$id");
    $_SESSION['nama'] = $nama;
    echo "<div class='alert alert-success'>Profil berhasil diperbarui!</div>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profil Saya</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="form-container">
        <h2>Profil Akun</h2>

        <form method="POST">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= $u['nama']; ?>" required>

            <button class="btn-primary" name="save">Update</button>
        </form>

        <br>
        <a href="index.php" class="btn-primary">Kembali</a>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>
