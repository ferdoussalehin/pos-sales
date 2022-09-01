-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2022 at 06:18 PM
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
-- Table structure for table `sls_attachments`
--

CREATE TABLE `sls_attachments` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `subject_type` varchar(55) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `orig_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_attachments`
--

INSERT INTO `sls_attachments` (`id`, `subject_id`, `subject_type`, `file_name`, `orig_name`) VALUES
(2, 4, 'purchase', 'fae232b9b171c1e9aeb4fff87d017363.jpg', '1500x500.jpg');

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
  `logo` varchar(255) DEFAULT 'logo.png',
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

INSERT INTO `sls_billers` (`id`, `name`, `company_name`, `phone`, `email`, `logo`, `address`, `city`, `state`, `zip`, `country`, `vat_number`, `status`, `create_date`, `create_by`) VALUES
(11, 'abc2', 'Abc', '01558930222', 'admin3@example.com', './assets/uploads/logos/text-in-swooshes-9381ld_1658062327.png', 'test', 'test', 'Test', '1234', '', '', 1, '2022-07-17 09:01:25', '2'),
(4, 'Test', 'test', '1232', 'admin2@example.com', './assets/uploads/logos/text-in-swooshes-9381ld_1658066395.png', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:12:45', '2'),
(7, 'Test6', 'test6', '015589', 'admin6@example.com', 'logo.png', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:14:33', '2'),
(8, 'Test7', 'test7', '01767896', 'admin7@example.com', 'logo.png', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:15:16', '2'),
(9, 'aisoft', 'Owner', '015589', 'aisoft@example.com', 'logo.png', 'test', 'test', 'Test', '1211', 'BDESH', '1122', 1, '2021-05-25 06:10:15', '2'),
(10, 'Test Supplier', 'testsup', '01558933', 'admintest@example.com', 'logo.png', 'testsup', 'test', 'Testsup', '121133', 'BDESH', '112233', 1, '2021-05-25 08:36:38', '2');

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
-- Table structure for table `sls_order_ref`
--

CREATE TABLE `sls_order_ref` (
  `ref_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `so` int(11) NOT NULL DEFAULT 1,
  `qu` int(11) NOT NULL DEFAULT 1,
  `po` int(11) NOT NULL DEFAULT 1,
  `to` int(11) NOT NULL DEFAULT 1,
  `pos` int(11) NOT NULL DEFAULT 1,
  `do` int(11) NOT NULL DEFAULT 1,
  `pay` int(11) NOT NULL DEFAULT 1,
  `re` int(11) NOT NULL DEFAULT 1,
  `rep` int(11) NOT NULL DEFAULT 1,
  `ex` int(11) NOT NULL DEFAULT 1,
  `ppay` int(11) NOT NULL DEFAULT 1,
  `qa` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_order_ref`
--

INSERT INTO `sls_order_ref` (`ref_id`, `date`, `so`, `qu`, `po`, `to`, `pos`, `do`, `pay`, `re`, `rep`, `ex`, `ppay`, `qa`) VALUES
(1, '2015-03-01', 6, 1, 5, 1, 78, 1, 62, 1, 2, 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sls_order_status_tracking`
--

CREATE TABLE `sls_order_status_tracking` (
  `id` bigint(20) NOT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `status_id` varchar(225) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `is_notified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_order_status_tracking`
--

INSERT INTO `sls_order_status_tracking` (`id`, `order_id`, `status_id`, `date_created`, `last_updated`, `updated_by`, `created_by`, `remark`, `is_notified`) VALUES
(1, '202', '2', '2021-06-21 06:15:41', NULL, NULL, NULL, NULL, 0),
(128, '1', '1', '2022-07-05 06:49:47', NULL, NULL, NULL, NULL, 0),
(129, '2', '1', '2022-07-05 08:51:33', NULL, NULL, NULL, NULL, 0),
(130, '3', '1', '2022-07-05 08:51:58', NULL, NULL, NULL, NULL, 0),
(131, '4', '1', '2022-07-05 09:20:51', NULL, NULL, NULL, NULL, 0),
(132, '5', '1', '2022-07-05 09:28:10', NULL, NULL, NULL, NULL, 0),
(133, '6', '1', '2022-07-05 09:32:19', NULL, NULL, NULL, NULL, 0),
(134, '7', '1', '2022-07-05 09:43:36', NULL, NULL, NULL, NULL, 0),
(135, '8', '1', '2022-07-05 09:49:32', NULL, NULL, NULL, NULL, 0),
(136, '9', '1', '2022-07-05 09:50:39', NULL, NULL, NULL, NULL, 0),
(138, '11', '1', '2022-07-05 14:38:41', NULL, NULL, NULL, NULL, 0),
(139, '12', '1', '2022-07-07 06:05:04', NULL, NULL, NULL, NULL, 0),
(140, '13', '1', '2022-07-07 10:13:31', NULL, NULL, NULL, NULL, 0),
(141, '14', '1', '2022-07-07 10:14:34', NULL, NULL, NULL, NULL, 0),
(142, '15', '1', '2022-07-07 11:43:13', NULL, NULL, NULL, NULL, 0),
(143, '16', '1', '2022-07-07 11:44:01', NULL, NULL, NULL, NULL, 0),
(144, '17', '1', '2022-07-07 11:44:39', NULL, NULL, NULL, NULL, 0),
(147, NULL, '1', '2022-07-20 07:01:35', NULL, NULL, NULL, NULL, 0),
(148, '18', '1', '2022-07-23 04:45:55', NULL, NULL, NULL, NULL, 0),
(149, '19', '1', '2022-07-23 05:17:43', NULL, NULL, NULL, NULL, 0),
(150, '20', '1', '2022-07-23 05:24:18', NULL, NULL, NULL, NULL, 0),
(151, '21', '1', '2022-07-24 10:25:23', NULL, NULL, NULL, NULL, 0),
(152, '22', '1', '2022-07-24 12:01:18', NULL, NULL, NULL, NULL, 0),
(153, '23', '1', '2022-07-24 12:45:11', NULL, NULL, NULL, NULL, 0),
(154, '24', '1', '2022-07-24 16:05:26', NULL, NULL, NULL, NULL, 0),
(155, '25', '1', '2022-07-25 11:40:05', NULL, NULL, NULL, NULL, 0),
(156, '26', '1', '2022-07-25 12:12:19', NULL, NULL, NULL, NULL, 0),
(157, '27', '1', '2022-07-27 04:33:11', NULL, NULL, NULL, NULL, 0),
(158, '28', '1', '2022-07-27 04:36:10', NULL, NULL, NULL, NULL, 0),
(159, '29', '1', '2022-07-27 05:02:23', NULL, NULL, NULL, NULL, 0),
(160, '30', '1', '2022-07-27 05:05:21', NULL, NULL, NULL, NULL, 0),
(161, '31', '1', '2022-07-27 05:10:54', NULL, NULL, NULL, NULL, 0),
(162, '32', '1', '2022-07-27 05:41:26', NULL, NULL, NULL, NULL, 0),
(163, '33', '1', '2022-07-27 06:10:47', NULL, NULL, NULL, NULL, 0),
(164, '34', '1', '2022-07-27 06:13:52', NULL, NULL, NULL, NULL, 0),
(165, '35', '1', '2022-07-27 06:16:04', NULL, NULL, NULL, NULL, 0),
(166, '36', '1', '2022-07-27 06:16:43', NULL, NULL, NULL, NULL, 0),
(167, '37', '1', '2022-07-27 06:18:54', NULL, NULL, NULL, NULL, 0),
(168, '38', '1', '2022-07-27 06:47:50', NULL, NULL, NULL, NULL, 0),
(169, '39', '1', '2022-07-27 06:54:38', NULL, NULL, NULL, NULL, 0),
(170, '40', '1', '2022-07-27 06:56:38', NULL, NULL, NULL, NULL, 0),
(171, '41', '1', '2022-07-27 09:01:04', NULL, NULL, NULL, NULL, 0),
(172, '42', '1', '2022-07-27 09:31:42', NULL, NULL, NULL, NULL, 0),
(173, '43', '1', '2022-07-27 09:33:52', NULL, NULL, NULL, NULL, 0),
(174, '44', '1', '2022-07-27 09:37:16', NULL, NULL, NULL, NULL, 0),
(175, '45', '1', '2022-07-27 09:38:41', NULL, NULL, NULL, NULL, 0),
(176, '46', '1', '2022-07-27 09:46:30', NULL, NULL, NULL, NULL, 0),
(177, '47', '1', '2022-07-27 16:13:07', NULL, NULL, NULL, NULL, 0),
(178, '48', '1', '2022-07-27 16:13:37', NULL, NULL, NULL, NULL, 0),
(179, '49', '1', '2022-07-30 04:59:53', NULL, NULL, NULL, NULL, 0),
(180, '50', '1', '2022-07-30 09:08:03', NULL, NULL, NULL, NULL, 0),
(181, '51', '1', '2022-07-30 09:09:38', NULL, NULL, NULL, NULL, 0),
(182, '52', '1', '2022-07-30 11:45:59', NULL, NULL, NULL, NULL, 0),
(183, '53', '1', '2022-07-30 11:48:33', NULL, NULL, NULL, NULL, 0),
(184, '54', '1', '2022-07-30 12:10:16', NULL, NULL, NULL, NULL, 0),
(185, '55', '1', '2022-07-31 03:34:50', NULL, NULL, NULL, NULL, 0),
(186, '56', '1', '2022-07-31 03:40:48', NULL, NULL, NULL, NULL, 0),
(187, '57', '1', '2022-07-31 03:46:25', NULL, NULL, NULL, NULL, 0),
(188, '58', '1', '2022-07-31 03:47:08', NULL, NULL, NULL, NULL, 0),
(189, '59', '1', '2022-08-01 10:37:44', NULL, NULL, NULL, NULL, 0),
(193, '63', '1', '2022-08-01 10:56:51', NULL, NULL, NULL, NULL, 0),
(196, '66', '1', '2022-08-01 12:29:59', NULL, NULL, NULL, NULL, 0),
(198, '68', '1', '2022-08-01 12:52:39', NULL, NULL, NULL, NULL, 0),
(199, '69', '1', '2022-08-02 04:08:33', NULL, NULL, NULL, NULL, 0),
(200, '70', '1', '2022-08-03 06:03:45', NULL, NULL, NULL, NULL, 0),
(202, '72', '1', '2022-08-03 06:25:50', NULL, NULL, NULL, NULL, 0),
(203, '73', '1', '2022-08-03 06:27:21', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sls_payments`
--

CREATE TABLE `sls_payments` (
  `id` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT current_timestamp(),
  `sale_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `purchase_raw_id` int(11) DEFAULT NULL,
  `reference_no` varchar(50) NOT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `paid_by` varchar(20) NOT NULL,
  `cheque_no` varchar(20) DEFAULT NULL,
  `cc_no` varchar(20) DEFAULT NULL,
  `cc_holder` varchar(25) DEFAULT NULL,
  `cc_month` varchar(2) DEFAULT NULL,
  `cc_year` varchar(4) DEFAULT NULL,
  `cc_type` varchar(20) DEFAULT NULL,
  `amount` decimal(25,4) NOT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `pos_paid` decimal(25,4) DEFAULT 0.0000,
  `pos_balance` decimal(25,4) DEFAULT 0.0000,
  `approval_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_payments`
--

INSERT INTO `sls_payments` (`id`, `date`, `sale_id`, `return_id`, `purchase_id`, `purchase_raw_id`, `reference_no`, `transaction_id`, `paid_by`, `cheque_no`, `cc_no`, `cc_holder`, `cc_month`, `cc_year`, `cc_type`, `amount`, `currency`, `created_by`, `attachment`, `type`, `note`, `pos_paid`, `pos_balance`, `approval_code`) VALUES
(1, '2022-07-05 05:20:51', 4, NULL, NULL, NULL, '829658203351', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '115.0000', NULL, 2, NULL, 'received', NULL, '115.0000', '0.0000', NULL),
(2, '2022-07-05 05:28:10', 5, NULL, NULL, NULL, '354264704401', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '115.0000', NULL, 2, NULL, 'received', NULL, '115.0000', '0.0000', NULL),
(3, '2022-07-05 05:32:19', 6, NULL, NULL, NULL, '829324646345', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '115.0000', NULL, 2, NULL, 'received', NULL, '115.0000', '0.0000', NULL),
(4, '2022-07-05 05:43:36', 7, NULL, NULL, NULL, '879398303799', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '115.0000', NULL, 2, NULL, 'received', NULL, '115.0000', '0.0000', NULL),
(5, '2022-07-05 05:49:32', 8, NULL, NULL, NULL, '303161303693', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '115.0000', NULL, 2, NULL, 'received', NULL, '115.0000', '0.0000', NULL),
(6, '2022-07-05 05:50:39', 9, NULL, NULL, NULL, '854809039504', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '115.0000', NULL, 2, NULL, 'received', NULL, '115.0000', '0.0000', NULL),
(7, '2022-07-05 10:38:41', 11, NULL, NULL, NULL, 'IPAY2022/0032', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '337.0000', NULL, 2, NULL, 'received', NULL, '337.0000', '0.0000', NULL),
(8, '2022-07-07 02:05:04', 12, NULL, NULL, NULL, 'IPAY2022/0033', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '430.0000', NULL, 2, NULL, 'received', NULL, '430.0000', '0.0000', NULL),
(9, '2022-07-07 06:13:31', 13, NULL, NULL, NULL, 'IPAY2022/0034', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '30.0000', NULL, 2, NULL, 'received', NULL, '30.0000', '0.0000', NULL),
(10, '2022-07-07 06:14:34', 14, NULL, NULL, NULL, 'IPAY2022/0035', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '130.0000', NULL, 2, NULL, 'received', NULL, '130.0000', '0.0000', NULL),
(11, '2022-07-07 07:43:13', 15, NULL, NULL, NULL, 'IPAY2022/0036', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '30.0000', NULL, 2, NULL, 'received', NULL, '30.0000', '0.0000', NULL),
(12, '2022-07-07 07:44:01', 16, NULL, NULL, NULL, 'IPAY2022/0037', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '30.0000', NULL, 2, NULL, 'received', NULL, '30.0000', '0.0000', NULL),
(14, '2022-07-20 03:01:35', NULL, NULL, NULL, NULL, 'IPAY2022/0039', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '45.0000', NULL, 2, NULL, 'received', NULL, '45.0000', '0.0000', NULL),
(18, '2022-07-20 04:23:08', 17, NULL, NULL, NULL, 'IPAY2022/0043', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '160.0000', NULL, 2, NULL, 'received', NULL, '160.0000', '0.0000', NULL),
(19, '2022-07-23 00:45:55', 18, NULL, NULL, NULL, 'IPAY2022/0044', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '290.0000', NULL, 1, NULL, 'received', NULL, '290.0000', '0.0000', NULL),
(20, '2022-07-23 01:17:43', 19, NULL, NULL, NULL, 'IPAY2022/0045', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '99.0000', NULL, 1, NULL, 'received', NULL, '99.0000', '0.0000', NULL),
(21, '2022-07-23 01:24:18', 20, NULL, NULL, NULL, 'IPAY2022/0046', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '99.0000', NULL, 1, NULL, 'received', NULL, '99.0000', '0.0000', NULL),
(22, '2022-07-27 00:33:11', 27, NULL, NULL, NULL, 'IPAY2022/0047', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '600.0000', NULL, 1, NULL, 'received', NULL, '600.0000', '0.0000', NULL),
(23, '2022-07-27 00:36:10', 28, NULL, NULL, NULL, 'IPAY2022/0048', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '350.0000', NULL, 1, NULL, 'received', NULL, '350.0000', '0.0000', NULL),
(25, '2022-07-27 01:05:21', 30, NULL, NULL, NULL, 'IPAY2022/0050', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '350.0000', NULL, 1, NULL, 'received', NULL, '350.0000', '0.0000', NULL),
(28, '2022-07-28 08:11:39', 30, NULL, NULL, NULL, 'IPAY2022/0053', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '10.0000', NULL, 1, NULL, 'received', '', '10.0000', '0.0000', NULL),
(29, '2022-07-28 08:11:53', 30, NULL, NULL, NULL, 'IPAY2022/0053', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '-10.0000', NULL, 1, NULL, 'received', '', '-10.0000', '0.0000', NULL),
(30, '2022-07-28 08:16:04', 30, NULL, NULL, NULL, 'IPAY2022/0053', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '10.0000', NULL, 1, NULL, 'received', '', '10.0000', '0.0000', NULL),
(32, '2022-08-01 02:22:57', 25, NULL, NULL, NULL, 'IPAY2022/0053', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '750.0000', NULL, 1, NULL, 'received', '', '750.0000', '0.0000', NULL),
(33, '2022-07-28 09:55:27', 19, NULL, NULL, NULL, 'IPAY2022/0053', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '11.0000', NULL, 1, NULL, 'received', '', '11.0000', '0.0000', NULL),
(34, '2022-07-28 10:23:34', 21, NULL, NULL, NULL, 'IPAY2022/0053', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '150.0000', NULL, 1, NULL, 'received', '', '150.0000', '0.0000', NULL),
(35, '2022-07-28 10:24:52', 24, NULL, NULL, NULL, 'IPAY2022/0053', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '600.0000', NULL, 1, NULL, 'received', '', '600.0000', '0.0000', NULL),
(36, '2022-07-30 05:09:38', 51, NULL, NULL, NULL, 'IPAY2022/0053', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '700.0000', NULL, 1, NULL, 'received', NULL, '700.0000', '0.0000', NULL),
(37, '2022-07-30 07:48:33', 53, NULL, NULL, NULL, 'IPAY2022/0054', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '400.0000', NULL, 1, NULL, 'received', NULL, '400.0000', '0.0000', NULL),
(38, '2022-08-01 06:05:26', 47, NULL, NULL, NULL, 'IPAY2022/0055', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '450.0000', NULL, 1, NULL, 'received', '', '450.0000', '0.0000', NULL),
(39, '2022-08-01 06:37:44', 59, NULL, NULL, NULL, 'IPAY2022/0055', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '300.0000', NULL, 1, NULL, 'received', NULL, '300.0000', '0.0000', NULL),
(40, '2022-08-01 06:56:51', 63, NULL, NULL, NULL, 'IPAY2022/0056', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '300.0000', NULL, 1, NULL, 'received', NULL, '300.0000', '0.0000', NULL),
(41, '2022-08-01 08:29:59', 66, NULL, NULL, NULL, 'IPAY2022/0057', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '150.0000', NULL, 1, NULL, 'received', NULL, '150.0000', '0.0000', NULL),
(42, '2022-08-01 08:52:39', 68, NULL, NULL, NULL, 'IPAY2022/0058', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '150.0000', NULL, 1, NULL, 'received', NULL, '150.0000', '0.0000', NULL),
(43, '2022-08-03 02:03:45', 70, NULL, NULL, NULL, 'IPAY2022/0059', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '300.0000', NULL, 1, NULL, 'received', NULL, '300.0000', '0.0000', NULL),
(44, '2022-08-03 02:25:50', 72, NULL, NULL, NULL, 'IPAY2022/0060', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '300.0000', NULL, 1, NULL, 'received', NULL, '300.0000', '0.0000', NULL),
(45, '2022-08-03 02:27:21', 73, NULL, NULL, NULL, 'IPAY2022/0061', NULL, 'cash', '', NULL, NULL, NULL, NULL, NULL, '300.0000', NULL, 1, NULL, 'received', NULL, '300.0000', '0.0000', NULL);

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
(1, 22, 10, 2, 1, 4, '1', 'GST Reg', 'VAT Reg', '123456789', '987654321', NULL, NULL, 'Ctrl+F3', 'Ctrl+Shift+M', 'Ctrl+Shift+C', 'Ctrl+Shift+A', 'Ctrl+F11', 'Ctrl+F12', 'F4', 'F7', 'F9', 'F8', 'Ctrl+F1', 'Ctrl+F2', 'Ctrl+F10', 1, NULL, 0, 'default', 1, 0, 0, 0, 42, '12345678', 'purchase_code', 'envato_username', '3.4.53', 0, 0, NULL, '', 1, NULL, 'null', NULL, 0, NULL, 3);

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
(96, '71356220', 'abc', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30.0000', 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '71356220', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(97, '58574449', 'hello', NULL, 1, '80.0000', '100.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 3, '123.0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '123', NULL, NULL, NULL, NULL, NULL, NULL, 0, '58574449', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, '1'),
(98, '39276026', 'my1', NULL, 1, '10.0000', '15.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '              ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '39276026', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(99, '03329242', 'my11', NULL, 1, '10.0000', '15.0000', '0.0000', '7bdcde35412968e32c5de9827646c80b.jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30.0000', 0, 0, NULL, NULL, 'code128', NULL, '    ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '03329242', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(100, '61720108', 'my2Variant', NULL, 1, '80.0000', '100.0000', '0.0000', '857a47e5eea2672756fffb2c1f73383c.jpg', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, NULL, NULL, 'code128', NULL, '                    ', 0, 'standard', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '61720108', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(101, '93710795', 'TestCombo', NULL, NULL, NULL, '250.0000', '0.0000', '7bdcde35412968e32c5de9827646c80b.jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '      ', 0, 'combo', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '93710795', NULL, '0.0000', NULL, 0, 0, '', 1, 0, 0, '', 0, 0, ''),
(102, '55215950', 'Serve', NULL, NULL, NULL, '170.0000', '0.0000', '857a47e5eea2672756fffb2c1f73383c.jpg', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'service', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '55215950', NULL, '0.0000', NULL, 0, 0, '', 1, 0, 0, '', 0, 0, ''),
(103, '16535498', 'TestAB', NULL, 1, '80.0000', '100.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '16535498', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(104, '92293990', 'TestBC', NULL, 1, '80.0000', '100.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '92293990', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(105, '69140522', 'TestDC', NULL, 1, '80.0000', '100.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '69140522', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(106, '72692446', 'TestFF', NULL, 1, '80.0000', '100.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '72692446', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(107, '63863605', 'TestRR', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '63863605', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(108, '99824966', 'Testasd', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '99824966', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(110, '60823701', 'Var', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '17.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(111, '33469826', 'abc', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 0, 0, NULL, NULL, 'code128', NULL, '    ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '33469826', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(112, '87116896', 'variant', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '87116896', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(113, '13437928', 'variant', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '13437928', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(114, '00234415', 'variant', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '00234415', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(115, '49179907', 'variant', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-1.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '49179907', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(117, '12446983', 'TestVar', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '12446983', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, ''),
(118, '65822900', 'vary', NULL, 1, '120.0000', '150.0000', '0.0000', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', 2, 0, NULL, NULL, 'code128', NULL, '  ', 0, 'standard', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '65822900', NULL, '0.0000', NULL, 0, 0, '', 0, 0, 0, '', 0, 0, '');

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
(78, 1, 't', NULL, '0.0000', NULL),
(89, 110, 's', NULL, '0.0000', NULL),
(90, 110, 'm', NULL, '0.0000', '10.0000'),
(92, 117, 's', NULL, '0.0000', '5.0000'),
(93, 117, 'm', NULL, '0.0000', '0.0000'),
(94, 118, 'q', NULL, '0.0000', '0.0000'),
(95, 118, 'r', NULL, '0.0000', '0.0000');

-- --------------------------------------------------------

--
-- Table structure for table `sls_purchases`
--

CREATE TABLE `sls_purchases` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `product_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `order_discount` decimal(25,4) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT NULL,
  `product_tax` decimal(25,4) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT 0.0000,
  `shipping` decimal(25,4) DEFAULT 0.0000,
  `grand_total` decimal(25,4) NOT NULL,
  `paid` decimal(25,4) NOT NULL DEFAULT 0.0000,
  `status` varchar(55) DEFAULT '',
  `payment_status` varchar(20) DEFAULT 'pending',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT 0.0000,
  `return_purchase_ref` varchar(55) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `return_purchase_total` decimal(25,4) NOT NULL DEFAULT 0.0000,
  `cgst` decimal(25,4) DEFAULT NULL,
  `sgst` decimal(25,4) DEFAULT NULL,
  `igst` decimal(25,4) DEFAULT NULL,
  `platform` varchar(100) DEFAULT NULL,
  `online_id` int(11) DEFAULT NULL,
  `local_id` int(11) DEFAULT NULL,
  `is_synchronize` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_purchases`
--

INSERT INTO `sls_purchases` (`id`, `reference_no`, `date`, `supplier_id`, `supplier`, `warehouse_id`, `note`, `total`, `product_discount`, `order_discount_id`, `order_discount`, `total_discount`, `product_tax`, `order_tax_id`, `order_tax`, `total_tax`, `shipping`, `grand_total`, `paid`, `status`, `payment_status`, `created_by`, `updated_by`, `updated_at`, `attachment`, `payment_term`, `due_date`, `return_id`, `surcharge`, `return_purchase_ref`, `purchase_id`, `return_purchase_total`, `cgst`, `sgst`, `igst`, `platform`, `online_id`, `local_id`, `is_synchronize`) VALUES
(3, 'PO2022/03/0002', '2022-03-15 12:42:00', 2, 'Supplier Company Name', 1, '', '6000.0000', '0.0000', '', '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '6000.0000', '0.0000', 'received', 'pending', 1, NULL, NULL, '0', 0, NULL, NULL, '0.0000', NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 'PO2022/04/0003', '2022-04-07 05:49:00', 2, 'Supplier Company Name', 1, '', '26.0000', '0.0000', '', '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '26.0000', '0.0000', 'received', 'pending', 1, 1, '2022-04-09 07:47:08', '1', 0, NULL, NULL, '0.0000', NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(5, 'PO2022/06/0004', '2022-06-13 08:49:00', 2, 'Supplier Company Name', 1, '', '1320.0000', '0.0000', '', '0.0000', '0.0000', '132.0000', 1, '0.0000', '132.0000', '0.0000', '1452.0000', '0.0000', 'received', 'pending', 1, 1, '2022-06-13 05:58:06', '0', 0, NULL, NULL, '0.0000', NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL, NULL, 0);

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
(6, NULL, NULL, 2, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-2.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, 3, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(8, NULL, NULL, 5, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, 4, '', '', 31, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-7.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, 20, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(12, NULL, NULL, 89, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-1.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(13, NULL, NULL, 85, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-1.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(14, NULL, NULL, 84, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-1.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(15, 4, NULL, 10, '11', 'حبة شواية سادة', NULL, '26.0000', '1.0000', 1, '0.0000', NULL, '', '0', '0.0000', NULL, '26.0000', '1.0000', '2022-04-07', 'received', '26.0000', '26.0000', '1.0000', NULL, NULL, 1, '1122', '1.0000', NULL, NULL, NULL, NULL, '26.0000'),
(16, NULL, NULL, 1, '1', 'حبة شواية مع الرز', 10, '38.0000', '-1.0000', 1, NULL, NULL, NULL, NULL, NULL, NULL, '-38.0000', '-8.0000', '2022-04-09', 'received', '38.0000', '38.0000', '-1.0000', NULL, NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL),
(18, 5, NULL, 96, '01747274', 'Test1a', 59, '120.0000', '11.0000', 1, '132.0000', 2, '10%', '0', '0.0000', NULL, '1452.0000', '7.0000', '2022-06-13', 'received', '132.0000', '120.0000', '11.0000', NULL, NULL, 1, '1122', '11.0000', NULL, NULL, NULL, NULL, '120.0000'),
(19, NULL, NULL, 95, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-1.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(20, NULL, NULL, 99, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-29.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(21, NULL, NULL, 92, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-1.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, 98, '', '', 63, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-2.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(23, NULL, NULL, 94, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-2.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL),
(24, NULL, NULL, 90, '', '', NULL, '0.0000', '0.0000', 1, '0.0000', NULL, NULL, NULL, NULL, NULL, '0.0000', '-2.0000', '0000-00-00', 'received', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sls_sales`
--

CREATE TABLE `sls_sales` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `staff_note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT 0.0000,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT 0.0000,
  `order_discount` decimal(25,4) DEFAULT 0.0000,
  `product_tax` decimal(25,4) DEFAULT 0.0000,
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT 0.0000,
  `total_tax` decimal(25,4) DEFAULT 0.0000,
  `shipping` decimal(25,4) DEFAULT 0.0000,
  `grand_total` decimal(25,4) NOT NULL,
  `sale_status` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_items` smallint(6) DEFAULT NULL,
  `pos` tinyint(1) NOT NULL DEFAULT 0,
  `paid` decimal(25,4) DEFAULT 0.0000,
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT 0.0000,
  `attachment` varchar(55) DEFAULT NULL,
  `return_sale_ref` varchar(55) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `return_sale_total` decimal(25,4) NOT NULL DEFAULT 0.0000,
  `rounding` decimal(10,4) DEFAULT NULL,
  `suspend_note` varchar(255) DEFAULT NULL,
  `api` tinyint(1) DEFAULT 0,
  `shop` tinyint(1) DEFAULT 0,
  `address_id` int(11) DEFAULT NULL,
  `reserve_id` int(11) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `manual_payment` varchar(55) DEFAULT NULL,
  `cgst` decimal(25,4) DEFAULT NULL,
  `sgst` decimal(25,4) DEFAULT NULL,
  `igst` decimal(25,4) DEFAULT NULL,
  `payment_method` varchar(55) DEFAULT NULL,
  `order_status` int(11) NOT NULL DEFAULT 1,
  `customer_type` int(11) DEFAULT NULL,
  `table_no` varchar(255) DEFAULT NULL,
  `local_id` int(11) DEFAULT NULL,
  `online_id` int(11) DEFAULT NULL,
  `is_syncronize` tinyint(2) NOT NULL DEFAULT 0,
  `order_platform` varchar(255) DEFAULT NULL,
  `is_printed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_sales`
--

INSERT INTO `sls_sales` (`id`, `date`, `reference_no`, `customer_id`, `customer`, `biller_id`, `biller`, `warehouse_id`, `note`, `staff_note`, `total`, `product_discount`, `order_discount_id`, `total_discount`, `order_discount`, `product_tax`, `order_tax_id`, `order_tax`, `total_tax`, `shipping`, `grand_total`, `sale_status`, `payment_status`, `payment_term`, `due_date`, `created_by`, `updated_by`, `updated_at`, `total_items`, `pos`, `paid`, `return_id`, `surcharge`, `attachment`, `return_sale_ref`, `sale_id`, `return_sale_total`, `rounding`, `suspend_note`, `api`, `shop`, `address_id`, `reserve_id`, `hash`, `manual_payment`, `cgst`, `sgst`, `igst`, `payment_method`, `order_status`, `customer_type`, `table_no`, `local_id`, `online_id`, `is_syncronize`, `order_platform`, `is_printed`) VALUES
(1, '2022-07-05 02:49:47', '159861461597', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '115.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '115.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '9d9429da7f8dfb8823179abe16fab1a021e446a61846ce99fe478bbbd85a9166', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(2, '2022-07-05 04:51:33', '408864122312', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '115.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '115.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '98b559a25e354fc1bb59f7cc86273ead9d9b7b99ba21b9b6cc34379311e60294', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(3, '2022-07-05 04:51:58', '115239126432', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '115.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '115.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '7606b6e2a63b1363dc6d624145d48416f508769b35e31d698c24e785d86b8430', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(4, '2022-07-05 05:20:51', '018104718851', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '115.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '115.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'aa330d210a1881214b7b93fa17953228a2172e5c04a969f8ae5dd97f08bac39d', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(5, '2022-07-05 05:28:10', '343664945036', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '115.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '115.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'b96782b71693f5af346051f2306c47e1b8d7347c8f397fae9efd5c7308762e6f', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(6, '2022-07-05 05:32:19', '119522600131', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '115.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '115.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '49c2b36c9d31abeaf5547e07f0f8455da73b98afe71de7c8ffa49f7beb5caf53', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(7, '2022-07-05 05:43:36', '089910474727', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '115.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '115.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '85b696ce46b2af5e9e2737b0cee1023c80a7eb04bd57df557acec55088ff4ddb', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(8, '2022-07-05 05:49:32', '950156138372', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '115.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '115.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'e923f80b20eff0875dd275755f71b6f1091437ef81d8c338172e33154e291d64', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(9, '2022-07-05 05:50:39', '951182407003', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '115.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '115.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '1588c293f358ad9826d373d04a83e2e5c49929b49e3807c93584fbe950ff9840', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(11, '2022-07-05 10:38:41', 'SALE/POS2022/0024', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '337.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '337.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 3, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '798866a97ea68297dc36ac20ea92097dbb1b8d492edebde33fa59895d263f337', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(12, '2022-07-07 02:05:04', 'SALE/POS2022/0025', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '402.7200', '0.0000', NULL, '0.0000', '0.0000', '27.2800', NULL, '0.0000', '27.2800', '0.0000', '430.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 5, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '0a799cba81cc2056b8005f7030153721a560edabd80e9f1c80dee44a0b64e796', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(13, '2022-07-07 06:13:31', 'SALE/POS2022/0026', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '30.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '30.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '003ce7993dd40df41f76c8382428d31fbbbac37fcb90932074e7c35a66003c09', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(14, '2022-07-07 06:14:34', 'SALE/POS2022/0027', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '130.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '130.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 3, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '7cc88445e9fa521c757535682f5e38ce6b4b646dfadf13e56e4e28cf71fe1656', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(15, '2022-07-07 07:43:13', 'SALE/POS2022/0028', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '30.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '30.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '8c6d77c87c0388c2dd284ab996bde6689d02502f7e23661a425465b8747389a0', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(16, '2022-07-07 07:44:01', 'SALE/POS2022/0029', 1, 'Walking Customer', 3, 'Test', 1, NULL, NULL, '30.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '30.0000', 'completed', 'due', 0, NULL, NULL, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '2768cec1870de3c0971cdf7eb692136f96a1b31b840a46d46c4375d6592c781e', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(17, '2022-07-20 04:23:08', 'SALE/POS2022/0030', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '160.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '160.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 5, 1, '160.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '69cd6c6ed4fa20bb593189391a1465880b93e6f312399f44eb3efdef2ce3ec96', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(18, '2022-07-23 00:45:55', 'SALE/POS2022/0031', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '300.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '300.0000', 'completed', 'due', 0, NULL, 1, NULL, NULL, 2, 1, '290.0000', 50, '0.0000', NULL, '2022/0001', NULL, '-240.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'ad96ddc1366a7054296e424666f8e622450fd3790b4004a6961e2095affd3efa', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(19, '2022-07-23 01:17:43', 'SALE/POS2022/0032', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '90.9100', '0.0000', '', '0.0000', '0.0000', '9.0900', 2, '10.0000', '19.0900', '0.0000', '110.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 1, 1, '110.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'ad8aa73bbcad14108204688c1d9280fb4b3aba209cef4a3ff7f73462cd387fa2', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(20, '2022-07-23 01:24:18', 'SALE/POS2022/0033', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '90.9100', '0.0000', '10', '10.0000', '10.0000', '9.0900', 2, '9.0000', '18.0900', '0.0000', '99.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 1, 1, '99.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '5434ecde4000a3a2f34b31a81a3113122223f89e8e2349bbec6adc77b7157254', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(21, '2022-07-24 06:25:23', 'SALE/POS2022/0034', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '150.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 0, '0.0000', '0.0000', '0.0000', '150.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, NULL, 0, '150.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'f277fdd4a866eaa2804af955ee3e246efd1bf0c80a89856a697dfff6e8ebe89a', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(24, '2022-07-25 08:32:01', 'SALE/POS2022/0037', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '600.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '600.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 4, 0, '600.0000', 42, '0.0000', NULL, 'SALE/POS2022/0037', NULL, '-300.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'eca5a2ff2de82258b2df74c1115ded0095984eef696a5df28841192086a8a333', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(25, '2022-07-25 07:40:05', 'SALE/POS2022/0038', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '750.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '750.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, NULL, 0, '750.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '98032df547c5eeedaa6c90169452196e3587d523644374b0e4f5b44e142c5d57', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(26, '2022-07-25 08:12:19', 'SALE/POS2022/0039', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '600.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '600.0000', 'completed', 'due', 0, NULL, 1, NULL, NULL, 4, 0, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '4fd10def93d9b57909c7bb5d832d0a3344954ac0a9dca9c94895ae97f45b1a39', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(27, '2022-07-27 00:34:02', 'SALE/POS2022/0040', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '100.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '100.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 1, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '8284cd70ea1840bae70fbd09dc5e7742696298ac6177eab1ef6f29b92e71a9c9', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(28, '2022-07-27 01:00:51', 'SALE/POS2022/0041', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '150.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '150.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 1, 1, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '4cf0bb48a9bb82b5426adec57f257f2dc70266f277adb3df1ee935bdf8f60ea0', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(30, '2022-07-27 01:05:21', 'SALE/POS2022/0043', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '350.0000', '0.0000', '', '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '350.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 3, 1, '360.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'b5ae8b6f4c47894b08a5e38e7d997dfa513bb3888cd50d78c565cd7d578cad55', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(31, '2022-07-27 01:10:54', '', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '-150.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '-150.0000', 'returned', 'paid', 0, NULL, 1, NULL, NULL, 1, 0, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '525024bfc242caa73532216e522134ff2457e263e3b412d1417f6f43f21d62bf', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(44, '2022-07-27 05:37:16', 'SALE/POS2022/0057', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '300.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '300.0000', 'completed', 'pending', 0, NULL, 1, NULL, NULL, NULL, 0, '0.0000', 46, '0.0000', NULL, 'SALE/POS2022/0057', NULL, '-150.0000', '0.0000', NULL, 0, 0, NULL, NULL, '4e2c408dac47dce8194a0feb0c3abca09070425f693c39a725006d31ae9d2925', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(45, '2022-07-27 05:38:41', 'SALE/POS2022/0058', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '150.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '150.0000', 'completed', 'pending', 0, NULL, 1, NULL, NULL, NULL, 0, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '7d28ed79254873b5bc935070da6ff91c835780efc78a2131515b13d15be5767a', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(46, '2022-07-27 05:46:30', 'SALE/POS2022/0057', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '-150.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '-150.0000', 'returned', 'pending', 0, NULL, 1, NULL, NULL, 1, 0, '0.0000', NULL, '0.0000', NULL, 'SALE/POS2022/0057', 44, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'ed172f9480976bf7b9ac288368f4375438df5ecb5fad30e10de6f4e6c8e78bc1', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(47, '2022-07-27 12:13:07', 'SALE/POS2022/0060', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '450.0000', '0.0000', '', '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '450.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 4, 1, '450.0000', 48, '0.0000', NULL, 'SALE/POS2022/0060', NULL, '-200.0000', '0.0000', NULL, 0, 0, NULL, NULL, '68ea01d21e229910bb76c9aa38d513474f1c33fc69ab7bb0d170a7c99bdc3c1c', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(48, '2022-07-27 12:13:37', 'SALE/POS2022/0060', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '-200.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '-200.0000', 'returned', 'paid', 0, NULL, 1, NULL, NULL, 2, 1, '0.0000', NULL, '0.0000', NULL, 'SALE/POS2022/0060', 47, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'fd9807c9cd16b55fa95453ff79eb0e1e55a8c4427dff362cd6c3e5c544e14f80', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(49, '2022-07-30 00:59:53', 'SALE/POS2022/0040', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', '0.0000', 'returned', 'due', NULL, NULL, NULL, NULL, NULL, NULL, 1, '0.0000', NULL, '0.0000', NULL, '2022/0001', 27, '0.0000', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 0),
(50, '2022-07-30 05:08:03', 'SALE/POS2022/0031', 1, 'Walking Customer', 4, 'Test', 1, '', NULL, '-240.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 0, '0.0000', '0.0000', '0.0000', '-240.0000', 'returned', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 1, '0.0000', NULL, '0.0000', NULL, '2022/0001', 18, '0.0000', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 0),
(51, '2022-07-30 05:09:38', 'SALE/POS2022/0064', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '700.0000', '0.0000', '', '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '700.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 6, 1, '700.0000', 52, '0.0000', NULL, '2022/0001', NULL, '-200.0000', '0.0000', NULL, 0, 0, NULL, NULL, '0c323e4b80646ceef874908125433c61fc242bf3b179f1939202f9febac5188f', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(52, '2022-07-30 07:45:59', 'SALE/POS2022/0064', 1, 'Walking Customer', 4, 'Test', 1, '', NULL, '-200.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '-200.0000', 'returned', 'due', NULL, NULL, NULL, NULL, NULL, NULL, 1, '0.0000', NULL, '0.0000', NULL, '2022/0001', 51, '0.0000', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 0),
(53, '2022-07-30 07:48:33', 'SALE/POS2022/0066', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '400.0000', '0.0000', '', '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '400.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 4, 1, '400.0000', 54, '0.0000', NULL, '2022/0001', NULL, '-200.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'cf102e592ce349734ad8de804f787a5632f23a82bb85b9758e7bc48398bd4d6e', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(54, '2022-07-30 08:10:16', 'SALE/POS2022/0066', 1, 'Walking Customer', 4, 'Test', 1, '', NULL, '-200.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '-200.0000', 'returned', 'due', NULL, NULL, NULL, NULL, NULL, NULL, 1, '0.0000', NULL, '0.0000', NULL, '2022/0001', 53, '0.0000', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, 0),
(58, '2022-07-30 23:47:08', 'SALE2022/0004', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '150.0000', '0.0000', NULL, '0.0000', '0.0000', '0.0000', 1, '0.0000', '0.0000', '0.0000', '150.0000', 'completed', 'pending', 0, NULL, 1, NULL, NULL, NULL, 0, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '3a5cd72809730c33881aad94904629db1aafbbb7e4287caf3e243d27ba82b59d', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(59, '2022-08-01 06:37:44', 'SALE/POS2022/0071', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '272.7200', '0.0000', '', '0.0000', '0.0000', '27.2800', 1, '0.0000', '27.2800', '0.0000', '300.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 2, 1, '300.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'fa68a40e41ed4cfd1cba9c3a3c006deb5928b856b31fce188acb8dde794639ac', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(63, '2022-08-01 06:56:51', 'SALE/POS2022/0072', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '272.7200', '0.0000', '', '0.0000', '0.0000', '27.2800', 1, '0.0000', '27.2800', '0.0000', '300.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 2, 1, '300.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '0fb785ac2ef711ffaab396e624c7f508d7211ace881e6775db22426af9528096', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(66, '2022-08-01 08:29:59', 'SALE/POS2022/0073', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '136.3600', '0.0000', '', '0.0000', '0.0000', '13.6400', 1, '0.0000', '13.6400', '0.0000', '150.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 1, 1, '150.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'bf5fc12511b639d81d46b1aae63c2f3bf11e2745d795011fc306712aa2158d99', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(68, '2022-08-01 08:52:39', 'SALE/POS2022/0074', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '136.3600', '0.0000', '', '0.0000', '0.0000', '13.6400', 1, '0.0000', '13.6400', '0.0000', '150.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 1, 1, '150.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '6a441ca65cca17e42f47796b5b6a9a36b21b8dcf704b389f01415f178f3d25c0', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(69, '2022-08-02 00:08:33', 'SALE2022/0005', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '136.3600', '0.0000', NULL, '0.0000', '0.0000', '13.6400', 1, '0.0000', '13.6400', '0.0000', '150.0000', 'completed', 'pending', 0, NULL, 1, NULL, NULL, NULL, 0, '0.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, '708c7e614cdf58320d83b96f9304c7234848885fd6e1f193d6e57d92f99bd9bd', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(70, '2022-08-03 02:03:45', 'SALE/POS2022/0075', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '272.7200', '0.0000', '', '0.0000', '0.0000', '27.2800', 1, '0.0000', '27.2800', '0.0000', '300.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 2, 1, '300.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'c113af00d5ea3bfbcbfa4d2f9c8e998c8f8717629b0efca67a8c54fce16ba426', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(72, '2022-08-03 02:25:50', 'SALE/POS2022/0076', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '272.7200', '0.0000', '', '0.0000', '0.0000', '27.2800', 1, '0.0000', '27.2800', '0.0000', '300.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 2, 1, '300.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'd7b4946f31f7e9e83133370bb6034c1eac72b69fb595447802828e65517249c3', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0),
(73, '2022-08-03 02:27:21', 'SALE/POS2022/0077', 1, 'Walking Customer', 4, 'Test', 1, NULL, NULL, '272.7200', '0.0000', '', '0.0000', '0.0000', '27.2800', 1, '0.0000', '27.2800', '0.0000', '300.0000', 'completed', 'paid', 0, NULL, 1, NULL, NULL, 2, 1, '300.0000', NULL, '0.0000', NULL, NULL, NULL, '0.0000', '0.0000', NULL, 0, 0, NULL, NULL, 'bdc79aec0056b5a1cb08a8f33818d594907caf56126c222d47a070de3e12eedf', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sls_sale_items`
--

CREATE TABLE `sls_sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `name_alt` varchar(255) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `sale_item_id` int(11) DEFAULT NULL,
  `product_unit_id` int(11) DEFAULT NULL,
  `product_unit_code` varchar(10) DEFAULT NULL,
  `unit_quantity` decimal(15,4) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `gst` varchar(20) DEFAULT NULL,
  `cgst` decimal(25,4) DEFAULT NULL,
  `sgst` decimal(25,4) DEFAULT NULL,
  `igst` decimal(25,4) DEFAULT NULL,
  `printer_selection` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sls_sale_items`
--

INSERT INTO `sls_sale_items` (`id`, `sale_id`, `product_id`, `product_code`, `product_name`, `name_alt`, `product_type`, `option_id`, `net_unit_price`, `unit_price`, `quantity`, `warehouse_id`, `item_tax`, `tax_rate_id`, `tax`, `discount`, `item_discount`, `subtotal`, `serial_no`, `real_unit_price`, `sale_item_id`, `product_unit_id`, `product_unit_code`, `unit_quantity`, `comment`, `gst`, `cgst`, `sgst`, `igst`, `printer_selection`) VALUES
(1, 1, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(2, 1, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(3, 2, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(4, 2, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(5, 3, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(6, 3, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(7, 4, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(8, 4, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(9, 5, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(10, 5, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(11, 6, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(12, 6, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(13, 7, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(14, 7, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(15, 8, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(16, 8, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(17, 9, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(18, 9, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(21, 11, 96, '01747274', 'Test1a', NULL, 'standard', 60, '161.0000', '161.0000', '2.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '322.0000', '', '149.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(22, 11, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '1.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '15.0000', '', '15.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(23, 12, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '30.0000', '', '15.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(24, 12, 103, '16535498', 'TestAB', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(25, 12, 4294967295, '1122', 'Test', NULL, 'manual', 0, '136.3600', '150.0000', '2.0000', 1, '27.2800', 2, '10%', '0', '0.0000', '300.0000', '', '150.0000', NULL, NULL, NULL, '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(26, 13, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '30.0000', '', '15.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(27, 14, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '30.0000', '', '15.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(28, 14, 103, '16535498', 'TestAB', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(29, 15, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '30.0000', '', '15.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(30, 16, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '30.0000', '', '15.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(37, 17, 99, '03329242', 'my11', NULL, 'standard', 0, '15.0000', '15.0000', '4.0000', 1, '0.0000', NULL, '', '0', '0.0000', '60.0000', '', '15.0000', NULL, 1, '1122', '4.0000', '', NULL, NULL, NULL, NULL, NULL),
(38, 17, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', NULL, '', '0', '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(39, 18, 110, '60823701', 'Var', NULL, 'standard', 89, '150.0000', '150.0000', '2.0000', 1, '0.0000', NULL, '', '0', '0.0000', '300.0000', '', '150.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(40, 19, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '90.9100', '100.0000', '1.0000', 1, '9.0900', 2, '10%', '0', '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(41, 20, 100, '61720108', 'my2Variant', NULL, 'standard', 0, '90.9100', '100.0000', '1.0000', 1, '9.0900', 2, '10%', '0', '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(42, 21, 108, '99824966', 'Testasd', NULL, 'standard', NULL, '150.0000', '150.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, '1122', '1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(48, 25, 107, '63863605', 'TestRR', NULL, 'standard', 0, '150.0000', '150.0000', '2.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '300.0000', '', '150.0000', NULL, 1, '1122', '2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(49, 25, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '3.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '450.0000', '', '150.0000', NULL, 1, '1122', '3.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(50, 26, 107, '63863605', 'TestRR', NULL, 'standard', 0, '150.0000', '150.0000', '2.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '300.0000', '', '150.0000', NULL, 1, '1122', '2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(51, 26, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '2.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '300.0000', '', '150.0000', NULL, 1, '1122', '2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(56, 24, 107, '63863605', 'TestRR', NULL, 'standard', 0, '150.0000', '150.0000', '2.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '300.0000', '', '150.0000', NULL, 1, '1122', '2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(57, 24, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '2.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '300.0000', '', '150.0000', NULL, 1, '1122', '2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(61, 27, 104, '92293990', 'TestBC', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(65, 28, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '150.0000', '', '150.0000', NULL, 1, '1122', '1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(70, 30, 103, '16535498', 'TestAB', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(71, 30, 104, '92293990', 'TestBC', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(72, 30, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(73, 31, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 33, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(78, 34, 105, '69140522', 'TestDC', NULL, 'standard', 0, '100.0000', '100.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-100.0000', '', '100.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(79, 34, 106, '72692446', 'TestFF', NULL, 'standard', 0, '100.0000', '100.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-100.0000', '', '100.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(80, 34, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(81, 35, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(82, 36, 106, '72692446', 'TestFF', NULL, 'standard', 0, '100.0000', '100.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-100.0000', '', '100.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(83, 37, 106, '72692446', 'TestFF', NULL, 'standard', 0, '100.0000', '100.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-100.0000', '', '100.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(84, 38, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(85, 39, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(86, 40, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(87, 41, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(88, 42, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-2.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-300.0000', '', '150.0000', NULL, 1, '1122', '-2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(89, 43, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(90, 44, 107, '63863605', 'TestRR', NULL, 'standard', NULL, '150.0000', '150.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, '1122', '1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(91, 44, 108, '99824966', 'Testasd', NULL, 'standard', NULL, '150.0000', '150.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, '1122', '1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(92, 45, 108, '99824966', 'Testasd', NULL, 'standard', NULL, '150.0000', '150.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, '1122', '1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(93, 46, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '-1.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-150.0000', '', '150.0000', NULL, 1, '1122', '-1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(94, 47, 103, '16535498', 'TestAB', NULL, 'standard', 0, '100.0000', '100.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '100.0000', '', '100.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(95, 47, 104, '92293990', 'TestBC', NULL, 'standard', 0, '100.0000', '100.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '200.0000', '', '100.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(96, 47, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, '1122', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(97, 48, 104, '92293990', 'TestBC', NULL, 'standard', 0, '100.0000', '100.0000', '-2.0000', 1, '0.0000', 0, '0', NULL, '0.0000', '-200.0000', '', '100.0000', NULL, 1, '1122', '-2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(98, 50, 110, '60823701', 'Var', NULL, 'standard', NULL, '120.0000', '120.0000', '-2.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '-240.0000', '', '120.0000', 0, 1, '1122', '-2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(99, 51, 103, '16535498', 'TestAB', NULL, 'standard', 0, '100.0000', '100.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '200.0000', '', '100.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(100, 51, 105, '69140522', 'TestDC', NULL, 'standard', 0, '100.0000', '100.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '200.0000', '', '100.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(101, 51, 108, '99824966', 'Testasd', NULL, 'standard', 0, '150.0000', '150.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '300.0000', '', '150.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(102, 52, 103, '16535498', 'TestAB', NULL, 'standard', NULL, '100.0000', '100.0000', '-2.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '-200.0000', '', '80.0000', 99, 1, '1122', '-2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(103, 53, 103, '16535498', 'TestAB', NULL, 'standard', 0, '100.0000', '100.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '200.0000', '', '100.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(104, 53, 104, '92293990', 'TestBC', NULL, 'standard', 0, '100.0000', '100.0000', '2.0000', 1, '0.0000', 0, '0', '0', '0.0000', '200.0000', '', '100.0000', NULL, 1, '1122', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(105, 54, 103, '16535498', 'TestAB', NULL, 'standard', NULL, '100.0000', '100.0000', '-2.0000', 1, '0.0000', NULL, '', NULL, '0.0000', '-200.0000', '', '80.0000', 103, 1, '1122', '-2.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(109, 58, 108, '99824966', 'Testasd', NULL, 'standard', NULL, '150.0000', '150.0000', '1.0000', 1, '0.0000', 0, '0', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, '1122', '1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(110, 59, 110, '60823701', 'Var', NULL, 'standard', 89, '136.3600', '150.0000', '2.0000', 1, '27.2800', 2, '10%', '0', '0.0000', '300.0000', '', '150.0000', NULL, 1, 'pc', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(114, 63, 110, '60823701', 'Var', NULL, 'standard', 89, '136.3600', '150.0000', '2.0000', 1, '27.2800', 2, '10%', '0', '0.0000', '300.0000', '', '150.0000', NULL, 1, 'pc', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(117, 66, 110, '60823701', 'Var', NULL, 'standard', 89, '136.3600', '150.0000', '1.0000', 1, '13.6400', 2, '10%', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, 'pc', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(119, 68, 110, '60823701', 'Var', NULL, 'standard', 89, '136.3600', '150.0000', '1.0000', 1, '13.6400', 2, '10%', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, 'pc', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(120, 69, 110, '60823701', 'Var', NULL, 'standard', 89, '136.3600', '150.0000', '1.0000', 1, '13.6400', 2, '10%', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, 'pc', '1.0000', NULL, NULL, NULL, NULL, NULL, NULL),
(121, 70, 117, '12446983', 'TestVar', NULL, 'standard', 92, '136.3600', '150.0000', '2.0000', 1, '27.2800', 2, '10%', '0', '0.0000', '300.0000', '', '150.0000', NULL, 1, 'pc', '2.0000', '', NULL, NULL, NULL, NULL, NULL),
(124, 72, 115, '49179907', 'variant', NULL, 'standard', 0, '136.3600', '150.0000', '1.0000', 1, '13.6400', 2, '10%', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, 'pc', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(125, 72, 117, '12446983', 'TestVar', NULL, 'standard', 92, '136.3600', '150.0000', '1.0000', 1, '13.6400', 2, '10%', '0', '0.0000', '150.0000', '', '150.0000', NULL, 1, 'pc', '1.0000', '', NULL, NULL, NULL, NULL, NULL),
(126, 73, 117, '12446983', 'TestVar', NULL, 'standard', 92, '136.3600', '150.0000', '2.0000', 1, '27.2800', 2, '10%', '0', '0.0000', '300.0000', '', '150.0000', NULL, 1, 'pc', '2.0000', '', NULL, NULL, NULL, NULL, NULL);

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
(1, 'logo2.png', 'logo3.png', 'Sales Erp', '', 1, 0, 'SAR', 1, 10, '3.4.53', 1, 4, 'SALE', '', '', '', '', 'IPAY', 'SR', '', '', 1, '', 0, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 800, 800, 0, 0, NULL, 0, 0, 0, NULL, '', NULL, NULL, NULL, 'Alama360alama', NULL, NULL, NULL, 0, 'sales.erp@admin.com', 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, '', '', 1, 4, 'moslehaisoft', '6f1088a7-9623-477f-bc96-20c37ff0c443', 0, NULL, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, 0, '-', 0, NULL, 1, 'POP', NULL, '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', 'ggsk4wkssoc4sccgskggssws04gc4gokc4g4gokw', NULL, NULL);

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
(2, 'abc', 'Abc', '01558930222', 'admin33@example.com', 'test', 'test', 'Test', '1234', '', '', 1, '2022-07-17 08:58:57', '2'),
(12, 'abc', 'Abc', '01558930222', 'admin44@example.com', 'test', 'test', 'Test', '1234', '', '', 1, '2022-07-17 08:51:26', '2'),
(7, 'Test6', 'test6', '015589', 'admin6@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:14:33', '2'),
(8, 'Test7', 'test7', '01767896', 'admin7@example.com', 'test', 'test', '', '', '', '', 1, '2021-05-24 15:15:16', '2'),
(9, 'aisoft', 'Owner', '015589', 'aisoft@example.com', 'test', 'test', 'Test', '1211', 'BDESH', '1122', 1, '2021-05-25 06:10:15', '2'),
(10, 'Test Supplier', 'testsup', '01558933', 'admintest@example.com', 'testsup', 'test', 'Testsup', '121133', 'BDESH', '112233', 1, '2021-05-25 08:36:38', '2'),
(14, 'abc', 'Abc', '01558930222', 'admin33@example.com', 'test', 'test', 'Test', '1234', '', '', 1, '2022-07-17 08:59:58', '2');

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
(1, 'pc', 'piece', NULL, NULL, NULL, NULL),
(2, 'kg', 'kilogram', NULL, NULL, NULL, NULL),
(5, 'ltr', 'Litre', NULL, NULL, NULL, NULL),
(6, 'sqrft', 'Square Feet', NULL, NULL, NULL, NULL);

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
(1, '2', 'admin@example.com', '41d99b369894eb1ec3f461135132d8bb', '', 'admin@example.com	', 1, 'Aisoft', 'Aisoft', NULL, NULL, NULL, 1, 0),
(2, '500636', 'aisoft@example.com', '41d99b369894eb1ec3f461135132d8bb', '01558930222', 'aisoft@example.com', 1, 'Aisoft', 'Aisoft', NULL, NULL, NULL, 1, 0),
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
(108, 99, 1, '30.0000', NULL, '10.0000'),
(109, 99, 2, '0.0000', NULL, '10.0000'),
(110, 100, 1, '0.0000', NULL, '80.0000'),
(111, 100, 2, '0.0000', NULL, '80.0000'),
(112, 1, 1, '0.0000', NULL, '80.0000'),
(113, 1, 2, '0.0000', NULL, '80.0000'),
(114, 1, 1, '0.0000', NULL, '80.0000'),
(115, 1, 2, '0.0000', NULL, '80.0000'),
(116, 103, 1, '0.0000', NULL, '80.0000'),
(117, 103, 2, '0.0000', NULL, '80.0000'),
(118, 104, 1, '0.0000', NULL, '80.0000'),
(119, 104, 2, '0.0000', NULL, '80.0000'),
(120, 105, 1, '0.0000', NULL, '80.0000'),
(121, 105, 2, '0.0000', NULL, '80.0000'),
(122, 106, 1, '0.0000', NULL, '80.0000'),
(123, 106, 2, '0.0000', NULL, '80.0000'),
(124, 107, 1, '0.0000', NULL, '120.0000'),
(125, 107, 2, '0.0000', NULL, '120.0000'),
(126, 108, 1, '0.0000', NULL, '120.0000'),
(127, 108, 2, '0.0000', NULL, '120.0000'),
(128, 96, 1, '30.0000', NULL, '120.0000'),
(131, 110, 1, '17.0000', NULL, '120.0000'),
(132, 110, 2, '0.0000', NULL, '120.0000'),
(133, 111, 1, '0.0000', NULL, '120.0000'),
(134, 111, 2, '0.0000', NULL, '120.0000'),
(135, 112, 1, '0.0000', NULL, '120.0000'),
(136, 112, 2, '0.0000', NULL, '120.0000'),
(137, 113, 1, '0.0000', NULL, '120.0000'),
(138, 113, 2, '0.0000', NULL, '120.0000'),
(139, 114, 1, '0.0000', NULL, '120.0000'),
(140, 114, 2, '0.0000', NULL, '120.0000'),
(141, 115, 1, '-1.0000', NULL, '120.0000'),
(142, 115, 2, '0.0000', NULL, '120.0000'),
(145, 117, 1, '5.0000', NULL, '120.0000'),
(146, 117, 2, '0.0000', NULL, '120.0000'),
(147, 118, 1, '0.0000', NULL, '120.0000'),
(148, 118, 2, '0.0000', NULL, '120.0000');

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
(26, 83, 100, 2, '0.0000', NULL),
(31, 89, 110, 1, '8.0000', NULL),
(32, 89, 110, 2, '0.0000', NULL),
(33, 90, 110, 1, '10.0000', NULL),
(34, 90, 110, 2, '0.0000', NULL),
(37, 92, 117, 1, '5.0000', NULL),
(38, 92, 117, 2, '0.0000', NULL),
(39, 93, 117, 1, '0.0000', NULL),
(40, 93, 117, 2, '0.0000', NULL),
(41, 94, 118, 1, '0.0000', NULL),
(42, 94, 118, 2, '0.0000', NULL),
(43, 95, 118, 1, '0.0000', NULL),
(44, 95, 118, 2, '0.0000', NULL);

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
-- Indexes for table `sls_attachments`
--
ALTER TABLE `sls_attachments`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `sls_order_ref`
--
ALTER TABLE `sls_order_ref`
  ADD PRIMARY KEY (`ref_id`);

--
-- Indexes for table `sls_order_status_tracking`
--
ALTER TABLE `sls_order_status_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sls_payments`
--
ALTER TABLE `sls_payments`
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
-- Indexes for table `sls_purchases`
--
ALTER TABLE `sls_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `sls_purchase_items`
--
ALTER TABLE `sls_purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sls_sales`
--
ALTER TABLE `sls_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `sls_sale_items`
--
ALTER TABLE `sls_sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_id_2` (`product_id`,`sale_id`),
  ADD KEY `sale_id_2` (`sale_id`,`product_id`);

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
-- AUTO_INCREMENT for table `sls_attachments`
--
ALTER TABLE `sls_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sls_billers`
--
ALTER TABLE `sls_billers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- AUTO_INCREMENT for table `sls_order_ref`
--
ALTER TABLE `sls_order_ref`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sls_order_status_tracking`
--
ALTER TABLE `sls_order_status_tracking`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `sls_payments`
--
ALTER TABLE `sls_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `sls_printers`
--
ALTER TABLE `sls_printers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sls_products`
--
ALTER TABLE `sls_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `sls_product_variants`
--
ALTER TABLE `sls_product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `sls_purchases`
--
ALTER TABLE `sls_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sls_purchase_items`
--
ALTER TABLE `sls_purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sls_sales`
--
ALTER TABLE `sls_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `sls_sale_items`
--
ALTER TABLE `sls_sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `sls_suppliers`
--
ALTER TABLE `sls_suppliers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sls_tax_rates`
--
ALTER TABLE `sls_tax_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sls_units`
--
ALTER TABLE `sls_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `sls_warehouses_products_variants`
--
ALTER TABLE `sls_warehouses_products_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `sls_web_setting`
--
ALTER TABLE `sls_web_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
