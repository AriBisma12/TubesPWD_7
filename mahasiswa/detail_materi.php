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

        <!-- MAIN DETAIL -->
        <main class="content">
            <div class="detail-wrapper">

                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    Materi / <?= htmlspecialchars($materi['judul']) ?>
                </div>

                <!-- Thumbnail -->
                <img
                    src="../assets/uploads/<?= $materi['gambar'] ?: 'placeholder.png' ?>"
                    class="detail-thumb"
                    onerror="this.src='../assets/img/placeholder.png'">

                <!-- Judul -->
                <h1 class="detail-title"><?= htmlspecialchars($materi['judul']) ?></h1>

                <!-- Deskripsi -->
                <p class="detail-desc">
                    <?= nl2br(htmlspecialchars($materi['deskripsi'])) ?>
                </p>


                <!-- Link Video -->
                <?php if (!empty($materi['link_video'])): ?>
                    <h2 class="section-title">Link Video</h2>

                    <p>
                        <a href="<?= htmlspecialchars($materi['link_video']) ?>"
                            target="_blank"
                            class="card-link"
                            style="display: inline-block; margin-top: 8px;">
                            Buka Link Video
                        </a>
                    </p>
                <?php endif; ?>


                <!-- File Tugas -->
                <?php if (!empty($materi['file_tugas'])): ?>
                    <h2 class="section-title">File Tugas</h2>

                    <div class="file-box">
                        <?php
                        $file = htmlspecialchars($materi['file_tugas']);
                        $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                        // Jika PDF → tampilkan embed viewer
                        if ($ext === "pdf") {
                            echo "
                        <embed src='../assets/uploads/$file'
                               type='application/pdf'
                               width='100%'
                               height='500px'>
                        ";
                        } else {
                            // Download file lain (doc, docx, ppt, zip, dll)
                            echo "
                        <a href='../assets/uploads/$file'
                           class='btn-download'
                           download>
                            📥 Download File Tugas ($ext)
                        </a>
                        ";
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <a class="btn-subscribe" style="margin-top: 20px;">Langganan</a>

            </div>
        </main>

    </div>

</body>

</html>