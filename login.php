<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="form-container">
        <h2>Login</h2>

        <form action="auth/login_process.php" method="POST">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button class="btn-primary" type="submit">Masuk</button>
        </form>
    </div>

    <!-- Javascript agar show password, validasi, alert -->
    <script src="assets/js/script.js"></script>
</body>

</html>
