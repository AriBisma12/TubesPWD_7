<!DOCTYPE html>
<html>

<head>
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="form-container">
        <h2>Registrasi</h2>

        <form action="auth/register_process.php" method="POST">
            <label>Nama</label>
            <input type="text" name="nama" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button class="btn-primary" type="submit">Daftar</button>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>
