-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2021 at 01:21 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

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
  `authorsId` int(11) NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `age` int(3) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`authorsId`, `authorName`, `age`, `genre`) VALUES
(1, 'Vikram Seth', 66, 'poetry'),
(2, 'Abu\'l-Fazi ibn Mubarak (deceased)', 0, 'biography'),
(3, 'Phillip Zimbardo', 87, 'psychology'),
(4, 'Jane Austen (deceased)', 0, 'fiction'),
(5, 'J.M. Coetzee', 81, 'fiction'),
(6, 'Phillip', 34, 'poetry'),
(7, 'Phillip', 34, 'poetry');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookId` int(11) NOT NULL,
  `bookTitle` varchar(100) NOT NULL,
  `year` int(4) NOT NULL,
  `genre` varchar(20) NOT NULL,
  `agegroup` varchar(50) DEFAULT NULL,
  `authorsId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookId`, `bookTitle`, `year`, `genre`, `agegroup`, `authorsId`) VALUES
(1, 'The Tale of Melon City ', 1981, 'poetry', '16+', 1),
(3, 'The Humble Administrator\'s Garden', 1985, 'poetry', '18+', 1),
(4, 'All You Who Sleep Tonight', 1990, 'poetry', '18+', 1),
(6, 'The Cognitive Control of Motivation', 1969, 'psychology', '18+', 3),
(7, 'Stanford Prison Experiment: A Simulation Study of the Psychology of Imprisonment', 1972, 'psychology', '18+', 3),
(8, 'Influencing Attitudes and Changing Behaviour', 1969, 'psychology', '18+', 3),
(9, 'Sense and Sensibility ', 1811, 'fiction', '12+', 4),
(10, 'Pride and Prejudice', 1813, 'fiction', '14+', 4),
(11, 'Mansfield Park', 1814, 'fiction', '18+', 4),
(12, 'Emma', 1815, 'fiction', 'children\'s fiction', 4),
(13, 'Northanger Abbey', 1818, 'fiction', 'teenage fiction', 4),
(14, 'Persuasion', 1818, 'fiction', 'adult fiction', 4),
(15, 'Lady Susan', 1871, 'fiction', 'adult fiction', 4),
(16, 'The Childhood of Jesus', 2013, 'fiction', '12-14', 5),
(17, 'The Schooldays of Jesus', 2016, 'fiction', '8-10', 5),
(19, 'The Death of Jesus', 2019, 'fiction', '12-17', 5),
(20, 'Akbarnama', 2011, 'biography', '18+', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pwdreset`
--

INSERT INTO `pwdreset` (`pwdResetId`, `pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpires`) VALUES
(7, 'wordsbychristinehogg@gmail.com', '94069a289127d196', '$2y$10$yi8EXCBcw/4aQd1bwSlfg.IR3daIPSfLxQU.hioIfJlLs/TZALkMa', '1634900744');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersId` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `userType` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPwd`, `userType`) VALUES
(1, 'Christine Hogg', 'wordsbychristinehogg@gmail.com', 'cs', '$2y$10$IOV0cIP65LprU8PoFoibpOpGjx4.M.jTqE5MagA6L0mZJcU4uzM2y', 'admin'),
(2, 'Chris', 'christine_hogg@hotmail.com', 'C', '$2y$10$KSPQU0GT2dFH6i6g6CqaXO5evPzPUjzscz351pspwGXhiqYKClp8a', 'member'),
(3, 'John Member', 'john@doe.com', 'Jo', '$2y$10$UXZsWE0yTcJ.amt5BBKKqu79/xUbhOHvmcZ6vBhc6nWTbZe444Siq', 'member'),
(4, 'Jane Admin', 'jane@doe.com', 'Ja', '$2y$10$dBCCKl6E7jr0UDi1DKLe5eFFV7EIqrpO04E/vPrlMkzuKaKN5tng2', 'admin'),
(5, 'Christine Hogg', 'test@gmail.com', 'Test', '$2y$10$XqTG5dLLJ5ja1C7cKvP9Xu7/w9WQIwBd1qRmCQ8HjsaWsi7pUJFrG', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`authorsId`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookId`),
  ADD KEY `authorsId` (`authorsId`) USING BTREE;

--
-- Indexes for table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `authorsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`authorsId`) REFERENCES `authors` (`authorsId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
