-- phpMyAdmin SQL Dump
-- version 5.2.3deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 23, 2026 at 01:29 PM
-- Server version: 8.4.11-0ubuntu0.26.04.1
-- PHP Version: 8.5.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BookOfWhos`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `pid` int NOT NULL,
  `uid` int NOT NULL,
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reactions` json NOT NULL,
  `networkid` varchar(255) NOT NULL,
  `reply` json NOT NULL,
  `galleryimage` int NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Gallery`
--

CREATE TABLE `Gallery` (
  `pid` int NOT NULL,
  `uid` int NOT NULL,
  `file` int NOT NULL,
  `related` json NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `upvoters` json NOT NULL,
  `downvoters` json NOT NULL,
  `reactions` json NOT NULL,
  `tags` json NOT NULL,
  `op` varchar(255) NOT NULL DEFAULT 'Uploaded with Gallery.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Imageboard`
--

CREATE TABLE `Imageboard` (
  `postid` int NOT NULL,
  `isreply` tinyint(1) NOT NULL,
  `replys` json NOT NULL,
  `uid` int NOT NULL,
  `networkid` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` varchar(8000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `media` json NOT NULL,
  `thread` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `uid` int NOT NULL,
  `username` varchar(45) NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` varchar(2047) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'No Notes',
  `permission` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `pfp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'nopfp.png',
  `savedposts` json DEFAULT NULL,
  `savedimages` json DEFAULT NULL,
  `banneduntil` datetime DEFAULT NULL,
  `banreason` varchar(2047) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Not Banned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`uid`, `username`, `password_hash`, `ip`, `created_at`, `notes`, `permission`, `pfp`, `savedposts`, `savedimages`, `banneduntil`, `banreason`) VALUES
(1, '1234', '$2y$12$v7yvss3U3MiLQ/Bf7gibgenpuIpjn19t9Tqzkb3ORh0Ssw3jb0nw.', '192.168.49.187', '2026-10-05 11:47:11', 'No Notes', 0, 'nopfp.png', NULL, NULL, '2026-10-22 00:00:00', 'Stupid mango plus leo diff.'),
(2, 'chud', '$2y$12$5Y2qTi3KpRJilw7FGQhJgOkLlkZ0NG9rP9JXXKDsFXu1BVGm6NtzK', '192.168.49.187', '2026-10-05 11:47:20', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(3, 'sex', '$2y$12$qidQ.dD1VvyeqQ.iyW.ITuhKvMT6rGc7Vf3uS7QqzdS.GuPErcwhC', '192.168.49.103', '2026-10-06 10:57:46', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(4, '67', '$2y$12$YrSspSrpS8mHKa7AFo4NF.GHWhCOkyPvlPLxe91tcys52XnzV9b6q', '192.168.49.110', '2026-10-07 08:30:32', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(7, 'leoleoarp&aring;sig', '$2y$12$tmmQtL9vkvi7yl.8spDkSO/vpi01JFfpnUB4ouP05tKWTEB4v4LhK', '192.168.49.187', '2026-10-20 12:55:18', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(8, 'leoleoarpasig', '$2y$12$sl00.zrxwsF/rJtnKIzcm.O8J64oGV.A7of0JWoVZ6J5H1NHTn6Xm', '192.168.49.187', '2026-10-20 12:55:56', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(9, 'iiiuuu', '$2y$12$JVLuImF.9U4l1KUBo6YTEuthQ6FlKN2lqG5fYzkbw1DuI5lPmLc7O', '192.168.49.187', '2026-10-20 12:56:03', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(10, 'fffddd', '$2y$12$zdgDGx7cAFp0cv2hCmAJl.r0gSqJTFNa9.8WEwAwmxV.E00tr1XL.', '192.168.49.187', '2026-10-20 12:56:52', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(11, 'test', '$2y$12$5iD7uJrmpypKvwvuA6BPyegQ7l./P1zPwc78FCLSRu9K/8yMSTD.a', '192.168.49.187', '2026-10-20 12:59:42', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(13, 'ddssdd', '$2y$12$cPwDxliyk0d4lIvsiHA1Ze2nN5y96RVtYZtxr5eyJhTvFhhzm.HNK', '192.168.49.187', '2026-10-20 13:02:10', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(14, 'lklk', '$2y$12$7I9iwqA1sRY/wnrTpRHzF.cJzSBksFCLK/oLVVr6TNaiaJ4duOqPO', '192.168.49.187', '2026-10-20 13:04:49', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(15, 'asdasdsadasdsad', '$2y$12$AOy6/P1ej/z5RQuJt8YiUuFYR3269nPLYxtokS1v9qCZo1dk5tDkm', '192.168.49.187', '2026-10-20 13:07:54', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(16, 'durpeelingo', '$2y$12$J4fGvC3SwJtgHmSMKg7ZLOgn86PMiE8e1wH4Y/8YyQpek/4OY56Jm', '192.168.49.187', '2026-10-20 13:16:19', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(17, 'tuffington', '$2y$12$M3DywMN7gn6uCn/4WkKrOuimUfmp6llgFwypi1AVmM1zAfOqIZcNW', '192.168.49.187', '2026-10-21 08:06:09', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(18, 'man go', '$2y$12$EAV/Wp9d7cQK2nmMXD2fLeKQjqxcaty4KYXjJCcNXnK57bHCuCr8W', '192.168.49.187', '2026-10-23 12:43:16', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(19, '12345678901234567890', '$2y$12$NSE/4vjHcLHvzmRjbGOif.6QdCCvj6TPyELOYifwuOE5IcVk2DIta', '192.168.49.187', '2026-10-23 13:15:32', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned'),
(20, '123456789012345678901234', '$2y$12$j5XmMV9nzJ2VsoEBb/d6FOupRDNujOiMiHwDnN4WAuCRhLeQViP/y', '192.168.49.187', '2026-10-23 13:21:29', 'No Notes', 0, 'nopfp.png', NULL, NULL, NULL, 'Not Banned');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `Gallery`
--
ALTER TABLE `Gallery`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `file` (`file`);

--
-- Indexes for table `Imageboard`
--
ALTER TABLE `Imageboard`
  ADD PRIMARY KEY (`postid`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `Unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `pid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Gallery`
--
ALTER TABLE `Gallery`
  MODIFY `pid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Imageboard`
--
ALTER TABLE `Imageboard`
  MODIFY `postid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `uid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
