-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 30, 2023 at 08:47 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `retel`
--

-- --------------------------------------------------------

--
-- Table structure for table `aksescrud`
--

CREATE TABLE IF NOT EXISTS `aksescrud` (
  `id_aksescrud` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupakses` int(11) NOT NULL,
  `id_modul` int(11) NOT NULL,
  `lihat` char(1) NOT NULL,
  `isi` char(1) NOT NULL,
  `ubah` char(1) NOT NULL,
  `hapus` char(1) NOT NULL,
  PRIMARY KEY (`id_aksescrud`),
  KEY `id_grupakses` (`id_grupakses`),
  KEY `id_modul` (`id_modul`),
  KEY `id_modul_2` (`id_modul`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `aksescrud`
--

INSERT INTO `aksescrud` (`id_aksescrud`, `id_grupakses`, `id_modul`, `lihat`, `isi`, `ubah`, `hapus`) VALUES
(16, 3, 52, 'y', 'y', 'y', 'y'),
(17, 3, 28, 'y', 'y', 'y', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `grupakses`
--

CREATE TABLE IF NOT EXISTS `grupakses` (
  `id_grupakses` int(11) NOT NULL AUTO_INCREMENT,
  `grupakses` varchar(50) NOT NULL,
  PRIMARY KEY (`id_grupakses`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `grupakses`
--

INSERT INTO `grupakses` (`id_grupakses`, `grupakses`) VALUES
(3, 'Juri');

-- --------------------------------------------------------

--
-- Table structure for table `kategorinilai`
--

CREATE TABLE IF NOT EXISTS `kategorinilai` (
  `id_kategorinilai` int(11) NOT NULL AUTO_INCREMENT,
  `kategorinilai` varchar(100) NOT NULL,
  `persentasenilai` decimal(10,2) NOT NULL,
  `nilaimaksimal` int(11) NOT NULL,
  `tampilkan` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id_kategorinilai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `kategorinilai`
--

INSERT INTO `kategorinilai` (`id_kategorinilai`, `kategorinilai`, `persentasenilai`, `nilaimaksimal`, `tampilkan`) VALUES
(8, 'Vocal Group Serie B', 100.00, 100, 'n');

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE IF NOT EXISTS `modul` (
  `id_modul` int(11) NOT NULL AUTO_INCREMENT,
  `modul` varchar(100) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `aktif` enum('Y','T') DEFAULT NULL,
  `id_parent` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `urutan` int(3) NOT NULL,
  PRIMARY KEY (`id_modul`),
  KEY `id_parent` (`id_parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`id_modul`, `modul`, `link`, `aktif`, `id_parent`, `icon`, `urutan`) VALUES
