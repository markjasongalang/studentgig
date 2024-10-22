-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 10:34 AM
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
  `status` varchar(10) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `gig_id`, `student`, `date_applied`, `status`) VALUES
(1, 21, 'student_admin', '2024-10-22 03:07:08', 'pending'),
(2, 20, 'student_admin', '2024-10-22 03:08:41', 'pending'),
(3, 19, 'student_admin', '2024-10-22 03:10:42', 'pending');

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
(10, 'Part-Time Tutor for Math/Science', 'gig_admin', 24, 'months', 'Ratione sint lorem', 'Officia consectetur', 'A modi repudiandae u', 16.00, 'month', 'Hybrid', 'Perferendis autem mo', '2024-10-21 07:08:43', 'active', '2024-10-31 08:58:57'),
(11, 'Tutor for Midterms (Python Programming)', 'gig_admin', 49, 'days', 'Sed egestas urna et ipsum bibendum accumsan. Fusce tortor nisi, rhoncus vel eleifend sit amet, malesuada vel velit. Suspendisse quis turpis sodales purus pellentesque sollicitudin vel vitae est. Aliquam sed efficitur nisi. Curabitur elementum diam nec varius tristique. Nam vel metus pretium, hendrerit massa eget, posuere quam. Nullam mauris neque, consequat in dapibus quis, laoreet ac quam.\r\n\r\nFusce venenatis at erat ut hendrerit. Ut dignissim tortor a enim rhoncus elementum. Donec mattis viverra mi et ultrices. Sed velit sapien, sagittis id metus ac, suscipit tristique libero. Pellentesque et turpis malesuada, lobortis dolor ut, egestas elit. Duis quis interdum sapien. Vivamus ut interdum tortor, a lobortis nulla. Vivamus sodales risus in magna elementum auctor. In et finibus enim. Vivamus mattis viverra dolor, id venenatis mauris egestas vitae.', 'Iure explicabo Saep', 'Consequatur fugiat', 580.76, 'hour', 'Onsite', 'Padre Paredes St, Sampaloc, Manila, 1015 Metro Manila', '2024-10-21 07:08:50', 'active', '2024-10-31 08:49:52'),
(12, 'Doloribus commodo qu', 'gig_admin', 74, 'months', 'Autem voluptas neque', 'Labore alias cupidit', 'Officia dicta commod', 49.00, 'hour', 'Onsite', 'SM Mall of Asia, Seaside Blvd, Pasay, 1300 Metro Manila', '2024-10-21 07:08:56', 'closed', '2024-10-31 03:41:00'),
(13, 'Graphic Designer for event flyers (Urgent!!)', 'gig_admin', 27, 'months', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu finibus sapien, ut finibus ipsum. Phasellus id purus nibh. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac dui consequat, laoreet ex a, porttitor sapien. Nunc ut varius dolor, ac sodales lacus. Donec fermentum at purus at condimentum. Donec arcu ligula, lobortis ac ipsum sit amet, feugiat commodo sapien. Vivamus eu egestas magna. Pellentesque vitae nisi a odio varius tristique eu maximus ante. Duis sit amet tristique urna. Vivamus egestas condimentum tincidunt. Aliquam nec elementum tellus.\r\n\r\nFusce aliquam non libero ut efficitur. Integer auctor cursus justo, convallis molestie leo sagittis et. Proin sed metus malesuada, lobortis purus at, posuere lorem. Mauris libero turpis, varius sit amet arcu commodo, eleifend pretium purus. Fusce tincidunt urna quis vulputate ultrices. Nam arcu mauris, semper in porta quis, gravida eget ligula. Aliquam sed sapien vitae enim gravida imperdiet. Mauris euismod ante ac nulla iaculis, sed efficitur augue iaculis. Phasellus non ante a justo venenatis pretium. Suspendisse eu ligula dolor.', 'Sed egestas urna et ipsum bibendum accumsan. Fusce tortor nisi, rhoncus vel eleifend sit amet, malesuada vel velit. Suspendisse quis turpis sodales purus pellentesque sollicitudin vel vitae est. Aliquam sed efficitur nisi. Curabitur elementum diam nec varius tristique. Nam vel metus pretium, hendrerit massa eget, posuere quam. Nullam mauris neque, consequat in dapibus quis, laoreet ac quam.', 'Fusce venenatis at erat ut hendrerit. Ut dignissim tortor a enim rhoncus elementum. Donec mattis viverra mi et ultrices. Sed velit sapien, sagittis id metus ac, suscipit tristique libero. Pellentesque et turpis malesuada, lobortis dolor ut, egestas elit. Duis quis interdum sapien. Vivamus ut interdum tortor, a lobortis nulla. Vivamus sodales risus in magna elementum auctor. In et finibus enim. Vivamus mattis viverra dolor, id venenatis mauris egestas vitae.', 900.00, 'hour', 'Remote', '', '2024-10-21 07:08:59', 'closed', '2024-10-31 03:36:47'),
(14, 'Voluptates vel labor', 'gig_admin', 61, 'weeks', 'Nulla tincidunt metus ac nunc finibus, nec consectetur diam vestibulum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque lacus dolor, volutpat ut condimentum eu, bibendum eget lectus. Ut posuere magna non quam porta, vel tristique massa vulputate. Donec luctus arcu metus, vitae efficitur purus porttitor vel. Vestibulum euismod lorem sed tellus vestibulum, eget viverra augue fringilla. In tincidunt gravida tincidunt.\r\n\r\nCras efficitur erat purus, sit amet tempor felis cursus quis. Nam dignissim, nisi a suscipit bibendum, mi nisi fermentum diam, viverra pellentesque orci nibh sed ligula. Sed ante mauris, iaculis ut maximus quis, mollis et nisl.', 'Occaecat rem sunt r', 'Ea dolorem est ea s', 6500.00, 'hour', 'Hybrid', 'Esse omnis sequi ma', '2024-10-21 14:22:11', 'closed', '2024-10-31 08:47:37'),
(15, 'Short-Term Virtual Assistant', 'gig_admin', 61, 'days', 'Non debitis sint ips', 'Nam labore assumenda', 'Quisquam reiciendis', 71.00, 'submission', 'Onsite', 'Duis neque ut volupt', '2024-10-21 14:53:59', 'active', '2024-10-31 08:58:47'),
(16, 'Data Entry Specialist for One-Time Project', 'gig_admin', 9, 'weeks', 'Id dolor quia quod q', 'Minus est obcaecati', 'Ratione sint culpa m', 18.00, 'month', 'Remote', '', '2024-10-21 14:56:52', 'active', '2024-10-31 08:58:38'),
(17, 'Graphic Designer for Event Flyers', 'gig_admin', 86, 'weeks', 'Voluptas aut volupta', 'Nulla non praesentiu', 'Est in suscipit labo', 95.00, 'day', 'Onsite', 'Saepe facere nihil n', '2024-10-21 14:56:57', 'active', '2024-10-31 08:58:30'),
(18, 'Social Media Manager for a Week', 'gig_admin', 83, 'days', 'Lorem do vitae in qu', 'A sit eligendi quo', 'Qui est iusto dolor', 71.00, 'week', 'Onsite', 'Molestiae animi est', '2024-10-21 14:57:09', 'active', '2024-10-31 08:58:20'),
(19, 'Onsite Photographer for Event', 'gig_admin', 42, 'months', 'Excepturi expedita q', 'Sed itaque dolores q', 'Dicta aliquam sit a', 57.00, 'month', 'Onsite', 'Quis eos assumenda', '2024-10-21 14:59:17', 'active', '2024-10-31 08:59:17'),
(20, 'Brand Ambassador for Weekend Event', 'gig_admin', 3, 'weeks', 'Aliquid maiores volu', 'Sed minim incidunt', 'Eaque et aut incidun', 48.00, 'hour', 'Onsite', 'Voluptates mollit ul', '2024-10-21 14:59:33', 'active', '2024-10-31 08:59:33'),
(21, 'Video Editor for a Project', 'gig_admin', 86, 'weeks', 'Suscipit neque suscipit fames eros vitae massa. Pretium phasellus tempus risus nibh volutpat. Torquent convallis lacus integer scelerisque mi vestibulum euismod neque. Litora sit integer iaculis lacus dolor auctor morbi iaculis. Commodo maximus congue montes litora lobortis dapibus rutrum hac. Faucibus sed blandit nascetur elementum purus ultricies vitae fermentum. Pretium nascetur neque vestibulum porta nunc. Lectus vehicula per odio pellentesque metus nec mus dis. Quisque porta fusce et nullam convallis venenatis ex.\r\n\r\nNunc platea pretium, sociosqu accumsan volutpat quisque. Inceptos fringilla ante vitae neque ex orci malesuada varius? Habitant dui volutpat habitant, potenti elit dis morbi inceptos. Cursus maximus metus cubilia mus lobortis; magnis magna. Nunc dictum curae potenti accumsan sollicitudin hac. Vestibulum morbi duis orci donec condimentum ultrices ac. Mauris pharetra proin ac condimentum parturient laoreet parturient taciti.', 'Curabitur non feugiat arcu. Etiam non magna quis risus viverra fermentum. Duis pellentesque convallis mauris, quis dignissim purus hendrerit a. Suspendisse nec elementum dolor, a dictum quam. Morbi nisi erat, lobortis in accumsan vitae, lobortis at odio. Curabitur porttitor ex ut ipsum porttitor, et bibendum enim aliquam. Duis a lorem elementum, tempus urna eu, consectetur nibh. Ut volutpat porttitor nibh non ultrices.', 'Luctus efficitur curabitur sit ad posuere sodales primis augue eget. Neque sollicitudin libero ac aliquet inceptos nunc potenti? Cursus ultrices aenean venenatis ante neque inceptos cras. Vitae nisl ante;', 88.00, 'hour', 'Hybrid', 'Ex qui tempore quis', '2024-10-21 23:37:03', 'active', '2024-10-31 21:11:34');

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

INSERT INTO `gig_creators` (`id`, `username`, `email`, `first_name`, `last_name`, `company`, `profile_image_path`, `valid_id_image_path`, `birthdate`, `date_joined`, `terms_and_privacy`, `password`) VALUES
('aa0d4553-9329-417b-80c6-e7f21b601a17', 'gig_admin', 'zohave@mailinator.com', 'Phelan', 'Crane', 'Henson Weber Associates', '../uploads/gig-creators/profile-images/aa0d4553-9329-417b-80c6-e7f21b601a17/file_6715397b67e194.17299822.png', '../uploads/gig-creators/valid-ids/aa0d4553-9329-417b-80c6-e7f21b601a17/file_6713d0e4b37952.31005043.png', '1999-07-14', '2024-10-19 15:32:03', 'agree', '$2y$10$MVTYotGhQSvrbagdE8tlY.CjfrpAse/.0k2g6pcpkoh4Burv2spNy');

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
('02c8018f-ee82-49ae-a206-61', 'student_admin', 'markjasongalang.work@gmail.com', 'Hilel', 'Dickson', 'Sed vel quasi fugiat', '2001', 'Cillum maiores fuga', NULL, '../uploads/students/student-ids/02c8018f-ee82-49ae-a206-61b04c2036b3/file_6713d1c3ccaea4.22700188.png', '1983-02-12', '2024-10-19 15:35:44', 'agree', '$2y$10$2DL6VfobwGcMXkVCFiByDeOeKgwAj7kz4lVjpmZCRHnis3azQ4YG2');

-- --------------------------------------------------------

--
-- Table structure for table `students_about_me`
--

CREATE TABLE `students_about_me` (
  `id` int(11) NOT NULL,
  `student` varchar(255) NOT NULL,
  `skills` text DEFAULT NULL,
  `contact_info` text DEFAULT NULL,
  `work_exp` text DEFAULT NULL,
  `certifications` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_about_me`
--

INSERT INTO `students_about_me` (`id`, `student`, `skills`, `contact_info`, `work_exp`, `certifications`) VALUES
(3, 'student_admin', NULL, NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gigs`
--
ALTER TABLE `gigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `students_about_me`
--
ALTER TABLE `students_about_me`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `gigs`
--
ALTER TABLE `gigs`
  ADD CONSTRAINT `gigs_ibfk_1` FOREIGN KEY (`gig_creator`) REFERENCES `gig_creators` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `students_about_me`
--
ALTER TABLE `students_about_me`
  ADD CONSTRAINT `students_about_me_ibfk_1` FOREIGN KEY (`student`) REFERENCES `students` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
