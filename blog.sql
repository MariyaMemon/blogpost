-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2024 at 09:14 PM
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
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogpost`
--

CREATE TABLE `blogpost` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(200) NOT NULL,
  `post_body` text NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogpost`
--

INSERT INTO `blogpost` (`post_id`, `post_title`, `post_body`, `post_date`, `user_id`, `picture`) VALUES
(1, 'My first blog post', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti aperiam provident libero quisquam velit. Libero illum blanditiis, rem minus expedita consequuntur iusto! Ex, earum magnam dignissimos alias expedita nostrum impedit asperiores corporis non eos! Ipsum, est consequatur? Deleniti rem culpa vitae nulla. Quaerat placeat necessitatibus dolore modi illo quae ab.', '2019-10-20 00:00:00', 2, NULL),
(2, 'This is my second blog post', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti aperiam provident libero quisquam velit. Libero illum blanditiis, rem minus expedita consequuntur iusto! Ex, earum magnam dignissimos alias expedita nostrum impedit asperiores corporis non eos! Ipsum, est consequatur? Deleniti rem culpa vitae nulla. Quaerat placeat necessitatibus dolore modi illo quae ab.', '2020-10-10 00:00:00', 3, NULL),
(3, 'My recent blog post, a bit longer', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti aperiam provident libero quisquam velit. Libero illum blanditiis, rem minus expedita consequuntur iusto! Ex, earum magnam dignissimos alias expedita nostrum impedit asperiores corporis non eos! Ipsum, est consequatur? Deleniti rem culpa vitae nulla. Quaerat placeat necessitatibus dolore modi illo quae ab. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate consectetur, laudantium aspernatur ducimus autem quisquam praesentium molestiae esse illo et eligendi, veniam deserunt saepe obcaecati ea! Nostrum rerum eum quaerat iure, debitis libero eos! Adipisci ad vel amet, dolores id, at animi, voluptas veritatis accusamus repellat perspiciatis fuga! Dolorem, numquam!', '2021-09-21 00:00:00', 0, NULL),
(4, 'Ganymede - The Largest Moon in the Solar System', 'Ganymede holds the prestigious title of being the largest moon not only around Jupiter but in our entire solar system. It even surpasses the planet Mercury in size. Ganymede\'s surface showcases a diverse geology, featuring both older, darker regions and relatively younger, lighter areas. Beneath its icy crust, Ganymede is believed to host a subsurface ocean, adding to the intrigue of this colossal moon.', '2024-01-20 20:13:57', 1, 'blogUpload/jupiter.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`user_id`, `post_id`) VALUES
(1, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `post_id`, `created_at`) VALUES
(1, 1, '2024-01-20 19:39:00'),
(3, 1, '2024-01-20 19:50:59'),
(3, 2, '2024-01-20 19:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE `shares` (
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shares`
--

INSERT INTO `shares` (`user_id`, `post_id`, `created_at`) VALUES
(1, 1, '2024-01-20 19:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`) VALUES
(1, 'mariya', '$2y$10$zv7TpUzEcOldFgg33.9imu19RAXKcTZ9vQiNoBFi9rB41UVnrSWy2', 'mariyamemon54@gmail.com'),
(2, 'camella', '$2y$10$e2NTgPJJdWn/cKue0P97R.DD3eFbfb6U9rWaioF0GAus63t0fXkQe', 'cam@gmail.com'),
(3, 'sunny', '$2y$10$EO/QlmcFg6dTjTwGL7GgoOU2WaafIkmBsozPnplkZm6vPiSi.VFXq', 'sunny@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogpost`
--
ALTER TABLE `blogpost`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `fk_blogposts_users` (`user_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `blog_id` (`post_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `shares`
--
ALTER TABLE `shares`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogpost`
--
ALTER TABLE `blogpost`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogpost`
--
ALTER TABLE `blogpost`
  ADD CONSTRAINT `fk_blogposts_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `blogpost` (`post_id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `blogpost` (`post_id`);

--
-- Constraints for table `shares`
--
ALTER TABLE `shares`
  ADD CONSTRAINT `shares_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `shares_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `blogpost` (`post_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
