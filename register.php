<?php
session_start();
require 'cofig/koneksi.php';

if (isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if (isset($_POST['register'])) {
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Hashing password
    $role = 'user'; // Default role user biasa

    // Cek apakah username sudah ada
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        $error = "Username sudah digunakan! Silakan pilih yang lain.";
    } else {
        $query = "INSERT INTO users (nama_lengkap, username, password, role) VALUES ('$nama_lengkap', '$username', '$password', '$role')";
        if (mysqli_query($koneksi, $query)) {
            $success = "Akun berhasil dibuat! Silakan <a href='login.php' style='color:#3B82F6;font-weight:bold;text-decoration:underline;'>Login di sini</a>.";
        } else {
            $error = "Terjadi kesalahan saat mendaftar: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link rel="stylesheet" href="asset/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient flex-center h-screen font-inter">

    <div class="glass-card login-box fade-in" style="max-width: 450px;">
        <div class="login-header">
            <h2>Buat Akun Baru</h2>
            <p>Daftar untuk mengakses sistem kami.</p>
        </div>

        <?php if ($error) : ?>
            <div class="alert alert-danger slide-down">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if ($success) : ?>
            <div class="alert alert-info slide-down">
                <?= $success ?>
            </div>
        <?php else: ?>

        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Pilih username" required>
            </div>
            
            <div class="form-group pb-3">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Buat password" required>
            </div>

            <button type="submit" name="register" class="btn btn-primary btn-block ripple">Daftar Akun</button>
        </form>
        
        <?php endif; ?>

        <div class="login-footer">
            <p>Sudah punya akun? <a href="login.php" style="color: var(--primary); font-weight: 600; text-decoration: none;">Sign In</a></p>
        </div>
    </div>

    <script src="asset/script.js"></script>
</body>
</html>
