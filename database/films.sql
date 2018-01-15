-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 16, 2018 at 01:47 AM
-- Server version: 5.7.16
-- PHP Version: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `top_films`
--

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `rated` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `released` date DEFAULT NULL,
  `runtime` int(11) DEFAULT NULL,
  `director` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `awards` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_to_poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imdb_rating` double(4,2) DEFAULT NULL,
  `other_rating` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`id`, `title`, `year`, `rated`, `released`, `runtime`, `director`, `awards`, `path_to_poster`, `imdb_rating`, `other_rating`, `created_at`, `updated_at`) VALUES
(1, 'Best Film', 2001, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-14 17:31:10', '2018-01-14 17:31:10'),
(2, 'Best Film Prat Two', 2002, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-14 17:31:25', '2018-01-14 17:31:25'),
(3, 'Batman', 1989, 'PG-13', '1989-06-23', 126, 'Tim Burton', 'Won 1 Oscar. Another 9 wins & 26 nominations.', './img/Bq7SH40swDfY2j2ntcM2MecVMxBoSCST.jpg', 7.60, '[{\"Value\": \"7.6/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"72%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"69/100\", \"Source\": \"Metacritic\"}]', '2018-01-14 17:34:33', '2018-01-14 17:34:33'),
(4, 'Trainspotting', 1996, 'R', '1996-08-09', 94, 'Danny Boyle', 'Nominated for 1 Oscar. Another 23 wins & 33 nominations.', './img/sUXXXczQuQo2BiuIeLaVWAScTteMUg1W.jpg', 8.20, '[{\"Value\": \"8.2/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"90%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"83/100\", \"Source\": \"Metacritic\"}]', '2018-01-15 18:30:19', '2018-01-15 18:30:19'),
(5, 'Star Wars: Episode IV - A New Hope', 1977, 'PG', '1977-05-25', 121, 'George Lucas', 'Won 6 Oscars. Another 50 wins & 28 nominations.', './img/Z9vjGBz9BQg8eZh86xBjuL6GsCzNu2dm.jpg', 8.70, '[{\"Value\": \"8.7/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"93%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"92/100\", \"Source\": \"Metacritic\"}]', '2018-01-15 18:31:09', '2018-01-15 18:31:09'),
(6, 'Filth', 2013, 'R', '2014-04-24', 97, 'Jon S. Baird', '9 wins & 13 nominations.', './img/vh1Hh7KcWsIPNXhypEzjHaRD4QRCPs8E.jpg', 7.10, '[{\"Value\": \"7.1/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"64%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"56/100\", \"Source\": \"Metacritic\"}]', '2018-01-15 18:31:32', '2018-01-15 18:31:32'),
(7, 'Rick and Morty', 2013, 'TV-14', '2013-12-02', 23, 'N/A', '10 wins & 11 nominations.', './img/rzg14wgVDwjGcdztXNFG52eMoRbg62oe.jpg', 9.30, '[{\"Value\": \"9.3/10\", \"Source\": \"Internet Movie Database\"}]', '2018-01-15 18:31:45', '2018-01-15 18:31:45'),
(8, 'Gravity Falls', 2012, 'TV-Y7', '2012-06-15', 23, 'N/A', 'Won 2 Primetime Emmys. Another 11 wins & 33 nominations.', './img/RRS6cJREUcVsPrDqJPhr6qIC9Sv1SeXy.jpg', 8.90, '[{\"Value\": \"8.9/10\", \"Source\": \"Internet Movie Database\"}]', '2018-01-15 18:32:06', '2018-01-15 18:32:06'),
(9, 'The Matrix', 1999, 'R', '1999-03-31', 136, 'Lana Wachowski, Lilly Wachowski', 'Won 4 Oscars. Another 34 wins & 45 nominations.', './img/IeVPTLBSlGIx03YNwAIEsKVqPH0IWvKq.jpg', 8.70, '[{\"Value\": \"8.7/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"87%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"73/100\", \"Source\": \"Metacritic\"}]', '2018-01-15 18:32:19', '2018-01-15 18:32:19'),
(10, 'Interstellar', 2014, 'PG-13', '2014-11-07', 169, 'Christopher Nolan', 'Won 1 Oscar. Another 43 wins & 143 nominations.', './img/pcJEjP7eouBJmtpPkg8Vm56AVuOeHkjm.jpg', 8.60, '[{\"Value\": \"8.6/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"71%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"74/100\", \"Source\": \"Metacritic\"}]', '2018-01-15 18:32:57', '2018-01-15 18:32:57'),
(11, 'Veronica Mars', 2004, 'TV-14', '2004-09-22', 44, 'N/A', '5 wins & 18 nominations.', './img/S7ifJnbGnjei81jfIC0gBghGHMLyaycO.jpg', 8.40, '[{\"Value\": \"8.4/10\", \"Source\": \"Internet Movie Database\"}]', '2018-01-15 18:33:11', '2018-01-15 18:33:11'),
(12, 'Mars', 2016, 'TV-PG', '2016-11-14', 60, 'N/A', '5 nominations.', './img/K7foRiKZU7SvL7u5Cw2Rkp8NAWkhpGpa.jpg', 7.50, '[{\"Value\": \"7.5/10\", \"Source\": \"Internet Movie Database\"}]', '2018-01-15 18:33:23', '2018-01-15 18:33:23'),
(13, 'Pulp Fiction', 1994, 'R', '1994-10-14', 154, 'Quentin Tarantino', 'Won 1 Oscar. Another 60 wins & 68 nominations.', './img/zXyQiYSCSUDt9Yvs0YeFkvP3cc9kDiw2.jpg', 8.90, '[{\"Value\": \"8.9/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"94%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"94/100\", \"Source\": \"Metacritic\"}]', '2018-01-15 18:33:48', '2018-01-15 18:33:48'),
(14, 'Knockin\' on Heaven\'s Door', 1997, 'NOT RATED', '1997-02-20', 87, 'Thomas Jahn', '8 wins & 3 nominations.', './img/MNAPK3y8vRWegrKfpzDkBxmX5pDbUcMg.jpg', 8.00, '[{\"Value\": \"8.0/10\", \"Source\": \"Internet Movie Database\"}]', '2018-01-15 18:33:58', '2018-01-15 18:33:58'),
(15, 'Forrest Gump', 1994, 'PG-13', '1994-07-06', 142, 'Robert Zemeckis', 'Won 6 Oscars. Another 39 wins & 66 nominations.', './img/6Y9PqRj2QW2eHbTGirdT5XvHP8R9DxoR.jpg', 8.80, '[{\"Value\": \"8.8/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"71%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"82/100\", \"Source\": \"Metacritic\"}]', '2018-01-15 18:34:09', '2018-01-15 18:34:09'),
(16, 'Inception', 2010, 'PG-13', '2010-07-16', 148, 'Christopher Nolan', 'Won 4 Oscars. Another 152 wins & 204 nominations.', './img/d1sf7qwaqmrlftKkg1WFVFcVgUyBDatR.jpg', 8.80, '[{\"Value\": \"8.8/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"86%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"74/100\", \"Source\": \"Metacritic\"}]', '2018-01-15 18:34:33', '2018-01-15 18:34:33'),
(17, 'Snatch', 2000, 'R', '2001-01-19', 102, 'Guy Ritchie', '4 wins & 6 nominations.', './img/dXhuWGbexg6YBFllogeVoAcdkZC8oAbY.jpg', 8.30, '[{\"Value\": \"8.3/10\", \"Source\": \"Internet Movie Database\"}, {\"Value\": \"73%\", \"Source\": \"Rotten Tomatoes\"}, {\"Value\": \"55/100\", \"Source\": \"Metacritic\"}]', '2018-01-15 18:34:54', '2018-01-15 18:34:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
