-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 06, 2025 lúc 09:33 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12
-- Schema link: https://dbdiagram.io/d/67c41b6d263d6cf9a0edcb6e

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `broshoes`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `BrandID` int(11) NOT NULL,
  `BrandName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`BrandID`, `BrandName`) VALUES
(4, 'Adidas'),
(3, 'BirkenStock'),
(1, 'Converse'),
(6, 'Fila'),
(2, 'Nike'),
(5, 'Teva');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Size` int(11) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `AddedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`) VALUES
(3, 'Kid'),
(2, 'Sandal'),
(1, 'Sneaker');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderDetailID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Size` int(11) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetails`
--

INSERT INTO `orderdetails` (`OrderDetailID`, `OrderID`, `ProductID`, `Size`, `Quantity`, `UnitPrice`) VALUES
(1, 1, 1, 41, 1, 2000000.00),
(2, 2, 10, 43, 2, 1650000.00),
(3, 2, 25, 21, 1, 1500000.00),
(4, 3, 22, 20, 1, 2000000.00),
(5, 3, 2, 41, 1, 2400000.00),
(6, 3, 9, 43, 1, 4000000.00),
(7, 4, 18, 42, 1, 3000000.00),
(8, 4, 11, 43, 1, 3500000.00),
(9, 5, 13, 36, 1, 4200000.00),
(10, 5, 16, 37, 1, 2500000.00),
(11, 6, 9, 41, 1, 4000000.00),
(12, 6, 10, 42, 1, 1650000.00),
(13, 7, 27, 41, 1, 990000.00),
(14, 7, 29, 37, 1, 845000.00),
(15, 8, 28, 41, 1, 2099000.00),
(16, 8, 28, 42, 1, 2099000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `TotalAmount` decimal(10,2) NOT NULL,
  `DeliveryFee` decimal(10,2) DEFAULT 0.00,
  `ShippingAddress` text NOT NULL,
  `Province` varchar(50) DEFAULT NULL,
  `District` varchar(50) DEFAULT NULL,
  `Ward` varchar(50) DEFAULT NULL,
  `PaymentMethod` varchar(20) DEFAULT NULL,
  `OrderStatus` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `OrderDate`, `TotalAmount`, `DeliveryFee`, `ShippingAddress`, `Province`, `District`, `Ward`, `PaymentMethod`, `OrderStatus`) VALUES
(1, 1, '2023-03-12 09:16:29', 2000000.00, 30000.00, '120 Elm St, Grandville', 'Hồ Chí Minh', 'Quận 3', 'Phường 10', 'Cash', 'Received'),
(2, 3, '2023-03-12 09:16:29', 3150000.00, 30000.00, '789 Oak Ave, Grandville', 'Cần Thơ', 'Quận Ninh Kiều', 'Phường Tân An', 'Cash', 'Cancelled'),
(3, 11, '2023-03-22 12:09:22', 8400000.00, 30000.00, '707 Redwood St, Grandville', 'Đà Nẵng', 'Quận Hải Châu', 'Phường Hòa Thuận', 'Card', 'Received'),
(4, 1, '2023-07-20 08:45:30', 6500000.00, 30000.00, '120 Elm St, Grandville', 'Hồ Chí Minh', 'Quận 3', 'Phường 10', 'Card', 'Received'),
(5, 7, '2024-05-20 10:21:02', 6700000.00, 30000.00, '303 Cedar Dr, Grandville', 'Huế', 'Thành phố Huế', 'Phường Thuận Hòa', 'Card', 'Cancelled'),
(6, 8, '2024-08-11 12:19:01', 5650000.00, 30000.00, '404 Willow Way, Grandville', 'Hồ Chí Minh', 'Thành phố Thủ Đức', 'Phường Bình Chiểu', 'Card', 'Processed/Delivering'),
(7, 10, '2024-10-21 00:16:31', 1835000.00, 30000.00, '606 Pinecrest Rd, Grandville', 'Hà Nội', 'Quận Hoàn Kiếm', 'Phường Hàng Bông', 'Cash', 'Received'),
(8, 3, '2024-11-20 00:16:31', 4198000.00, 30000.00, '789 Oak Ave, Grandville', 'Cần Thơ', 'Quận Ninh Kiều', 'Phường Tân An', 'Cash', 'Processed/Delivering');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `paymentdetails`
--

