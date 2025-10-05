-- pitchboard.sql
CREATE DATABASE IF NOT EXISTS `pitchboard` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pitchboard`;

CREATE TABLE IF NOT EXISTS `ideas` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `likes` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `idea_id` INT NOT NULL,
  `comment_text` TEXT NOT NULL,
  `date_posted` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`idea_id`) REFERENCES `ideas`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- seed some ideas (optional)
INSERT INTO `ideas` (`title`,`description`,`category`,`likes`)
VALUES
('Eco-Pack: Biodegradable Packaging Startup', 'A startup to provide compostable packaging for food vendors using agricultural waste.', 'Environment', 8),
('TutorLink: Micro-tutoring Platform', 'Students can book micro-sessions (15 min) with high-performing peers for exam prep.', 'Education', 12),
('QuickMeds: Medicine Reminder & Pharmacy Delivery', 'Reminder + 1-hour delivery from nearby pharmacies for urgent meds.', 'Health', 5);
