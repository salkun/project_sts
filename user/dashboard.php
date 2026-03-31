<?php
session_start();
require '../cofig/koneksi.php';

// Cek apakah user biasa
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../asset/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-light font-inter">

    <nav class="navbar glass-nav">
        <div class="container nav-content">
            <h1 class="brand-title">Katalog Barang</h1>
            <div class="user-menu">
                <span>Halo, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>!</span>
                <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4 slide-up">
        
        <div class="card glass-card">
            <div class="card-header">
                <h2>Daftar Barang Tersedia</h2>
            </div>
            <div class="card-body mt-2">
                <div class="grid-container">
                    <?php 
                    $query = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC");
                    while ($row = mysqli_fetch_assoc($query)): ?>
                        <div class="product-card">
                            <div class="product-info">
                                <h3><?= htmlspecialchars($row['nama_barang']) ?></h3>
                                <span class="badge badge-info"><?= htmlspecialchars($row['kategori']) ?></span>
                                <p class="price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                                <p class="stock">Stok Tersedia: <?= $row['stok'] ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($query) == 0): ?>
                        <p class="text-center w-100">Belum ada data barang.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
    
    <script src="../asset/script.js"></script>
</body>
</html>
