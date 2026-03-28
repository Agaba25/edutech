-- Enhanced EduTech Database Schema
-- Based on Uganda Public Universities Information 2024/2025

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Create database
-- Changed database name from edutech_db to educareer_db
CREATE DATABASE IF NOT EXISTS `educareer_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `educareer_db`;

-- Enhanced institutions table
CREATE TABLE `institutions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `short_name` VARCHAR(20),
  `short_description` TEXT,
  `address` VARCHAR(255),
  `region` VARCHAR(100),
  `logo_path` VARCHAR(255),
  `contact_email` VARCHAR(100),
  `phone` VARCHAR(20),
  `website` VARCHAR(255),
  `university_type` ENUM('Public', 'Private') DEFAULT 'Public',
  `established_year` YEAR,
  `student_capacity` INT,
  `application_deadline` DATE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_region` (`region`),
  INDEX `idx_name` (`name`),
  INDEX `idx_type` (`university_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Enhanced programs table
CREATE TABLE `programs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `institution_id` INT NOT NULL,
  `program_code` VARCHAR(10),
  `level` ENUM('Certificate', 'Diploma', 'Bachelor', 'Master', 'PhD') NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `duration` VARCHAR(50),
  `duration_years` INT,
  `fee_estimate` VARCHAR(100),
  `cutoff_info` TEXT COMMENT 'Entry-level cut-off points',
  `description` TEXT,
  `faculty` VARCHAR(100),
  `essential_subjects` TEXT,
  `relevant_subjects` TEXT,
  `desirable_subjects` TEXT,
  `cutoff_points_2023` DECIMAL(5,2),
  `cutoff_points_2022` DECIMAL(5,2),
  `cutoff_points_2021` DECIMAL(5,2),
  `sponsorship_type` ENUM('Government', 'Private', 'Both') DEFAULT 'Both',
  `application_fee` DECIMAL(10,2),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`institution_id`) REFERENCES `institutions`(`id`) ON DELETE CASCADE,
  INDEX `idx_institution` (`institution_id`),
  INDEX `idx_level` (`level`),
  INDEX `idx_code` (`program_code`),
  INDEX `idx_faculty` (`faculty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Subject combinations table
