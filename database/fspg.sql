-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2023 at 09:37 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fspg`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=257 ;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id_peserta`, `peserta`, `jemaat`, `wilayah`, `id_rayon`, `kelamin`, `nomortalent`) VALUES
(173, 'FIRDAUS RANOTONGKOR', '', 'TANAWANGKO I', 3, '', 1),
(174, 'MAHANAIM SAWANGAN', '', 'SONDER', 3, '', 2),
(175, 'BAITEL KEMA II', '', 'KEMA', 3, '', 3),
(176, 'SYALOM DENDENGAN DALAM', '', 'MANADO TIMUR II', 3, '', 4),
(177, 'IMANUEL SAGRAT', '', 'BITUNG VII', 3, '', 5),
(178, 'AGAPE MALENDENG', '', 'MANADO TIMUR V', 3, '', 6),
(179, 'EXODUS WATULINEY', '', 'BELANG', 3, '', 7),
(180, 'SESAWI WATUTUMOU ', '', 'KALAWAT I', 3, '', 8),
(181, 'ANDREAS BANJER', '', 'MANADO TIMUR I', 3, '', 9),
(182, 'SANGKAKALA MALALAYANG I', '', 'MANADO MALALAYANG TIMUR', 3, '', 10),
(183, 'BAPA ABRAHAM TATAARAN PATAR', '', 'TONDANO III', 3, '', 11),
(184, 'DALO SU RUATA KOMBOS TIMUR', '', 'MANADO WAWONASA KOMBOS', 3, '', 12),
(185, 'YARDEN SINGKIL KAMPUNG ISLAM', '', 'MANADO UTARA I', 3, '', 13),
(186, 'GETSEMANI BAILANG', '', 'MANADO UTARA III', 3, '', 14),
(187, 'SILOAM TATAARAN II', '', 'TONDANO VI', 3, '', 15),
(188, 'KALVARI TALAITAD', '', 'TARERAN II', 3, '', 16),
(189, 'PETRA WANGURER BARAT', '', 'BITUNG VIII', 3, '', 17),
(190, 'TORSINA KEMBES', '', 'KEMBES', 3, '', 18),
(191, 'MORIA SASARAN', '', 'TONDANO VI', 3, '', 19),
(192, 'HOSANA WAWONASA', '', 'MANADO WAWONASA', 3, '', 20),
(193, 'BAITEL ERIS', '', 'TANDENGAN', 3, '', 21),
(194, 'SION NOONGAN', '', 'LANGOWAN KELELONDEI', 3, '', 22),
(195, 'BAITANI KOPIWANGKER', '', 'LANGOWAN IV', 3, '', 23),
(196, 'KASIH KARUNIA PANCURAN', '', 'MANADO MALALAYANG TIMUR', 3, '', 24),
(197, 'SENTRUM MANADO', '', 'MANADO SENTRUM', 3, '', 25),
(198, 'EKLESIA PANDU', '', 'MANADO MAPANGET TUMPA II', 3, '', 26),
(199, 'BUKIT ZAITUN PANCURAN ATAS SINGKIL', '', 'MANADO UTARA I', 3, '', 27),
(200, 'IMANUEL BAHU', '', 'MANADO BARAT DAYA', 3, '', 28),
(201, 'EBEN HAEZER AMPRENG', '', 'LANGOWAN KELELONDEI', 3, '', 29),
(202, 'BUKIT KARMEL KAKENTURAN', '', 'BITUNG I', 3, '', 30),
(203, 'RIEDEL KEMBES', '', 'KEMBES', 3, '', 31),
(204, 'BETANIA SINDULANG SINGKIL', '', 'MANADO UTARA I', 3, '', 32),
(205, 'TASIK WANGURER', '', 'BITUNG VIII', 3, '', 33),
(206, 'BUKIT SION AIRMADIDI ATAS', '', 'AIRMADIDI III', 3, '', 34),
(207, 'MARKUS KINILOW', '', 'LOKON EMPUNG', 3, '', 35),
(208, 'BAITEL TENDEKI', '', 'BITUNG XI', 3, '', 36),
(209, 'KALVARI WANGURER', '', 'BITUNG VIII', 3, '', 37),
(210, 'SION SENTRUM SENDANGAN', '', 'KAWANGKOAN', 3, '', 38),
(211, 'YERUSALEM BATUKOTA', '', 'MANADO BARAT DAYA', 3, '', 39),
(212, 'PAULUS TITIWUNGEN WENANG MAHAKERET', '', 'MANADO TITIWUNGEN', 3, '', 40),
(213, 'TANJUNG PASIR PAAL IV', '', 'MANADO TIMUR IV', 3, '', 41),
(214, 'SILOAM DENDENGAN LUAR', '', 'MANADO TIMUR I', 3, '', 42),
(215, 'TRIFENA KAASAR', '', 'MINAWEROT I', 3, '', 43),
(216, 'MARANATHA SARONGSONG', '', 'AIRMADIDI III', 3, '', 44),
(217, 'WALETA PINELENG', '', 'PINELENG', 3, '', 45),
(218, 'KANAAN KULO', '', 'TONDANO V', 3, '', 46),
(219, 'EBEN HAEZER MASARANG', '', 'TONDANO II', 3, '', 47),
(220, 'SION TUMALUNTUNG', '', 'MINAWEROT I', 3, '', 48),
(221, 'ANUGERAH TATELU', '', 'TATELU', 3, '', 49),
(222, 'SUMBER BERKAT MALALAYANG I', '', 'MANADO MALALAYANG', 3, '', 50),
(223, 'EBEN HAEZER TAWARIKH', '', 'MANADO TENGGARA', 3, '', 51),
(224, 'SYALOM RARINGIS', '', 'LANGOWAN KELELONDEI', 3, '', 52),
(225, 'EBEN HAEZER KOMBOS', '', 'MANADO WAWONASA KOMBOS', 3, '', 53),
(226, 'MARTURIA ROONG', '', 'TONDANO II', 3, '', 54),
(227, 'BUKIT KARMEL MAPANGET', '', 'MAPANGET II', 3, '', 55),
(228, 'PAULUS TONSARU', '', 'TONDANO III', 3, '', 56),
(229, 'FIRDAUS MAYONDI TUMINTING', '', 'MANADO UTARA II', 3, '', 57),
(230, 'SION WAREMBUNGAN', '', 'WAREMBUNGAN', 3, '', 58),
(231, 'EBEN HAEZER BUMI BERINGIN', '', 'MANADO TELING', 3, '', 59),
(232, 'DAMAI BELANG I', '', 'BELANG', 3, '', 60),
(233, 'EKLESIA TATELU RONDOR', '', 'TATELU I', 3, '', 61),
(234, 'IMANUEL SENDANGAN', '', 'KAKAS I', 3, '', 62),
(235, 'ELOHIM KOLONGAN I', '', 'TOMOHON I', 3, '', 63),
(236, 'GETSEMANI SENDUK', '', 'TANAWANGKO II', 3, '', 64),
(237, 'SOLAFIDE KALI', '', 'PINELENG', 3, '', 65),
(238, 'ABRAHAM TATAARAN PATAR', '', 'TONDANO III', 3, '', 66),
(239, 'KASIH KRISTUS', '', 'MINAWEROT', 3, '', 67),
(240, 'KINILOW YERUSALEM', '', 'LOKON EMPUNG', 3, '', 68),
(241, 'SENTRUM BITUNG', '', 'BITUNG I', 3, '', 69),
(242, 'TUMOUTOU KENDIS', '', 'TONDANO I', 3, '', 70),
(243, 'ELIM SULUAN', '', 'TOMOHON V', 3, '', 71),
(244, 'PNIEL BAHU', '', 'MANADO BARAT DAYA', 3, '', 72),
(245, 'GETSEMANI PAAL IV', '', 'MANADO TIMUR IV', 3, '', 73),
(246, 'ZEBAOTH KAIRAGI', '', 'MANADO TIMUR III', 3, '', 74),
(247, 'KALVARI PURI MANADO PERMAI BENGKOL', '', 'MANADO MAPANGET TUMPA II', 3, '', 75),
(248, 'BUKIT ZAITUN MALALAYANG', '', 'MANADO MALALAYANG', 3, '', 76),
(249, 'EBEN HAEZER KOMBI', '', 'LEMBEAN KOMBI', 3, '', 77),
(250, 'EBEN HAEZER BUNTONG', '', 'MANDOLANG II', 3, '', 78),
(251, 'BAITANI PASLATEN', '', 'MINAWEROT I', 3, '', 79),
(252, 'DIASPORA PERUM BHAYANGKARA BUHA PERMAI', '', 'MANADO MAPANGET TUMPA I', 3, '', 80),
(253, 'GUNUNG ARARAT BUHA', '', 'MANADO MAPANGET TUMPA I', 3, '', 81),
(254, 'KALVARI MALALAYANG', '', 'MANADO MALALAYANG', 3, '', 82),
(255, 'PNIEL KAIRAGI', '', 'MANADO TIMUR III', 3, '', 83),
(256, 'HIDUP BARU MAESA UNIMA', '', 'TONDANO III', 3, '', 84);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=256 ;

