-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 05, 2024 at 09:08 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `breakroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(10) NOT NULL,
  `Nama` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `Nama`, `Username`, `Email`, `Password`, `Role`) VALUES
('ADBR001', 'Dio Masafan Mufio Rois', 'mufimasafan', 'mufi@gmail.com', 'root', 'admin'),
('ADBR002', 'Pak vinsen', 'vinsenaldo', 'vinsen@gmail.com', 'root', 'officer'),
('ADBR003', 'Althof Ali Wafa', 'wafa69', 'wafa@gmail.com', 'root', 'admin'),
('ADBR004', 'Riki', 'rik', 'rik@gmail.com', '1', 'officer');

--
-- Triggers `admin`
--
DELIMITER $$
CREATE TRIGGER `before_insert_admin` BEFORE INSERT ON `admin` FOR EACH ROW BEGIN
    DECLARE max_id INT;
    DECLARE new_id VARCHAR(10);
    
    -- Mendapatkan nilai maksimum dari kolom id_admin
    SELECT COALESCE(MAX(CAST(SUBSTRING(id_admin, 5) AS UNSIGNED)), 0) + 1 INTO max_id FROM admin;
    
    -- Membuat id_admin baru dengan format 'ADBR' diikuti dengan angka 3 digit
    SET new_id = CONCAT('ADBR', LPAD(max_id, 3, '0'));
    
    -- Menetapkan nilai id_admin baru
    SET NEW.id_admin = new_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` varchar(10) NOT NULL,
  `Nama` varchar(50) DEFAULT NULL,
  `Member_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `Nama`, `Member_type`) VALUES
('BR0001', 'Dio Masafan Mufio Rois', 'Platinum'),
('BR0002', 'Althof Ali Wafa', 'Silver'),
('BR0003', 'Aldo Vincent', 'Gold'),
('BR0004', 'Abizaki', 'Silver'),
('BR0009', 'Valen Aqsa Juwana', 'Platinum');

-- --------------------------------------------------------

--
-- Table structure for table `tableinfo`
--

CREATE TABLE `tableinfo` (
  `id_table` varchar(10) NOT NULL,
  `Gedung` varchar(50) DEFAULT NULL,
  `Lantai` int DEFAULT NULL,
  `Nomor` varchar(10) DEFAULT NULL,
  `Action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'NoActive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tableinfo`
--

