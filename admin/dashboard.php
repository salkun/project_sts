<?php
session_start();
require '../cofig/koneksi.php';

// Cek apakah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Handler Aksi Hapus
if (isset($_GET['act']) && $_GET['act'] == 'hapus') {
    $id = (int)$_GET['id'];
    $hapus = mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");
    if ($hapus) {
        header("Location: dashboard.php?msg=hapus_sukses");
    } else {
        header("Location: dashboard.php?msg=hapus_gagal");
    }
    exit;
}

// Handler Aksi Tambah
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];

    $query = "INSERT INTO barang (nama_barang, kategori, harga, stok) VALUES ('$nama', '$kategori', $harga, $stok)";
    if (mysqli_query($koneksi, $query)) {
        header("Location: dashboard.php?msg=tambah_sukses");
    } else {
        header("Location: dashboard.php?msg=tambah_gagal");
    }
    exit;
}

// Handler Aksi Edit
if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];

    $query = "UPDATE barang SET nama_barang='$nama', kategori='$kategori', harga=$harga, stok=$stok WHERE id=$id";
    if (mysqli_query($koneksi, $query)) {
        header("Location: dashboard.php?msg=edit_sukses");
    } else {
        header("Location: dashboard.php?msg=edit_gagal");
    }
    exit;
}

$act = isset($_GET['act']) ? $_GET['act'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../asset/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-light font-inter">

    <nav class="navbar glass-nav">
        <div class="container nav-content">
            <h1 class="brand-title">AdminPanel</h1>
            <div class="user-menu">
                <span>Halo, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>!</span>
                <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4 slide-up">
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-info">
                <?php 
                    if ($_GET['msg'] == 'tambah_sukses') echo "Data berhasil ditambahkan!";
                    elseif ($_GET['msg'] == 'edit_sukses') echo "Data berhasil diperbarui!";
                    elseif ($_GET['msg'] == 'hapus_sukses') echo "Data berhasil dihapus!";
                    else echo "Operasi gagal dilakukan.";
                ?>
            </div>
        <?php endif; ?>

        <?php if ($act == 'tambah'): ?>
            <div class="card glass-card">
                <div class="card-header">
                    <h2>Tambah Barang Baru</h2>
                    <a href="dashboard.php" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body mt-2">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>Kategori</label>
                            <input type="text" name="kategori" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" name="tambah" class="btn btn-primary">Simpan Barang</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php elseif ($act == 'edit'): 
            $id = (int)$_GET['id'];
            $data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id = $id");
            $row = mysqli_fetch_assoc($data);
            if (!$row) die('Data tidak ditemukan');
        ?>
            <div class="card glass-card">
                <div class="card-header">
                    <h2>Edit Barang</h2>
                    <a href="dashboard.php" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body mt-2">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($row['nama_barang']) ?>" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>Kategori</label>
                            <input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($row['kategori']) ?>" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" value="<?= $row['harga'] ?>" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= $row['stok'] ?>" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" name="edit" class="btn btn-primary">Update Barang</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php else: ?>
            <div class="card glass-card">
                <div class="card-header">
                    <h2>Daftar Barang</h2>
                    <a href="dashboard.php?act=tambah" class="btn btn-primary btn-sm">+ Tambah Baru</a>
                </div>
                <div class="card-body mt-2">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                $query = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC");
                                while ($row = mysqli_fetch_assoc($query)): ?>
                                    <tr class="table-row-hover">
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                                        <td><span class="badge badge-info"><?= htmlspecialchars($row['kategori']) ?></span></td>
                                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                        <td><?= $row['stok'] ?></td>
                                        <td class="action-buttons">
                                            <a href="dashboard.php?act=edit&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="dashboard.php?act=hapus&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
    
    <script src="../asset/script.js"></script>
</body>
</html>
