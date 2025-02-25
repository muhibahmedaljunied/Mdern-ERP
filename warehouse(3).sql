-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 12:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `absences`
--

CREATE TABLE `absences` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `absence_type_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absences`
--

INSERT INTO `absences` (`id`, `staff_id`, `absence_type_id`, `date`, `note`, `created_at`, `updated_at`) VALUES
(1, 6, 2, '2025-02-20', NULL, NULL, NULL),
(2, 5, 1, '2025-02-01', NULL, '2025-02-19 20:24:11', '2025-02-19 20:24:11'),
(3, 4, 2, '2025-02-06', NULL, '2025-02-22 11:51:26', '2025-02-22 11:51:26'),
(6, 7, 1, '2025-02-09', NULL, '2025-02-24 12:12:00', '2025-02-24 12:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `absence_details`
--

CREATE TABLE `absence_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `absence_id` int(10) UNSIGNED NOT NULL,
  `absence_sanction_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absence_sanctions`
--

CREATE TABLE `absence_sanctions` (
  `id` int(10) UNSIGNED NOT NULL,
  `absence_type_id` int(10) UNSIGNED NOT NULL,
  `sanction_discount_id` int(10) UNSIGNED NOT NULL,
  `discount` int(11) NOT NULL,
  `iteration` int(11) NOT NULL,
  `sanction` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absence_sanctions`
--

INSERT INTO `absence_sanctions` (`id`, `absence_type_id`, `sanction_discount_id`, `discount`, `iteration`, `sanction`, `created_at`, `updated_at`) VALUES
(13, 1, 1, 1, 1, 1000, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(14, 1, 1, 1, 2, 1500, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(15, 1, 1, 1, 3, 1700, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(16, 2, 1, 1, 1, 2000, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(17, 2, 1, 1, 2, 1400, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(18, 2, 1, 1, 3, 1500, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(19, 2, 1, 1, 4, 1600, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(20, 4, 1, 1, 1, 1000, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(21, 4, 1, 1, 2, 1300, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(22, 4, 1, 1, 3, 3000, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(23, 4, 1, 1, 4, 3200, '2025-02-18 17:44:05', '2025-02-18 17:44:05'),
(24, 4, 1, 1, 5, 3500, '2025-02-18 17:44:05', '2025-02-18 17:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `absence_types`
--

CREATE TABLE `absence_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absence_types`
--

INSERT INTO `absence_types` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'يوم السبت', 'Sat', NULL, NULL),
(2, 'يوم الخميس', 'Thu', NULL, NULL),
(3, 'بعد عطله اسبوعيه', 'After_holiday', NULL, NULL),
(4, 'بعد اجازه رسميه', 'After_vacation', NULL, NULL),
(5, 'يوم اجتماع', 'meet', '2025-02-24 17:41:27', '2025-02-24 17:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `account_name_en` varchar(255) DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `rank` int(11) DEFAULT 0,
  `account_type_debit_credit` int(11) DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `final_account` int(11) DEFAULT NULL,
  `status_account` varchar(255) NOT NULL DEFAULT 'true',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `text`, `account_name_en`, `parent_id`, `rank`, `account_type_debit_credit`, `account_type`, `currency`, `final_account`, `status_account`, `created_at`, `updated_at`) VALUES
(1, 'الاصول', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(2, 'الخصوم', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(3, 'الايرادات', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(4, 'المصروفات', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(5, 'حقوق الملكية', NULL, NULL, NULL, 2, 5, NULL, 1, 'true', '2025-02-26 18:30:29', '2025-02-26 18:30:29'),
(11, 'الاصول الثابته', NULL, 1, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(12, 'الاصول المتداوله', NULL, 1, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(21, 'الخصوم الثابته', NULL, 2, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(22, 'الخصوم المتداوله', NULL, 2, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(23, 'حسابات داينه اخري', NULL, 2, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(31, 'المبيعات', NULL, 3, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(32, 'ايرادات حضور وغياب', NULL, 3, 1, NULL, NULL, NULL, NULL, 'true', '2024-03-04 21:00:00', '2024-03-04 21:00:00'),
(41, 'مصروف رواتب واجور', NULL, 4, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(42, 'مصروفات اداريه', NULL, 4, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(43, 'مصروفات عموميه', NULL, 4, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(44, 'مصروفات نثريه', NULL, 4, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(45, 'مصروفات اخري', NULL, 4, 1, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(46, 'تكلفة البضاعه المباعة', NULL, 4, 1, 1, 6, NULL, 2, 'false', '2025-02-26 18:17:16', '2025-02-26 18:17:16'),
(47, 'الضرائب', NULL, 4, 1, 1, 6, NULL, 2, 'false', '2025-02-26 18:18:46', '2025-02-26 18:18:46'),
(48, 'مردودات المبيعات', NULL, 4, 1, 1, 6, NULL, 2, 'false', '2025-02-26 19:46:11', '2025-02-26 19:46:11'),
(51, 'ارباح وخساير محتجزه', NULL, 5, 1, 2, 5, NULL, 1, 'false', '2025-02-26 18:31:19', '2025-02-26 18:31:19'),
(52, 'راس المال', NULL, 5, 1, 2, 5, NULL, 1, 'true', '2025-02-26 19:02:41', '2025-02-26 19:02:41'),
(111, 'الاراضي', NULL, 11, 2, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(112, 'السيارات', NULL, 11, 2, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(113, 'العقارات', NULL, 11, 2, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(121, 'البنك', NULL, 12, 2, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(122, 'الصندوق', NULL, 12, 2, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(123, 'العملاء المدينون', NULL, 12, 2, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(124, 'المخزون', NULL, 12, 2, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(125, 'سلف الموظفين', NULL, 12, 2, NULL, NULL, NULL, NULL, 'false', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(126, 'خصميات الموظف', NULL, 12, 2, NULL, NULL, NULL, NULL, 'false', '2024-02-22 21:00:00', '2024-02-22 21:00:00'),
(221, 'الموردون الداينون', NULL, 22, 2, NULL, NULL, NULL, NULL, 'true', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(231, 'مستحقات الموظفين', NULL, 23, 2, NULL, NULL, NULL, NULL, 'false', '2023-12-03 21:00:00', '2023-12-03 21:00:00'),
(232, 'اضافي الموظف', NULL, 23, 2, NULL, NULL, NULL, NULL, 'false', '2024-02-22 21:00:00', '2024-02-22 21:00:00'),
(233, 'بدلات الموظف', NULL, 23, 2, NULL, NULL, NULL, NULL, 'false', '2024-02-22 21:00:00', '2024-02-22 21:00:00'),
(321, 'ايرادات غياب', NULL, 32, 2, NULL, NULL, NULL, NULL, 'false', '2024-03-04 21:00:00', '2024-03-04 21:00:00'),
(322, 'ايرادات تأخير', NULL, 32, 2, NULL, NULL, NULL, NULL, 'false', '2024-03-04 21:00:00', '2024-03-04 21:00:00'),
(323, 'ايرادات انصراف مبكر', NULL, 32, 2, NULL, NULL, NULL, NULL, 'false', '2024-03-04 21:00:00', '2024-03-04 21:00:00'),
(324, 'ايرادات خصم اخري', NULL, 32, 2, NULL, NULL, NULL, NULL, 'false', '2024-03-04 21:00:00', '2024-03-04 21:00:00'),
(411, 'مصروف الرواتب', NULL, 41, 2, NULL, NULL, NULL, NULL, 'false', '2024-02-23 21:00:00', '2024-02-23 21:00:00'),
(412, 'مصروف البدلات', NULL, 41, 2, NULL, NULL, NULL, NULL, 'false', '2024-02-23 21:00:00', '2024-02-23 21:00:00'),
(413, 'مصروف الاضافي', NULL, 41, 2, NULL, NULL, NULL, NULL, 'false', '2024-02-23 21:00:00', '2024-02-23 21:00:00'),
(441, 'فواتير كهرباء', NULL, 44, 2, NULL, NULL, NULL, NULL, 'false', '2023-12-11 21:00:00', '2023-12-11 21:00:00'),
(442, 'فواتير ماء', NULL, 44, 2, NULL, NULL, NULL, NULL, 'false', '2023-12-11 21:00:00', '2023-12-11 21:00:00'),
(443, 'فواتير هاتف', NULL, 44, 2, NULL, NULL, NULL, NULL, 'false', '2023-12-11 21:00:00', '2023-12-11 21:00:00'),
(451, 'صدقات وتبرعات', NULL, 45, 2, NULL, NULL, NULL, NULL, 'false', '2024-05-03 21:00:00', '2024-05-03 21:00:00'),
(521, 'راس مال الشريك1', NULL, 52, 2, 2, 5, NULL, 1, 'false', '2025-02-26 19:07:13', '2025-02-26 19:07:13'),
(1211, 'بنك الكريمي', NULL, 121, 3, NULL, NULL, NULL, NULL, 'false', '2023-12-04 21:00:00', '2023-12-04 21:00:00'),
(1212, 'بنك دولار', NULL, 121, 3, NULL, NULL, NULL, NULL, 'false', '2024-03-30 21:00:00', '2024-03-30 21:00:00'),
(1221, 'صندوق حده المدينه', NULL, 122, 3, NULL, NULL, NULL, NULL, 'false', '2023-12-04 21:00:00', '2023-12-04 21:00:00'),
(1222, 'صندوق باب اليمن', NULL, 122, 3, NULL, NULL, NULL, NULL, 'false', '2023-12-04 21:00:00', '2023-12-04 21:00:00'),
(1223, 'صندوق دولار', NULL, 122, 3, NULL, NULL, NULL, NULL, 'false', '2024-03-30 21:00:00', '2024-03-30 21:00:00'),
(1224, 'صندوق ريال', NULL, 122, 3, NULL, NULL, NULL, NULL, 'false', '2024-03-30 21:00:00', '2024-03-30 21:00:00'),
(1231, 'العميل محمد علي حسن', NULL, 123, 3, NULL, NULL, NULL, NULL, 'false', '2023-12-04 21:00:00', '2023-12-04 21:00:00'),
(1232, 'عملاء تعز', NULL, 123, 3, NULL, NULL, NULL, NULL, 'false', '2024-03-29 21:00:00', '2024-03-29 21:00:00'),
(1233, 'عملاء صنعاء', NULL, 123, 3, NULL, NULL, NULL, NULL, 'false', '2024-03-29 21:00:00', '2024-03-29 21:00:00'),
(1241, 'المخزن الريسي', NULL, 124, 3, NULL, NULL, NULL, NULL, 'false', '2023-12-04 21:00:00', '2023-12-04 21:00:00'),
(1242, 'المخزن المركزي الاول', NULL, 124, 3, NULL, NULL, NULL, NULL, 'false', '2023-12-04 21:00:00', '2023-12-04 21:00:00'),
(1243, 'مخزن المواد الغذائيه', NULL, 124, 3, NULL, NULL, NULL, NULL, 'false', '2024-04-07 21:00:00', '2024-04-07 21:00:00'),
(1261, 'غياب', NULL, 126, 3, NULL, NULL, NULL, NULL, 'false', '2024-02-23 21:00:00', '2024-02-23 21:00:00'),
(1262, 'تأخير', NULL, 126, 3, NULL, NULL, NULL, NULL, 'false', '2024-02-23 21:00:00', '2024-02-23 21:00:00'),
(1263, 'انصراف مبكر', NULL, 126, 3, NULL, NULL, NULL, NULL, 'false', '2024-02-23 21:00:00', '2024-02-23 21:00:00'),
(1264, 'خصميات اخري', NULL, 126, 3, NULL, NULL, NULL, NULL, 'false', '2024-02-23 21:00:00', '2024-02-23 21:00:00'),
(2211, 'المورد مهيب احمد عبدالجليل الجنيد الجنيد', NULL, 221, 3, NULL, NULL, NULL, NULL, 'false', '2023-12-04 21:00:00', '2023-12-04 21:00:00'),
(2212, 'موردين تعز', NULL, 221, 3, NULL, NULL, NULL, NULL, 'false', '2024-03-29 21:00:00', '2024-03-29 21:00:00'),
(2213, 'موردين صنعاء', NULL, 221, 3, NULL, NULL, NULL, NULL, 'false', '2024-03-29 21:00:00', '2024-03-29 21:00:00'),
(2331, 'بدل مواصلات', NULL, 233, 3, NULL, NULL, NULL, NULL, 'false', '2024-05-12 21:00:00', '2024-05-12 21:00:00'),
(2332, 'بدل سكن', NULL, 233, 3, NULL, NULL, NULL, NULL, 'false', '2024-05-12 21:00:00', '2024-05-12 21:00:00'),
(2333, 'بدل تغذيه', NULL, 233, 3, NULL, NULL, NULL, NULL, 'false', '2024-05-12 21:00:00', '2024-05-12 21:00:00'),
(4121, 'مصروف بدلات السكن', NULL, 412, 3, NULL, NULL, NULL, NULL, 'false', '2024-02-25 21:00:00', '2024-02-25 21:00:00'),
(4122, 'مصروف بدلات المواصلات', NULL, 412, 3, NULL, NULL, NULL, NULL, 'false', '2024-02-25 21:00:00', '2024-02-25 21:00:00'),
(4123, 'مصروف بدلات التغذيه', NULL, 412, 3, NULL, NULL, NULL, NULL, 'false', '2024-02-25 21:00:00', '2024-02-25 21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `account_years`
--

CREATE TABLE `account_years` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `administrative_structures`
--

CREATE TABLE `administrative_structures` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `type_branch` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrative_structures`
--

INSERT INTO `administrative_structures` (`id`, `text`, `parent_id`, `rank`, `type_branch`, `status`, `created_at`, `updated_at`) VALUES
(1, 'مدير عام المصنع', NULL, NULL, NULL, 'true', '2025-02-18 18:00:06', '2025-02-18 18:00:06'),
(2, 'مدير المصنع', NULL, NULL, NULL, 'true', '2025-02-18 18:00:06', '2025-02-18 18:00:06'),
(3, 'اداره الانتاج', NULL, NULL, NULL, 'true', '2025-02-18 18:00:06', '2025-02-18 18:00:06'),
(4, 'قسم الصيانه والتشغيل', NULL, NULL, NULL, 'true', '2025-02-18 18:00:06', '2025-02-18 18:00:06'),
(5, 'قسم المستودعات', NULL, NULL, NULL, 'true', '2025-02-18 18:00:06', '2025-02-18 18:00:06'),
(6, 'مسؤل النقل', NULL, NULL, NULL, 'true', '2025-02-18 18:00:06', '2025-02-18 18:00:06'),
(7, 'مسؤول اداري', NULL, NULL, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(8, 'منسق اداري', NULL, NULL, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(9, 'اداره المصنع', NULL, NULL, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(10, 'مهندس الانتاج', 3, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(11, 'عمال انتاج', 3, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(12, 'عمال نظافه', 3, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(13, 'عمال تحميل وتنزيل', 3, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(14, 'مشغلي المصنع', 3, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(15, 'مشغل معدات عام', 3, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(16, 'ميكانيكي مصنع', 4, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(17, 'مساعد ميكانيكي مصنع', 4, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(18, 'كهربائي مصنع', 4, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(19, 'مساعد كهربائي مصنع', 4, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(20, 'صيانه عامه', 4, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(21, 'الانتاج التام', 5, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07'),
(22, 'الانتاج الخام', 5, 1, NULL, 'true', '2025-02-18 18:00:07', '2025-02-18 18:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `advances`
--

CREATE TABLE `advances` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advances`
--

INSERT INTO `advances` (`id`, `staff_id`, `quantity`, `date`, `note`, `created_at`, `updated_at`) VALUES
(3, 4, 3000, '2025-02-22', NULL, '2025-02-22 17:07:49', '2025-02-22 17:07:49'),
(4, 5, 3000, '2025-02-06', NULL, '2025-02-22 17:21:52', '2025-02-22 17:21:52'),
(5, 6, 3000, '2025-02-03', NULL, '2025-02-22 17:22:06', '2025-02-22 17:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `allowance_type_id` int(10) UNSIGNED NOT NULL,
  `status` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`id`, `staff_id`, `allowance_type_id`, `status`, `quantity`, `date`, `created_at`, `updated_at`) VALUES
(1, 4, 1, NULL, 4000, NULL, '2025-02-19 17:11:31', '2025-02-19 17:11:31'),
(2, 4, 2, NULL, 6000, NULL, '2025-02-19 17:11:31', '2025-02-19 17:11:31'),
(3, 4, 3, NULL, 30000, NULL, '2025-02-19 17:11:31', '2025-02-19 17:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `allowance_types`
--

CREATE TABLE `allowance_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allowance_types`
--

INSERT INTO `allowance_types` (`id`, `name`, `group_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'بدل مواصلات', NULL, '1', '2025-02-19 16:46:01', '2025-02-19 16:46:01'),
(2, 'بدل سفر', NULL, '1', '2025-02-19 16:46:43', '2025-02-19 16:46:43'),
(3, 'بدل تغذيه', NULL, '1', '2025-02-19 16:46:43', '2025-02-19 16:46:43'),
(4, 'بدل مظهر', NULL, '2', '2025-02-24 17:53:32', '2025-02-24 17:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `attendance_status` varchar(255) NOT NULL,
  `attendance_final` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `staff_id`, `attendance_date`, `attendance_status`, `attendance_final`, `created_at`, `updated_at`) VALUES
(3, 4, '2025-02-19', '1', 'pendding', '2025-02-19 17:27:01', '2025-02-19 17:27:01'),
(4, 4, '2025-02-18', '1', 'pendding', '2025-02-19 18:00:12', '2025-02-19 18:00:12'),
(5, 5, '2025-02-19', '1', 'pendding', '2025-02-19 18:08:18', '2025-02-19 18:08:18'),
(6, 6, '2025-02-20', '0', 'pendding', '2025-02-19 18:21:25', '2025-02-19 18:21:25'),
(7, 5, '2025-02-01', '0', 'pendding', '2025-02-19 20:24:11', '2025-02-19 20:24:11'),
(10, 5, '2025-02-06', '1', 'pendding', '2025-02-22 11:50:31', '2025-02-22 11:50:31'),
(11, 6, '2025-02-06', '1', 'pendding', '2025-02-22 11:50:31', '2025-02-22 11:50:31'),
(12, 4, '2025-02-06', '0', 'pendding', '2025-02-22 11:51:26', '2025-02-22 11:51:26'),
(13, 5, '2025-02-22', '1', 'pendding', '2025-02-22 12:19:11', '2025-02-22 12:19:11'),
(14, 4, '2025-02-22', '1', 'pendding', '2025-02-22 12:19:11', '2025-02-22 12:19:11'),
(15, 6, '2025-02-22', '1', 'pendding', '2025-02-22 12:19:11', '2025-02-22 12:19:11'),
(16, 7, '2025-02-01', '1', 'pendding', '2025-02-24 12:07:59', '2025-02-24 12:07:59'),
(17, 4, '2025-02-01', '1', 'pendding', '2025-02-24 12:07:59', '2025-02-24 12:07:59'),
(18, 6, '2025-02-01', '1', 'pendding', '2025-02-24 12:07:59', '2025-02-24 12:07:59'),
(19, 5, '2025-02-10', '1', 'pendding', '2025-02-24 12:08:52', '2025-02-24 12:08:52'),
(20, 7, '2025-02-10', '1', 'pendding', '2025-02-24 12:08:52', '2025-02-24 12:08:52'),
(21, 4, '2025-02-10', '1', 'pendding', '2025-02-24 12:08:53', '2025-02-24 12:08:53'),
(22, 6, '2025-02-10', '1', 'pendding', '2025-02-24 12:08:53', '2025-02-24 12:08:53'),
(23, 5, '2025-02-25', '1', 'pendding', '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(24, 7, '2025-02-25', '1', 'pendding', '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(25, 4, '2025-02-25', '1', 'pendding', '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(26, 6, '2025-02-25', '1', 'pendding', '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(29, 7, '2025-02-09', '0', 'pendding', '2025-02-24 12:12:00', '2025-02-24 12:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_details`
--

CREATE TABLE `attendance_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `attendance_id` int(10) UNSIGNED NOT NULL,
  `period_id` int(10) UNSIGNED NOT NULL,
  `attendance_statusssss` varchar(255) DEFAULT NULL,
  `check_in` time DEFAULT '00:00:00',
  `check_out` time DEFAULT '00:00:00',
  `duration` int(11) DEFAULT 0,
  `delay` int(11) DEFAULT 0,
  `leaveout` int(11) DEFAULT 0,
  `extra` int(11) DEFAULT 0,
  `extra_after` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_details`
--

INSERT INTO `attendance_details` (`id`, `attendance_id`, `period_id`, `attendance_statusssss`, `check_in`, `check_out`, `duration`, `delay`, `leaveout`, `extra`, `extra_after`, `created_at`, `updated_at`) VALUES
(1, 3, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-19 17:27:01', '2025-02-19 17:27:01'),
(2, 3, 6, NULL, '14:30:00', '17:30:00', 180, 30, 0, 0, 30, '2025-02-19 17:27:01', '2025-02-19 17:27:01'),
(3, 4, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-19 18:00:12', '2025-02-19 18:00:12'),
(4, 4, 6, NULL, '14:30:00', '17:30:00', 180, 30, 0, 0, 30, '2025-02-19 18:00:12', '2025-02-19 18:00:12'),
(5, 5, 5, NULL, '08:30:00', '12:30:00', 240, 30, 30, 0, 0, '2025-02-19 18:08:18', '2025-02-19 18:08:18'),
(6, 5, 6, NULL, '14:00:00', '17:30:00', 210, 0, 0, 0, 30, '2025-02-19 18:08:18', '2025-02-19 18:08:18'),
(7, 10, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-22 11:50:31', '2025-02-22 11:50:31'),
(8, 10, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-22 11:50:31', '2025-02-22 11:50:31'),
(9, 11, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-22 11:50:31', '2025-02-22 11:50:31'),
(10, 11, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-22 11:50:31', '2025-02-22 11:50:31'),
(11, 13, 5, NULL, '08:30:00', '13:00:00', 270, 30, 0, 0, 0, '2025-02-22 12:19:11', '2025-02-22 12:19:11'),
(12, 13, 6, NULL, '14:00:00', '17:30:00', 210, 0, 0, 0, 30, '2025-02-22 12:19:11', '2025-02-22 12:19:11'),
(13, 14, 5, NULL, '07:30:00', '13:00:00', 330, 0, 0, 30, 0, '2025-02-22 12:19:11', '2025-02-22 12:19:11'),
(14, 14, 6, NULL, '14:30:00', '17:30:00', 180, 30, 0, 0, 30, '2025-02-22 12:19:11', '2025-02-22 12:19:11'),
(15, 15, 5, NULL, '08:15:00', '13:00:00', 285, 15, 0, 0, 0, '2025-02-22 12:19:11', '2025-02-22 12:19:11'),
(16, 15, 6, NULL, '14:00:00', '17:15:00', 195, 0, 0, 0, 15, '2025-02-22 12:19:11', '2025-02-22 12:19:11'),
(17, 16, 7, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:07:59', '2025-02-24 12:07:59'),
(18, 16, 8, NULL, '14:00:00', '18:00:00', 240, 0, 0, 0, 0, '2025-02-24 12:07:59', '2025-02-24 12:07:59'),
(19, 17, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:07:59', '2025-02-24 12:07:59'),
(20, 17, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-24 12:07:59', '2025-02-24 12:07:59'),
(21, 18, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:07:59', '2025-02-24 12:07:59'),
(22, 18, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-24 12:07:59', '2025-02-24 12:07:59'),
(23, 19, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:08:52', '2025-02-24 12:08:52'),
(24, 19, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-24 12:08:52', '2025-02-24 12:08:52'),
(25, 20, 7, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:08:52', '2025-02-24 12:08:52'),
(26, 20, 8, NULL, '14:00:00', '18:00:00', 240, 0, 0, 0, 0, '2025-02-24 12:08:53', '2025-02-24 12:08:53'),
(27, 21, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:08:53', '2025-02-24 12:08:53'),
(28, 21, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-24 12:08:53', '2025-02-24 12:08:53'),
(29, 22, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:08:53', '2025-02-24 12:08:53'),
(30, 22, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-24 12:08:53', '2025-02-24 12:08:53'),
(31, 23, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(32, 23, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(33, 24, 7, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(34, 24, 8, NULL, '14:00:00', '18:00:00', 240, 0, 0, 0, 0, '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(35, 25, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(36, 25, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(37, 26, 5, NULL, '08:00:00', '13:00:00', 300, 0, 0, 0, 0, '2025-02-24 12:09:55', '2025-02-24 12:09:55'),
(38, 26, 6, NULL, '14:00:00', '17:00:00', 180, 0, 0, 0, 0, '2025-02-24 12:09:55', '2025-02-24 12:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `group_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 3, 'بنك القاسمي', '2025-02-17 18:44:16', '2025-02-18 13:20:26'),
(2, NULL, 'بنك الكريمي', '2025-02-17 18:51:48', '2025-02-17 18:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'تعز', NULL, NULL),
(2, 'صنعاء', NULL, NULL),
(3, 'اب', NULL, NULL),
(4, 'عدن', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cashes`
--

CREATE TABLE `cashes` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `customer_name` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `grand_total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cashes`
--

INSERT INTO `cashes` (`id`, `customer_id`, `daily_id`, `customer_name`, `date`, `status`, `grand_total`, `created_at`, `updated_at`) VALUES
(2, 7, 12, 'مهيب الجنيد', '2025-02-24', 'pending', 8000, '2025-02-24 20:04:40', '2025-02-24 20:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `cash_details`
--

CREATE TABLE `cash_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `cash_id` int(10) UNSIGNED NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `total` double(8,2) NOT NULL DEFAULT 0.00,
  `qty_return` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_details`
--

INSERT INTO `cash_details` (`id`, `cash_id`, `store_product_id`, `unit_id`, `qty`, `price`, `total`, `qty_return`, `created_at`, `updated_at`) VALUES
(4, 2, 39, 2, 1, 600.00, 600.00, 0, '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(5, 2, 40, 2, 1, 1000.00, 1000.00, 0, '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(6, 2, 52, 1, 20, 400.00, 8000.00, 0, '2025-02-24 20:04:40', '2025-02-24 20:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `cash_returns`
--

CREATE TABLE `cash_returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `cash_id` int(10) UNSIGNED DEFAULT NULL,
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_return_details`
--

CREATE TABLE `cash_return_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `cash_return_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbole` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbole`, `rate`, `type`, `created_at`, `updated_at`) VALUES
(1, 'ريال يمني', 'YER', 1, NULL, NULL, NULL),
(2, 'دولار امريكي', 'USD', 600, NULL, NULL, NULL),
(3, 'ريال سعودي', 'SAR', 150, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT '776165784',
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT 'taiz',
  `status` varchar(255) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `group_id`, `name`, `phone`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES
(7, 1, 'مهيب الجنيد', '776165784', 'muhibalmuh@gmail.com', 'taiz', '1', '2025-02-17 17:54:43', '2025-02-18 11:38:14'),
(8, 1, 'الخليل الحنيد', '738017689', 'muhibalmuhib10@gmail.com', 'ibb', '1', '2025-02-17 17:54:43', '2025-02-18 12:43:54');

-- --------------------------------------------------------

--
-- Table structure for table `dailies`
--

CREATE TABLE `dailies` (
  `id` int(10) UNSIGNED NOT NULL,
  `total` int(11) NOT NULL,
  `daily_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dailies`
--

INSERT INTO `dailies` (`id`, `total`, `daily_date`, `created_at`, `updated_at`) VALUES
(3, 3000, '2025-02-22', '2025-02-22 17:07:49', '2025-02-22 17:07:49'),
(4, 3000, '2025-02-06', '2025-02-22 17:21:52', '2025-02-22 17:21:52'),
(5, 3000, '2025-02-03', '2025-02-22 17:22:06', '2025-02-22 17:22:06'),
(8, 32000, '2025-02-24', '2025-02-24 19:41:26', '2025-02-24 19:41:26'),
(10, 2000, '2025-02-24', '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(12, 8000, '2025-02-24', '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(50, 2000, '2025-02-25', '2025-02-24 22:29:21', '2025-02-24 22:29:21'),
(89, 2000, '2025-02-25', '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(91, 400, '2025-02-25', '2025-02-25 16:42:23', '2025-02-25 16:42:23'),
(92, 8000, '2025-02-25', '2025-02-25 16:43:37', '2025-02-25 16:43:37'),
(95, 800, '2025-02-25', '2025-02-25 16:53:36', '2025-02-25 16:53:36'),
(96, 1200, '2025-02-25', '2025-02-25 16:59:23', '2025-02-25 16:59:23'),
(98, 400, '2025-02-25', '2025-02-25 17:03:18', '2025-02-25 17:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `daily_details`
--

CREATE TABLE `daily_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `account_id` int(10) UNSIGNED DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `debit` int(11) DEFAULT 0,
  `credit` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_details`
--

INSERT INTO `daily_details` (`id`, `daily_id`, `account_id`, `description`, `debit`, `credit`, `created_at`, `updated_at`) VALUES
(3, 3, 125, '', 3000, 0, '2025-02-22 17:07:49', '2025-02-22 17:07:49'),
(4, 3, 1223, '', 0, 3000, '2025-02-22 17:07:49', '2025-02-22 17:07:49'),
(5, 4, 125, '', 3000, 0, '2025-02-22 17:21:52', '2025-02-22 17:21:52'),
(6, 4, 1223, '', 0, 3000, '2025-02-22 17:21:52', '2025-02-22 17:21:52'),
(7, 5, 125, '', 3000, 0, '2025-02-22 17:22:06', '2025-02-22 17:22:06'),
(8, 5, 1223, '', 0, 3000, '2025-02-22 17:22:06', '2025-02-22 17:22:06'),
(13, 8, 1241, '', 32000, 0, '2025-02-24 19:41:26', '2025-02-24 19:41:26'),
(14, 8, 1223, '', 0, 32000, '2025-02-24 19:41:26', '2025-02-24 19:41:26'),
(19, 10, 1223, '', 2000, 0, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(20, 10, 1241, '', 0, 600, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(21, 10, 1241, '', 0, 1000, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(22, 10, 1241, '', 0, 400, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(27, 12, 1223, '', 8000, 0, '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(30, 12, 1241, '', 0, 8000, '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(66, 50, 1223, '', 2000, 0, '2025-02-24 22:29:21', '2025-02-24 22:29:21'),
(67, 50, 1241, '', 0, 2000, '2025-02-24 22:29:21', '2025-02-24 22:29:21'),
(99, 89, 1243, '', 600, 0, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(100, 89, 1243, '', 1000, 0, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(101, 89, 1243, '', 400, 0, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(102, 89, 1223, '', 0, 2000, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(107, 91, 1223, '', 400, 0, '2025-02-25 16:42:23', '2025-02-25 16:42:23'),
(108, 91, 1241, '', 0, 400, '2025-02-25 16:42:23', '2025-02-25 16:42:23'),
(109, 92, 1223, '', 8000, 0, '2025-02-25 16:43:37', '2025-02-25 16:43:37'),
(110, 92, 1241, '', 0, 8000, '2025-02-25 16:43:37', '2025-02-25 16:43:37'),
(111, 95, 1243, '', 800, 0, '2025-02-25 16:53:36', '2025-02-25 16:53:36'),
(112, 95, 1223, '', 0, 800, '2025-02-25 16:53:36', '2025-02-25 16:53:36'),
(113, 96, 1223, '', 1200, 0, '2025-02-25 16:59:23', '2025-02-25 16:59:23'),
(114, 96, 1241, '', 0, 1200, '2025-02-25 16:59:23', '2025-02-25 16:59:23'),
(115, 98, 1243, '', 400, 0, '2025-02-25 17:03:18', '2025-02-25 17:03:18'),
(116, 98, 1223, '', 0, 400, '2025-02-25 17:03:18', '2025-02-25 17:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `delays`
--

CREATE TABLE `delays` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `delay_type_id` int(10) UNSIGNED NOT NULL,
  `part_id` int(10) UNSIGNED NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delay_sanctions`
--

CREATE TABLE `delay_sanctions` (
  `id` int(10) UNSIGNED NOT NULL,
  `delay_type_id` int(10) UNSIGNED NOT NULL,
  `part_id` int(10) UNSIGNED NOT NULL,
  `sanction_discount_id` int(10) UNSIGNED NOT NULL,
  `discount` int(11) NOT NULL,
  `iteration` int(11) NOT NULL,
  `sanction` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delay_sanctions`
--

INSERT INTO `delay_sanctions` (`id`, `delay_type_id`, `part_id`, `sanction_discount_id`, `discount`, `iteration`, `sanction`, `created_at`, `updated_at`) VALUES
(16, 1, 1, 1, 1, 1, 150, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(17, 1, 2, 1, 1, 1, 200, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(18, 1, 1, 1, 1, 2, 200, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(19, 1, 1, 1, 1, 3, 300, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(20, 1, 2, 1, 1, 2, 220, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(21, 1, 2, 1, 1, 3, 340, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(22, 2, 1, 1, 1, 1, 200, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(23, 2, 1, 1, 1, 2, 250, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(24, 2, 1, 1, 1, 3, 350, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(25, 2, 1, 1, 1, 4, 400, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(26, 2, 2, 1, 1, 1, 120, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(27, 2, 2, 1, 1, 2, 170, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(28, 2, 2, 1, 1, 3, 130, '2025-02-18 17:42:05', '2025-02-18 17:42:05'),
(29, 2, 2, 1, 1, 4, 140, '2025-02-18 17:42:05', '2025-02-18 17:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `delay_types`
--

CREATE TABLE `delay_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delay_types`
--

INSERT INTO `delay_types` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'يوم السبت', 'Sat', NULL, NULL),
(2, 'يوم الخميس', 'Thu', NULL, NULL),
(3, 'يوم اجتماع', 'meet', '2025-02-24 17:51:24', '2025-02-24 17:51:24');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `discount_type_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `staff_id`, `name`, `discount_type_id`, `date`, `quantity`, `note`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 2, '2025-02-22', 3000, NULL, '2025-02-22 16:12:36', '2025-02-22 16:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `discount_types`
--

CREATE TABLE `discount_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_types`
--

INSERT INTO `discount_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'سداد سلفه', NULL, NULL),
(2, 'مخالفه قوانين', NULL, NULL),
(3, 'جزاء', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expences`
--

CREATE TABLE `expences` (
  `id` int(10) UNSIGNED NOT NULL,
  `daily_id` int(10) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extras`
--

CREATE TABLE `extras` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `extra_type_id` int(10) UNSIGNED NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `number_hours` double(8,2) DEFAULT NULL,
  `date` date NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extras`
--

INSERT INTO `extras` (`id`, `staff_id`, `extra_type_id`, `start_time`, `end_time`, `number_hours`, `date`, `note`, `created_at`, `updated_at`) VALUES
(2, 4, 1, '08:00:00', '13:00:00', 300.00, '2025-02-19', NULL, '2025-02-19 16:30:51', '2025-02-19 16:30:51'),
(3, 5, 1, '07:00:00', '08:00:00', 60.00, '2025-02-01', NULL, '2025-02-19 16:32:31', '2025-02-19 16:32:31'),
(4, 5, 2, '18:00:00', '19:00:00', 60.00, '2025-02-01', NULL, '2025-02-19 16:32:31', '2025-02-19 16:32:31'),
(5, 4, 1, '06:30:00', '07:00:00', 30.00, '2025-02-01', NULL, '2025-02-19 16:34:50', '2025-02-19 16:34:50'),
(6, 4, 2, '19:00:00', '19:30:00', 30.00, '2025-02-01', NULL, '2025-02-19 16:34:50', '2025-02-19 16:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `extra_sanctions`
--

CREATE TABLE `extra_sanctions` (
  `id` int(10) UNSIGNED NOT NULL,
  `extra_type_id` int(10) UNSIGNED NOT NULL,
  `part_id` int(10) UNSIGNED NOT NULL,
  `sanction_discount_id` int(10) UNSIGNED NOT NULL,
  `iteration` int(11) NOT NULL,
  `sanction` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extra_sanctions`
--

INSERT INTO `extra_sanctions` (`id`, `extra_type_id`, `part_id`, `sanction_discount_id`, `iteration`, `sanction`, `created_at`, `updated_at`) VALUES
(17, 1, 1, 1, 1, 1000, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(18, 1, 1, 1, 2, 1200, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(19, 1, 1, 1, 3, 1300, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(20, 1, 1, 1, 4, 1400, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(21, 1, 2, 1, 1, 1500, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(22, 1, 2, 1, 2, 2000, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(23, 1, 2, 1, 3, 2400, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(24, 1, 2, 1, 4, 3000, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(25, 2, 1, 1, 1, 1000, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(26, 2, 1, 1, 2, 1300, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(27, 2, 1, 1, 3, 1500, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(28, 2, 1, 1, 4, 1700, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(29, 3, 2, 1, 1, 1900, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(30, 3, 2, 1, 2, 2500, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(31, 3, 2, 1, 3, 3000, '2025-02-18 17:42:22', '2025-02-18 17:42:22'),
(32, 3, 2, 1, 4, 3500, '2025-02-18 17:42:22', '2025-02-18 17:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `extra_types`
--

CREATE TABLE `extra_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extra_types`
--

INSERT INTO `extra_types` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'قبل الدوام', 'Before_work', NULL, NULL),
(2, 'بعد الدوام', 'After_work', NULL, NULL),
(3, 'يوم عطله رسميه', 'Vacation', NULL, NULL),
(4, 'يوم عطله اسبوعيه', 'Holiday', NULL, NULL),
(5, 'اخري', 'another', '2025-02-24 17:52:29', '2025-02-24 17:52:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_type_id` int(10) UNSIGNED DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `group_type_id`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'عملاء صنعاء', 1, 'customer_1', '0', '2025-02-17 18:23:19', '2025-02-17 18:23:19'),
(2, 'صناديق دولار', 3, 'treasury_2', '0', '2025-02-18 12:47:51', '2025-02-18 12:47:51'),
(3, 'بنك دولار', 4, 'bank_1', '0', '2025-02-18 13:15:01', '2025-02-18 13:15:01'),
(4, 'موردين صنعاء', 2, 'supplier_1', '0', '2025-02-18 15:41:11', '2025-02-18 15:41:11'),
(5, 'سلف الموظف', 6, 'advance_1', '0', '2025-02-22 16:06:52', '2025-02-22 16:06:52'),
(6, 'بدلات سفر', 7, 'allowance_1', '1', '2025-02-22 16:35:11', '2025-02-22 16:35:11'),
(7, 'اضافي الموظف', 5, 'extra_1', '1', '2025-02-22 17:50:38', '2025-02-22 17:50:38'),
(8, 'راتب الموظف', 8, 'salary_1', '1', '2025-02-22 18:40:10', '2025-02-22 18:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `group_accounts`
--

CREATE TABLE `group_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_accounts`
--

INSERT INTO `group_accounts` (`id`, `account_id`, `group_id`, `created_at`, `updated_at`) VALUES
(1, 1233, 1, '2025-02-18 16:00:38', '2025-02-18 16:00:38'),
(2, 2213, 4, '2025-02-18 16:01:49', '2025-02-18 16:01:49'),
(3, 1223, 2, '2025-02-18 16:02:40', '2025-02-18 16:02:40'),
(4, 1212, 3, '2025-02-18 16:03:21', '2025-02-18 16:03:21'),
(5, 2331, 6, '2025-02-22 16:46:01', '2025-02-22 16:46:01'),
(6, 125, 5, '2025-02-22 16:51:45', '2025-02-22 16:51:45'),
(7, 232, 7, '2025-02-22 17:51:28', '2025-02-22 17:51:28'),
(8, 231, 8, '2025-02-22 18:40:55', '2025-02-22 18:40:55');

-- --------------------------------------------------------

--
-- Table structure for table `group_account_daily_details`
--

CREATE TABLE `group_account_daily_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `dailyable_type` varchar(255) NOT NULL,
  `dailyable_id` bigint(20) UNSIGNED NOT NULL,
  `daily_detail_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_account_daily_details`
--

INSERT INTO `group_account_daily_details` (`id`, `dailyable_type`, `dailyable_id`, `daily_detail_id`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\Advance', 3, 3, '2025-02-22 17:07:49', '2025-02-22 17:07:49'),
(3, 'App\\Models\\Treasury', 1, 4, '2025-02-22 17:07:49', '2025-02-22 17:07:49'),
(4, 'App\\Models\\Advance', 4, 5, '2025-02-22 17:21:52', '2025-02-22 17:21:52'),
(5, 'App\\Models\\Treasury', 1, 6, '2025-02-22 17:21:52', '2025-02-22 17:21:52'),
(6, 'App\\Models\\Advance', 5, 7, '2025-02-22 17:22:06', '2025-02-22 17:22:06'),
(7, 'App\\Models\\Treasury', 1, 8, '2025-02-22 17:22:06', '2025-02-22 17:22:06'),
(12, 'App\\Models\\Store', 111, 13, '2025-02-24 19:41:26', '2025-02-24 19:41:26'),
(13, 'App\\Models\\Treasury', 1, 14, '2025-02-24 19:41:26', '2025-02-24 19:41:26'),
(18, 'App\\Models\\Treasury', 1, 19, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(19, 'App\\Models\\Store', 111, 20, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(20, 'App\\Models\\Store', 111, 21, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(21, 'App\\Models\\Store', 111, 22, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(26, 'App\\Models\\Treasury', 1, 27, '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(29, 'App\\Models\\Store', 111, 30, '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(32, 'App\\Models\\Treasury', 1, 66, '2025-02-24 22:29:21', '2025-02-24 22:29:21'),
(33, 'App\\Models\\Treasury', 1, 67, '2025-02-24 22:29:21', '2025-02-24 22:29:21'),
(42, 'App\\Models\\Store', 131, 99, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(43, 'App\\Models\\Store', 131, 100, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(44, 'App\\Models\\Store', 131, 101, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(45, 'App\\Models\\Treasury', 1, 102, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(50, 'App\\Models\\Treasury', 1, 107, '2025-02-25 16:42:23', '2025-02-25 16:42:23'),
(51, 'App\\Models\\Store', 111, 108, '2025-02-25 16:42:23', '2025-02-25 16:42:23'),
(52, 'App\\Models\\Treasury', 1, 109, '2025-02-25 16:43:37', '2025-02-25 16:43:37'),
(53, 'App\\Models\\Store', 111, 110, '2025-02-25 16:43:37', '2025-02-25 16:43:37'),
(54, 'App\\Models\\Store', 131, 111, '2025-02-25 16:53:36', '2025-02-25 16:53:36'),
(55, 'App\\Models\\Treasury', 1, 112, '2025-02-25 16:53:36', '2025-02-25 16:53:36'),
(56, 'App\\Models\\Treasury', 1, 113, '2025-02-25 16:59:23', '2025-02-25 16:59:23'),
(57, 'App\\Models\\Store', 111, 114, '2025-02-25 16:59:23', '2025-02-25 16:59:23'),
(58, 'App\\Models\\Store', 131, 115, '2025-02-25 17:03:18', '2025-02-25 17:03:18'),
(59, 'App\\Models\\Treasury', 1, 116, '2025-02-25 17:03:18', '2025-02-25 17:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `group_account_details`
--

CREATE TABLE `group_account_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_account_id` int(10) UNSIGNED DEFAULT NULL,
  `account_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_account_details`
--

INSERT INTO `group_account_details` (`id`, `group_account_id`, `account_id`, `created_at`, `updated_at`) VALUES
(7, 5, 412, '2025-02-22 19:10:47', '2025-02-22 19:10:47'),
(8, 7, 413, '2025-02-22 19:10:47', '2025-02-22 19:10:47'),
(9, 8, 411, '2025-02-22 19:10:47', '2025-02-22 19:10:47');

-- --------------------------------------------------------

--
-- Table structure for table `group_types`
--

CREATE TABLE `group_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_types`
--

INSERT INTO `group_types` (`id`, `name`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'العملاء', 'customer', '1', '2025-02-17 18:12:55', '2025-02-17 18:12:55'),
(2, 'الموردين', 'supplier', '1', '2025-02-17 18:13:52', '2025-02-17 18:13:52'),
(3, 'الصناديق', 'treasury', '1', '2025-02-17 18:13:52', '2025-02-17 18:13:52'),
(4, 'البنوك', 'bank', '1', '2025-02-17 18:13:52', '2025-02-17 18:13:52'),
(5, 'الاضافي', 'extra', '1', '2025-02-17 18:16:35', '2025-02-17 18:16:35'),
(6, 'السلف', 'advance', '1', '2025-02-22 16:05:58', '2025-02-22 16:05:58'),
(7, 'البدلات', 'allowance', '1', '2025-02-22 16:34:39', '2025-02-22 16:34:39'),
(8, 'الراتب', 'salary', '1', '2025-02-22 18:39:22', '2025-02-22 18:39:22');

-- --------------------------------------------------------

--
-- Table structure for table `iterations`
--

CREATE TABLE `iterations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `part_id` int(10) UNSIGNED NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_sanctions`
--

CREATE TABLE `leave_sanctions` (
  `id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `part_id` int(10) UNSIGNED NOT NULL,
  `sanction_discount_id` int(10) UNSIGNED NOT NULL,
  `discount` int(11) NOT NULL,
  `iteration` int(11) NOT NULL,
  `sanction` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_sanctions`
--

INSERT INTO `leave_sanctions` (`id`, `leave_type_id`, `part_id`, `sanction_discount_id`, `discount`, `iteration`, `sanction`, `created_at`, `updated_at`) VALUES
(7, 1, 1, 1, 1, 1, 120, '2025-02-18 17:47:09', '2025-02-18 17:47:09'),
(8, 1, 1, 1, 1, 2, 150, '2025-02-18 17:47:09', '2025-02-18 17:47:09'),
(9, 1, 1, 1, 1, 3, 200, '2025-02-18 17:47:09', '2025-02-18 17:47:09'),
(10, 1, 2, 1, 1, 1, 350, '2025-02-18 17:47:09', '2025-02-18 17:47:09'),
(11, 1, 2, 1, 1, 2, 320, '2025-02-18 17:47:09', '2025-02-18 17:47:09'),
(12, 1, 2, 1, 1, 3, 380, '2025-02-18 17:47:09', '2025-02-18 17:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'يوم السبت', 'Sat', NULL, NULL),
(2, 'يوم الخميس', 'Thu', NULL, NULL),
(3, 'يوم اجتماع', 'meet', '2025-02-24 17:50:26', '2025-02-24 17:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `number_premium` int(11) NOT NULL,
  `premium` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_143051_create_account_years_table', 1),
(2, '2014_10_11_143051_create_accounts_table', 1),
(3, '2014_10_11_143051_create_group_types_table', 1),
(4, '2014_10_11_143051_create_groups_table', 1),
(5, '2014_10_11_223454_create_roles_table', 1),
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_resets_table', 1),
(8, '2014_10_12_211153_create_customers_table', 1),
(9, '2019_08_11_140937_create_statuses_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2020_01_10_062359_create_stores_table', 1),
(12, '2020_01_10_062359_create_units_table', 1),
(13, '2020_01_13_152127_create_companies_table', 1),
(14, '2020_01_13_152127_create_iterations_table', 1),
(15, '2020_01_13_152127_create_suppliers_table', 1),
(16, '2021_07_09_225000_create_administrative_structures_table', 1),
(17, '2021_07_09_225000_create_products_table', 1),
(18, '2021_07_10_225000_create_product_units_table', 1),
(19, '2021_11_18_170226_create_store_products_table', 1),
(20, '2021_11_18_220511_create_dailies_table', 1),
(21, '2021_11_19_081420__create_stocks_table', 1),
(22, '2021_11_19_151816_create_expences_table', 1),
(23, '2021_12_14_155058_create_purchases_table', 1),
(24, '2021_12_14_155111_create_supplies_table', 1),
(25, '2021_12_14_155120_create_purchase_details_table', 1),
(26, '2021_12_14_155120_create_supply_details_table', 1),
(27, '2021_12_14_155141_create_sales_table', 1),
(28, '2021_12_14_155158_create_sale_details_table', 1),
(29, '2021_12_14_155159_create_cashes_table', 1),
(30, '2021_12_15_155158_create_cash_details_table', 1),
(31, '2021_12_15_155230_create_cash_returns_table', 1),
(32, '2021_12_15_155230_create_purchase_returns_table', 1),
(33, '2021_12_15_155230_create_supply_returns_table', 1),
(34, '2021_12_15_155250_create_sale_returns_table', 1),
(35, '2022_01_22_143051_create_group_accounts_table', 1),
(36, '2022_01_22_185930_create_daily_details_table', 1),
(37, '2022_01_22_220442_create_currencies_table', 1),
(38, '2022_01_23_143051_create_group_account_daily_details_table', 1),
(39, '2022_01_23_143051_create_group_account_details_table', 1),
(40, '2022_01_27_142749_create_qualifications_table', 1),
(41, '2022_01_27_204849_create_branches_table', 1),
(42, '2022_01_27_205058_create_staff_types_table', 1),
(43, '2022_01_27_205115_create_staff_religions_table', 1),
(44, '2022_01_27_205319_create_nationalities_table', 1),
(45, '2022_01_27_205643_create_official_holidays_table', 1),
(46, '2022_01_27_205643_create_vacation_types_table', 1),
(47, '2022_01_28_160512_create_transfers_table', 1),
(48, '2022_01_28_160616_create_transfer_details_table', 1),
(49, '2022_01_28_210059_create_staff_table', 1),
(50, '2022_02_25_151203_create_discount_types_table', 1),
(51, '2022_02_26_205544_create_discounts_table', 1),
(52, '2022_02_26_205603_create_vacations_table', 1),
(53, '2022_02_29_215343_create_period_times_table', 1),
(54, '2022_03_01_140559_create_absence_types_table', 1),
(55, '2022_03_01_141038_create_loans_table', 1),
(56, '2022_03_01_141431_create_allowance_types_table', 1),
(57, '2022_03_01_205405_create_advances_table', 1),
(58, '2022_03_01_205405_create_payrolls_table', 1),
(59, '2022_03_01_205517_create_allowances_table', 1),
(60, '2022_03_01_205517_create_attendances_table', 1),
(61, '2022_03_02_205517_create_attendance_details_table', 1),
(62, '2022_05_12_195536_create_personalities_table', 1),
(63, '2022_06_07_215343_create_opening_inventories_table', 1),
(64, '2022_10_22_143051_create_ staff_group_daily_details_table', 1),
(65, '2023_01_08_152127_create_leave_types_table', 1),
(66, '2023_06_28_210055_create_work_system_types_table', 1),
(67, '2023_06_28_210055_create_work_systems_table', 1),
(68, '2023_06_29_210055_create_staff_work_systems_table', 1),
(69, '2023_09_25_152127_create_sanction_discounts_table', 1),
(70, '2023_09_26_205712_create_extra_types_table', 1),
(71, '2023_09_26_205819_create_delay_types_table', 1),
(72, '2023_09_26_205819_create_parts_table', 1),
(73, '2023_09_27_152127_create_absence_sanctions_table', 1),
(74, '2023_09_27_152127_create_delay_sanctions_table', 1),
(75, '2023_09_27_152127_create_extra_sanctions_table', 1),
(76, '2023_09_27_152127_create_leave_sanctions_table', 1),
(77, '2023_12_08_154853_create_payable_notes_table', 1),
(78, '2023_12_08_154853_create_receivable_notes_table', 1),
(79, '2023_12_15_154853_create_payments_table', 1),
(80, '2023_12_15_155309_create_purchase_return_details_table', 1),
(81, '2023_12_15_155309_create_supply_return_details_table', 1),
(82, '2023_12_15_155334_create_cash_return_details_table', 1),
(83, '2023_12_15_155334_create_sale_return_details_table', 1),
(84, '2024_02_26_205749_create_extras_table', 1),
(85, '2024_02_26_205916_create_banks_table', 1),
(86, '2024_02_26_205916_create_delays_table', 1),
(87, '2024_02_26_205916_create_leaves_table', 1),
(88, '2024_02_26_205916_create_treasuries_table', 1),
(89, '2024_03_01_140719_create_absences_table', 1),
(90, '2024_03_01_140719_create_staff_sanctions_table', 1),
(91, '2024_03_01_140720_create_absence_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'اليمن', NULL, NULL),
(2, 'السعوديه', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `official_holidays`
--

CREATE TABLE `official_holidays` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `from_date` date DEFAULT NULL,
  `into_date` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `official_holidays`
--

INSERT INTO `official_holidays` (`id`, `name`, `from_date`, `into_date`, `duration`, `created_at`, `updated_at`) VALUES
(1, '26 سبتمبر', '2025-09-26', '2025-09-27', 1, '2025-02-24 10:47:36', '2025-02-24 10:47:36'),
(2, '14 اكتوبر', '2025-10-14', '2025-10-15', 1, '2025-02-24 10:51:36', '2025-02-24 10:51:36'),
(3, '30 نوفمبر', '2025-11-30', '2025-12-01', 1, '2025-02-24 10:51:36', '2025-02-24 10:51:36'),
(4, '22 مايو', '2025-05-22', '2025-05-23', 1, '2025-02-24 10:51:36', '2025-02-24 10:51:36'),
(5, '21 سبتمبر', '2025-09-21', '2025-09-22', 1, '2025-02-24 20:00:36', '2025-02-24 20:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `opening_inventuries`
--

CREATE TABLE `opening_inventuries` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opening_inventuries`
--

INSERT INTO `opening_inventuries` (`id`, `store_product_id`, `unit_id`, `qty`, `total`, `date`, `created_at`, `updated_at`) VALUES
(31, 39, 1, 2, 0, NULL, '2025-02-17 18:11:17', '2025-02-17 18:11:17'),
(32, 40, 1, 2, 0, NULL, '2025-02-17 18:11:17', '2025-02-17 18:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `name`, `duration`, `created_at`, `updated_at`) VALUES
(1, ' ربع ساعه', 15, NULL, NULL),
(2, 'نص ساعه', 30, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payable_notes`
--

CREATE TABLE `payable_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(10) UNSIGNED NOT NULL,
  `daily_id` int(10) UNSIGNED NOT NULL,
  `paid` varchar(255) NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `paymentable_type` varchar(255) NOT NULL,
  `paymentable_id` bigint(20) UNSIGNED NOT NULL,
  `payment_info` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `paid` varchar(255) NOT NULL DEFAULT '0',
  `remaining` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `paymentable_type`, `paymentable_id`, `payment_info`, `payment_status`, `paid`, `remaining`, `created_at`, `updated_at`) VALUES
(15, 'App\\Models\\Purchase', 12, '1', 'paiding', '32000', '0', '2025-02-24 19:41:26', '2025-02-24 19:41:26'),
(18, 'App\\Models\\Sale', 6, '1', 'paiding', '2000', '0', '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(20, 'App\\Models\\Cash', 2, '1', 'paiding', '8000', '0', '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(59, 'App\\Models\\PurchaseReturn', 45, '1', 'paiding', '2000', '0', '2025-02-24 22:29:21', '2025-02-24 22:29:21'),
(99, 'App\\Models\\SaleReturn', 40, '1', 'paiding', '2000', '0', '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(101, 'App\\Models\\Sale', 7, '1', 'paiding', '400', '0', '2025-02-25 16:42:23', '2025-02-25 16:42:23'),
(102, 'App\\Models\\Sale', 8, '1', 'paiding', '8000', '0', '2025-02-25 16:43:37', '2025-02-25 16:43:37'),
(105, 'App\\Models\\SaleReturn', 53, '1', 'paiding', '800', '0', '2025-02-25 16:53:36', '2025-02-25 16:53:36'),
(106, 'App\\Models\\Sale', 9, '1', 'paiding', '1200', '0', '2025-02-25 16:59:23', '2025-02-25 16:59:23'),
(108, 'App\\Models\\SaleReturn', 55, '1', 'paiding', '400', '0', '2025-02-25 17:03:18', '2025-02-25 17:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `net_salary` double(8,2) NOT NULL,
  `total_allowance` double(8,2) NOT NULL DEFAULT 0.00,
  `total_discount` double(8,2) NOT NULL DEFAULT 0.00,
  `total_extra` double(8,2) NOT NULL DEFAULT 0.00,
  `total_advance` double(8,2) NOT NULL DEFAULT 0.00,
  `total_sanction` double(8,2) NOT NULL DEFAULT 0.00,
  `total_delay_sanction` double(8,2) NOT NULL DEFAULT 0.00,
  `total_leave_sanction` double(8,2) NOT NULL DEFAULT 0.00,
  `total_absence_sanction` double(8,2) NOT NULL DEFAULT 0.00,
  `total_extra_sanction` double(8,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `staff_id`, `net_salary`, `total_allowance`, `total_discount`, `total_extra`, `total_advance`, `total_sanction`, `total_delay_sanction`, `total_leave_sanction`, `total_absence_sanction`, `total_extra_sanction`, `status`, `note`, `created_at`, `updated_at`) VALUES
(1, 4, 300000.00, 40000.00, 3000.00, 0.00, 3000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2025-02-18 18:47:59', '2025-02-22 17:07:49'),
(2, 5, 350000.00, 0.00, 0.00, 0.00, 3000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2025-02-19 11:11:09', '2025-02-22 17:21:52'),
(3, 6, 250000.00, 0.00, 0.00, 0.00, 3000.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2025-02-19 11:14:45', '2025-02-22 17:22:06'),
(4, 7, 400000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2025-02-19 11:17:40', '2025-02-19 11:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `period_times`
--

CREATE TABLE `period_times` (
  `id` int(10) UNSIGNED NOT NULL,
  `work_system_type_id` int(255) UNSIGNED NOT NULL,
  `from_time` time NOT NULL DEFAULT '00:00:00',
  `into_time` time NOT NULL DEFAULT '00:00:00',
  `duration` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `period_times`
--

INSERT INTO `period_times` (`id`, `work_system_type_id`, `from_time`, `into_time`, `duration`, `created_at`, `updated_at`) VALUES
(5, 1, '08:00:00', '13:00:00', 5, '2025-02-19 12:09:35', '2025-02-19 12:09:35'),
(6, 1, '14:00:00', '17:00:00', 3, '2025-02-19 12:09:35', '2025-02-19 12:09:35'),
(7, 3, '08:00:00', '13:00:00', 5, '2025-02-24 12:05:55', '2025-02-24 12:05:55'),
(8, 3, '14:00:00', '18:00:00', 4, '2025-02-24 12:05:55', '2025-02-24 12:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `personalities`
--

CREATE TABLE `personalities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `text` varchar(255) NOT NULL,
  `rank` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'true',
  `product_minimum` int(11) DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `parent_id`, `text`, `rank`, `status`, `product_minimum`, `image`, `created_at`, `updated_at`) VALUES
(1, NULL, 'منتجات محليه', NULL, 'true', NULL, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(2, NULL, 'منتجات خارجيه', NULL, 'true', NULL, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(11, 1, 'عصاير', 1, 'true', NULL, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(21, 2, 'مواد غذائيه', 1, 'true', NULL, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(111, 11, 'عصير الهناء', 2, 'true', 6, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(112, 11, 'عصير يماني', 2, 'true', 2, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(113, 11, 'عصير الهداف', 2, 'true', 3, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(211, 21, 'دقيق السنابل كيس50 كيلو', 2, 'true', NULL, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_units`
--

CREATE TABLE `product_units` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `unit_id` int(10) UNSIGNED DEFAULT NULL,
  `purchase_price` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_units`
--

INSERT INTO `product_units` (`id`, `product_id`, `unit_id`, `purchase_price`, `rate`, `created_at`, `updated_at`) VALUES
(58, 111, 2, 400, 1, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(59, 112, 2, NULL, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(60, 111, 1, 9000, 20, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(61, 211, 13, NULL, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(62, 211, 14, NULL, NULL, '2025-01-19 11:34:54', '2025-01-19 11:34:54'),
(63, 211, 4, NULL, NULL, '2025-01-19 11:34:55', '2025-01-19 11:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `sub_total` varchar(255) DEFAULT NULL,
  `discount` decimal(8,2) DEFAULT NULL,
  `tax_amount` decimal(8,2) DEFAULT NULL,
  `grand_total` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `supplier_id`, `daily_id`, `date`, `due_date`, `note`, `sub_total`, `discount`, `tax_amount`, `grand_total`, `status`, `created_at`, `updated_at`) VALUES
(12, 17, 8, '2025-02-24', NULL, NULL, '32000', NULL, 0.00, 32000, NULL, '2025-02-24 19:41:26', '2025-02-24 19:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(10) UNSIGNED NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED DEFAULT NULL,
  `qty` varchar(255) NOT NULL DEFAULT '0',
  `price` varchar(255) NOT NULL DEFAULT '0',
  `qty_return` int(11) NOT NULL DEFAULT 0,
  `total` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `store_product_id`, `unit_id`, `qty`, `price`, `qty_return`, `total`, `created_at`, `updated_at`) VALUES
(12, 12, 52, 1, '80', '400', 5, '32000', '2025-02-24 19:41:26', '2025-02-24 19:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(10) UNSIGNED DEFAULT NULL,
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `purchase_id`, `daily_id`, `quantity`, `date`, `note`, `created_at`, `updated_at`) VALUES
(45, 12, 50, NULL, '2025-02-25', NULL, '2025-02-24 22:29:21', '2025-02-24 22:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_return_id` int(10) UNSIGNED NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_return_details`
--

INSERT INTO `purchase_return_details` (`id`, `purchase_return_id`, `store_product_id`, `unit_id`, `qty`, `created_at`, `updated_at`) VALUES
(45, 45, 52, 2, 5, '2025-02-24 22:29:21', '2025-02-24 22:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'بكلوريوس', NULL, NULL),
(2, 'ماجستر', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `receivable_notes`
--

CREATE TABLE `receivable_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_id` int(10) UNSIGNED NOT NULL,
  `daily_id` int(10) UNSIGNED NOT NULL,
  `paid` varchar(255) NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'admin',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, NULL, NULL),
(3, 'Customer', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `customer_name` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `discount` decimal(8,2) DEFAULT NULL,
  `tax_amount` decimal(8,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `sub_total` varchar(255) DEFAULT NULL,
  `grand_total` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `daily_id`, `customer_name`, `date`, `discount`, `tax_amount`, `status`, `sub_total`, `grand_total`, `created_at`, `updated_at`) VALUES
(6, 7, 10, NULL, NULL, NULL, NULL, 'pending', NULL, 2000, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(7, 7, 91, NULL, NULL, NULL, NULL, 'pending', NULL, 400, '2025-02-25 16:42:23', '2025-02-25 16:42:23'),
(8, 7, 92, NULL, NULL, NULL, NULL, 'pending', NULL, 8000, '2025-02-25 16:43:37', '2025-02-25 16:43:37'),
(9, 7, 96, NULL, NULL, NULL, NULL, 'pending', NULL, 1200, '2025-02-25 16:59:23', '2025-02-25 16:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_id` int(10) UNSIGNED NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `total` double(8,2) NOT NULL DEFAULT 0.00,
  `qty_return` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `store_product_id`, `unit_id`, `qty`, `price`, `total`, `qty_return`, `created_at`, `updated_at`) VALUES
(13, 6, 39, 2, 1, 600.00, 600.00, 1, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(14, 6, 40, 2, 1, 1000.00, 1000.00, 1, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(15, 6, 52, 2, 1, 400.00, 400.00, 1, '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(16, 7, 52, 2, 1, 400.00, 400.00, 0, '2025-02-25 16:42:23', '2025-02-25 16:42:23'),
(17, 8, 52, 1, 20, 400.00, 8000.00, 2, '2025-02-25 16:43:37', '2025-02-25 16:43:37'),
(18, 9, 52, 2, 3, 400.00, 1200.00, 1, '2025-02-25 16:59:23', '2025-02-25 16:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_id` int(10) UNSIGNED DEFAULT NULL,
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_returns`
--

INSERT INTO `sale_returns` (`id`, `sale_id`, `daily_id`, `quantity`, `date`, `note`, `created_at`, `updated_at`) VALUES
(40, 6, 89, 3, '2025-02-25', NULL, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(53, 8, 95, 2, '2025-02-25', NULL, '2025-02-25 16:53:36', '2025-02-25 16:53:36'),
(55, 9, 98, 1, '2025-02-25', NULL, '2025-02-25 17:03:18', '2025-02-25 17:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_details`
--

CREATE TABLE `sale_return_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `sale_return_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_return_details`
--

INSERT INTO `sale_return_details` (`id`, `qty`, `store_product_id`, `unit_id`, `sale_return_id`, `created_at`, `updated_at`) VALUES
(118, 1, 39, 2, 40, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(119, 1, 40, 2, 40, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(120, 1, 52, 2, 40, '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(126, 2, 52, 2, 53, '2025-02-25 16:53:36', '2025-02-25 16:53:36'),
(128, 1, 52, 2, 55, '2025-02-25 17:03:18', '2025-02-25 17:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `sanction_discounts`
--

CREATE TABLE `sanction_discounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sanction_discounts`
--

INSERT INTO `sanction_discounts` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'من الراتب', NULL, NULL),
(2, 'من الاضافي', NULL, NULL),
(3, 'من الاجازه المرضيه', NULL, NULL),
(4, 'من البدلات', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `register` varchar(255) DEFAULT NULL,
  `phone` int(11) NOT NULL DEFAULT 776165784,
  `email` varchar(255) NOT NULL DEFAULT 'muhib@gmail.com',
  `salary` int(11) NOT NULL DEFAULT 0,
  `personal_card` int(11) NOT NULL,
  `date` date NOT NULL,
  `staff_status` int(11) NOT NULL,
  `gender` int(11) NOT NULL,
  `social_status` int(11) NOT NULL,
  `barth_date` date NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `job_id` int(10) UNSIGNED NOT NULL,
  `qualification_id` int(10) UNSIGNED NOT NULL,
  `staff_type_id` int(10) UNSIGNED NOT NULL,
  `religion_id` int(10) UNSIGNED NOT NULL,
  `nationality_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `register`, `phone`, `email`, `salary`, `personal_card`, `date`, `staff_status`, `gender`, `social_status`, `barth_date`, `branch_id`, `department_id`, `job_id`, `qualification_id`, `staff_type_id`, `religion_id`, `nationality_id`, `created_at`, `updated_at`) VALUES
(4, 'مهيب احمد عبدالحليل', NULL, 1231313, 'muhib@gmail.com', 300000, 234242424, '2025-02-18', 1, 1, 1, '2025-02-18', 2, 5, 21, 1, 1, 1, 1, '2025-02-18 18:47:59', '2025-02-18 18:47:59'),
(5, 'محمد احمد عبدالجليل', NULL, 1231313, 'muhib@gmail.com', 350000, 234242424, '2025-02-19', 1, 1, 1, '2025-02-19', 1, 5, 22, 1, 1, 1, 1, '2025-02-19 11:11:09', '2025-02-19 11:11:09'),
(6, 'نجيب احمد عبدالواحد', NULL, 1231313, 'muhib@gmail.com', 250000, 234242424, '2025-02-19', 1, 1, 1, '2025-02-19', 2, 4, 1, 1, 1, 1, 1, '2025-02-19 11:14:45', '2025-02-19 11:14:45'),
(7, 'محمد عبدالكريم قاسم', NULL, 1231313, 'muhib@gmail.com', 400000, 234242424, '2025-02-19', 1, 1, 1, '2025-02-19', 2, 4, 1, 1, 1, 1, 1, '2025-02-19 11:17:40', '2025-02-19 11:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `staff_group_daily_details`
--

CREATE TABLE `staff_group_daily_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `staff_id` int(10) UNSIGNED DEFAULT NULL,
  `daily_detail_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_religions`
--

CREATE TABLE `staff_religions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_religions`
--

INSERT INTO `staff_religions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'مسلم', NULL, NULL),
(2, 'مسيحي', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_sanctions`
--

CREATE TABLE `staff_sanctions` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `sanctionable_type` varchar(255) NOT NULL,
  `sanctionable_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_types`
--

CREATE TABLE `staff_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_types`
--

INSERT INTO `staff_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'رسمي', NULL, NULL),
(2, 'متعاقد', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_work_systems`
--

CREATE TABLE `staff_work_systems` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED DEFAULT NULL,
  `work_system_type_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'تالف', NULL, NULL),
(2, 'جديد', NULL, NULL),
(3, 'مستخدم', NULL, NULL),
(4, 'سليم', NULL, NULL),
(5, 'عطلان', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_product_id` int(10) UNSIGNED DEFAULT NULL,
  `unit_id` int(10) UNSIGNED DEFAULT NULL,
  `stockable_type` varchar(255) DEFAULT NULL,
  `stockable_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `store_product_id`, `unit_id`, `stockable_type`, `stockable_id`, `quantity`, `date`, `created_at`, `updated_at`) VALUES
(19, 39, 1, 'App\\Models\\OpeningInventury', 31, 2, NULL, '2025-02-17 18:11:17', '2025-02-17 18:11:17'),
(20, 40, 1, 'App\\Models\\OpeningInventury', 32, 2, NULL, '2025-02-17 18:11:17', '2025-02-17 18:11:17'),
(38, 52, 1, 'App\\Models\\Purchase', 12, 80, '2025-02-24', '2025-02-24 19:41:26', '2025-02-24 19:41:26'),
(45, 39, 2, 'App\\Models\\Sale', 6, 1, '2025-02-24', '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(46, 40, 2, 'App\\Models\\Sale', 6, 1, '2025-02-24', '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(47, 52, 2, 'App\\Models\\Sale', 6, 1, '2025-02-24', '2025-02-24 19:53:40', '2025-02-24 19:53:40'),
(51, 39, 2, 'App\\Models\\Cash', 2, 1, '2025-02-24', '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(52, 40, 2, 'App\\Models\\Cash', 2, 1, '2025-02-24', '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(53, 52, 1, 'App\\Models\\Cash', 2, 20, '2025-02-24', '2025-02-24 20:04:40', '2025-02-24 20:04:40'),
(98, 52, 2, 'App\\Models\\PurchaseReturn', 45, 5, '2025-02-25', '2025-02-24 22:29:21', '2025-02-24 22:29:21'),
(216, 39, 2, 'App\\Models\\SaleReturn', 40, 1, '2025-02-25', '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(217, 40, 2, 'App\\Models\\SaleReturn', 40, 1, '2025-02-25', '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(218, 52, 2, 'App\\Models\\SaleReturn', 40, 1, '2025-02-25', '2025-02-25 12:25:02', '2025-02-25 12:25:02'),
(222, 52, 2, 'App\\Models\\Sale', 7, 1, '2025-02-25', '2025-02-25 16:42:23', '2025-02-25 16:42:23'),
(223, 52, 1, 'App\\Models\\Sale', 8, 20, '2025-02-25', '2025-02-25 16:43:37', '2025-02-25 16:43:37'),
(226, 52, 2, 'App\\Models\\SaleReturn', 53, 2, '2025-02-25', '2025-02-25 16:53:36', '2025-02-25 16:53:36'),
(227, 52, 2, 'App\\Models\\Sale', 9, 3, '2025-02-25', '2025-02-25 16:59:23', '2025-02-25 16:59:23'),
(229, 52, 2, 'App\\Models\\SaleReturn', 55, 1, '2025-02-25', '2025-02-25 17:03:18', '2025-02-25 17:03:18'),
(233, 56, 2, 'App\\Models\\Transfer', 2, 1, '2025-02-25', '2025-02-25 17:08:11', '2025-02-25 17:08:11'),
(234, 57, 2, 'App\\Models\\Transfer', 2, 1, '2025-02-25', '2025-02-25 17:08:11', '2025-02-25 17:08:11'),
(235, 58, 2, 'App\\Models\\Transfer', 2, 1, '2025-02-25', '2025-02-25 17:08:11', '2025-02-25 17:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `account_id` int(10) UNSIGNED DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'true',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `text`, `parent_id`, `account_id`, `rank`, `status`, `created_at`, `updated_at`) VALUES
(1, 'مخازن صنعاء', NULL, NULL, NULL, 'true', '2023-12-04 21:00:00', '2024-04-15 21:00:00'),
(11, 'مخازن حده', 1, NULL, 1, 'true', '2023-12-04 21:00:00', '2024-04-15 21:00:00'),
(12, 'مخازن باب اليمن', 1, NULL, 1, 'true', '2023-12-04 21:00:00', '2024-04-15 21:00:00'),
(13, 'مخزن المواد الغذائيه', 1, NULL, 1, 'true', '2024-04-07 21:00:00', '2024-04-15 21:00:00'),
(111, 'المخزن الريسي', 11, 1241, 2, 'false', '2023-12-04 21:00:00', '2025-02-24 19:07:46'),
(121, 'المخزن المركزي الاول', 12, 1242, 2, 'false', '2023-12-04 21:00:00', '2025-02-24 19:08:13'),
(131, 'مخزن دقيق السنابل', 13, 1243, 2, 'false', '2024-04-07 21:00:00', '2025-02-24 19:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `store_products`
--

CREATE TABLE `store_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `status_id` int(10) UNSIGNED DEFAULT NULL,
  `desc` varchar(255) NOT NULL DEFAULT 'default',
  `qr_code` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `cost` double(8,2) NOT NULL DEFAULT 0.00,
  `total` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_products`
--

INSERT INTO `store_products` (`id`, `product_id`, `store_id`, `status_id`, `desc`, `qr_code`, `quantity`, `cost`, `total`, `created_at`, `updated_at`) VALUES
(39, 111, 111, 2, 'asd', NULL, 0, 600.00, 600.00, '2025-02-17 18:11:17', '2025-02-17 18:11:17'),
(40, 111, 111, 2, 'sdf', NULL, 0, 1000.00, 1000.00, '2025-02-17 18:11:17', '2025-02-17 18:11:17'),
(52, 111, 111, 2, 'MQR', NULL, 33, 400.00, 13600.00, '2025-02-24 19:41:26', '2025-02-24 19:41:26'),
(56, 111, 131, 2, 'asd', NULL, 1, 600.00, 600.00, '2025-02-25 17:08:11', '2025-02-25 17:08:11'),
(57, 111, 131, 2, 'sdf', NULL, 1, 1000.00, 1000.00, '2025-02-25 17:08:11', '2025-02-25 17:08:11'),
(58, 111, 131, 2, 'MQR', NULL, 1, 400.00, 400.00, '2025-02-25 17:08:11', '2025-02-25 17:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `company` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `status` int(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `group_id`, `name`, `code`, `company`, `email`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(17, NULL, 'محمد عامر', NULL, NULL, 'muhibalmuhib10@gmail.com', '777345234', 'taiz', 1, '2025-02-18 15:39:08', '2025-02-18 15:39:08'),
(18, 4, 'بشير الحنيد', NULL, NULL, 'muhibalmuh@gmail.com', '777658958', 'ibb', 1, '2025-02-18 15:39:08', '2025-02-18 15:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply_details`
--

CREATE TABLE `supply_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `supply_id` int(10) UNSIGNED NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED DEFAULT NULL,
  `qty` varchar(255) NOT NULL DEFAULT '0',
  `price` varchar(255) NOT NULL DEFAULT '0',
  `qty_return` int(11) NOT NULL DEFAULT 0,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply_returns`
--

CREATE TABLE `supply_returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `supply_id` int(10) UNSIGNED DEFAULT NULL,
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply_return_details`
--

CREATE TABLE `supply_return_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `supply_return_id` int(10) UNSIGNED NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `date`, `created_at`, `updated_at`) VALUES
(2, '2025-02-25', '2025-02-25 17:08:11', '2025-02-25 17:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_details`
--

CREATE TABLE `transfer_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `transfer_id` int(10) UNSIGNED NOT NULL,
  `store_product_id` int(10) UNSIGNED NOT NULL,
  `into_store` text NOT NULL,
  `from_store` text NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfer_details`
--

INSERT INTO `transfer_details` (`id`, `transfer_id`, `store_product_id`, `into_store`, `from_store`, `qty`, `created_at`, `updated_at`) VALUES
(4, 2, 56, '\"\\u0645\\u062e\\u0632\\u0646 \\u062f\\u0642\\u064a\\u0642 \\u0627\\u0644\\u0633\\u0646\\u0627\\u0628\\u0644\"', '\"\\u0627\\u0644\\u0645\\u062e\\u0632\\u0646 \\u0627\\u0644\\u0631\\u064a\\u0633\\u064a\"', 1, '2025-02-25 17:08:11', '2025-02-25 17:08:11'),
(5, 2, 57, '\"\\u0645\\u062e\\u0632\\u0646 \\u062f\\u0642\\u064a\\u0642 \\u0627\\u0644\\u0633\\u0646\\u0627\\u0628\\u0644\"', '\"\\u0627\\u0644\\u0645\\u062e\\u0632\\u0646 \\u0627\\u0644\\u0631\\u064a\\u0633\\u064a\"', 1, '2025-02-25 17:08:11', '2025-02-25 17:08:11'),
(6, 2, 58, '\"\\u0645\\u062e\\u0632\\u0646 \\u062f\\u0642\\u064a\\u0642 \\u0627\\u0644\\u0633\\u0646\\u0627\\u0628\\u0644\"', '\"\\u0627\\u0644\\u0645\\u062e\\u0632\\u0646 \\u0627\\u0644\\u0631\\u064a\\u0633\\u064a\"', 1, '2025-02-25 17:08:11', '2025-02-25 17:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `treasuries`
--

CREATE TABLE `treasuries` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treasuries`
--

INSERT INTO `treasuries` (`id`, `group_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 2, 'صندوق صنعاء', '2025-02-17 18:52:59', '2025-02-18 13:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'كرتون', NULL, NULL),
(2, 'قطعه', NULL, NULL),
(3, 'حبه', NULL, NULL),
(4, 'كيلو', NULL, NULL),
(5, 'جرام', NULL, NULL),
(6, 'متر', NULL, NULL),
(7, 'default', NULL, NULL),
(13, 'كيس', '2025-01-19 11:15:51', '2025-01-19 11:15:51'),
(14, 'نصف كيس', '2025-01-19 11:15:51', '2025-01-19 11:15:51'),
(18, 'سم', '2025-02-17 18:21:47', '2025-02-17 18:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT '776165784',
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `address` varchar(255) DEFAULT 'taiz',
  `password` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT '1',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `phone`, `email`, `email_verified_at`, `address`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'مهيب الجنيد', '776165784', 'muhib@gmail.com', '2025-02-25 02:05:53', 'taiz', '$2y$12$c487OQNuyYcXslJoNEbd1eoCiAs59bYAPaExk3htDwHcnhxQXqa02', '1', 'JSpElCjpWPHVB9X7ANEJYVBrXqMkdt8eeWHlYhV0skCAanXJdrGmSfPetEpB', NULL, NULL),
(2, 1, 'محمد عامر', '738017689', 'muhamed@gmail.com', '2025-01-15 16:45:07', 'sana\'a', '$2y$12$pi0rAS1.W.nDR6xKkF82Ke4YDTGjlUgwQ4N4ojaVWfGdEwnb9SkBy', '1', '12313131313', NULL, NULL),
(4, 1, 'الخليل الجنيد', '738017689', 'muhibalmuh@gmail.com', '2025-01-19 15:04:57', NULL, '$2y$12$vCwbuw3xO6VlZQQbZ4VJwuSB/VsWQyBV.vHDE/AW9CgvHIEZZ1BR.', '1', NULL, '2025-01-19 12:04:57', '2025-01-19 12:04:57'),
(5, 1, 'امير محمد عبدالجليل', '776165784', 'muhibalmuh@gmail.comm', '2025-02-11 19:20:08', 'sanaa', '$2y$12$j.DA.NVjYIK8Y6968K9G2e5s9GjNZBZJckbl/DvMe8wu6PN2kqC4y', '1', NULL, '2025-02-11 16:20:08', '2025-02-11 16:20:08'),
(6, 1, 'محمد احمد عبدالجليل', '776165784', 'muhibalmuh11@gmail.com', '2025-02-11 19:26:54', 'taiz', '$2y$12$5whSOxdrJsVfQL.ddSg9Ce9GtYmRoVjtzxHrVAHQZqmUPX3R8QDVu', '1', NULL, '2025-02-11 16:26:54', '2025-02-11 16:26:54'),
(7, 1, 'امير محمدعبدالجليل', '776165784', 'muhibalmuh12@gmail.com', '2025-02-11 19:26:54', 'sanaa', '$2y$12$LUWEtDX5ZCo1F2hNOjERieO/RNzOD9.jnggScRP5OZUzIe4JKQMIS', '1', NULL, '2025-02-11 16:26:54', '2025-02-11 16:26:54'),
(9, 1, 'امجد عبدالرزاق', '776165784', 'muhibalmuh200@gmail.com', '2025-02-17 21:26:25', 'taiz', '$2y$12$qgyV9ey7VsAWmj0XdMinH.Ol40K.yMMWVCNj1/vQUD2xRwG07CK.6', '1', NULL, '2025-02-17 18:26:25', '2025-02-17 18:26:25');

-- --------------------------------------------------------

--
-- Table structure for table `vacations`
--

CREATE TABLE `vacations` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `vacation_type_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `total_days` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vacations`
--

INSERT INTO `vacations` (`id`, `staff_id`, `vacation_type_id`, `status`, `total_days`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 4, 1, NULL, 2, '2025-02-02', '2025-02-04', '2025-02-19 20:07:41', '2025-02-19 20:07:41'),
(2, 5, 1, NULL, 1, '2025-02-04', '2025-02-05', '2025-02-19 20:21:19', '2025-02-19 20:21:19'),
(3, 6, 1, NULL, 1, '2025-02-02', '2025-02-03', '2025-02-19 20:22:58', '2025-02-19 20:22:58'),
(4, 7, 2, NULL, 3, '2025-02-03', '2025-02-06', '2025-02-24 12:01:48', '2025-02-24 12:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `vacation_types`
--

CREATE TABLE `vacation_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vacation_types`
--

INSERT INTO `vacation_types` (`id`, `name`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'مرضيه', 30, NULL, NULL),
(2, 'زواج', 14, NULL, NULL),
(3, 'ولاد', 7, NULL, NULL),
(4, 'وفاه', 5, NULL, NULL),
(5, 'اخري', 3, '2025-02-24 17:15:56', '2025-02-24 17:15:56');

-- --------------------------------------------------------

--
-- Table structure for table `work_systems`
--

CREATE TABLE `work_systems` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED DEFAULT NULL,
  `work_system_type_id` int(10) UNSIGNED DEFAULT NULL,
  `period_time_id` int(10) UNSIGNED DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`days`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_systems`
--

INSERT INTO `work_systems` (`id`, `staff_id`, `work_system_type_id`, `period_time_id`, `sort`, `days`, `created_at`, `updated_at`) VALUES
(5, 4, 1, 5, NULL, '\"{\\\"1\\\":\\\"Satarday\\\",\\\"2\\\":\\\"Sunday\\\",\\\"3\\\":\\\"Monday\\\",\\\"4\\\":\\\"Tusday\\\",\\\"5\\\":\\\"Wedencday\\\",\\\"6\\\":\\\"Thresay\\\"}\"', '2025-02-19 16:24:43', '2025-02-19 16:24:43'),
(6, 4, 1, 6, NULL, '\"{\\\"1\\\":\\\"Satarday\\\",\\\"2\\\":\\\"Sunday\\\",\\\"3\\\":\\\"Monday\\\",\\\"4\\\":\\\"Tusday\\\",\\\"5\\\":\\\"Wedencday\\\",\\\"6\\\":\\\"Thresay\\\"}\"', '2025-02-19 16:24:43', '2025-02-19 16:24:43'),
(7, 5, 1, 5, NULL, '\"{\\\"1\\\":\\\"Satarday\\\",\\\"2\\\":\\\"Sunday\\\",\\\"3\\\":\\\"Monday\\\",\\\"4\\\":\\\"Tusday\\\",\\\"5\\\":\\\"Wedencday\\\",\\\"6\\\":\\\"Thresay\\\"}\"', '2025-02-19 18:04:33', '2025-02-19 18:04:33'),
(8, 5, 1, 6, NULL, '\"{\\\"1\\\":\\\"Satarday\\\",\\\"2\\\":\\\"Sunday\\\",\\\"3\\\":\\\"Monday\\\",\\\"4\\\":\\\"Tusday\\\",\\\"5\\\":\\\"Wedencday\\\",\\\"6\\\":\\\"Thresay\\\"}\"', '2025-02-19 18:04:33', '2025-02-19 18:04:33'),
(9, 6, 1, 5, NULL, '\"{\\\"1\\\":\\\"Satarday\\\",\\\"2\\\":\\\"Sunday\\\",\\\"3\\\":\\\"Monday\\\",\\\"4\\\":\\\"Tusday\\\",\\\"5\\\":\\\"Wedencday\\\",\\\"6\\\":\\\"Thresay\\\"}\"', '2025-02-19 18:04:33', '2025-02-19 18:04:33'),
(10, 6, 1, 6, NULL, '\"{\\\"1\\\":\\\"Satarday\\\",\\\"2\\\":\\\"Sunday\\\",\\\"3\\\":\\\"Monday\\\",\\\"4\\\":\\\"Tusday\\\",\\\"5\\\":\\\"Wedencday\\\",\\\"6\\\":\\\"Thresay\\\"}\"', '2025-02-19 18:04:33', '2025-02-19 18:04:33'),
(11, 7, 3, 7, NULL, '\"{\\\"1\\\":\\\"Satarday\\\",\\\"2\\\":\\\"Sunday\\\",\\\"3\\\":\\\"Monday\\\",\\\"4\\\":\\\"Tusday\\\",\\\"5\\\":\\\"Wedencday\\\",\\\"6\\\":\\\"Thresay\\\"}\"', '2025-02-24 12:06:29', '2025-02-24 12:06:29'),
(12, 7, 3, 8, NULL, '\"{\\\"1\\\":\\\"Satarday\\\",\\\"2\\\":\\\"Sunday\\\",\\\"3\\\":\\\"Monday\\\",\\\"4\\\":\\\"Tusday\\\",\\\"5\\\":\\\"Wedencday\\\",\\\"6\\\":\\\"Thresay\\\"}\"', '2025-02-24 12:06:29', '2025-02-24 12:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `work_system_types`
--

CREATE TABLE `work_system_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_system_types`
--

INSERT INTO `work_system_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'دوام رسمي', '2025-02-19 11:24:51', '2025-02-19 11:24:51'),
(2, 'دوام مدراء', '2025-02-19 11:24:51', '2025-02-19 11:24:51'),
(3, 'دوام خدمه عملاء', '2025-02-19 11:24:51', '2025-02-19 11:24:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absences_staff_id_foreign` (`staff_id`),
  ADD KEY `absences_absence_type_id_foreign` (`absence_type_id`);

--
-- Indexes for table `absence_details`
--
ALTER TABLE `absence_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absence_details_absence_id_foreign` (`absence_id`),
  ADD KEY `absence_details_absence_sanction_id_foreign` (`absence_sanction_id`);

--
-- Indexes for table `absence_sanctions`
--
ALTER TABLE `absence_sanctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absence_sanctions_absence_type_id_foreign` (`absence_type_id`),
  ADD KEY `absence_sanctions_sanction_discount_id_foreign` (`sanction_discount_id`);

--
-- Indexes for table `absence_types`
--
ALTER TABLE `absence_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `account_years`
--
ALTER TABLE `account_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrative_structures`
--
ALTER TABLE `administrative_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrative_structures_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `advances`
--
ALTER TABLE `advances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advances_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allowances_staff_id_foreign` (`staff_id`),
  ADD KEY `allowances_allowance_type_id_foreign` (`allowance_type_id`);

--
-- Indexes for table `allowance_types`
--
ALTER TABLE `allowance_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allowance_types_group_id_foreign` (`group_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `attendance_details`
--
ALTER TABLE `attendance_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_details_attendance_id_foreign` (`attendance_id`),
  ADD KEY `attendance_details_period_id_foreign` (`period_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banks_group_id_foreign` (`group_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashes`
--
ALTER TABLE `cashes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cashes_customer_id_foreign` (`customer_id`),
  ADD KEY `cashes_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `cash_details`
--
ALTER TABLE `cash_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_details_cash_id_foreign` (`cash_id`),
  ADD KEY `cash_details_store_product_id_foreign` (`store_product_id`),
  ADD KEY `cash_details_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `cash_returns`
--
ALTER TABLE `cash_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_returns_cash_id_foreign` (`cash_id`),
  ADD KEY `cash_returns_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `cash_return_details`
--
ALTER TABLE `cash_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_return_details_store_product_id_foreign` (`store_product_id`),
  ADD KEY `cash_return_details_unit_id_foreign` (`unit_id`),
  ADD KEY `cash_return_details_cash_return_id_foreign` (`cash_return_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_email_unique` (`email`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD KEY `customers_group_id_foreign` (`group_id`);

--
-- Indexes for table `dailies`
--
ALTER TABLE `dailies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_details`
--
ALTER TABLE `daily_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_details_daily_id_foreign` (`daily_id`),
  ADD KEY `daily_details_account_id_foreign` (`account_id`);

--
-- Indexes for table `delays`
--
ALTER TABLE `delays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delays_staff_id_foreign` (`staff_id`),
  ADD KEY `delays_delay_type_id_foreign` (`delay_type_id`),
  ADD KEY `delays_part_id_foreign` (`part_id`);

--
-- Indexes for table `delay_sanctions`
--
ALTER TABLE `delay_sanctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delay_sanctions_delay_type_id_foreign` (`delay_type_id`),
  ADD KEY `delay_sanctions_part_id_foreign` (`part_id`),
  ADD KEY `delay_sanctions_sanction_discount_id_foreign` (`sanction_discount_id`);

--
-- Indexes for table `delay_types`
--
ALTER TABLE `delay_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discounts_staff_id_foreign` (`staff_id`),
  ADD KEY `discounts_discount_type_id_foreign` (`discount_type_id`);

--
-- Indexes for table `discount_types`
--
ALTER TABLE `discount_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expences`
--
ALTER TABLE `expences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expences_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extras_staff_id_foreign` (`staff_id`),
  ADD KEY `extras_extra_type_id_foreign` (`extra_type_id`);

--
-- Indexes for table `extra_sanctions`
--
ALTER TABLE `extra_sanctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extra_sanctions_extra_type_id_foreign` (`extra_type_id`),
  ADD KEY `extra_sanctions_part_id_foreign` (`part_id`),
  ADD KEY `extra_sanctions_sanction_discount_id_foreign` (`sanction_discount_id`);

--
-- Indexes for table `extra_types`
--
ALTER TABLE `extra_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_group_type_id_foreign` (`group_type_id`);

--
-- Indexes for table `group_accounts`
--
ALTER TABLE `group_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_accounts_account_id_foreign` (`account_id`),
  ADD KEY `group_accounts_group_id_foreign` (`group_id`);

--
-- Indexes for table `group_account_daily_details`
--
ALTER TABLE `group_account_daily_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_account_daily_details_dailyable_type_dailyable_id_index` (`dailyable_type`,`dailyable_id`),
  ADD KEY `group_account_daily_details_daily_detail_id_foreign` (`daily_detail_id`);

--
-- Indexes for table `group_account_details`
--
ALTER TABLE `group_account_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_account_details_group_account_id_foreign` (`group_account_id`),
  ADD KEY `group_account_details_account_id_foreign` (`account_id`);

--
-- Indexes for table `group_types`
--
ALTER TABLE `group_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iterations`
--
ALTER TABLE `iterations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_staff_id_foreign` (`staff_id`),
  ADD KEY `leaves_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `leaves_part_id_foreign` (`part_id`);

--
-- Indexes for table `leave_sanctions`
--
ALTER TABLE `leave_sanctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_sanctions_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `leave_sanctions_part_id_foreign` (`part_id`),
  ADD KEY `leave_sanctions_sanction_discount_id_foreign` (`sanction_discount_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `official_holidays`
--
ALTER TABLE `official_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opening_inventuries`
--
ALTER TABLE `opening_inventuries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opening_inventories_store_product_id_foreign` (`store_product_id`),
  ADD KEY `opening_inventories_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payable_notes`
--
ALTER TABLE `payable_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payable_notes_purchase_id_foreign` (`purchase_id`),
  ADD KEY `payable_notes_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_paymentable_type_paymentable_id_index` (`paymentable_type`,`paymentable_id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payrolls_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `period_times`
--
ALTER TABLE `period_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_system_type_id` (`work_system_type_id`);

--
-- Indexes for table `personalities`
--
ALTER TABLE `personalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `product_units`
--
ALTER TABLE `product_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_units_product_id_foreign` (`product_id`),
  ADD KEY `product_units_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchases_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_details_store_product_id_foreign` (`store_product_id`),
  ADD KEY `purchase_details_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_returns_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_returns_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_details_purchase_return_id_foreign` (`purchase_return_id`),
  ADD KEY `purchase_return_details_store_product_id_foreign` (`store_product_id`),
  ADD KEY `purchase_return_details_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receivable_notes`
--
ALTER TABLE `receivable_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receivable_notes_sale_id_foreign` (`sale_id`),
  ADD KEY `receivable_notes_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_details_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_details_store_product_id_foreign` (`store_product_id`),
  ADD KEY `sale_details_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_returns_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_returns_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_return_details_store_product_id_foreign` (`store_product_id`),
  ADD KEY `sale_return_details_unit_id_foreign` (`unit_id`),
  ADD KEY `sale_return_details_sale_return_id_foreign` (`sale_return_id`);

--
-- Indexes for table `sanction_discounts`
--
ALTER TABLE `sanction_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_branch_id_foreign` (`branch_id`),
  ADD KEY `staff_department_id_foreign` (`department_id`),
  ADD KEY `staff_job_id_foreign` (`job_id`),
  ADD KEY `staff_qualification_id_foreign` (`qualification_id`),
  ADD KEY `staff_staff_type_id_foreign` (`staff_type_id`),
  ADD KEY `staff_religion_id_foreign` (`religion_id`),
  ADD KEY `staff_nationality_id_foreign` (`nationality_id`);

--
-- Indexes for table `staff_group_daily_details`
--
ALTER TABLE `staff_group_daily_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_group_daily_details_group_id_foreign` (`group_id`),
  ADD KEY `staff_group_daily_details_staff_id_foreign` (`staff_id`),
  ADD KEY `staff_group_daily_details_daily_detail_id_foreign` (`daily_detail_id`);

--
-- Indexes for table `staff_religions`
--
ALTER TABLE `staff_religions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_sanctions`
--
ALTER TABLE `staff_sanctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_sanctions_staff_id_foreign` (`staff_id`),
  ADD KEY `staff_sanctions_sanctionable_type_sanctionable_id_index` (`sanctionable_type`,`sanctionable_id`);

--
-- Indexes for table `staff_types`
--
ALTER TABLE `staff_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_work_systems`
--
ALTER TABLE `staff_work_systems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_work_systems_staff_id_foreign` (`staff_id`),
  ADD KEY `staff_work_systems_work_system_type_id_foreign` (`work_system_type_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_store_product_id_foreign` (`store_product_id`),
  ADD KEY `stocks_unit_id_foreign` (`unit_id`),
  ADD KEY `stocks_stockable_type_stockable_id_index` (`stockable_type`,`stockable_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stores_parent_id_foreign` (`parent_id`),
  ADD KEY `stores_account_id_foreign` (`account_id`);

--
-- Indexes for table `store_products`
--
ALTER TABLE `store_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_products_product_id_foreign` (`product_id`),
  ADD KEY `store_products_store_id_foreign` (`store_id`),
  ADD KEY `store_products_status_id_foreign` (`status_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`),
  ADD KEY `suppliers_group_id_foreign` (`group_id`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplies_supplier_id_foreign` (`supplier_id`),
  ADD KEY `supplies_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `supply_details`
--
ALTER TABLE `supply_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supply_details_supply_id_foreign` (`supply_id`),
  ADD KEY `supply_details_store_product_id_foreign` (`store_product_id`),
  ADD KEY `supply_details_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `supply_returns`
--
ALTER TABLE `supply_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supply_returns_supply_id_foreign` (`supply_id`),
  ADD KEY `supply_returns_daily_id_foreign` (`daily_id`);

--
-- Indexes for table `supply_return_details`
--
ALTER TABLE `supply_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supply_return_details_supply_return_id_foreign` (`supply_return_id`),
  ADD KEY `supply_return_details_store_product_id_foreign` (`store_product_id`),
  ADD KEY `supply_return_details_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_details`
--
ALTER TABLE `transfer_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_details_transfer_id_foreign` (`transfer_id`),
  ADD KEY `transfer_details_store_product_id_foreign` (`store_product_id`);

--
-- Indexes for table `treasuries`
--
ALTER TABLE `treasuries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treasuries_group_id_foreign` (`group_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `vacations`
--
ALTER TABLE `vacations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacations_staff_id_foreign` (`staff_id`),
  ADD KEY `vacations_vacation_type_id_foreign` (`vacation_type_id`);

--
-- Indexes for table `vacation_types`
--
ALTER TABLE `vacation_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_systems`
--
ALTER TABLE `work_systems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_systems_staff_id_foreign` (`staff_id`),
  ADD KEY `work_systems_work_system_type_id_foreign` (`work_system_type_id`),
  ADD KEY `work_systems_period_time_id_foreign` (`period_time_id`);

--
-- Indexes for table `work_system_types`
--
ALTER TABLE `work_system_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `absence_details`
--
ALTER TABLE `absence_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absence_sanctions`
--
ALTER TABLE `absence_sanctions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `absence_types`
--
ALTER TABLE `absence_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4124;

--
-- AUTO_INCREMENT for table `account_years`
--
ALTER TABLE `account_years`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `administrative_structures`
--
ALTER TABLE `administrative_structures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `advances`
--
ALTER TABLE `advances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `allowance_types`
--
ALTER TABLE `allowance_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `attendance_details`
--
ALTER TABLE `attendance_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cashes`
--
ALTER TABLE `cashes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cash_details`
--
ALTER TABLE `cash_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cash_returns`
--
ALTER TABLE `cash_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_return_details`
--
ALTER TABLE `cash_return_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dailies`
--
ALTER TABLE `dailies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `daily_details`
--
ALTER TABLE `daily_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `delays`
--
ALTER TABLE `delays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delay_sanctions`
--
ALTER TABLE `delay_sanctions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `delay_types`
--
ALTER TABLE `delay_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `discount_types`
--
ALTER TABLE `discount_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expences`
--
ALTER TABLE `expences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extras`
--
ALTER TABLE `extras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `extra_sanctions`
--
ALTER TABLE `extra_sanctions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `extra_types`
--
ALTER TABLE `extra_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `group_accounts`
--
ALTER TABLE `group_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `group_account_daily_details`
--
ALTER TABLE `group_account_daily_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `group_account_details`
--
ALTER TABLE `group_account_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `group_types`
--
ALTER TABLE `group_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `iterations`
--
ALTER TABLE `iterations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_sanctions`
--
ALTER TABLE `leave_sanctions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `official_holidays`
--
ALTER TABLE `official_holidays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `opening_inventuries`
--
ALTER TABLE `opening_inventuries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payable_notes`
--
ALTER TABLE `payable_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `period_times`
--
ALTER TABLE `period_times`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personalities`
--
ALTER TABLE `personalities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `receivable_notes`
--
ALTER TABLE `receivable_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `sanction_discounts`
--
ALTER TABLE `sanction_discounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff_group_daily_details`
--
ALTER TABLE `staff_group_daily_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_religions`
--
ALTER TABLE `staff_religions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_sanctions`
--
ALTER TABLE `staff_sanctions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_types`
--
ALTER TABLE `staff_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_work_systems`
--
ALTER TABLE `staff_work_systems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1312;

--
-- AUTO_INCREMENT for table `store_products`
--
ALTER TABLE `store_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_details`
--
ALTER TABLE `supply_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_returns`
--
ALTER TABLE `supply_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_return_details`
--
ALTER TABLE `supply_return_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfer_details`
--
ALTER TABLE `transfer_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `treasuries`
--
ALTER TABLE `treasuries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vacations`
--
ALTER TABLE `vacations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vacation_types`
--
ALTER TABLE `vacation_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `work_systems`
--
ALTER TABLE `work_systems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `work_system_types`
--
ALTER TABLE `work_system_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_absence_type_id_foreign` FOREIGN KEY (`absence_type_id`) REFERENCES `absence_types` (`id`),
  ADD CONSTRAINT `absences_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `absence_details`
--
ALTER TABLE `absence_details`
  ADD CONSTRAINT `absence_details_absence_id_foreign` FOREIGN KEY (`absence_id`) REFERENCES `absences` (`id`),
  ADD CONSTRAINT `absence_details_absence_sanction_id_foreign` FOREIGN KEY (`absence_sanction_id`) REFERENCES `absence_sanctions` (`id`);

--
-- Constraints for table `absence_sanctions`
--
ALTER TABLE `absence_sanctions`
  ADD CONSTRAINT `absence_sanctions_absence_type_id_foreign` FOREIGN KEY (`absence_type_id`) REFERENCES `absence_types` (`id`),
  ADD CONSTRAINT `absence_sanctions_sanction_discount_id_foreign` FOREIGN KEY (`sanction_discount_id`) REFERENCES `sanction_discounts` (`id`);

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `administrative_structures`
--
ALTER TABLE `administrative_structures`
  ADD CONSTRAINT `administrative_structures_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `administrative_structures` (`id`);

--
-- Constraints for table `advances`
--
ALTER TABLE `advances`
  ADD CONSTRAINT `advances_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `allowances`
--
ALTER TABLE `allowances`
  ADD CONSTRAINT `allowances_allowance_type_id_foreign` FOREIGN KEY (`allowance_type_id`) REFERENCES `allowance_types` (`id`),
  ADD CONSTRAINT `allowances_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `allowance_types`
--
ALTER TABLE `allowance_types`
  ADD CONSTRAINT `allowance_types_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `attendance_details`
--
ALTER TABLE `attendance_details`
  ADD CONSTRAINT `attendance_details_attendance_id_foreign` FOREIGN KEY (`attendance_id`) REFERENCES `attendances` (`id`),
  ADD CONSTRAINT `attendance_details_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `period_times` (`id`);

--
-- Constraints for table `banks`
--
ALTER TABLE `banks`
  ADD CONSTRAINT `banks_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `cashes`
--
ALTER TABLE `cashes`
  ADD CONSTRAINT `cashes_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cashes_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_details`
--
ALTER TABLE `cash_details`
  ADD CONSTRAINT `cash_details_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_details_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `cash_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `cash_returns`
--
ALTER TABLE `cash_returns`
  ADD CONSTRAINT `cash_returns_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_returns_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_return_details`
--
ALTER TABLE `cash_return_details`
  ADD CONSTRAINT `cash_return_details_cash_return_id_foreign` FOREIGN KEY (`cash_return_id`) REFERENCES `cash_returns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_return_details_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `cash_return_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `daily_details`
--
ALTER TABLE `daily_details`
  ADD CONSTRAINT `daily_details_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `daily_details_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`);

--
-- Constraints for table `delays`
--
ALTER TABLE `delays`
  ADD CONSTRAINT `delays_delay_type_id_foreign` FOREIGN KEY (`delay_type_id`) REFERENCES `delay_types` (`id`),
  ADD CONSTRAINT `delays_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`),
  ADD CONSTRAINT `delays_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `delay_sanctions`
--
ALTER TABLE `delay_sanctions`
  ADD CONSTRAINT `delay_sanctions_delay_type_id_foreign` FOREIGN KEY (`delay_type_id`) REFERENCES `delay_types` (`id`),
  ADD CONSTRAINT `delay_sanctions_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`),
  ADD CONSTRAINT `delay_sanctions_sanction_discount_id_foreign` FOREIGN KEY (`sanction_discount_id`) REFERENCES `sanction_discounts` (`id`);

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_discount_type_id_foreign` FOREIGN KEY (`discount_type_id`) REFERENCES `discount_types` (`id`),
  ADD CONSTRAINT `discounts_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `expences`
--
ALTER TABLE `expences`
  ADD CONSTRAINT `expences_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`);

--
-- Constraints for table `extras`
--
ALTER TABLE `extras`
  ADD CONSTRAINT `extras_extra_type_id_foreign` FOREIGN KEY (`extra_type_id`) REFERENCES `extra_types` (`id`),
  ADD CONSTRAINT `extras_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `extra_sanctions`
--
ALTER TABLE `extra_sanctions`
  ADD CONSTRAINT `extra_sanctions_extra_type_id_foreign` FOREIGN KEY (`extra_type_id`) REFERENCES `extra_types` (`id`),
  ADD CONSTRAINT `extra_sanctions_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`),
  ADD CONSTRAINT `extra_sanctions_sanction_discount_id_foreign` FOREIGN KEY (`sanction_discount_id`) REFERENCES `sanction_discounts` (`id`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_group_type_id_foreign` FOREIGN KEY (`group_type_id`) REFERENCES `group_types` (`id`);

--
-- Constraints for table `group_accounts`
--
ALTER TABLE `group_accounts`
  ADD CONSTRAINT `group_accounts_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `group_accounts_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `group_account_daily_details`
--
ALTER TABLE `group_account_daily_details`
  ADD CONSTRAINT `group_account_daily_details_daily_detail_id_foreign` FOREIGN KEY (`daily_detail_id`) REFERENCES `daily_details` (`id`);

--
-- Constraints for table `group_account_details`
--
ALTER TABLE `group_account_details`
  ADD CONSTRAINT `group_account_details_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `group_account_details_group_account_id_foreign` FOREIGN KEY (`group_account_id`) REFERENCES `group_accounts` (`id`);

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`),
  ADD CONSTRAINT `leaves_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`),
  ADD CONSTRAINT `leaves_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `leave_sanctions`
--
ALTER TABLE `leave_sanctions`
  ADD CONSTRAINT `leave_sanctions_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`),
  ADD CONSTRAINT `leave_sanctions_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`),
  ADD CONSTRAINT `leave_sanctions_sanction_discount_id_foreign` FOREIGN KEY (`sanction_discount_id`) REFERENCES `sanction_discounts` (`id`);

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `opening_inventuries`
--
ALTER TABLE `opening_inventuries`
  ADD CONSTRAINT `opening_inventories_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `opening_inventories_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `payable_notes`
--
ALTER TABLE `payable_notes`
  ADD CONSTRAINT `payable_notes_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`),
  ADD CONSTRAINT `payable_notes_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`);

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `period_times`
--
ALTER TABLE `period_times`
  ADD CONSTRAINT `period_times_ibfk_1` FOREIGN KEY (`work_system_type_id`) REFERENCES `work_system_types` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_units`
--
ALTER TABLE `product_units`
  ADD CONSTRAINT `product_units_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_units_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_details_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `purchase_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD CONSTRAINT `purchase_returns_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_returns_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD CONSTRAINT `purchase_return_details_purchase_return_id_foreign` FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_returns` (`id`),
  ADD CONSTRAINT `purchase_return_details_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `purchase_return_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `receivable_notes`
--
ALTER TABLE `receivable_notes`
  ADD CONSTRAINT `receivable_notes_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`),
  ADD CONSTRAINT `receivable_notes_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_details_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `sale_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD CONSTRAINT `sale_returns_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_returns_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD CONSTRAINT `sale_return_details_sale_return_id_foreign` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_returns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_return_details_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `sale_return_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `staff_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `administrative_structures` (`id`),
  ADD CONSTRAINT `staff_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `administrative_structures` (`id`),
  ADD CONSTRAINT `staff_nationality_id_foreign` FOREIGN KEY (`nationality_id`) REFERENCES `nationalities` (`id`),
  ADD CONSTRAINT `staff_qualification_id_foreign` FOREIGN KEY (`qualification_id`) REFERENCES `qualifications` (`id`),
  ADD CONSTRAINT `staff_religion_id_foreign` FOREIGN KEY (`religion_id`) REFERENCES `staff_religions` (`id`),
  ADD CONSTRAINT `staff_staff_type_id_foreign` FOREIGN KEY (`staff_type_id`) REFERENCES `staff_types` (`id`);

--
-- Constraints for table `staff_group_daily_details`
--
ALTER TABLE `staff_group_daily_details`
  ADD CONSTRAINT `staff_group_daily_details_daily_detail_id_foreign` FOREIGN KEY (`daily_detail_id`) REFERENCES `daily_details` (`id`),
  ADD CONSTRAINT `staff_group_daily_details_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `staff_group_daily_details_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `staff_sanctions`
--
ALTER TABLE `staff_sanctions`
  ADD CONSTRAINT `staff_sanctions_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `staff_work_systems`
--
ALTER TABLE `staff_work_systems`
  ADD CONSTRAINT `staff_work_systems_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `staff_work_systems_work_system_type_id_foreign` FOREIGN KEY (`work_system_type_id`) REFERENCES `work_system_types` (`id`);

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stocks_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `stores_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `store_products`
--
ALTER TABLE `store_products`
  ADD CONSTRAINT `store_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `store_products_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `store_products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `supplies`
--
ALTER TABLE `supplies`
  ADD CONSTRAINT `supplies_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplies_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supply_details`
--
ALTER TABLE `supply_details`
  ADD CONSTRAINT `supply_details_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `supply_details_supply_id_foreign` FOREIGN KEY (`supply_id`) REFERENCES `supplies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supply_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `supply_returns`
--
ALTER TABLE `supply_returns`
  ADD CONSTRAINT `supply_returns_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supply_returns_supply_id_foreign` FOREIGN KEY (`supply_id`) REFERENCES `supplies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supply_return_details`
--
ALTER TABLE `supply_return_details`
  ADD CONSTRAINT `supply_return_details_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `supply_return_details_supply_return_id_foreign` FOREIGN KEY (`supply_return_id`) REFERENCES `supply_returns` (`id`),
  ADD CONSTRAINT `supply_return_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `transfer_details`
--
ALTER TABLE `transfer_details`
  ADD CONSTRAINT `transfer_details_store_product_id_foreign` FOREIGN KEY (`store_product_id`) REFERENCES `store_products` (`id`),
  ADD CONSTRAINT `transfer_details_transfer_id_foreign` FOREIGN KEY (`transfer_id`) REFERENCES `transfers` (`id`);

--
-- Constraints for table `treasuries`
--
ALTER TABLE `treasuries`
  ADD CONSTRAINT `treasuries_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vacations`
--
ALTER TABLE `vacations`
  ADD CONSTRAINT `vacations_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `vacations_vacation_type_id_foreign` FOREIGN KEY (`vacation_type_id`) REFERENCES `vacation_types` (`id`);

--
-- Constraints for table `work_systems`
--
ALTER TABLE `work_systems`
  ADD CONSTRAINT `work_systems_period_time_id_foreign` FOREIGN KEY (`period_time_id`) REFERENCES `period_times` (`id`),
  ADD CONSTRAINT `work_systems_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `work_systems_work_system_type_id_foreign` FOREIGN KEY (`work_system_type_id`) REFERENCES `work_system_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
