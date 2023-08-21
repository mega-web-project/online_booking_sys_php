-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2023 at 01:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `status`) VALUES
(63, 'clinic', 1),
(64, 'Commercial', 1),
(67, 'Technical', 1),
(68, 'Mentainance', 1),
(69, 'RSPO', 1),
(70, 'Small Holder', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `emp_code` varchar(50) DEFAULT NULL,
  `emp_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `emp_code`, `emp_name`) VALUES
(234, '45590', 'John Ayeh'),
(235, '23822', 'Peter Asiedu'),
(236, '48224', 'Bright Mensah'),
(237, '26534', 'Jude Arhin'),
(238, '67884', 'Peter and Paul');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `price`, `category_id`, `image`) VALUES
(21, 'fufu with light soup', 'The soup is made from a palm cream or palm nut base. The palm cream is combined with flavorful marinated meats, smoked dried fish.', 67.00, 3, 'menuImage/fufu.jpg'),
(22, 'Rice With Tomatoe stew', 'As a diuretic, rice husk can help to lose excess water weight, eliminate toxins from the body like uric acid, and even lose weight,', 30.00, 2, 'menuImage/plain rice.jpg'),
(24, 'Coffee Tea', 'Find yourself with healthy coffee tea', 12.00, 1, 'menuImage/breakfast.jpg'),
(25, 'Sandwich', ' An open face sandwich fulfills the second definition of the word “sandwich” which is one slice of bread covered in food. ', 12.00, 1, 'menuImage/sand.jpg'),
(26, 'Fried Rice', 'Get delicios fried rice and chicken', 15.00, 2, 'menuImage/fried.jpg'),
(27, 'Boild Yarm with palava sauce', 'Boild yarm with sweet palava sauce stew', 20.00, 3, 'menuImage/yarm.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `menu_category`
--

CREATE TABLE `menu_category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_category`
--

INSERT INTO `menu_category` (`id`, `name`) VALUES
(1, 'Break Fast'),
(2, 'Lunch'),
(3, 'Dinner');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `uniqid` varchar(255) NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_address` varchar(255) NOT NULL,
  `check_in_date` datetime NOT NULL,
  `check_out_date` datetime NOT NULL,
  `purpose_of_visit` varchar(255) NOT NULL,
  `breakfast` varchar(255) DEFAULT NULL,
  `dinner` varchar(255) DEFAULT NULL,
  `lunch` varchar(255) DEFAULT NULL,
  `num_of_people_for_menu` int(11) DEFAULT NULL,
  `num_of_people_for_acco` int(11) DEFAULT NULL,
  `employee_names` varchar(255) DEFAULT NULL,
  `visitors_names` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `rejection_message` varchar(255) DEFAULT NULL,
  `requester_id` int(11) NOT NULL,
  `approver1` int(11) DEFAULT NULL,
  `approver2` int(11) DEFAULT NULL,
  `approver3` int(11) DEFAULT NULL,
  `approver4` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approver1_status` enum('Approved','Rejected','Pending') DEFAULT 'Pending',
  `approver2_status` enum('Approved','Rejected','Pending') DEFAULT 'Pending',
  `approver3_status` enum('Approved','Rejected','Pending') DEFAULT 'Pending',
  `approver4_status` enum('Approved','Rejected','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `uniqid`, `guest_name`, `guest_address`, `check_in_date`, `check_out_date`, `purpose_of_visit`, `breakfast`, `dinner`, `lunch`, `num_of_people_for_menu`, `num_of_people_for_acco`, `employee_names`, `visitors_names`, `status`, `rejection_message`, `requester_id`, `approver1`, `approver2`, `approver3`, `approver4`, `created_at`, `approver1_status`, `approver2_status`, `approver3_status`, `approver4_status`) VALUES
(26, '64bcdae97cf44', 'Sohnet solution', 'GT/022- street 33', '2023-07-23 11:44:00', '2023-07-27 10:45:00', 'Installation of  LED light and cable management', 'Coffee Tea', 'Boild Yarm with palava sauce', 'Rice With Tomatoe stew', 4, 3, '', 'louis fobi, John mensah, Asare Bright', 'Approved', NULL, 70, 76, 71, 62, 61, '2023-07-23 09:46:49', 'Approved', 'Approved', 'Approved', 'Approved'),
(27, '64bd936a20886', 'louis', 'GT/022- street 33', '2023-07-23 20:53:00', '2023-07-24 20:53:00', 'htdrgh', '', '', '', 0, 0, '', '', 'Pending', NULL, 62, 71, 71, 61, 62, '2023-07-23 22:54:02', 'Pending', 'Pending', 'Pending', 'Pending'),
(29, '64bf9fdc9602f', 'Sohnet solution', 'GT/022- street 33', '2023-07-26 10:11:00', '2023-07-29 10:11:00', ' hb\\v,m.', '', '', '', 0, 0, '', '', 'Pending', NULL, 62, 76, 68, 62, 61, '2023-07-25 12:11:40', 'Pending', 'Pending', 'Pending', 'Pending'),
(30, '64bfa0be39dd4', 'louis', 'stret 116222', '2023-07-25 10:14:00', '2023-07-29 15:14:00', 'jhvjchnbc', 'Sandwich', 'fufu with light soup', 'Fried Rice', 9, 9, '', 'louis,john', 'Pending', NULL, 70, 71, 68, 62, 61, '2023-07-25 12:15:26', 'Pending', 'Pending', 'Pending', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `createddate` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(250) NOT NULL,
  `profile_image` varchar(250) NOT NULL,
  `user_type` enum('admin','user','approver') NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `tel` varchar(10) NOT NULL,
  `reset_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `createddate`, `name`, `profile_image`, `user_type`, `department_id`, `tel`, `reset_token`) VALUES
