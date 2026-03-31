CREATE DATABASE IF NOT EXISTS `db_sts`;
USE `db_sts`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `nama_lengkap` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`username`, `password`, `role`, `nama_lengkap`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'Administrator Utama'),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 'Pengguna Biasa');
-- password admin: admin
-- password user: user

CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `barang` (`nama_barang`, `kategori`, `harga`, `stok`) VALUES
('Laptop Asus ROG', 'Elektronik', 15000000, 10),
('Keyboard Mechanical', 'Aksesoris', 850000, 25),
('Mouse Logitech', 'Aksesoris', 350000, 50);
