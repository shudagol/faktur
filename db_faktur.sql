-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 16 Agu 2016 pada 08.16
-- Versi Server: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_faktur`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('56962aaf69945064364397d6fade99a8', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 1470983375, 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";s:13:"yesGetMeLogin";s:8:"username";s:5:"admin";s:13:"nama_pengguna";s:5:"Shuda";s:4:"stts";s:5:"admin";}'),
('d213eafb6f13b1d653bd5cb1d3a33dca', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 1471235151, 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";s:13:"yesGetMeLogin";s:8:"username";s:5:"admin";s:13:"nama_pengguna";s:5:"Shuda";s:4:"stts";s:5:"admin";}');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE IF NOT EXISTS `tbl_barang` (
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(150) NOT NULL,
  `harga_barang` int(10) NOT NULL,
  `stok` int(10) NOT NULL,
  `keterangan` tinytext NOT NULL,
  `kode_suplier` varchar(10) NOT NULL,
  `harga_beli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`kode_barang`, `nama_barang`, `harga_barang`, `stok`, `keterangan`, `kode_suplier`, `harga_beli`) VALUES
('BR0023', 'Jilbab Kisut', 30000, 33, 'warna warni', 'SP00001', 25000),
('BR0024', 'Jilbab Aleana Hoodie Polka', 35000, 21, 'new versi', 'SP00003', 30000),
('BR0025', 'Jilbab Daily Serut', 50000, -6, 'hijau', 'SP00004', 30000),
('BR0027', 'jilbab renda', 70000, 35, 'fhgh', 'SP00001', 50000),
('BR0028', 'baruuu', 2300, 49, 'jahj', 'SP00001', 2000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_faktur`
--

CREATE TABLE IF NOT EXISTS `tbl_faktur` (
  `kode_faktur` varchar(10) NOT NULL,
  `tanggal_faktur` date NOT NULL,
  `kode_pesanan` varchar(10) NOT NULL,
  `qty_barang_terjual` int(10) NOT NULL,
  `total_barang` int(10) NOT NULL,
  `total_bayar` int(20) NOT NULL,
  `bayar` int(20) NOT NULL,
  `sisa_bayar` int(20) NOT NULL,
  `bayar_hutang` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_faktur`
--

INSERT INTO `tbl_faktur` (`kode_faktur`, `tanggal_faktur`, `kode_pesanan`, `qty_barang_terjual`, `total_barang`, `total_bayar`, `bayar`, `sisa_bayar`, `bayar_hutang`) VALUES
('FK00000001', '2016-07-27', 'PS00000001', 10, 10, 450000, 450000, 0, 0),
('FK00000002', '2016-07-27', 'PS00000002', 3, 3, 90000, 50000, 0, 0),
('FK00000003', '2016-08-10', 'PS00000009', 9, 9, 450000, 45000, 0, 0),
('FK00000004', '2016-08-10', 'PS00000009', 5, 5, 250000, 200000, 0, 0),
('FK00000005', '2016-08-10', 'PS00000010', 10, 10, 300000, 100000, 0, 0),
('FK00000006', '2016-08-10', 'PS00000011', 10, 10, 300000, 500000, 0, 0),
('FK00000007', '2016-08-10', 'PS00000013', 5, 5, 150000, 100000, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_faktur_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_faktur_detail` (
  `kode_faktur` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `qty_terkirim` int(10) NOT NULL,
  `harga_tersimpan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_faktur_detail`
--

INSERT INTO `tbl_faktur_detail` (`kode_faktur`, `kode_barang`, `qty`, `qty_terkirim`, `harga_tersimpan`) VALUES
('FK00000001', 'BR0014', 10, 10, 45000),
('FK00000002', 'BR0021', 5, 3, 30000),
('FK00000003', 'BR0025', 15, 9, 50000),
('FK00000004', 'BR0025', 15, 5, 50000),
('FK00000005', 'BR0023', 10, 10, 30000),
('FK00000006', 'BR0023', 10, 10, 30000),
('FK00000007', 'BR0023', 5, 5, 30000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_login`
--

CREATE TABLE IF NOT EXISTS `tbl_login` (
  `username` varchar(50) NOT NULL,
  `password` varchar(75) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `stts` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_login`
--

INSERT INTO `tbl_login` (`username`, `password`, `nama_pengguna`, `stts`) VALUES
('admin', '6ee3ce2b00c9c04f22d7bfbabeabaac1', 'Shuda', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pelanggan`
--

CREATE TABLE IF NOT EXISTS `tbl_pelanggan` (
  `kode_pelanggan` varchar(10) NOT NULL,
  `nama_pelanggan` varchar(150) NOT NULL,
  `alamat` tinytext NOT NULL,
  `kota` varchar(100) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `hutang` int(40) NOT NULL,
  `stts` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pelanggan`
--

INSERT INTO `tbl_pelanggan` (`kode_pelanggan`, `nama_pelanggan`, `alamat`, `kota`, `provinsi`, `no_telp`, `hutang`, `stts`) VALUES
('PL00004', 'Huda', 'Kartoharjo', 'Nganjuk', 'Jawa Timur', 'dsd', 0, 'Macet'),
('PL00005', 'Anisa', 'Begadumg', 'Nganjuk', 'Jatim', '085733204407', 40000, '-'),
('PL00006', 'Pepy Lolita', 'Lawu 3 no.43 Keramat', 'Nganjuk', 'Jawa Timur', '081359723225', 0, '-'),
('PL00007', 'Ali Masrur', 'Bagor', 'Nganjuk', 'Jawa Timur', '081435680', 120000, '-'),
('PL00008', 'Feri', 'Ploso', 'Nganjuk', 'Jawa Timur', '0359', 455000, '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pesanan_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_pesanan_detail` (
  `kode_pesanan` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `qty_terkirim` int(10) NOT NULL,
  `harga_tersimpan` int(10) NOT NULL,
  `stts_pengiriman` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pesanan_detail`
--

INSERT INTO `tbl_pesanan_detail` (`kode_pesanan`, `kode_barang`, `qty`, `qty_terkirim`, `harga_tersimpan`, `stts_pengiriman`) VALUES
('PS00000001', 'BR0014', 10, 10, 45000, 'terkirim'),
('PS00000002', 'BR0021', 5, 3, 30000, 'pending'),
('PS00000003', 'BR0013', 5, 0, 35000, 'pending'),
('PS00000004', 'BR0023', 7, 0, 30000, 'pending'),
('PS00000005', 'BR0024', 2, 0, 35000, 'pending'),
('PS00000006', 'BR0025', 11, 0, 50000, 'pending'),
('PS00000007', 'BR0023', 1, 0, 30000, 'pending'),
('PS00000008', 'BR0027', 10, 0, 70000, 'pending'),
('PS00000009', 'BR0025', 15, 14, 50000, 'pending'),
('PS00000010', 'BR0023', 10, 10, 30000, 'terkirim'),
('PS00000011', 'BR0023', 10, 10, 30000, 'terkirim'),
('PS00000012', 'BR0023', 1, 0, 30000, 'pending'),
('PS00000013', 'BR0023', 5, 5, 30000, 'terkirim'),
('PS00000014', 'BR0028', 2, 0, 2300, 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pesanan_header`
--

CREATE TABLE IF NOT EXISTS `tbl_pesanan_header` (
  `kode_pesanan` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  `kode_pelanggan` varchar(10) NOT NULL,
  `stts` varchar(10) NOT NULL,
  `jenis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pesanan_header`
--

INSERT INTO `tbl_pesanan_header` (`kode_pesanan`, `username`, `tanggal_pesanan`, `kode_pelanggan`, `stts`, `jenis`) VALUES
('PS00000001', 'admin', '2016-07-27', 'PL00007', 'Ok', 'Pesanan'),
('PS00000002', 'admin', '2016-07-27', 'PL00005', 'Pending', 'Pesanan'),
('PS00000003', 'admin', '2016-07-27', 'PL00005', 'Pending', 'Pesanan'),
('PS00000004', 'admin', '2016-08-10', 'PL00005', 'Pending', 'Pesanan'),
('PS00000005', 'admin', '2016-08-10', 'PL00005', 'Pending', 'Pesanan'),
('PS00000006', 'admin', '2016-08-10', 'PL00005', 'Pending', 'Pesanan'),
('PS00000007', 'admin', '2016-08-10', 'PL00005', 'Pending', 'Pesanan'),
('PS00000008', 'admin', '2016-08-10', 'PL00006', 'Pending', 'Pesanan'),
('PS00000009', 'admin', '2016-08-10', 'PL00008', 'Pending', 'Pesanan'),
('PS00000010', 'admin', '2016-08-10', 'PL00007', 'Ok', 'Pesanan'),
('PS00000011', 'admin', '2016-08-10', 'PL00007', 'Ok', 'Pesanan'),
('PS00000012', 'admin', '2016-08-10', 'PL00005', 'Pending', 'Pesanan'),
('PS00000013', 'admin', '2016-08-10', 'PL00007', 'Ok', 'Pesanan'),
('PS00000014', 'admin', '2016-08-15', 'PL00006', 'Pending', 'Pesanan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_suplier`
--

CREATE TABLE IF NOT EXISTS `tbl_suplier` (
  `kode_suplier` varchar(10) NOT NULL,
  `nama_suplier` varchar(150) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(100) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kontak` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_suplier`
--

INSERT INTO `tbl_suplier` (`kode_suplier`, `nama_suplier`, `alamat`, `kota`, `provinsi`, `kontak`) VALUES
('SP00001', 'Mb. Wiwin', 'Jl. Anjuk Ladang No.05', 'Nganjuk', 'Jawa Timur', '081359332657'),
('SP00003', 'Mb. Lita', 'nurulitashop.com', 'Nganjuk', 'Jawa Timur', '5BDF34'),
('SP00004', 'yeni', 'jl.solo', 'solo', 'jawa tengah', '7gghj2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_surat_jalan`
--

CREATE TABLE IF NOT EXISTS `tbl_surat_jalan` (
  `kode_surat_jalan` varchar(10) NOT NULL,
  `kode_pesanan` varchar(10) NOT NULL,
  `tanggal_surat_jalan` int(20) NOT NULL,
  `kode_faktur` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`session_id`), ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
 ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `tbl_faktur`
--
ALTER TABLE `tbl_faktur`
 ADD PRIMARY KEY (`kode_faktur`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
 ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
 ADD PRIMARY KEY (`kode_pelanggan`);

--
-- Indexes for table `tbl_pesanan_header`
--
ALTER TABLE `tbl_pesanan_header`
 ADD PRIMARY KEY (`kode_pesanan`);

--
-- Indexes for table `tbl_surat_jalan`
--
ALTER TABLE `tbl_surat_jalan`
 ADD PRIMARY KEY (`kode_surat_jalan`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
