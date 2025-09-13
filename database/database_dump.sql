-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2025 at 06:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `item`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `date_added` date NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item`, `quantity`, `date_added`, `price`) VALUES
(1, 'XBOX Series S', 1, '2025-09-12', 0.00),
(2, 'XBOX Series X', 17, '2025-09-12', 0.00),
(3, 'Playstation 5', 4, '2025-09-12', 0.00),
(4, 'GeForce 4090', 3, '2025-09-12', 0.00),
(5, 'Nintendo Switch OLED', 1, '2025-09-12', 0.00),
(6, 'LEGION LOG', 1, '2025-09-12', 0.00),
(7, 'ASUS TUF 15', 3, '2025-09-12', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `item_maintenance`
--

CREATE TABLE `item_maintenance` (
  `id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item_maintenance`
--

INSERT INTO `item_maintenance` (`id`, `item`, `price`, `date_added`) VALUES
(1, 'XBOX Series S', 30000.00, '2025-09-12'),
(2, 'XBOX Series 5', 24000.00, '2025-09-12'),
(3, 'Playstation 5', 30000.00, '2025-09-12'),
(4, 'GeForce 4090', 110000.00, '2025-09-12'),
(5, 'Nintendo Switch OLED', 30000.00, '2025-09-12'),
(12, 'LEGION', 70000.00, '2025-09-12'),
(13, 'MacBook Pro 14-inch', 91000.00, '2025-09-12'),
(19, 'ASUS TUF 15', 45000.00, '2025-09-12');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_sales` decimal(10,2) NOT NULL,
  `date_tendered` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `item`, `quantity`, `total_sales`, `date_tendered`) VALUES
(3, 'XBOX Series S', 5, 150000.00, '2025-09-12'),
(5, 'XBOX Series S', 1, 30000.00, '2025-09-12'),
(6, 'Playstation 5', 3, 90000.00, '2025-09-12'),
(7, 'Playstation 5', 4, 120000.00, '2025-09-12'),
(8, 'Nintendo Switch OLED', 1, 30000.00, '2025-09-12'),
(9, 'GeForce 4090', 2, 220000.00, '2025-09-12'),
(10, 'ASUS TUF 15', 2, 90000.00, '2025-09-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_maintenance`
--
ALTER TABLE `item_maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `item_maintenance`
--
ALTER TABLE `item_maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
