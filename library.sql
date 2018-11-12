-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2018 at 02:43 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(10) UNSIGNED NOT NULL,
  `fname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `fname`, `lname`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'David', 'Mendoza', '2018-09-19 09:00:52', '2018-09-19 09:00:00', '2018-09-19 09:00:00'),
(2, 'Mendoza', 'David', NULL, '2018-09-19 09:01:10', '2018-09-19 09:03:15'),
(3, 'David', 'Divad', NULL, '2018-09-19 09:03:04', '2018-09-19 09:03:04'),
(4, 'George', 'Lucas', NULL, '2018-09-21 00:56:00', '2018-09-21 00:56:00');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `publisher_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_published` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `edition` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `author_id`, `publisher_id`, `date_published`, `description`, `title`, `isbn`, `categories`, `edition`, `stock`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 2, '[\"1\",\"6\"]', '2007-07-21', 'Throughout the six previous novels in the series, the main character Harry Potter has struggled with the difficulties of adolescence along with being famous as the only wizard to survive the Killing Curse. The curse was cast by the evil Tom Riddle, better known as Lord Voldemort, a powerful evil wizard, who had murdered Harry\'s parents and attempted to kill Harry as a baby, in the belief this would frustrate a prophecy that Harry would become his equal. As an orphan, Harry was placed in the care of his Muggle (non-magical) relatives Petunia Dursley and Vernon Dursley.', 'Harry Potter and the Deathly Hallows', '0-545-01022-5', '[\"7\",\"6\"]', 'UK', 3, NULL, '2018-09-19 20:51:24', '2018-11-08 06:01:56'),
(4, 4, '[\"1\"]', '1994-10-01', 'The film was released in theaters on May 25, 1983, six years to the day after the release of the first film, receiving mostly positive reviews. The film grossed between $475 million[4][5] and $572 million worldwide.[6] Several home video and theatrical releases and revisions to the film followed over the next 20 years. 32 years after the film\'s original release, it was followed by a sequel trilogy, beginning in 2015 with The Force Awakens.', 'Return of the Jedi', '0-345-30767-4', '[\"6\",\"7\",\"5\"]', 'Original', 2, NULL, '2018-09-21 00:56:28', '2018-11-10 06:06:50'),
(5, 2, '[\"5\"]', '2018-09-23', 'Sometimes the only thing to fear…is yourself.', 'In a Dark, Dark Wood', '1501190474', '[\"2\",\"3\"]', 'reprint', 1, NULL, '2018-09-22 21:04:24', '2018-11-08 03:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `required_return_date` datetime NOT NULL,
  `fee` float(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `returned_on` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`id`, `user_id`, `book_id`, `required_return_date`, `fee`, `created_at`, `updated_at`, `returned_on`, `deleted_at`) VALUES
(1, 3, 4, '2018-11-09 14:06:48', 5.00, '2018-11-10 06:06:48', '2018-11-10 07:13:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Horror', '2018-09-19 04:45:55', '2018-09-19 04:45:47', '2018-09-19 04:45:47'),
(2, 'Suspense', NULL, '2018-09-19 04:46:02', '2018-09-19 04:47:06'),
(3, 'Horror', NULL, '2018-09-19 04:47:15', '2018-09-19 04:47:15'),
(4, 'Romance', NULL, '2018-09-19 04:47:22', '2018-09-19 04:47:22'),
(5, 'Sci-fi', NULL, '2018-09-19 04:47:28', '2018-09-19 04:47:28'),
(6, 'Adventure', NULL, '2018-09-21 00:53:52', '2018-09-21 00:53:52'),
(7, 'Fiction', NULL, '2018-09-21 00:54:06', '2018-09-21 00:54:06');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_09_15_042421_create_books_table', 1),
(4, '2018_09_15_043331_create_authors_table', 1),
(5, '2018_09_15_043422_create_publishers_table', 1),
(6, '2018_09_15_043451_create_categorys_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`id`, `name`, `location`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Rex Bookstore', 'Morayta HEHES', NULL, '2018-09-19 02:19:21', '2018-09-19 02:33:29'),
(2, 'Test', 'Test Location', '2018-09-19 03:36:28', NULL, NULL),
(3, 'asd', 'qwe', '2018-09-19 03:36:30', '2018-09-19 03:34:15', '2018-09-19 03:34:15'),
(4, 'rabbitry', 'HEHEHEHE', '2018-09-19 03:36:33', '2018-09-19 03:36:07', '2018-09-19 03:36:07'),
(5, 'Miriam', 'Morayta', NULL, '2018-09-19 03:37:13', '2018-09-19 03:40:01'),
(6, 'National', 'Moraytaaa', NULL, '2018-09-19 03:39:28', '2018-09-19 03:40:14');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `display` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `display`, `value`, `created_at`, `updated_at`) VALUES
(1, 'allowedDays', 'Allowed days', '4', '2018-11-10 05:47:33', '2018-11-10 05:47:33'),
(2, 'excessFee', 'Excess days fee', '5.0', '2018-11-10 05:47:33', '2018-11-10 05:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_id` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `account_id`, `type`, `fname`, `lname`, `gender`, `contact`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'Librarian', 'David', 'Mendoza', 'Male', '09154590172', 'librarian@librarian.com', '21232f297a57a5a743894a0e4a801fc3', NULL, '2018-09-19 01:27:36', '2018-09-21 11:48:52', NULL),
(3, '305414-001', 'Teacher', 'Juan', 'Dela Cruz', 'Male', '09123456789', 'teacher@teacher.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2018-09-22 17:07:54', '2018-09-22 17:07:54', NULL),
(4, '4', 'Staff', 'Lib', 'Rarian', 'Female', '09129876543', 'staff@staff.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2018-09-23 03:06:01', '2018-09-23 03:06:01', NULL),
(5, '305414-000001', 'Student', 'Maria', 'Clara', 'Female', '09123459876', 'student@student.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2018-09-23 13:12:03', '2018-09-23 13:12:03', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
