<?php
session_start();
require "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));

// update profil
if (isset($_POST['save'])) {

    $nama         = $_POST['nama'];
    $npm          = $_POST['npm'];
    $fakultas     = $_POST['fakultas'];
    $programstudi = $_POST['programstudi'];

    // foto handling
    $fotoName = $user['foto']; // default foto lama

    if (!empty($_FILES['foto']['name'])) {
        $tmp    = $_FILES['foto']['tmp_name'];
        $file   = time() . "_" . $_FILES['foto']['name'];
        $folder = "uploads/" . $file;

        move_uploaded_file($tmp, $folder);

        $fotoName = $file;
    }

    mysqli_query(
        $conn,
        "UPDATE users SET 
            nama='$nama',
            npm='$npm',
            fakultas='$fakultas',
            programstudi='$programstudi',
            foto='$fotoName'
        WHERE id=$id"
    );

    $_SESSION['nama'] = $nama;

    echo "<div class='alert alert-success'>Profil berhasil diperbarui!</div>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profil</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="form-container">
        <h2>Profil Pengguna</h2>

        <div class="profile-box">

            <div>
                <strong><?= $user['nama']; ?></strong><br>
                <small><?= $user['email']; ?></small>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">

            <label>Nama</label>
            <input type="text" name="nama" value="<?= $user['nama']; ?>" required>

            <button class="btn-primary" name="save" type="submit">Update Profil</button>
        </form>

        <br>
        <a href="index.php" class="btn-primary">Kembali</a>
    </div>

    <script src="assets/js/script.js"></script>

</body>

</html>