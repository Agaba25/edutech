-- Adding real institution data from Uganda
-- Insert sample institutions data for Uganda
-- Database: educareer_db

USE educareer_db;

-- Clear existing data
TRUNCATE TABLE institutions;

-- Insert major Ugandan universities and institutions
INSERT INTO institutions (name, short_description, full_description, region, address, phone, contact_email, website, logo_url, created_at) VALUES
('Makerere University', 'Uganda\'s oldest and most prestigious university', 'Makerere University is Uganda\'s largest and oldest institution of higher learning, first established as a technical school in 1922. It became an independent national university in 1970. The university offers programs in various fields including medicine, engineering, business, and humanities.', 'Central', 'P.O. Box 7062, Kampala', '+256-414-542-803', 'info@mak.ac.ug', 'https://www.mak.ac.ug', NULL, NOW()),

('Kampala International University', 'Leading private university in East Africa', 'Kampala International University (KIU) is one of the leading private universities in Uganda and East Africa. Established in 2001, KIU offers a wide range of undergraduate and postgraduate programs in medicine, engineering, business, law, and education.', 'Central', 'P.O. Box 20000, Kampala', '+256-414-266-813', 'info@kiu.ac.ug', 'https://www.kiu.ac.ug', NULL, NOW()),

('Kyambogo University', 'Excellence in vocational and technical education', 'Kyambogo University was established in 2003 following the merger of the Institute of Teacher Education Kyambogo (ITEK), Uganda Polytechnic Kyambogo (UPK), and the Uganda National Institute of Special Education (UNISE). The university specializes in engineering, education, and vocational studies.', 'Central', 'P.O. Box 1, Kyambogo, Kampala', '+256-414-285-001', 'info@kyu.ac.ug', 'https://www.kyu.ac.ug', NULL, NOW()),

('Mbarara University of Science and Technology', 'Premier institution for science and technology', 'Mbarara University of Science and Technology (MUST) was established in 1989 as a public university. It is known for its strong programs in medicine, nursing, pharmacy, and development studies. MUST is located in southwestern Uganda.', 'Western', 'P.O. Box 1410, Mbarara', '+256-485-420-782', 'info@must.ac.ug', 'https://www.must.ac.ug', NULL, NOW()),

('Uganda Christian University', 'Faith-based holistic education', 'Uganda Christian University (UCU) is a private Christian university established in 1997. It offers programs in theology, business, law, social sciences, and health sciences. UCU emphasizes character development alongside academic excellence.', 'Central', 'P.O. Box 4, Mukono', '+256-312-350-800', 'info@ucu.ac.ug', 'https://www.ucu.ac.ug', NULL, NOW()),

('Busitema University', 'Science and technology innovation hub', 'Busitema University is a public university established in 2007, focusing on science, technology, and innovation. It has multiple campuses across eastern Uganda and offers programs in engineering, agriculture, health sciences, and education.', 'Eastern', 'P.O. Box 236, Tororo', '+256-454-444-121', 'info@busitema.ac.ug', 'https://www.busitema.ac.ug', NULL, NOW()),

('Gulu University', 'Transforming northern Uganda through education', 'Gulu University was established in 2002 to serve the educational needs of northern Uganda. It offers programs in agriculture, business, education, medicine, and law. The university plays a crucial role in post-conflict development.', 'Northern', 'P.O. Box 166, Gulu', '+256-471-432-084', 'info@gu.ac.ug', 'https://www.gu.ac.ug', NULL, NOW()),

('Makerere University Business School', 'Leading business education institution', 'Makerere University Business School (MUBS) is a constituent college of Makerere University, specializing in business and management education. Established in 1997, MUBS offers undergraduate and postgraduate programs in business administration, accounting, and entrepreneurship.', 'Central', 'P.O. Box 1337, Kampala', '+256-414-251-171', 'info@mubs.ac.ug', 'https://www.mubs.ac.ug', NULL, NOW()),

