-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 02:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentgig`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `student` varchar(255) NOT NULL,
  `date_applied` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `gig_id`, `student`, `date_applied`, `status`) VALUES
(1, 1, 'nicolas', '2024-10-29 00:57:13', 'Pending'),
(2, 6, 'nicolas', '2024-10-29 00:57:16', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` char(36) NOT NULL,
  `student` varchar(255) NOT NULL,
  `gig_creator` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gig_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `student`, `gig_creator`, `created_at`, `gig_id`) VALUES
('6f77316a-47f0-4938-aa16-4ac7239655da', 'nicolas', 'wilburn', '2024-10-29 01:01:19', 6);

-- --------------------------------------------------------

--
-- Table structure for table `gigs`
--

CREATE TABLE `gigs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `gig_creator` varchar(255) NOT NULL,
  `duration_value` int(11) NOT NULL,
  `duration_unit` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `skills` text NOT NULL,
  `schedule` text NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_unit` varchar(255) NOT NULL,
  `gig_type` varchar(10) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `expiration` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gigs`
--

INSERT INTO `gigs` (`id`, `title`, `gig_creator`, `duration_value`, `duration_unit`, `description`, `skills`, `schedule`, `payment_amount`, `payment_unit`, `gig_type`, `address`, `date_posted`, `status`, `expiration`) VALUES
(1, 'Junior Web Developer', 'wilburn', 2, 'months', 'Join a dynamic team to assist in developing new features for our main website. This role involves coding, debugging, and implementing changes based on user feedback. You’ll be working closely with senior developers who will guide you in enhancing your coding practices. Ideal for a student looking to expand their front-end development skills.', 'Proficient in HTML, CSS, and JavaScript; understanding of responsive design; experience with debugging tools; willingness to learn and adapt in a collaborative environment.', '15 hours per week', 200.00, 'hour', 'Remote', '', '2024-10-29 00:47:53', 'active', '2024-11-07 17:47:53'),
(2, 'Data Entry Specialist', 'wilburn', 3, 'weeks', 'We need a highly detail-oriented individual to transfer large volumes of data from physical documents into our secure online system. You’ll play a crucial role in ensuring data accuracy and consistency across various platforms, helping streamline our digital records. This is an excellent opportunity for students aiming to build administrative and data management skills.', 'Strong proficiency in Microsoft Excel; ability to maintain focus over extended periods; high attention to detail; experience with digital filing or data entry systems is a plus.', '20 hours per week', 150.00, 'hour', 'Onsite', 'Makati City', '2024-10-29 00:48:45', 'active', '2024-11-07 17:48:45'),
(3, 'IT Support Assistant', 'wilburn', 1, 'months', 'Assist our IT team by troubleshooting software, hardware, and basic networking issues remotely. Your role will involve identifying problems quickly and efficiently and ensuring minimal downtime for staff. Great for students who want hands-on experience in IT support and enjoy helping others solve technical issues.', 'Familiarity with troubleshooting steps for common software and hardware issues; experience with Windows OS; basic understanding of networking concepts; strong communication skills to provide clear and concise instructions.', '10 hours per week, flexible', 250.00, 'hour', 'Remote', '', '2024-10-29 00:49:08', 'active', '2024-11-07 17:49:08'),
(4, 'Content Writer for Lifestyle Blog', 'wilburn', 1, 'months', 'We’re seeking a creative writer to contribute engaging articles on travel, food, health, and lifestyle topics. Articles should capture the reader’s attention while delivering valuable insights and information. You’ll also be encouraged to bring in your unique style and perspectives. Perfect for students looking to enhance their writing portfolio.', 'Strong writing skills; creativity in generating new topics; familiarity with SEO best practices; ability to research and write accurately on various subjects.', '10 articles per month, flexible timing', 500.00, 'submission', 'Remote', '', '2024-10-29 00:50:39', 'active', '2024-11-07 17:50:39'),
(5, 'Social Media Assistant', 'wilburn', 3, 'months', 'Assist our team in managing social media platforms, creating visual content, and scheduling posts. You’ll also engage with followers, help analyze metrics, and suggest strategies to increase engagement. This role is ideal for students interested in gaining experience in social media management and learning the behind-the-scenes of digital marketing.', 'Basic knowledge of graphic design tools like Canva or Photoshop; understanding of social media trends and engagement strategies; ability to communicate effectively and professionally online; knowledge of basic analytics tools is a plus.', '5 hours per week', 200.00, 'hour', 'Remote', '', '2024-10-29 00:51:04', 'active', '2024-11-07 17:51:04'),
(6, 'Event Photography Assistant', 'wilburn', 1, 'days', 'Support our lead photographer during an upcoming corporate event by managing equipment, setting up shots, and capturing candid moments. This is a one-day gig, but you’ll gain valuable insights into professional photography. Ideal for students passionate about photography who want hands-on experience in an event setting.', 'Basic understanding of photography concepts (lighting, composition); comfortable using DSLR cameras; attention to detail to ensure all shots are well-composed; teamwork skills to assist and communicate effectively with the lead photographer.', 'Full day', 1500.00, 'day', 'Onsite', 'Quezon City', '2024-10-29 00:51:31', 'active', '2024-11-07 17:51:31'),
(7, 'Virtual Personal Assistant', 'wilburn', 2, 'weeks', 'Provide organizational support to a freelance consultant, helping manage schedules, answer emails, and organize to-do lists. This role requires exceptional time management skills and a proactive approach to task management. Perfect for students interested in learning more about time management and organizational skills in a remote setting.', 'Excellent time management and organizational skills; strong written communication abilities; proficiency with scheduling and task management tools; ability to work independently and anticipate needs.', '10 hours per week', 200.00, 'hour', 'Remote', '', '2024-10-29 00:52:04', 'active', '2024-11-07 17:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `gig_creators`
--

CREATE TABLE `gig_creators` (
  `id` char(36) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `free_gig_posts` int(11) NOT NULL DEFAULT 3,
  `profile_image_path` varchar(255) DEFAULT NULL,
  `valid_id_image_path` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `terms_and_privacy` varchar(6) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gig_creators`
