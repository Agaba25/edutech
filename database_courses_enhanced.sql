-- Enhanced Course Finder Database Structure
-- Run this after database.sql

-- Changed database name from edutech_db to educareer_db
USE `educareer_db`;

-- Enhanced courses table with all required fields for matching
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Course-University associations
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Course Scholarships
CREATE TABLE IF NOT EXISTS `course_scholarships` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_id` INT NOT NULL,
  `scholarship_name` VARCHAR(255) NOT NULL,
  `scholarship_link` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  INDEX `idx_course` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Course Data
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

-- Link courses to universities
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

-- Add scholarships
INSERT INTO `course_scholarships` (`course_id`, `scholarship_name`, `scholarship_link`) VALUES
(1, 'Government Medical Scholarship Program', '#'),
(1, 'Medical Excellence Fund', '#'),
(2, 'Technology Innovation Scholarship', '#'),
(3, 'Engineering Excellence Scholarship', '#'),
(4, 'Business Leadership Scholarship', '#');
