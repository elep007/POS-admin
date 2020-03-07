-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2020 at 08:29 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `shop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `shop_id`) VALUES
(1, 'CHICKEN', 1305903),
(2, 'SEAFOOD', 1305903),
(3, 'SOUP', 1305903),
(4, 'VEGETABLES', 1305903),
(5, 'BEEF', 1305903),
(6, 'PROMOTION', 1305903),
(7, 'LAMB', 1305903),
(8, 'test_category1', 123),
(9, 'test_category2', 123);

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `discountValue` int(11) NOT NULL,
  `discountKey` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `discountValue`, `discountKey`) VALUES
(1, 0, 'No'),
(2, 10, '10%'),
(3, 20, '20%');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` tinytext,
  `tax_code` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `price` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `tax_code`, `photo`, `category_id`, `shop_id`, `price`) VALUES
(92, 'ch-test', 'Chicken with sze chuan pepper', NULL, 'food1.jpg', 1, 1305903, 3.5),
(93, 'CH-spicy sauce', 'Chicken in spicy sauce', NULL, 'food1.jpg', 1, 1305903, 21),
(94, 'CH-glass noodle', 'Chicken glass noodle', NULL, 'food1.jpg', 1, 1305903, 21),
(95, 'CH-black fungus', 'Chicken with black fungus', NULL, 'food1.jpg', 1, 1305903, 21),
(96, 'CH-shred green pepp', 'Shredded chicken with green pepper', NULL, 'food1.jpg', 1, 1305903, 17),
(97, 'CH-shred celery', 'Shredded chicken with celery', NULL, 'food1.jpg', 1, 1305903, 17),
(98, 'CH-Shred garlic sprout', 'Shredded chicken with garlic sprout', NULL, 'food1.jpg', 1, 1305903, 17),
(99, 'CH-shittake mushroom', 'Double boiled chicken with shittake mushroom', NULL, 'food1.jpg', 1, 1305903, 20),
(100, 'CH-white cut', 'White cut chicken', NULL, 'food1.jpg', 1, 1305903, 19),
(101, 'CH-slice hot chilies oil', 'Chicken slice in hot chilies oil', NULL, 'food1.jpg', 1, 1305903, 21),
(102, 'CH-sweet potato', 'Sweet potato chicken', NULL, 'food1.jpg', 1, 1305903, 16),
(103, 'CH-wing garlic', 'Garlic chicken wing', NULL, 'food1.jpg', 1, 1305903, 16),
(104, 'CH - golden cruspy', 'Golden crispy chicken', NULL, 'food1.jpg', 1, 1305903, 16),
(105, 'FS-pickle spicy&sour', 'Pickle spicy & sour fish', NULL, 'food1.jpg', 2, 1305903, 0),
(106, 'FS-sau. grilled FS', 'Sauerkraut grilled fish', NULL, 'food1.jpg', 2, 1305903, 0),
(107, 'FS-golden spicy&sour', 'Golden spicy & sour fish', NULL, 'food1.jpg', 2, 1305903, 0),
(108, 'FS-wanzhou grill', 'Wanzhou grilled fish', NULL, 'food1.jpg', 2, 1305903, 0),
(109, 'FS-old grandma stem', 'Old grandma recepi steam fish', NULL, 'food1.jpg', 2, 1305903, 58),
(110, 'FS-steam tilapia', 'Steam tilapia', NULL, 'food1.jpg', 2, 1305903, 38),
(111, 'FS-pickle pepper', 'Fish with pickle pepper', NULL, 'food1.jpg', 2, 1305903, 46),
(112, 'FS-tofu', 'Tofu fish', NULL, 'food1.jpg', 2, 1305903, 42),
(113, 'FS-blac pepper sauce', 'Fish fillet in black pepper sauce', NULL, 'food1.jpg', 2, 1305903, 38),
(114, 'FS-Tilapia coconut gra.', 'Tilapia in coconut gravy', NULL, 'food1.jpg', 2, 1305903, 38),
(115, 'Spicy big prawn', 'Spicy Big prawn', NULL, 'food1.jpg', 2, 1305903, 45),
(116, 'Salt. egg crispy prawn', 'Salted egg cripy yolk prawn', NULL, 'food1.jpg', 2, 1305903, 29),
(117, 'Prawn cocktail', 'Prawn Cocktail', NULL, 'food1.jpg', 2, 1305903, 16),
(118, 'Cabbage, glass noodle so', 'Pickle cabbage and glass noodle soup', NULL, 'food1.jpg', 3, 1305903, 12),
(119, 'Tom egg drop soup', 'Tomato egg drop soup', NULL, 'food1.jpg', 3, 1305903, 12),
(120, 'cucumber celery egg so', 'Cucumber and celery egg soup', NULL, 'food1.jpg', 3, 1305903, 12),
(121, 'Beancurd vege soup', 'Beancurd vegetable soup', NULL, 'food1.jpg', 3, 1305903, 10),
(122, 'spicy & sour so', 'Spicy & sour Soup', NULL, 'food1.jpg', 3, 1305903, 25),
(123, 'Egg seaweed so', 'Egg drop seaweed soup', NULL, 'food1.jpg', 3, 1305903, 12),
(124, 'Flavour stim egg', 'Special flavour stim egg', NULL, 'food1.jpg', 3, 1305903, 16),
(125, 'Braised baby cabbage', 'Braised baby cabbage in broth', NULL, 'food1.jpg', 4, 1305903, 20),
(126, 'Green peas rice pep', 'Green peas rice pepper', NULL, 'food1.jpg', 4, 1305903, 18),
(127, 'Braised cauliflower', 'Braised cauliflower', NULL, 'food1.jpg', 4, 1305903, 18),
(128, 'Sesame oil broccoli', 'Sesame oil broccoli', NULL, 'food1.jpg', 4, 1305903, 18),
(129, 'Nutritious Raddish', 'Nutritious Raddish', NULL, 'food1.jpg', 4, 1305903, 12),
(130, 'Fried bitter gourd', 'Fried bitter gourd', NULL, 'food1.jpg', 4, 1305903, 12),
(131, 'Seafood mushr luffa', 'Seafood mushroom with luffa', NULL, 'food1.jpg', 4, 1305903, 16),
(132, 'Stir fry winter melon', 'Stir fry winter melon', NULL, 'food1.jpg', 4, 1305903, 16),
(133, 'Braised bean curd', 'Braised bean curd', NULL, 'food1.jpg', 4, 1305903, 12),
(134, 'Dry stew potatoes', 'Dry stew potatoes', NULL, 'food1.jpg', 4, 1305903, 12),
(135, 'Sour spicy potato juliene', 'Sour spicy potato juliene', NULL, 'food1.jpg', 4, 1305903, 12),
(136, 'Mapo tofu', 'Mapo tofu', NULL, 'food1.jpg', 4, 1305903, 16),
(137, 'Fr. Crispy oyter mushr', 'Fried crispy oyster mushroom', NULL, 'food1.jpg', 4, 1305903, 12),
(138, 'Blac fungus cucumber', 'Black fungus and cucumber', NULL, 'food1.jpg', 4, 1305903, 16),
(139, 'Fr. Sugar vi chinese cab', 'Fried sugar vinaigratte chinese cabbage', NULL, 'food1.jpg', 4, 1305903, 16),
(140, 'stir fry chine lettuce gralic', 'Stir fry chinese lettuce with toasted garlic', NULL, 'food1.jpg', 4, 1305903, 18),
(141, 'Braised eggplant ', 'Braised eggplant ', NULL, 'food1.jpg', 4, 1305903, 16),
(142, '_Stew eggplant in pot', 'Stew eggplant in pot', NULL, 'food1.jpg', 8, 123, 12),
(143, '_Sp. Eggplant dark sauce', 'Spicy eggplant in dark sauce', NULL, 'food1.jpg', 9, 123, 12),
(144, 'St. fry beef crispy peppe', 'Stir fry beef with crispy pepper', NULL, 'food1.jpg', 5, 1305903, 32),
(145, 'Roastbeef with potato', 'Roastbeef with potato', NULL, 'food1.jpg', 5, 1305903, 32),
(146, 'Stew beef sirloin tomato', 'Stewed beef sirloin with tomato', NULL, 'food1.jpg', 5, 1305903, 32),
(147, 'Beef sze chuan pepper', 'Beef with sze chuan pepper', NULL, 'food1.jpg', 5, 1305903, 32),
(148, 'Spicy boiled beef slice', 'Spicy boiled beef slice', NULL, 'food1.jpg', 5, 1305903, 32),
(149, 'Mutton in hot pot', 'Mutton in hot pot', NULL, 'food1.jpg', 6, 1305903, 43),
(150, 'Stew lamb brawn sauce', 'Stew lamb in  brown sauce', NULL, 'food1.jpg', 6, 1305903, 43),
(151, 'Poached lamb', 'Poached lamb', NULL, 'food1.jpg', 6, 1305903, 43);

