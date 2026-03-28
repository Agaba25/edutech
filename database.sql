-- EduTech Institution Listing Database Schema
-- MySQL 5.7+ compatible

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Create database
-- Changed database name from edutech_db to educareer_db to avoid conflicts
CREATE DATABASE IF NOT EXISTS `educareer_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `educareer_db`;

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

-- Institutions table
CREATE TABLE `institutions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `short_description` TEXT,
  `address` VARCHAR(255),
  `region` VARCHAR(100),
  `logo_path` VARCHAR(255),
  `contact_email` VARCHAR(100),
  `phone` VARCHAR(20),
  `website` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_region` (`region`),
  INDEX `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Programs table (Certificate/Diploma)
CREATE TABLE `programs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `institution_id` INT NOT NULL,
  `level` ENUM('Certificate', 'Diploma') NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `duration` VARCHAR(50),
  `fee_estimate` VARCHAR(100),
  `cutoff_info` TEXT COMMENT 'Entry-level cut-off points (sample data - verify with institution)',
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`institution_id`) REFERENCES `institutions`(`id`) ON DELETE CASCADE,
  INDEX `idx_institution` (`institution_id`),
  INDEX `idx_level` (`level`)
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
-- SEED DATA (Sample Data - Verify with Institutions)
-- ============================================

-- Insert admin user (password: admin123)
INSERT INTO `users` (`name`, `email`, `password_hash`, `role`) VALUES
('Admin User', 'admin@edutech.local', '$2y$10$YIjlrPNoS0E9IeaVrcemCOYvxijrQWXVVmMvqIYeNLsN8/LewKope', 'admin');

-- Insert institutions
INSERT INTO `institutions` (`name`, `short_description`, `address`, `region`, `contact_email`, `phone`, `website`) VALUES
('Kampala International University (KIU)', 'Leading private university offering diverse academic programs', 'Kansanga, Kampala', 'Central', 'admissions@kiu.ac.ug', '+256-414-267-100', 'www.kiu.ac.ug'),
('Makerere University Business School (MUBS)', 'Premier business education institution', 'Kampala', 'Central', 'admissions@mubs.ac.ug', '+256-414-531-000', 'www.mubs.ac.ug'),
('Kyambogo University', 'Public university specializing in education and technology', 'Kyambogo, Kampala', 'Central', 'admissions@kyambogo.ac.ug', '+256-414-286-000', 'www.kyambogo.ac.ug'),
('Uganda Technical College, Kyema', 'Technical and vocational training institution', 'Kyema, Mukono', 'Central', 'info@utc-kyema.ac.ug', '+256-414-200-500', 'www.utc-kyema.ac.ug'),
('Nsamizi Institute of Agriculture & Veterinary', 'Agricultural and veterinary sciences training', 'Nsamizi, Wakiso', 'Central', 'admissions@nsamizi.ac.ug', '+256-414-500-200', 'www.nsamizi.ac.ug'),
('Uganda Institute of Allied Health & Management Sciences', 'Health sciences and management training', 'Kampala', 'Central', 'info@uiahms.ac.ug', '+256-414-300-100', 'www.uiahms.ac.ug'),
('Mbarara Technical Institute', 'Technical training in western Uganda', 'Mbarara', 'Western', 'admissions@mti.ac.ug', '+256-485-420-100', 'www.mti.ac.ug'),
('Kampala School of Business', 'Vocational and business training', 'Kampala', 'Central', 'info@ksb.ac.ug', '+256-414-250-300', 'www.ksb.ac.ug');

-- Insert programs for KIU
INSERT INTO `programs` (`institution_id`, `level`, `name`, `duration`, `fee_estimate`, `cutoff_info`, `description`) VALUES
(1, 'Certificate', 'Certificate in Information Technology', '1 year', '2,500,000 UGX', 'Minimum: 5 O-levels (Grade 5 or better)', 'Foundational IT skills including hardware, software, and basic networking'),
(1, 'Diploma', 'Diploma in Computer Science', '2 years', '5,000,000 UGX', 'Minimum: 2 A-levels or equivalent', 'Advanced programming, database design, and software development'),
(1, 'Certificate', 'Certificate in Business Management', '1 year', '2,200,000 UGX', 'Minimum: 5 O-levels', 'Business fundamentals, accounting basics, and management principles');

-- Insert programs for MUBS
INSERT INTO `programs` (`institution_id`, `level`, `name`, `duration`, `fee_estimate`, `cutoff_info`, `description`) VALUES
(2, 'Diploma', 'Diploma in Accounting', '2 years', '6,000,000 UGX', 'Minimum: 2 A-levels (including Math)', 'Professional accounting standards, financial reporting, and auditing'),
(2, 'Certificate', 'Certificate in Business Administration', '1 year', '2,800,000 UGX', 'Minimum: 5 O-levels', 'Business operations, customer service, and office management'),
(2, 'Diploma', 'Diploma in Marketing', '2 years', '5,500,000 UGX', 'Minimum: 2 A-levels', 'Digital marketing, brand management, and consumer behavior');

-- Insert programs for Kyambogo University
INSERT INTO `programs` (`institution_id`, `level`, `name`, `duration`, `fee_estimate`, `cutoff_info`, `description`) VALUES
(3, 'Certificate', 'Certificate in Teacher Training', '1 year', '2,000,000 UGX', 'Minimum: 5 O-levels', 'Pedagogical methods and classroom management'),
(3, 'Diploma', 'Diploma in Electronics & Telecommunications', '2 years', '5,200,000 UGX', 'Minimum: 2 A-levels (including Physics)', 'Modern telecommunications systems and electronic devices');

-- Insert programs for UTC Kyema
INSERT INTO `programs` (`institution_id`, `level`, `name`, `duration`, `fee_estimate`, `cutoff_info`, `description`) VALUES
(4, 'Certificate', 'Certificate in Welding & Fabrication', '1 year', '1,800,000 UGX', 'Minimum: 4 O-levels', 'Welding techniques, metal fabrication, and safety'),
(4, 'Diploma', 'Diploma in Mechanical Engineering', '2 years', '4,800,000 UGX', 'Minimum: 2 A-levels (including Math & Physics)', 'Machine design, thermodynamics, and manufacturing processes');

-- Insert programs for Nsamizi
INSERT INTO `programs` (`institution_id`, `level`, `name`, `duration`, `fee_estimate`, `cutoff_info`, `description`) VALUES
(5, 'Certificate', 'Certificate in Crop Production', '1 year', '1,500,000 UGX', 'Minimum: 4 O-levels', 'Modern farming techniques and crop management'),
(5, 'Diploma', 'Diploma in Veterinary Science', '2 years', '5,500,000 UGX', 'Minimum: 2 A-levels (including Biology)', 'Animal health, disease prevention, and veterinary practice');

-- Insert programs for UIAHMS
INSERT INTO `programs` (`institution_id`, `level`, `name`, `duration`, `fee_estimate`, `cutoff_info`, `description`) VALUES
(6, 'Certificate', 'Certificate in Nursing', '1 year', '2,200,000 UGX', 'Minimum: 5 O-levels (including Biology)', 'Patient care, medical procedures, and health safety'),
(6, 'Diploma', 'Diploma in Public Health', '2 years', '5,000,000 UGX', 'Minimum: 2 A-levels (including Biology)', 'Epidemiology, health promotion, and disease prevention');

-- Insert programs for Mbarara Technical Institute
INSERT INTO `programs` (`institution_id`, `level`, `name`, `duration`, `fee_estimate`, `cutoff_info`, `description`) VALUES
(7, 'Certificate', 'Certificate in Electrical Installation', '1 year', '1,900,000 UGX', 'Minimum: 4 O-levels', 'Electrical systems, wiring, and safety standards'),
(7, 'Diploma', 'Diploma in Civil Engineering', '2 years', '4,500,000 UGX', 'Minimum: 2 A-levels (including Math & Physics)', 'Construction, structural design, and project management');

-- Insert programs for Kampala School of Business
INSERT INTO `programs` (`institution_id`, `level`, `name`, `duration`, `fee_estimate`, `cutoff_info`, `description`) VALUES
(8, 'Certificate', 'Certificate in Hospitality Management', '1 year', '2,000,000 UGX', 'Minimum: 4 O-levels', 'Hotel operations, customer service, and food safety'),
(8, 'Certificate', 'Certificate in Hairdressing & Beauty', '6 months', '1,200,000 UGX', 'Minimum: 3 O-levels', 'Hair styling, makeup, and beauty treatments');

-- Scholarships table
CREATE TABLE `scholarships` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `institution_id` INT,
  `amount` VARCHAR(100),
  `deadline` DATE,
  `description` TEXT,
  `requirements` TEXT,
  `category` ENUM('Government', 'International', 'Merit', 'Gender', 'Rural', 'Sports', 'Need-based') DEFAULT 'Merit',
  `application_url` VARCHAR(255),
  `is_active` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`institution_id`) REFERENCES `institutions`(`id`) ON DELETE SET NULL,
  INDEX `idx_category` (`category`),
  INDEX `idx_deadline` (`deadline`),
  INDEX `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Careers table
