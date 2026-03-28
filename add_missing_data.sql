-- Add missing universities (corrected version for existing database schema)
USE `educareer_db`;

-- First, check if universities already exist to avoid duplicates
INSERT IGNORE INTO `institutions` (`name`, `short_description`, `address`, `region`, `contact_email`, `phone`, `website`) VALUES
('Gulu University', 'Northern Uganda\'s premier public university', 'Gulu', 'Northern', 'ar@gu.ac.ug', '+256-471-432921', 'www.gu.ac.ug'),
('Busitema University', 'Multi-campus public university focusing on agriculture and engineering', 'Tororo', 'Eastern', 'ar@acadreg.busitema.ac.ug', '+256-454448842', 'www.busitema.ac.ug'),
('Muni University', 'Public university in West Nile region', 'Arua', 'Northern', 'ar@muni.ac.ug', '+256-476-420312', 'www.muni.ac.ug'),
('Kabale University', 'Public university in southwestern Uganda', 'Kabale', 'Western', 'registrar@kab.ac.ug', '+256-4864-26463', 'www.kab.ac.ug'),
('Lira University', 'Public university in northern Uganda', 'Lira', 'Northern', 'academicregistrar@lirauni.ac.ug', '+256-471-660709', 'www.lirauni.ac.ug'),
('Soroti University', 'Public university in eastern Uganda', 'Soroti', 'Eastern', 'ar@sun.ac.ug', '+256-454-961605', 'www.sun.ac.ug'),
('Mountains of the Moon University', 'Public university in western Uganda', 'Fort Portal', 'Western', 'registrar@mmu.ac.ug', '+256-483-660390', 'www.mmu.ac.ug');

-- Add sample courses for the new universities with proper weighting system
INSERT IGNORE INTO `courses` (`name`, `description`, `essential_subjects`, `relevant_subjects`, `desirable_subjects`, `minimum_points`, `duration`, `career_fields`, `career_opportunities`) VALUES
('Bachelor of Science in Agriculture', 'A comprehensive program focusing on crop production, animal husbandry, and sustainable farming practices.', '[\"Biology\", \"Chemistry\", \"Agriculture\"]', '[\"Mathematics\", \"Geography\"]', '[\"General Paper\", \"Sub Maths\", \"Computer Studies\"]', 35, '4 years', '[\"Agriculture & Veterinary\"]', '[\"Agricultural Officer\", \"Farm Manager\", \"Agronomist\", \"Agricultural Consultant\", \"Research Scientist\"]'),
('Bachelor of Arts in Social Work', 'A program focusing on social welfare, community development, and helping vulnerable populations.', '[]', '[]', '[\"General Paper\", \"Sub Maths\", \"Computer Studies\"]', 30, '3 years', '[\"Social Sciences\"]', '[\"Social Worker\", \"Community Development Officer\", \"Counsellor\", \"Youth Worker\", \"Welfare Officer\"]'),
('Bachelor of Science in Civil Engineering', 'A program covering structural design, construction management, and infrastructure development.', '[\"Mathematics\", \"Physics\"]', '[\"Chemistry\", \"Geography\"]', '[\"General Paper\", \"Computer Studies\"]', 42, '4 years', '[\"Engineering\"]', '[\"Civil Engineer\", \"Structural Engineer\", \"Construction Manager\", \"Project Manager\", \"Urban Planner\"]'),
('Bachelor of Business Administration', 'A comprehensive business program covering management, finance, and entrepreneurship.', '[\"Mathematics\", \"Economics\"]', '[\"Literature\", \"History\", \"Geography\"]', '[\"General Paper\", \"Computer Studies\"]', 35, '3 years', '[\"Business & Management\"]', '[\"Business Manager\", \"Entrepreneur\", \"Financial Analyst\", \"Marketing Manager\", \"Operations Manager\"]');

-- Note: The course_universities and course_scholarships links will need to be added manually after you check the actual IDs
-- Please run the check_institution_ids.php and check_course_ids.php scripts to get the correct IDs