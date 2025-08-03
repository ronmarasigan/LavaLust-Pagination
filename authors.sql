-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 03, 2025 at 04:27 AM
-- Server version: 11.8.2-MariaDB-1 from Debian
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lavalust`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `first_name`, `last_name`, `email`, `birthdate`, `added`) VALUES
(1, 'Nelson', 'Ullrich', 'candelario62@example.org', '2013-07-21', '2015-09-04 17:53:44'),
(2, 'Albina', 'Fahey', 'kschumm@example.net', '2013-03-10', '1993-12-01 11:41:14'),
(3, 'Carleton', 'Bechtelar', 'jarvis.walker@example.org', '1987-06-17', '1986-02-23 17:02:41'),
(4, 'Jamie', 'Marks', 'briana.kiehn@example.net', '1978-07-02', '1984-05-02 03:39:44'),
(5, 'Chaim', 'Deckow', 'ffisher@example.com', '2010-04-10', '1986-01-27 22:40:04'),
(6, 'Nicolette', 'Cruickshank', 'zella.streich@example.net', '1977-06-13', '1982-02-16 15:31:56'),
(7, 'Mikel', 'Cormier', 'hills.kiley@example.org', '1987-11-25', '1994-05-25 03:30:44'),
(8, 'Nora', 'O\'Hara', 'eblock@example.com', '1981-12-30', '2018-08-26 10:39:52'),
(9, 'Hyman', 'Crist', 'xmccullough@example.net', '2013-04-21', '2014-11-06 11:59:13'),
(10, 'Shaina', 'Romaguera', 'lavon.graham@example.com', '1976-12-21', '1972-11-11 23:24:03'),
(11, 'Peggie', 'Daniel', 'collier.dean@example.org', '1984-06-19', '2009-01-07 00:45:45'),
(12, 'Marty', 'Von', 'jaydon38@example.com', '1987-06-22', '1977-05-16 14:02:51'),
(13, 'Julia', 'Nolan', 'flossie30@example.net', '2008-10-17', '1988-09-10 18:16:50'),
(14, 'Anya', 'Gutkowski', 'miller.coralie@example.org', '2006-01-20', '1999-11-10 11:24:35'),
(15, 'Jaleel', 'Quigley', 'beer.easter@example.net', '2000-03-14', '1972-08-31 17:58:51'),
(16, 'Agustina', 'Little', 'jeanne73@example.net', '1989-05-11', '2017-06-01 18:24:43'),
(17, 'Ezra', 'Leuschke', 'francisco73@example.org', '1982-08-13', '1983-12-17 14:04:12'),
(18, 'Christina', 'Rodriguez', 'schneider.cristina@example.org', '1981-10-02', '2001-04-15 00:09:24'),
(19, 'Nils', 'Mayert', 'lonny41@example.org', '1989-01-13', '1991-09-24 12:25:47'),
(20, 'Tania', 'Considine', 'lola.windler@example.net', '1973-07-13', '1974-01-29 03:12:47'),
(21, 'Octavia', 'Ryan', 'rwilkinson@example.com', '1995-07-11', '1980-12-16 09:21:48'),
(22, 'Reid', 'Carroll', 'dalton.purdy@example.org', '2001-05-24', '1994-12-27 03:52:52'),
(23, 'Norval', 'Hayes', 'rupton@example.com', '1973-12-16', '2005-11-26 18:43:51'),
(24, 'Matilde', 'Botsford', 'bosco.enid@example.org', '1998-02-13', '1976-07-07 18:26:56'),
(25, 'Millie', 'Nitzsche', 'issac66@example.org', '1978-09-29', '1974-02-19 05:11:00'),
(26, 'Eloy', 'Blanda', 'milton81@example.com', '1994-06-11', '1999-09-17 10:23:50'),
(27, 'Pascale', 'Smith', 'keshawn99@example.com', '2014-08-13', '2020-10-10 10:37:32'),
(28, 'Bernadine', 'Mayer', 'alene72@example.org', '2004-07-31', '1981-03-29 20:49:46'),
(29, 'Burnice', 'Daniel', 'austin75@example.com', '1982-06-26', '2000-10-11 02:26:21'),
(30, 'Scot', 'Carroll', 'margarete.stehr@example.org', '1996-07-28', '1983-06-03 07:18:07'),
(31, 'Rubie', 'Watsica', 'becker.payton@example.com', '1970-04-02', '1988-12-05 08:58:02'),
(32, 'Mara', 'Orn', 'zlind@example.net', '1982-01-28', '2021-07-31 11:32:11'),
(33, 'Joe', 'Langosh', 'chelsie54@example.org', '1996-09-03', '2023-06-09 07:55:53'),
(34, 'Brock', 'Rowe', 'brekke.florencio@example.net', '1981-03-19', '2023-08-08 07:31:49'),
(35, 'Yesenia', 'Beer', 'janick.marks@example.net', '2014-11-01', '1977-04-09 11:44:36'),
(36, 'Jesse', 'Murray', 'anita84@example.org', '1977-09-13', '1998-05-13 00:14:45'),
(37, 'Bulah', 'Eichmann', 'destini.cummerata@example.net', '2023-10-10', '1994-09-10 04:10:27'),
(38, 'Maximillian', 'Howell', 'o\'hara.jarrod@example.com', '1974-11-17', '1987-08-30 06:59:46'),
(39, 'Horace', 'Shields', 'rudy.bogan@example.com', '2011-02-08', '1993-01-09 09:42:42'),
(40, 'Ike', 'Runolfsdottir', 'schaden.joelle@example.net', '2004-10-19', '1996-08-04 02:45:54'),
(41, 'Mariah', 'Kub', 'everette.murphy@example.net', '1975-06-29', '2007-02-07 08:02:54'),
(42, 'Magnus', 'O\'Keefe', 'katlynn.rosenbaum@example.net', '1974-11-20', '2007-10-03 08:15:57'),
(43, 'Juanita', 'Daugherty', 'nicholaus62@example.org', '1976-11-17', '2021-02-01 23:37:54'),
(44, 'Shaniya', 'Jacobson', 'adella23@example.net', '2024-06-15', '1972-07-31 18:05:16'),
(45, 'Rudolph', 'Block', 'pamela.spencer@example.net', '1998-02-19', '1995-10-11 23:57:58'),
(46, 'Susan', 'Rath', 'ydavis@example.net', '1990-11-16', '2003-06-19 21:58:29'),
(47, 'Gerardo', 'Muller', 'edmund.dooley@example.net', '1994-08-05', '1991-07-30 16:55:35'),
(48, 'Al', 'Stark', 'elta54@example.com', '1997-06-19', '2021-06-30 23:37:15'),
(49, 'Darwin', 'Bosco', 'dusty72@example.com', '1973-10-08', '1994-10-31 14:52:13'),
(50, 'Quincy', 'Feeney', 'alysson.predovic@example.net', '2007-01-14', '2024-01-25 04:44:11'),
(51, 'Kelly', 'Halvorson', 'tina.kessler@example.net', '2010-10-23', '1995-10-02 05:09:37'),
(52, 'Marjolaine', 'White', 'sallie.o\'keefe@example.org', '2015-05-21', '2015-07-03 20:34:04'),
(53, 'Janick', 'Runolfsdottir', 'kwyman@example.org', '1998-06-07', '1996-01-26 03:45:49'),
(54, 'Leanna', 'Lang', 'vmarvin@example.com', '1995-03-23', '2004-09-20 15:15:50'),
(55, 'Carter', 'Renner', 'gutkowski.willie@example.org', '2019-12-25', '1989-09-25 15:06:09'),
(56, 'Laverne', 'Ryan', 'frederick52@example.net', '1978-10-05', '2007-04-02 01:44:43'),
(57, 'Nikko', 'West', 'brandi.abshire@example.org', '2022-03-16', '2010-01-10 12:21:46'),
(58, 'Patricia', 'Marquardt', 'lkessler@example.org', '2012-07-16', '2022-02-04 15:07:07'),
(59, 'Boyd', 'Nitzsche', 'leland.braun@example.org', '2019-07-06', '2005-07-26 14:37:15'),
(60, 'Ariane', 'Hartmann', 'angela.terry@example.org', '2020-03-12', '2000-01-22 17:01:39'),
(61, 'Krystina', 'Smitham', 'dkrajcik@example.net', '1992-10-11', '2011-05-20 22:55:29'),
(62, 'Patsy', 'Howell', 'tommie43@example.net', '1970-07-10', '1976-12-16 19:21:14'),
(63, 'Catharine', 'Stracke', 'nschaefer@example.net', '1992-05-16', '2023-06-27 12:26:05'),
(64, 'Braeden', 'Wiegand', 'holden36@example.net', '2013-07-15', '1993-04-30 10:21:12'),
(65, 'Rodolfo', 'McKenzie', 'block.jayme@example.net', '2005-10-28', '2007-11-01 17:12:19'),
(66, 'Sherwood', 'Howe', 'dessie.deckow@example.org', '2021-05-20', '2017-08-04 05:06:01'),
(67, 'Ulises', 'Bernhard', 'lilian.gusikowski@example.com', '1990-04-19', '2005-06-22 06:15:56'),
(68, 'Adolfo', 'Bins', 'leannon.wilburn@example.com', '1997-11-28', '2020-09-14 20:51:11'),
(69, 'Nola', 'Spencer', 'axel88@example.com', '1998-01-24', '2000-09-10 04:29:09'),
(70, 'Marie', 'Reichel', 'brent.jerde@example.org', '2012-12-03', '2020-03-15 13:59:17'),
(71, 'Harmon', 'Nolan', 'ebert.joseph@example.com', '1980-03-15', '1986-03-01 00:35:15'),
(72, 'Holly', 'Steuber', 'theo.labadie@example.net', '2012-07-12', '2023-07-07 13:27:30'),
(73, 'Zita', 'Strosin', 'nitzsche.garnet@example.net', '2001-07-15', '1999-05-05 19:28:00'),
(74, 'Halie', 'Harris', 'frederique96@example.org', '1991-12-09', '2001-10-24 00:48:58'),
(75, 'Herman', 'Mosciski', 'ellis98@example.net', '1982-12-18', '2013-03-01 21:47:58'),
(76, 'Elmo', 'Tillman', 'gkertzmann@example.net', '2024-06-08', '1977-11-06 18:28:44'),
(77, 'Hannah', 'Dietrich', 'bartell.ines@example.net', '1989-05-26', '2003-09-08 09:07:18'),
(78, 'Gilda', 'Harris', 'okrajcik@example.org', '1992-05-18', '1987-03-12 08:59:30'),
(79, 'Palma', 'Kling', 'kariane85@example.com', '1971-11-13', '1994-10-03 10:55:23'),
(80, 'Leda', 'Larkin', 'dulce86@example.com', '2005-05-17', '2023-02-16 20:48:26'),
(81, 'Javonte', 'Mitchell', 'hertha55@example.net', '1998-04-25', '1970-08-14 11:13:00'),
(82, 'Joelle', 'Murray', 'tlynch@example.net', '1988-07-05', '2015-08-02 14:14:41'),
(83, 'Ray', 'Mayert', 'mable.boehm@example.com', '1971-01-15', '2015-09-24 09:12:36'),
(84, 'Germaine', 'Lakin', 'leffler.patsy@example.org', '1989-07-22', '1986-07-15 11:12:25'),
(85, 'Conor', 'White', 'sjast@example.com', '1982-09-06', '1986-01-09 07:43:15'),
(86, 'Elsie', 'Predovic', 'monroe.jaskolski@example.net', '1998-03-23', '1989-11-24 01:38:21'),
(87, 'Shany', 'Ernser', 'lou73@example.org', '2008-04-01', '2003-07-28 06:11:57'),
(88, 'Ulices', 'Cummings', 'jackson.orn@example.org', '1984-12-15', '1977-02-14 08:54:17'),
(89, 'Quinton', 'Hyatt', 'lesch.rogelio@example.net', '1989-04-28', '2024-05-31 10:42:19'),
(90, 'Chanelle', 'Nikolaus', 'nikko34@example.net', '1986-03-01', '1971-03-29 01:18:16'),
(91, 'Watson', 'Wintheiser', 'grutherford@example.com', '1985-07-09', '1991-04-25 03:15:14'),
(92, 'Eveline', 'Koss', 'cicero10@example.org', '2011-12-24', '1992-09-07 06:32:49'),
(93, 'Rollin', 'Parisian', 'adalberto78@example.org', '2021-02-18', '1972-08-13 00:20:11'),
(94, 'Madilyn', 'Feest', 'ukutch@example.com', '2000-03-02', '2002-03-23 03:01:24'),
(95, 'Lacey', 'Haag', 'sschmeler@example.com', '1980-03-14', '2022-06-18 15:11:12'),
(96, 'Fatima', 'Parker', 'sydnie.wehner@example.org', '1987-04-22', '1994-06-29 05:40:29'),
(97, 'Raquel', 'Wilderman', 'gislason.estelle@example.net', '1980-04-18', '1990-07-24 02:40:06'),
(98, 'Demetrius', 'Larson', 'raufderhar@example.net', '1977-11-02', '1981-11-23 10:52:05'),
(99, 'Geovanni', 'Wolff', 'santina70@example.net', '2021-09-23', '1975-09-10 20:34:03'),
(100, 'Camylle', 'Senger', 'margarette01@example.org', '2012-11-10', '2000-03-03 17:41:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
