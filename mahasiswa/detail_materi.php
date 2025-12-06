<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require "../config/db.php";

$id = $_GET['id'] ?? 0;

// Ambil data materi
$stmt = $conn->prepare("SELECT * FROM materi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$materi = $stmt->get_result()->fetch_assoc();

if (!$materi) {
    die("Materi tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($materi['judul']) ?> | Detail Materi</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="materi-page">

    <div class="layout">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">Belajar<span class="accent">HUB</span></div>

            <div class="menu-title">Menu</div>
            <ul class="menu-list">
                <li><a href="index.php">Home</a></li>
                <li class="active"><a href="materi.php">Materi</a></li>
                <li><a href="tugas.php">Tugas</a></li>
                <li><a href="../profil.php">Profil</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </aside>

        <div>
            <!-- MAIN DETAIL -->
            <main class="content">
                <div class="detail-wrapper">

                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                        Materi / <?= htmlspecialchars($materi['judul']) ?>
                    </div>

                    <!-- Thumbnail -->
                    <img
                        src="../uploads/<?= $materi['gambar'] ?: 'placeholder.png' ?>"
                        class="detail-thumb"
                        onerror="this.src='../assets/img/placeholder.png'">

                    <!-- Judul -->
                    <h1 class="detail-title"><?= htmlspecialchars($materi['judul']) ?></h1>

                    <!-- Deskripsi -->
                    <p class="detail-desc">
                        <?= nl2br(htmlspecialchars($materi['deskripsi'])) ?>
                    </p>

                    <!-- Isi Konten Materi -->
                    <h2 class="section-title">Isi Konten Materi</h2>

                    <div class="chapter-list">
                        <?php
                        // pecah deskripsi menjadi chapter berdasarkan newline
                        $chapters = explode("\n", $materi['link_video']);
                        foreach ($chapters as $ch) {
                            if (trim($ch) !== "") {
                                echo "<p>• " . htmlspecialchars($ch) . "</p>";
                            }
                        }
                        ?>
                    </div>

                    <!-- Tombol -->
                    <a href="#" class="btn-subscribe">Langganan</a>

                </div>
            </main>
        </div>


    </div>

</body>

</html>