--
-- Dumping data for table `pesertakategorinilai`
--

INSERT INTO `pesertakategorinilai` (`id_pesertakategorinilai`, `id_peserta`, `id_kategorinilai`) VALUES
(172, 173, 8),
(173, 174, 8),
(174, 175, 8),
(175, 176, 8),
(176, 177, 8),
(177, 178, 8),
(178, 179, 8),
(179, 180, 8),
(180, 181, 8),
(181, 182, 8),
(182, 183, 8),
(183, 184, 8),
(184, 185, 8),
(185, 186, 8),
(186, 187, 8),
(187, 188, 8),
(188, 189, 8),
(189, 190, 8),
(190, 191, 8),
(191, 192, 8),
(192, 193, 8),
(193, 194, 8),
(194, 195, 8),
(195, 196, 8),
(196, 197, 8),
(197, 198, 8),
(198, 199, 8),
(199, 200, 8),
(200, 201, 8),
(201, 202, 8),
(202, 203, 8),
(203, 204, 8),
(204, 205, 8),
(205, 206, 8),
(206, 207, 8),
(207, 208, 8),
(208, 209, 8),
(209, 210, 8),
(210, 211, 8),
(211, 212, 8),
(212, 213, 8),
(213, 214, 8),
(214, 215, 8),
(215, 216, 8),
(216, 217, 8),
(217, 218, 8),
(218, 219, 8),
(219, 220, 8),
(220, 221, 8),
(221, 222, 8),
(222, 223, 8),
(223, 224, 8),
(224, 225, 8),
(225, 226, 8),
(226, 227, 8),
(227, 228, 8),
(228, 229, 8),
(229, 230, 8),
(230, 231, 8),
(231, 232, 8),
(232, 233, 8),
(233, 234, 8),
(234, 235, 8),
(235, 236, 8),
(236, 237, 8),
(237, 238, 8),
(238, 239, 8),
(239, 240, 8),
(240, 241, 8),
(241, 242, 8),
(242, 243, 8),
(243, 244, 8),
(244, 245, 8),
(245, 246, 8),
(246, 247, 8),
(247, 248, 8),
(248, 249, 8),
(249, 250, 8),
(250, 251, 8),
(251, 252, 8),
(252, 253, 8),
(253, 254, 8),
(254, 255, 8),
(255, 256, 8);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `rayon`
--

INSERT INTO `rayon` (`id_rayon`, `rayon`, `keterangan`) VALUES
(1, 'Kalawat Raya', 'Kalawat Raya'),
(2, 'Minawerot', ''),
(3, 'Sinode GMIM', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userkategorinilai`
--

INSERT INTO `userkategorinilai` (`id_userkategorinilai`, `id_user`, `id_kategorinilai`) VALUES
(4, 'tiffanymoningka', 8);

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
('administrator', '8052cd54fbfb948b9847cc151e5a52e6', 'Administrator', 1, '', '', NULL, 1, 'T', '41f83316477477a0bc03ac954c9a251b'),
('dummytesting', '8052cd54fbfb948b9847cc151e5a52e6', 'Admin Pemuda', 3, '', '', NULL, 2, 'T', '01601da7b3a79ca9d8198fd46c5cf44a'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

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
