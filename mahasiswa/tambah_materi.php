<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$error   = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
$old     = $_SESSION['old'] ?? ['judul' => '', 'deskripsi' => '', 'link_video' => ''];

unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah Materi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <nav class="navbar">
        <div class="nav-brand">E-LEARNING</div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="materi.php">Materi</a></li>
            <li><a href="tugas.php">Tugas</a></li>
            <li><a href="../profil.php">Profil</a></li>
            <li><a href="#" onclick="confirmLogout('../auth/logout.php')">Logout</a></li>
        </ul>
    </nav>

    <section class="hero">
        <h1>Tambah Materi</h1>
        <p>Lengkapi form berikut untuk menambahkan materi baru.</p>
    </section>

    <div class="form-container">

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <h2>Form Materi</h2>

        <form action="../proses/tambah_materi_proses.php" method="POST" enctype="multipart/form-data">

            <label>Judul Materi</label>
            <input type="text" name="judul"
                   value="<?= htmlspecialchars($old['judul']) ?>" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required><?= htmlspecialchars($old['deskripsi']) ?></textarea>

            <label>Link Video (opsional)</label>
            <input type="text" name="link_video"
                   value="<?= htmlspecialchars($old['link_video']) ?>">

            <label>Gambar (opsional)</label>
            <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.gif">

            <label>File Tugas (opsional)</label>
            <input type="file" name="file_tugas" accept=".pdf,.doc,.docx,.zip,.ppt,.pptx">

            <br><br>
            <button class="btn-primary" href="../mahasiswa/materi.php" type="submit">Simpan Materi</button>
            <a class="btn-primary" href="../mahasiswa/materi.php" style="margin-left: 8px;">Kembali</a>
        </form>
    </div>

    <footer class="footer">Developed for UAS PWD 2025/2026</footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>
