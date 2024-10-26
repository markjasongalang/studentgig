-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 05:54 PM
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
(1, 21, 'student_admin', '2024-10-23 12:15:55', 'Accepted'),
(2, 20, 'student_admin', '2024-10-23 12:15:58', 'Pending'),
(3, 19, 'student_admin', '2024-10-23 12:16:02', 'Invited'),
(4, 18, 'student_admin', '2024-10-23 12:16:05', 'Pending'),
(5, 16, 'student_admin', '2024-10-23 12:16:08', 'Pending'),
(6, 21, 'jason_admin', '2024-10-23 12:16:17', 'Pending'),
(7, 20, 'jason_admin', '2024-10-23 12:16:20', 'Invited'),
(8, 11, 'jason_admin', '2024-10-23 12:16:26', 'Accepted'),
(9, 10, 'jason_admin', '2024-10-23 12:16:34', 'Accepted'),
(10, 16, 'jason_admin', '2024-10-23 12:24:34', 'Accepted'),
(11, 26, 'student_admin', '2024-10-25 07:08:42', 'Accepted');

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
('34d8f036-caf0-40bf-ba4b-15385464634e', 'jason_admin', 'gig_admin', '2024-10-24 07:08:03', 21),
('48ef379f-52a4-4945-9945-a278698a1afc', 'student_admin', 'gig_admin', '2024-10-24 12:41:05', 18),
('99aecac5-55ad-4e0b-ab77-3e6e8d1ed758', 'jason_admin', 'gig_admin', '2024-10-24 12:40:10', 20),
('9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'student_admin', 'gig_admin', '2024-10-26 13:14:37', 19),
('df47ab7f-8cb8-4fa6-a084-be7f6fb3d452', 'student_admin', 'gig_admin', '2024-10-25 07:10:12', 26),
('e61e39a4-772e-4c45-a22f-3808ba5c44c6', 'student_admin', 'gig_admin', '2024-10-24 12:31:44', 20),
('f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'gig_admin', '2024-10-24 07:07:04', 21);

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
(15, 'Short-Term Virtual Assistant', 'gig_admin', 61, 'days', 'Non debitis sint ips', 'Nam labore assumenda', 'Quisquam reiciendis', 71.00, 'submission', 'Onsite', 'Duis neque ut volupt', '2024-10-21 14:53:59', 'closed', '2024-10-31 08:58:47'),
(16, 'Data Entry Specialist for One-Time Project', 'gig_admin', 9, 'weeks', 'Id dolor quia quod q', 'Minus est obcaecati', 'Ratione sint culpa m', 18.00, 'month', 'Remote', '', '2024-10-21 14:56:52', 'active', '2024-10-31 08:58:38'),
(17, 'Graphic Designer for Event Flyers', 'gig_admin', 86, 'weeks', 'Voluptas aut volupta', 'Nulla non praesentiu', 'Est in suscipit labo', 95.00, 'day', 'Onsite', 'Saepe facere nihil n', '2024-10-21 14:56:57', 'closed', '2024-10-31 08:58:30'),
(18, 'Social Media Manager for a Week', 'gig_admin', 83, 'days', 'Lorem do vitae in qu', 'A sit eligendi quo', 'Qui est iusto dolor', 71.00, 'week', 'Onsite', 'Molestiae animi est', '2024-10-21 14:57:09', 'active', '2024-10-31 08:58:20'),
(19, 'Onsite Photographer for Event', 'gig_admin', 42, 'months', 'Excepturi expedita q', 'Sed itaque dolores q', 'Dicta aliquam sit a', 57.00, 'month', 'Onsite', 'Quis eos assumenda', '2024-10-21 14:59:17', 'active', '2024-10-31 08:59:17'),
(20, 'Brand Ambassador for Weekend Event', 'gig_admin', 3, 'weeks', 'Aliquid maiores volu', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse hendrerit tincidunt lacus. Mauris et viverra nisl, at mattis diam. Quisque interdum fringilla ipsum eu tempor. Aliquam sit amet fringilla massa. Pellentesque a felis sit amet lectus fermentum pretium. Sed commodo odio in blandit maximus. Pellentesque at dapibus orci. Nullam ornare odio eu semper tempor.\r\n\r\nCras nulla diam, sodales nec risus sed, congue semper mauris. Aliquam eu tempus nisl. Proin posuere dignissim eros. Sed interdum ultricies magna, eu ultricies sem facilisis vel. Morbi congue magna ac justo venenatis, eget aliquam enim vulputate. Maecenas sodales est et mi tincidunt auctor. Proin eleifend sodales lectus a convallis.\r\n\r\nSed molestie sit amet purus quis pellentesque. Aenean scelerisque, eros in vulputate pretium, velit tellus faucibus purus, id pellentesque magna nunc id nulla. Nullam fermentum massa leo, in porta nibh ultricies iaculis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Suspendisse nec magna nec elit scelerisque lobortis. Nunc eleifend at nisi quis rutrum. Praesent id dolor aliquam, malesuada augue eget, iaculis est. Fusce quis ligula risus. Etiam vitae ornare sapien, nec venenatis nisl.', 'Eaque et aut incidun', 48.00, 'hour', 'Onsite', 'Voluptates mollit ul', '2024-10-21 14:59:33', 'active', '2024-11-01 18:56:19'),
(21, 'Video Editor for a Project', 'gig_admin', 86, 'weeks', 'Suscipit neque suscipit fames eros vitae massa. Pretium phasellus tempus risus nibh volutpat. Torquent convallis lacus integer scelerisque mi vestibulum euismod neque. Litora sit integer iaculis lacus dolor auctor morbi iaculis. Commodo maximus congue montes litora lobortis dapibus rutrum hac. Faucibus sed blandit nascetur elementum purus ultricies vitae fermentum. Pretium nascetur neque vestibulum porta nunc. Lectus vehicula per odio pellentesque metus nec mus dis. Quisque porta fusce et nullam convallis venenatis ex.\r\n\r\nNunc platea pretium, sociosqu accumsan volutpat quisque. Inceptos fringilla ante vitae neque ex orci malesuada varius? Habitant dui volutpat habitant, potenti elit dis morbi inceptos. Cursus maximus metus cubilia mus lobortis; magnis magna. Nunc dictum curae potenti accumsan sollicitudin hac. Vestibulum morbi duis orci donec condimentum ultrices ac. Mauris pharetra proin ac condimentum parturient laoreet parturient taciti.', 'Curabitur non feugiat arcu. Etiam non magna quis risus viverra fermentum. Duis pellentesque convallis mauris, quis dignissim purus hendrerit a. Suspendisse nec elementum dolor, a dictum quam. Morbi nisi erat, lobortis in accumsan vitae, lobortis at odio. Curabitur porttitor ex ut ipsum porttitor, et bibendum enim aliquam. Duis a lorem elementum, tempus urna eu, consectetur nibh. Ut volutpat porttitor nibh non ultrices.', 'Luctus efficitur curabitur sit ad posuere sodales primis augue eget. Neque sollicitudin libero ac aliquet inceptos nunc potenti? Cursus ultrices aenean venenatis ante neque inceptos cras. Vitae nisl ante;', 88.00, 'hour', 'Hybrid', 'Ex qui tempore quis', '2024-10-21 23:37:03', 'active', '2024-10-31 21:11:34'),
(22, 'Voluptate ut non ape', 'gig_admin', 62, 'days', 'Non est ut vero sunt', 'Mollitia officia quo', 'Sint eos perferendi', 22.00, 'day', 'Onsite', 'Qui tempora fugit i', '2024-10-25 05:36:17', 'closed', '2024-11-03 23:36:17'),
(23, 'Illum perspiciatis', 'gig_admin', 40, 'months', 'Dolorum officia exer', 'Nobis minima nobis s', 'Porro voluptas rerum', 84.00, 'day', 'Remote', '', '2024-10-25 05:37:45', 'closed', '2024-11-03 23:37:45'),
(24, 'Alias molestias porr', 'gig_admin', 13, 'weeks', 'Enim tempora minim e', 'Voluptas nihil volup', 'Id ullam voluptatem', 33.00, 'week', 'Remote', '', '2024-10-25 05:38:48', 'closed', '2024-11-03 23:38:48'),
(25, 'Molestias sed aut to', 'gig_admin', 49, 'weeks', 'Impedit totam dolor', 'Enim aliquip aperiam', 'Pariatur Consequatu', 58.00, 'submission', 'Remote', '', '2024-10-25 05:40:55', 'closed', '2024-11-03 23:40:55'),
(26, 'Web Developer for Custom Websites and Apps', 'gig_admin', 15, 'months', 'Necessitatibus quia', 'Deserunt vitae sint', 'Dolore illo excepteu', 23.00, 'month', 'Onsite', 'Necessitatibus elige', '2024-10-25 07:07:39', 'active', '2024-11-04 01:08:22'),
(27, 'Maxime autem dolorem', 'gig_admin', 99, 'months', 'Dolores mollitia non', 'Elit adipisicing ar', 'Ipsum ut est distin', 91.00, 'hour', 'Hybrid', 'Ea perferendis nulla', '2024-10-25 08:01:31', 'active', '2024-10-25 02:03:31'),
(28, 'Consectetur et nihil', 'gig_admin', 88, 'weeks', 'Ullam amet id tempo', 'Amet ad ex ut aperi', 'Suscipit officiis oc', 87.00, 'day', 'Hybrid', 'Laborum in iure aut', '2024-10-25 09:40:55', 'active', '2024-10-25 03:42:55'),
(29, 'Cillum ab incidunt', 'gig_admin', 81, 'months', 'Esse aut totam volu', 'Ullamco irure veniam', 'Asperiores nobis sim', 39.00, 'day', 'Remote', '', '2024-10-25 13:21:28', 'closed', '2024-11-04 07:21:28'),
(30, 'Quo voluptatem nisi', 'gig_admin', 8, 'weeks', 'Dolor eu explicabo', 'Ducimus nostrum ut', 'Vero ipsam exercitat', 6.00, 'submission', 'Remote', '', '2024-10-25 13:22:50', 'closed', '2024-11-04 07:22:50'),
(31, 'Id deserunt cumque n', 'gig_admin', 93, 'months', 'Soluta deserunt dolo', 'Consectetur et quo a', 'Culpa veritatis ut n', 19.00, 'submission', 'Onsite', 'Sed tempor ipsa tot', '2024-10-25 13:24:37', 'closed', '2024-11-04 07:24:37'),
(32, 'Et quibusdam debitis', 'gig_admin', 18, 'days', 'Quisquam incidunt n', 'Elit harum tempore', 'Pariatur Officiis a', 56.00, 'day', 'Remote', '', '2024-10-25 13:26:08', 'closed', '2024-11-04 07:26:08'),
(33, 'Photographer for School Play', 'gig_admin', 2, 'weeks', 'Molestias error quia', 'Rerum in veniam Nam', 'Cupiditate et natus', 27.00, 'month', 'Hybrid', 'Vero fugiat est temp', '2024-10-25 13:26:17', 'active', '2024-11-05 05:43:25'),
(34, 'Startup Founder Needed', 'gig_admin', 15, 'days', 'Sed officiis qui ab', 'Non eius nihil anim', 'Ea enim ullam dolore', 75.00, 'week', 'Hybrid', 'Inventore sunt esse', '2024-10-25 13:26:32', 'active', '2024-11-05 02:16:22'),
(35, 'Recusandae Ipsam qu', 'gig_admin', 94, 'months', 'Est laboris non eum', 'Asperiores tempore', 'Cupidatat optio Nam', 18.00, 'hour', 'Remote', '', '2024-10-25 13:26:58', 'closed', '2024-11-04 07:26:58'),
(36, 'Corporate Assurance Consultant', 'gig_admin', 618, 'weeks', 'Sint cum dignissimos veritatis ad iusto odio nam quidem unde.', 'Vero similique ea veritatis corporis incidunt.', 'Libero enim explicabo magni repellat dolore eos vero error saepe.', 411.00, 'submission', 'Hybrid', '594 Marquis Branch', '2024-10-26 13:44:43', 'active', '2024-11-05 07:44:43'),
(37, 'Human Solutions Specialist', 'gig_admin', 447, 'weeks', 'Rerum soluta nulla voluptatum.', 'Consequatur ex consequatur odit.', 'Harum illo iure repellendus nisi voluptatum.', 201.00, 'day', 'Remote', '2605 Dayana Motorway', '2024-10-26 13:45:01', 'active', '2024-11-05 07:45:01');

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
('aa0d4553-9329-417b-80c6-e7f21b601a17', 'gig_admin', 'ranevoxaqu@mailinator.com', 'Yoshi', 'Holder', 'Sharpe Osborne LLC', 2, '../uploads/gig-creators/profile-images/aa0d4553-9329-417b-80c6-e7f21b601a17/file_6719037ac60dc9.92719821.png', '../uploads/gig-creators/valid-ids/aa0d4553-9329-417b-80c6-e7f21b601a17/file_6713d0e4b37952.31005043.png', '1999-07-14', '2024-10-19 15:32:03', 'agree', '$2y$10$MVTYotGhQSvrbagdE8tlY.CjfrpAse/.0k2g6pcpkoh4Burv2spNy');

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
(1, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'how are you today?', '2024-10-24 07:07:04'),
(2, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2024-10-24 07:07:39'),
(3, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'hello, are yo there?', '2024-10-24 07:08:03'),
(4, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'good afternoon, even though there&#039;s a typhoon :(((', '2024-10-24 07:08:17'),
(5, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'your skills are interesting :)', '2024-10-24 07:08:20'),
(6, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'hello', '2024-10-24 07:08:27'),
(7, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'hi', '2024-10-24 07:08:30'),
(8, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'your skills are interesting :)', '2024-10-24 07:08:59'),
(9, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'how are you today?', '2024-10-24 07:09:45'),
(10, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'how are you today?', '2024-10-24 07:10:45'),
(11, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'you&#039;re always amazing !', '2024-10-24 07:10:57'),
(12, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', '#spreadLove', '2024-10-24 07:11:07'),
(13, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'Hello, thank you for messaging me :)', '2024-10-24 08:10:03'),
(14, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'I&#039;d like to apply for your gig &lt;3', '2024-10-24 08:15:31'),
(15, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'Suree that&#039;s fine', '2024-10-24 08:17:10'),
(16, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'Suree that&#039;s fine', '2024-10-24 08:17:11'),
(17, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'Suree that&#039;s fine', '2024-10-24 08:17:14'),
(18, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'thank you', '2024-10-24 08:17:30'),
(19, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'You&#039;re very much welcome', '2024-10-24 08:17:44'),
(20, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'you are very nice', '2024-10-24 08:18:01'),
(21, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'no you&#039;re nicer haha', '2024-10-24 08:18:09'),
(22, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'That&#039;s funny😆', '2024-10-24 08:18:27'),
(23, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'how are you today?', '2024-10-24 08:18:33'),
(24, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'I&#039;m so kilig💗', '2024-10-24 08:18:47'),
(25, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'Thank you for checking up on me😍😍🫶🫶', '2024-10-24 08:19:04'),
(26, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'of course, you will always be my baby &lt;#', '2024-10-24 08:19:18'),
(27, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'Aww thanks babe', '2024-10-24 08:19:37'),
(28, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'you&#039;re welcome my baby :)))', '2024-10-24 08:20:15'),
(29, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'Bye i&#039;ll eat na', '2024-10-24 08:20:49'),
(30, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'suree, eat well haa', '2024-10-24 08:20:57'),
(31, '34d8f036-caf0-40bf-ba4b-15385464634e', 'jason_admin', 'hi! thank you so much for reaching out to me :))', '2024-10-24 08:26:09'),
(32, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'I saw your skills, you are quite amazing🙌🙌', '2024-10-24 08:26:29'),
(33, '34d8f036-caf0-40bf-ba4b-15385464634e', 'jason_admin', 'ohh wow, thanks so much fr fr', '2024-10-24 08:26:40'),
(34, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'No cap', '2024-10-24 08:26:51'),
(35, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'Can i get your socials uwu', '2024-10-24 08:27:25'),
(36, '34d8f036-caf0-40bf-ba4b-15385464634e', 'jason_admin', 'of course, anything for you babe', '2024-10-24 08:27:37'),
(37, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'Okk love🫶', '2024-10-24 08:29:03'),
(38, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'will chat you later baby &lt;333', '2024-10-24 08:29:31'),
(39, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'aww you&#039;re so dreamy', '2024-10-24 08:31:52'),
(40, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'have you eaten yet?', '2024-10-24 08:56:19'),
(41, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'do you wanna date me uwu', '2024-10-24 08:59:29'),
(42, '34d8f036-caf0-40bf-ba4b-15385464634e', 'gig_admin', 'shy girl :D', '2024-10-24 11:02:55'),
(44, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'do you want me to cook for you babe &lt;3', '2024-10-24 11:39:05'),
(45, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'I&#039;m one call away baby :)))', '2024-10-24 11:46:01'),
(46, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', 'thank you as always', '2024-10-24 11:58:11'),
(47, 'f773f04c-0651-4303-be60-333e267fd86e', 'student_admin', '&lt;3', '2024-10-24 12:05:11'),
(48, 'e61e39a4-772e-4c45-a22f-3808ba5c44c6', 'gig_admin', 'hello, this is our first chat!', '2024-10-24 12:31:44'),
(49, 'e61e39a4-772e-4c45-a22f-3808ba5c44c6', 'student_admin', 'ohh thanks for noticing my application :))', '2024-10-24 12:32:27'),
(50, 'e61e39a4-772e-4c45-a22f-3808ba5c44c6', 'student_admin', 'it&#039;s an honor to work on this gig, this would surely enhance my skills &amp; experience', '2024-10-24 12:32:44'),
(51, 'e61e39a4-772e-4c45-a22f-3808ba5c44c6', 'gig_admin', 'I appreciate this statement of yours :D', '2024-10-24 12:33:27'),
(52, '99aecac5-55ad-4e0b-ab77-3e6e8d1ed758', 'gig_admin', 'hi jason gainz :)', '2024-10-24 12:40:10'),
(53, '48ef379f-52a4-4945-9945-a278698a1afc', 'gig_admin', 'hi again otto!', '2024-10-24 12:41:05'),
(54, '48ef379f-52a4-4945-9945-a278698a1afc', 'student_admin', 'hello there, if it isn&#039;t the great Mr. Yoshi :))', '2024-10-24 12:42:29'),
(55, '48ef379f-52a4-4945-9945-a278698a1afc', 'gig_admin', 'good evening', '2024-10-24 14:06:18'),
(56, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'you&#039;re welcome babe...', '2024-10-24 16:26:10'),
(57, '99aecac5-55ad-4e0b-ab77-3e6e8d1ed758', 'jason_admin', 'good morning mr. yoshi', '2024-10-24 16:26:44'),
(58, '34d8f036-caf0-40bf-ba4b-15385464634e', 'jason_admin', 'uwu', '2024-10-24 16:26:52'),
(59, 'df47ab7f-8cb8-4fa6-a084-be7f6fb3d452', 'gig_admin', 'Hi Otto! your profile looks amazing! When are you free for a short video call to discuss the gig?', '2024-10-25 07:10:12'),
(60, 'df47ab7f-8cb8-4fa6-a084-be7f6fb3d452', 'student_admin', 'Hi, thank you for selecting me, I am free anytime anywhere :))', '2024-10-25 07:11:38'),
(61, 'df47ab7f-8cb8-4fa6-a084-be7f6fb3d452', 'gig_admin', 'hi babe, how are you??', '2024-10-25 13:59:36'),
(62, 'df47ab7f-8cb8-4fa6-a084-be7f6fb3d452', 'student_admin', 'Hi, I&#039;m fine my baby &lt;333', '2024-10-25 13:59:56'),
(63, 'df47ab7f-8cb8-4fa6-a084-be7f6fb3d452', 'gig_admin', 'ok, that&#039;s fantastic!!', '2024-10-25 14:00:29'),
(64, 'f773f04c-0651-4303-be60-333e267fd86e', 'gig_admin', 'how are you tonight babe ?', '2024-10-26 12:46:32'),
(65, 'e61e39a4-772e-4c45-a22f-3808ba5c44c6', 'student_admin', 'you&#039;re welcome mr. yoshi, btw, I am free for a quick interview to learn more about the process of your gig', '2024-10-26 13:04:01'),
(66, 'e61e39a4-772e-4c45-a22f-3808ba5c44c6', 'student_admin', 'you&#039;re welcome mr. yoshi, btw, I am free for a quick interview to learn more about the process of your gig', '2024-10-26 13:07:43'),
(67, 'e61e39a4-772e-4c45-a22f-3808ba5c44c6', 'student_admin', 'when are you free for it?', '2024-10-26 13:07:52'),
(68, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'gig_admin', 'Interdum et malesuada fames ac ante ipsum primis in faucibus. Suspendisse hendrerit sapien nisl, ut elementum elit semper fringilla. Pellentesque diam ante, placerat at felis ut, ornare sollicitudin urna. Praesent ac vulputate dolor. Aliquam ac nisi vel ipsum lacinia finibus.', '2024-10-26 13:14:37'),
(69, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'gig_admin', 'Sed venenatis et enim eget lobortis. Nulla facilisi. Fusce in ante sed eros luctus accumsan. Fusce ut eros mauris. Vivamus ac purus diam. Nam odio dui, semper non nisl at, venenatis scelerisque turpis', '2024-10-26 13:15:45'),
(70, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'student_admin', 'Thank you for the invite!', '2024-10-26 13:16:21'),
(71, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'gig_admin', 'You&#039;re very welcome', '2024-10-26 13:22:48'),
(72, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'student_admin', 'When are you free for a quick rundown of the gig?', '2024-10-26 13:25:43'),
(73, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'student_admin', 'I just need to discuss some important elements of this short job', '2024-10-26 13:26:08'),
(74, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'gig_admin', 'I&#039;m free tomorrow anytime / anywhere 😎', '2024-10-26 13:26:29'),
(75, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'student_admin', 'that&#039;s great to hear!', '2024-10-26 13:26:45'),
(76, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'student_admin', 'looking forward to our discussion :)))', '2024-10-26 13:27:03'),
(77, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'gig_admin', 'Me too!', '2024-10-26 13:27:10'),
(78, '9dc33d72-4f97-4d08-82f8-a1c2ff4b0087', 'student_admin', 'see you &lt;3', '2024-10-26 13:28:44');

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
('02c8018f-ee82-49ae-a206-61', 'student_admin', 'kipog@mailinator.com', 'Otto', 'Coleman', 'FEU Institute of Technology', '4th Year', 'Ut dolor adipisci do', '../uploads/students/profile-images/02c8018f-ee82-49ae-a206-61/file_6719035d723069.91564429.png', '../uploads/students/student-ids/02c8018f-ee82-49ae-a206-61b04c2036b3/file_6713d1c3ccaea4.22700188.png', '1983-02-12', '2024-10-19 15:35:44', 'agree', '$2y$10$2DL6VfobwGcMXkVCFiByDeOeKgwAj7kz4lVjpmZCRHnis3azQ4YG2'),
('6ce48ce1-8027-4aad-9dbc-e9', 'jason_admin', 'markjasongalang.work@gmail.com', 'Jason', 'Gainz', 'UP Diliman', '3rd Year', 'Information Technology', NULL, '../uploads/students/student-ids/6ce48ce1-8027-4aad-9dbc-e9174d871482/file_671873efdc6ea5.29145539.png', '3123-03-31', '2024-10-23 03:56:46', 'agree', '$2y$10$VCEiDW3XkiIs99kjleQd1.Z2uP1PqSgUjTlHwD6GpyyJRQRGJG.E.');

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
(3, 'student_admin', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi eu accumsan nunc. Duis ac sapien vel orci congue mattis. Nullam mollis metus ac magna vehicula, quis consectetur urna vehicula. Nullam tempus arcu ante, sed commodo augue sollicitudin at. Etiam dictum nisl vel velit sodales, sit amet hendrerit nisi blandit. Mauris eget faucibus magna. \r\n\r\nProin nec hendrerit magna, in tempus massa. Donec placerat dapibus nisl ut vulputate. Nullam feugiat sed eros et tincidunt. Aenean mollis tellus arcu, at euismod nisl semper vel. Pellentesque nec dignissim massa. Nunc gravida vulputate urna, feugiat vulputate lorem vestibulum id. \r\n\r\nPhasellus a nisi vehicula, aliquet nisi sit amet, facilisis odio. Cras elementum faucibus lacus, a luctus risus cursus sit amet.', '', 'Suspendisse eget urna massa. Nunc eu elit lorem. Duis in turpis leo. Nulla et feugiat dolor. Donec malesuada dolor mauris, vitae dapibus sem sodales porta. \r\n\r\nMauris lacinia felis et ante faucibus, et imperdiet quam suscipit. Aliquam ornare pulvinar dui, in sollicitudin eros commodo a. Vestibulum facilisis consequat luctus. Ut eget scelerisque nunc. \r\n\r\nAliquam arcu lectus, varius ac velit eu, ornare lacinia mauris.'),
(5, 'jason_admin', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan interdum rutrum. Aliquam ut luctus nunc. Curabitur tempor erat lectus, in convallis lorem sollicitudin vel. Quisque aliquam enim et magna tincidunt, id dictum libero ultricies. Pellentesque tristique blandit libero. Donec laoreet ex tortor, nec egestas velit condimentum in. Duis condimentum, tellus sit amet bibendum imperdiet, neque velit facilisis elit, non laoreet tellus tellus viverra ligula.\r\n\r\nDonec nec accumsan risus. Aenean sed nisi at orci feugiat facilisis. In consectetur ultrices elit. Nulla laoreet felis non est mollis, nec mollis sem viverra. Quisque maximus a tortor nec suscipit. Integer molestie vel leo sit amet blandit. Maecenas in velit ac nulla varius porta maximus id elit. Donec mattis pharetra suscipit. Morbi eleifend aliquam odio, vel gravida magna malesuada a. Proin vitae justo tortor. Donec at odio et quam luctus condimentum a et quam. Phasellus a lorem non nunc aliquam facilisis. Aliquam nisi ante, imperdiet quis nibh non, varius finibus arcu.', '', 'Nam nec nulla mi. Proin blandit nisi maximus, tincidunt arcu pharetra, vestibulum orci. Nunc finibus libero eros, vel eleifend eros faucibus non.');

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
(1, 'markjasongalang.work@gmail.com', '767445', 1, '2024-10-22 22:03:51'),
(2, 'markjasongalang.work@gmail.com', '405244', 1, '2024-10-22 22:06:34'),
(3, 'rory@mailinator.com', '331802', 0, '2024-10-26 01:40:20');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `gigs`
--
ALTER TABLE `gigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `students_about_me`
--
ALTER TABLE `students_about_me`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
