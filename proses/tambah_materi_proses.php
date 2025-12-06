<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: tambah_materi.php");
    exit;
}

$pemilik     = $_SESSION['nama'] ?? 'Mahasiswa';
$judul       = trim($_POST['judul'] ?? '');
$deskripsi   = trim($_POST['deskripsi'] ?? '');
$linkVideo   = trim($_POST['link_video'] ?? '');
$gambarName  = null;
$fileName    = null;

$errors = [];

// Validasi
if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}

if ($deskripsi === '') {
    $errors[] = "Deskripsi wajib diisi.";
}

/* =========================
   UPLOAD GAMBAR OPSIONAL
========================= */
if (!empty($_FILES['gambar']['name'])) {
    $allowedImg = ['jpg', 'jpeg', 'png', 'gif'];
    $ext        = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedImg)) {
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

/* =========================
   UPLOAD FILE TUGAS OPSIONAL
========================= */
if (!empty($_FILES['file_tugas']['name'])) {
    $allowedFile = ['pdf', 'doc', 'docx', 'zip', 'ppt', 'pptx'];
    $ext         = strtolower(pathinfo($_FILES['file_tugas']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedFile)) {
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

/* =========================
     TIDAK ADA ERROR → SIMPAN
========================= */
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

/* =========================
    KEMBALIKAN FORM + ERROR
========================= */
$_SESSION['old'] = [
    'judul'      => $judul,
    'deskripsi'  => $deskripsi,
    'link_video' => $linkVideo
];

$_SESSION['error'] = implode(" ", $errors);

header("Location: tambah_materi.php");
exit;