('Uganda Martyrs University', 'Catholic university with strong values', 'Uganda Martyrs University (UMU) is a private Catholic university established in 1993. It offers programs in business, education, health sciences, and social sciences. UMU emphasizes ethical leadership and community service.', 'Central', 'P.O. Box 5498, Kampala', '+256-414-410-611', 'info@umu.ac.ug', 'https://www.umu.ac.ug', NULL, NOW()),

('Islamic University in Uganda', 'Islamic values and modern education', 'Islamic University in Uganda (IUIU) was established in 1988 as a private Islamic university. It offers programs in Islamic studies, education, management, science, and law. IUIU has multiple campuses across Uganda.', 'Eastern', 'P.O. Box 2555, Mbale', '+256-454-433-021', 'info@iuiu.ac.ug', 'https://www.iuiu.ac.ug', NULL, NOW()),

('Nkumba University', 'Practical skills for the job market', 'Nkumba University is a private university established in 1994, located in Entebbe. It offers programs in business, education, science, and social sciences with a focus on practical skills and employability.', 'Central', 'P.O. Box 237, Entebbe', '+256-414-320-452', 'info@nkumbauniversity.ac.ug', 'https://www.nkumbauniversity.ac.ug', NULL, NOW()),

('Ndejje University', 'Holistic education for development', 'Ndejje University is a private university established in 1992. It offers programs in education, business, theology, and social sciences. The university has multiple campuses and emphasizes community development.', 'Central', 'P.O. Box 7088, Kampala', '+256-414-697-441', 'info@ndejjeuniversity.ac.ug', 'https://www.ndejjeuniversity.ac.ug', NULL, NOW()),

('Mountains of the Moon University', 'Excellence in western Uganda', 'Mountains of the Moon University is a private university established in 2005, located in Fort Portal. It offers programs in business, education, health sciences, and development studies, serving the western region of Uganda.', 'Western', 'P.O. Box 837, Fort Portal', '+256-483-422-580', 'info@mmu.ac.ug', 'https://www.mmu.ac.ug', NULL, NOW()),

('Kabale University', 'Serving southwestern Uganda', 'Kabale University is a public university established in 2001, located in southwestern Uganda. It offers programs in business, education, science, and development studies with a focus on regional development.', 'Western', 'P.O. Box 317, Kabale', '+256-486-424-701', 'info@kab.ac.ug', 'https://www.kab.ac.ug', NULL, NOW()),

('Bishop Stuart University', 'Anglican values and academic excellence', 'Bishop Stuart University is a private Anglican university established in 2002, located in Mbarara. It offers programs in education, business, theology, and development studies with emphasis on Christian values.', 'Western', 'P.O. Box 9, Mbarara', '+256-485-420-951', 'info@bsu.ac.ug', 'https://www.bsu.ac.ug', NULL, NOW()),

('Uganda Technical College - Kichwamba', 'Technical and vocational training', 'Uganda Technical College Kichwamba is a leading technical institution offering diploma and certificate programs in engineering, construction, and technical fields. It prepares students for practical careers in industry.', 'Western', 'P.O. Box 109, Kabarole', '+256-483-444-025', 'info@utc-kichwamba.ac.ug', 'https://www.utc-kichwamba.ac.ug', NULL, NOW()),

('Uganda Technical College - Lira', 'Northern Uganda technical education', 'Uganda Technical College Lira provides technical and vocational education in northern Uganda. It offers programs in mechanical engineering, electrical engineering, and construction with hands-on training.', 'Northern', 'P.O. Box 6, Lira', '+256-473-420-123', 'info@utc-lira.ac.ug', 'https://www.utc-lira.ac.ug', NULL, NOW()),

('Soroti University', 'Serving eastern Uganda', 'Soroti University is a public university established in 2015, located in eastern Uganda. It offers programs in agriculture, business, education, and health sciences, focusing on regional development and innovation.', 'Eastern', 'P.O. Box 211, Soroti', '+256-454-461-001', 'info@su.ac.ug', 'https://www.su.ac.ug', NULL, NOW());
