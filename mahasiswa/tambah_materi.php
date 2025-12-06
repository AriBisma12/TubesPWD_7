<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require "../config/db.php";

$error   = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
$old     = $_SESSION['old'] ?? ['judul' => '', 'deskripsi' => '', 'link_video' => ''];
unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pemilik     = $_SESSION['nama'] ?? 'Mahasiswa';
    $judul       = trim($_POST['judul'] ?? '');
    $deskripsi   = trim($_POST['deskripsi'] ?? '');
    $linkVideo   = trim($_POST['link_video'] ?? '');
    $gambarName  = null;
    $fileName    = null;
    $errors      = [];

    if ($judul === '') {
        $errors[] = "Judul wajib diisi.";
    }

    if ($deskripsi === '') {
        $errors[] = "Deskripsi wajib diisi.";
    }

    // Upload gambar (opsional)
    if (!empty($_FILES['gambar']['name'])) {
        $allowedImg = ['jpg', 'jpeg', 'png', 'gif'];
        $ext        = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedImg, true)) {
            $errors[] = "Format gambar harus jpg, jpeg, png, atau gif.";
        } elseif ($_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Upload gambar gagal.";
        } else {
            $gambarName = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $_FILES['gambar']['name']);
            if (!move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/" . $gambarName)) {
                $errors[]  = "Tidak bisa menyimpan gambar.";
                $gambarName = null;
            }
        }
    }

    // Upload file tugas (opsional)
    if (!empty($_FILES['file_tugas']['name'])) {
        $allowedFile = ['pdf', 'doc', 'docx', 'zip', 'ppt', 'pptx'];
        $ext         = strtolower(pathinfo($_FILES['file_tugas']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedFile, true)) {
            $errors[] = "Format file tugas harus pdf, doc, docx, zip, ppt, atau pptx.";
        } elseif ($_FILES['file_tugas']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Upload file tugas gagal.";
        } else {
            $fileName = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $_FILES['file_tugas']['name']);
            if (!move_uploaded_file($_FILES['file_tugas']['tmp_name'], "../uploads/" . $fileName)) {
                $errors[] = "Tidak bisa menyimpan file tugas.";
                $fileName = null;
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("
            INSERT INTO materi (pemilik, judul, gambar, deskripsi, link_video, file_tugas)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssssss", $pemilik, $judul, $gambarName, $deskripsi, $linkVideo, $fileName);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Materi berhasil ditambahkan.";
            header("Location: materi.php");
            exit;
        }

        $errors[] = "Terjadi kesalahan: " . $conn->error;
        $stmt->close();
    }

    $_SESSION['old'] = [
        'judul'      => $judul,
        'deskripsi'  => $deskripsi,
        'link_video' => $linkVideo,
    ];
    $_SESSION['error'] = implode(" ", $errors);
    header("Location: tambah_materi.php");
    exit;
}
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
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Judul Materi</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($old['judul'] ?? '') ?>" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required><?= htmlspecialchars($old['deskripsi'] ?? '') ?></textarea>

            <label>Link Video (opsional)</label>
            <input type="text" name="link_video" value="<?= htmlspecialchars($old['link_video'] ?? '') ?>">

            <label>Gambar (opsional)</label>
            <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.gif">

            <label>File Tugas (opsional)</label>
            <input type="file" name="file_tugas" accept=".pdf,.doc,.docx,.zip,.ppt,.pptx">

            <br><br>
            <button class="btn-primary" type="submit">Simpan Materi</button>
            <a class="btn-primary" href="materi.php" style="margin-left: 8px;">Kembali</a>
        </form>
    </div>

    <footer class="footer">Developed for UAS PWD 2025/2026</footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>
