-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2022 at 07:23 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eposyandu`
--

-- --------------------------------------------------------

--
-- Table structure for table `ref_anak`
--

CREATE TABLE `ref_anak` (
  `id_anak` int(11) NOT NULL,
  `nama_anak` varchar(50) NOT NULL,
  `nik_anak` varchar(25) NOT NULL,
  `tempat_lahir_anak` varchar(255) NOT NULL,
  `tgl_lahir_anak` date NOT NULL,
  `jk_anak` enum('P','L') NOT NULL,
  `nik_ibu` varchar(20) DEFAULT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `alamat_ibu` varchar(255) NOT NULL,
  `no_telp_ibu` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref_anak`
--

INSERT INTO `ref_anak` (`id_anak`, `nama_anak`, `nik_anak`, `tempat_lahir_anak`, `tgl_lahir_anak`, `jk_anak`, `nik_ibu`, `nama_ibu`, `alamat_ibu`, `no_telp_ibu`) VALUES
(6, 'Kevin Sanjaya', '3234097611800911', 'Kendal', '2022-05-13', 'L', '3325089015211231', 'Kurnia Kusumastuti', 'Brangsong', '628883911162'),
(9, 'Azzahra Yunita', '3324089001009560', 'Kendal', '2022-06-11', 'P', '3324089001821765', 'Lala Ayuningrum', 'Brangsong', '6289100200010');

-- --------------------------------------------------------

--
-- Table structure for table `ref_bantuan`
--

