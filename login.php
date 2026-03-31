<?php
session_start();
require 'cofig/koneksi.php';

if (isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['nama_lengkap'] = $row['nama_lengkap'];

        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <link rel="stylesheet" href="asset/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient flex-center h-screen font-inter">

    <div class="glass-card login-box fade-in">
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Please enter your details to sign in.</p>
        </div>

        <?php if ($error) : ?>
            <div class="alert alert-danger slide-down">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group pb-3">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary btn-block ripple">Sign In</button>
        </form>
        
        <div class="login-footer">
            <p>Use <b>admin</b>/<b>admin</b> or <b>user</b>/<b>user</b></p>
            <p style="margin-top: 0.5rem;">Belum punya akun? <a href="register.php" style="color: var(--primary); font-weight: 600; text-decoration: none;">Daftar di sini</a></p>
        </div>
    </div>

    <script src="asset/script.js"></script>
</body>
</html>
