<?php session_start(); ?>
<?php
require "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));
?>
<!DOCTYPE html>
<html>

<head>
    <title>E-Learning | Mahasiswa</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-brand">E-LEARNING</div>
        <ul class="nav-links">
            <li><a href="../profil.php">Profil</a></li>
            <li><a href="materi.php">Materi</a></li>
            <li><a href="tugas.php">Tugas</a></li>
            <li><a href="#" onclick="confirmLogout('../auth/logout.php')">Logout</a></li>
        </ul>
    </nav>

    <!-- Content Dashboard Mahasiswa -->
    <section class="hero">
        <h1>Halo, <?= $user['nama'] ?> 👋</h1>
        <p>Selamat Datang di Halaman Mahasiswa</p>

        <div class="dashboard-menu">
            <a class="btn-primary" href="materi.php">📘 Lihat Materi</a>
            <a class="btn-primary" href="tugas.php">📝 Lihat Tugas</a>
        </div>
    </section>

    <footer class="footer">Developed for UAS PWD 2025/2026</footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>