CREATE TABLE `ref_bantuan` (
  `id_bantuan` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ref_ibu`
--

CREATE TABLE `ref_ibu` (
  `id_ibu` int(11) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `nik_ibu` varchar(20) NOT NULL,
  `alamat_ibu` text NOT NULL,
  `no_telp_ibu` varchar(20) NOT NULL,
  `foto_ibu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref_ibu`
--

INSERT INTO `ref_ibu` (`id_ibu`, `nama_ibu`, `nik_ibu`, `alamat_ibu`, `no_telp_ibu`, `foto_ibu`) VALUES
(11, 'ueiqeuqieuqe', '7617616176177', 'hdasjdaksdh', 'dhidhaidsui', 'foto1654945663.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ref_imunisasi`
--

CREATE TABLE `ref_imunisasi` (
  `id_imunisasi` int(11) NOT NULL,
  `tgl_imunisasi` date NOT NULL,
  `id_vaksin` varchar(255) DEFAULT NULL,
  `id_anak` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref_imunisasi`
--

INSERT INTO `ref_imunisasi` (`id_imunisasi`, `tgl_imunisasi`, `id_vaksin`, `id_anak`, `id_petugas`) VALUES
(1, '2022-06-11', '1', 9, 1),
(2, '2022-05-13', '1', 6, 1),
(3, '2022-06-13', '2', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ref_login`
--

CREATE TABLE `ref_login` (
  `id_login` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_petugas_login` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref_login`
--

INSERT INTO `ref_login` (`id_login`, `username`, `password`, `id_petugas_login`) VALUES
(1, 'admin', '$2y$10$4E5NEooMTyAKWrQkUcgcBuZW1RwJImsc.XU1POuGBUEIAdfVKeveG', 0),
(3, 'petugas2', '$2y$10$LBa0/g9dFO2foV8lbNhhV.VgnvyWuIElj6FsQfNtkBW1H7Djmiiyy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ref_penimbangan`
--

CREATE TABLE `ref_penimbangan` (
  `id_penimbangan` int(11) NOT NULL,
  `tgl_penimbangan` date NOT NULL,
  `id_anak` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `bb_penimbangan` double NOT NULL,
  `tb_penimbangan` double NOT NULL,
  `lingkar_kepala` double NOT NULL,
  `perilaku` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_penimbangan`
--

INSERT INTO `ref_penimbangan` (`id_penimbangan`, `tgl_penimbangan`, `id_anak`, `id_petugas`, `bb_penimbangan`, `tb_penimbangan`, `lingkar_kepala`, `perilaku`) VALUES
(1, '2022-06-12', 6, 1, 10, 45, 35, 'Menatap ke ibu-Mengoceh');

-- --------------------------------------------------------

--
-- Table structure for table `ref_petugas`
--

CREATE TABLE `ref_petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(50) NOT NULL,
  `jabatan_petugas` varchar(50) NOT NULL,
  `jk_petugas` enum('L','P') NOT NULL,
  `tempat_lahir_petugas` varchar(50) NOT NULL,
  `tgl_lahir_petugas` date NOT NULL,
  `alamat_petugas` text NOT NULL,
  `no_telp_petugas` varchar(20) NOT NULL,
  `foto_petugas` varchar(150) DEFAULT NULL,
  `status_petugas` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref_petugas`
--

INSERT INTO `ref_petugas` (`id_petugas`, `nama_petugas`, `jabatan_petugas`, `jk_petugas`, `tempat_lahir_petugas`, `tgl_lahir_petugas`, `alamat_petugas`, `no_telp_petugas`, `foto_petugas`, `status_petugas`, `username`, `password`, `level`) VALUES
(1, 'Angga Cahya', 'Petugas 1', 'L', 'Bandung', '1988-06-19', 'Jl. Leuwi Panjang', '6289319092891', 'foto1655004651.jpg', 'Aktif', 'Admin', '12345', 'admin'),
(2, 'Kevin Farel', 'Petugas 2', 'L', 'Bandung', '1983-05-19', 'Jl. Buah Batu', '6289319902737', 'foto1655205660.jpg', 'Aktif', 'kevin', 'kevin', 'kader'),
(3, 'Arya Permana', 'Ketua kader', 'L', 'Jakarta', '1987-10-20', 'Jl. Cibaduyut Raya', '6289643392093', '-', 'Aktif', 'arya', 'arya', 'kader'),
(4, 'Supriadi Armalawi', 'Ketua Kader', 'L', 'Jakarta', '1988-10-21', 'Jl. Moh.toha', '6289333902209 ', '-', 'Tidak', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ref_posyandu`
--

CREATE TABLE `ref_posyandu` (
  `id_posyandu` int(11) NOT NULL,
  `nama_posyandu` varchar(50) NOT NULL,
  `alamat_posyandu` text NOT NULL,
  `kel_posyandu` varchar(50) NOT NULL,
  `kec_posyandu` varchar(50) NOT NULL,
  `kota_kab_posyandu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ref_vaksin`
--

CREATE TABLE `ref_vaksin` (
  `id_vaksin` int(11) NOT NULL,
  `nama_vaksin` varchar(50) NOT NULL,
  `usia_vaksin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref_vaksin`
--

INSERT INTO `ref_vaksin` (`id_vaksin`, `nama_vaksin`, `usia_vaksin`) VALUES
(1, 'Hepatitis B', 0),
(2, 'BCG POLIO 1', 30),
(3, 'DPT-1 Hepatitis B 1 HIB 1 Polio-2 ', 60),
(4, 'DPT 2 Hepatitis B2 Hib 2 Polio-3 ', 90),
(5, 'DPT 3 Hepatitis B 3 Hib 3 Polio-4 IPV ', 120),
(6, 'Campak 1 ', 270);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ref_anak`
--
ALTER TABLE `ref_anak`
  ADD PRIMARY KEY (`id_anak`);

--
-- Indexes for table `ref_bantuan`
--
ALTER TABLE `ref_bantuan`
  ADD PRIMARY KEY (`id_bantuan`);

--
-- Indexes for table `ref_ibu`
--
ALTER TABLE `ref_ibu`
  ADD PRIMARY KEY (`id_ibu`);

--
-- Indexes for table `ref_imunisasi`
--
ALTER TABLE `ref_imunisasi`
  ADD PRIMARY KEY (`id_imunisasi`);

--
-- Indexes for table `ref_login`
--
ALTER TABLE `ref_login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `ref_penimbangan`
--
ALTER TABLE `ref_penimbangan`
  ADD PRIMARY KEY (`id_penimbangan`);

--
-- Indexes for table `ref_petugas`
--
ALTER TABLE `ref_petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `ref_posyandu`
--
ALTER TABLE `ref_posyandu`
  ADD PRIMARY KEY (`id_posyandu`);

--
-- Indexes for table `ref_vaksin`
--
ALTER TABLE `ref_vaksin`
  ADD PRIMARY KEY (`id_vaksin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ref_anak`
--
ALTER TABLE `ref_anak`
  MODIFY `id_anak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ref_bantuan`
--
ALTER TABLE `ref_bantuan`
  MODIFY `id_bantuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_ibu`
--
ALTER TABLE `ref_ibu`
  MODIFY `id_ibu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ref_imunisasi`
--
ALTER TABLE `ref_imunisasi`
  MODIFY `id_imunisasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ref_login`
--
ALTER TABLE `ref_login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ref_penimbangan`
--
ALTER TABLE `ref_penimbangan`
  MODIFY `id_penimbangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ref_petugas`
--
ALTER TABLE `ref_petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ref_posyandu`
--
ALTER TABLE `ref_posyandu`
  MODIFY `id_posyandu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_vaksin`
--
ALTER TABLE `ref_vaksin`
  MODIFY `id_vaksin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