CREATE TABLE `subject_combinations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `program_id` INT NOT NULL,
  `combination_code` VARCHAR(10),
  `subject_1` VARCHAR(50),
  `subject_2` VARCHAR(50),
  `subject_3` VARCHAR(50),
  `description` TEXT,
  FOREIGN KEY (`program_id`) REFERENCES `programs`(`id`) ON DELETE CASCADE,
  INDEX `idx_program` (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Users table (admin authentication)
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'user') DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_email` (`email`),
  INDEX `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Contact messages table
CREATE TABLE `contact_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `subject` VARCHAR(200),
  `message` TEXT NOT NULL,
  `status` ENUM('new', 'read', 'replied') DEFAULT 'new',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_email` (`email`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- SEED DATA - Uganda Public Universities
-- ============================================

-- Insert admin user
INSERT INTO `users` (`name`, `email`, `password_hash`, `role`) VALUES
('Admin User', 'admin@edutech.local', '$2y$10$YIjlrPNoS0E9IeaVrcemCOYvxijrQWXVVmMvqIYeNLsN8/LewKope', 'admin');

-- Insert 10 Public Universities
INSERT INTO `institutions` (`name`, `short_name`, `short_description`, `address`, `region`, `contact_email`, `phone`, `website`, `university_type`, `established_year`) VALUES
('Makerere University', 'MAK', 'Uganda\'s premier public university offering diverse academic programs', 'Kampala', 'Central', 'ar@mak.ac.ug', '+256-41-4534343', 'www.mak.ac.ug', 'Public', 1922),
('Mbarara University of Science & Technology', 'MUST', 'Leading science and technology university in western Uganda', 'Mbarara', 'Western', 'ar@must.ac.ug', '+256-485-660584', 'www.must.ac.ug', 'Public', 1989),
('Kyambogo University', 'KYU', 'Public university specializing in education and technology', 'Kyambogo, Kampala', 'Central', 'arkyu@kyu.ac.ug', '+256-41-286237', 'www.kyu.ac.ug', 'Public', 2003),
('Gulu University', 'GU', 'Northern Uganda\'s premier public university', 'Gulu', 'Northern', 'ar@gu.ac.ug', '+256-471-432921', 'www.gu.ac.ug', 'Public', 2002),
('Busitema University', 'BUS', 'Multi-campus public university focusing on agriculture and engineering', 'Tororo', 'Eastern', 'ar@acadreg.busitema.ac.ug', '+256-454448842', 'www.busitema.ac.ug', 'Public', 2007),
('Muni University', 'MUNI', 'Public university in West Nile region', 'Arua', 'Northern', 'ar@muni.ac.ug', '+256-476-420312', 'www.muni.ac.ug', 'Public', 2013),
('Kabale University', 'KAB', 'Public university in southwestern Uganda', 'Kabale', 'Western', 'registrar@kab.ac.ug', '+256-4864-26463', 'www.kab.ac.ug', 'Public', 2002),
('Lira University', 'LIRA', 'Public university in northern Uganda', 'Lira', 'Northern', 'academicregistrar@lirauni.ac.ug', '+256-471-660709', 'www.lirauni.ac.ug', 'Public', 2012),
('Soroti University', 'SUN', 'Public university in eastern Uganda', 'Soroti', 'Eastern', 'ar@sun.ac.ug', '+256-454-961605', 'www.sun.ac.ug', 'Public', 2015),
('Mountains of the Moon University', 'MMU', 'Public university in western Uganda', 'Fort Portal', 'Western', 'registrar@mmu.ac.ug', '+256-483-660390', 'www.mmu.ac.ug', 'Public', 2005);

-- Insert sample programs for Makerere University
INSERT INTO `programs` (`institution_id`, `program_code`, `level`, `name`, `duration`, `duration_years`, `fee_estimate`, `cutoff_info`, `description`, `faculty`, `essential_subjects`, `relevant_subjects`, `desirable_subjects`, `cutoff_points_2023`, `cutoff_points_2022`, `cutoff_points_2021`, `sponsorship_type`, `application_fee`) VALUES
(1, 'MAM', 'Bachelor', 'Bachelor of Medicine and Bachelor of Surgery', '5 Years', 5, '15,000,000 UGX', 'Minimum: Biology and Chemistry at A-Level, Mathematics or Physics', 'Comprehensive medical training program', 'College of Health Sciences', 'Biology, Chemistry', 'Mathematics, Physics', 'General Paper, Sub Maths or Computer Studies', 48.0, 39.8, 51.1, 'Government', 52000),
(1, 'PHA', 'Bachelor', 'Bachelor of Pharmacy', '4 Years', 4, '12,000,000 UGX', 'Minimum: Biology and Chemistry at A-Level, Mathematics or Physics', 'Professional pharmacy program', 'College of Health Sciences', 'Biology, Chemistry', 'Mathematics, Physics', 'General Paper, Sub Maths or Computer Studies', 45.4, 39.3, 48.4, 'Government', 52000),
(1, 'CIV', 'Bachelor', 'Bachelor of Science in Civil Engineering', '4 Years', 4, '10,000,000 UGX', 'Minimum: Mathematics and Physics at A-Level', 'Civil engineering and construction program', 'College of Engineering', 'Mathematics, Physics', 'Economics, Chemistry, Geography', 'General Paper, Computer Studies', 49.1, 23.4, 51.5, 'Government', 52000),
(1, 'ELE', 'Bachelor', 'Bachelor of Science in Electrical Engineering', '4 Years', 4, '10,000,000 UGX', 'Minimum: Mathematics and Physics at A-Level', 'Electrical engineering program', 'College of Engineering', 'Mathematics, Physics', 'Economics, Chemistry', 'General Paper, Computer Studies', 48.2, 30.3, 48.7, 'Government', 52000),
(1, 'CSC', 'Bachelor', 'Bachelor of Science in Computer Science', '3 Years', 3, '8,000,000 UGX', 'Minimum: Mathematics and one of Physics, Economics, Chemistry', 'Computer science and programming', 'College of Computing', 'Mathematics', 'Physics, Economics, Chemistry', 'General Paper, Computer Studies', 47.1, 28.7, 42.7, 'Government', 52000);

-- Insert sample programs for Mbarara University
INSERT INTO `programs` (`institution_id`, `program_code`, `level`, `name`, `duration`, `duration_years`, `fee_estimate`, `cutoff_info`, `description`, `faculty`, `essential_subjects`, `relevant_subjects`, `desirable_subjects`, `cutoff_points_2023`, `cutoff_points_2022`, `cutoff_points_2021`, `sponsorship_type`, `application_fee`) VALUES
(2, 'MBM', 'Bachelor', 'Bachelor of Medicine and Bachelor of Surgery', '5 Years', 5, '15,000,000 UGX', 'Minimum: Biology and Chemistry at A-Level, Mathematics or Physics', 'Medical training program', 'Faculty of Medicine', 'Biology, Chemistry', 'Mathematics, Physics', 'General Paper, Sub Maths or Computer Studies', 46.9, 41.3, 49.9, 'Government', 52000),
(2, 'PHM', 'Bachelor', 'Bachelor of Pharmacy', '4 Years', 4, '12,000,000 UGX', 'Minimum: Biology and Chemistry at A-Level, Mathematics or Physics', 'Pharmacy program', 'Faculty of Medicine', 'Biology, Chemistry', 'Mathematics, Physics', 'General Paper, Sub Maths or Computer Studies', 46.8, 43.7, 49.8, 'Government', 52000),
(2, 'NUM', 'Bachelor', 'Bachelor of Nursing Science', '4 Years', 4, '10,000,000 UGX', 'Minimum: Biology and Chemistry at A-Level, Mathematics or Physics', 'Nursing science program', 'Faculty of Medicine', 'Biology, Chemistry', 'Mathematics, Physics', 'General Paper, Sub Maths or Computer Studies', 45.1, 40.6, 46.7, 'Government', 52000);

-- Insert sample programs for Kyambogo University
INSERT INTO `programs` (`institution_id`, `program_code`, `level`, `name`, `duration`, `duration_years`, `fee_estimate`, `cutoff_info`, `description`, `faculty`, `essential_subjects`, `relevant_subjects`, `desirable_subjects`, `cutoff_points_2023`, `cutoff_points_2022`, `cutoff_points_2021`, `sponsorship_type`, `application_fee`) VALUES
(3, 'ESB', 'Bachelor', 'Bachelor of Science with Education (Biological)', '3 Years', 3, '6,000,000 UGX', 'Minimum: Biology and Chemistry at A-Level', 'Science education with biology focus', 'Faculty of Science', 'Biology, Chemistry', 'Mathematics, Physics', 'General Paper, Sub Maths or Computer Studies', 42.3, 35.2, 44.3, 'Government', 52000),
(3, 'ESP', 'Bachelor', 'Bachelor of Science with Education (Physical)', '3 Years', 3, '6,000,000 UGX', 'Minimum: Mathematics and Physics at A-Level', 'Science education with physics focus', 'Faculty of Science', 'Mathematics, Physics', 'Chemistry, Biology', 'General Paper, Sub Maths or Computer Studies', 45.3, 35.2, 47.2, 'Government', 52000),
(3, 'ESE', 'Bachelor', 'Bachelor of Science with Education (Economics)', '3 Years', 3, '6,000,000 UGX', 'Minimum: Mathematics and Economics at A-Level', 'Science education with economics focus', 'Faculty of Science', 'Mathematics, Economics', 'Physics, Chemistry, Biology', 'General Paper, Sub Maths or Computer Studies', 43.8, 34.0, 41.5, 'Government', 52000);

-- Insert sample subject combinations
INSERT INTO `subject_combinations` (`program_id`, `combination_code`, `subject_1`, `subject_2`, `subject_3`, `description`) VALUES
(1, 'PCB', 'Physics', 'Chemistry', 'Biology', 'Traditional science combination for medicine'),
(1, 'PCM', 'Physics', 'Chemistry', 'Mathematics', 'Science combination with mathematics'),
(2, 'PCB', 'Physics', 'Chemistry', 'Biology', 'Traditional science combination for pharmacy'),
(2, 'PCM', 'Physics', 'Chemistry', 'Mathematics', 'Science combination with mathematics'),
(3, 'PCB', 'Physics', 'Chemistry', 'Biology', 'Traditional science combination for civil engineering'),
(3, 'PCM', 'Physics', 'Chemistry', 'Mathematics', 'Science combination with mathematics'),
(4, 'PCB', 'Physics', 'Chemistry', 'Biology', 'Traditional science combination for electrical engineering'),
(4, 'PCM', 'Physics', 'Chemistry', 'Mathematics', 'Science combination with mathematics'),
(5, 'PCM', 'Physics', 'Chemistry', 'Mathematics', 'Science combination with mathematics for computer science'),
(5, 'PCE', 'Physics', 'Chemistry', 'Economics', 'Science combination with economics');
