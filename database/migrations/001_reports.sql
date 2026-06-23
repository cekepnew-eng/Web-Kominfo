-- Migration: Pengajuan Laporan Masyarakat
-- Run: mysql -u root kominfov2 < database/migrations/001_reports.sql

CREATE TABLE IF NOT EXISTS `reports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ticket_number` VARCHAR(20) NOT NULL UNIQUE,
  `category` VARCHAR(50) NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `latitude` DECIMAL(10, 8) NOT NULL,
  `longitude` DECIMAL(11, 8) NOT NULL,
  `address` TEXT DEFAULT NULL,
  `reporter_name` VARCHAR(100) DEFAULT NULL,
  `reporter_contact` VARCHAR(50) DEFAULT NULL,
  `status` VARCHAR(30) NOT NULL DEFAULT 'pending_verification',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_reports_location` (`latitude`, `longitude`),
  INDEX `idx_reports_status` (`status`),
  INDEX `idx_reports_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `report_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `report_id` INT NOT NULL,
  `image_url` VARCHAR(1024) NOT NULL,
  `is_primary` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_report_images_report` FOREIGN KEY (`report_id`) REFERENCES `reports`(`id`) ON DELETE CASCADE,
  INDEX `idx_report_images_report` (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `report_status_history` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `report_id` INT NOT NULL,
  `status` VARCHAR(30) NOT NULL,
  `note` TEXT DEFAULT NULL,
  `changed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_report_status_history_report` FOREIGN KEY (`report_id`) REFERENCES `reports`(`id`) ON DELETE CASCADE,
  INDEX `idx_report_status_history_report` (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