CREATE TABLE `paymentdetails` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `CardOwnerName` varchar(100) DEFAULT NULL,
  `CardNumber` varchar(20) DEFAULT NULL,
  `CVV` varchar(4) DEFAULT NULL,
  `ExpiryDate` date DEFAULT NULL,
  `PaymentDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `paymentdetails`
--

INSERT INTO `paymentdetails` (`PaymentID`, `OrderID`, `CardOwnerName`, `CardNumber`, `CVV`, `ExpiryDate`, `PaymentDate`) VALUES
(1, 3, 'BRIAN', '123456789123', '123', NULL, '2025-03-06 08:27:41'),
(2, 4, 'JESSICA', '987654321987', '200', NULL, '2025-03-06 08:27:41'),
(3, 5, 'DAVID', '275283894150', '999', NULL, '2025-03-06 08:27:41'),
(4, 6, 'LAURA', '423515034900', '235', NULL, '2025-03-06 08:27:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `BrandID` int(11) DEFAULT NULL,
  `Gender` char(1) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` text DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `CategoryID`, `BrandID`, `Gender`, `Price`, `Description`, `ImageURL`, `CreatedAt`) VALUES
(1, '70 COURT CANVAS HI', 1, 1, 'U', 2000000.00, NULL, './view/layout/asset/img/catalogue/70-COURT-CANVAS-HI.jpg', '2025-03-06 08:27:41'),
(2, 'AIR FLIGHT 89 (GS)', 1, 2, 'M', 2400000.00, NULL, './view/layout/asset/img/catalogue/AIR-FLIGHT-89-(GS).jpg', '2025-03-06 08:27:41'),
(3, 'AIR FORCE 1 LV8-3 (GS)', 1, 2, 'U', 3200000.00, NULL, './view/layout/asset/img/catalogue/AIR-FORCE-1-LV8-3-(GS).jpg', '2025-03-06 08:27:41'),
(4, 'AIR FORCE 1\'07', 1, 2, 'U', 3500000.00, NULL, './view/layout/asset/img/catalogue/AIR-FORCE-1\'07.jpg', '2025-03-06 08:27:41'),
(5, 'AIR MAX 90 LTR', 1, 2, 'M', 4600000.00, NULL, './view/layout/asset/img/catalogue/AIR-MAX-90-LTR.jpg', '2025-03-06 08:27:41'),
(6, 'AIR TERRRA HUMARA', 1, 2, 'M', 3200000.00, NULL, './view/layout/asset/img/catalogue/AIR-TERRA-HUMARA.jpg', '2025-03-06 08:27:41'),
(7, 'AIRIZONA VEG THYME', 2, 3, 'M', 3500000.00, NULL, './view/layout/asset/img/catalogue/AIRIZONA-VEG-THYME.jpg', '2025-03-06 08:27:41'),
(8, 'ARIZONA BLACKBIRKO FLOR SFB', 2, 3, 'M', 3200000.00, NULL, './view/layout/asset/img/catalogue/ARIZONA-BLACKBIRKO-FLOR-SFB.jpg', '2025-03-06 08:27:41'),
(9, 'ARIZONA TOBACCO BROWN OILDED LEATHER', 2, 3, 'M', 4000000.00, NULL, './view/layout/asset/img/catalogue/ARIZONA-TOBACCO-BROWN-OILED-LEATHER.jpg', '2025-03-06 08:27:41'),
(10, 'CHUCK 70 SEASONAL', 1, 1, 'M', 1650000.00, NULL, './view/layout/asset/img/catalogue/CHUCK-70-SEASONAL.jpg', '2025-03-06 08:27:41'),
(11, 'DUNK LOW (W)', 1, 2, 'M', 3500000.00, NULL, './view/layout/asset/img/catalogue/DUNK-LOW-(W).jpg', '2025-03-06 08:27:41'),
(12, 'FASTBREAK PRO SUEDE MID', 1, 1, 'M', 2800000.00, NULL, './view/layout/asset/img/catalogue/FASTBREAK-PRO-SUEDE-MID.jpg', '2025-03-06 08:27:41'),
(13, 'FENG CHENG WANG QS', 1, 1, 'U', 4200000.00, NULL, './view/layout/asset/img/catalogue/FENG-CHENG-WANG-QS.jpg', '2025-03-06 08:27:41'),
(14, 'GAZELLE (PS)', 3, 4, 'U', 1800000.00, NULL, './view/layout/asset/img/catalogue/GAZELLE-(PS).jpg', '2025-03-06 08:27:41'),
(15, 'GAZELLE INDOOR (W)', 1, 4, 'F', 2800000.00, NULL, './view/layout/asset/img/catalogue/GAZELLE-INDOOR-(W).jpg', '2025-03-06 08:27:41'),
(16, 'HANDBALL SPEZIAL (W)', 1, 4, 'F', 2500000.00, NULL, './view/layout/asset/img/catalogue/HANDBALL-SPEZIAL-(W).jpg', '2025-03-06 08:27:41'),
(17, 'NIKE CALM BEIGE (W)', 2, 2, 'F', 2349000.00, NULL, './view/layout/asset/img/catalogue/Nike_Calm_Be(w).jpg', '2025-03-06 08:27:41'),
(18, 'NMD S1', 1, 4, 'M', 3000000.00, NULL, './view/layout/asset/img/catalogue/NMD_S1.jpg', '2025-03-06 08:27:41'),
(19, 'RUN STAR HIKE HI', 1, 1, 'U', 3200000.00, NULL, './view/layout/asset/img/catalogue/RUN-STAR-HIKE-HI.jpg', '2025-03-06 08:27:41'),
(20, 'SAMBA OG', 1, 4, 'U', 2500000.00, NULL, './view/layout/asset/img/catalogue/SAMBA-OG.jpg', '2025-03-06 08:27:41'),
(21, 'SABA XLG', 1, 4, 'M', 3500000.00, NULL, './view/layout/asset/img/catalogue/SAMBA-XLG.jpg', '2025-03-06 08:27:41'),
(22, 'SL72 RS (PS)', 3, 4, 'U', 2000000.00, NULL, './view/layout/asset/img/catalogue/SL-72-RS-(PS).jpg', '2025-03-06 08:27:41'),
(23, 'SL72 RS (TD)', 3, 4, 'U', 1800000.00, NULL, './view/layout/asset/img/catalogue/SL72-RS-(TD).jpg', '2025-03-06 08:27:41'),
(24, 'SL72 RS', 1, 4, 'M', 2500000.00, NULL, './view/layout/asset/img/catalogue/SL72-RS.jpg', '2025-03-06 08:27:41'),
(25, 'STAN SMITH (TD)', 3, 4, 'U', 1500000.00, NULL, './view/layout/asset/img/catalogue/STAN-SMITH-(TD).jpg', '2025-03-06 08:27:41'),
(26, 'SUPERSTAR', 1, 4, 'M', 2500000.00, NULL, './view/layout/asset/img/catalogue/SUPERSTAR.jpg', '2025-03-06 08:27:41'),
(27, 'TEVA HURRICANE DRIFT (M)', 2, 5, 'M', 990000.00, NULL, './view/layout/asset/img/catalogue/Teva_Hurricane_Drift(m)-990k.jpg', '2025-03-06 08:27:41'),
(28, 'TEVA TERRA FI 5 UNIVERSAL', 2, 5, 'M', 2099000.00, NULL, './view/layout/asset/img/catalogue/Teva_Terra_Fi_5_Universal-2099k.jpg', '2025-03-06 08:27:41'),
(29, 'TEVA VOYA STRAPPY (W)', 2, 5, 'F', 845000.00, NULL, './view/layout/asset/img/catalogue/Teva_Voya_Strappy(w)-845k.jpg', '2025-03-06 08:27:41'),
(30, 'TEVA ZYMIC (W)', 2, 5, 'F', 1600000.00, NULL, './view/layout/asset/img/catalogue/Teva_Zymic-1600k(w).jpg', '2025-03-06 08:27:41'),
(31, 'TEVA SANDALS HURRICANE (W)', 2, 5, 'F', 1900000.00, NULL, './view/layout/asset/img/catalogue/TevaSandalsHunrricane(w).jpg', '2025-03-06 08:27:41'),
(32, 'UNISEX FILA PONG SD (W)', 2, 6, 'F', 1595000.00, NULL, './view/layout/asset/img/catalogue/Unisex_Fila_Pong_Sd-1595k(w).jpg', '2025-03-06 08:27:41'),
(33, 'UNISEX FILA TORI (M)', 2, 6, 'M', 1995000.00, NULL, './view/layout/asset/img/catalogue/unisex_fila_tori-1995k(m).jpg', '2025-03-06 08:27:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productsizes`
--

CREATE TABLE `productsizes` (
  `ProductSizeID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Size` int(11) NOT NULL,
  `StockQuantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productsizes`
--

INSERT INTO `productsizes` (`ProductSizeID`, `ProductID`, `Size`, `StockQuantity`) VALUES
(1, 1, 36, 10),
(2, 1, 37, 10),
(3, 1, 38, 10),
(4, 1, 41, 10),
(5, 1, 42, 10),
(6, 2, 41, 10),
(7, 2, 42, 10),
(8, 2, 43, 10),
(9, 3, 36, 10),
(10, 3, 37, 10),
(11, 3, 38, 10),
(12, 3, 41, 10),
(13, 3, 42, 10),
(14, 4, 36, 10),
(15, 4, 37, 10),
(16, 4, 38, 10),
(17, 4, 41, 10),
(18, 4, 42, 10),
(19, 5, 41, 10),
(20, 5, 42, 10),
(21, 5, 43, 10),
(22, 6, 41, 10),
(23, 6, 42, 10),
(24, 6, 43, 10),
(25, 7, 41, 10),
(26, 7, 42, 10),
(27, 7, 43, 10),
(28, 8, 41, 10),
(29, 8, 42, 10),
(30, 8, 43, 10),
(31, 9, 41, 10),
(32, 9, 42, 10),
(33, 9, 43, 10),
(34, 10, 41, 10),
(35, 10, 42, 10),
(36, 10, 43, 10),
(37, 11, 41, 10),
(38, 11, 42, 10),
(39, 11, 43, 10),
(40, 12, 41, 10),
(41, 12, 42, 10),
(42, 12, 43, 10),
(43, 13, 36, 10),
(44, 13, 37, 10),
(45, 13, 38, 10),
(46, 13, 41, 10),
(47, 13, 42, 10),
(48, 14, 20, 10),
(49, 14, 21, 10),
(50, 14, 22, 10),
(51, 14, 23, 10),
(52, 14, 24, 10),
(53, 15, 36, 10),
(54, 15, 37, 10),
(55, 15, 38, 10),
(56, 15, 39, 10),
(57, 16, 36, 10),
(58, 16, 37, 10),
(59, 16, 38, 10),
(60, 16, 39, 10),
(61, 17, 36, 10),
(62, 17, 37, 10),
(63, 17, 38, 10),
(64, 17, 39, 10),
(65, 18, 41, 10),
(66, 18, 42, 10),
(67, 18, 43, 10),
(68, 19, 36, 10),
(69, 19, 37, 10),
(70, 19, 38, 10),
(71, 19, 41, 10),
(72, 19, 42, 10),
(73, 20, 36, 10),
(74, 20, 37, 10),
(75, 20, 38, 10),
(76, 20, 41, 10),
(77, 20, 42, 10),
(78, 21, 41, 10),
(79, 21, 42, 10),
(80, 21, 43, 10),
(81, 22, 20, 10),
(82, 22, 21, 10),
(83, 22, 22, 10),
(84, 22, 23, 10),
(85, 22, 24, 10),
(86, 23, 20, 10),
(87, 23, 21, 10),
(88, 23, 22, 10),
(89, 23, 23, 10),
(90, 23, 24, 10),
(91, 24, 41, 10),
(92, 24, 42, 10),
(93, 24, 43, 10),
(94, 25, 20, 10),
(95, 25, 21, 10),
(96, 25, 22, 10),
(97, 25, 23, 10),
(98, 25, 24, 10),
(99, 26, 41, 10),
(100, 26, 42, 10),
(101, 26, 43, 10),
(102, 27, 41, 10),
(103, 27, 42, 10),
(104, 27, 43, 10),
(105, 28, 41, 10),
(106, 28, 42, 10),
(107, 28, 43, 10),
(108, 29, 36, 10),
(109, 29, 37, 10),
(110, 29, 38, 10),
(111, 29, 39, 10),
(112, 30, 36, 10),
(113, 30, 37, 10),
(114, 30, 38, 10),
(115, 30, 39, 10),
(116, 31, 36, 10),
(117, 31, 37, 10),
(118, 31, 38, 10),
(119, 31, 39, 10),
(120, 32, 36, 10),
(121, 32, 37, 10),
(122, 32, 38, 10),
(123, 32, 39, 10),
(124, 33, 41, 10),
(125, 33, 42, 10),
(126, 33, 43, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Address` text NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `IsAdmin` tinyint(1) DEFAULT 0,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`UserID`, `Username`, `FullName`, `PhoneNumber`, `Email`, `Address`, `PasswordHash`, `IsAdmin`, `CreatedAt`) VALUES
(1, 'mrhw36', 'Hauser Wasly', '0123456789', 'mrhw36@example.com', 'Grandville', '12345', 1, '2025-03-06 08:27:41'),
(2, 'jessica_smith', 'Jessica Smith', '0123456701', 'jessica.smith@example.com', '120 Elm St, Grandville', '12345', 0, '2025-03-06 08:27:41'),
(3, 'john_doe', 'John Doe', '0123456702', 'john.doe@example.com', '456 Maple Rd, Grandville', '12345', 0, '2025-03-06 08:27:41'),
(4, 'sarah_jones', 'Sarah Jones', '0123456703', 'sarah.jones@example.com', '789 Oak Ave, Grandville', '12345', 0, '2025-03-06 08:27:41'),
(5, 'mike_williams', 'Mike Williams', '0123456704', 'mike.williams@example.com', '101 Pine St, Grandville', '12345', 0, '2025-03-06 08:27:41'),
(6, 'emily_brown', 'Emily Brown', '0123456705', 'emily.brown@example.com', '202 Birch Ln, Grandville', '12345', 0, '2025-03-06 08:27:41'),
(7, 'david_miller', 'David Miller', '0123456706', 'david.miller@example.com', '303 Cedar Dr, Grandville', '12345', 0, '2025-03-06 08:27:41'),
(8, 'laura_davis', 'Laura Davis', '0123456707', 'laura.davis@example.com', '404 Willow Way, Grandville', '12345', 0, '2025-03-06 08:27:41'),
(9, 'chris_martin', 'Chris Martin', '0123456708', 'chris.martin@example.com', '505 Fir Blvd, Grandville', '12345', 0, '2025-03-06 08:27:41'),
(10, 'katie_thompson', 'Katie Thompson', '0123456709', 'katie.thompson@example.com', '606 Pinecrest Rd, Grandville', '12345', 0, '2025-03-06 08:27:41'),
(11, 'brian_clark', 'Brian Clark', '0123456710', 'brian.clark@example.com', '707 Redwood St, Grandville', '12345', 0, '2025-03-06 08:27:41');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`BrandID`),
  ADD UNIQUE KEY `BrandName` (`BrandName`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`),
  ADD UNIQUE KEY `CategoryName` (`CategoryName`);

--
-- Chỉ mục cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderDetailID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`);

--
-- Chỉ mục cho bảng `paymentdetails`
--
ALTER TABLE `paymentdetails`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `BrandID` (`BrandID`);

--
-- Chỉ mục cho bảng `productsizes`
--
ALTER TABLE `productsizes`
  ADD PRIMARY KEY (`ProductSizeID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `PhoneNumber` (`PhoneNumber`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `BrandID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `paymentdetails`
--
ALTER TABLE `paymentdetails`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `productsizes`
--
ALTER TABLE `productsizes`
  MODIFY `ProductSizeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Các ràng buộc cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Các ràng buộc cho bảng `paymentdetails`
--
ALTER TABLE `paymentdetails`
  ADD CONSTRAINT `paymentdetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`BrandID`) REFERENCES `brands` (`BrandID`);

--
-- Các ràng buộc cho bảng `productsizes`
--
ALTER TABLE `productsizes`
  ADD CONSTRAINT `productsizes_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