INSERT INTO `tableinfo` (`id_table`, `Gedung`, `Lantai`, `Nomor`, `Action`) VALUES
('A.1.1', 'A', 1, '1', 'Active'),
('A.1.2', 'A', 1, '2', 'Active'),
('A.1.3', 'A', 1, '3', 'NoAction'),
('A.1.4', 'A', 1, '4', 'Active'),
('A.1.5', 'A', 1, '5', 'NoAction'),
('A.1.6', 'A', 1, '6', 'NoAction'),
('A.1.7', 'A', 1, '7', 'NoActive');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id_Transaction` int NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `id_trxTableBilliard` int NOT NULL,
  `Date_checkout` date NOT NULL,
  `Time_checkout` time NOT NULL,
  `Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id_Transaction`, `id_member`, `id_trxTableBilliard`, `Date_checkout`, `Time_checkout`, `Amount`) VALUES
(1, 'BR0001', 18, '2024-05-21', '21:59:07', '35000.00'),
(2, 'BR0003', 19, '2024-05-21', '22:12:33', '35000.00'),
(3, 'BR0001', 20, '2024-05-22', '09:26:08', '0.00'),
(4, 'BR0002', 21, '2024-05-22', '09:27:17', '0.00'),
(5, 'BR0001', 22, '2024-05-22', '09:27:54', '0.00'),
(6, 'BR0004', 23, '2024-05-22', '09:28:34', '35000.00'),
(7, 'BR0002', 24, '2024-05-22', '09:31:00', '3500.00'),
(8, 'BR0004', 25, '2024-05-22', '09:32:42', '9742.00'),
(9, 'BR0001', 26, '2024-05-22', '09:32:43', '19085.00'),
(10, 'BR0001', 27, '2024-05-22', '10:48:18', '4259.00'),
(11, 'BR0001', 28, '2024-05-22', '11:20:04', '2373.00'),
(12, 'BR0004', 29, '2024-05-22', '11:20:05', '1799.00'),
(13, 'BR0003', 30, '2024-05-22', '11:20:05', '4716.00'),
(14, 'BR0002', 32, '2024-06-02', '23:02:27', '846.00'),
(15, 'BR0001', 33, '2024-06-05', '12:15:22', '248277.00'),
(16, 'BR0001', 38, '2024-06-05', '12:22:30', '3481.00'),
(17, 'BR0002', 34, '2024-06-05', '12:22:41', '251835.00'),
(18, 'BR0004', 37, '2024-06-05', '12:22:53', '5834.00'),
(19, 'BR0004', 36, '2024-06-05', '12:23:04', '6203.00'),
(20, 'BR0003', 35, '2024-06-05', '12:23:08', '251864.00'),
(21, 'BR0001', 39, '2024-06-05', '12:23:51', '98.00'),
(22, 'BR0001', 40, '2024-06-05', '12:25:54', '59.00'),
(23, 'BR0001', 41, '2024-06-05', '12:28:48', '30.00'),
(24, 'BR0001', 42, '2024-06-05', '12:33:20', '49.00'),
(25, 'BR0001', 43, '2024-06-05', '12:35:02', '39.00'),
(26, 'BR0001', 44, '2024-06-05', '12:35:18', '39.00'),
(27, 'BR0001', 45, '2024-06-05', '12:38:17', '107.00'),
(28, 'BR0004', 46, '2024-06-05', '12:39:18', '671.00'),
(29, 'BR0002', 47, '2024-06-05', '12:40:43', '1469.00'),
(30, 'BR0004', 48, '2024-06-05', '12:41:33', '107.00'),
(31, 'BR0001', 49, '2024-06-05', '12:41:47', '224.00'),
(32, 'BR0009', 51, '2024-06-05', '12:43:17', '88.00'),
(33, 'BR0004', 50, '2024-06-05', '12:45:12', '2198.00'),
(34, 'BR0004', 52, '2024-06-05', '12:46:53', '1235.00'),
(35, 'BR0004', 53, '2024-06-05', '12:47:48', '1605.00'),
(36, 'BR0004', 54, '2024-06-05', '12:48:55', '273.00'),
(37, 'BR0001', 55, '2024-06-05', '12:49:09', '389.00'),
(38, 'BR0001', 56, '2024-06-05', '12:49:24', '506.00'),
(39, 'BR0001', 57, '2024-06-05', '12:51:10', '1517.00'),
(40, 'BR0001', 58, '2024-06-05', '12:55:02', '30.00'),
(41, 'BR0001', 59, '2024-06-05', '12:56:04', '39.00'),
(42, 'BR0001', 60, '2024-06-05', '13:21:33', '39.00'),
(43, 'BR0004', 61, '2024-06-05', '13:25:00', '584.00'),
(44, 'BR0003', 62, '2024-06-05', '15:00:59', '56555.00');

-- --------------------------------------------------------

--
-- Table structure for table `trxtablebilliard`
--

CREATE TABLE `trxtablebilliard` (
  `id_trxTableBilliard` int NOT NULL,
  `id_member` varchar(10) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `id_table` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trxtablebilliard`
--

INSERT INTO `trxtablebilliard` (`id_trxTableBilliard`, `id_member`, `Date`, `Time`, `id_table`) VALUES
(63, 'BR0001', '2024-06-05', '13:24:04', 'A.1.4'),
(64, 'BR0001', '2024-06-05', '15:00:46', 'A.1.2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `Nama`, `Username`, `Email`, `Password`, `Role`) VALUES
(1, 'Valen Aqsa', 'valen', 'valen@gmail.com', 'valen', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `tableinfo`
--
ALTER TABLE `tableinfo`
  ADD PRIMARY KEY (`id_table`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id_Transaction`);

--
-- Indexes for table `trxtablebilliard`
--
ALTER TABLE `trxtablebilliard`
  ADD PRIMARY KEY (`id_trxTableBilliard`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_table` (`id_table`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id_Transaction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `trxtablebilliard`
--
ALTER TABLE `trxtablebilliard`
  MODIFY `id_trxTableBilliard` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trxtablebilliard`
--
ALTER TABLE `trxtablebilliard`
  ADD CONSTRAINT `trxtablebilliard_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`),
  ADD CONSTRAINT `trxtablebilliard_ibfk_2` FOREIGN KEY (`id_table`) REFERENCES `tableinfo` (`id_table`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
