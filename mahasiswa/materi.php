<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require "../config/db.php";

$nama = $_SESSION['nama'];

$query = $conn->prepare("SELECT * FROM materi WHERE pemilik = ?");
$query->bind_param("s", $nama);
$query->execute();
$result = $query->get_result();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Materi Saya</title>
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
                <li><a href="profil.php">Profil</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="content">

            <!-- HEADER -->
            <div class="content-header">
                <div>
                    <div class="eyebrow">Materi Saya</div>
                    <h2 class="bold">Halo, <?= htmlspecialchars($nama) ?> 👋</h2>
                </div>

                <div class="header-right">
                    <input type="text" class="search-input" placeholder="Cari materi...">
                    <div class="avatar-placeholder"></div>
                </div>
            </div>

            <!-- PILLS -->
            <div class="pill-nav">
                <a class="pill pill-active"><b>Materi Saya</b></a>
            </div>

            <!-- SECTION -->
            <div class="section-block">

                <div class="section-header">
                    <h3 class="bold">Materi yang Kamu Upload</h3>
                    <a class="btn-primary" href="tambah_materi.php" >Tambah Materi</a>
                </div>

                <!-- GRID MATERI -->
                <div class="card-row">

                    <?php if ($result->num_rows === 0): ?>
                        <p class="empty-text">Belum ada materi yang kamu upload.</p>

                    <?php else: ?>
                        <?php while ($row = $result->fetch_assoc()): ?>

                            <div class="materi-card">

                                <!-- Thumbnail -->
                                <div class="card-thumb"
                                    style="background-image: url('../assets/uploads/<?= $row['gambar'] ?: 'placeholder.png' ?>'); 
                                       background-color:#e5e7eb;">
                                </div>

                                <div class="card-body">
                                    <div class="card-title">
                                        <?= htmlspecialchars($row['judul']) ?>
                                    </div>

                                    <a class="card-link" href="detail_materi.php?id=<?= $row['id'] ?>">
                                        Lihat Detail
                                    </a>

                                    <a class="card-link" href="edit_materi.php?id=<?= $row['id'] ?>">
                                        Edit
                                    </a>

                                    <a class="card-link-delete"
                                        onclick="return confirm('Hapus materi ini?')"
                                        href="hapus_materi.php?id=<?= $row['id'] ?>">
                                        Hapus
                                    </a>
                                </div>

                            </div>

                        <?php endwhile; ?>
                    <?php endif; ?>

                </div>

            </div>

        </main>

    </div>

</body>

</html>