-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for smartsip_db
CREATE DATABASE IF NOT EXISTS `smartsip_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `smartsip_db`;

-- Dumping structure for table smartsip_db.beverages
CREATE TABLE IF NOT EXISTS `beverages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sugar_per_100ml` decimal(5,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `beverages_category_id_foreign` (`category_id`),
  CONSTRAINT `beverages_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `beverage_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.beverages: ~23 rows (approximately)
INSERT INTO `beverages` (`id`, `category_id`, `name`, `sugar_per_100ml`, `image_url`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Cola Kaleng', 10.60, '/images/beverages/cola.png', '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(2, 2, 'Brown Sugar Boba', 12.50, '/images/beverages/boba.png', '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(3, 3, 'Teh Kotak Sosro', 8.00, NULL, '2026-07-20 02:25:00', '2026-08-04 07:39:22'),
	(4, 3, 'Teh manis kemasan', 9.80, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(5, 3, 'Teh tarik', 11.20, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(6, 3, 'Thai tea', 13.50, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(7, 3, 'Matcha latte', 12.00, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(8, 4, 'Kopi susu', 12.40, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(9, 4, 'Cappuccino sachet', 10.50, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(10, 4, 'Es kopi gula aren', 12.40, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(11, 5, 'Boba', 14.20, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(12, 5, 'Bubble drink', 13.80, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(13, 5, 'Milkshake', 14.50, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(14, 5, 'Minuman jelly', 10.00, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(15, 6, 'Minuman soda', 10.60, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(16, 6, 'Minuman energi', 11.30, NULL, '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(17, 6, 'Minuman isotonik', 6.40, NULL, '2026-08-04 07:32:10', '2026-08-04 07:32:10'),
	(18, 7, 'Susu rasa coklat', 9.50, NULL, '2026-08-04 07:32:10', '2026-08-04 07:32:10'),
	(19, 7, 'Yogurt manis', 11.00, NULL, '2026-08-04 07:32:10', '2026-08-04 07:32:10'),
	(20, 7, 'Minuman coklat', 12.80, NULL, '2026-08-04 07:32:10', '2026-08-04 07:32:10'),
	(21, 8, 'Jus kemasan', 10.80, NULL, '2026-08-04 07:32:10', '2026-08-04 07:32:10'),
	(22, 8, 'Sirup', 15.00, NULL, '2026-08-04 07:32:10', '2026-08-04 07:32:10'),
	(23, 8, 'Minuman kemasan lainnya', 10.00, NULL, '2026-08-04 07:32:10', '2026-08-04 07:32:10');

-- Dumping structure for table smartsip_db.beverage_categories
CREATE TABLE IF NOT EXISTS `beverage_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.beverage_categories: ~8 rows (approximately)
INSERT INTO `beverage_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Minuman Bersoda', '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(2, 'Boba & Kopi Susu', '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(3, 'Teh & Olahan Teh', '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(4, 'Kopi & Olahan Kopi', '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(5, 'Boba & Minuman Kekinian', '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(6, 'Minuman Bersoda & Olahraga', '2026-08-04 07:32:09', '2026-08-04 07:32:09'),
	(7, 'Susu & Olahan Dairy', '2026-08-04 07:32:10', '2026-08-04 07:32:10'),
	(8, 'Jus, Sirup & Kemasan Lain', '2026-08-04 07:32:10', '2026-08-04 07:32:10');

-- Dumping structure for table smartsip_db.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.cache: ~0 rows (approximately)

-- Dumping structure for table smartsip_db.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.cache_locks: ~0 rows (approximately)

-- Dumping structure for table smartsip_db.challenges
CREATE TABLE IF NOT EXISTS `challenges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `reward_points` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.challenges: ~3 rows (approximately)
INSERT INTO `challenges` (`id`, `title`, `description`, `reward_points`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, '3 Hari Tanpa Soda', 'Jangan minum minuman bersoda selama 3 hari berturut-turut.', 50, 1, '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(2, 'Pejuang Air Putih', 'Ganti minuman manismu dengan air putih hari ini.', 20, 1, '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(3, '7 Hari Bebas Boba', 'Jangan minum boba selama seminggu', 100, 1, '2026-07-20 02:27:14', '2026-07-20 02:27:14');

-- Dumping structure for table smartsip_db.educations
CREATE TABLE IF NOT EXISTS `educations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('video','artikel','tips') COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.educations: ~3 rows (approximately)
INSERT INTO `educations` (`id`, `title`, `type`, `content`, `media_url`, `is_published`, `created_at`, `updated_at`) VALUES
	(1, 'Fakta Gula Tersembunyi pada Minuman Kekinian', 'artikel', 'Tahukah kamu? Segelas brown sugar boba bisa mengandung hingga 50-60 gram gula! Jumlah ini setara dengan dua kali lipat rekomendasi harian WHO untuk remaja. Gula berlebih yang masuk ke tubuh tidak langsung diubah menjadi energi, melainkan disimpan sebagai lemak. Dampak jangka panjangnya bisa memicu kegemukan (obesitas), kerusakan gigi, hingga diabetes tipe 2 di usia muda. Jadi, yuk mulai perhatikan apa yang kita teguk!', NULL, 1, '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(2, 'Kenapa Gula Bikin Ketagihan?', 'video', 'Sebuah video animasi singkat yang menjelaskan efek gula di otak kita. Ketika kita mengonsumsi gula, otak melepaskan hormon dopamin yang membuat kita merasa senang sementara waktu, sehingga memicu keinginan untuk minum manis lagi. Pelajari cara memutus lingkaran kecanduan ini dengan membatasi asupan harianmu!', 'https://www.youtube.com/watch?v=hBEAvorom88', 1, '2026-07-19 21:40:58', '2026-08-01 11:35:19'),
	(3, '3 Langkah Praktis Kurangi Boba & Kopi Susu', 'tips', '1. Kurangi level kemanisan (less sugar): Mulailah dengan meminta kadar gula 50% atau 25% saat memesan.\r\n2. Perkecil ukuran gelas (size down): Pilih ukuran small daripada large untuk memangkas asupan gula secara drastis.\r\n3. Atur jadwal khusus (cheat day): Batasi konsumsi minuman manis hanya 1 kali dalam seminggu sebagai reward.', 'https://www.youtube.com/watch?v=lWgMrh_Mxc0', 1, '2026-07-19 21:40:58', '2026-08-01 11:25:36');

-- Dumping structure for table smartsip_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table smartsip_db.ffq_responses
CREATE TABLE IF NOT EXISTS `ffq_responses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `phase` enum('T0','T1','T2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_data` json NOT NULL,
  `total_daily_sugar_grams` decimal(8,2) NOT NULL,
  `category` enum('Baik','Sedang','Tinggi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `answered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ffq_responses_student_id_foreign` (`student_id`),
  CONSTRAINT `ffq_responses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.ffq_responses: ~2 rows (approximately)
INSERT INTO `ffq_responses` (`id`, `student_id`, `phase`, `items_data`, `total_daily_sugar_grams`, `category`, `answered_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 'T0', '[{"name": "Teh manis kemasan", "freq_code": 1, "portion_ml": 500, "sugar_100ml": 9.8, "daily_sugar_grams": 10.5}, {"name": "Teh tarik", "freq_code": 2, "portion_ml": 500, "sugar_100ml": 11.2, "daily_sugar_grams": 28}, {"name": "Boba", "freq_code": 2, "portion_ml": 500, "sugar_100ml": 14.2, "daily_sugar_grams": 35.5}, {"name": "Kopi susu", "freq_code": 1, "portion_ml": 500, "sugar_100ml": 12.4, "daily_sugar_grams": 13.29}, {"name": "Cappuccino sachet", "freq_code": 2, "portion_ml": 500, "sugar_100ml": 10.5, "daily_sugar_grams": 26.25}, {"name": "Minuman soda", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 10.6, "daily_sugar_grams": 0}, {"name": "Minuman energi", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 11.3, "daily_sugar_grams": 0}, {"name": "Susu rasa coklat", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 9.5, "daily_sugar_grams": 0}, {"name": "Yogurt manis", "freq_code": 0, "portion_ml": 500, "sugar_100ml": 11, "daily_sugar_grams": 0}, {"name": "Jus kemasan", "freq_code": 1, "portion_ml": 500, "sugar_100ml": 10.8, "daily_sugar_grams": 11.57}, {"name": "Sirup", "freq_code": 3, "portion_ml": 250, "sugar_100ml": 15, "daily_sugar_grams": 29.46}, {"name": "Minuman isotonik", "freq_code": 1, "portion_ml": 250, "sugar_100ml": 6.4, "daily_sugar_grams": 3.43}, {"name": "Thai tea", "freq_code": 0, "portion_ml": 500, "sugar_100ml": 13.5, "daily_sugar_grams": 0}, {"name": "Matcha latte", "freq_code": 2, "portion_ml": 250, "sugar_100ml": 12, "daily_sugar_grams": 15}, {"name": "Milkshake", "freq_code": 1, "portion_ml": 250, "sugar_100ml": 14.5, "daily_sugar_grams": 7.77}, {"name": "Minuman coklat", "freq_code": 2, "portion_ml": 250, "sugar_100ml": 12.8, "daily_sugar_grams": 16}, {"name": "Es kopi gula aren", "freq_code": 2, "portion_ml": 250, "sugar_100ml": 12.4, "daily_sugar_grams": 15.5}, {"name": "Minuman jelly", "freq_code": 2, "portion_ml": 250, "sugar_100ml": 10, "daily_sugar_grams": 12.5}, {"name": "Bubble drink", "freq_code": 2, "portion_ml": 250, "sugar_100ml": 13.8, "daily_sugar_grams": 17.25}, {"name": "Minuman kemasan lainnya", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 10, "daily_sugar_grams": 0}]', 242.02, 'Tinggi', '2026-08-01 08:10:01', '2026-08-01 08:10:01', '2026-08-01 08:10:01'),
	(2, 2, 'T0', '[{"name": "Teh manis kemasan", "freq_code": 1, "portion_ml": 500, "sugar_100ml": 9.8, "daily_sugar_grams": 10.5}, {"name": "Teh tarik", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 11.2, "daily_sugar_grams": 0}, {"name": "Boba", "freq_code": 1, "portion_ml": 500, "sugar_100ml": 14.2, "daily_sugar_grams": 15.21}, {"name": "Kopi susu", "freq_code": 3, "portion_ml": 250, "sugar_100ml": 12.4, "daily_sugar_grams": 24.36}, {"name": "Cappuccino sachet", "freq_code": 1, "portion_ml": 250, "sugar_100ml": 10.5, "daily_sugar_grams": 5.63}, {"name": "Minuman soda", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 10.6, "daily_sugar_grams": 0}, {"name": "Minuman energi", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 11.3, "daily_sugar_grams": 0}, {"name": "Susu rasa coklat", "freq_code": 2, "portion_ml": 250, "sugar_100ml": 9.5, "daily_sugar_grams": 11.88}, {"name": "Yogurt manis", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 11, "daily_sugar_grams": 0}, {"name": "Jus kemasan", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 10.8, "daily_sugar_grams": 0}, {"name": "Sirup", "freq_code": 1, "portion_ml": 500, "sugar_100ml": 15, "daily_sugar_grams": 16.07}, {"name": "Minuman isotonik", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 6.4, "daily_sugar_grams": 0}, {"name": "Thai tea", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 13.5, "daily_sugar_grams": 0}, {"name": "Matcha latte", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 12, "daily_sugar_grams": 0}, {"name": "Milkshake", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 14.5, "daily_sugar_grams": 0}, {"name": "Minuman coklat", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 12.8, "daily_sugar_grams": 0}, {"name": "Es kopi gula aren", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 12.4, "daily_sugar_grams": 0}, {"name": "Minuman jelly", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 10, "daily_sugar_grams": 0}, {"name": "Bubble drink", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 13.8, "daily_sugar_grams": 0}, {"name": "Minuman kemasan lainnya", "freq_code": 0, "portion_ml": 250, "sugar_100ml": 10, "daily_sugar_grams": 0}]', 83.64, 'Tinggi', '2026-08-01 10:51:59', '2026-08-01 10:51:59', '2026-08-01 10:51:59');

-- Dumping structure for table smartsip_db.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.jobs: ~0 rows (approximately)

-- Dumping structure for table smartsip_db.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.job_batches: ~0 rows (approximately)

-- Dumping structure for table smartsip_db.knowledge_questions
CREATE TABLE IF NOT EXISTS `knowledge_questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` json NOT NULL,
  `correct_option` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.knowledge_questions: ~10 rows (approximately)
INSERT INTO `knowledge_questions` (`id`, `question_text`, `options`, `correct_option`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'WHO menganjurkan konsumsi gula bebas maksimal per hari untuk orang dewasa dan anak adalah....', '{"A": "25 gram (±6 sendok teh)", "B": "50 gram", "C": "75 gram", "D": "Tidak tahu"}', 'A', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21'),
	(2, 'Minuman berikut yang umumnya mengandung gula paling tinggi adalah....', '{"A": "Air putih", "B": "Teh tawar", "C": "Minuman bersoda", "D": "Air mineral"}', 'C', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21'),
	(3, 'Konsumsi gula berlebihan dapat meningkatkan risiko....', '{"A": "Obesitas", "B": "Diabetes melitus tipe 2", "C": "Penyakit jantung", "D": "Semua jawaban benar"}', 'D', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21'),
	(4, 'Minuman yang paling sehat untuk dikonsumsi setiap hari adalah....', '{"A": "Air putih", "B": "Minuman bersoda", "C": "Minuman energi", "D": "Bubble tea"}', 'A', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21'),
	(5, 'Salah satu cara mengetahui kandungan gula dalam minuman kemasan adalah dengan....', '{"A": "Melihat warna kemasan", "B": "Membaca label informasi nilai gizi", "C": "Melihat iklan di televisi", "D": "Menanyakan kepada teman"}', 'B', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21'),
	(6, 'Mengonsumsi minuman berpemanis setiap hari dapat menyebabkan....', '{"A": "Berat badan meningkat", "B": "Kerusakan gigi", "C": "Risiko diabetes meningkat", "D": "Semua jawaban benar"}', 'D', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21'),
	(7, 'Berikut yang termasuk Sugar-Sweetened Beverage (SSB) adalah....', '{"A": "Air putih", "B": "Teh tanpa gula", "C": "Minuman teh kemasan manis", "D": "Air mineral"}', 'C', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21'),
	(8, 'Jika merasa haus setelah beraktivitas, pilihan minuman terbaik adalah....', '{"A": "Air putih", "B": "Minuman bersoda", "C": "Minuman rasa buah dengan tambahan gula", "D": "Minuman energi"}', 'A', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21'),
	(9, 'Mengurangi konsumsi minuman manis dapat membantu....', '{"A": "Menjaga berat badan tetap ideal", "B": "Mengurangi risiko diabetes", "C": "Menjaga kesehatan tubuh", "D": "Semua jawaban benar"}', 'D', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21'),
	(10, 'Salah satu kebiasaan yang dapat membantu mengurangi konsumsi gula adalah....', '{"A": "Membawa botol air minum sendiri", "B": "Membeli minuman manis setiap hari", "C": "Menambahkan gula pada semua minuman", "D": "Mengonsumsi minuman bersoda saat haus"}', 'A', 1, '2026-08-01 07:45:21', '2026-08-01 07:45:21');

-- Dumping structure for table smartsip_db.knowledge_responses
CREATE TABLE IF NOT EXISTS `knowledge_responses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `phase` enum('T0','T1','T2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int NOT NULL,
  `category` enum('Baik','Cukup','Kurang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `answers` json NOT NULL,
  `answered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `knowledge_responses_student_id_foreign` (`student_id`),
  CONSTRAINT `knowledge_responses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.knowledge_responses: ~1 rows (approximately)
INSERT INTO `knowledge_responses` (`id`, `student_id`, `phase`, `score`, `category`, `answers`, `answered_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 'T1', 1, 'Kurang', '{"1": "B", "2": "B", "3": "C", "4": "C", "5": "C", "6": "B", "7": "C", "8": "C", "9": "B", "10": "B"}', '2026-08-01 08:11:30', '2026-08-01 08:11:30', '2026-08-01 08:11:30');

-- Dumping structure for table smartsip_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.migrations: ~23 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_07_19_131407_create_schools_table', 1),
	(5, '2026_07_19_131436_create_beverage_categories_table', 1),
	(6, '2026_07_19_131449_create_challenges_table', 1),
	(7, '2026_07_19_131459_create_tpb_questions_table', 1),
	(8, '2026_07_19_131509_create_educations_table', 1),
	(9, '2026_07_19_131517_create_settings_table', 1),
	(10, '2026_07_19_131528_create_research_teams_table', 1),
	(11, '2026_07_19_131539_create_school_classes_table', 1),
	(12, '2026_07_19_131550_create_beverages_table', 1),
	(13, '2026_07_19_131558_create_students_table', 1),
	(14, '2026_07_19_131622_create_tpb_responses_table', 1),
	(15, '2026_07_19_131633_create_sugar_consumptions_table', 1),
	(16, '2026_07_19_133145_create_point_histories_table', 1),
	(17, '2026_08_01_150000_add_demographics_to_students_table', 2),
	(18, '2026_08_01_150100_create_ffq_responses_table', 2),
	(19, '2026_08_01_150200_create_knowledge_questions_table', 2),
	(20, '2026_08_01_150300_create_knowledge_responses_table', 2),
	(21, '2026_08_01_150400_create_usability_responses_table', 2),
	(22, '2026_08_01_174104_add_body_fat_percentage_to_students_table', 3),
	(23, '2026_08_01_175525_add_school_id_to_users_table', 4);

-- Dumping structure for table smartsip_db.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table smartsip_db.point_histories
CREATE TABLE IF NOT EXISTS `point_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `challenge_id` bigint unsigned DEFAULT NULL,
  `points_earned` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `point_histories_user_id_foreign` (`user_id`),
  KEY `point_histories_challenge_id_foreign` (`challenge_id`),
  CONSTRAINT `point_histories_challenge_id_foreign` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE SET NULL,
  CONSTRAINT `point_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.point_histories: ~8 rows (approximately)
INSERT INTO `point_histories` (`id`, `user_id`, `challenge_id`, `points_earned`, `description`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, 50, 'Klaim Misi: 3 Hari Tanpa Soda', '2026-07-20 01:58:08', '2026-07-20 01:58:08'),
	(2, 3, NULL, 20, 'Mengisi FFQ 7 Hari Fase T0', '2026-08-01 08:10:01', '2026-08-01 08:10:01'),
	(3, 3, NULL, 30, 'Mengisi Evaluasi Usability Aplikasi (SUS)', '2026-08-01 08:10:31', '2026-08-01 08:10:31'),
	(4, 3, NULL, 20, 'Mengisi Kuesioner TPB Fase T0', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(5, 3, NULL, 20, 'Mengisi Kuesioner Pengetahuan Gula Fase T1', '2026-08-01 08:11:30', '2026-08-01 08:11:30'),
	(6, 3, NULL, 20, 'Mengisi Kuesioner TPB Fase T1', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(7, 4, NULL, 20, 'Mengisi FFQ 7 Hari Fase T0', '2026-08-01 10:51:59', '2026-08-01 10:51:59'),
	(8, 4, NULL, 20, 'Mengisi Kuesioner TPB Fase T0', '2026-08-01 10:52:26', '2026-08-01 10:52:26');

-- Dumping structure for table smartsip_db.research_teams
CREATE TABLE IF NOT EXISTS `research_teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.research_teams: ~0 rows (approximately)

-- Dumping structure for table smartsip_db.schools
CREATE TABLE IF NOT EXISTS `schools` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_type` enum('intervensi','kontrol') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.schools: ~5 rows (approximately)
INSERT INTO `schools` (`id`, `name`, `group_type`, `created_at`, `updated_at`) VALUES
	(1, 'SMAN 1 SmartSip', 'intervensi', '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(2, 'SMKN  1 SmartSip', 'kontrol', '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(3, 'SMAN 3 Karawang', 'intervensi', '2026-07-20 02:25:50', '2026-07-20 02:25:50'),
	(4, 'SMAN 1 Intervensi', 'intervensi', '2026-08-01 07:41:19', '2026-08-01 07:41:19'),
	(5, 'SMAN 2 Kontrol', 'kontrol', '2026-08-01 07:41:19', '2026-08-01 07:41:19');

-- Dumping structure for table smartsip_db.school_classes
CREATE TABLE IF NOT EXISTS `school_classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `school_classes_school_id_foreign` (`school_id`),
  CONSTRAINT `school_classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.school_classes: ~3 rows (approximately)
INSERT INTO `school_classes` (`id`, `school_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 1, 'X-IPA 1', '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(2, 3, 'XII-MIPA 1', '2026-07-20 02:26:05', '2026-07-20 02:26:05'),
	(3, 4, 'X-IPA 1', '2026-08-01 07:41:19', '2026-08-01 07:41:19');

-- Dumping structure for table smartsip_db.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('CTqHSiwNcTK1WXEagNuj2EYmroRh8Eqc7xTJ7LXv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJSY0xqMUFadnJoRWU5TjNmM0s2WUxWcHBYTW04VjQ2eFB4YTR5MDRHIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3JlZ2lzdGVyIiwicm91dGUiOiJyZWdpc3RlciJ9fQ==', 1785854640),
	('RWr4qNHLvpSulJckY2lIHkmpRt5Ou9XNQoXAskAl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJYUTU3aGkwdXRDeGlTUHlmQjVtWXpDRDBXd0dJaVpBYm02UE44VHl5IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6bnVsbH19', 1785609472);

-- Dumping structure for table smartsip_db.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.settings: ~2 rows (approximately)
INSERT INTO `settings` (`id`, `key`, `value`, `updated_at`) VALUES
	(1, 'app_name', 'SmartSip Web', '2026-08-04 07:32:09'),
	(2, 'footer_text', '© 2026 Tim Peneliti Hibah Dikti - Theory of Planned Behavior', '2026-08-04 07:32:09');

-- Dumping structure for table smartsip_db.students
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `informed_consent` tinyint(1) NOT NULL DEFAULT '1',
  `school_id` bigint unsigned NOT NULL,
  `class_id` bigint unsigned NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `height_cm` decimal(5,2) NOT NULL,
  `weight_kg` decimal(5,2) NOT NULL,
  `bmi_score` decimal(5,2) DEFAULT NULL,
  `body_fat_percentage` decimal(5,2) DEFAULT NULL,
  `pocket_money` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_user_id_unique` (`user_id`),
  KEY `students_school_id_foreign` (`school_id`),
  KEY `students_class_id_foreign` (`class_id`),
  CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.students: ~2 rows (approximately)
INSERT INTO `students` (`id`, `user_id`, `informed_consent`, `school_id`, `class_id`, `nickname`, `gender`, `date_of_birth`, `height_cm`, `weight_kg`, `bmi_score`, `body_fat_percentage`, `pocket_money`, `father_education`, `mother_education`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, 1, 1, 'Z-Warrior', 'L', '2009-05-15', 165.50, 55.00, 20.10, NULL, NULL, NULL, NULL, '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(2, 4, 1, 1, 2, 'amu official', 'L', '1990-08-17', 168.00, 78.00, 27.64, NULL, 'Rp21.000–30.000', 'D3/S1/S2/S3', 'SMP', '2026-08-01 10:50:43', '2026-08-01 10:50:43');

-- Dumping structure for table smartsip_db.sugar_consumptions
CREATE TABLE IF NOT EXISTS `sugar_consumptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `beverage_id` bigint unsigned NOT NULL,
  `volume_ml` int NOT NULL,
  `total_sugar_grams` decimal(6,2) NOT NULL,
  `consumed_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sugar_consumptions_user_id_foreign` (`user_id`),
  KEY `sugar_consumptions_beverage_id_foreign` (`beverage_id`),
  CONSTRAINT `sugar_consumptions_beverage_id_foreign` FOREIGN KEY (`beverage_id`) REFERENCES `beverages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sugar_consumptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.sugar_consumptions: ~4 rows (approximately)
INSERT INTO `sugar_consumptions` (`id`, `user_id`, `beverage_id`, `volume_ml`, `total_sugar_grams`, `consumed_at`, `created_at`, `updated_at`) VALUES
	(1, 3, 2, 500, 62.50, '2026-07-20 04:45:30', '2026-07-19 21:45:30', '2026-07-19 21:45:30'),
	(2, 3, 3, 200, 16.00, '2026-07-20 10:14:31', '2026-07-20 03:14:31', '2026-07-20 03:14:31'),
	(3, 3, 2, 300, 37.50, '2026-08-01 15:08:24', '2026-08-01 08:08:24', '2026-08-01 08:08:24'),
	(4, 4, 3, 200, 16.00, '2026-08-01 17:51:04', '2026-08-01 10:51:04', '2026-08-01 10:51:04');

-- Dumping structure for table smartsip_db.tpb_questions
CREATE TABLE IF NOT EXISTS `tpb_questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `construct_type` enum('attitude','subjective_norm','pbc','intention') COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.tpb_questions: ~23 rows (approximately)
INSERT INTO `tpb_questions` (`id`, `construct_type`, `question_text`, `is_active`) VALUES
	(9, 'attitude', 'Mengurangi konsumsi minuman manis bermanfaat bagi kesehatan saya.', 1),
	(10, 'attitude', 'Mengurangi konsumsi minuman manis merupakan keputusan yang baik.', 1),
	(11, 'attitude', 'Mengurangi konsumsi minuman manis membuat tubuh saya lebih sehat.', 1),
	(12, 'attitude', 'Mengurangi konsumsi minuman manis membantu mencegah obesitas.', 1),
	(13, 'attitude', 'Mengurangi konsumsi minuman manis layak saya lakukan.', 1),
	(14, 'attitude', 'Mengurangi konsumsi minuman manis penting bagi masa depan kesehatan saya.', 1),
	(15, 'subjective_norm', 'Orang tua saya mendukung saya mengurangi minuman manis.', 1),
	(16, 'subjective_norm', 'Guru saya menyarankan saya membatasi minuman manis.', 1),
	(17, 'subjective_norm', 'Teman saya mendukung saya memilih air putih.', 1),
	(18, 'subjective_norm', 'Orang penting bagi saya ingin saya mengurangi minuman manis.', 1),
	(19, 'subjective_norm', 'Saya merasa lingkungan sekolah mendukung konsumsi minuman sehat.', 1),
	(20, 'subjective_norm', 'Saya merasa keluarga saya memberi contoh yang baik.', 1),
	(21, 'pbc', 'Saya mampu menolak minuman manis.', 1),
	(22, 'pbc', 'Saya mampu memilih air putih.', 1),
	(23, 'pbc', 'Saya tetap dapat mengurangi minuman manis meskipun teman saya meminumnya.', 1),
	(24, 'pbc', 'Saya dapat mengontrol diri ketika ingin membeli minuman manis.', 1),
	(25, 'pbc', 'Saya memiliki kesempatan memilih minuman sehat.', 1),
	(26, 'pbc', 'Mengurangi minuman manis merupakan hal yang mudah bagi saya.', 1),
	(27, 'intention', 'Saya berniat mengurangi minuman manis mulai minggu ini.', 1),
	(28, 'intention', 'Saya akan memilih air putih lebih sering.', 1),
	(29, 'intention', 'Saya akan mengurangi membeli minuman kemasan.', 1),
	(30, 'intention', 'Saya akan membaca kandungan gula sebelum membeli minuman.', 1),
	(31, 'intention', 'Saya berkomitmen membatasi konsumsi minuman manis.', 1);

-- Dumping structure for table smartsip_db.tpb_responses
CREATE TABLE IF NOT EXISTS `tpb_responses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `question_id` bigint unsigned NOT NULL,
  `phase` enum('T0','T1','T2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` tinyint NOT NULL,
  `answered_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tpb_responses_student_id_foreign` (`student_id`),
  KEY `tpb_responses_question_id_foreign` (`question_id`),
  CONSTRAINT `tpb_responses_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `tpb_questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tpb_responses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.tpb_responses: ~69 rows (approximately)
INSERT INTO `tpb_responses` (`id`, `student_id`, `question_id`, `phase`, `score`, `answered_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 9, 'T0', 3, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(2, 1, 10, 'T0', 3, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(3, 1, 11, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(4, 1, 12, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(5, 1, 13, 'T0', 3, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(6, 1, 14, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(7, 1, 15, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(8, 1, 16, 'T0', 3, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(9, 1, 17, 'T0', 4, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(10, 1, 18, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(11, 1, 19, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(12, 1, 20, 'T0', 3, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(13, 1, 21, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(14, 1, 22, 'T0', 3, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(15, 1, 23, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(16, 1, 24, 'T0', 3, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(17, 1, 25, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(18, 1, 26, 'T0', 4, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(19, 1, 27, 'T0', 4, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(20, 1, 28, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(21, 1, 29, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(22, 1, 30, 'T0', 4, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(23, 1, 31, 'T0', 5, '2026-08-01 15:11:02', '2026-08-01 08:11:02', '2026-08-01 08:11:02'),
	(24, 1, 9, 'T1', 5, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(25, 1, 10, 'T1', 5, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(26, 1, 11, 'T1', 3, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(27, 1, 12, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(28, 1, 13, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(29, 1, 14, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(30, 1, 15, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(31, 1, 16, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(32, 1, 17, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(33, 1, 18, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(34, 1, 19, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(35, 1, 20, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(36, 1, 21, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(37, 1, 22, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(38, 1, 23, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(39, 1, 24, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(40, 1, 25, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(41, 1, 26, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(42, 1, 27, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(43, 1, 28, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(44, 1, 29, 'T1', 4, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(45, 1, 30, 'T1', 5, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(46, 1, 31, 'T1', 5, '2026-08-01 15:11:59', '2026-08-01 08:11:59', '2026-08-01 08:11:59'),
	(47, 2, 9, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(48, 2, 10, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(49, 2, 11, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(50, 2, 12, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(51, 2, 13, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(52, 2, 14, 'T0', 2, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(53, 2, 15, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(54, 2, 16, 'T0', 2, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(55, 2, 17, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(56, 2, 18, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(57, 2, 19, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(58, 2, 20, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(59, 2, 21, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(60, 2, 22, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(61, 2, 23, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(62, 2, 24, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(63, 2, 25, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(64, 2, 26, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(65, 2, 27, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(66, 2, 28, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(67, 2, 29, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(68, 2, 30, 'T0', 4, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26'),
	(69, 2, 31, 'T0', 3, '2026-08-01 17:52:26', '2026-08-01 10:52:26', '2026-08-01 10:52:26');

-- Dumping structure for table smartsip_db.usability_responses
CREATE TABLE IF NOT EXISTS `usability_responses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `scores` json NOT NULL,
  `total_score` int NOT NULL,
  `category` enum('Sangat Baik','Baik','Cukup','Kurang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `answered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usability_responses_student_id_foreign` (`student_id`),
  CONSTRAINT `usability_responses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.usability_responses: ~1 rows (approximately)
INSERT INTO `usability_responses` (`id`, `student_id`, `scores`, `total_score`, `category`, `answered_at`, `created_at`, `updated_at`) VALUES
	(1, 1, '{"1": "5", "2": "5", "3": "5", "4": "4", "5": "4", "6": "4", "7": "5", "8": "5", "9": "5", "10": "5"}', 47, 'Sangat Baik', '2026-08-01 08:10:31', '2026-08-01 08:10:31', '2026-08-01 08:10:31');

-- Dumping structure for table smartsip_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('siswa','guru','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  `school_id` bigint unsigned DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`),
  KEY `users_school_id_foreign` (`school_id`),
  CONSTRAINT `users_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartsip_db.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `google_id`, `role`, `school_id`, `avatar_url`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator Peneliti', 'admin@smartsip.id', NULL, '$2y$12$AcA8ZSAkY48SQgbcZVI69eyOVrXL9Pzp4ai.Dm9j3xI1NLnWD.9EG', NULL, 'admin', NULL, NULL, NULL, '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(2, 'Bapak Budi (Guru UKS)', 'guru@smartsip.id', NULL, '$2y$12$9f5JAr4jjq.Cf/tgQZZO5eHtvkJu56ll7qYJ4PqbAR1A9IRzoSgnq', NULL, 'guru', 1, NULL, NULL, '2026-07-19 21:40:58', '2026-08-01 11:02:56'),
	(3, 'Siswa Responden 01', 'siswa@smartsip.id', NULL, '$2y$12$2c6jfbKHmmeqxI1O5NrI9OdoFdZd3zbbms0hqKcHfylixBb0PYDAa', NULL, 'siswa', NULL, NULL, NULL, '2026-07-19 21:40:58', '2026-07-19 21:40:58'),
	(4, 'ahmad', 'ahmadmubarok941@gmail.com', NULL, '$2y$12$X1PT2FCMb3NcwOIU06aPH.nWKQdhqiPBfz3zCNUVXuMRV.by/hRh6', NULL, 'siswa', NULL, NULL, NULL, '2026-08-01 10:49:48', '2026-08-01 10:49:48'),
	(5, 'Guru SMKN 1 Smartsip', 'gurusmkn1@gmail.com', NULL, '$2y$12$KjedrL5Tzr4ZM.VA6kNJAuZc3M8IkU4uv/.4OLZJV.X.UTdXW0Yo2', NULL, 'guru', 2, NULL, NULL, '2026-08-01 11:01:19', '2026-08-01 11:01:19');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
