<?php 
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));
$nama = $user['nama'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Mahasiswa | E-Learning</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="materi-page">

<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            Belajar<span class="accent">HUB</span>
        </div>

        <div class="menu-title">Menu</div>
        <ul class="menu-list">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="materi.php">Materi</a></li>
            <li><a href="tugas.php">Tugas</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="index.php" onclick="confirmLogout('../auth/logout.php')" >Logout</a></li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">

        <!-- Header -->
        <div class="content-header">
            <div>
                <div class="eyebrow">Selamat Datang di BELAJAR HUB</div>
                <h2 class="bold">Halo, <?= htmlspecialchars($nama) ?> 👋</h2>
            </div>
        </div>

        <!-- PILLS -->
        <div class="pill-nav">
            <a class="pill pill-active"><b>Beranda</b></a>
            <a class="pill pill-active" href="materi.php"><b>Materi</b></a>
            <a class="pill pill-active" href="tugas.php"><b>Tugas</b></a>
        </div>

        <!-- SECTIONS -->
        <div class="section-block">
            <div class="section-header">
                <h3 class="bold">Menu Cepat</h3>
            </div>

            <div class="card-row" style="margin-top: 10px;">

                <!-- Card Materi -->
                <div class="materi-card">
                    <div class="card-thumb" style="background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDH7385Cw73EQLcBXnQBed5A9QTWaHVXJ9Jw&s);"></div>
                    <div class="card-body">
                        <div class="card-title">Materi</div>
                        <a class="card-link" href="materi.php">Lihat Materi</a>
                        <a class="card-link" href="tambah_materi.php">Tambah Materi</a>
                    </div>
                </div>

                <!-- Card Tugas -->
                <div class="materi-card">
                    <div class="card-thumb" style="background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQxN_2aZmh8GuYSi5B-9s5HlDn3Umg0c_S5w&s);"></div>
                    <div class="card-body">
                        <div class="card-title">Tugas</div>
                        <a class="card-link" href="tugas.php">Lihat Tugas</a>
                    </div>
                </div>

            </div>
        </div>

    </main>

</div>

<footer class="footer">Developed for UAS PWD 2025/2026</footer>

<script src="../assets/js/script.js"></script>
</body>

</html>
