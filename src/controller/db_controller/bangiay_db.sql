-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 17, 2025 lúc 03:52 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `bangiay_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `BrandID` int(11) NOT NULL,
  `BrandName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brand`
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
-- Cấu trúc bảng cho bảng `cart`
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
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`CartID`, `UserID`, `ProductID`, `Size`, `Quantity`, `AddedAt`) VALUES
(1, 1, 1, '36', 2, '2024-04-01 15:00:00'),
(2, 2, 2, '28', 1, '2024-04-02 16:30:00'),
(3, 3, 3, '41', 1, '2024-04-03 17:45:00');

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
(1, 'Kid'),
(2, 'Sandal'),
(3, 'Sneaker');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee`
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
-- Đang đổ dữ liệu cho bảng `employee`
--

INSERT INTO `employee` (`EmployeeID`, `Username`, `Fullname`, `PhoneNumber`, `Email`, `Address`, `PasswordHash`, `CreatedAt`, `PermissionID`, `isActivate`) VALUES
(1, 'admin1', 'Nguyễn Văn A', '0925123456', 'admin1@gmail.com', '56 Nguyễn Trãi, Thanh Xuân, Hà Nội', 'hashadmin1', '2024-01-01 08:00:00', 1, 1),
(2, 'sale1', 'Trần Thị Bích', '0945123456', 'sale1@gmail.com', '89 Lê Lợi, TP Huế', 'hashsale1', '2024-01-02 09:00:00', 2, 0),
(3, 'kho1', 'Phạm Văn Cường', '0965123456', 'kho1@gmail.com', '12 Tôn Đức Thắng, TP Đà Nẵng', 'hashkho1', '2024-01-03 10:00:00', 3, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `function`
--

CREATE TABLE `function` (
  `FunctionID` int(11) NOT NULL,
  `FunctionDescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `function`
--

INSERT INTO `function` (`FunctionID`, `FunctionDescription`) VALUES
(1, 'Quản lý sản phẩm'),
(2, 'Quản lý đơn hàng'),
(3, 'Quản lý kho');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import`
--

CREATE TABLE `import` (
  `ImportID` int(11) NOT NULL,
  `ProductSizeID` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ImportDate` datetime DEFAULT current_timestamp(),
  `SupplierID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `import`
--

INSERT INTO `import` (`ImportID`, `ProductSizeID`, `Price`, `Quantity`, `ImportDate`, `SupplierID`) VALUES
(1, 1, 200000.00, 100, '2024-03-01 08:00:00', 1),
(2, 3, 600000.00, 50, '2024-03-02 09:00:00', 2),
(3, 4, 3000000.00, 20, '2024-03-03 10:00:00', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `importhistory`
--

CREATE TABLE `importhistory` (
  `ImportHistoryID` int(11) NOT NULL,
  `ImportID` int(11) NOT NULL,
  `ProductSizeID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ImportDate` datetime DEFAULT current_timestamp(),
  `EmployeeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `importhistory`
--

INSERT INTO `importhistory` (`ImportHistoryID`, `ImportID`, `ProductSizeID`, `Quantity`, `ImportDate`, `EmployeeID`) VALUES
(1, 1, 1, 100, '2024-03-01 08:00:00', 3),
(2, 2, 3, 50, '2024-03-02 09:00:00', 3),
(3, 3, 4, 20, '2024-03-03 10:00:00', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetail`
--

CREATE TABLE `orderdetail` (
  `OrderDetailID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Size` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetail`
--

INSERT INTO `orderdetail` (`OrderDetailID`, `OrderID`, `ProductID`, `Quantity`, `Size`) VALUES
(1, 1, 4, 2, '36'),
(2, 2, 2, 1, '38'),
(3, 3, 3, 1, '41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
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
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `OrderDate`, `ShippingAddress`, `Province`, `Ward`, `PaymentStatus`, `EmployeeID`, `ExportDate`) VALUES
(1, 1, '2024-04-05 10:00:00', '123 Đường Láng, Đống Đa', 'Hà Nội', 'Láng Thượng', 'Processed', NULL, NULL),
(2, 2, '2024-04-06 11:30:00', '45 Nguyễn Huệ', 'Thừa Thiên Huế', 'Phú Nhuận', 'Pending', NULL, NULL),
(3, 3, '2024-04-07 14:00:00', '78 Phạm Văn Đồng', 'Đà Nẵng', 'Hòa Khánh', 'Cancelled', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `paymentdetail`
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
-- Cấu trúc bảng cho bảng `permission`
--

CREATE TABLE `permission` (
  `PermissionID` int(11) NOT NULL,
  `PermissionName` varchar(50) NOT NULL,
  `FunctionID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `permission`
--

INSERT INTO `permission` (`PermissionID`, `PermissionName`, `FunctionID`) VALUES
(1, 'Admin', 1),
(2, 'Nhân viên bán hàng', 2),
(3, 'Nhân viên kho', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
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
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `CategoryID`, `BrandID`, `Gender`, `Price`, `ImageURL`, `CreatedAt`, `IsDeleted`) VALUES
(1, '70 COURT CANVAS HI', 1, 1, 'U', 2000000.00, './view/layout/asset/img/catalogue/70-COURT-CANVAS-HI.jpg', '2025-03-06 08:27:41', 0),
(2, 'AIR FLIGHT 89 (GS)', 1, 2, 'M', 2400000.00, './view/layout/asset/img/catalogue/AIR-FLIGHT-89-(GS).jpg', '2025-03-06 08:27:41', 0),
(3, 'AIR FORCE 1 LV8-3 (GS)', 1, 2, 'U', 3200000.00, './view/layout//img/catalogue/AIR-FORCE-1-LV8-3-(GS).jpg', '2025-03-06 08:27:41', 0),
(4, 'AIR FORCE 1\'07', 1, 2, 'U', 3500000.00, './view/layout//img/catalogue/AIR-FORCE-1\'07.jpg', '2025-03-06 08:27:41', 0),
(5, 'AIR MAX 90 LTR', 1, 2, 'M', 4600000.00, './view/layout//img/catalogue/AIR-MAX-90-LTR.jpg', '2025-03-06 08:27:41', 0),
(6, 'AIR TERRRA HUMARA', 1, 2, 'M', 3200000.00, './view/layout//img/catalogue/AIR-TERRA-HUMARA.jpg', '2025-03-06 08:27:41', 0),
(7, 'AIRIZONA VEG THYME', 2, 3, 'M', 3500000.00, './view/layout//img/catalogue/AIRIZONA-VEG-THYME.jpg', '2025-03-06 08:27:41', 0),
(8, 'ARIZONA BLACKBIRKO FLOR SFB', 2, 3, 'M', 3200000.00, './view/layout//img/catalogue/ARIZONA-BLACKBIRKO-FLOR-SFB.jpg', '2025-03-06 08:27:41', 0),
(9, 'ARIZONA TOBACCO BROWN OILDED LEATHER', 2, 3, 'M', 4000000.00, './asset/img/catalogue/ARIZONA-TOBACCO-BROWN-OILED-LEATHER.jpg', '2025-03-06 08:27:41', 0),
(10, 'CHUCK 70 SEASONAL', 1, 1, 'M', 1650000.00, './asset/img/catalogue/CHUCK-70-SEASONAL.jpg', '2025-03-06 08:27:41', 0),
(11, 'DUNK LOW (W)', 1, 2, 'M', 3500000.00, './asset/img/catalogue/DUNK-LOW-(W).jpg', '2025-03-06 08:27:41', 0),
(12, 'FASTBREAK PRO SUEDE MID', 1, 1, 'M', 2800000.00, './asset/img/catalogue/FASTBREAK-PRO-SUEDE-MID.jpg', '2025-03-06 08:27:41', 0),
(13, 'FENG CHENG WANG QS', 1, 1, 'U', 4200000.00, './asset/img/catalogue/FENG-CHENG-WANG-QS.jpg', '2025-03-06 08:27:41', 0),
(14, 'GAZELLE (PS)', 3, 4, 'U', 1800000.00, './asset/img/catalogue/GAZELLE-(PS).jpg', '2025-03-06 08:27:41', 0),
(15, 'GAZELLE INDOOR (W)', 1, 4, 'F', 2800000.00, './asset/img/catalogue/GAZELLE-INDOOR-(W).jpg', '2025-03-06 08:27:41', 0),
(16, 'HANDBALL SPEZIAL (W)', 1, 4, 'F', 2500000.00, './asset/img/catalogue/HANDBALL-SPEZIAL-(W).jpg', '2025-03-06 08:27:41', 0),
(17, 'NIKE CALM BEIGE (W)', 2, 2, 'F', 2349000.00, './asset/img/catalogue/Nike_Calm_Be(w).jpg', '2025-03-06 08:27:41', 0),
(18, 'NMD S1', 1, 4, 'M', 3000000.00, './asset/img/catalogue/NMD_S1.jpg', '2025-03-06 08:27:41', 0),
(19, 'RUN STAR HIKE HI', 1, 1, 'U', 3200000.00, './asset/img/catalogue/RUN-STAR-HIKE-HI.jpg', '2025-03-06 08:27:41', 0),
(20, 'SAMBA OG', 1, 4, 'U', 2500000.00, './asset/img/catalogue/SAMBA-OG.jpg', '2025-03-06 08:27:41', 0),
(21, 'SABA XLG', 1, 4, 'M', 3500000.00, './asset/img/catalogue/SAMBA-XLG.jpg', '2025-03-06 08:27:41', 0),
(22, 'SL72 RS (PS)', 3, 4, 'U', 2000000.00, './asset/img/catalogue/SL-72-RS-(PS).jpg', '2025-03-06 08:27:41', 0),
(23, 'SL72 RS (TD)', 3, 4, 'U', 1800000.00, './asset/img/catalogue/SL72-RS-(TD).jpg', '2025-03-06 08:27:41', 0),
(24, 'SL72 RS', 1, 4, 'M', 2500000.00, './asset/img/catalogue/SL72-RS.jpg', '2025-03-06 08:27:41', 0),
(25, 'STAN SMITH (TD)', 3, 4, 'U', 1500000.00, './asset/img/catalogue/STAN-SMITH-(TD).jpg', '2025-03-06 08:27:41', 0),
(26, 'SUPERSTAR', 1, 4, 'M', 2500000.00, './asset/img/catalogue/SUPERSTAR.jpg', '2025-03-06 08:27:41', 0),
(27, 'TEVA HURRICANE DRIFT (M)', 2, 5, 'M', 990000.00, './asset/img/catalogue/Teva_Hurricane_Drift(m)-990k.jpg', '2025-03-06 08:27:41', 0),
(28, 'TEVA TERRA FI 5 UNIVERSAL', 2, 5, 'M', 2099000.00, './asset/img/catalogue/Teva_Terra_Fi_5_Universal-2099k.jpg', '2025-03-06 08:27:41', 0),
(29, 'TEVA VOYA STRAPPY (W)', 2, 5, 'F', 845000.00, './asset/img/catalogue/Teva_Voya_Strappy(w)-845k.jpg', '2025-03-06 08:27:41', 0),
(30, 'TEVA ZYMIC (W)', 2, 5, 'F', 1600000.00, './asset/img/catalogue/Teva_Zymic-1600k(w).jpg', '2025-03-06 08:27:41', 0),
(31, 'TEVA SANDALS HURRICANE (W)', 2, 5, 'F', 1900000.00, './asset/img/catalogue/TevaSandalsHunrricane(w).jpg', '2025-03-06 08:27:41', 0),
(32, 'UNISEX FILA PONG SD (W)', 2, 6, 'F', 1595000.00, './asset/img/catalogue/Unisex_Fila_Pong_Sd-1595k(w).jpg', '2025-03-06 08:27:41', 0),
(33, 'UNISEX FILA TORI (M)', 2, 6, 'M', 1995000.00, './asset/img/catalogue/unisex_fila_tori-1995k(m).jpg', '2025-03-06 08:27:41', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productsize`
--

CREATE TABLE `productsize` (
  `ProductSizeID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Size` varchar(10) DEFAULT NULL,
  `StockQuantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productsize`
--

INSERT INTO `productsize` (`ProductSizeID`, `ProductID`, `Size`, `StockQuantity`) VALUES
(1, 1, 'M', 50),
(2, 1, 'L', 30),
(3, 2, '28', 20),
(4, 3, '41', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `statistic`
--

CREATE TABLE `statistic` (
  `StatisticID` int(11) NOT NULL,
  `TotalOrder` int(11) DEFAULT NULL,
  `TotalRevenue` decimal(15,2) DEFAULT NULL,
  `TotalCustomers` int(11) DEFAULT NULL,
  `TotalProductsSold` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `statistic`
--

INSERT INTO `statistic` (`StatisticID`, `TotalOrder`, `TotalRevenue`, `TotalCustomers`, `TotalProductsSold`) VALUES
(1, 3, 4250000.00, 3, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`) VALUES
(1, 'Công ty TNHH Uniqlo Việt Nam'),
(2, 'Công ty TNHH Levi\'s Việt Nam'),
(3, 'Công ty TNHH Adidas Việt Nam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
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
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Fullname`, `PhoneNumber`, `Email`, `Address`, `PasswordHash`, `CreatedAt`, `isActivate`) VALUES
(1, 'nguyenminh', 'Nguyễn Minh Anh', '0905123456', 'minhanh@gmail.com', '123 Đường Láng, Đống Đa, Hà Nội', 'hash123', '2024-01-10 10:00:00', 0),
(2, 'tranthanh', 'Trần Thanh Tâm', '0916123456', 'thanhtam@gmail.com', '45 Nguyễn Huệ, TP Huế', 'hash456', '2024-02-15 14:30:00', 1),
(3, 'levan', 'Lê Văn Hùng', '0935123456', 'vanhung@gmail.com', '78 Phạm Văn Đồng, TP Đà Nẵng', 'hash789', '2024-03-20 09:15:00', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`BrandID`);

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
  ADD PRIMARY KEY (`CategoryID`);

--
-- Chỉ mục cho bảng `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `PermissionID` (`PermissionID`);

--
-- Chỉ mục cho bảng `function`
--
ALTER TABLE `function`
  ADD PRIMARY KEY (`FunctionID`);

--
-- Chỉ mục cho bảng `import`
--
ALTER TABLE `import`
  ADD PRIMARY KEY (`ImportID`),
  ADD KEY `ProductSizeID` (`ProductSizeID`),
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Chỉ mục cho bảng `importhistory`
--
ALTER TABLE `importhistory`
  ADD PRIMARY KEY (`ImportHistoryID`),
  ADD KEY `ImportID` (`ImportID`),
  ADD KEY `ProductSizeID` (`ProductSizeID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Chỉ mục cho bảng `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`OrderDetailID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Chỉ mục cho bảng `paymentdetail`
--
ALTER TABLE `paymentdetail`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Chỉ mục cho bảng `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`PermissionID`),
  ADD KEY `FunctionID` (`FunctionID`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `BrandID` (`BrandID`);

--
-- Chỉ mục cho bảng `productsize`
--
ALTER TABLE `productsize`
  ADD PRIMARY KEY (`ProductSizeID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Chỉ mục cho bảng `statistic`
--
ALTER TABLE `statistic`
  ADD PRIMARY KEY (`StatisticID`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Các ràng buộc cho bảng `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`PermissionID`) REFERENCES `permission` (`PermissionID`);

--
-- Các ràng buộc cho bảng `import`
--
ALTER TABLE `import`
  ADD CONSTRAINT `import_ibfk_1` FOREIGN KEY (`ProductSizeID`) REFERENCES `productsize` (`ProductSizeID`),
  ADD CONSTRAINT `import_ibfk_2` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);

--
-- Các ràng buộc cho bảng `importhistory`
--
ALTER TABLE `importhistory`
  ADD CONSTRAINT `importhistory_ibfk_1` FOREIGN KEY (`ImportID`) REFERENCES `import` (`ImportID`),
  ADD CONSTRAINT `importhistory_ibfk_2` FOREIGN KEY (`ProductSizeID`) REFERENCES `productsize` (`ProductSizeID`),
  ADD CONSTRAINT `importhistory_ibfk_3` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Các ràng buộc cho bảng `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`);

--
-- Các ràng buộc cho bảng `paymentdetail`
--
ALTER TABLE `paymentdetail`
  ADD CONSTRAINT `paymentdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`);

--
-- Các ràng buộc cho bảng `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`FunctionID`) REFERENCES `function` (`FunctionID`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`BrandID`) REFERENCES `brand` (`BrandID`);

--
-- Các ràng buộc cho bảng `productsize`
--
ALTER TABLE `productsize`
  ADD CONSTRAINT `productsize_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
