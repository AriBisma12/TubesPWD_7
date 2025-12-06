<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require "../config/db.php";

// ============================
// QUERY DATA USER
// ============================
$id = $_SESSION['user_id'];

$userStmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$userStmt->bind_param("i", $id);
$userStmt->execute();
$user = $userStmt->get_result()->fetch_assoc();

if (!$user) {
    die("Error: Data user tidak ditemukan.");
}

// ============================
// QUERY MATERI BERDASARKAN PEMILIK
// ============================
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
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="brand">Belajar<span class="accent">HUB</span></div>

            <div class="menu-title">Menu</div>
            <ul class="menu-list">
                <li><a href="index.php">Home</a></li>
                <li><a href="materi.php">Materi</a></li>
                <li><a href="tugas.php">Tugas</a></li>
                <li class="active"><a href="profil.php">Profil</a></li>
                <li><a href="../index.php" onclick="confirmLogout('auth/logout.php')">Logout</a></li>
            </ul>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="content">

            <h2 class="bold" style="margin-bottom: 22px;">Profil Pengguna</h2>

            <div class="profile-main">

                <!-- PROFILE CARD -->
                <div class="profile-card">
                    <img src="https://cdn-icons-png.flaticon.com/512/666/666201.png"
                        class="profile-photo">

                    <div class="profile-name"><?= htmlspecialchars($user['nama']) ?></div>
                    <div class="profile-email"><?= htmlspecialchars($user['email']) ?></div>

                    <a href="index.php" class="btn-back">Kembali</a>
                </div>

                <!-- KONTEN KANAN -->
                <div class="profile-right">
                    <div class="big-banner"></div>
                    <h3 class="section-title">Materi Yang Pernah Diupload</h3>
                    <div class="card-row">

                        <?php if ($result->num_rows === 0): ?>
                            <p class="empty-text">Belum ada materi yang kamu upload.</p>

                        <?php else: ?>
                            <?php while ($row = $result->fetch_assoc()): ?>

                                <div class="materi-card">

                                    <!-- Thumbnail -->
                                    <div class="card-thumb"
                                        style="background-image: url('../uploads/<?= $row['gambar'] ?: 'placeholder.png' ?>'); 
                                       background-color:#e5e7eb;">
                                    </div>

                                    <div class="card-body">
                                        <div class="card-title">
                                            <?= htmlspecialchars($row['judul']) ?>
                                        </div>

                                        <a class="card-link" href="detail_materi.php?id=<?= $row['id'] ?>">
                                            Lihat Detail
                                        </a>
                                    </div>

                                </div>

                            <?php endwhile; ?>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

        </main>

    </div>

</body>

</html>