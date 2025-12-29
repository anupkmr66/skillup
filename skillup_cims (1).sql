-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2025 at 10:00 AM
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
-- Database: `skillup_cims`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES
(2, 1, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 07:16:46'),
(3, 1, 'User logged out', 'Authentication', NULL, '::1', NULL, '2025-12-28 07:17:34'),
(4, 1, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 07:17:40'),
(5, 1, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 09:02:44'),
(6, 9, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 09:30:33'),
(7, 9, 'User logged out', 'Authentication', NULL, '::1', NULL, '2025-12-28 09:31:04'),
(8, 13, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 10:37:17'),
(9, 13, 'User logged out', 'Authentication', NULL, '::1', NULL, '2025-12-28 10:38:25'),
(10, 13, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 10:38:54'),
(11, 13, 'Fee Payment Received: 2499', 'Fees', 'Receipt: REC2025000003 | Student ID: 4', '::1', NULL, '2025-12-28 11:31:23'),
(12, 13, 'Applied Discount: ₹2000', 'Fees', 'Fee ID: 2', '::1', NULL, '2025-12-28 11:56:32'),
(13, 13, 'Fee Payment Received: 5000', 'Fees', 'Receipt: REC2025000004 | Student ID: 5', '::1', NULL, '2025-12-28 11:56:52'),
(14, 13, 'Fee Payment Received: 499', 'Fees', 'Receipt: REC2025000005 | Student ID: 5', '::1', NULL, '2025-12-28 12:01:32'),
(15, 13, 'Applied Discount: ₹499', 'Fees', 'Fee ID: 3', '::1', NULL, '2025-12-28 12:09:31'),
(16, 13, 'Fee Payment Received: 5000', 'Fees', 'Receipt: REC2025000006 | Student ID: 6', '::1', NULL, '2025-12-28 12:10:03'),
(17, 1, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 12:11:12'),
(18, 13, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 12:59:45'),
(19, 1, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 14:07:37'),
(20, 13, 'User logged out', 'Authentication', NULL, '::1', NULL, '2025-12-28 15:07:04'),
(21, 13, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 15:08:51'),
(22, 1, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 15:21:28'),
(23, 1, 'User logged out', 'Authentication', NULL, '::1', NULL, '2025-12-28 15:36:56'),
(24, 1, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 15:41:03'),
(25, 13, 'User logged out', 'Authentication', NULL, '::1', NULL, '2025-12-28 15:43:08'),
(26, 1, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 23:19:08'),
(27, 1, 'User logged out', 'Authentication', NULL, '::1', NULL, '2025-12-28 23:36:05'),
(28, 13, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-28 23:38:04'),
(29, 13, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-29 00:49:03'),
(30, 20, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-29 01:08:34'),
(31, 11, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-29 01:28:09'),
(32, 11, 'User logged out', 'Authentication', NULL, '::1', NULL, '2025-12-29 01:28:25'),
(33, 16, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-29 01:28:37'),
(34, 16, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-29 03:30:32'),
(35, 13, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-29 03:40:21'),
(36, 13, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-29 03:49:39'),
(37, 13, 'User logged out', 'Authentication', NULL, '::1', NULL, '2025-12-29 04:01:30'),
(38, 1, 'User logged in', 'Authentication', NULL, '::1', NULL, '2025-12-29 04:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `batch_id` int(10) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('present','absent','late','leave') NOT NULL,
  `remarks` text DEFAULT NULL,
  `marked_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `batch_id`, `attendance_date`, `status`, `remarks`, `marked_by`, `created_at`) VALUES
(1, 4, 1, '2025-12-28', 'present', NULL, 13, '2025-12-28 15:44:29'),
(2, 5, 2, '2025-12-28', 'absent', NULL, 13, '2025-12-28 15:44:39'),
(3, 4, 1, '2025-12-29', 'present', NULL, 13, '2025-12-28 19:35:37'),
(4, 6, 2, '2025-12-29', 'absent', NULL, 13, '2025-12-28 19:35:52'),
(5, 5, 2, '2025-12-29', 'late', NULL, 13, '2025-12-28 19:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(10) UNSIGNED NOT NULL,
  `batch_name` varchar(100) NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `institute_id` int(10) UNSIGNED NOT NULL,
  `teacher_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Teacher user ID',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `timing` varchar(50) DEFAULT NULL COMMENT 'e.g., 9:00 AM - 11:00 AM',
  `max_students` int(11) DEFAULT 30,
  `status` enum('active','inactive','completed') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `batch_name`, `course_id`, `institute_id`, `teacher_id`, `start_date`, `end_date`, `timing`, `max_students`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MORNING VIBES', 2, 4, 20, '2025-03-10', NULL, '07:00AM-9:00AM', 10, 'active', '2025-12-28 15:31:00', '2025-12-29 05:31:07'),
(2, 'MORNING VIBES ADCA', 3, 4, NULL, '2025-03-10', NULL, '07:00AM-9:00AM', 10, 'active', '2025-12-28 15:31:50', '2025-12-28 15:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(10) UNSIGNED NOT NULL,
  `certificate_number` varchar(50) NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `issue_date` date NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL COMMENT 'QR code for verification',
  `template` varchar(100) DEFAULT 'default',
  `certificate_file` varchar(255) DEFAULT NULL,
  `status` enum('active','revoked') DEFAULT 'active',
  `issued_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `certificate_number`, `student_id`, `course_id`, `issue_date`, `qr_code`, `template`, `certificate_file`, `status`, `issued_by`, `created_at`, `updated_at`) VALUES
(2, 'CERT-2025-0004', 4, 2, '2025-12-29', NULL, 'default', NULL, 'active', NULL, '2025-12-29 06:15:10', '2025-12-29 06:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_name` varchar(200) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in months',
  `fee` decimal(10,2) NOT NULL,
  `regular_price` decimal(10,2) DEFAULT 0.00,
  `offer_price` decimal(10,2) DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `syllabus` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `duration`, `fee`, `regular_price`, `offer_price`, `description`, `syllabus`, `category`, `status`, `created_at`, `updated_at`) VALUES
(2, 'DCA02', 'DCA', 6, 5499.00, 5499.00, 5499.00, 'BASIC OF COMPUTERS AND OFFICE PACKAGE INCLUDEING MS_ WORD, POWER POINT AND EXCELL WITH INTERNET', NULL, 'Basic', 'active', '2025-12-28 15:19:51', '2025-12-28 16:49:24'),
(3, 'ADCA03', 'ADCA', 12, 6999.00, 7499.00, 6999.00, 'ALL INCLUDEING DCA + DTP + TALLY PRIME WITH CERTIFIED', NULL, 'ADVANCED', 'active', '2025-12-28 15:21:03', '2025-12-28 17:28:43'),
(4, 'FOI04', 'FUNDAMENTAL OF INTERNET', 2, 1999.00, 2999.00, 1999.00, 'FUNDAMENTAL, GAMIL, MAIL SEN Etc\r\n', NULL, 'Basic', 'active', '2025-12-28 17:26:36', '2025-12-28 17:26:36'),
(5, 'TC05', 'TYPING COURSE', 2, 2000.00, 3000.00, 2000.00, 'TYPING THIS COURSE YOU TO FAST YOUR TYPING SPEED WITH PLAYING GAME YOU CAN SPPED UP YOUR SPPED BY 25 to 40 WPM', NULL, 'TYPING', 'active', '2025-12-28 18:39:02', '2025-12-28 18:39:02');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(10) UNSIGNED NOT NULL,
  `exam_name` varchar(200) NOT NULL,
  `exam_code` varchar(50) DEFAULT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `batch_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_date` date NOT NULL,
  `exam_time` time DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'Duration in minutes',
  `total_marks` int(11) NOT NULL,
  `pass_marks` int(11) NOT NULL,
  `instructions` text DEFAULT NULL,
  `status` enum('scheduled','ongoing','completed','cancelled') DEFAULT 'scheduled',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `exam_name`, `exam_code`, `course_id`, `batch_id`, `exam_date`, `exam_time`, `duration`, `total_marks`, `pass_marks`, `instructions`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'DCA FINAL', 'EX-20251228-170847', 2, 1, '2025-12-28', '21:40:00', 60, 100, 40, NULL, 'completed', 13, '2025-12-28 16:08:47', '2025-12-28 16:10:34'),
(2, 'ADCA final', 'EX-20251228-195728', 3, 2, '2025-12-30', '12:12:00', 60, 100, 40, NULL, 'completed', 13, '2025-12-28 18:57:28', '2025-12-28 19:40:08');

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` int(10) UNSIGNED NOT NULL,
  `exam_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `roll_number` varchar(50) DEFAULT NULL,
  `marks_obtained` decimal(5,2) NOT NULL,
  `grade` varchar(5) DEFAULT NULL,
  `percentage` decimal(5,2) DEFAULT NULL,
  `status` enum('pass','fail','absent') NOT NULL,
  `remarks` text DEFAULT NULL,
  `result_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`id`, `exam_id`, `student_id`, `roll_number`, `marks_obtained`, `grade`, `percentage`, `status`, `remarks`, `result_date`, `created_at`, `updated_at`) VALUES
(1, 1, 4, NULL, 50.00, NULL, NULL, 'pass', 'nice', '2025-12-28', '2025-12-28 16:10:24', '2025-12-28 16:10:24'),
(2, 2, 5, NULL, 60.00, NULL, NULL, 'pass', '', '2025-12-28', '2025-12-28 18:58:06', '2025-12-28 18:58:06'),
(3, 2, 6, NULL, 70.00, NULL, NULL, 'pass', '', '2025-12-28', '2025-12-28 18:58:47', '2025-12-28 18:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `total_fee` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `paid_amount` decimal(10,2) DEFAULT 0.00,
  `due_amount` decimal(10,2) NOT NULL,
  `payment_mode` enum('one-time','installment') DEFAULT 'one-time',
  `installments` int(11) DEFAULT 1,
  `status` enum('paid','partial','due','overdue') DEFAULT 'due',
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `student_id`, `course_id`, `total_fee`, `discount_amount`, `paid_amount`, `due_amount`, `payment_mode`, `installments`, `status`, `due_date`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 5499.00, 0.00, 5499.00, 0.00, 'one-time', 1, 'paid', '2026-01-27', '2025-12-28 15:33:43', '2025-12-28 16:01:23'),
(2, 5, 3, 7499.00, 2000.00, 5499.00, 0.00, 'one-time', 1, 'paid', '2026-01-27', '2025-12-28 15:36:28', '2025-12-28 16:31:32'),
(3, 6, 3, 7499.00, 499.00, 5000.00, 2000.00, 'one-time', 1, 'partial', '2026-01-27', '2025-12-28 16:39:12', '2025-12-28 16:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `franchises`
--

CREATE TABLE `franchises` (
  `id` int(10) UNSIGNED NOT NULL,
  `franchise_code` varchar(20) NOT NULL,
  `franchise_name` varchar(200) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `commission_rate` decimal(5,2) DEFAULT 10.00 COMMENT 'Commission percentage',
  `status` enum('active','inactive','pending') DEFAULT 'pending',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'Franchise admin user ID',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `franchises`
--

INSERT INTO `franchises` (`id`, `franchise_code`, `franchise_name`, `owner_name`, `email`, `phone`, `address`, `city`, `state`, `pincode`, `commission_rate`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(7, 'FR20250001', 'Er Kumar Anup (RTPARK)', 'Er Kumar Anup', 'anupkmr66@gmail.com', '07004959254', 'Ormanjhi', 'Ranchi', 'Jharkhand', '835219', 30.00, 'active', 9, '2025-12-28 13:41:25', '2025-12-28 14:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `franchise_certificates`
--

CREATE TABLE `franchise_certificates` (
  `id` int(10) UNSIGNED NOT NULL,
  `certificate_number` varchar(50) NOT NULL,
  `franchise_id` int(10) UNSIGNED NOT NULL,
  `issue_date` date NOT NULL,
  `status` enum('active','revoked') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `franchise_certificates`
--

INSERT INTO `franchise_certificates` (`id`, `certificate_number`, `franchise_id`, `issue_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'FC-2025-0007', 7, '2025-12-28', 'active', '2025-12-28 19:13:17', '2025-12-28 19:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `franchise_inquiries`
--

CREATE TABLE `franchise_inquiries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','contacted','converted','rejected') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `franchise_inquiries`
--

INSERT INTO `franchise_inquiries` (`id`, `name`, `email`, `phone`, `city`, `state`, `message`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Er Kumar Anup', 'anupkmr66@gmail.com', '07004959254', 'Ranchi', 'Jharkhand', 'Graduation with Capability of minimum Investment', 'converted', '2025-12-28 12:18:08', '2025-12-28 13:41:25'),
(3, 'Rahul Kumar ', 'rahulips@gmail.com', '8789369010', 'Hazaribag', 'Jharkhand', 'MSC IN ELECTRONIC i have own infracture to start the institute ', 'new', '2025-12-28 12:33:31', '2025-12-28 12:33:31');

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `id` int(10) UNSIGNED NOT NULL,
  `franchise_id` int(10) UNSIGNED NOT NULL,
  `institute_code` varchar(20) NOT NULL,
  `institute_name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `contact_person` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `user_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Institute admin user ID',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `franchise_id`, `institute_code`, `institute_name`, `address`, `city`, `state`, `pincode`, `contact_person`, `phone`, `email`, `logo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 7, 'INS20250001', 'Skill-Up Center', 'Ranchi', 'ranchi', 'Jharkhand', '835219', 'Er Kumar Anup', '07004959254', 'anupkmr66@gmail.com', NULL, 'active', 9, '2025-12-28 14:29:54', '2025-12-28 14:29:54'),
(3, 7, 'INS20250002', 'Skill-Up Center Gagari', 'ranchi\r\nranchi', 'ranchi', 'Jharkhand', '835219', 'Pankaj Bediya', '07004959254', 'pankajmj79@gmail.com', NULL, 'active', 12, '2025-12-28 14:45:00', '2025-12-28 14:45:00'),
(4, 7, 'INS20250003', 'Skill-Up Center Dahu', 'Hesatu', 'Ranchi', 'Jharkhand', '835219', 'Er. Kumar Anup', '07004959254', 'testdemomailrnc@gmail.com', NULL, 'active', 13, '2025-12-28 14:52:23', '2025-12-28 15:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','contacted','enrolled','closed') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `course_id`, `name`, `email`, `phone`, `city`, `education`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Er Kumar Anup', 'sawef25437@calorpg.com', '+917004959254', '', 'School Student', 'Interested in course', 'new', '2025-12-28 18:49:52', '2025-12-28 18:49:52');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','success','warning','error') DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `receipt_number` varchar(50) NOT NULL,
  `fee_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','online','cheque','card') DEFAULT 'cash',
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `received_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'User ID who received payment',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `receipt_number`, `fee_id`, `student_id`, `amount`, `payment_method`, `transaction_id`, `payment_date`, `received_by`, `notes`, `created_at`) VALUES
(1, 'REC2025000001', 1, 4, 2000.00, 'cash', '', '2025-12-28', NULL, NULL, '2025-12-28 15:38:29'),
(2, 'REC2025000002', 1, 4, 1000.00, 'cash', '', '2025-12-28', NULL, NULL, '2025-12-28 15:46:05'),
(3, 'REC2025000003', 1, 4, 2499.00, 'cash', '', '2025-12-28', NULL, NULL, '2025-12-28 16:01:23'),
(4, 'REC2025000004', 2, 5, 5000.00, '', '', '2025-12-28', NULL, NULL, '2025-12-28 16:26:52'),
(5, 'REC2025000005', 2, 5, 499.00, 'cash', '', '2025-12-28', NULL, NULL, '2025-12-28 16:31:32'),
(6, 'REC2025000006', 3, 6, 5000.00, 'cash', '', '2025-12-28', NULL, NULL, '2025-12-28 16:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `display_name`, `permissions`, `created_at`) VALUES
(1, 'super_admin', 'Super Administrator', '[\"all\"]', '2025-12-28 11:45:12'),
(2, 'franchise_admin', 'Franchise Administrator', '[\"manage_institutes\", \"view_students\", \"manage_wallet\", \"view_reports\"]', '2025-12-28 11:45:12'),
(3, 'institute_admin', 'Institute Administrator', '[\"manage_students\", \"manage_fees\", \"manage_exams\", \"view_reports\"]', '2025-12-28 11:45:12'),
(4, 'teacher', 'Teacher/Staff', '[\"view_students\", \"mark_attendance\", \"upload_materials\", \"enter_marks\"]', '2025-12-28 11:45:12'),
(5, 'student', 'Student', '[\"view_profile\", \"view_fees\", \"view_results\", \"view_materials\"]', '2025-12-28 11:45:12');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(50) DEFAULT 'text',
  `description` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'Student login user ID',
  `institute_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `dob` date NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `guardian_name` varchar(100) NOT NULL,
  `guardian_phone` varchar(20) NOT NULL,
  `guardian_relation` varchar(50) DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `status` enum('active','inactive','completed','dropped') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `user_id`, `institute_id`, `first_name`, `last_name`, `email`, `phone`, `gender`, `dob`, `photo`, `address`, `city`, `state`, `pincode`, `guardian_name`, `guardian_phone`, `guardian_relation`, `enrollment_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'STU20250001', 10, 2, 'Kumari', 'Puja', 'kp94041@gmail.com', '9155055945', 'female', '1993-01-16', '69513f4484989_1766932292.jpg', 'Doranda', NULL, NULL, NULL, 'Newas Prasad Gupta', '9155055945', NULL, '2025-12-28', 'active', '2025-12-28 14:31:32', '2025-12-28 14:31:32'),
(2, 'STU20250002', 11, 2, 'Kumari', 'Kiran', 'kirandoranda@gmail.com', '8434939308', 'female', '1996-02-02', '69513f9c4ea0b_1766932380.jpg', 'Manitola Doranda', NULL, NULL, NULL, 'Newas Prasad Gupta', '8434939308', NULL, '2025-12-28', 'active', '2025-12-28 14:33:00', '2025-12-28 14:33:00'),
(4, 'STU20250003', 16, 4, 'SHREYA', 'KUMARI', 'siya@gmail.com', '07004959254', 'female', '2006-05-02', NULL, 'BASATI', NULL, NULL, NULL, 'Jay Prakash Sahu', '7004959254', NULL, '2025-12-28', 'active', '2025-12-28 15:33:43', '2025-12-28 15:33:43'),
(5, 'STU20250004', 17, 4, 'ROZINA ', 'PRAVEEN', 'roshonipraveen@gmail.com', '7004959254', 'female', '2007-02-02', NULL, 'RIGATOLI', NULL, NULL, NULL, 'BASARAIT ANASARI', '7004959254', NULL, '2025-12-28', 'active', '2025-12-28 15:36:28', '2025-12-28 15:36:28'),
(6, 'STU20250005', 18, 4, 'Neha', 'Kumari', 'neha123@gmail.com', '4554454545', 'female', '2007-10-10', '69515d3095210_1766939952.jpg', 'hinno', NULL, NULL, NULL, 'Newas Gupta', '7004959254', NULL, '2025-12-28', 'active', '2025-12-28 16:39:12', '2025-12-28 16:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `student_courses`
--

CREATE TABLE `student_courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `batch_id` int(10) UNSIGNED DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `status` enum('enrolled','ongoing','completed','dropped') DEFAULT 'enrolled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_courses`
--

INSERT INTO `student_courses` (`id`, `student_id`, `course_id`, `batch_id`, `enrollment_date`, `completion_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 1, '2025-12-28', NULL, 'ongoing', '2025-12-28 15:33:43', '2025-12-28 15:33:43'),
(2, 5, 3, 2, '2025-12-28', NULL, 'ongoing', '2025-12-28 15:36:28', '2025-12-28 15:36:28'),
(3, 6, 3, 2, '2025-12-28', NULL, 'ongoing', '2025-12-28 16:39:12', '2025-12-28 16:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `study_materials`
--

CREATE TABLE `study_materials` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `batch_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `file_type` enum('pdf','video','document','link','other') NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL COMMENT 'File size in bytes',
  `file_url` varchar(500) DEFAULT NULL COMMENT 'External URL if applicable',
  `is_public` tinyint(1) DEFAULT 0 COMMENT 'Public or restricted',
  `uploaded_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `study_materials`
--

INSERT INTO `study_materials` (`id`, `course_id`, `batch_id`, `title`, `description`, `file_type`, `file_path`, `file_size`, `file_url`, `is_public`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'wordpad', 'compete wordpd notes', 'pdf', '6952162152ca6_1766987297.pdf', NULL, NULL, 0, 20, '2025-12-29 05:48:17', '2025-12-29 05:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `institute_id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `experience` varchar(50) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `institute_id`, `first_name`, `last_name`, `phone`, `qualification`, `experience`, `specialization`, `status`, `created_at`, `updated_at`) VALUES
(1, 20, 4, 'INDU', 'DEVI', '07004959254', 'graduation', '5', 'C, C++,JAVA', 'active', '2025-12-29 05:29:55', '2025-12-29 05:29:55'),
(2, 21, 4, 'Tanveer ', 'Ahmad', '07004959254', 'graduation', '5', 'C, C++,JAVA', 'active', '2025-12-29 05:30:32', '2025-12-29 05:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires_at` datetime DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `reset_token`, `reset_expires_at`, `username`, `email`, `password_hash`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 'admin', 'admin@skillup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active', NULL, '2025-12-28 11:45:12', '2025-12-28 11:45:12'),
(9, 2, NULL, NULL, 'skillup-ranchi600', 'anupkmr66@gmail.com', '$2y$10$vaACUWAgOxH8fHDBxVOWaORPiNDbLuwH7clvP0XMbLg0d1v.Zd6f6', 'active', NULL, '2025-12-28 13:41:25', '2025-12-28 09:49:33'),
(10, 5, NULL, NULL, 'kumari_0001', 'kp94041@gmail.com', '$2y$10$CN3QGgY2uHcwMpFCsqqd/eQg4r0oADJ97MMsSxs3ApVSWmJM3oG.e', 'active', NULL, '2025-12-28 14:31:32', '2025-12-28 14:31:32'),
(11, 5, NULL, NULL, 'kumari_0002', 'kirandoranda@gmail.com', '$2y$10$N0wDkY5DWAQbiaHyYs7FKeInO5ubH.BsNQ6pNHKo/aHrfsfTzogDe', 'active', NULL, '2025-12-28 14:33:00', '2025-12-28 14:33:00'),
(12, 3, NULL, NULL, 'pankajmj79@gmail.com', 'pankajmj79@gmail.com', '$2y$10$Eshpx1qR02abD.gnnwUzDeQEYVxO6dl9VRn7dVmC6B1PlkkqFTKWe', 'active', NULL, '2025-12-28 10:15:00', '2025-12-28 10:15:00'),
(13, 3, NULL, NULL, 'testdemomailrnc@gmail.com', 'testdemomailrnc@gmail.com', '$2y$10$d99AAZYqToMeC4SnFnvNxeUF8evcIAj6yPrY4gKx3itNXM88Tlpai', 'active', NULL, '2025-12-28 10:22:23', '2025-12-28 10:22:23'),
(16, 5, NULL, NULL, 'shreya_0003', 'siya@gmail.com', '$2y$10$0oTWMT4LpW/YXOR0PhODh.vAkTzSTtAaqI8N93X3HxUNshgfa5/Hq', 'active', NULL, '2025-12-28 15:33:43', '2025-12-28 15:33:43'),
(17, 5, NULL, NULL, 'rozina _0004', 'roshonipraveen@gmail.com', '$2y$10$UCNZ4FL/LyWg.914Hwpr7OSv8QdL31g84HbH704AKvt7K18nUL8K.', 'active', NULL, '2025-12-28 15:36:28', '2025-12-28 15:36:28'),
(18, 5, NULL, NULL, 'neha_0005', 'neha123@gmail.com', '$2y$10$dLiSqPgnb9hRLD1X9t4Ke.sD61qESkHEagfdgR9f71ragTyB6n/v.', 'active', NULL, '2025-12-28 16:39:12', '2025-12-28 16:39:12'),
(20, 4, NULL, NULL, 'indu.devi', 'indudevi@gmail.com', '$2y$10$YkKLhIE4xYMGcOUz.MnMNuuB74h4aHDce67bC7YUw4YF7zDX9QD0m', 'active', NULL, '2025-12-29 05:29:55', '2025-12-29 05:34:21'),
(21, 4, NULL, NULL, 'tanveer .ahmad', 'mallictreders@gmil.com', '$2y$10$rZF5uZcECWRDl6DhOYXpqORod7ciW6LUlh3XTjjvRGIm0Ewy2Gc0K', 'active', NULL, '2025-12-29 05:30:32', '2025-12-29 05:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(10) UNSIGNED NOT NULL,
  `franchise_id` int(10) UNSIGNED NOT NULL,
  `balance` decimal(12,2) DEFAULT 0.00,
  `total_earned` decimal(12,2) DEFAULT 0.00,
  `total_withdrawn` decimal(12,2) DEFAULT 0.00,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `franchise_id`, `balance`, `total_earned`, `total_withdrawn`, `updated_at`) VALUES
(7, 7, 0.00, 0.00, 0.00, '2025-12-28 13:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `wallet_id` int(10) UNSIGNED NOT NULL,
  `transaction_type` enum('credit','debit') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `reference_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Payment/withdrawal ID',
  `reference_type` varchar(50) DEFAULT NULL COMMENT 'payment, withdrawal, etc.',
  `status` enum('pending','completed','rejected') DEFAULT 'completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_requests`
--

CREATE TABLE `withdrawal_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `franchise_id` int(10) UNSIGNED NOT NULL,
  `wallet_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `account_holder` varchar(100) DEFAULT NULL,
  `status` enum('pending','approved','rejected','processed') DEFAULT 'pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'Admin who processed',
  `processed_date` timestamp NULL DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_module` (`module`),
  ADD KEY `idx_date` (`created_at`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_date` (`student_id`,`batch_id`,`attendance_date`),
  ADD KEY `marked_by` (`marked_by`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_batch` (`batch_id`),
  ADD KEY `idx_date` (`attendance_date`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `idx_course` (`course_id`),
  ADD KEY `idx_institute` (`institute_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_number` (`certificate_number`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `issued_by` (`issued_by`),
  ADD KEY `idx_certificate_number` (`certificate_number`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_qr` (`qr_code`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_date` (`created_at`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD KEY `idx_course_code` (`course_code`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_code` (`exam_code`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_course` (`course_id`),
  ADD KEY `idx_exam_date` (`exam_date`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_exam_student` (`exam_id`,`student_id`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `franchises`
--
ALTER TABLE `franchises`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `franchise_code` (`franchise_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_franchise_code` (`franchise_code`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `franchise_certificates`
--
ALTER TABLE `franchise_certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_number` (`certificate_number`),
  ADD KEY `idx_certificate_number` (`certificate_number`),
  ADD KEY `idx_franchise` (`franchise_id`);

--
-- Indexes for table `franchise_inquiries`
--
ALTER TABLE `franchise_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_date` (`created_at`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `institute_code` (`institute_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_franchise` (`franchise_id`),
  ADD KEY `idx_institute_code` (`institute_code`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_read` (`is_read`),
  ADD KEY `idx_date` (`created_at`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receipt_number` (`receipt_number`),
  ADD KEY `fee_id` (`fee_id`),
  ADD KEY `received_by` (`received_by`),
  ADD KEY `idx_receipt` (`receipt_number`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_payment_date` (`payment_date`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_student_id` (`student_id`),
  ADD KEY `idx_institute` (`institute_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_course` (`course_id`),
  ADD KEY `idx_batch` (`batch_id`);

--
-- Indexes for table `study_materials`
--
ALTER TABLE `study_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `idx_course` (`course_id`),
  ADD KEY `idx_batch` (`batch_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `institute_id` (`institute_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `franchise_id` (`franchise_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_wallet` (`wallet_id`),
  ADD KEY `idx_type` (`transaction_type`),
  ADD KEY `idx_date` (`created_at`);

--
-- Indexes for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_id` (`wallet_id`),
  ADD KEY `processed_by` (`processed_by`),
  ADD KEY `idx_franchise` (`franchise_id`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `franchises`
--
ALTER TABLE `franchises`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `franchise_certificates`
--
ALTER TABLE `franchise_certificates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `franchise_inquiries`
--
ALTER TABLE `franchise_inquiries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_courses`
--
ALTER TABLE `student_courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `study_materials`
--
ALTER TABLE `study_materials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`marked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `batches_ibfk_2` FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `batches_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `certificates_ibfk_3` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exams_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_results_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `franchises`
--
ALTER TABLE `franchises`
  ADD CONSTRAINT `franchises_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `franchise_certificates`
--
ALTER TABLE `franchise_certificates`
  ADD CONSTRAINT `franchise_certificates_ibfk_1` FOREIGN KEY (`franchise_id`) REFERENCES `franchises` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `institutes`
--
ALTER TABLE `institutes`
  ADD CONSTRAINT `institutes_ibfk_1` FOREIGN KEY (`franchise_id`) REFERENCES `franchises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `institutes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`fee_id`) REFERENCES `fees` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`);

--
-- Constraints for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD CONSTRAINT `student_courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `student_courses_ibfk_3` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `study_materials`
--
ALTER TABLE `study_materials`
  ADD CONSTRAINT `study_materials_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `study_materials_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `study_materials_ibfk_3` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teachers_ibfk_2` FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`franchise_id`) REFERENCES `franchises` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  ADD CONSTRAINT `withdrawal_requests_ibfk_1` FOREIGN KEY (`franchise_id`) REFERENCES `franchises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `withdrawal_requests_ibfk_2` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `withdrawal_requests_ibfk_3` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
