-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2024 at 05:13 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mywifi`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `sub_name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `picture` text NOT NULL,
  `logo` text NOT NULL,
  `whatsapp` varchar(100) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `instagram` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `owner` varchar(128) NOT NULL,
  `video` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `sub_name`, `description`, `picture`, `logo`, `whatsapp`, `facebook`, `twitter`, `instagram`, `phone`, `email`, `owner`, `video`, `address`) VALUES
(1, 'BUMDESnet', 'Networking', '', 'picture-191121-62a0af9970.jpg', '', '-', '-', '-', '-', '089629112777', '-', '-', '', '-');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int NOT NULL,
  `name` varchar(128) NOT NULL,
  `no_services` varchar(128) NOT NULL,
  `status_p` enum('aktif','nonaktif','pending','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` text NOT NULL,
  `no_wa` varchar(128) NOT NULL,
  `no_ktp` varchar(128) NOT NULL,
  `created` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `no_services`, `status_p`, `address`, `no_wa`, `no_ktp`, `created`) VALUES
(91, 'Perdhiansyah', '241011042112', 'nonaktif', 'a', '0842184642746', '2492942948238423', 1728620478),
(92, 'Nining', '241013161808', 'aktif', 'paris', '0842841924891', '6171929481049109', 1728836302),
(93, 'fufufafa', '241016153956', 'aktif', 'jak', '0872364623746', '1314523589231845', 1729093212),
(94, 'ba', '241019054851', 'aktif', 's', '0831284823942', '6226262626262622', 1729316938),
(95, 'babo', '241019070023', 'aktif', 'ge', '0842184655555', '6226262626263434', 1729321236),
(96, 'wawan', '241019171022', 'aktif', 'p', '0862378562783', '8724523758972389', 1729357832),
(97, 'desa', '241023164508', 'aktif', 'dfs', '0865148451651', '9875921654846561', 1729701922);

-- --------------------------------------------------------

--
-- Table structure for table `expenditure`
--

CREATE TABLE `expenditure` (
  `expenditure_id` int NOT NULL,
  `date_payment` varchar(125) NOT NULL,
  `nominal` varchar(125) NOT NULL,
  `remark` text NOT NULL,
  `created` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int NOT NULL,
  `date_payment` varchar(125) NOT NULL,
  `nominal` varchar(125) NOT NULL,
  `remark` text NOT NULL,
  `created` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `date_payment`, `nominal`, `remark`, `created`) VALUES
(164, '2024-10-24', '150000', 'Pembayaran atas nama Nining dengan nomor langganan 241013161808', 0),
(165, '2024-10-24', '300000', 'Pembayaran atas nama Nining dengan nomor langganan 241013161808', 0),
(166, '2024-10-24', '300000', 'Pembayaran atas nama Nining dengan nomor langganan 241013161808', 0),
(167, '2024-10-24', '6000000', 'Pembayaran atas nama ba dengan nomor langganan 241019054851', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int NOT NULL,
  `invoice` varchar(225) NOT NULL,
  `month` varchar(11) NOT NULL,
  `year` int NOT NULL,
  `no_services` varchar(128) NOT NULL,
  `status` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created` int NOT NULL,
  `date_pay` datetime NOT NULL,
  `date_payment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice`, `month`, `year`, `no_services`, `status`, `created`, `date_pay`, `date_payment`) VALUES
(723, '241013161808022024', '02', 2024, '241013161808', 'BELUM BAYAR', 1729788500, '0000-00-00 00:00:00', '0000-00-00'),
(724, '241016153956022024', '02', 2024, '241016153956', 'BELUM BAYAR', 1729788500, '0000-00-00 00:00:00', '0000-00-00'),
(725, '241019054851022024', '02', 2024, '241019054851', 'BELUM BAYAR', 1729788500, '0000-00-00 00:00:00', '0000-00-00'),
(726, '241019070023022024', '02', 2024, '241019070023', 'BELUM BAYAR', 1729788500, '0000-00-00 00:00:00', '0000-00-00'),
(727, '241019171022022024', '02', 2024, '241019171022', 'BELUM BAYAR', 1729788500, '0000-00-00 00:00:00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `detail_id` int NOT NULL,
  `invoice_id` varchar(225) NOT NULL,
  `price` varchar(125) NOT NULL,
  `qty` varchar(125) NOT NULL,
  `disc` varchar(128) NOT NULL,
  `remark` text NOT NULL,
  `total` varchar(128) NOT NULL,
  `item_id` int NOT NULL,
  `category_id` int NOT NULL,
  `date_payment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`detail_id`, `invoice_id`, `price`, `qty`, `disc`, `remark`, `total`, `item_id`, `category_id`, `date_payment`) VALUES
