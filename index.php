<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>E-Learning</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-brand">E-LEARNING</div>
        <ul class="nav-links">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="#" onclick="confirmLogout('auth/logout.php')">Logout</a></li>
            <?php else : ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <h1>Selamat Datang di Sistem E-Learning</h1>
        <p>Belajar kapanpun & dimanapun menjadi lebih mudah.</p>

        <?php if (!isset($_SESSION['user_id'])) : ?>
            <a href="register.php" class="btn-primary">Mulai Belajar</a>
        <?php endif; ?>
    </section>

    <footer class="footer">Developed for UAS PWD 2025/2026</footer>

    <!-- Tambahkan JS -->
    <script src="assets/js/script.js"></script>
</body>

</html>