--

INSERT INTO `gig_creators` (`id`, `username`, `email`, `first_name`, `last_name`, `company`, `free_gig_posts`, `profile_image_path`, `valid_id_image_path`, `birthdate`, `date_joined`, `terms_and_privacy`, `password`) VALUES
('95f6a8ba-775d-40b3-a277-d7b1d4ec69bc', 'wilburn', 'markjasongalang.work@gmail.com', 'Wilburn', 'Lubowitz', 'McKenzie - Hermann', 6, '../uploads/gig-creators/profile-images/95f6a8ba-775d-40b3-a277-d7b1d4ec69bc/file_67203003963663.83312892.jfif', '../uploads/gig-creators/valid-ids/95f6a8ba-775d-40b3-a277-d7b1d4ec69bc/file_67202f232ee430.51341119.png', '2025-05-25', '2024-10-29 00:41:20', 'agree', '$2y$10$JmR4S1aaRvpKY081dI0IoOTUkdeVxVHkTKlth585aOeRPSkB8kELO');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` char(36) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `sender`, `message`, `sent_at`) VALUES
(1, '6f77316a-47f0-4938-aa16-4ac7239655da', 'wilburn', 'Hi, I saw your profile, you seem fit for this gig!', '2024-10-29 01:01:19'),
(2, '6f77316a-47f0-4938-aa16-4ac7239655da', 'nicolas', 'Thank you Mr. Wilburn :)', '2024-10-29 01:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` char(26) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `university` varchar(255) NOT NULL,
  `year_level` varchar(10) NOT NULL,
  `degree_program` varchar(255) NOT NULL,
  `profile_image_path` varchar(255) DEFAULT NULL,
  `student_id_image_path` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `terms_and_privacy` varchar(6) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `username`, `email`, `first_name`, `last_name`, `university`, `year_level`, `degree_program`, `profile_image_path`, `student_id_image_path`, `birthdate`, `date_joined`, `terms_and_privacy`, `password`) VALUES