CREATE TABLE `careers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT,
  `education_requirements` TEXT,
  `key_skills` TEXT,
  `salary_range` VARCHAR(100),
  `demand_level` ENUM('Low', 'Medium', 'High', 'Very High') DEFAULT 'Medium',
  `category` VARCHAR(50),
  `job_market_info` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_category` (`category`),
  INDEX `idx_demand` (`demand_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Course recommendations table
CREATE TABLE `course_recommendations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_session` VARCHAR(100),
  `subjects` VARCHAR(100),
  `interests` VARCHAR(100),
  `level` VARCHAR(50),
  `budget` VARCHAR(50),
  `recommended_programs` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_session` (`user_session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Career assessments table
CREATE TABLE `career_assessments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_session` VARCHAR(100),
  `subjects` VARCHAR(100),
  `environment` VARCHAR(100),
  `strengths` VARCHAR(100),
  `motivation` VARCHAR(100),
  `recommended_careers` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_session` (`user_session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample scholarships
INSERT INTO `scholarships` (`title`, `institution_id`, `amount`, `deadline`, `description`, `requirements`, `category`) VALUES
('Government Scholarship Program', NULL, 'Full Tuition', '2024-03-15', 'Government-funded scholarships for outstanding students in STEM fields', 'Minimum 3.5 GPA, UACE with 15+ points', 'Government'),
('Mastercard Foundation Scholars Program', 1, 'Full Scholarship', '2024-04-30', 'Comprehensive scholarship covering tuition, accommodation, and living expenses', 'Financial need, academic excellence, leadership potential', 'International'),
('KIU Merit Scholarship', 1, '50% Tuition', '2024-05-15', 'Merit-based scholarship for top-performing students', 'UACE with 18+ points, excellent academic record', 'Merit'),
('Women in STEM Scholarship', 3, '75% Tuition', '2024-06-01', 'Scholarship specifically for female students pursuing STEM programs', 'Female student, STEM program, financial need', 'Gender'),
('Rural Development Scholarship', 7, 'Full Tuition + Stipend', '2024-04-20', 'Scholarship for students from rural areas pursuing agriculture and development studies', 'Rural background, agriculture/development program', 'Rural'),
('Sports Excellence Scholarship', NULL, 'Variable', '2024-07-01', 'Scholarship for students with exceptional sports achievements', 'National/international sports recognition', 'Sports');

-- Insert sample careers
INSERT INTO `careers` (`title`, `description`, `education_requirements`, `key_skills`, `salary_range`, `demand_level`, `category`, `job_market_info`) VALUES
('Data Scientist', 'Analyze complex data to help organizations make informed decisions', 'Bachelor\'s in Computer Science, Statistics, or Mathematics', 'Python, R, Machine Learning, Statistics, SQL', '3,000,000 - 8,000,000 UGX', 'High', 'Technology', 'Growing demand in Uganda with increasing digitalization'),
('Software Developer', 'Design, develop, and maintain software applications', 'Bachelor\'s in Computer Science or Software Engineering', 'Programming, Problem Solving, Teamwork, Version Control', '2,500,000 - 6,000,000 UGX', 'Very High', 'Technology', 'High demand across all industries'),
('Medical Doctor', 'Diagnose and treat patients, provide medical care', 'Bachelor of Medicine and Bachelor of Surgery (MBChB)', 'Medical Knowledge, Communication, Empathy, Problem Solving', '4,000,000 - 12,000,000 UGX', 'High', 'Healthcare', 'Consistent demand with growing population'),
('Civil Engineer', 'Design and oversee construction of infrastructure projects', 'Bachelor\'s in Civil Engineering', 'Engineering Design, Project Management, Mathematics, CAD', '3,000,000 - 7,000,000 UGX', 'High', 'Engineering', 'Growing infrastructure development in Uganda'),
('Business Analyst', 'Analyze business processes and recommend improvements', 'Bachelor\'s in Business Administration or related field', 'Analytical Thinking, Communication, Data Analysis, Problem Solving', '2,800,000 - 5,500,000 UGX', 'High', 'Business', 'Increasing demand in corporate sector'),
('Teacher/Educator', 'Educate students in various subjects and grade levels', 'Bachelor\'s in Education or subject-specific degree', 'Teaching, Communication, Patience, Subject Knowledge', '1,500,000 - 4,000,000 UGX', 'High', 'Education', 'Always in demand with growing student population');
