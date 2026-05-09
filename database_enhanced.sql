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

-- ---------------------------------------------------------------------------
-- Additional modules (single schema): admin scholarships + course finder
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scholarships` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `institution_id` INT NULL,
  `amount` VARCHAR(100),
  `deadline` DATE,
  `description` TEXT,
  `requirements` TEXT,
  `application_url` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`institution_id`) REFERENCES `institutions`(`id`) ON DELETE SET NULL,
  INDEX `idx_deadline` (`deadline`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `essential_subjects` TEXT COMMENT 'JSON array of required subjects (x3 weight)',
  `relevant_subjects` TEXT COMMENT 'JSON array of relevant subjects (x2 weight)',
  `desirable_subjects` TEXT COMMENT 'JSON array of desirable subjects (x1 weight)',
  `minimum_points` INT DEFAULT 15,
  `duration` VARCHAR(50),
  `career_fields` TEXT COMMENT 'JSON array of career fields',
  `career_opportunities` TEXT COMMENT 'JSON array of career opportunities',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_minimum_points` (`minimum_points`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `course_universities` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT NOT NULL,
  `institution_id` INT NOT NULL,
  `application_link` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`institution_id`) REFERENCES `institutions`(`id`) ON DELETE CASCADE,
  INDEX `idx_course` (`course_id`),
  INDEX `idx_institution` (`institution_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `course_scholarships` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT NOT NULL,
  `scholarship_name` VARCHAR(255) NOT NULL,
  `scholarship_link` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  INDEX `idx_course` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `courses` (`name`, `description`, `essential_subjects`, `relevant_subjects`, `desirable_subjects`, `minimum_points`, `duration`, `career_fields`, `career_opportunities`) VALUES
('Bachelor of Medicine and Surgery',
 'A comprehensive 5-year medical program providing theoretical knowledge and clinical training. Graduates are equipped to diagnose, treat, and prevent diseases, becoming licensed medical doctors.',
 '["Biology", "Chemistry"]',
 '["Mathematics", "Physics"]',
 '["General Paper", "Sub Maths", "Computer Studies"]',
 45,
 '5 years',
 '["Medicine & Health Sciences"]',
 '["Medical Doctor", "Surgeon", "Medical Researcher", "Public Health Officer", "Hospital Administrator"]'),

('Bachelor of Computer Science',
 'A 3-year program focusing on software development, algorithms, data structures, and computer systems. Prepares students for careers in technology and software engineering.',
 '["Mathematics"]',
 '["Physics", "Economics", "Chemistry", "Biology"]',
 '["General Paper", "Computer Studies"]',
 40,
 '3 years',
 '["Computing & IT", "Science & Technology"]',
 '["Software Developer", "Data Analyst", "Systems Administrator", "IT Consultant", "App Developer"]'),

('Bachelor of Science in Electrical Engineering',
 'A 4-year engineering program covering electrical systems, power generation, electronics, and telecommunications. Combines theoretical knowledge with practical applications.',
 '["Mathematics", "Physics"]',
 '["Economics", "Chemistry", "Geography"]',
 '["General Paper", "Computer Studies"]',
 42,
 '4 years',
 '["Engineering", "Science & Technology"]',
 '["Electrical Engineer", "Power Systems Engineer", "Telecommunications Engineer", "Electronics Engineer", "Project Manager"]'),

('Bachelor of Business Administration',
 'A 3-year program covering management principles, finance, marketing, and entrepreneurship. Prepares students for leadership roles in business and commerce.',
 '["Economics", "Entrepreneurship"]',
 '[]',
 '["General Paper", "Sub Maths", "Computer Studies"]',
 35,
 '3 years',
 '["Business & Management"]',
 '["Business Manager", "Entrepreneur", "Financial Analyst", "Marketing Manager", "Operations Manager"]'),

('Bachelor of Laws',
 'A 4-year legal studies program covering constitutional law, criminal law, contract law, and legal practice. Prepares students for legal careers and advocacy.',
 '[]',
 '[]',
 '["General Paper", "Sub Maths", "Computer Studies"]',
 40,
 '4 years',
 '["Law & Legal Studies"]',
 '["Lawyer", "Legal Advisor", "Judge", "Legal Researcher", "Corporate Counsel"]'),

('Bachelor of Science in Agriculture',
 'A 3-year program focusing on crop production, animal husbandry, agricultural economics, and sustainable farming practices for modern agriculture.',
 '["Biology", "Chemistry", "Agriculture"]',
 '[]',
 '["General Paper", "Sub Maths", "Computer Studies"]',
 35,
 '3 years',
 '["Agriculture & Veterinary", "Science & Technology"]',
 '["Agricultural Officer", "Farm Manager", "Agronomist", "Agricultural Consultant", "Research Scientist"]'),

('Bachelor of Science with Education (Biological)',
 'A 3-year teacher education program providing pedagogical knowledge and teaching methodologies for biological sciences. Prepares students to become professional science educators.',
 '["Biology", "Chemistry"]',
 '["Mathematics", "Physics"]',
 '["General Paper", "Sub Maths", "Computer Studies"]',
 39,
 '3 years',
 '["Education"]',
 '["Secondary School Teacher", "School Administrator", "Education Officer", "Curriculum Developer", "Educational Consultant"]'),

('Bachelor of Arts in Social Work',
 'A 3-year program focusing on social welfare, community development, and helping vulnerable populations. Combines theory with field practice.',
 '[]',
 '[]',
 '["General Paper", "Sub Maths", "Computer Studies"]',
 30,
 '3 years',
 '["Social Sciences", "Arts & Humanities"]',
 '["Social Worker", "Community Development Officer", "Counsellor", "Youth Worker", "Welfare Officer"]');

INSERT INTO `course_universities` (`course_id`, `institution_id`, `application_link`) VALUES
(1, 1, 'https://mak.ac.ug/admissions'),
(1, 2, 'https://must.ac.ug/admissions'),
(2, 1, 'https://mak.ac.ug/admissions'),
(2, 3, 'https://kyu.ac.ug/admissions'),
(3, 1, 'https://mak.ac.ug/admissions'),
(3, 5, 'https://busitema.ac.ug/admissions'),
(4, 1, 'https://mak.ac.ug/admissions'),
(4, 3, 'https://kyu.ac.ug/admissions'),
(5, 1, 'https://mak.ac.ug/admissions'),
(6, 5, 'https://busitema.ac.ug/admissions'),
(7, 3, 'https://kyu.ac.ug/admissions'),
(8, 1, 'https://mak.ac.ug/admissions');

INSERT INTO `course_scholarships` (`course_id`, `scholarship_name`, `scholarship_link`) VALUES
(1, 'Government Medical Scholarship Program', '#'),
(1, 'Medical Excellence Fund', '#'),
(2, 'Technology Innovation Scholarship', '#'),
(3, 'Engineering Excellence Scholarship', '#'),
(4, 'Business Leadership Scholarship', '#');

INSERT INTO `scholarships` (`title`, `institution_id`, `amount`, `deadline`, `description`, `requirements`, `application_url`) VALUES
('Government Scholarship Program', NULL, 'Full Tuition', '2026-03-15', 'Government-funded scholarships for outstanding students in STEM fields', 'Minimum UACE performance as advertised', NULL),
('Mastercard Foundation Scholars Program', 1, 'Full Scholarship', '2026-04-30', 'Comprehensive scholarship covering tuition, accommodation, and living expenses', 'Financial need, academic excellence, leadership potential', 'https://mak.ac.ug'),
('Rural Development Scholarship', 2, 'Full Tuition + Stipend', '2026-04-20', 'Scholarship for students from rural areas pursuing agriculture and development studies', 'Rural background; agriculture or development-related programs', 'https://must.ac.ug');
