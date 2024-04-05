-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 04:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_attendancexstaff`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendanceID` int(255) NOT NULL,
  `employeeID` int(200) NOT NULL,
  `date` date NOT NULL,
  `timeIn` time DEFAULT NULL,
  `timeOut` time DEFAULT NULL,
  `statusID` int(50) DEFAULT NULL,
  `workhoursID` int(50) DEFAULT NULL,
  `worktime_statusID` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`attendanceID`, `employeeID`, `date`, `timeIn`, `timeOut`, `statusID`, `workhoursID`, `worktime_statusID`) VALUES
(7, 4, '2024-04-05', '20:41:02', '20:41:06', 1, 1, 2),
(8, 15, '2024-04-05', '20:41:36', '20:41:38', 2, 1, 3),
(9, 4, '2024-04-06', '20:42:50', '20:42:52', 2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `statusID` int(10) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`statusID`, `status`) VALUES
(1, 'PRESENT'),
(2, 'LATE'),
(3, 'ABSENT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_workhours`
--

CREATE TABLE `tbl_workhours` (
  `workhoursID` int(200) NOT NULL,
  `workhours` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_workhours`
--

INSERT INTO `tbl_workhours` (`workhoursID`, `workhours`) VALUES
(1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_worktime_status`
--

CREATE TABLE `tbl_worktime_status` (
  `worktime_statusID` int(255) NOT NULL,
  `worktime_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_worktime_status`
--

INSERT INTO `tbl_worktime_status` (`worktime_statusID`, `worktime_status`) VALUES
(1, 'NORMAL'),
(2, 'OVERTIME'),
(3, 'UNDERTIME');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendanceID`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`statusID`);

--
-- Indexes for table `tbl_workhours`
--
ALTER TABLE `tbl_workhours`
  ADD PRIMARY KEY (`workhoursID`);

--
-- Indexes for table `tbl_worktime_status`
--
ALTER TABLE `tbl_worktime_status`
  ADD PRIMARY KEY (`worktime_statusID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `attendanceID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `statusID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_workhours`
--
ALTER TABLE `tbl_workhours`
  MODIFY `workhoursID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_worktime_status`
--
ALTER TABLE `tbl_worktime_status`
  MODIFY `worktime_statusID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