('45568e91-bd7e-4b1a-97cd-eb', 'nicolas', 'markjasongalang3@gmail.com', 'Nicolas', 'Anderson', 'University of Manila', '3rd Year', 'B.S. in Information Technology', '../uploads/students/profile-images/45568e91-bd7e-4b1a-97cd-eb/file_6720326284c318.74933016.png', '../uploads/students/student-ids/45568e91-bd7e-4b1a-97cd-ebe5d8dc1b27/file_6720321bc74136.83106541.png', '2024-01-28', '2024-10-29 00:54:01', 'agree', '$2y$10$3mnDESSv4Cknu/2t8Hu7..E7exEPIIitP7DWPoaMKrAFC.MrPiX6e');

-- --------------------------------------------------------

--
-- Table structure for table `students_about_me`
--

CREATE TABLE `students_about_me` (
  `id` int(11) NOT NULL,
  `student` varchar(255) NOT NULL,
  `skills` text DEFAULT NULL,
  `work_exp` text DEFAULT NULL,
  `certifications` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_about_me`
--

INSERT INTO `students_about_me` (`id`, `student`, `skills`, `work_exp`, `certifications`) VALUES
(1, 'nicolas', 'Programming Languages: Proficient in Java, Python, and JavaScript, with experience in web development using HTML, CSS, and PHP.\r\n\r\nDatabase Management: Familiar with MySQL, MongoDB, and database design principles.\r\nFront-End Development: Knowledgeable in React and Bootstrap for building responsive web applications.\r\nGraphic Design: Skilled in Adobe Photoshop and Canva for creating visuals and graphics for social media content.\r\n\r\nContent Creation: Experience in content planning, video editing (Adobe Premiere Pro), and social media management.\r\n\r\nPhotography: Intermediate photography skills with experience in portrait and product photography.\r\n\r\nProject Management: Familiar with Trello and Asana for organizing tasks and team collaboration.\r\nSoft Skills: Strong problem-solving abilities, attention to detail, effective time management, and adaptability.', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `verification_codes`
--

CREATE TABLE `verification_codes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL,
  `is_verified` tinyint(4) NOT NULL DEFAULT 0,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verification_codes`
--

INSERT INTO `verification_codes` (`id`, `email`, `code`, `is_verified`, `expires_at`) VALUES
(1, 'markjasongalang.work@gmail.com', '291539', 1, '2024-10-28 17:51:12'),
(2, 'markjasongalang3@gmail.com', '960264', 1, '2024-10-28 18:03:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gig_id` (`gig_id`),
  ADD KEY `student` (`student`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student` (`student`),
  ADD KEY `gig_creator` (`gig_creator`),
  ADD KEY `gig_id` (`gig_id`);

--
-- Indexes for table `gigs`
--
ALTER TABLE `gigs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gig_creator` (`gig_creator`);

--
-- Indexes for table `gig_creators`
--
ALTER TABLE `gig_creators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `students_about_me`
--
ALTER TABLE `students_about_me`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student` (`student`);

--
-- Indexes for table `verification_codes`
--
ALTER TABLE `verification_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gigs`
--
ALTER TABLE `gigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students_about_me`
--
ALTER TABLE `students_about_me`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`gig_id`) REFERENCES `gigs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `applicants_ibfk_2` FOREIGN KEY (`student`) REFERENCES `students` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`student`) REFERENCES `students` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`gig_creator`) REFERENCES `gig_creators` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `chats_ibfk_3` FOREIGN KEY (`gig_id`) REFERENCES `gigs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `gigs`
--
ALTER TABLE `gigs`
  ADD CONSTRAINT `gigs_ibfk_1` FOREIGN KEY (`gig_creator`) REFERENCES `gig_creators` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `students_about_me`
--
ALTER TABLE `students_about_me`
  ADD CONSTRAINT `students_about_me_ibfk_1` FOREIGN KEY (`student`) REFERENCES `students` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
