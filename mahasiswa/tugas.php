<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tugas Mahasiswa</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <nav class="navbar">
        <div class="nav-brand">E-LEARNING</div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="materi.php">Materi</a></li>
            <li><a href="../profil.php">Profil</a></li>
            <li><a href="#" onclick="confirmLogout('../auth/logout.php')">Logout</a></li>
        </ul>
    </nav>

    <section class="hero">
        <h1>📝 Daftar Tugas</h1>
        <p>Silakan pilih tugas untuk dikumpulkan</p>

        <div class="dashboard-menu">
            <a class="btn-primary" href="upload_tugas.php?id=1">Tugas 1 - Pengenalan Web</a>
            <a class="btn-primary" href="upload_tugas.php?id=2">Tugas 2 - HTML & CSS</a>
        </div>

        <br>
        <a href="index.php" class="btn-primary">Kembali</a>
    </section>

    <footer class="footer">Developed for UAS PWD 2025/2026</footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>