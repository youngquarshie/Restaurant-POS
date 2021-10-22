-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2021 at 06:54 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `de-dons`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `active`) VALUES
(4, 'Fridge Items', 1),
(5, 'Tots', 1),
(6, 'Vodka', 1),
(7, 'Spirit', 1),
(8, 'Jagd', 1),
(9, 'Whisky', 1),
(10, 'Irish Cream', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `vat_charge_value` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `currency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `vat_charge_value`, `address`, `phone`, `country`, `message`, `currency`) VALUES
(1, 'Kocilia Enterprise', '0', 'Mile 7', '758676851', 'Ghana', 'hello everyone one', 'GHS');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expenses_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expenses_id`, `user_id`, `purpose`, `amount`, `expense_date`) VALUES
(2, 6, 'Milo', '50.00', '1618916878');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `permission`) VALUES
(1, 'Administrator', 'a:36:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createBrand\";i:9;s:11:\"updateBrand\";i:10;s:9:\"viewBrand\";i:11;s:11:\"deleteBrand\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s:11:\"createStore\";i:17;s:11:\"updateStore\";i:18;s:9:\"viewStore\";i:19;s:11:\"deleteStore\";i:20;s:15:\"createAttribute\";i:21;s:15:\"updateAttribute\";i:22;s:13:\"viewAttribute\";i:23;s:15:\"deleteAttribute\";i:24;s:13:\"createProduct\";i:25;s:13:\"updateProduct\";i:26;s:11:\"viewProduct\";i:27;s:13:\"deleteProduct\";i:28;s:11:\"createOrder\";i:29;s:11:\"updateOrder\";i:30;s:9:\"viewOrder\";i:31;s:11:\"deleteOrder\";i:32;s:11:\"viewReports\";i:33;s:13:\"updateCompany\";i:34;s:11:\"viewProfile\";i:35;s:13:\"updateSetting\";}'),
(4, 'Cashier', 'a:8:{i:0;s:11:\"viewProduct\";i:1;s:11:\"createOrder\";i:2;s:9:\"viewOrder\";i:3;s:13:\"createProfile\";i:4;s:13:\"updateProfile\";i:5;s:11:\"viewProfile\";i:6;s:13:\"deleteProfile\";i:7;s:13:\"updateSetting\";}'),
(5, 'Manager', 'a:23:{i:0;s:11:\"createBrand\";i:1;s:11:\"updateBrand\";i:2;s:9:\"viewBrand\";i:3;s:11:\"deleteBrand\";i:4;s:14:\"createCategory\";i:5;s:14:\"updateCategory\";i:6;s:12:\"viewCategory\";i:7;s:14:\"deleteCategory\";i:8;s:15:\"createAttribute\";i:9;s:15:\"updateAttribute\";i:10;s:13:\"viewAttribute\";i:11;s:15:\"deleteAttribute\";i:12;s:13:\"createProduct\";i:13;s:13:\"updateProduct\";i:14;s:11:\"viewProduct\";i:15;s:11:\"createOrder\";i:16;s:11:\"updateOrder\";i:17;s:9:\"viewOrder\";i:18;s:11:\"deleteOrder\";i:19;s:11:\"viewReports\";i:20;s:13:\"updateCompany\";i:21;s:11:\"viewProfile\";i:22;s:13:\"updateSetting\";}'),
(6, 'New Admin', 'a:47:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:14:\"createExpenses\";i:9;s:14:\"updateExpenses\";i:10;s:12:\"viewExpenses\";i:11;s:14:\"deleteExpenses\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s:14:\"createSupplier\";i:17;s:14:\"updateSupplier\";i:18;s:12:\"viewSupplier\";i:19;s:14:\"deleteSupplier\";i:20;s:13:\"createProduct\";i:21;s:13:\"updateProduct\";i:22;s:11:\"viewProduct\";i:23;s:13:\"deleteProduct\";i:24;s:15:\"updateStockLogs\";i:25;s:13:\"viewStockLogs\";i:26;s:11:\"createOrder\";i:27;s:11:\"updateOrder\";i:28;s:9:\"viewOrder\";i:29;s:11:\"deleteOrder\";i:30;s:13:\"createReports\";i:31;s:13:\"updateReports\";i:32;s:11:\"viewReports\";i:33;s:13:\"deleteReports\";i:34;s:17:\"viewProductReport\";i:35;s:13:\"createCompany\";i:36;s:13:\"updateCompany\";i:37;s:11:\"viewCompany\";i:38;s:13:\"deleteCompany\";i:39;s:13:\"createProfile\";i:40;s:13:\"updateProfile\";i:41;s:11:\"viewProfile\";i:42;s:13:\"deleteProfile\";i:43;s:13:\"createSetting\";i:44;s:13:\"updateSetting\";i:45;s:11:\"viewSetting\";i:46;s:13:\"deleteSetting\";}');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `date_sold` varchar(255) NOT NULL,
  `time_sold` varchar(255) NOT NULL,
  `gross_amount` varchar(255) NOT NULL,
  `vat_charge_rate` varchar(255) NOT NULL,
  `vat_charge` varchar(255) NOT NULL,
  `net_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `paid_status` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `bill_no`, `customer_name`, `customer_phone`, `date_sold`, `time_sold`, `gross_amount`, `vat_charge_rate`, `vat_charge`, `net_amount`, `discount`, `paid_status`, `user_id`) VALUES
(31, 'DE-01CF99', '', '', '1634860800', '1634871541', '', '', '', '35.00', '', 1, 6),
(32, 'DE-D888C1', '', '', '1634860800', '1634871752', '', '', '', '4.00', '', 1, 6),
(33, 'DE-8293E5', '', '', '1634860800', '1634871778', '', '', '', '12.00', '', 1, 6),
(34, 'DE-835B63', '', '', '1634860800', '1634873809', '', '', '', '9.00', '', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders_item`
--

