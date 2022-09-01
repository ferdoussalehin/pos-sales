-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2022 at 05:46 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_information`
--

CREATE TABLE `company_information` (
  `company_id` varchar(250) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `website` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_information`
--

INSERT INTO `company_information` (`company_id`, `company_name`, `email`, `address`, `mobile`, `website`, `status`) VALUES
('1', 'Demo LTD', 'example@gmail.com', '4th Floor Mannan Plaza,Khilkhet,Dhaka-1229', '234234', 'httpss://www.bdtask.com/', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sls_billers`
--

CREATE TABLE `sls_billers` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `vat_number` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL COMMENT '1=paid,2=credit',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `create_by` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_billers`
--

INSERT INTO `sls_billers` (`id`, `name`, `company_name`, `phone`, `email`, `address`, `city`, `state`, `zip`, `country`, `vat_number`, `status`, `create_date`, `create_by`) VALUES
(3, 'Test', 'test', '01558930222', 'admin@example.com', 'test', 'test', 'Test', '1211', 'BDESH', '1122', 1, '2021-05-24 12:24:47', '2'),
(4, 'Test', 'test', '1232', 'admin2@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:12:45', '2'),
(7, 'Test6', 'test6', '015589', 'admin6@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:14:33', '2'),
(8, 'Test7', 'test7', '01767896', 'admin7@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:15:16', '2'),
(9, 'aisoft', 'Owner', '015589', 'aisoft@example.com', 'test', 'test', 'Test', '1211', 'BDESH', '1122', 1, '2021-05-25 06:10:15', '2'),
(10, 'Test Supplier', 'testsup', '01558933', 'admintest@example.com', 'testsup', 'test', 'Testsup', '121133', 'BDESH', '112233', 1, '2021-05-25 08:36:38', '2');

-- --------------------------------------------------------

--
-- Table structure for table `sls_brands`
--

CREATE TABLE `sls_brands` (
  `id` int(11) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `slug` varchar(55) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_brands`
--

INSERT INTO `sls_brands` (`id`, `code`, `name`, `image`, `slug`, `description`) VALUES
(1, '1222', 'test', NULL, 'test', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sls_categories`
--

CREATE TABLE `sls_categories` (
  `id` int(11) NOT NULL,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `name_alt` varchar(55) DEFAULT NULL,
  `image` varchar(55) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `slug` varchar(55) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_synchronize` tinyint(2) NOT NULL DEFAULT 0,
  `hide_status` tinyint(2) NOT NULL DEFAULT 0,
  `display_serial` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_categories`
--

INSERT INTO `sls_categories` (`id`, `code`, `name`, `name_alt`, `image`, `parent_id`, `slug`, `description`, `is_synchronize`, `hide_status`, `display_serial`) VALUES
(1, 'C1', 'Category 1', NULL, NULL, 0, 'category-1', 'test', 0, 0, 13),
(2, '1', 'الفحم', NULL, '26ae0251ecd2bf0f2fcc62d8a37e8868.png', 0, 'AB1', 'الفحم', 0, 0, 2),
(3, '2', 'مشويات', NULL, '2d36388068da76fad14209b0eaebb99e.png', 0, 'aa', 'مشويات', 0, 0, 3),
(4, '3', 'ايدامات كبير', NULL, '992df5c8c798a1de2d20696e18229245.jpg', 0, 'aaa', 'ايدامات كبير', 0, 0, 6),
(5, '4', 'سلطات ومعكرونة', NULL, '1e11da72464dd1fae5d8ee85deb525d3.png', 0, 'aaaa', 'سلطات ومعكرونة', 0, 0, 8),
(6, '5', 'الحلا', NULL, '9e114ad7110027d2bac4316bd59b5e15.png', 0, 'aaaaa', 'الحلا', 0, 0, 9),
(7, '6', 'المشروبات', NULL, 'e30017d337318872ae4c4c6083ebad94.png', 0, 'aaaaaa', 'المشروبات', 0, 0, 10),
(8, '7', 'ايدامات صغير', NULL, '46af58345318d3f85e4be3ded052b189.jpg', 0, 'aaaaaaa', 'ايدامات صغير', 0, 0, 7),
(9, '11', 'الشواية', NULL, '8f4b04737e5812d6ac3b3317ec661972.png', 0, 'AB', 'الشواية', 0, 0, 1),
(10, '13', 'كبسة لحم', NULL, '559ea455dd000208376d27ed9969d9c7.png', 0, 'AB2', 'كبسة لحم', 0, 0, 4),
(11, '165156', 'قسم رز', NULL, 'e1393d612fb2a717f2e70dcf93aa499e.png', 0, '2063206516', 'قسم رز', 0, 0, 5),
(12, '12390', 'Efg', NULL, NULL, 0, 'efg', 'test', 0, 0, NULL),
(13, '112234', 'friends', NULL, NULL, 0, 'friends', 'testddddd', 0, 0, 14),
(14, '12390rr', 'fgfd', NULL, NULL, 0, 'fgfd', 'fgf', 0, 0, 33);

-- --------------------------------------------------------

--
-- Table structure for table `sls_combo_items`
--

CREATE TABLE `sls_combo_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `quantity` decimal(12,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_combo_items`
--

INSERT INTO `sls_combo_items` (`id`, `product_id`, `item_code`, `quantity`, `unit_price`) VALUES
(4, 101, '112234234', '1.0000', '100.0000'),
(5, 101, '12333', '1.0000', '150.0000');

-- --------------------------------------------------------

--
-- Table structure for table `sls_currencies`
--

CREATE TABLE `sls_currencies` (
  `id` int(11) NOT NULL,
  `code` varchar(5) NOT NULL,
  `name` varchar(55) NOT NULL,
  `rate` decimal(12,4) NOT NULL,
  `auto_update` tinyint(1) NOT NULL DEFAULT 0,
  `symbol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_currencies`
--

INSERT INTO `sls_currencies` (`id`, `code`, `name`, `rate`, `auto_update`, `symbol`) VALUES
(1, 'USD', 'US Dollar', '1.0000', 0, NULL),
(2, 'EUR', 'EURO', '0.7340', 0, NULL),
(3, 'SAR', 'SAR', '1.0000', 0, 'SAR');

-- --------------------------------------------------------

--
-- Table structure for table `sls_customers`
--

CREATE TABLE `sls_customers` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `vat_number` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL COMMENT '1=paid,2=credit',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `create_by` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_customers`
--

INSERT INTO `sls_customers` (`id`, `name`, `company_name`, `phone`, `email`, `address`, `city`, `state`, `zip`, `country`, `vat_number`, `status`, `create_date`, `create_by`) VALUES
(1, 'Walking Customer', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-03-03 01:23:10', NULL),
(2, 'Test', NULL, '01558930222', 'admin34@example.com', 'test', 'test', '', '', '', NULL, 1, '2021-05-24 12:20:15', '500636'),
(3, 'Test', 'test', '01558930222', 'admin@example.com', 'test', 'test', 'Test', '1211', 'BDESH', '1122', 1, '2021-05-24 12:24:47', '2'),
(4, 'Test', 'test', '1232', 'admin2@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:12:45', '2'),
(7, 'Test6', 'test6', '015589', 'admin6@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:14:33', '2'),
(8, 'Test7', 'test7', '01767896', 'admin7@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:15:16', '2'),
(9, 'aisoft', 'Owner', '015589', 'aisoft@example.com', 'test', 'test', 'Test', '1211', 'BDESH', '1122', 1, '2021-05-25 06:10:15', '2');

-- --------------------------------------------------------

--
-- Table structure for table `sls_date_format`
--

CREATE TABLE `sls_date_format` (
  `id` int(11) NOT NULL,
  `js` varchar(20) NOT NULL,
  `php` varchar(20) NOT NULL,
  `sql` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_date_format`
--

INSERT INTO `sls_date_format` (`id`, `js`, `php`, `sql`) VALUES
(1, 'mm-dd-yyyy', 'm-d-Y', '%m-%d-%Y'),
(2, 'mm/dd/yyyy', 'm/d/Y', '%m/%d/%Y'),
(3, 'mm.dd.yyyy', 'm.d.Y', '%m.%d.%Y'),
(4, 'dd-mm-yyyy', 'd-m-Y', '%d-%m-%Y'),
(5, 'dd/mm/yyyy', 'd/m/Y', '%d/%m/%Y'),
(6, 'dd.mm.yyyy', 'd.m.Y', '%d.%m.%Y');

-- --------------------------------------------------------

--
-- Table structure for table `sls_pos_settings`
--

CREATE TABLE `sls_pos_settings` (
  `pos_id` int(1) NOT NULL,
  `cat_limit` int(11) NOT NULL,
  `pro_limit` int(11) NOT NULL,
  `default_category` int(11) NOT NULL,
  `default_customer` int(11) NOT NULL,
  `default_biller` int(11) NOT NULL,
  `display_time` varchar(3) NOT NULL DEFAULT 'yes',
  `cf_title1` varchar(255) DEFAULT NULL,
  `cf_title2` varchar(255) DEFAULT NULL,
  `cf_value1` varchar(255) DEFAULT NULL,
  `cf_value2` varchar(255) DEFAULT NULL,
  `receipt_printer` varchar(55) DEFAULT NULL,
  `cash_drawer_codes` varchar(55) DEFAULT NULL,
  `focus_add_item` varchar(55) DEFAULT NULL,
  `add_manual_product` varchar(55) DEFAULT NULL,
  `customer_selection` varchar(55) DEFAULT NULL,
  `add_customer` varchar(55) DEFAULT NULL,
  `toggle_category_slider` varchar(55) DEFAULT NULL,
  `toggle_subcategory_slider` varchar(55) DEFAULT NULL,
  `cancel_sale` varchar(55) DEFAULT NULL,
  `suspend_sale` varchar(55) DEFAULT NULL,
  `print_items_list` varchar(55) DEFAULT NULL,
  `finalize_sale` varchar(55) DEFAULT NULL,
  `today_sale` varchar(55) DEFAULT NULL,
  `open_hold_bills` varchar(55) DEFAULT NULL,
  `close_register` varchar(55) DEFAULT NULL,
  `keyboard` tinyint(1) NOT NULL,
  `pos_printers` varchar(255) DEFAULT NULL,
  `java_applet` tinyint(1) NOT NULL,
  `product_button_color` varchar(20) NOT NULL DEFAULT 'default',
  `tooltips` tinyint(1) DEFAULT 1,
  `paypal_pro` tinyint(1) DEFAULT 0,
  `stripe` tinyint(1) DEFAULT 0,
  `rounding` tinyint(1) DEFAULT 0,
  `char_per_line` tinyint(4) DEFAULT 42,
  `pin_code` varchar(20) DEFAULT NULL,
  `purchase_code` varchar(100) DEFAULT 'purchase_code',
  `envato_username` varchar(50) DEFAULT 'envato_username',
  `version` varchar(10) DEFAULT '3.4.53',
  `after_sale_page` tinyint(1) DEFAULT 0,
  `item_order` tinyint(1) DEFAULT 0,
  `authorize` tinyint(1) DEFAULT 0,
  `toggle_brands_slider` varchar(55) DEFAULT NULL,
  `remote_printing` tinyint(1) DEFAULT 1,
  `printer` int(11) DEFAULT NULL,
  `order_printers` varchar(55) DEFAULT NULL,
  `auto_print` tinyint(1) DEFAULT 0,
  `customer_details` tinyint(1) DEFAULT NULL,
  `local_printers` tinyint(1) DEFAULT NULL,
  `pos_layout_type` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_pos_settings`
--

INSERT INTO `sls_pos_settings` (`pos_id`, `cat_limit`, `pro_limit`, `default_category`, `default_customer`, `default_biller`, `display_time`, `cf_title1`, `cf_title2`, `cf_value1`, `cf_value2`, `receipt_printer`, `cash_drawer_codes`, `focus_add_item`, `add_manual_product`, `customer_selection`, `add_customer`, `toggle_category_slider`, `toggle_subcategory_slider`, `cancel_sale`, `suspend_sale`, `print_items_list`, `finalize_sale`, `today_sale`, `open_hold_bills`, `close_register`, `keyboard`, `pos_printers`, `java_applet`, `product_button_color`, `tooltips`, `paypal_pro`, `stripe`, `rounding`, `char_per_line`, `pin_code`, `purchase_code`, `envato_username`, `version`, `after_sale_page`, `item_order`, `authorize`, `toggle_brands_slider`, `remote_printing`, `printer`, `order_printers`, `auto_print`, `customer_details`, `local_printers`, `pos_layout_type`) VALUES
(1, 22, 20, 3, 1, 3, '1', 'GST Reg', 'VAT Reg', '123456789', '987654321', '1', 'x1C', 'Ctrl+F3', 'Ctrl+Shift+M', 'Ctrl+Shift+C', 'Ctrl+Shift+A', 'Ctrl+F11', 'Ctrl+F12', 'F4', 'F7', 'F9', 'F8', 'Ctrl+F1', 'Ctrl+F2', 'Ctrl+F10', 1, NULL, 0, 'default', 1, 0, 0, 0, 42, '12345678', 'purchase_code', 'envato_username', '3.4.53', 0, 0, 0, '', 1, 1, 'null', 0, 0, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sls_printers`
--

CREATE TABLE `sls_printers` (
  `id` int(11) NOT NULL,
  `title` varchar(55) NOT NULL,
  `print_type` varchar(255) DEFAULT NULL,
  `type` varchar(25) NOT NULL,
  `profile` varchar(25) NOT NULL,
  `char_per_line` tinyint(3) UNSIGNED DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `ip_address` varbinary(45) DEFAULT NULL,
  `port` varchar(10) DEFAULT NULL,
  `pc_no` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_printers`
--

INSERT INTO `sls_printers` (`id`, `title`, `print_type`, `type`, `profile`, `char_per_line`, `path`, `ip_address`, `port`, `pc_no`) VALUES
(1, '80mm Series Printer', 'primary', 'network', 'default', 47, '', 0x3139322e3136382e312e313931, '9100', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sls_products`
--

CREATE TABLE `sls_products` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_alt` varchar(255) DEFAULT NULL,
  `unit` int(11) DEFAULT NULL,
  `cost` decimal(25,4) DEFAULT NULL,
  `price` decimal(25,4) NOT NULL,
  `alert_quantity` decimal(15,4) DEFAULT 20.0000,
  `image` varchar(255) DEFAULT 'no_image.png',
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `cf1` varchar(255) DEFAULT NULL,
  `cf2` varchar(255) DEFAULT NULL,
  `cf3` varchar(255) DEFAULT NULL,
  `cf4` varchar(255) DEFAULT NULL,
  `cf5` varchar(255) DEFAULT NULL,
  `cf6` varchar(255) DEFAULT NULL,
  `quantity` decimal(15,4) DEFAULT 0.0000,
  `tax_rate` int(11) DEFAULT NULL,
  `track_quantity` tinyint(1) DEFAULT 1,
  `details` varchar(1000) DEFAULT NULL,
  `warehouse` int(11) DEFAULT NULL,
  `barcode_symbology` varchar(55) NOT NULL DEFAULT 'code128',
  `file` varchar(100) DEFAULT NULL,
  `product_details` text DEFAULT NULL,
  `tax_method` tinyint(1) DEFAULT 0,
  `type` varchar(55) NOT NULL DEFAULT 'standard',
  `supplier1` int(11) DEFAULT NULL,
  `supplier1price` decimal(25,4) DEFAULT NULL,
  `supplier2` int(11) DEFAULT NULL,
  `supplier2price` decimal(25,4) DEFAULT NULL,
  `supplier3` int(11) DEFAULT NULL,
  `supplier3price` decimal(25,4) DEFAULT NULL,
  `supplier4` int(11) DEFAULT NULL,
  `supplier4price` decimal(25,4) DEFAULT NULL,
  `supplier5` int(11) DEFAULT NULL,
  `supplier5price` decimal(25,4) DEFAULT NULL,
  `promotion` tinyint(1) DEFAULT 0,
  `promo_price` decimal(25,4) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `supplier1_part_no` varchar(50) DEFAULT NULL,
  `supplier2_part_no` varchar(50) DEFAULT NULL,
  `supplier3_part_no` varchar(50) DEFAULT NULL,
  `supplier4_part_no` varchar(50) DEFAULT NULL,
  `supplier5_part_no` varchar(50) DEFAULT NULL,
  `sale_unit` int(11) DEFAULT NULL,
  `purchase_unit` int(11) DEFAULT NULL,
  `brand` int(11) DEFAULT NULL,
  `slug` varchar(55) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `weight` decimal(10,4) DEFAULT NULL,
  `hsn_code` int(11) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `hide` tinyint(1) NOT NULL DEFAULT 0,
  `second_name` varchar(255) DEFAULT NULL,
  `hide_pos` tinyint(1) NOT NULL DEFAULT 0,
  `is_packed` tinyint(2) NOT NULL DEFAULT 0,
  `pack_piece` int(11) DEFAULT NULL,
  `packed_product` varchar(255) DEFAULT NULL,
  `is_synchronize` tinyint(4) DEFAULT 0,
  `display_serial` int(11) DEFAULT NULL,
  `printer_selection` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_products`
--

INSERT INTO `sls_products` (`id`, `code`, `name`, `name_alt`, `unit`, `cost`, `price`, `alert_quantity`, `image`, `category_id`, `subcategory_id`, `cf1`, `cf2`, `cf3`, `cf4`, `cf5`, `cf6`, `quantity`, `tax_rate`, `track_quantity`, `details`, `warehouse`, `barcode_symbology`, `file`, `product_details`, `tax_method`, `type`, `supplier1`, `supplier1price`, `supplier2`, `supplier2price`, `supplier3`, `supplier3price`, `supplier4`, `supplier4price`, `supplier5`, `supplier5price`, `promotion`, `promo_price`, `start_date`, `end_date`, `supplier1_part_no`, `supplier2_part_no`, `supplier3_part_no`, `supplier4_part_no`, `supplier5_part_no`, `sale_unit`, `purchase_unit`, `brand`, `slug`, `featured`, `weight`, `hsn_code`, `views`, `hide`, `second_name`, `hide_pos`, `is_packed`, `pack_piece`, `packed_product`, `is_synchronize`, `display_serial`, `printer_selection`) VALUES
(1, '1', 'حبة شواية مع الرز', NULL, 1, '38.0000', '38.0000', '0.0000', 'ebe305c964e103a471541ddc588483ce.png', 9, NULL, '', '', '', '', '', '', '45.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '3838383', NULL, '0.0000', NULL, 0, 0, ' SHAWAYA RICE', 0, 0, 0, '', 0, 1, ''),
(2, '2', 'نص الشواية مع الرز', NULL, 1, '19.0000', '19.0000', '0.0000', '56643cb6ea296b3beaee0249a69c14ce.png', 9, NULL, '', '', '', '', '', '', '-6459.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '47484838', NULL, '0.0000', NULL, 1, 0, '1/2 SHAWAYA RICE', 0, 0, 0, '', 0, 5, ''),
(3, '3', 'حبة الفحم مع الرز', NULL, 1, '40.0000', '40.0000', '0.0000', 'bcf830dc271502381475f89d4b9eb650.png', 2, NULL, '', '', '', '', '', '', '-1919.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '37838383', NULL, '0.0000', NULL, 0, 0, ' FAHAM RICE', 0, 0, 0, '', 0, 0, ''),
(4, '4', ' نص الفحم مع الرز', NULL, 1, '20.0000', '20.0000', '0.0000', '38d5e072b497649c9982b2b0f7eb27a1.png', 2, NULL, '', '', '', '', '', '', '-3.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '8383838', NULL, '0.0000', NULL, 1, 0, '1/2 FAHAM RICE', 0, 0, 0, '', 0, 3, ''),
(5, '5', 'سمك فيليه مع الرز', NULL, 1, '25.0000', '25.0000', '0.0000', '2a9c3b1d3c42bac4a5d1ff11b0c76993.png', 3, NULL, '', '', '', '', '', '', '-228.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '06095070492424086', NULL, '0.0000', NULL, 0, 0, 'SAMAK FELT &amp; RICE', 0, 0, 0, '', 0, 1, ''),
(6, '6', 'نفر كبسة لحم', NULL, 1, '56.0000', '56.0000', '0.0000', '61b1f8b2fe39cb23514356df408a491e.png', 10, NULL, '', '', '', '', '', '', '-77.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '020758385064993723', NULL, '0.0000', NULL, 0, 0, 'KABSA LAHAM', 0, 0, 0, '', 0, 1, NULL),
(7, '7', 'نص كبسة لحم', NULL, 1, '28.0000', '28.0000', '0.0000', 'eda62cc9b2f81ece9afdeb68b472dafe.png', 10, NULL, '', '', '', '', '', '', '-497.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '030669606611724687', NULL, '0.0000', NULL, 0, 0, '1/2 KABSA LAHAM', 0, 0, 0, '', 0, 2, NULL),
(8, '8', 'نفر البخاري', NULL, 1, '6.0000', '6.0000', '0.0000', '3b5dc706bdb8fd43d9620b4b952ba197.png', 11, NULL, '', '', '', '', '', '', '-3768.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '08245344828680068', NULL, '0.0000', NULL, 0, 0, 'BOKHARI RICE', 0, 0, 0, '', 0, 1, ''),
(9, '9', 'نفر البرياني', NULL, 1, '6.0000', '6.0000', '0.0000', '2da99e03dfaed7b96a74fcba63f9bc72.png', 11, NULL, '', '', '', '', '', '', '-1955.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '07703179171554586', NULL, '0.0000', NULL, 0, 0, 'BIRIANI RICE', 0, 0, 0, '', 0, 2, ''),
(10, '11', 'حبة شواية سادة', NULL, 1, '26.0000', '26.0000', '0.0000', '8dba89cf4bed7ce4b73fd19032ac1cab.png', 9, NULL, '', '', '', '', '', '', '1.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '38383838', NULL, '0.0000', NULL, 0, 0, ' SHAWAYA', 0, 0, 0, '', 0, 2, ''),
(11, '12', 'نص شواية سادة', NULL, 1, '13.0000', '13.0000', '0.0000', '8848cdfa5723b1bac559905172c33154.jpeg', 9, NULL, '', '', '', '', '', '', '-2212.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '474738', NULL, '0.0000', NULL, 0, 0, '1/2  SHAWAYA', 0, 0, 0, '', 0, 6, ''),
(12, '13', 'حبة الفحم سادة', NULL, 1, '28.0000', '28.0000', '0.0000', 'bc7b6b4464cef66659097db47f915b9c.jpg', 2, NULL, '', '', '', '', '', '', '-2017.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '84838338', NULL, '0.0000', NULL, 0, 0, ' FAHAM ', 0, 0, 0, '', 0, 2, ''),
(13, '14', 'نص الفحم سادة', NULL, 1, '14.0000', '14.0000', '0.0000', 'ae1f05092c6b771f45cb2765b4ebeb5c.png', 2, NULL, '', '', '', '', '', '', '-3664.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '73833838', NULL, '0.0000', NULL, 0, 0, '1/2  FAHAM ', 0, 0, 0, '', 0, 4, ''),
(14, '15', 'كباب لحم', NULL, 1, '24.0000', '24.0000', '0.0000', 'e51aec33f5a9fe5cb30477e50735e231.png', 3, NULL, '', '', '', '', '', '', '-206.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '034661181957916254', NULL, '0.0000', NULL, 0, 0, 'KEBAB BEEF', 0, 0, 0, '', 0, 7, ''),
(15, '16', 'اوصال لحم', NULL, 1, '24.0000', '24.0000', '0.0000', 'a7c5c7db7e5926e5a550b5eefa492381.png', 3, NULL, '', '', '', '', '', '', '-117.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '025449061792469707', NULL, '0.0000', NULL, 0, 0, 'AWSAL BEEF', 0, 0, 0, '', 0, 8, ''),
(16, '17', 'كباب دجاج', NULL, 1, '22.0000', '22.0000', '0.0000', '6768ff9eb0afb2bc8e949faf0794c483.png', 3, NULL, '', '', '', '', '', '', '-73.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '022037755139953585', NULL, '0.0000', NULL, 0, 0, 'KEBAB CHICKEN', 0, 0, 0, '', 0, 6, ''),
(17, '18', 'اوصال دجاج بالعظم', NULL, 1, '22.0000', '22.0000', '0.0000', 'b7d079623793950f47b445f851915dbe.png', 3, NULL, '', '', '', '', '', '', '-33.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '027557638351466807', NULL, '0.0000', NULL, 0, 0, 'AWSAL CHICKEN', 0, 0, 0, '', 0, 4, ''),
(18, '19', 'شيش طاووق', NULL, 1, '22.0000', '22.0000', '0.0000', 'babc9fc7ca005c35e1a1b735415d027b.png', 3, NULL, '', '', '', '', '', '', '-163.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '042205581450487806', NULL, '0.0000', NULL, 0, 0, 'SEESH TAOUQ', 0, 0, 0, '', 0, 5, ''),
(19, '20', 'سمك فيليه ساده', NULL, 1, '19.0000', '19.0000', '0.0000', '79a3eeb3dd5e0b70d941ce9fff2ff30b.png', 3, NULL, '', '', '', '', '', '', '-289.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '09795827296243351', NULL, '0.0000', NULL, 0, 0, 'SAMAK FELT', 0, 0, 0, '', 0, 2, NULL),
(20, '21', 'اوصال سمك فيليه', NULL, 1, '20.0000', '20.0000', '0.0000', '76a4cb5fde794e70f11c9010dc371bc2.png', 3, NULL, '', '', '', '', '', '', NULL, 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '01219439237346438', NULL, '0.0000', NULL, 0, 0, 'AWSAL SAMAK', 0, 0, 0, '', 0, 3, NULL),
(21, '22', 'ايدام خضار مشكل كبير', NULL, 1, '7.0000', '7.0000', '0.0000', '28f44e868c545a640cdeee62297fcfa5.png', 4, NULL, '', '', '', '', '', '', '-91.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '22', NULL, '0.0000', NULL, 0, 0, 'EDAM MIX LARGE', 0, 0, 0, '', 0, NULL, NULL),
(22, '23', 'ايدام دجاج كبير', NULL, 1, '8.0000', '8.0000', '0.0000', '92b28b8c4e60332340cf85d998da967e.png', 4, NULL, '', '', '', '', '', '', '-61.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '23', NULL, '0.0000', NULL, 0, 0, 'EDAM CHICKEN LARGE', 0, 0, 0, '', 0, NULL, NULL),
(23, '24', 'ايدام مسقع كبير', NULL, 1, '7.0000', '7.0000', '0.0000', '2a82e73ee256a121fc6699cbbcf3cc11.png', 4, NULL, '', '', '', '', '', '', '-82.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '24', NULL, '0.0000', NULL, 0, 0, 'EDAM MOSAGA LARGE', 0, 0, 0, '', 0, NULL, NULL),
(24, '25', 'ملوخية كبير', NULL, 1, '7.0000', '7.0000', '0.0000', 'a0ddf4afd41b254b55d29d6d756d0df7.png', 4, NULL, '', '', '', '', '', '', '-54.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '25', NULL, '0.0000', NULL, 0, 0, 'MOLOKHIA LARGE', 0, 0, 0, '', 0, NULL, NULL),
(25, '26', 'ايدام بامية كبير', NULL, 1, '7.0000', '7.0000', '0.0000', '0e2e53a9590739c8a8e24eaf750f166c.png', 4, NULL, '', '', '', '', '', '', '-60.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '26', NULL, '0.0000', NULL, 0, 0, 'EDAM PAMIA LARGE', 0, 0, 0, '', 0, NULL, NULL),
(26, '27', 'ايدام فاصوليا كبير', NULL, 1, '7.0000', '7.0000', '0.0000', '34f4b36581962dd7c4be4d50dd8267b1.png', 4, NULL, '', '', '', '', '', '', '0.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '27', NULL, '0.0000', NULL, 0, 0, 'EDAM PHASOLA LARGE', 0, 0, 0, '', 0, 0, ''),
(27, '28', 'ايدام بطاطس كبير', NULL, 1, '7.0000', '7.0000', '0.0000', '39a1fcdfe31bc3634a52c592cf6502dd.png', 4, NULL, '', '', '', '', '', '', '-47.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '28', NULL, '0.0000', NULL, 0, 0, 'EDAM POTATO LARGE', 0, 0, 0, '', 0, NULL, NULL),
(28, '29', 'مكرونة كبير', NULL, 1, '5.0000', '5.0000', '0.0000', '80b55d34a15c78dbf12021c99440901d.png', 4, NULL, '', '', '', '', '', '', '-105.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '03566161178366616', NULL, '0.0000', NULL, 0, 0, 'MAKARONA LARGE', 0, 0, 0, '', 0, 0, NULL),
(29, '30', 'سلطة خضار كبير', NULL, 1, '6.0000', '6.0000', '0.0000', 'ce9653c6012f275f96dca51b00ae4541.png', 5, NULL, '', '', '', '', '', '', '-387.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '0614646734688161', NULL, '0.0000', NULL, 0, 0, 'SALAD LARGE', 0, 0, 0, '', 0, 2, NULL),
(30, '31', 'صحن مقبلات مشكلة', NULL, 1, '8.0000', '8.0000', '0.0000', 'd080918330231eac3102517fdf65a164.png', 5, NULL, '', '', '', '', '', '', '-79.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '06652174438881759', NULL, '0.0000', NULL, 0, 0, 'MIX APPETRERS', 0, 0, 0, '', 0, 11, NULL),
(31, '32', 'سلطة خيار باللبن', NULL, 1, '3.5000', '3.5000', '0.0000', '5060d384b2652f4bfd558b2ed2e84930.png', 5, NULL, '', '', '', '', '', '', '-1260.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '08330440452542802', NULL, '0.0000', NULL, 0, 0, 'SALAD  KHIAR LABAN', 0, 0, 0, '', 0, 4, NULL),
(32, '33', 'سلطة حارة خضراء', NULL, 1, '3.5000', '3.5000', '0.0000', '8e990bef7c00074f29a8482376c0dac7.png', 5, NULL, '', '', '', '', '', '', '-154.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '33', NULL, '0.0000', NULL, 0, 0, 'SALAD HOT GREEN', 0, 0, 0, '', 0, 8, NULL),
(33, '34', 'شطة سومطرا', NULL, 1, '3.5000', '3.5000', '0.0000', '30221a2cac27f7b2906382166252a3a1.png', 5, NULL, '', '', '', '', '', '', '-125.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '08560374672472366', NULL, '0.0000', NULL, 0, 0, 'SHATA SOMATRA', 0, 0, 0, '', 0, 10, NULL),
(34, '35', 'شطة رنا', NULL, 1, '1.0000', '1.0000', '0.0000', '22be6a23908c3aca72830dd5f9595a6c.png', 5, NULL, '', '', '', '', '', '', '-198.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '05598746144620679', NULL, '0.0000', NULL, 0, 0, 'SHATA RANA', 0, 0, 0, '', 0, 9, NULL),
(35, '36', 'كنافة البركة', NULL, 1, '9.0000', '9.0000', '0.0000', 'd0dd6cde9c688477d278343cf01775c9.png', 6, NULL, '', '', '', '', '', '', '-6780.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '36691733151514', NULL, '0.0000', NULL, 0, 0, 'KENAFA ALBARAKA', 0, 0, 0, '', 0, 1, ''),
(36, '38', 'حلى اوريو', NULL, 1, '7.0000', '7.0000', '0.0000', '10ae576db0c5e04b24618be44c509891.png', 6, NULL, '', '', '', '', '', '', '-115.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '05397885759701968', NULL, '0.0000', NULL, 0, 0, 'OREO', 0, 0, 0, '', 0, 3, NULL),
(37, '37', 'بسبوسة', NULL, 1, '3.5000', '3.5000', '0.0000', '44eb65c336806b8c53ab874622fca30d.jpg', 6, NULL, '', '', '', '', '', '', '-123.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '08141494967089582', NULL, '0.0000', NULL, 0, 0, 'BASBOSA', 0, 0, 0, '', 0, 2, NULL),
(38, '39', 'مشروبات غازية', NULL, 1, '2.5000', '2.5000', '0.0000', '753356b470103d6855bd07493c14d0b4.png', 7, NULL, '', '', '', '', '', '', '-18211.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '05607203290315323', NULL, '0.0000', NULL, 0, 0, 'PEPSI ', 0, 0, 0, '', 0, 1, NULL),
(39, '40', 'لبن القرية', NULL, 1, '3.0000', '3.0000', '0.0000', '1e87bb7e2f1fd1ea4076a564229bef1a.png', 7, NULL, '', '', '', '', '', '', '-1500.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '09972388550162969', NULL, '0.0000', NULL, 0, 0, 'LABAN ALQARIA SR3', 0, 0, 0, '', 0, 11, ''),
(40, '41', 'لبن نادك', NULL, 1, '1.5000', '1.5000', '0.0000', '94e0bbb38b3c3e64559ee0698cadbed5.png', 7, NULL, '', '', '', '', '', '', '-1770.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '09129156031938839', NULL, '0.0000', NULL, 0, 0, 'LABAN NADIC SR1.25', 0, 0, 0, '', 0, 8, ''),
(41, '42', 'ماء بريال', NULL, 1, '1.0000', '1.0000', '0.0000', '24caa9de94aae058ffec7a858a2316b7.png', 7, NULL, '', '', '', '', '', '', '-2712.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '01399373918641238', NULL, '0.0000', NULL, 0, 0, 'WATER SR1', 0, 0, 0, '', 0, 5, NULL),
(42, '43', 'ماء صغير', NULL, 1, '0.5000', '0.5000', '0.0000', '9844308bab280af9eb543d6597a54173.png', 7, NULL, '', '', '', '', '', '', '-3879.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '07160168863202212', NULL, '0.0000', NULL, 0, 0, 'WATER SMAIL', 0, 0, 0, '', 0, 4, NULL),
(43, '39432770', 'مهلبية', NULL, 1, '3.5000', '3.5000', '0.0000', 'd4c87c854cbee51581950e96a210b03c.jpg', 6, NULL, '', '', '', '', '', '', '-105.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '16511516', NULL, '0.0000', NULL, 0, 0, 'MOHALABIA', 0, 0, 0, '', 0, 6, NULL),
(44, '38776365', 'حلى كراميل', NULL, 1, '7.0000', '7.0000', '0.0000', '7d1953a30240a3256d4f20a2fbcf0bb6.png', 6, NULL, '', '', '', '', '', '', '-124.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '38776365', NULL, '0.0000', NULL, 0, 0, 'CARAMEL', 0, 0, 0, '', 0, 4, NULL),
(45, '66425454', 'زبادي نادك', NULL, 1, '1.5000', '1.5000', '0.0000', '22287641849246942af239444df889e7.png', 7, NULL, '', '', '', '', '', '', '-1234.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '66425454', NULL, '0.0000', NULL, 0, 0, 'ZABAI NADIC', 0, 0, 0, '', 0, 7, ''),
(46, '54265968', 'لبن القرية كبير', NULL, 1, '8.0000', '8.0000', '0.0000', '8781e12dd31f22520e9a001c6edd2372.png', 7, NULL, '', '', '', '', '', '', '-31.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '54265968', NULL, '0.0000', NULL, 0, 0, 'LABAN ALQARIA SR7.5', 0, 0, 0, '', 0, 12, ''),
(47, '13204385', 'لبن نادك كبير', NULL, 1, '7.5000', '7.5000', '0.0000', 'c0ed31c92f7e127576e0c865183a9bd7.png', 7, NULL, '', '', '', '', '', '', '-50.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '13204385', NULL, '0.0000', NULL, 0, 0, 'LABAN NADIC SR7.5', 0, 0, 0, '', 0, 10, NULL),
(48, '30762605', 'لبن نادك وسط', NULL, 1, '2.5000', '2.5000', '0.0000', '8243f0261cfaf74c4d59f7bbda3ec70b.png', 7, NULL, '', '', '', '', '', '', '-128.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '30762605', NULL, '0.0000', NULL, 0, 0, 'LABAN NADIC SR2.25', 0, 0, 0, '', 0, 9, ''),
(49, '94857486', 'سبوسة لحم', NULL, 1, '1.0000', '1.0000', '0.0000', '72a8d7a073c902e35d9665083ea7130e.jpg', 5, NULL, '', '', '', '', '', '', '0.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '94857486', NULL, '0.0000', NULL, 0, 0, 'SAMBOSA BEEF', 0, 0, 0, '', 0, 14, NULL),
(50, '19251454', 'سبوسة جبنة', NULL, 1, '1.0000', '1.0000', '0.0000', 'd858536d2ca7e2deb654b877575d51e7.jpg', 5, NULL, '', '', '', '', '', '', '-11.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '19251454', NULL, '0.0000', NULL, 0, 0, 'SAMBOSA JEPNA', 0, 0, 0, '', 0, 13, NULL),
(51, '01936428', 'طحينة', NULL, 1, '3.5000', '3.5000', '0.0000', 'fd5dfc696ea6d86124388d4b02b20f83.jpg', 5, NULL, '', '', '', '', '', '', '-457.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '01936428', NULL, '0.0000', NULL, 0, 0, 'TAHINIA', 0, 0, 0, '', 0, 5, NULL),
(52, '12714827', 'سلطة خضار صغير', NULL, 1, '3.5000', '3.5000', '0.0000', 'edd90d35c8838f317c02636419d26726.png', 5, NULL, '', '', '', '', '', '', '-607.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '12714827', NULL, '0.0000', NULL, 0, 0, 'SALAD SMAIL', 0, 0, 0, '', 0, 1, NULL),
(53, '91684883', 'مشروب غازي وسط', NULL, 1, '5.0000', '5.0000', '0.0000', 'b5be070629fe58c88f0e85c68da0cf82.png', 7, NULL, '', '', '', '', '', '', '-978.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '91684883', NULL, '0.0000', NULL, 0, 0, 'PEPSI SR5', 0, 0, 0, '', 0, 2, NULL),
(54, '40349825', 'مشروب غازي كبير', NULL, 1, '9.0000', '9.0000', '0.0000', 'a8932c478dcf3b16e52908cc55b7e009.png', 7, NULL, '', '', '', '', '', '', '-1166.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '40349825', NULL, '0.0000', NULL, 0, 0, 'PEPSI SR9', 0, 0, 0, '', 0, 3, NULL),
(55, '36691733', 'مكرونة صغير', NULL, 1, '3.0000', '3.0000', '0.0000', '99fb322ece715134148e04dc8ae2689d.png', 8, NULL, '', '', '', '', '', '', '-70.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '36691733', NULL, '0.0000', NULL, 0, 0, 'MAKARONA SMALL', 0, 0, 0, '', 0, 0, NULL),
(56, '66398140', 'ربع الشواية الرز', NULL, 1, '11.0000', '11.0000', '0.0000', '65456d0e75a4d3cde66d12972faaa415.png', 9, NULL, '', '', '', '', '', '', '-7908.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '4473783', NULL, '0.0000', NULL, 0, 0, '1/4 SHAWAYA RICE', 0, 0, 0, '', 0, 7, ''),
(57, '08557108', 'ربع الشواية ', NULL, 1, '7.0000', '7.0000', '0.0000', 'ecc9371de40f7c41ca9bc6600cae9644.jpg', 9, NULL, '', '', '', '', '', '', '-766.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '83383839', NULL, '0.0000', NULL, 0, 0, '1/4  SHAWAYA ', 0, 0, 0, '', 0, 8, ''),
(59, '228', ' ايدام خضار مشكل صغير', NULL, 1, '5.0000', '5.0000', '0.0000', '28f44e868c545a640cdeee62297fcfa5.png', 8, NULL, '', '', '', '', '', '', '-658.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '228', NULL, '0.0000', NULL, 0, 0, 'EDAM MIX SMALL', 0, 0, 0, '', 0, NULL, NULL),
(60, '238', 'ايدام دجاج صغير', NULL, 1, '5.0000', '5.0000', '0.0000', '92b28b8c4e60332340cf85d998da967e.png', 8, NULL, '', '', '', '', '', '', '-202.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '238', NULL, '0.0000', NULL, 0, 0, 'EDAM CHICKEN SMALL', 0, 0, 0, '', 0, NULL, NULL),
(61, '248', 'ايدام مسقع صغير', NULL, 1, '5.0000', '5.0000', '0.0000', '2a82e73ee256a121fc6699cbbcf3cc11.png', 8, NULL, '', '', '', '', '', '', '-714.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '248', NULL, '0.0000', NULL, 0, 0, 'EDAM MOSAGA SMALL', 0, 0, 0, '', 0, NULL, NULL),
(62, '258', 'ملوخية صغير', NULL, 1, '5.0000', '5.0000', '0.0000', 'a0ddf4afd41b254b55d29d6d756d0df7.png', 8, NULL, '', '', '', '', '', '', '-528.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '258', NULL, '0.0000', NULL, 0, 0, 'MOLOKHIA SMALL', 0, 0, 0, '', 0, NULL, NULL),
(63, '268', 'ايدام بامية صغير', NULL, 1, '5.0000', '5.0000', '0.0000', '0e2e53a9590739c8a8e24eaf750f166c.png', 8, NULL, '', '', '', '', '', '', '-406.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '268', NULL, '0.0000', NULL, 0, 0, 'EDAM PAMIA SMALL', 0, 0, 0, '', 0, NULL, NULL),
(64, '278', 'ايدام فاصوليا صغير', NULL, 1, '5.0000', '5.0000', '0.0000', '34f4b36581962dd7c4be4d50dd8267b1.png', 8, NULL, '', '', '', '', '', '', '-482.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '278', NULL, '0.0000', NULL, 0, 0, 'EDAM PHASOLA SMALL', 0, 0, 0, '', 0, NULL, NULL),
(65, '288', 'ايدام بطاطس صغير', NULL, 1, '5.0000', '5.0000', '0.0000', '39a1fcdfe31bc3634a52c592cf6502dd.png', 8, NULL, '', '', '', '', '', '', '-434.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '288', NULL, '0.0000', NULL, 0, 0, 'EDAM POTATO SMALL', 0, 0, 0, '', 0, NULL, NULL),
(66, '05205838', 'نفر بشاوري', NULL, 1, '7.0000', '7.0000', '0.0000', '47d84aa824f792dcb41e28b1e6db8f6a.jpg', 11, NULL, '', '', '', '', '', '', '-1.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '05205838', NULL, '0.0000', NULL, 0, 0, 'BASHAWAR RICE', 0, 0, 0, '', 0, 7, NULL),
(67, '91678429', 'رز بالحليب', NULL, 1, '3.5000', '3.5000', '0.0000', 'd4db5a3bcf99384c7b1e6d54d04f079e.jpg', 6, NULL, '', '', '', '', '', '', '-76.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '91678429', NULL, '0.0000', NULL, 0, 0, 'RICE MILK', 0, 0, 0, '', 0, 7, NULL),
(69, '85498336', 'مشويات مشكل كبير', NULL, 1, '45.0000', '45.0000', '0.0000', '192e9069a475050115c3ab0dbd9e6d20.jpg', 3, NULL, '', '', '', '', '', '', '-8.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '85498336', NULL, '0.0000', NULL, 0, 0, 'MIX BBQBIG', 0, 0, 0, '', 0, 10, NULL),
(70, '57485950', 'نصف لحم سادة', NULL, 1, '24.0000', '24.0000', '0.0000', 'e734f0dc07d6024b2d74fefa7961dfe1.jpg', 10, NULL, '', '', '', '', '', '', '-13.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '57485950', NULL, '0.0000', NULL, 0, 0, '1/2 KABSA LAHAM SADA', 0, 0, 0, '', 0, 3, NULL),
(71, '51718621', 'حلى سندس', NULL, 1, '5.0000', '5.0000', '0.0000', '2e875b27f0f142eb0c66e127cde21176.jpg', 6, NULL, '', '', '', '', '', '', '-154.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '51718621', NULL, '0.0000', NULL, 0, 0, 'HALA SUNDOS', 0, 0, 0, '', 0, 5, NULL),
(72, '01329897', 'مشويات مشكل', NULL, 1, '22.0000', '22.0000', '0.0000', '7bdcde35412968e32c5de9827646c80b.jpg', 3, NULL, '', '', '', '', '', '', '-95.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '01329897', NULL, '0.0000', NULL, 0, 0, 'MIX BBQ', 0, 0, 0, '', 0, 9, ''),
(73, '54973464', 'ماء 3 ريال', NULL, 1, '3.0000', '3.0000', '0.0000', '52d67bbd550f75cffd07242f6be9bfcb.jpg', 7, NULL, '', '', '', '', '', '', '0.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '54973464', NULL, '0.0000', NULL, 0, 0, 'WATER SR3', 1, 0, 0, '', 0, NULL, NULL),
(74, '00670212', 'ماء 4 ريال', NULL, 1, '4.0000', '4.0000', '0.0000', 'e61e275b30d0d870974870b2b8c0eecb.jpg', 7, NULL, '', '', '', '', '', '', '0.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '00670212', NULL, '0.0000', NULL, 0, 0, 'WATER SR4', 1, 0, 0, '', 0, NULL, NULL),
(75, '20871051', 'ماء ريالين', NULL, 1, '2.0000', '2.0000', '0.0000', '084c1a941c371b8e425fb429eb891b59.jpg', 7, NULL, '', '', '', '', '', '', '-1.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '20871051', NULL, '0.0000', NULL, 0, 0, 'WATER SR2', 0, 0, 0, '', 0, 6, NULL),
(76, '02867746', 'حبة الا ربع شواية مع الرز', NULL, 1, '30.0000', '30.0000', '0.0000', '857a47e5eea2672756fffb2c1f73383c.jpg', 9, NULL, '', '', '', '', '', '', '-288.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '02867746', NULL, '0.0000', NULL, 0, 0, '1/3 SHAWAYA RICE', 0, 0, 0, '', 0, 3, ''),
(77, '52806251', 'حبة الا ربع شواية ', NULL, 1, '20.0000', '20.0000', '0.0000', '440f01085f787eb491d5f9dca67481f0.jpg', 9, NULL, '', '', '', '', '', '', '-205.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '656568979', NULL, '0.0000', NULL, 0, 0, '1/3  SHAWAYA ', 0, 0, 0, '', 0, 4, ''),
(78, '29696363', 'سلطة حاره', NULL, 1, '3.5000', '3.5000', '0.0000', '96e42dd30d2f8661cda9c7e6e541f1d9.jpg', 5, NULL, '', '', '', '', '', '', '-292.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '29696363', NULL, '0.0000', NULL, 0, 0, 'SALAD HOT', 0, 0, 0, '', 0, 7, NULL),
(79, '26452258', 'صوص كوكتيل', NULL, 1, '3.5000', '3.5000', '0.0000', '0e4685c6e8905bc85828707435d32703.jpg', 5, NULL, '', '', '', '', '', '', '0.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '26452258', NULL, '0.0000', NULL, 0, 0, 'SAUCE COCTAIL', 0, 0, 0, '', 0, 6, NULL),
(80, '45685339', 'سلطة خضار جرجير', NULL, 1, '6.0000', '6.0000', '0.0000', 'f7b665f90bc1c0392a298e660508716d.jpg', 5, NULL, '', '', '', '', '', '', '-173.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '45685339', NULL, '0.0000', NULL, 0, 0, 'SALAD LARGE JARJEI', 0, 0, 0, '', 0, 3, NULL),
(81, '78003512', 'رز البرياني 4 ريال', NULL, 1, '4.0000', '4.0000', '0.0000', 'a03a9e24457e683f2fdbe59d33e4c1f3.png', 11, NULL, '', '', '', '', '', '', '-643.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '78003512', NULL, '0.0000', NULL, 0, 0, 'RICE 4SR', 0, 0, 0, '', 0, 5, NULL),
(82, '34816092', 'رز بخاري 4 ريال', NULL, 1, '4.0000', '4.0000', '0.0000', '84558e83460bab5c0bb71cfc8047ecbe.png', 11, NULL, '', '', '', '', '', '', '-978.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '34816092', NULL, '0.0000', NULL, 0, 0, 'RICE SR4', 0, 0, 0, '', 0, 4, NULL),
(83, '98595847', 'نفر مشكل', NULL, 1, '6.0000', '6.0000', '0.0000', '7c19e90488419453b924420384b6381a.jpg', 11, NULL, '', '', '', '', '', '', '-269.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '98595847', NULL, '0.0000', NULL, 0, 0, 'RICE MIX', 0, 0, 0, '', 0, 3, ''),
(84, '03869391', 'رز مشكل 4 ريال', NULL, 1, '4.0000', '4.0000', '0.0000', '66c112239dd5d3bc2878d0407c93f6da.jpg', 11, NULL, '', '', '', '', '', '', '-1.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0, 0, 0, '03869391', NULL, '0.0000', NULL, 0, 0, 'RICE SR4', 0, 0, 0, '', 0, 6, NULL),
(85, '79013103', 'خبز', NULL, 1, '1.0000', '1.0000', '0.0000', 'no_image.png', 5, NULL, '', '', '', '', '', '', '-1.0000', 2, 1, '', NULL, 'code128', '', '', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '79013103', NULL, '0.0000', NULL, 0, 0, 'bread', 0, 0, 0, '', 0, 12, NULL),
(87, '23302496', 'وجبة وربع الشواية مع الرز', NULL, 1, '8.0000', '8.0000', '0.0000', 'no_image.png', 12, NULL, '', '', '', '', '', '', '0.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, '23302496', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(89, '123312', 'testtes', NULL, 1, '120.0000', '150.0000', '0.0000', 'no_image.png', 2, NULL, '', '', '', '', '', '', '-1.0000', NULL, 1, '', NULL, 'code128', '', '', NULL, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 1, 0, 'testet', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(94, '11223423445', 'Test', NULL, 1, '120.0000', '150.0000', '0.0000', '14045_1.jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '  ', NULL, 'standard', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(95, '49375727', 'abc', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 3, '123.0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '123', NULL, NULL, NULL, NULL, NULL, NULL, 0, '49375727', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, '1'),
(96, '71356220', 'abc', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '71356220', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(97, '58574449', 'hello', NULL, 1, '80.0000', '100.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 3, '123.0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '123', NULL, NULL, NULL, NULL, NULL, NULL, 0, '58574449', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, '1'),
(98, '39276026', 'my1', NULL, 1, '10.0000', '15.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '              ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '39276026', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(99, '03329242', 'my11', NULL, 1, '10.0000', '15.0000', '0.0000', '7bdcde35412968e32c5de9827646c80b.jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '    ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '03329242', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(100, '61720108', 'my2Variant', NULL, 1, '80.0000', '100.0000', '0.0000', '857a47e5eea2672756fffb2c1f73383c.jpg', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 2, 0, NULL, NULL, 'code128', NULL, '                    ', 0, 'standard', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '61720108', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(101, '93710795', 'TestCombo', NULL, NULL, NULL, '250.0000', '0.0000', '7bdcde35412968e32c5de9827646c80b.jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '      ', 0, 'combo', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '93710795', NULL, '0.0000', NULL, 0, 0, '', 1, 0, 0, '', 0, 0, ''),
(102, '55215950', 'Serve', NULL, NULL, NULL, '170.0000', '0.0000', '857a47e5eea2672756fffb2c1f73383c.jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'service', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '55215950', NULL, '0.0000', NULL, 0, 0, '', 1, 0, 0, '', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sls_product_variants`
--

CREATE TABLE `sls_product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `cost` decimal(25,4) DEFAULT NULL,
  `price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_product_variants`
--

INSERT INTO `sls_product_variants` (`id`, `product_id`, `name`, `cost`, `price`, `quantity`) VALUES
(10, 1, 'البخاري', NULL, '0.0000', '-3.0000'),
(11, 1, 'البرياني', NULL, '0.0000', '-301.0000'),
(61, 96, 'test', NULL, '120.0000', '10.0000'),
(62, 96, 'test2', NULL, '130.0000', '20.0000'),
(63, 97, 'Small', NULL, '70.0000', '10.0000'),
(64, 97, 'Large', NULL, '90.0000', '20.0000'),
(65, 98, 's', NULL, '11.0000', '10.0000'),
(68, 98, 'm', NULL, '10.0000', '0.0000'),
(70, 100, 's', NULL, '10.0000', NULL),
(71, 100, 'm', NULL, '20.0000', NULL),
(78, 1, 't', NULL, '0.0000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sls_purchase_items`
--

CREATE TABLE `sls_purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_cost` decimal(25,4) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `quantity_balance` decimal(15,4) DEFAULT 0.0000,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `unit_cost` decimal(25,4) DEFAULT NULL,
  `real_unit_cost` decimal(25,4) DEFAULT NULL,
  `quantity_received` decimal(15,4) DEFAULT NULL,
  `supplier_part_no` varchar(50) DEFAULT NULL,
  `purchase_item_id` int(11) DEFAULT NULL,
  `product_unit_id` int(11) DEFAULT NULL,
  `product_unit_code` varchar(10) DEFAULT NULL,
  `unit_quantity` decimal(15,4) NOT NULL,
  `gst` varchar(20) DEFAULT NULL,
  `cgst` decimal(25,4) DEFAULT NULL,
  `sgst` decimal(25,4) DEFAULT NULL,
  `igst` decimal(25,4) DEFAULT NULL,
  `base_unit_cost` decimal(25,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_purchase_items`
--

INSERT INTO `sls_purchase_items` (`id`, `purchase_id`, `transfer_id`, `product_id`, `product_code`, `product_name`, `option_id`, `net_unit_cost`, `quantity`, `warehouse_id`, `item_tax`, `tax_rate_id`, `tax`, `discount`, `item_discount`, `expiry`, `subtotal`, `quantity_balance`, `date`, `status`, `unit_cost`, `real_unit_cost`, `quantity_received`, `supplier_part_no`, `purchase_item_id`, `product_unit_id`, `product_unit_code`, `unit_quantity`, `gst`, `cgst`, `sgst`, `igst`, `base_unit_cost`) VALUES
(4, NULL, NULL, 1, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '8.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(5, 3, NULL, 1, '1122', 'Test', NULL, '120.0000', '50.0000', 1, '0.0000', 1, '0', '0', '0.0000', NULL, '6000.0000', '40.0000', '2022-03-15', 'received', '120.0000', '120.0000', '50.0000', NULL, NULL, 1, '1122', '50.0000', NULL, NULL, NULL, NULL, '120.0000'),
(19, NULL, NULL, 96, '71356220', 'abc', 61, '120.0000', '10.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '1200.0000', '10.0000', '2022-06-13', 'received', '120.0000', NULL, '10.0000', NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(20, NULL, NULL, 96, '71356220', 'abc', 62, '120.0000', '20.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '2400.0000', '20.0000', '2022-06-13', 'received', '120.0000', NULL, '20.0000', NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(21, NULL, NULL, 97, '58574449', 'hello', 63, '72.7273', '10.0000', 1, '72.7273', 2, '10.0000%', NULL, NULL, NULL, '800.0000', '10.0000', '2022-06-13', 'received', '80.0000', NULL, '10.0000', NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, 97, '58574449', 'hello', 64, '72.7273', '20.0000', 1, '145.4545', 2, '10.0000%', NULL, NULL, NULL, '1600.0000', '20.0000', '2022-06-13', 'received', '80.0000', NULL, '20.0000', NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(23, NULL, NULL, 98, '39276026', 'my1', 65, '10.0000', '10.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '100.0000', '10.0000', '2022-06-13', 'received', '10.0000', NULL, '10.0000', NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(24, NULL, NULL, 99, '03329242', 'my1', 66, '10.0000', '10.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '100.0000', '10.0000', '2022-06-13', 'received', '10.0000', NULL, '10.0000', NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(25, NULL, NULL, 99, '03329242', 'my1', 67, '10.0000', '20.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '200.0000', '20.0000', '2022-06-13', 'received', '10.0000', NULL, '20.0000', NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sls_settings`
--

CREATE TABLE `sls_settings` (
  `setting_id` int(1) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logo2` varchar(255) NOT NULL,
  `site_name` varchar(55) NOT NULL,
  `language` varchar(20) NOT NULL,
  `default_warehouse` int(2) NOT NULL,
  `accounting_method` tinyint(4) NOT NULL DEFAULT 0,
  `default_currency` varchar(3) NOT NULL,
  `default_tax_rate` int(2) NOT NULL,
  `rows_per_page` int(2) NOT NULL,
  `version` varchar(10) NOT NULL DEFAULT '1.0',
  `default_tax_rate2` int(11) NOT NULL DEFAULT 0,
  `dateformat` int(11) NOT NULL,
  `sales_prefix` varchar(20) DEFAULT NULL,
  `quote_prefix` varchar(20) DEFAULT NULL,
  `purchase_prefix` varchar(20) DEFAULT NULL,
  `transfer_prefix` varchar(20) DEFAULT NULL,
  `delivery_prefix` varchar(20) DEFAULT NULL,
  `payment_prefix` varchar(20) DEFAULT NULL,
  `return_prefix` varchar(20) DEFAULT NULL,
  `returnp_prefix` varchar(20) DEFAULT NULL,
  `expense_prefix` varchar(20) DEFAULT NULL,
  `item_addition` tinyint(1) NOT NULL DEFAULT 0,
  `theme` varchar(20) NOT NULL,
  `product_serial` tinyint(4) NOT NULL,
  `default_discount` int(11) NOT NULL,
  `product_discount` tinyint(1) NOT NULL DEFAULT 0,
  `discount_method` tinyint(4) NOT NULL,
  `tax1` tinyint(4) NOT NULL,
  `tax2` tinyint(4) NOT NULL,
  `overselling` tinyint(1) NOT NULL DEFAULT 0,
  `restrict_user` tinyint(4) NOT NULL DEFAULT 0,
  `restrict_calendar` tinyint(4) NOT NULL DEFAULT 0,
  `timezone` varchar(100) DEFAULT NULL,
  `iwidth` int(11) NOT NULL DEFAULT 0,
  `iheight` int(11) NOT NULL,
  `twidth` int(11) NOT NULL,
  `theight` int(11) NOT NULL,
  `watermark` tinyint(1) DEFAULT NULL,
  `reg_ver` tinyint(1) DEFAULT NULL,
  `allow_reg` tinyint(1) DEFAULT NULL,
  `reg_notification` tinyint(1) DEFAULT NULL,
  `auto_reg` tinyint(1) DEFAULT NULL,
  `protocol` varchar(20) NOT NULL DEFAULT 'mail',
  `mailpath` varchar(55) DEFAULT '/usr/sbin/sendmail',
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtp_user` varchar(100) DEFAULT NULL,
  `smtp_pass` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(10) DEFAULT '25',
  `smtp_crypto` varchar(10) DEFAULT NULL,
  `corn` datetime DEFAULT NULL,
  `customer_group` int(11) NOT NULL,
  `default_email` varchar(100) NOT NULL,
  `mmode` tinyint(1) NOT NULL,
  `bc_fix` tinyint(4) NOT NULL DEFAULT 0,
  `auto_detect_barcode` tinyint(1) NOT NULL DEFAULT 0,
  `captcha` tinyint(1) NOT NULL DEFAULT 1,
  `reference_format` tinyint(1) NOT NULL DEFAULT 1,
  `racks` tinyint(1) DEFAULT 0,
  `attributes` tinyint(1) NOT NULL DEFAULT 0,
  `product_expiry` tinyint(1) NOT NULL DEFAULT 0,
  `decimals` tinyint(2) NOT NULL DEFAULT 2,
  `qty_decimals` tinyint(2) NOT NULL DEFAULT 2,
  `decimals_sep` varchar(2) NOT NULL DEFAULT '.',
  `thousands_sep` varchar(2) NOT NULL DEFAULT ',',
  `invoice_view` tinyint(1) DEFAULT 0,
  `default_biller` int(11) DEFAULT NULL,
  `envato_username` varchar(50) DEFAULT NULL,
  `purchase_code` varchar(100) DEFAULT NULL,
  `rtl` tinyint(1) DEFAULT 0,
  `each_spent` decimal(15,4) DEFAULT NULL,
  `ca_point` tinyint(4) DEFAULT NULL,
  `each_sale` decimal(15,4) DEFAULT NULL,
  `sa_point` tinyint(4) DEFAULT NULL,
  `update` tinyint(1) DEFAULT 0,
  `sac` tinyint(1) DEFAULT 0,
  `display_all_products` tinyint(1) DEFAULT 0,
  `display_symbol` tinyint(1) DEFAULT NULL,
  `symbol` varchar(50) DEFAULT NULL,
  `remove_expired` tinyint(1) DEFAULT 0,
  `barcode_separator` varchar(2) NOT NULL DEFAULT '-',
  `set_focus` tinyint(1) NOT NULL DEFAULT 0,
  `price_group` int(11) DEFAULT NULL,
  `barcode_img` tinyint(1) NOT NULL DEFAULT 1,
  `ppayment_prefix` varchar(20) DEFAULT 'POP',
  `disable_editing` smallint(6) DEFAULT 90,
  `qa_prefix` varchar(55) DEFAULT NULL,
  `update_cost` tinyint(1) DEFAULT NULL,
  `apis` tinyint(1) NOT NULL DEFAULT 0,
  `state` varchar(100) DEFAULT NULL,
  `pdf_lib` varchar(20) DEFAULT 'dompdf',
  `use_code_for_slug` tinyint(1) DEFAULT NULL,
  `ws_barcode_type` varchar(10) DEFAULT 'weight',
  `ws_barcode_chars` tinyint(4) DEFAULT NULL,
  `flag_chars` tinyint(4) DEFAULT NULL,
  `item_code_start` tinyint(4) DEFAULT NULL,
  `item_code_chars` tinyint(4) DEFAULT NULL,
  `price_start` tinyint(4) DEFAULT NULL,
  `price_chars` tinyint(4) DEFAULT NULL,
  `price_divide_by` int(11) DEFAULT NULL,
  `weight_start` tinyint(4) DEFAULT NULL,
  `weight_chars` tinyint(4) DEFAULT NULL,
  `weight_divide_by` int(11) DEFAULT NULL,
  `ksa_qrcode` tinyint(1) DEFAULT NULL,
  `online_link` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `is_half_monthly` tinyint(2) DEFAULT NULL,
  `half_deduct_month` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_settings`
--

INSERT INTO `sls_settings` (`setting_id`, `logo`, `logo2`, `site_name`, `language`, `default_warehouse`, `accounting_method`, `default_currency`, `default_tax_rate`, `rows_per_page`, `version`, `default_tax_rate2`, `dateformat`, `sales_prefix`, `quote_prefix`, `purchase_prefix`, `transfer_prefix`, `delivery_prefix`, `payment_prefix`, `return_prefix`, `returnp_prefix`, `expense_prefix`, `item_addition`, `theme`, `product_serial`, `default_discount`, `product_discount`, `discount_method`, `tax1`, `tax2`, `overselling`, `restrict_user`, `restrict_calendar`, `timezone`, `iwidth`, `iheight`, `twidth`, `theight`, `watermark`, `reg_ver`, `allow_reg`, `reg_notification`, `auto_reg`, `protocol`, `mailpath`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `smtp_crypto`, `corn`, `customer_group`, `default_email`, `mmode`, `bc_fix`, `auto_detect_barcode`, `captcha`, `reference_format`, `racks`, `attributes`, `product_expiry`, `decimals`, `qty_decimals`, `decimals_sep`, `thousands_sep`, `invoice_view`, `default_biller`, `envato_username`, `purchase_code`, `rtl`, `each_spent`, `ca_point`, `each_sale`, `sa_point`, `update`, `sac`, `display_all_products`, `display_symbol`, `symbol`, `remove_expired`, `barcode_separator`, `set_focus`, `price_group`, `barcode_img`, `ppayment_prefix`, `disable_editing`, `qa_prefix`, `update_cost`, `apis`, `state`, `pdf_lib`, `use_code_for_slug`, `ws_barcode_type`, `ws_barcode_chars`, `flag_chars`, `item_code_start`, `item_code_chars`, `price_start`, `price_chars`, `price_divide_by`, `weight_start`, `weight_chars`, `weight_divide_by`, `ksa_qrcode`, `online_link`, `api_key`, `is_half_monthly`, `half_deduct_month`) VALUES
(1, 'logo2.png', 'logo3.png', 'Sales Erp', '', 1, 0, 'SAR', 1, 10, '3.4.53', 0, 4, 'SALE', '', '', '', '', 'IPAY', 'SR', '', '', 0, '', 0, 1, 0, 1, 0, 0, 0, 1, 0, NULL, 800, 800, 0, 0, NULL, 0, 0, 0, NULL, '', NULL, NULL, NULL, 'Alama360alama', NULL, NULL, NULL, 0, 'sales.erp@admin.com', 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, '', '', 1, 3, 'moslehaisoft', '6f1088a7-9623-477f-bc96-20c37ff0c443', 0, NULL, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, 0, '-', 0, NULL, 0, 'POP', NULL, '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', 'ggsk4wkssoc4sccgskggssws04gc4gokc4g4gokw', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sls_suppliers`
--

CREATE TABLE `sls_suppliers` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `vat_number` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL COMMENT '1=paid,2=credit',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `create_by` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_suppliers`
--

INSERT INTO `sls_suppliers` (`id`, `name`, `company_name`, `phone`, `email`, `address`, `city`, `state`, `zip`, `country`, `vat_number`, `status`, `create_date`, `create_by`) VALUES
(3, 'Test', 'test', '01558930222', 'admin@example.com', 'test', 'test', 'Test', '1211', 'BDESH', '1122', 1, '2021-05-24 12:24:47', '2'),
(4, 'Test', 'test', '1232', 'admin2@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:12:45', '2'),
(7, 'Test6', 'test6', '015589', 'admin6@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:14:33', '2'),
(8, 'Test7', 'test7', '01767896', 'admin7@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:15:16', '2'),
(9, 'aisoft', 'Owner', '015589', 'aisoft@example.com', 'test', 'test', 'Test', '1211', 'BDESH', '1122', 1, '2021-05-25 06:10:15', '2'),
(10, 'Test Supplier', 'testsup', '01558933', 'admintest@example.com', 'testsup', 'test', 'Testsup', '121133', 'BDESH', '112233', 1, '2021-05-25 08:36:38', '2');

-- --------------------------------------------------------

--
-- Table structure for table `sls_tax_rates`
--

CREATE TABLE `sls_tax_rates` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `rate` decimal(12,4) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_tax_rates`
--

INSERT INTO `sls_tax_rates` (`id`, `name`, `code`, `rate`, `type`) VALUES
(1, 'No Tax', 'NT', '0.0000', '2'),
(2, 'VAT @10%', 'VAT10', '10.0000', '1'),
(3, 'GST @6%', 'GST', '6.0000', '1'),
(4, 'VAT @20%', 'VT20', '20.0000', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sls_units`
--

CREATE TABLE `sls_units` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(55) NOT NULL,
  `base_unit` int(11) DEFAULT NULL,
  `operator` varchar(1) DEFAULT NULL,
  `unit_value` varchar(55) DEFAULT NULL,
  `operation_value` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_units`
--

INSERT INTO `sls_units` (`id`, `code`, `name`, `base_unit`, `operator`, `unit_value`, `operation_value`) VALUES
(1, '1122', 'pc', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sls_users`
--

CREATE TABLE `sls_users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` int(2) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `company_name` varchar(250) DEFAULT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `security_code` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `is_ban` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_users`
--

INSERT INTO `sls_users` (`id`, `user_id`, `username`, `password`, `phone`, `email`, `user_type`, `last_name`, `first_name`, `company_name`, `logo`, `security_code`, `status`, `is_ban`) VALUES
(1, '2', 'admin@example.com', '41d99b369894eb1ec3f461135132d8bb', '', 'admin@example.com	', 1, '', '', NULL, NULL, NULL, 1, 0),
(2, '500636', 'aisoft@example.com', '41d99b369894eb1ec3f461135132d8bb', '01558930222', 'aisoft@example.com', 1, '', '', NULL, NULL, NULL, 1, 0),
(5, '944721', 'admin2@example.com', '41d99b369894eb1ec3f461135132d8bb', '+355672122345', 'admin@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(6, '723691', 'admin3@example.com', '41d99b369894eb1ec3f461135132d8bb', '01558930222', 'admin@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(16, '849900', 'admin55@example.com', '41d99b369894eb1ec3f461135132d8bb', '+8801558934345', 'admin@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(8, '661309', 'admin5@example.com', '41d99b369894eb1ec3f461135132d8bb', '01558930222', 'admin@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(9, '228799', 'admin6@example.com', '41d99b369894eb1ec3f461135132d8bb', '01558930222', 'admin@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(10, '548261', 'admin@example.com', '41d99b369894eb1ec3f461135132d8bb', '01558930222', 'admin@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(17, '476538', 'owner@tecdiary.com', '82c1ab9f315f15ff53d5bba77c9a1884', '+355672133456', 'admin@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(12, '125832', 'admin9@example.com', '41d99b369894eb1ec3f461135132d8bb', '01558930222', 'admin@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(13, '493344', 'admin@example.com', '41d99b369894eb1ec3f461135132d8bb', '01558930222', 'admin@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(14, '597571', 'admin12@example.com', '41d99b369894eb1ec3f461135132d8bb', '+1123124', 'admin12@example.com', 0, 'Aisoft', 'Aisoft', NULL, './assets/uploads/users/iguacu-falls-argentina-1_1621783704.jpg', NULL, 1, 0),
(15, '898001', 'ferdous1122@example.com', '41d99b369894eb1ec3f461135132d8bb', '01558930222', 'ferdous1122@example.com', 0, '', '', NULL, NULL, NULL, 1, 0),
(18, '284963', 'aisoft11@example.com', '41d99b369894eb1ec3f461135132d8bb', '+8801746457890', 'aisoft11@example.com', 0, 'Ltd', 'Aisoft', NULL, './admin/assets/img/user/2021-05-23/0c193f585f3b9fdc7ca3019df058a95f.jpg', NULL, 1, 0),
(19, '222789', 'admin13@example.com', 'a9f271f4c83b2268ca22fb7ef04727c2', '+11231244', 'admin13@example.com', 0, 'Salehin', 'Ferdous', NULL, './assets/uploads/users/46_49_1621840225.jpg', NULL, 1, 0),
(20, '88489', 'admin14@example.com', '5ebe9dd4ea7517bd2c30bc46985ef823', '+11231248', 'admin14@example.com', 0, 'Salehin', 'Ferdous', NULL, '', NULL, 1, 0),
(21, '804243', 'admin15@example.com', '41d99b369894eb1ec3f461135132d8bb', '+11234567', 'admin15@example.com', 0, 'Salehin', 'Ferdous', NULL, '', NULL, 1, 0),
(22, '413202', 'owner33@tecdiary.com', '82c1ab9f315f15ff53d5bba77c9a1884', '+1234224', 'owner33@tecdiary.com', 0, 'Aisoft', 'Aisoft', NULL, './admin/assets/img/user/2021-05-23/054610f930db49f1751a26ae75c4382c.jpg', NULL, 1, 0),
(23, '928400', 'ownersd@tecdiary.com', '82c1ab9f315f15ff53d5bba77c9a1884', '+112345', 'adminasd@example.com', 0, 'Salehin', 'Ferdous', NULL, 'E1P.jpg', NULL, 1, 0),
(24, '772860', 'owner423@tecdiary.com', '82c1ab9f315f15ff53d5bba77c9a1884', '+123424', 'admin432@example.com', 0, 'Salehin', 'Ferdous', NULL, NULL, NULL, 1, 0),
(25, '418517', 'owner3311@tecdiary.com', '82c1ab9f315f15ff53d5bba77c9a1884', '+11231414', 'admin3311@example.com', 0, 'Salehin', 'Ferdous', NULL, './assets/uploads/users/R4bc55f1d2861da6cf01465822d3a2d92_1621783935.jpg', NULL, 1, 0),
(26, '194695', 'ownervc@tecdiary.com', '82c1ab9f315f15ff53d5bba77c9a1884', '+1324234', 'admincv@example.com', 0, 'Salehin', 'Ferdous55', NULL, './assets/uploads/users/R4bc55f1d2861da6cf01465822d3a2d92_1621784098.jpg', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sls_variants`
--

CREATE TABLE `sls_variants` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sls_warehouses`
--

CREATE TABLE `sls_warehouses` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `map` varchar(255) DEFAULT NULL,
  `phone` varchar(55) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `price_group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_warehouses`
--

INSERT INTO `sls_warehouses` (`id`, `code`, `name`, `address`, `map`, `phone`, `email`, `price_group_id`) VALUES
(1, 'WHI', 'Warehouse 1', '<p>Address, City</p>', NULL, '012345678', 'whi@tecdiary.com', NULL),
(2, 'WHII', 'Warehouse 2', '<p>Warehouse 2, Jalan Sultan Ismail, 54000, Kuala Lumpur</p>', NULL, '0105292122', 'whii@tecdiary.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sls_warehouses_products`
--

CREATE TABLE `sls_warehouses_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `rack` varchar(55) DEFAULT NULL,
  `avg_cost` decimal(25,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_warehouses_products`
--

INSERT INTO `sls_warehouses_products` (`id`, `product_id`, `warehouse_id`, `quantity`, `rack`, `avg_cost`) VALUES
(106, 98, 1, '0.0000', NULL, '10.0000'),
(107, 98, 2, '0.0000', NULL, '10.0000'),
(108, 99, 1, '0.0000', NULL, '10.0000'),
(109, 99, 2, '0.0000', NULL, '10.0000'),
(110, 100, 1, '0.0000', NULL, '80.0000'),
(111, 100, 2, '0.0000', NULL, '80.0000'),
(112, 1, 1, '0.0000', NULL, '80.0000'),
(113, 1, 2, '0.0000', NULL, '80.0000'),
(114, 1, 1, '0.0000', NULL, '80.0000'),
(115, 1, 2, '0.0000', NULL, '80.0000');

-- --------------------------------------------------------

--
-- Table structure for table `sls_warehouses_products_variants`
--

CREATE TABLE `sls_warehouses_products_variants` (
  `id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `rack` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_warehouses_products_variants`
--

INSERT INTO `sls_warehouses_products_variants` (`id`, `option_id`, `product_id`, `warehouse_id`, `quantity`, `rack`) VALUES
(2, 31, 4, 1, '-3.0000', NULL),
(3, 10, 1, 1, '-3.0000', NULL),
(8, 61, 96, 1, '10.0000', NULL),
(9, 62, 96, 1, '20.0000', NULL),
(10, 63, 97, 1, '10.0000', NULL),
(11, 64, 97, 1, '20.0000', NULL),
(12, 65, 98, 1, '10.0000', NULL),
(13, 66, 99, 1, '10.0000', NULL),
(14, 66, 99, 2, '0.0000', NULL),
(15, 67, 99, 1, '20.0000', NULL),
(16, 67, 99, 2, '0.0000', NULL),
(17, 70, 100, 1, '0.0000', NULL),
(18, 70, 100, 2, '0.0000', NULL),
(19, 71, 100, 1, '0.0000', NULL),
(20, 71, 100, 2, '0.0000', NULL),
(21, 78, 1, 1, '0.0000', NULL),
(22, 78, 1, 2, '0.0000', NULL),
(23, 81, 100, 1, '0.0000', NULL),
(24, 81, 100, 2, '0.0000', NULL),
(25, 83, 100, 1, '0.0000', NULL),
(26, 83, 100, 2, '0.0000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sls_web_setting`
--

CREATE TABLE `sls_web_setting` (
  `setting_id` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `invoice_logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `timezone` varchar(150) NOT NULL,
  `currency_position` varchar(10) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `rtr` varchar(255) DEFAULT NULL,
  `captcha` int(11) DEFAULT 1 COMMENT '0=active,1=inactive',
  `site_key` varchar(250) DEFAULT NULL,
  `secret_key` varchar(250) DEFAULT NULL,
  `discount_type` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_web_setting`
--

INSERT INTO `sls_web_setting` (`setting_id`, `logo`, `invoice_logo`, `favicon`, `currency`, `timezone`, `currency_position`, `footer_text`, `language`, `rtr`, `captcha`, `site_key`, `secret_key`, `discount_type`) VALUES
(1, 'assets/img/icons/2020-09-28/93feea3d8b9f1647dbd7be1eeda38ce7.png', 'assets/img/icons/2020-08-27/d57.png', 'assets/img/icons/2020-09-07/870.png', '$', 'Asia/Dhaka', '0', 'CopyrightÂ© 2020 Bdtask. All rights reserved.', 'english', '0', 1, '6LdiKhsUAAAAAMV4jQRmNYdZy2kXEuFe1HrdP5tt', '6LdiKhsUAAAAAMV4jQRmNYdZy2kXEuFe1HrdP5tt', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sls_billers`
--
ALTER TABLE `sls_billers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`id`);

--
-- Indexes for table `sls_brands`
--
ALTER TABLE `sls_brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `sls_categories`
--
ALTER TABLE `sls_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `sls_combo_items`
--
ALTER TABLE `sls_combo_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sls_currencies`
--
ALTER TABLE `sls_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sls_customers`
--
ALTER TABLE `sls_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`id`);

--
-- Indexes for table `sls_date_format`
--
ALTER TABLE `sls_date_format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sls_pos_settings`
--
ALTER TABLE `sls_pos_settings`
  ADD PRIMARY KEY (`pos_id`);

--
-- Indexes for table `sls_printers`
--
ALTER TABLE `sls_printers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sls_products`
--
ALTER TABLE `sls_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `category_id_2` (`category_id`),
  ADD KEY `unit` (`unit`),
  ADD KEY `brand` (`brand`);

--
-- Indexes for table `sls_product_variants`
--
ALTER TABLE `sls_product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_product_id_name` (`product_id`,`name`);

--
-- Indexes for table `sls_purchase_items`
--
ALTER TABLE `sls_purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sls_settings`
--
ALTER TABLE `sls_settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `sls_suppliers`
--
ALTER TABLE `sls_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`id`);

--
-- Indexes for table `sls_tax_rates`
--
ALTER TABLE `sls_tax_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sls_units`
--
ALTER TABLE `sls_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `base_unit` (`base_unit`);

--
-- Indexes for table `sls_users`
--
ALTER TABLE `sls_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sls_variants`
--
ALTER TABLE `sls_variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sls_warehouses`
--
ALTER TABLE `sls_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `sls_warehouses_products`
--
ALTER TABLE `sls_warehouses_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `sls_warehouses_products_variants`
--
ALTER TABLE `sls_warehouses_products_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_id` (`option_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `sls_web_setting`
--
ALTER TABLE `sls_web_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sls_billers`
--
ALTER TABLE `sls_billers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sls_brands`
--
ALTER TABLE `sls_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sls_categories`
--
ALTER TABLE `sls_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sls_combo_items`
--
ALTER TABLE `sls_combo_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sls_currencies`
--
ALTER TABLE `sls_currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sls_customers`
--
ALTER TABLE `sls_customers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sls_date_format`
--
ALTER TABLE `sls_date_format`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sls_printers`
--
ALTER TABLE `sls_printers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sls_products`
--
ALTER TABLE `sls_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `sls_product_variants`
--
ALTER TABLE `sls_product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `sls_purchase_items`
--
ALTER TABLE `sls_purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sls_suppliers`
--
ALTER TABLE `sls_suppliers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sls_tax_rates`
--
ALTER TABLE `sls_tax_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sls_units`
--
ALTER TABLE `sls_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sls_users`
--
ALTER TABLE `sls_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sls_variants`
--
ALTER TABLE `sls_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sls_warehouses`
--
ALTER TABLE `sls_warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sls_warehouses_products`
--
ALTER TABLE `sls_warehouses_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `sls_warehouses_products_variants`
--
ALTER TABLE `sls_warehouses_products_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sls_web_setting`
--
ALTER TABLE `sls_web_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
