-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 27, 2025 at 03:00 AM
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
-- Database: `bangiay_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `BrandID` int(11) NOT NULL,
  `BrandName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`BrandID`, `BrandName`) VALUES
(1, 'Converse'),
(2, 'Nike'),
(3, 'BirkenStock'),
(4, 'Adidas'),
(5, 'Teva'),
(6, 'Fila');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Size` varchar(10) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `AddedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `UserID`, `ProductID`, `Size`, `Quantity`, `AddedAt`) VALUES
(1, 1, 1, '36', 2, '2024-04-01 15:00:00'),
(2, 2, 2, '28', 1, '2024-04-02 16:30:00'),
(3, 3, 3, '41', 1, '2024-04-03 17:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`) VALUES
(1, 'Sneaker'),
(2, 'Sandal'),
(3, 'Kid');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmployeeID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Fullname` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Address` text DEFAULT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `PermissionID` int(11) DEFAULT NULL,
  `isActivate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmployeeID`, `Username`, `Fullname`, `PhoneNumber`, `Email`, `Address`, `PasswordHash`, `CreatedAt`, `PermissionID`, `isActivate`) VALUES
(1, 'admin1', 'Nguyễn Văn A', '0925123456', 'admin1@gmail.com', '56 Nguyễn Trãi, Thanh Xuân, Hà Nội', 'hashadmin1', '2024-01-01 08:00:00', 1, 1),
(2, 'sale1', 'Trần Thị Bích', '0945123456', 'sale1@gmail.com', '89 Lê Lợi, TP Huế', 'hashsale1', '2024-01-02 09:00:00', 2, 0),
(3, 'kho1', 'Phạm Văn Cường', '0965123456', 'kho1@gmail.com', '12 Tôn Đức Thắng, TP Đà Nẵng', 'hashkho1', '2024-01-03 10:00:00', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `function`
--

CREATE TABLE `function` (
  `FunctionID` int(11) NOT NULL,
  `FunctionDescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `function`
--

INSERT INTO `function` (`FunctionID`, `FunctionDescription`) VALUES
(1, 'Quản lý sản phẩm'),
(2, 'Quản lý đơn hàng'),
(3, 'Quản lý kho');

-- --------------------------------------------------------

--
-- Table structure for table `import`
--

CREATE TABLE `import` (
  `ImportID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Total` decimal(10,2) DEFAULT 0.00,
  `ImportDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `importdetail`
--

CREATE TABLE `importdetail` (
  `ImportDetailID` int(11) NOT NULL,
  `ImportID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `ProductSizeID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `OrderDetailID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Size` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`OrderDetailID`, `OrderID`, `ProductID`, `Quantity`, `Size`) VALUES
(1, 1, 4, 2, '36'),
(2, 2, 2, 1, '38'),
(3, 3, 3, 1, '41');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `OrderDate` datetime DEFAULT current_timestamp(),
  `ShippingAddress` text DEFAULT NULL,
  `Province` varchar(50) DEFAULT NULL,
  `Ward` varchar(50) DEFAULT NULL,
  `PaymentStatus` varchar(20) DEFAULT 'Pending',
  `EmployeeID` int(11) DEFAULT NULL,
  `ExportDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `OrderDate`, `ShippingAddress`, `Province`, `Ward`, `PaymentStatus`, `EmployeeID`, `ExportDate`) VALUES
(1, 1, '2024-04-05 10:00:00', '123 Đường Láng, Đống Đa', 'Hà Nội', 'Láng Thượng', 'Processed', NULL, NULL),
(2, 2, '2024-04-06 11:30:00', '45 Nguyễn Huệ', 'Thừa Thiên Huế', 'Phú Nhuận', 'Pending', NULL, NULL),
(3, 3, '2024-04-07 14:00:00', '78 Phạm Văn Đồng', 'Đà Nẵng', 'Hòa Khánh', 'Cancelled', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paymentdetail`
--

CREATE TABLE `paymentdetail` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `CardOwner` varchar(100) DEFAULT NULL,
  `CardNumber` varchar(20) DEFAULT NULL,
  `CVV` varchar(4) DEFAULT NULL,
  `ExpiryDate` date DEFAULT NULL,
  `PaymentDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `PermissionID` int(11) NOT NULL,
  `PermissionName` varchar(50) NOT NULL,
  `FunctionID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`PermissionID`, `PermissionName`, `FunctionID`) VALUES
(1, 'Admin', 1),
(2, 'Nhân viên bán hàng', 2),
(3, 'Nhân viên kho', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `BrandID` int(11) NOT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `IsDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `CategoryID`, `BrandID`, `Gender`, `Price`, `ImageURL`, `CreatedAt`, `IsDeleted`) VALUES
(1, '70 COURT CANVAS HI', 1, 1, 'U', 2000000.00, './view/layout/asset/img/catalogue/70-COURT-CANVAS-HI.jpg', '2025-03-06 08:27:41', 0),
(2, 'AIR FLIGHT 89 (GS)', 1, 2, 'M', 2400000.00, './view/layout/asset/img/catalogue/AIR-FLIGHT-89-(GS).jpg', '2025-03-06 08:27:41', 0),
(3, 'AIR FORCE 1 LV8-3 (GS)', 1, 2, 'U', 3200000.00, './view/layout/asset/img/catalogue/AIR-FORCE-1-LV8-3-(GS).jpg', '2025-03-06 08:27:41', 0),
(4, 'AIR FORCE 1\'07', 1, 2, 'U', 3500000.00, './view/layout/asset/img/catalogue/AIR-FORCE-1\'07.jpg', '2025-03-06 08:27:41', 0),
(5, 'AIR MAX 90 LTR', 1, 2, 'M', 4600000.00, './view/layout/asset/img/catalogue/AIR-MAX-90-LTR.jpg', '2025-03-06 08:27:41', 0),
(6, 'AIR TERRRA HUMARA', 1, 2, 'M', 3200000.00, './view/layout/asset/img/catalogue/AIR-TERRA-HUMARA.jpg', '2025-03-06 08:27:41', 0),
(7, 'AIRIZONA VEG THYME', 2, 3, 'M', 3500000.00, './view/layout/asset/img/catalogue/AIRIZONA-VEG-THYME.jpg', '2025-03-06 08:27:41', 0),
(8, 'ARIZONA BLACKBIRKO FLOR SFB', 2, 3, 'M', 3200000.00, './view/layout/asset/img/catalogue/ARIZONA-BLACKBIRKO-FLOR-SFB.jpg', '2025-03-06 08:27:41', 0),
(9, 'ARIZONA TOBACCO BROWN OILDED LEATHER', 2, 3, 'M', 4000000.00, './view/layout/asset/img/catalogue/ARIZONA-TOBACCO-BROWN-OILED-LEATHER.jpg', '2025-03-06 08:27:41', 0),
(10, 'CHUCK 70 SEASONAL', 1, 1, 'M', 1650000.00, './view/layout/asset/img/catalogue/CHUCK-70-SEASONAL.jpg', '2025-03-06 08:27:41', 0),
(11, 'DUNK LOW (W)', 1, 2, 'M', 3500000.00, './view/layout/asset/img/catalogue/DUNK-LOW-(W).jpg', '2025-03-06 08:27:41', 0),
(12, 'FASTBREAK PRO SUEDE MID', 1, 1, 'M', 2800000.00, './view/layout/asset/img/catalogue/FASTBREAK-PRO-SUEDE-MID.jpg', '2025-03-06 08:27:41', 0),
(13, 'FENG CHENG WANG QS', 1, 1, 'U', 4200000.00, './view/layout/asset/img/catalogue/FENG-CHENG-WANG-QS.jpg', '2025-03-06 08:27:41', 0),
(14, 'GAZELLE (PS)', 3, 4, 'U', 1800000.00, './view/layout/asset/img/catalogue/GAZELLE-(PS).jpg', '2025-03-06 08:27:41', 0),
(15, 'GAZELLE INDOOR (W)', 1, 4, 'F', 2800000.00, './view/layout/asset/img/catalogue/GAZELLE-INDOOR-(W).jpg', '2025-03-06 08:27:41', 0),
(16, 'HANDBALL SPEZIAL (W)', 1, 4, 'F', 2500000.00, './view/layout/asset/img/catalogue/HANDBALL-SPEZIAL-(W).jpg', '2025-03-06 08:27:41', 0),
(17, 'NIKE CALM BEIGE (W)', 2, 2, 'F', 2349000.00, './view/layout/asset/img/catalogue/Nike_Calm_Be(w).jpg', '2025-03-06 08:27:41', 0),
(18, 'NMD S1', 1, 4, 'M', 3000000.00, './view/layout/asset/img/catalogue/NMD_S1.jpg', '2025-03-06 08:27:41', 0),
(19, 'RUN STAR HIKE HI', 1, 1, 'U', 3200000.00, './view/layout/asset/img/catalogue/RUN-STAR-HIKE-HI.jpg', '2025-03-06 08:27:41', 0),
(20, 'SAMBA OG', 1, 4, 'U', 2500000.00, './view/layout/asset/img/catalogue/SAMBA-OG.jpg', '2025-03-06 08:27:41', 0),
(21, 'SABA XLG', 1, 4, 'M', 3500000.00, './view/layout/asset/img/catalogue/SAMBA-XLG.jpg', '2025-03-06 08:27:41', 0),
(22, 'SL72 RS (PS)', 3, 4, 'U', 2000000.00, './view/layout/asset/img/catalogue/SL-72-RS-(PS).jpg', '2025-03-06 08:27:41', 0),
(23, 'SL72 RS (TD)', 3, 4, 'U', 1800000.00, './view/layout/asset/img/catalogue/SL72-RS-(TD).jpg', '2025-03-06 08:27:41', 0),
(24, 'SL72 RS', 1, 4, 'M', 2500000.00, './view/layout/asset/img/catalogue/SL72-RS.jpg', '2025-03-06 08:27:41', 0),
(25, 'STAN SMITH (TD)', 3, 4, 'U', 1500000.00, './view/layout/asset/img/catalogue/STAN-SMITH-(TD).jpg', '2025-03-06 08:27:41', 0),
(26, 'SUPERSTAR', 1, 4, 'M', 2500000.00, './view/layout/asset/img/catalogue/SUPERSTAR.jpg', '2025-03-06 08:27:41', 0),
(27, 'TEVA HURRICANE DRIFT (M)', 2, 5, 'M', 990000.00, './view/layout/asset/img/catalogue/Teva_Hurricane_Drift(m)-990k.jpg', '2025-03-06 08:27:41', 0),
(28, 'TEVA TERRA FI 5 UNIVERSAL', 2, 5, 'M', 2099000.00, './view/layout/asset/img/catalogue/Teva_Terra_Fi_5_Universal-2099k.jpg', '2025-03-06 08:27:41', 0),
(29, 'TEVA VOYA STRAPPY (W)', 2, 5, 'F', 845000.00, './view/layout/asset/img/catalogue/Teva_Voya_Strappy(w)-845k.jpg', '2025-03-06 08:27:41', 0),
(30, 'TEVA ZYMIC (W)', 2, 5, 'F', 1600000.00, './view/layout/asset/img/catalogue/Teva_Zymic-1600k(w).jpg', '2025-03-06 08:27:41', 0),
(31, 'TEVA SANDALS HURRICANE (W)', 2, 5, 'F', 1900000.00, './view/layout/asset/img/catalogue/TevaSandalsHunrricane(w).jpg', '2025-03-06 08:27:41', 0),
(32, 'UNISEX FILA PONG SD (W)', 2, 6, 'F', 1595000.00, './view/layout/asset/img/catalogue/Unisex_Fila_Pong_Sd-1595k(w).jpg', '2025-03-06 08:27:41', 0),
(33, 'UNISEX FILA TORI (M)', 2, 6, 'M', 1995000.00, './view/layout/asset/img/catalogue/unisex_fila_tori-1995k(m).jpg', '2025-03-06 08:27:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productsize`
--

CREATE TABLE `productsize` (
  `ProductSizeID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Size` varchar(10) DEFAULT NULL,
  `StockQuantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productsize`
--

INSERT INTO `productsize` (`ProductSizeID`, `ProductID`, `Size`, `StockQuantity`) VALUES
(1, 1, '36', 50),
(2, 1, '37', 30),
(3, 1, '38', 20),
(4, 1, '41', 15),
(5, 1, '42', 10),
(6, 2, '41', 10),
(7, 2, '42', 10),
(8, 2, '43', 10),
(9, 3, '36', 10),
(10, 3, '37', 10),
(11, 3, '38', 10),
(12, 3, '41', 10),
(13, 3, '42', 10),
(14, 4, '36', 10),
(15, 4, '37', 10),
(16, 4, '38', 10),
(17, 4, '41', 10),
(18, 4, '42', 10),
(19, 5, '41', 10),
(20, 5, '42', 10),
(21, 5, '43', 10),
(22, 6, '41', 10),
(23, 6, '42', 10),
(24, 6, '43', 10),
(25, 7, '41', 10),
(26, 7, '42', 10),
(27, 7, '43', 10),
(28, 8, '41', 10),
(29, 8, '42', 10),
(30, 8, '43', 10),
(31, 9, '41', 10),
(32, 9, '42', 10),
(33, 9, '43', 10),
(34, 10, '41', 10),
(35, 10, '42', 10),
(36, 10, '43', 10),
(37, 11, '41', 10),
(38, 11, '42', 10),
(39, 11, '43', 10),
(40, 12, '41', 10),
(41, 12, '42', 10),
(42, 12, '43', 10),
(43, 13, '36', 10),
(44, 13, '37', 10),
(45, 13, '38', 10),
(46, 13, '41', 10),
(47, 13, '42', 10),
(48, 14, '20', 10),
(49, 14, '21', 10),
(50, 14, '22', 10),
(51, 14, '23', 10),
(52, 14, '24', 10),
(53, 15, '36', 10),
(54, 15, '37', 10),
(55, 15, '38', 10),
(56, 15, '39', 10),
(57, 16, '36', 10),
(58, 16, '37', 10),
(59, 16, '38', 10),
(60, 16, '39', 10),
(61, 17, '36', 10),
(62, 17, '37', 10),
(63, 17, '38', 10),
(64, 17, '39', 10),
(65, 18, '41', 10),
(66, 18, '42', 10),
(67, 18, '43', 10),
(68, 19, '36', 10),
(69, 19, '37', 10),
(70, 19, '38', 10),
(71, 19, '41', 10),
(72, 19, '42', 10),
(73, 20, '36', 10),
(74, 20, '37', 10),
(75, 20, '38', 10),
(76, 20, '41', 10),
(77, 20, '42', 10),
(78, 21, '41', 10),
(79, 21, '42', 10),
(80, 21, '43', 10),
(81, 22, '20', 10),
(82, 22, '21', 10),
(83, 22, '22', 10),
(84, 22, '23', 10),
(85, 22, '24', 10),
(86, 23, '20', 10),
(87, 23, '21', 10),
(88, 23, '22', 10),
(89, 23, '23', 10),
(90, 23, '24', 10),
(91, 24, '41', 10),
(92, 24, '42', 10),
(93, 24, '43', 10),
(94, 25, '20', 10),
(95, 25, '21', 10),
(96, 25, '22', 10),
(97, 25, '23', 10),
(98, 25, '24', 10),
(99, 26, '41', 10),
(100, 26, '42', 10),
(101, 26, '43', 10),
(102, 27, '41', 10),
(103, 27, '42', 10),
(104, 27, '43', 10),
(105, 28, '41', 10),
(106, 28, '42', 10),
(107, 28, '43', 10),
(108, 29, '36', 10),
(109, 29, '37', 10),
(110, 29, '38', 10),
(111, 29, '39', 10),
(112, 30, '36', 10),
(113, 30, '37', 10),
(114, 30, '38', 10),
(115, 30, '39', 10),
(116, 31, '36', 10),
(117, 31, '37', 10),
(118, 31, '38', 10),
(119, 31, '39', 10),
(120, 32, '36', 10),
(121, 32, '37', 10),
(122, 32, '38', 10),
(123, 32, '39', 10),
(124, 33, '41', 10),
(125, 33, '42', 10),
(126, 33, '43', 10);

-- --------------------------------------------------------

--
-- Table structure for table `statistic`
--

CREATE TABLE `statistic` (
  `StatisticID` int(11) NOT NULL,
  `TotalOrder` int(11) DEFAULT NULL,
  `TotalRevenue` decimal(15,2) DEFAULT NULL,
  `TotalCustomers` int(11) DEFAULT NULL,
  `TotalProductsSold` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statistic`
--

INSERT INTO `statistic` (`StatisticID`, `TotalOrder`, `TotalRevenue`, `TotalCustomers`, `TotalProductsSold`) VALUES
(1, 3, 4250000.00, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`) VALUES
(1, 'Công ty TNHH Uniqlo Việt Nam'),
(2, 'Công ty TNHH Levi\'s Việt Nam'),
(3, 'Công ty TNHH Adidas Việt Nam');

-- --------------------------------------------------------

--
-- Table structure for table `supplierproduct`
--

CREATE TABLE `supplierproduct` (
  `SupplierProductID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `ImportPrice` decimal(10,2) NOT NULL,
  `LastUpdated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Fullname` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Address` text DEFAULT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `isActivate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Fullname`, `PhoneNumber`, `Email`, `Address`, `PasswordHash`, `CreatedAt`, `isActivate`) VALUES
(1, 'nguyenminh', 'Nguyễn Minh Anh', '0905123456', 'minhanh@gmail.com', '123 Đường Láng, Đống Đa, Hà Nội', 'hash123', '2024-01-10 10:00:00', 0),
(2, 'tranthanh', 'Trần Thanh Tâm', '0916123456', 'thanhtam@gmail.com', '45 Nguyễn Huệ, TP Huế', 'hash456', '2024-02-15 14:30:00', 1),
(3, 'levan', 'Lê Văn Hùng', '0935123456', 'vanhung@gmail.com', '78 Phạm Văn Đồng, TP Đà Nẵng', 'hash789', '2024-03-20 09:15:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`BrandID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `PermissionID` (`PermissionID`);

--
-- Indexes for table `function`
--
ALTER TABLE `function`
  ADD PRIMARY KEY (`FunctionID`);

--
-- Indexes for table `import`
--
ALTER TABLE `import`
  ADD PRIMARY KEY (`ImportID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `importdetail`
--
ALTER TABLE `importdetail`
  ADD PRIMARY KEY (`ImportDetailID`),
  ADD KEY `ImportID` (`ImportID`),
  ADD KEY `SupplierID` (`SupplierID`),
  ADD KEY `ProductSizeID` (`ProductSizeID`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`OrderDetailID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `paymentdetail`
--
ALTER TABLE `paymentdetail`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`PermissionID`),
  ADD KEY `FunctionID` (`FunctionID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `BrandID` (`BrandID`);

--
-- Indexes for table `productsize`
--
ALTER TABLE `productsize`
  ADD PRIMARY KEY (`ProductSizeID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `statistic`
--
ALTER TABLE `statistic`
  ADD PRIMARY KEY (`StatisticID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Indexes for table `supplierproduct`
--
ALTER TABLE `supplierproduct`
  ADD PRIMARY KEY (`SupplierProductID`),
  ADD KEY `SupplierID` (`SupplierID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `BrandID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `function`
--
ALTER TABLE `function`
  MODIFY `FunctionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `import`
--
ALTER TABLE `import`
  MODIFY `ImportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `importdetail`
--
ALTER TABLE `importdetail`
  MODIFY `ImportDetailID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paymentdetail`
--
ALTER TABLE `paymentdetail`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `PermissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `productsize`
--
ALTER TABLE `productsize`
  MODIFY `ProductSizeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `statistic`
--
ALTER TABLE `statistic`
  MODIFY `StatisticID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplierproduct`
--
ALTER TABLE `supplierproduct`
  MODIFY `SupplierProductID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`PermissionID`) REFERENCES `permission` (`PermissionID`);

--
-- Constraints for table `import`
--
ALTER TABLE `import`
  ADD CONSTRAINT `import_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Constraints for table `importdetail`
--
ALTER TABLE `importdetail`
  ADD CONSTRAINT `importdetail_ibfk_1` FOREIGN KEY (`ImportID`) REFERENCES `import` (`ImportID`),
  ADD CONSTRAINT `importdetail_ibfk_2` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`),
  ADD CONSTRAINT `importdetail_ibfk_3` FOREIGN KEY (`ProductSizeID`) REFERENCES `productsize` (`ProductSizeID`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Constraints for table `paymentdetail`
--
ALTER TABLE `paymentdetail`
  ADD CONSTRAINT `paymentdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`);

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`FunctionID`) REFERENCES `function` (`FunctionID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`BrandID`) REFERENCES `brand` (`BrandID`);

--
-- Constraints for table `productsize`
--
ALTER TABLE `productsize`
  ADD CONSTRAINT `productsize_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `supplierproduct`
--
ALTER TABLE `supplierproduct`
  ADD CONSTRAINT `supplierproduct_ibfk_1` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplierproduct_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