CREATE TABLE `orders_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_qty` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_item`
--

INSERT INTO `orders_item` (`id`, `order_id`, `product_id`, `order_qty`, `rate`, `amount`) VALUES
(73, 31, 20, '1', '35.00', '35.00'),
(74, 32, 9, '1', '4.00', '4.00'),
(75, 33, 10, '1', '3.00', '3.00'),
(76, 33, 14, '1', '3.00', '3.00'),
(77, 33, 17, '1', '6.00', '6.00'),
(78, 34, 17, '1', '6.00', '6.00'),
(79, 34, 14, '1', '3.00', '3.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `wholesale_price` decimal(10,2) NOT NULL,
  `profit` decimal(10,2) NOT NULL,
  `alert_level` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `availability` int(11) NOT NULL,
  `date_added` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `name`, `price`, `qty`, `wholesale_price`, `profit`, `alert_level`, `category_id`, `user_id`, `availability`, `date_added`) VALUES
(9, 'Special Ice', '4.00', '16', '3.00', '1.00', 4, 4, 6, 1, ''),
(10, 'Bel Aqua', '3.00', '16', '4.00', '1.00', 4, 4, 6, 1, ''),
(14, 'Don Simon - Multifruta', '3.00', '18', '4.00', '1.00', 4, 4, 6, 1, ''),
(16, 'Vitamilk Energy', '4.50', '59', '4.00', '0.50', 4, 4, 6, 1, ''),
(20, 'Fru Telli', '35.00', '10', '30.00', '5.00', 4, 4, 6, 1, '2021-04-29 01:40:am'),
(21, 'Heineken', '10.00', '20', '8.00', '2.00', 5, 4, 6, 1, '2021-10-22 04:32:am'),
(22, 'Coke Bottle', '1.50', '10', '1.00', '0.50', 10, 4, 6, 1, '2021-10-22 04:34:am'),
(23, 'Coke Plastic', '3.00', '10', '2.00', '1.00', 10, 4, 6, 1, '2021-10-22 04:35:am'),
(24, 'Can Drink- Kiss', '10.00', '10', '8.00', '2.00', 10, 4, 6, 1, '2021-10-22 04:36:am');

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_logs`
--

CREATE TABLE `product_stock_logs` (
  `stock_logs_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `old_qty` int(11) NOT NULL,
  `new_qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_stock_logs`
--

INSERT INTO `product_stock_logs` (`stock_logs_id`, `product_id`, `old_qty`, `new_qty`, `total`, `notes`, `user_id`, `date_created`) VALUES
(24, 19, 22, 2, 24, '', 6, '2021-04-22 09:14:pm'),
(25, 19, 24, 2, 26, '', 6, '2021-04-22 09:15:pm'),
(26, 18, 24, 4, 28, '', 6, '2021-04-22 09:20:pm'),
(27, 20, 15, -4, 11, '<p>error</p>', 6, '2021-04-29 01:53:am');

-- --------------------------------------------------------

--
-- Table structure for table `received_supplies`
--

CREATE TABLE `received_supplies` (
  `receiving_id` int(11) NOT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `receiving_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `received_supplies_items`
--

CREATE TABLE `received_supplies_items` (
  `id` int(11) NOT NULL,
  `id_receiving` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `supplies_qty` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `supplier_address` varchar(100) NOT NULL,
  `supplier_contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `phone`, `gender`) VALUES
(1, 'admin', '$2y$10$yfi5nUQGXUZtMdl27dWAyOd/jMOmATBpiUvJDmUu9hJ5Ro6BE5wsK', 'admin@admin.com', 'john', 'doe', '80789998', 1),
(6, 'de-dons', '$2y$10$r7ZZKIBJHEZ833Fr/h7VQeJ3m7CSTIlVQ49TRkENZ4OLZr1qSXbba', 'admin@gmail.com', 'De Don', 'adasda', '54455', 1),
(7, 'cashier', '$2y$10$OUrnMFzEdL2fsdLph/7Y4OLqMb1vYUHL0kxl8Qo7mHu5ZrBNzu.cq', 'cashier@gmail.com', 'cashier', 'lady', '02565411255', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(7, 6, 6),
(8, 7, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expenses_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `product_stock_logs`
--
ALTER TABLE `product_stock_logs`
  ADD PRIMARY KEY (`stock_logs_id`);

--
-- Indexes for table `received_supplies`
--
ALTER TABLE `received_supplies`
  ADD PRIMARY KEY (`receiving_id`);

--
-- Indexes for table `received_supplies_items`
--
ALTER TABLE `received_supplies_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expenses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders_item`
--
ALTER TABLE `orders_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_stock_logs`
--
ALTER TABLE `product_stock_logs`
  MODIFY `stock_logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `received_supplies`
--
ALTER TABLE `received_supplies`
  MODIFY `receiving_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `received_supplies_items`
--
ALTER TABLE `received_supplies_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