-- --------------------------------------------------------

--
-- Table structure for table `service_charge`
--

CREATE TABLE `service_charge` (
  `id` int(11) NOT NULL,
  `service_key` varchar(100) NOT NULL,
  `service_value` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_charge`
--

INSERT INTO `service_charge` (`id`, `service_key`, `service_value`) VALUES
(1, 'No', '0'),
(2, '10%', '10'),
(3, '20%', '20');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `website` varchar(255) NOT NULL,
  `shop_logo` varchar(255) NOT NULL,
  `shop_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id`, `shop_id`, `shop_name`, `phone`, `address`, `website`, `shop_logo`, `shop_code`) VALUES
(1, 1305903, 'NION9 SDN. BHD. ', 'TELl: 603- 8081 68001', 'C-2-28 Damen USJ Komersil', 'www.example.com', 'https://d1nhio0ox7pgb.cloudfront.net/_img/o_collection_png/green_dark_grey/256x256/plain/shopping_cart.png', 'Nion9'),
(2, 123, 'ShopName2', 'GTEST', 'TEST55', 'www.shop.com', 'https://www.gkicon.com/shop/assets/front/images/logo.png', 'shop9');

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

CREATE TABLE `table` (
  `table_id` int(11) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `shop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table`
--

INSERT INTO `table` (`table_id`, `table_name`, `shop_id`) VALUES
(1, 'TABLE 1', 1305903),
(2, 'TABLE 2', 1305903),
(3, 'TABLE 3', 1305903),
(4, 'TABLE 4', 1305903),
(5, 'TABLE 5', 1305903),
(6, 'TABLE 6', 1305903),
(7, 'TABLE 7', 1305903),
(8, 'TABLE 8', 1305903),
(9, 'TABLE 9', 1305903),
(10, 'TABLE 10', 1305903),
(11, 'TABLE 11', 123),
(12, 'TABLE 12', 123),
(13, 'TABLE 13', 123),
(14, 'TABLE 14', 123),
(15, 'TABLE 15', 123),
(16, 'TABLE 16', 123);

-- --------------------------------------------------------

--
-- Table structure for table `tax_code`
--

CREATE TABLE `tax_code` (
  `tax_id` int(11) NOT NULL,
  `tax_code` varchar(255) NOT NULL,
  `tax_percentage` varchar(255) DEFAULT NULL,
  `shop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tax_code`
--

INSERT INTO `tax_code` (`tax_id`, `tax_code`, `tax_percentage`, `shop_id`) VALUES
(1, 'NA', '0.06', 1305903),
(2, 'test', '0.08', 1305903),
(3, 'b_textcode1', '0.05', 123),
(4, 'b_testcode2', '0.09', 123);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `date_transaction` datetime DEFAULT NULL,
  `invoice` varchar(15) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  `tax_amount` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `date_transaction`, `invoice`, `table_id`, `product_id`, `unit_price`, `tax_amount`, `total_amount`, `status`, `shop_id`) VALUES
(257, '2019-09-29 12:31:12', '2019092900001', 1, 92, 21, '1.26', '22.26', 'BILLED', 1305903),
(258, '2019-09-29 12:31:12', '2019092900001', 1, 96, 17, '1.02', '18.02', 'BILLED', 1305903),
(259, '2019-09-29 12:31:12', '2019092900001', 1, 94, 21, '1.26', '22.26', 'BILLED', 1305903),
(260, '2019-09-29 12:31:12', '2019092900001', 1, 100, 19, '1.14', '20.14', 'BILLED', 1305903),
(268, '2019-10-01 19:38:49', '2019100100001', 2, 125, 22, '1.76', '23.76', 'Open', 1305903),
(269, '2019-10-01 19:38:49', '2019100100001', 2, 93, 21, '1.26', '22.26', 'Open', 1305903),
(272, '2019-10-02 03:25:20', '2019100200001', 3, 93, 25, '1.26', '26.26', 'Open', 1305903),
(273, '2019-10-02 03:25:20', '2019100200001', 3, 94, 21, '1.68', '22.68', 'Open', 1305903),
(274, '2019-10-02 04:09:20', '2019100200002', 4, 92, 22, NULL, '22', 'Open', 1305903),
(275, '2019-10-02 04:09:20', '2019100200002', 4, 92, 21, '1.68', '22.68', 'Open', 1305903),
(276, '2019-10-02 03:25:20', '2019100200003', 3, 92, 21, '1.26', '22.26', 'Open', 1305903),
(278, '2019-10-02 23:45:16', '2019100200004', 5, 93, 80, '4.8', '84.8', 'Open', 1305903),
(279, '2019-10-02 23:45:16', '2019100200004', 5, 94, 100, '', '108', 'Open', 1305903),
(280, '2019-10-10 22:25:42', '2019101000001', 1, 92, 21, '1.26', '22.26', 'Open', 1305903),
(281, '2019-10-10 22:25:42', '2019101000001', 1, 92, 4, '0.21', '3.71', 'Open', 1305903),
(282, '2019-10-10 22:25:42', '2019101000001', 1, 92, 3.5, '0.21', '3.71', 'Open', 1305903),
(283, '2019-10-10 22:25:42', '2019101000001', 1, 93, 21, '1.26', '22.26', 'Open', 1305903),
(284, '2019-10-24 18:01:23', '2019102400001', 12, 142, 12, '1.08', '13.08', 'Open', 123),
(285, '2019-10-31 00:40:45', '2019103100001', 6, 92, 3.5, '0.21', '3.71', 'Open', 1305903),
(286, '2019-10-31 00:40:45', '2019103100001', 6, 99, 20, '1.2', '21.2', 'Open', 1305903),
(287, '2019-10-31 00:40:45', '2019103100001', 6, 95, 21, '1.26', '22.26', 'Open', 1305903),
(288, '2019-10-02 23:45:16', '2019100200004', 5, 92, 3.5, '0.21', '3.71', 'Open', 1305903),
(289, '2019-10-10 22:25:42', '2019101000001', 1, 95, 21, '1.26', '22.26', 'Open', 1305903),
(305, '2019-12-03 09:32:39', '2019120300001', 9, 92, 3.5, '0.21', '3.71', 'Open', 1305903),
(306, '2019-12-03 09:32:39', '2019120300001', 9, 97, 17, '1.02', '18.02', 'Open', 1305903),
(307, '2019-12-03 09:32:55', '2019120300002', 10, 92, 3.5, '0.21', '3.71', 'Open', 1305903),
(308, '2019-12-03 09:32:55', '2019120300002', 10, 97, 17, '1.02', '18.02', 'Open', 1305903),
(309, '2019-12-03 09:32:55', '2019120300002', 10, 98, 17, '1.02', '18.02', 'Open', 1305903),
(310, '2019-12-03 09:32:39', '2019120300001', 9, 93, 21, '1.26', '22.26', 'Open', 1305903);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) CHARACTER SET utf8 NOT NULL,
  `email` varchar(191) CHARACTER SET utf8 NOT NULL,
  `password` varchar(191) CHARACTER SET utf8 NOT NULL,
  `encriptp` varchar(191) CHARACTER SET utf8 NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `time` datetime NOT NULL,
  `fcm_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `shop_id`, `username`, `email`, `password`, `encriptp`, `remember_token`, `time`, `fcm_token`) VALUES
(2, '1305903', 'wallace', 'virox99@yahoo.com', '1', '1', NULL, '0000-00-00 00:00:00', NULL),
(3, '123', 'test', 'aaa@bbb.com', '1', '1', NULL, '0000-00-00 00:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `service_charge`
--
ALTER TABLE `service_charge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table`
--
ALTER TABLE `table`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `tax_code`
--
ALTER TABLE `tax_code`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `service_charge`
--
ALTER TABLE `service_charge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table`
--
ALTER TABLE `table`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tax_code`
--
ALTER TABLE `tax_code`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
