 
-- Weather snapshots: store an Open-Meteo-like JSON payload for admin-managed forecasts
CREATE TABLE IF NOT EXISTS `weather_snapshots` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) DEFAULT 'default',
  `payload` LONGTEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Simple profile entries for site profile CRUD
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `keyname` VARCHAR(255) NOT NULL UNIQUE,
  `title` VARCHAR(255) DEFAULT NULL,
  `content` LONGTEXT,
  `image` VARCHAR(1024) DEFAULT NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Admins table (present but not enforced when 'no login' requested)
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) DEFAULT NULL,
  `display_name` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- News table (main berita management for admin)
CREATE TABLE IF NOT EXISTS `news` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) DEFAULT NULL,
  `excerpt` TEXT,
  `content` LONGTEXT,
  `thumbnail` VARCHAR(1024) DEFAULT NULL,
  `category` VARCHAR(128) DEFAULT NULL,
  `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `is_published` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Announcements / Pengumuman
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT,
  `start_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `end_at` DATETIME DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Settings table for site settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `keyname` VARCHAR(128) NOT NULL UNIQUE,
  `value` TEXT,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Visitors simple log
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ip` VARCHAR(64) DEFAULT NULL,
  `path` VARCHAR(255) DEFAULT NULL,
  `user_agent` VARCHAR(1024) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Media management
CREATE TABLE IF NOT EXISTS `media` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `filename` VARCHAR(1024) NOT NULL,
  `path` VARCHAR(1024) NOT NULL,
  `mime` VARCHAR(128) DEFAULT NULL,
  `size` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Complaint reports from warga (legacy — superseded by reports table)
CREATE TABLE IF NOT EXISTS `complaints` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `location_text` VARCHAR(512) DEFAULT NULL,
  `latitude` DECIMAL(11,8) DEFAULT NULL,
  `longitude` DECIMAL(11,8) DEFAULT NULL,
  `photo_path` VARCHAR(1024) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `comment` TEXT DEFAULT NULL,
  `status` VARCHAR(64) DEFAULT 'terkirim',
  `submitted_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Pengajuan Laporan Masyarakat (civic complaint portal)
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
