-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2023 at 07:29 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_details`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_detail`
--

CREATE TABLE `car_detail` (
  `Vehicle_ID` varchar(255) NOT NULL,
  `Vehicle_Model` varchar(255) DEFAULT NULL,
  `Vehicle_Type` varchar(255) DEFAULT NULL,
  `Vehicle_Color` varchar(255) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_detail`
--

INSERT INTO `car_detail` (`Vehicle_ID`, `Vehicle_Model`, `Vehicle_Type`, `Vehicle_Color`, `Price`) VALUES
('V001', 'Rolls', 'Luxurious', 'Blue', 9800),
('V002', 'Bentley Continental Flying Spur', 'Luxurious', 'White', 4800),
('V003', 'Mercedes Benz CLS 350', 'Luxurious', 'Silver', 1350),
('V004', 'Jaguar S Type', 'Luxurious', 'Champagne', 1350),
('V005', 'Ferrari F430 Scuderia', 'Sports', 'Red', 6000),
('V006', 'Lamborghini Murcielago LP640', 'Sports', 'Matte Black', 7000),
('V007', 'Porsche Boxster', 'Sports', 'White', 2800),
('V008', 'Lexus SC430', 'Sports', 'Black', 1600),
('V009', 'Jaguar MK 2', 'Classics', 'White', 2200),
('V010', 'Rolls Royce Silver Spirit Limousine', 'Classics', 'Georgian Silver', 3200),
('V011', 'MG TD', 'Classics', 'Red', 2500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_detail`
--
ALTER TABLE `car_detail`
  ADD PRIMARY KEY (`Vehicle_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
