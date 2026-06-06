-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2026 at 12:45 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sabrisae_equarter2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$REtk0gI9PR0U1Gyjxv.mbuD6A/GGzrGWGm82EgUiudd8EoknDT9s6', 'equarter@ruangprojek.com', '2026-06-06 14:09:14', '2026-06-06 14:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-05-26-042722', 'App\\Database\\Migrations\\CreateAdminTable', 'default', 'App', 1780726153, 1),
(2, '2026-06-06-000234', 'App\\Database\\Migrations\\CreatePenggunaTable', 'default', 'App', 1780726153, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int UNSIGNED NOT NULL,
  `nama_penuh` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `no_kp` varchar(12) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('kerani','ketua','pengurusan') COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('aktif','sekat') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama_penuh`, `email`, `no_kp`, `password`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(2, 'Siti Binti Abu', 'ketua@e-quarter.com', '850202145552', '$2y$10$QXV/GBoaFHvSwtNqrGrHc.N1q9pIMvrKhUjMQMfIsuIrCmd8xKgJe', 'ketua', 'aktif', NULL, '2026-06-06 14:09:14', '2026-06-06 14:09:14'),
(3, 'Dato Johan Bin Harun', 'pengurusan@e-quarter.com', '750303145553', '$2y$10$UBxy7CSAy9sbM/.KjFA9WeT/8Ot6iOXku/yN7zQnA0u/ujCuIJx/q', 'pengurusan', 'aktif', NULL, '2026-06-06 14:09:14', '2026-06-06 14:09:14'),
(4, 'Ahmad bin Sulaiman', 'ahmad@e-quarter.com', '123456123456', '$2y$10$GRNOV7eyE3pt8V83nyswUeMrEHNHYsDZR9QeFdn0bnQtmNj9RNlmq', 'kerani', 'aktif', NULL, '2026-06-06 18:44:59', '2026-06-06 20:09:38'),
(5, 'Syed Ali Bin Ahmad Abdullah', 'alicechen@gmail.com', '601205285050', '$2y$10$feNIo97uGVeLMdc5VOqINuGX0EaZcsJdfazec/WjIzwIEQVvU2uP2', 'kerani', 'aktif', NULL, '2026-06-06 20:40:53', '2026-06-06 20:40:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `no_kp` (`no_kp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
