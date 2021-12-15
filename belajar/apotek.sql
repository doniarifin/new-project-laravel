-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2021 at 04:57 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek`
--

-- --------------------------------------------------------

--
-- Table structure for table `bentuk`
--

CREATE TABLE `bentuk` (
  `id` int(11) NOT NULL,
  `bentuk` varchar(32) NOT NULL,
  `harga` varchar(32) NOT NULL,
  `expired` date NOT NULL,
  `id_petunjuk_pemakaian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bentuk`
--

INSERT INTO `bentuk` (`id`, `bentuk`, `harga`, `expired`, `id_petunjuk_pemakaian`) VALUES
(9, 'kapsul', 'Rp12000', '2023-12-15', 1),
(10, 'sirup', 'Rp15000', '2023-12-15', 2),
(11, 'kaplet', 'Rp5000', '2022-03-18', 4),
(12, 'tablet', 'Rp5000', '2022-05-13', 3),
(13, 'sirup', 'Rp12000', '2024-03-22', 4);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `bahan_aktif` varchar(108) NOT NULL,
  `manfaat` text NOT NULL,
  `dikonsumsi_oleh` text NOT NULL,
  `id_bentuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama`, `bahan_aktif`, `manfaat`, `dikonsumsi_oleh`, `id_bentuk`) VALUES
(1, 'Panadol', 'paracetamol 500mg', 'meredakan demam, sakit kepala, s', '> usia 15 tahun', 9),
(2, 'Tempra sirup', 'paracetamol 250mg', 'meredakan demam, sakit kepala, dan nyeri untuk anak-anak', '> usia 1 tahun', 10),
(4, 'Procold', 'Paracetamol 500 mg, Phenylephrine HCl 10 mg.', 'meringankan gejala flu seperti demam, sakit kepala, hidung tersumbat, dan batuk tidak berdahak', '> usia 15 tahun', 11),
(6, 'Promag ', 'hydrotalcite 200mg, magnesium hidroksida 150mg', 'Mengatasi sakit maag, GERD, dan perut kembung', '> usia 9 tahun', 12),
(7, 'Siladex', 'Bromhexine HCl 10 mg, Guaifenesin 50 mg\r\n', 'Meredakan batuk berdahak dan mempermudah pengeluaran dahak.', '> usia 9 tahun', 10);

-- --------------------------------------------------------

--
-- Table structure for table `petunjuk`
--

CREATE TABLE `petunjuk` (
  `id` int(11) NOT NULL,
  `usia 5-9` varchar(64) DEFAULT NULL,
  `usia 9-15` varchar(64) DEFAULT NULL,
  `usia 15 keatas` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petunjuk`
--

INSERT INTO `petunjuk` (`id`, `usia 5-9`, `usia 9-15`, `usia 15 keatas`) VALUES
(1, NULL, NULL, '3x2 sehari'),
(2, '2 x sehari 1 sendok takar (5ml)', '3 x sehari 2 sendok takar (10ml)', NULL),
(3, NULL, '2x1 sehari sebelum makan', '3x1 sehari sebelum makan'),
(4, NULL, NULL, '3x1 sehari setelah makan'),
(5, NULL, NULL, '3x2 sendok teh sehari');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bentuk`
--
ALTER TABLE `bentuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_petunjuk` (`id_petunjuk_pemakaian`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bentuk` (`id_bentuk`);

--
-- Indexes for table `petunjuk`
--
ALTER TABLE `petunjuk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bentuk`
--
ALTER TABLE `bentuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `petunjuk`
--
ALTER TABLE `petunjuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bentuk`
--
ALTER TABLE `bentuk`
  ADD CONSTRAINT `fk_petunjuk` FOREIGN KEY (`id_petunjuk_pemakaian`) REFERENCES `petunjuk` (`id`);

--
-- Constraints for table `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `fk_bentuk` FOREIGN KEY (`id_bentuk`) REFERENCES `bentuk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