(61, 'test@gmail.com', '$2y$10$W6cJnEXgcF8.OU750n1C7uUb8PE5CWRdFbRcGE970EG81kLM93l0W', '2023-06-30 12:36:10', 'test2', 'profile_images/649fabafa86dc_20220305_141406.jpg', 'admin', 68, '0565434412', ''),
(62, 'admin@gmail.com', '$2y$10$GOs4/B7nYWe0lMvQun1AuuIa7MsEXaVwNdJEPAVF6pTXE7sH5Ej7.', '2023-06-30 12:54:08', 'admin', 'profile_images/649ed9ce5df08_WhatsApp Image 2023-06-30 at 1.33.37 PM.jpeg', 'admin', 70, '565434412', ''),
(68, 'agyarkohmichael19@gmail.com', '$2y$10$aTrjx9Wdk2la3tjFUb34hundUXlmev2nXUAWliEyDcPTh0BXvK.Iu', '2023-07-02 23:52:57', 'Michael Agyarkoh', 'assets/img/avatars.png', 'approver', 64, '0548523328', ''),
(70, 'fobilouisstone@gmail.com', '$2y$10$HJ8UaL8Eek8U5vYu3a3a/.BiUNV8jQPE5JngMK6.cFMeVwOspmC6m', '2023-07-03 20:55:15', 'Louis', 'assets/img/avatars.png', 'user', 68, '0554343923', '2f5d1e0e03a0b32e965c13451e32d9829707d0276f0d8ecbb43201101f53a30e'),
(71, 'Hope.Yevugah@unilever.com', '$2y$10$huT.aIOE0teauv3SSRy8EOpbRqtw6tMqCZ0m4wk9WEd6pgtXwIzC6', '2023-07-04 16:45:51', 'Hope.Yevugah', 'assets/img/avatars.png', 'approver', 69, '0565434412', ''),
(76, 'fobilouis17@gmail.com', '$2y$10$79rhDilU1lmC7aq56vlUA.Qt1J4MVbjc43CKHZ0Nu6zWFV9zRI8VK', '2023-07-14 07:17:16', 'Louis.Fobi', 'assets/img/avatars.png', 'approver', 68, '0244343635', '1066c0a526652b67906a8dcdfa52baae079a2f93e36c6c69d5664325eee51d82'),
(78, 'samuel.abb@gmail.com', '$2y$10$AB8QFkjcn6HTRm4y703KgeqqRr.NXbznUa2kYcYcmyX9JfZlpa3M6', '2023-07-24 15:09:17', 'Samuel Abbey', 'assets/img/avatars.png', 'approver', 64, '0244343635', ''),
(79, 'vincent.gye-kye-hooper@unilever.com', '$2y$10$uigsIWBLGufrqdEVaAntl.kvfZhObxkErZdDUd8gKP2QDcTI6lr7q', '2023-07-25 17:40:31', 'Vincent Gyekye-Hooper', 'assets/img/avatars.png', 'admin', 68, '0245987687', ''),
(80, 'vincent.gye-kye-hooper@unilever.com', '$2y$10$PZg8ZspQ5FwcO3HX2Z1pjOEHjqVaZhtiw5klwnYmHNy0ruQCahT0y', '2023-07-25 17:40:51', 'Vincent Gyekye-Hooper', 'assets/img/avatars.png', 'admin', 68, '0245987687', '');

-- --------------------------------------------------------

--
-- Table structure for table `whilelist_requests`
--

CREATE TABLE `whilelist_requests` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `whilelisted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `whilelist_requests`
--

INSERT INTO `whilelist_requests` (`id`, `request_id`, `user_id`, `whilelisted_at`) VALUES
(2, 29, 62, '2023-08-01 13:09:14'),
(3, 26, 62, '2023-08-01 13:17:49'),
(5, 27, 62, '2023-08-01 13:48:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_code` (`emp_code`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `menu_category`
--
ALTER TABLE `menu_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniqid` (`uniqid`),
  ADD KEY `requester_id` (`requester_id`),
  ADD KEY `approver1` (`approver1`),
  ADD KEY `approver2` (`approver2`),
  ADD KEY `approver3` (`approver3`),
  ADD KEY `approver4` (`approver4`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `whilelist_requests`
--
ALTER TABLE `whilelist_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `whilelist_requests_ibfk_1` (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `menu_category`
--
ALTER TABLE `menu_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `whilelist_requests`
--
ALTER TABLE `whilelist_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `menu_category` (`id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`approver1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_3` FOREIGN KEY (`approver2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_4` FOREIGN KEY (`approver3`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_5` FOREIGN KEY (`approver4`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `whilelist_requests`
--
ALTER TABLE `whilelist_requests`
  ADD CONSTRAINT `whilelist_requests_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `whilelist_requests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