(700, '241013161808022024', '150000', '1', '0', '', '150000', 8, 11, '0000-00-00'),
(701, '241016153956022024', '150000', '1', '0', '', '150000', 8, 11, '0000-00-00'),
(702, '241019054851022024', '150000', '20', '0', '', '3000000', 8, 11, '0000-00-00'),
(703, '241019070023022024', '150000', '6', '0', '', '900000', 8, 11, '0000-00-00'),
(704, '241019171022022024', '150000', '1', '0', '', '150000', 8, 11, '0000-00-00'),
(705, '241013161808022024', '150000', '1', '0', '', '150000', 8, 11, '0000-00-00'),
(706, '241016153956022024', '150000', '1', '0', '', '150000', 8, 11, '0000-00-00'),
(707, '241019054851022024', '150000', '20', '0', '', '3000000', 8, 11, '0000-00-00'),
(708, '241019070023022024', '150000', '6', '0', '', '900000', 8, 11, '0000-00-00'),
(709, '241019171022022024', '150000', '1', '0', '', '150000', 8, 11, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `package_category`
--

CREATE TABLE `package_category` (
  `p_category_id` int NOT NULL,
  `name` varchar(125) NOT NULL,
  `description` text NOT NULL,
  `date_created` int NOT NULL,
  `date_updated` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package_category`
--

INSERT INTO `package_category` (`p_category_id`, `name`, `description`, `date_created`, `date_updated`) VALUES
(11, 'Langganan Internet', ' ', 1728607847, 0);

-- --------------------------------------------------------

--
-- Table structure for table `package_item`
--

CREATE TABLE `package_item` (
  `p_item_id` int NOT NULL,
  `name` varchar(125) NOT NULL,
  `price` varchar(125) NOT NULL,
  `picture` text NOT NULL,
  `description` text NOT NULL,
  `category_id` int NOT NULL,
  `date_created` int NOT NULL,
  `date_update` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package_item`
--

INSERT INTO `package_item` (`p_item_id`, `name`, `price`, `picture`, `description`, `category_id`, `date_created`, `date_update`) VALUES
(8, '10 Mbps', '150000', '', '', 11, 1728608282, 0);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `services_id` int NOT NULL,
  `item_id` int NOT NULL,
  `category_id` int NOT NULL,
  `no_services` varchar(125) NOT NULL,
  `qty` varchar(128) NOT NULL,
  `price` varchar(128) NOT NULL,
  `disc` varchar(128) DEFAULT NULL,
  `total` varchar(128) NOT NULL,
  `remark` text NOT NULL,
  `services_create` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`services_id`, `item_id`, `category_id`, `no_services`, `qty`, `price`, `disc`, `total`, `remark`, `services_create`) VALUES
(80, 8, 11, '241011042112', '1', '150000', '0', '150000', '', 1729388019),
(81, 8, 11, '241013161808', '1', '150000', '0', '150000', '', 1729388411),
(82, 8, 11, '241019171022', '1', '150000', '0', '150000', '', 1729390954),
(84, 8, 11, '241019070023', '6', '150000', '0', '900000', '', 1729390969),
(85, 8, 11, '241016153956', '1', '150000', '0', '150000', '', 1729391019),
(86, 8, 11, '241019054851', '20', '150000', '0', '3000000', '', 1729391038),
(87, 8, 11, '241011042112', '11', '150000', '0', '1650000', '', 1729449179);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total_amount` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `no_services` varchar(255) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `cashier` varchar(255) NOT NULL,
  `status` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` int NOT NULL,
  `transaction_id` int NOT NULL,
  `month` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `amount` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_midtrans`
--

CREATE TABLE `transaksi_midtrans` (
  `order_id` char(20) NOT NULL,
  `gross_amount` int DEFAULT NULL,
  `payment_type` varchar(13) DEFAULT NULL,
  `transaction_time` varchar(19) DEFAULT NULL,
  `bank` varchar(10) DEFAULT NULL,
  `va_number` varchar(30) DEFAULT NULL,
  `pdf_url` text,
  `status_code` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(128) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `address` text NOT NULL,
  `image` varchar(225) NOT NULL,
  `role_id` text NOT NULL,
  `is_active` int NOT NULL,
  `date_created` int NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `phone`, `address`, `image`, `role_id`, `is_active`, `date_created`, `gender`) VALUES
(8, 'admin@admin.com', '$2y$10$o0THPcRv0QQy.kXgc97PduYBTNtIaum6mfWEtV335J02JidXYdmoe', 'Rey Bimaska', '089629112777', '-', 'unnamed1.jpg', '1', 1, 1574219676, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `expenditure`
--
ALTER TABLE `expenditure`
  ADD PRIMARY KEY (`expenditure_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD UNIQUE KEY `invoice` (`invoice`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `package_category`
--
ALTER TABLE `package_category`
  ADD PRIMARY KEY (`p_category_id`);

--
-- Indexes for table `package_item`
--
ALTER TABLE `package_item`
  ADD PRIMARY KEY (`p_item_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`services_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fktransactions` (`transaction_id`),
  ADD KEY `fkstatus` (`month`);

--
-- Indexes for table `transaksi_midtrans`
--
ALTER TABLE `transaksi_midtrans`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `expenditure`
--
ALTER TABLE `expenditure`
  MODIFY `expenditure_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=728;

--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `detail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=710;

--
-- AUTO_INCREMENT for table `package_category`
--
ALTER TABLE `package_category`
  MODIFY `p_category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `package_item`
--
ALTER TABLE `package_item`
  MODIFY `p_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `services_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `fktransactions` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
