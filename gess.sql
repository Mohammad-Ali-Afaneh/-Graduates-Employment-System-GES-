-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 10:44 PM
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
-- Database: `gess`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `email`, `password`, `location`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'amazon', 'amazon@gmail.com', '$2y$12$twX86MW5OxIE0EpIvqOwtulOYBsEJ8PeukdmEAF0eJX59xy7BZA8K', 'عمان', '0799999999', '2025-05-14 10:56:25', '2025-05-14 10:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `gender` enum('Male','Female','غير محدد') NOT NULL,
  `course` varchar(255) NOT NULL,
  `hiring` enum('On','Off') NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `response` enum('accepted','rejected','pending') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `specialization`, `gender`, `course`, `hiring`, `company_id`, `student_id`, `response`, `created_at`, `updated_at`) VALUES
(4, 'تم اختياره من قبل الشركة', 'Male', 'غير محدد', 'On', 1, 6, 'pending', '2025-05-17 15:00:33', '2025-05-17 15:00:33');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_04_26_014248_create_admin_table', 1),
(4, '2025_04_26_014336_create_students_table', 1),
(5, '2025_04_26_033655_add_password_to_students_table', 1),
(6, '2025_04_26_211209_create_company_table', 1),
(7, '2025_04_27_183236_create_specializations_table', 1),
(8, '2025_04_27_184605_create_job_applications_table', 1),
(9, '2025_04_27_194801_reset_specializations_table', 1),
(10, '2025_04_27_200955_modify_students_table_remove_grade_add_score', 1),
(11, '2025_04_27_202438_add_specialization_to_students_table', 1),
(12, '2025_04_27_204832_add_programming_languages_to_students_table', 1),
(13, '2025_04_27_211704_add_grade_to_students_table', 1),
(14, '2025_04_29_201240_create_notifications_table', 1),
(15, '2025_04_29_222343_add_foreign_keys_to_notifications', 1),
(16, '2025_04_29_235318_add_phone_to_company_table', 1),
(17, '2025_04_29_235434_add_interview_details_to_notifications_table', 1),
(18, '2025_04_30_000032_add_student_id_to_job_applications_table', 1),
(19, '2025_04_30_002751_modify_gender_column_in_job_applications_table', 1),
(20, '2025_05_05_221228_create_student_programming_languages_table', 1),
(21, '2025_05_09_202747_add_is_read_to_notifications_table', 1),
(22, '2025_05_09_205450_add_response_to_job_applications_table', 1),
(23, '2025_05_10_144923_add_location_to_students_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `interview_details` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `student_id`, `company_id`, `message`, `interview_details`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 13, 1, 'تم إرسال طلب لك من شركة amazon للتوظيف!\nيمكنك التواصل مع الشركة عبر:\nرقم الهاتف: 0799999999\nالبريد الإلكتروني: amazon@gmail.com\nتفاصيل المقابلة: مطلوب لوظيفة عمل في شركة امازون', NULL, 1, '2025-05-14 19:00:21', '2025-05-14 19:01:18'),
(3, 6, 1, 'تم إرسال طلب لك من شركة amazon للتوظيف!\nيمكنك التواصل مع الشركة عبر:\nرقم الهاتف: 0799999999\nالبريد الإلكتروني: amazon@gmail.com\nتفاصيل المقابلة: jgsjdgjkshdlkjdhsd', NULL, 1, '2025-05-15 03:45:44', '2025-05-15 03:46:21'),
(4, 6, 1, 'تم إرسال طلب لك من شركة amazon للتوظيف!\nيمكنك التواصل مع الشركة عبر:\nرقم الهاتف: 0799999999\nالبريد الإلكتروني: amazon@gmail.com\nتفاصيل المقابلة: jhfgjhgjhgklghjhglgg', NULL, 0, '2025-05-17 15:00:33', '2025-05-17 15:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('specialization','programming_language') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `programming_languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`programming_languages`)),
  `score` double NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `password`, `phone`, `location`, `gender`, `specialization`, `programming_languages`, `score`, `grade`, `cv_path`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'أحمد محمد', 'ahmed@example.com', '$2y$12$7MJFkk6ojOb43/saUUYpHOU31kpaHsYf7a6tAp6lqLKVCTRBSaL12', '1234567890', 'عمان', 'ذكر', 'هندسة البرمجيات', NULL, 85.5, 'جيد جدًا', 'cvs/ahmed_cv.pdf', NULL, '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(2, 'خالد عبدالله', 'khalid@example.com', '$2y$12$Px9EP.j4Yh9rgauJWWOGje4sIa1mam37iNipXLSl9c1cIiH8W6E8S', '0987654321', 'إربد', 'ذكر', 'علوم الحاسوب', NULL, 90, 'ممتاز', 'cvs/khalid_cv.pdf', NULL, '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(3, 'ليان أحمد', 'layan@example.com', '$2y$12$IvvCXTXWt82Qe.KtrKbpeuKot7t12RpBYkb.6Dz6NAis8Gs1rOaCS', '1122334455', 'الزرقاء', 'أنثى', 'هندسة البرمجيات', NULL, 78, 'جيد', 'cvs/layan_cv.pdf', NULL, '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(4, 'سارة خالد', 'sarah@example.com', '$2y$12$0EHlAW9A85/oJytB49crwuSbzXHsNoqJTBRhxJfz2io6.IRjyhWWK', '5566778899', 'العقبة', 'أنثى', 'الأمن السيبراني', NULL, 92.5, 'ممتاز', 'cvs/sarah_cv.pdf', NULL, '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(5, 'يوسف علي', 'yousef@example.com', '$2y$12$NvdybBMBFS5CA.HRguBmKOOJShVUMfkp31hNA1rw7f2CGy6fF4H0a', '6677889900', 'الكرك', 'ذكر', 'تحليل البيانات', NULL, 88, 'جيد جدًا', 'cvs/yousef_cv.pdf', NULL, '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(6, 'مالك عيسى توفيق الجنيدي', 'malikIssa123@gmail.com', '$2y$12$fWw0PkRvPpnyUJPVZrQI5.W4jc7rDRzk3zHM8tH.iCLObxpVVBhsO', '0799999999', 'عمان', 'ذكر', 'علوم الحاسوب', '[\"C++\",\"C#\",\"Go\",\"Elixir\",\"F#\",\"Bash\"]', 70, 'جيد', 'cvs/50SLzCrDOPFJ97QGKeQ9jAzE0IhO9N0nySvxk7tU.pdf', NULL, '2025-05-14 10:55:14', '2025-05-15 15:09:51'),
(7, 'راما محمد', 'ramamohammad123@gmail.com', '$2y$12$l0va4sPvfRKbanxTAB3dA.3awQjDLUFTphcK8FYyFKphBlRhDW4Tu', '0799999999', 'إربد', 'أنثى', 'علوم الحاسوب', '[\"JavaScript\",\"C++\",\"Go\",\"Dart\",\"Elixir\"]', 90, 'ممتاز', NULL, NULL, '2025-05-14 14:54:06', '2025-05-14 14:54:06'),
(8, 'علي محمد الباشا', 'Alimohammad123@gmail.com', '$2y$12$sf2qrfsUzXf7oELGsJ7m6.4YRL2SJFpMQ6DfaZdFquyXKI5xsRnL.', '0798729498', 'الزرقاء', 'ذكر', 'علوم الحاسوب', '[\"C++\",\"C#\",\"Dart\",\"Elixir\",\"Julia\"]', 70, 'جيد', NULL, NULL, '2025-05-14 14:55:08', '2025-05-14 14:55:08'),
(9, 'رنا سامي', 'ranasami123@gmail.com', '$2y$12$alSpXfb3YTrHxCX/1FHhyORcEbcO8Qfqcl/DjwUAhSZmqs8VWHfOe', '0798729498', 'البلقاء', 'أنثى', 'علوم الحاسوب', '[\"Java\",\"JavaScript\",\"C#\",\"Go\",\"Dart\"]', 60, 'مقبول', NULL, NULL, '2025-05-14 14:56:13', '2025-05-14 14:56:13'),
(10, 'ريمي حسن', 'remihassn123@gmail.com', '$2y$12$BcSBQ9Lri5ZXD3UP0dJfdeRezddsscBUHL57bvaMXVPYAVWQchT16', '0785412365', 'الكرك', 'أنثى', 'علوم الحاسوب', '[\"C++\",\"Dart\",\"Elixir\",\"F#\"]', 50, 'راسب', NULL, NULL, '2025-05-14 14:57:28', '2025-05-14 14:57:28'),
(11, 'احمد عفانه', 'ahmadafaneh123@gmail.com', '$2y$12$c3B0pMMpFj81wSdA9OalJONWfq8RxjtEn.RS1ZfkQrQHhvsKTfUkC', '0788945612', 'معان', 'ذكر', 'علوم الحاسوب', '[\"Java\",\"JavaScript\",\"C++\",\"C#\",\"Julia\"]', 70, 'جيد', NULL, NULL, '2025-05-14 14:58:37', '2025-05-14 14:58:37'),
(12, 'رند علي', 'randali123@gmail.com', '$2y$12$ur1DQOZo5kgw..91Tft1NeYSeqMhq8atG2eEXvWbPu6wKIDbn8y02', '0788945612', 'الطفيلة', 'أنثى', 'علوم الحاسوب', '[\"C++\",\"Go\",\"Kotlin\",\"Julia\"]', 65, 'مقبول', NULL, NULL, '2025-05-14 14:59:43', '2025-05-14 14:59:43'),
(13, 'محمد ماهر عفانه', 'mohammadafaneh123@gmail.com', '$2y$12$XhjCODRKBW4XCtgokjC/eOjT2V1Fpf5znVbaLuXfEQnxAzlw6RrEe', '0785412365', 'العقبة', 'ذكر', 'علوم الحاسوب', '[\"C++\",\"C#\",\"Go\",\"Elixir\",\"F#\"]', 90, 'ممتاز', NULL, NULL, '2025-05-14 15:01:16', '2025-05-14 15:01:16'),
(14, 'محمود علي', 'mahmuodali123@gmail.com', '$2y$12$vGIcY27KpPnDo7gcWegIZek/5aJRVDCYfNd8h.6fkSywdnGYd4ir6', '0788567032', 'جرش', 'ذكر', 'علوم الحاسوب', '[\"Java\",\"JavaScript\",\"C++\",\"Go\",\"F#\"]', 85, 'جيد جدًا', NULL, NULL, '2025-05-14 15:02:46', '2025-05-14 15:02:46'),
(15, 'لينا زيد', 'lenazaid123@gmail.com', '$2y$12$Q6XdUEPfXMKVdO.78u/6DeLGkC.bidwgg4QU1.SE4cbp0bVEajzI2', '0788945612', 'عجلون', 'أنثى', 'علوم الحاسوب', '[\"Java\",\"JavaScript\",\"C++\",\"F#\",\"Julia\"]', 89, 'جيد جدًا', NULL, NULL, '2025-05-14 15:04:46', '2025-05-14 15:04:46'),
(16, 'علي ماهر عفانه', 'Aliafaneh123@gmail.com', '$2y$12$dsMh3Pql6oDzOcRnqMKL4.Y4E.8Qt2lzJ.mAs8qaOiOfE0FTXVHYe', '0788567032', 'مادبا', 'ذكر', 'علوم الحاسوب', '[\"JavaScript\",\"C++\",\"Go\",\"Dart\",\"Elixir\"]', 96, 'ممتاز', NULL, NULL, '2025-05-14 15:07:13', '2025-05-14 15:07:13'),
(17, 'طارق زيد', 'tareqzaid123@gmail.com', '$2y$12$iHrfdU6E4r9rYPxz.Wfy4OLA.0D818ruRMQ6lRenezEX4Mz1BioVK', '0788945612', 'المفرق', 'ذكر', 'علوم الحاسوب', '[\"C++\",\"C#\",\"Dart\",\"C\",\"F#\"]', 91, 'ممتاز', NULL, NULL, '2025-05-14 15:08:57', '2025-05-14 15:08:57'),
(29, 'خالد عوض', 'khaled31123@gmail.com', '$2y$12$pYx.mQ8ONUouIhYuNpuW1OO71QsOcYe8oyo6ylUVQ..IZdJrerelu', '0788567032', 'عمان', 'ذكر', 'علوم الحاسوب', '[\"Java\",\"C++\",\"C#\",\"Dart\"]', 85, 'جيد جدًا', NULL, NULL, '2025-05-14 17:31:55', '2025-05-14 18:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `student_programming_languages`
--

CREATE TABLE `student_programming_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `programming_language` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_programming_languages`
--

INSERT INTO `student_programming_languages` (`id`, `student_id`, `programming_language`, `created_at`, `updated_at`) VALUES
(1, 1, 'Python', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(2, 1, 'Java', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(3, 2, 'JavaScript', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(4, 2, 'C++', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(5, 3, 'Python', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(6, 3, 'JavaScript', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(7, 4, 'JavaScript', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(8, 4, 'C++', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(9, 5, 'Python', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(10, 5, 'Java', '2025-05-14 10:49:12', '2025-05-14 10:49:12'),
(11, 5, 'JavaScript', '2025-05-14 10:49:12', '2025-05-14 10:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_user_name_unique` (`user_name`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_company_name_unique` (`company_name`),
  ADD UNIQUE KEY `company_email_unique` (`email`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_company_id_foreign` (`company_id`),
  ADD KEY `job_applications_student_id_foreign` (`student_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_student_id_foreign` (`student_id`),
  ADD KEY `notifications_company_id_foreign` (`company_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `specializations_name_unique` (`name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`);

--
-- Indexes for table `student_programming_languages`
--
ALTER TABLE `student_programming_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_programming_languages_student_id_foreign` (`student_id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `student_programming_languages`
--
ALTER TABLE `student_programming_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_programming_languages`
--
ALTER TABLE `student_programming_languages`
  ADD CONSTRAINT `student_programming_languages_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