(23, 'Parent', '?module=parent', 'Y', 13, 'fa fa-key fa-fw', 1),
(24, 'Modul', '?module=modul', 'Y', 13, 'fa fa-leaf fa-fw', 2),
(25, 'User', '?module=user', 'Y', 13, 'fa fa-inbox fa-fw', 3),
(26, 'Grup Akses', '?module=grupakses', 'Y', 13, 'fa fa-navicon fa-fw', 4),
(27, 'Akses Crud', '?module=aksescrud', 'Y', 13, 'fa fa-user fa-fw', 5),
(28, 'Home', '?module=home', 'Y', 17, 'fa fa-user fa-fw', 1),
(34, 'Rayon', '?module=rayon', 'Y', 15, 'fa fa-cloud fa-fw', 3),
(49, 'Peserta', '?module=peserta', 'Y', 19, 'fa fa-user fa-fw', 1),
(50, 'Kategori Nilai', '?module=kategorinilai', 'Y', 24, 'fa fa-area-chart fa-fw', 1),
(51, 'User Kategori Nilai', '?module=userkategorinilai', 'Y', 25, 'fa fa-user fa-fw', 1),
(52, 'Penilaian', '?module=penilaian', 'Y', 26, 'fa fa-user fa-fw', 1),
(53, 'Rekap Nilai', '?module=rekapnilai', 'Y', 27, 'fa fa-user fa-fw', 1),
(54, 'Peserta Kategori Nilai', '?module=pesertakategorinilai', 'Y', 28, 'fa fa-bicycle fa-fw', 1),
(55, 'Persahabatan', '?module=persahabatan', 'Y', 27, 'fa fa-user fa-fw', 2),
(56, 'Tampilkan', '?module=tampilkan', 'Y', 29, 'fa fa-bell fa-fw', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE IF NOT EXISTS `parent` (
  `id_parent` int(11) NOT NULL AUTO_INCREMENT,
  `parent` varchar(100) NOT NULL,
  `urutan` int(2) NOT NULL,
  `icon` varchar(100) NOT NULL,
  PRIMARY KEY (`id_parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`id_parent`, `parent`, `urutan`, `icon`) VALUES
(13, 'Settings', 9, 'fa fa-cubes fa-fw'),
(15, 'Wilayah', 2, 'fa fa-gears fa-fw'),
(17, 'Home', 1, 'fa fa-home fa-fw'),
(19, 'Peserta', 7, 'fa fa-male fa-fw'),
(24, 'Kategori Nilai', 5, 'fa fa-calculator fa-fw'),
(25, 'User Kategori Nilai', 6, 'fa fa-area-chart fa-fw'),
(26, 'Penilaian', 7, 'fa fa-bookmark fa-fw'),
(27, 'Rekap Nilai', 8, 'fa fa-calendar fa-fw'),
(28, 'Peserta Kategori Nilai', 8, 'fa fa-bicycle fa-fw'),
(29, 'Tampilkan', 2, 'fa fa-bell fa-fw');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE IF NOT EXISTS `penilaian` (
  `id_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `penilaian` decimal(10,2) NOT NULL,
  `id_kategorinilai` int(11) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `catatan` text NOT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `id_kategorinilai` (`id_kategorinilai`),
  KEY `id_user` (`id_user`),
  KEY `id_peserta` (`id_peserta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `penilaian`, `id_kategorinilai`, `id_user`, `id_peserta`, `catatan`) VALUES
(4, 87.00, 8, 'pntwilly', 4, 'Content 87 | Correlation 88 | Performance 86 <br> '),
(6, 89.00, 8, 'tiffanymoningka', 4, 'Content 89 | Correlation 89 | Performance 89 <br> ');

-- --------------------------------------------------------

--
-- Table structure for table `persahabatan`
--

CREATE TABLE IF NOT EXISTS `persahabatan` (
  `id_persahabatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_peserta` int(11) NOT NULL,
  PRIMARY KEY (`id_persahabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE IF NOT EXISTS `peserta` (
  `id_peserta` int(11) NOT NULL AUTO_INCREMENT,
  `peserta` varchar(100) NOT NULL,
  `jemaat` varchar(100) NOT NULL,
  `wilayah` varchar(100) NOT NULL,
  `id_rayon` int(11) NOT NULL,
  `kelamin` varchar(6) NOT NULL,
  `nomortalent` int(11) NOT NULL,
  PRIMARY KEY (`id_peserta`),
  KEY `id_rayon` (`id_rayon`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id_peserta`, `peserta`, `jemaat`, `wilayah`, `id_rayon`, `kelamin`, `nomortalent`) VALUES
(4, 'VG Team A Getsemani', 'GMIM Getsemani Perum Rizky', '', 1, '', 1),
(5, 'VG Paulus Kauditan A', 'GMIM Paulus Kauditan', '', 2, '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pesertakategorinilai`
--

CREATE TABLE IF NOT EXISTS `pesertakategorinilai` (
  `id_pesertakategorinilai` int(11) NOT NULL AUTO_INCREMENT,
  `id_peserta` int(11) NOT NULL,
  `id_kategorinilai` int(11) NOT NULL,
  PRIMARY KEY (`id_pesertakategorinilai`),
  KEY `id_peserta` (`id_peserta`),
  KEY `id_kategorinilai` (`id_kategorinilai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pesertakategorinilai`
--

INSERT INTO `pesertakategorinilai` (`id_pesertakategorinilai`, `id_peserta`, `id_kategorinilai`) VALUES
(3, 4, 8),
(4, 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `rawdata`
--

CREATE TABLE IF NOT EXISTS `rawdata` (
  `nama` varchar(100) NOT NULL,
  `nomor` varchar(100) NOT NULL,
  `kelamin` varchar(100) NOT NULL,
  `jemaat` varchar(100) NOT NULL,
  `wilayah` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rayon`
--

CREATE TABLE IF NOT EXISTS `rayon` (
  `id_rayon` int(11) NOT NULL AUTO_INCREMENT,
  `rayon` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_rayon`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rayon`
--

INSERT INTO `rayon` (`id_rayon`, `rayon`, `keterangan`) VALUES
(1, 'Kalawat Raya', 'Kalawat Raya'),
(2, 'Minawerot', '');

-- --------------------------------------------------------

--
-- Table structure for table `talentmantos`
--

CREATE TABLE IF NOT EXISTS `talentmantos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(200) NOT NULL,
  `penilaian` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userkategorinilai`
--

CREATE TABLE IF NOT EXISTS `userkategorinilai` (
  `id_userkategorinilai` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(100) NOT NULL,
  `id_kategorinilai` int(11) NOT NULL,
  PRIMARY KEY (`id_userkategorinilai`),
  KEY `id_user` (`id_user`),
  KEY `id_kategorinilai` (`id_kategorinilai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `userkategorinilai`
--

INSERT INTO `userkategorinilai` (`id_userkategorinilai`, `id_user`, `id_kategorinilai`) VALUES
(2, 'tiffanymoningka', 8),
(3, 'pntwilly', 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) DEFAULT NULL,
  `namalengkap` varchar(100) DEFAULT NULL,
  `id_grupakses` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `notelp` varchar(20) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `id_userslevel` int(11) DEFAULT NULL,
  `blokir` enum('Y','T') DEFAULT NULL,
  `id_session` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `id_userslevel` (`id_userslevel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `namalengkap`, `id_grupakses`, `email`, `notelp`, `foto`, `id_userslevel`, `blokir`, `id_session`) VALUES
('administrator', '014ee16ac542a3a88535612a35ca6c78', 'Administrator', 1, '', '', NULL, 1, 'T', '41f83316477477a0bc03ac954c9a251b'),
('kelotuerah', 'c7997dd5634e2e5de9e39bfe33984774', 'Juri VG 1 - Michael Tuerah', 3, '', '', NULL, 2, 'T', 'c7997dd5634e2e5de9e39bfe33984774'),
('pntwilly', 'a73e47bcfd398c44c047863588227a95', 'Pnt Will', 3, '', '', NULL, 2, 'T', 'a73e47bcfd398c44c047863588227a95'),
('tiffanymoningka', '409ac3a4a3639f1ddaefd4fc71eb552e', 'Pnt. Tiffany Moningka', 3, '', '', NULL, 2, 'T', '409ac3a4a3639f1ddaefd4fc71eb552e');

-- --------------------------------------------------------

--
-- Table structure for table `userslevel`
--

CREATE TABLE IF NOT EXISTS `userslevel` (
  `id_userslevel` int(11) NOT NULL AUTO_INCREMENT,
  `userslevel` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_userslevel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `userslevel`
--

INSERT INTO `userslevel` (`id_userslevel`, `userslevel`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `usersmodul`
--

CREATE TABLE IF NOT EXISTS `usersmodul` (
  `id_umod` int(11) NOT NULL,
  `id_session` varchar(50) DEFAULT NULL,
  `id_modul` int(11) DEFAULT NULL,
  `lihat` enum('Y','T') DEFAULT NULL,
  `isi` enum('Y','T') DEFAULT NULL,
  `ubah` enum('Y','T') DEFAULT NULL,
  `hapus` enum('Y','T') DEFAULT NULL,
  KEY `id_modul` (`id_modul`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usersmodul`
--

INSERT INTO `usersmodul` (`id_umod`, `id_session`, `id_modul`, `lihat`, `isi`, `ubah`, `hapus`) VALUES
(1, 'e9b72959d3542b5a12e17679a4f53e0a', 2, 'Y', 'T', 'T', 'Y'),
(2, 'e9b72959d3542b5a12e17679a4f53e0a', 3, 'Y', 'Y', 'Y', 'Y'),
(4, 'e9b72959d3542b5a12e17679a4f53e0a', 6, 'Y', 'Y', 'Y', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wawancara`
--

CREATE TABLE IF NOT EXISTS `wawancara` (
  `id_wawancara` int(11) NOT NULL AUTO_INCREMENT,
  `id_peserta` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `sudah` char(1) NOT NULL,
  PRIMARY KEY (`id_wawancara`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `wawancara`
--

INSERT INTO `wawancara` (`id_wawancara`, `id_peserta`, `username`, `sudah`) VALUES
(10, 5, 'tiffanymoningka', 'n');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_kategorinilai`) REFERENCES `kategorinilai` (`id_kategorinilai`),
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `penilaian_ibfk_3` FOREIGN KEY (`id_peserta`) REFERENCES `peserta` (`id_peserta`);

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`id_rayon`) REFERENCES `rayon` (`id_rayon`);

--
-- Constraints for table `pesertakategorinilai`
--
ALTER TABLE `pesertakategorinilai`
  ADD CONSTRAINT `pesertakategorinilai_ibfk_1` FOREIGN KEY (`id_peserta`) REFERENCES `peserta` (`id_peserta`),
  ADD CONSTRAINT `pesertakategorinilai_ibfk_2` FOREIGN KEY (`id_kategorinilai`) REFERENCES `kategorinilai` (`id_kategorinilai`);

--
-- Constraints for table `userkategorinilai`
--
ALTER TABLE `userkategorinilai`
  ADD CONSTRAINT `userkategorinilai_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `userkategorinilai_ibfk_2` FOREIGN KEY (`id_kategorinilai`) REFERENCES `kategorinilai` (`id_kategorinilai`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
