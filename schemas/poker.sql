-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2016 at 09:46 PM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poker`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(10) NOT NULL,
  `usersId` int(10) NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `type` enum('news','faq','rules','prize','instruction','message') COLLATE utf8_persian_ci NOT NULL DEFAULT 'news',
  `content` blob,
  `createdAt` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `balance_histories`
--

CREATE TABLE `balance_histories` (
  `id` int(10) NOT NULL,
  `player` varchar(255) NOT NULL,
  `amountChange` varchar(15) DEFAULT NULL,
  `amountBalance` varchar(15) DEFAULT NULL,
  `src` varchar(255) DEFAULT NULL,
  `createdAt` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cashouts`
--

CREATE TABLE `cashouts` (
  `id` int(10) NOT NULL,
  `usersId` int(10) NOT NULL,
  `comment` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `amount` int(10) NOT NULL,
  `card` int(16) NOT NULL,
  `account` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `holder` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `bank` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `shaba` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `status` enum('Yes','No','Cancel','Reject') COLLATE utf8_persian_ci NOT NULL,
  `createdAt` int(10) NOT NULL,
  `paidAt` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) NOT NULL,
  `usersId` int(10) NOT NULL,
  `comment` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `amount` int(10) NOT NULL,
  `status` enum('Yes','No') COLLATE utf8_persian_ci NOT NULL DEFAULT 'No',
  `ref` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `type` enum('Handy','Automatic') COLLATE utf8_persian_ci NOT NULL DEFAULT 'Automatic',
  `operator` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `createdAt` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_confirmations`
--

CREATE TABLE `email_confirmations` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `code` char(32) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `modifiedAt` int(10) UNSIGNED DEFAULT NULL,
  `confirmed` char(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `failed_logins`
--

CREATE TABLE `failed_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED DEFAULT NULL,
  `ipAddress` char(15) NOT NULL,
  `attempted` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `active`) VALUES
(1, 'Administrators', 'Y'),
(2, 'Users', 'Y'),
(3, 'Read-Only', 'Y'),
(4, 'Admin 1', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `hand_histories`
--

CREATE TABLE `hand_histories` (
  `id` int(10) NOT NULL,
  `player` varchar(255) NOT NULL,
  `type` enum('Yes','No') NOT NULL DEFAULT 'No',
  `name` varchar(255) DEFAULT NULL,
  `hand_number` int(10) DEFAULT NULL,
  `createdAt` int(10) NOT NULL,
  `hand` varchar(255) DEFAULT NULL,
  `hand_value` int(10) DEFAULT NULL,
  `amount` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `honors`
--

CREATE TABLE `honors` (
  `id` int(10) NOT NULL,
  `usersId` int(10) NOT NULL,
  `comment` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `prize` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `type` int(10) NOT NULL,
  `createdAt` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE `invitations` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `code` char(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `confirmed` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_changes`
--

CREATE TABLE `password_changes` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `ipAddress` char(15) NOT NULL,
  `userAgent` varchar(48) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `groupsId` int(10) UNSIGNED NOT NULL,
  `resource` varchar(25) NOT NULL,
  `action` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rakes`
--

CREATE TABLE `rakes` (
  `id` int(10) NOT NULL,
  `fromId` int(10) NOT NULL,
  `toId` int(10) NOT NULL,
  `comment` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `amount` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `hand` int(10) DEFAULT NULL,
  `status` set('Yes','No') COLLATE utf8_persian_ci NOT NULL DEFAULT 'No',
  `createdAt` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `token` char(32) NOT NULL,
  `userAgent` varchar(120) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reset_passwords`
--

CREATE TABLE `reset_passwords` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `code` varchar(48) NOT NULL,
  `createdAt` int(10) UNSIGNED NOT NULL,
  `modifiedAt` int(10) UNSIGNED DEFAULT NULL,
  `reset` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rings`
--

CREATE TABLE `rings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `auto_online` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `game` varchar(255) DEFAULT NULL,
  `pw` varchar(255) DEFAULT NULL,
  `private` enum('Yes','No') DEFAULT NULL,
  `perm_play` varchar(15) DEFAULT NULL,
  `perm_observe` varchar(15) DEFAULT NULL,
  `perm_player_chat` varchar(15) DEFAULT NULL,
  `perm_observer_chat` varchar(15) DEFAULT NULL,
  `suspend_chat_all_in` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `seats` int(2) NOT NULL,
  `smallest_chip` int(1) DEFAULT NULL,
  `minimum_buy_in` int(10) NOT NULL DEFAULT '400',
  `maximum_buy_in` int(10) NOT NULL DEFAULT '2000',
  `default_buy_in` int(10) NOT NULL DEFAULT '1200',
  `plan` int(1) DEFAULT NULL,
  `rake` int(3) NOT NULL DEFAULT '2',
  `rake_every` int(3) NOT NULL DEFAULT '100',
  `rake_max` int(10) NOT NULL DEFAULT '10000',
  `turn_clock` int(3) NOT NULL DEFAULT '30',
  `time_bank` int(3) NOT NULL DEFAULT '60',
  `bank_reset` int(3) NOT NULL DEFAULT '0',
  `dis_protect` enum('Yes','No') NOT NULL DEFAULT 'No',
  `small_blind` int(10) NOT NULL DEFAULT '10',
  `big_blind` int(10) NOT NULL DEFAULT '20',
  `dupe_ips` enum('Yes','No') NOT NULL DEFAULT 'No',
  `rathole_minutes` int(3) NOT NULL DEFAULT '0',
  `sitout_minutes` int(3) NOT NULL DEFAULT '10',
  `sitout_relaxed` enum('Yes','No') NOT NULL DEFAULT 'No',
  `speed` int(1) DEFAULT NULL,
  `status` enum('offline','online','private','paused') NOT NULL DEFAULT 'offline',
  `usersId` int(10) NOT NULL,
  `createdAt` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `success_logins`
--

CREATE TABLE `success_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `usersId` int(10) UNSIGNED NOT NULL,
  `ipAddress` char(15) NOT NULL,
  `userAgent` varchar(120) NOT NULL,
  `createdAt` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE `support` (
  `id` int(10) NOT NULL,
  `usersId` int(10) NOT NULL,
  `type` enum('request','respond') COLLATE utf8_persian_ci NOT NULL DEFAULT 'request',
  `content` blob,
  `toStatus` enum('read','unread','deleted') COLLATE utf8_persian_ci NOT NULL DEFAULT 'unread',
  `fromStatus` enum('read','unread','deleted') COLLATE utf8_persian_ci NOT NULL DEFAULT 'unread',
  `createdAt` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tourneys`
--

CREATE TABLE `tourneys` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(25) NOT NULL,
  `game` varchar(25) NOT NULL,
  `shootout` enum('Yes','No') NOT NULL DEFAULT 'No',
  `description` varchar(500) DEFAULT NULL,
  `auto` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `pw` varchar(255) DEFAULT NULL,
  `private` enum('Yes','No') DEFAULT 'No',
  `perm_register` varchar(15) DEFAULT NULL,
  `perm_unregister` varchar(15) DEFAULT NULL,
  `perm_observe` varchar(15) DEFAULT NULL,
  `perm_player_chat` varchar(15) DEFAULT NULL,
  `perm_observer_chat` varchar(15) DEFAULT NULL,
  `suspend_chat_all_in` enum('Yes','No') NOT NULL DEFAULT 'No',
  `tables` int(11) NOT NULL DEFAULT '1',
  `seats` int(2) NOT NULL DEFAULT '10',
  `start_full` enum('Yes','No') DEFAULT 'Yes',
  `start_min` int(10) NOT NULL DEFAULT '0',
  `start_code` int(10) NOT NULL DEFAULT '0',
  `start_time` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00',
  `reg_period` int(10) NOT NULL DEFAULT '0',
  `late_reg_minutes` int(1) NOT NULL DEFAULT '0',
  `min_players` int(3) NOT NULL DEFAULT '2',
  `recur_minutes` int(3) NOT NULL DEFAULT '0',
  `no_show_minutes` int(10) NOT NULL DEFAULT '0',
  `buy_in` int(11) NOT NULL DEFAULT '1500',
  `entry_fee` int(11) NOT NULL DEFAULT '0',
  `prize_bonus` int(11) NOT NULL DEFAULT '0',
  `multiply_bonus` enum('Yes','No','Min') NOT NULL DEFAULT 'No',
  `chips` int(11) NOT NULL DEFAULT '1500',
  `add_on_chips` int(11) NOT NULL DEFAULT '0',
  `turn_clock` int(3) NOT NULL DEFAULT '30',
  `time_bank` int(3) NOT NULL DEFAULT '60',
  `bank_reset` int(3) NOT NULL DEFAULT '0',
  `dis_protect` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `level` int(10) NOT NULL DEFAULT '10',
  `rebuy_levels` int(11) NOT NULL DEFAULT '0',
  `threshold` int(11) NOT NULL DEFAULT '1500',
  `max_rebuys` int(10) NOT NULL DEFAULT '0',
  `rebuy_cost` int(10) NOT NULL DEFAULT '0',
  `rebuy_fee` int(11) NOT NULL DEFAULT '0',
  `break_time` int(11) NOT NULL DEFAULT '0',
  `break_levels` int(10) NOT NULL DEFAULT '0',
  `stop_on_chop` enum('Yes','No') NOT NULL DEFAULT 'No',
  `blinds` varchar(1000) NOT NULL,
  `payout` varchar(1000) NOT NULL,
  `unreg_logout` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('online','offline','paused') NOT NULL DEFAULT 'offline',
  `usersId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(10) NOT NULL,
  `fromId` int(10) NOT NULL,
  `toId` int(10) NOT NULL,
  `comment` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `amount` int(10) NOT NULL,
  `createdAt` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `player` varchar(255) NOT NULL,
  `title` varchar(15) DEFAULT NULL,
  `xp` int(10) NOT NULL DEFAULT '0',
  `level` int(10) NOT NULL DEFAULT '0',
  `rake` decimal(4,2) NOT NULL DEFAULT '12.50',
  `gender` enum('Male','Female') DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `mustChangePassword` char(1) DEFAULT NULL,
  `groupsId` int(10) UNSIGNED NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `avatar` int(10) DEFAULT '1',
  `chat` int(1) DEFAULT NULL,
  `inviterId` int(10) DEFAULT NULL,
  `card` varchar(16) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `holder` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `shaba` varchar(255) DEFAULT NULL,
  `pin` int(4) NOT NULL,
  `banned` char(1) NOT NULL,
  `suspended` char(1) NOT NULL,
  `active` char(1) DEFAULT NULL,
  `createdAt` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `player`, `title`, `xp`, `level`, `rake`, `gender`, `name`, `email`, `password`, `mustChangePassword`, `groupsId`, `location`, `avatar`, `chat`, `inviterId`, `card`, `account`, `holder`, `bank`, `shaba`, `pin`, `banned`, `suspended`, `active`, `createdAt`) VALUES
(8, 'mahmood', '', 80337, 14, '19.50', 'Male', 'mahmoode', 'mahmood.test@yahoo.com', '$2a$08$3cQ5oI1wMPH10KFtdx8EL.XeaGoPh.6PZPxjqGBSus1YYU9PTPx.W', 'N', 1, 'tehraner', 32, NULL, NULL, '0', '', '', '', '', 6123, 'N', 'N', 'Y', 0),
(16, 'test', 'feat', 242318, 16, '20.50', 'Male', 'hh', 'yaghoob.test@yahoo.com', '$2a$08$KT7IZWoGas34JXwyy96AaON.5AsJ/07Hd/dUB310E9WMEVVjljtXW', 'N', 1, 'tehran', NULL, NULL, NULL, 'zxcvbnmasdfghjkl', '', '', '', 'IR012345678hsfdddddddddddddddddddddssssssssssssssssssssssssss901234567890123456789', 2022, 'N', 'N', 'Y', 0),
(17, 'Bahram', '', 5295, 8, '16.50', 'Male', 'Bahram khani', 'Bahram@bbb.com', '$2a$08$HAYwMhoo8U57vn6NFdJHn.YZQk18/3fayjmYGnfto.7b/YR7z/vo.', NULL, 2, 'ajabshir', 5, NULL, NULL, '0', '', '', '', '', 0, 'N', 'N', 'N', 0),
(19, 'mahmood2', NULL, 0, 0, '12.50', NULL, 'mahmood2', 'mail2mahmood_test@yahoo.com', '$2a$08$Mf3m5MPhiO0aiXgCxa8sSO5Blx3qqAup0utbcvCsQrgphVoodFoLK', NULL, 2, 'teh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'N', 'N', 'Y', 0),
(23, 'mehrdad', NULL, 0, 25, '25.00', NULL, 'mehrdad', 'mehrdad@yahoo.com', '$2a$08$xDchtKBRgGzCBeBxH7pvKOZ6RsUeNF77BtGDD4XKVPyt5hUfNgP/6', NULL, 2, 'teh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'N', 'N', 'N', 0),
(24, 'mahmood3', NULL, 0, 0, '12.50', NULL, 'mahmood3', 'hhh@hhh.hhh', '$2a$08$ou4aDPAnS9TIuMOGY61PZeY2GWvm.b7oK/aqUZZcBA26lsiD7k3PO', 'N', 2, 'teh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'N', 'N', 'Y', 0),
(81, 'mohsen', NULL, 250, 2, '13.50', NULL, 'saeidi', 'mo@mmo.mmm', '$2a$08$wVVlTe1WiXbNMw0j1lfjTua8g/R4t192OGdAuHqjQVHTlnF7na89u', 'N', 1, 'teh', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 'N', 'N', 'Y', 0),
(82, 'ali', '', 1594, 6, '15.50', 'Male', 'ali ahmadi', 'akli3@h.com', '$2a$08$tosF8WWBLjozrHR3Zjse4uwD0FPV2DnUFj0dynzvEkEk0dAGFKJ7u', 'N', 2, 'teh', 53, NULL, NULL, '0', '', '', '', NULL, 0, 'N', 'N', 'Y', 0),
(83, 'black', '', 13436, 10, '17.50', 'Male', 'black', 'hfhhf@hh.com', '$2a$08$qbOK5995RjfmM8cj5qjXBOlC2agtEFj073a4x3X.FLaKmYrOufmgC', 'N', 1, 'tehran', NULL, NULL, NULL, '0', '', '', '', NULL, 0, 'N', 'N', 'Y', 0),
(85, 'mohammad', NULL, 159, 1, '13.00', NULL, 'mohammadb', 'm@ha.com', '$2a$08$5JKB3EyCuXNqC0L4d1I1iOf9voGTgOiQudjuL80BO3LWhz7OqsCNK', 'N', 2, 'tehran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5749, 'N', 'N', 'Y', 0),
(86, 'amir', NULL, 0, 0, '12.50', NULL, 'amiiiir', 'test@g.com', '$2a$08$rDArui85cMkCsK7uoLGA4OnpOdyHmBcckxfoyYV6hmOhb7BDlj3Qy', 'N', 2, 'ghazvin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'N', 'N', 'Y', 0),
(87, 'Admin', '', 2657, 7, '16.00', '', 'GutShot', 'gutshot@poker.com', '$2a$08$rmqkkZJbkZ446CsRCkNtsuuaUThyyTptTKL98E9iER1IJWNpMYkNC', 'N', 2, 'Iran', NULL, NULL, NULL, '0', '', '', '', NULL, 0, 'N', 'N', 'Y', 0),
(88, 'Amiryaghoob', '', 278, 2, '13.50', '', 'Amir', 'amirtest12@yahoo.com', '$2a$08$ncrkQsWCw6iMgGRfidHyVerZn.kctovtRieqh.lF52cH7oGDxOWS6', 'N', 2, 'Gutshot casino', 1, NULL, NULL, '0', '', '', '', '', 0, 'N', 'N', 'Y', 0),
(89, 'asghar', '', 32249, 12, '18.50', 'Male', 'asghar dada dada', 'yaghoob.test1@yahoo.com', '$2a$08$IshDWPdCA2xKH7JQNkXrf.FQpwjQ7tsaaCz9hHo6EWjVC8KtxuJgi', 'N', 2, 'tehran', 33, NULL, NULL, '603799', '1256', 'asg', 'test', 'IRTCI', 7034, 'N', 'N', 'Y', 0),
(90, 'mona', '', 49, 0, '12.50', '', 'mona joon', 'yaghoobtest6@yahoo.com', '$2a$08$GqcHvOqp1P0n18bCzIbzVudEMSqRkrRECCQmcU1c/UmP4UlhSJGH6', 'N', 2, 'teh', NULL, NULL, 16, '646', '0', 'kghj', 'kgj', '0', 1427, 'N', 'N', 'Y', 0),
(91, 'gutshot2', '', 212, 1, '13.00', 'Male', 'Gutshot', 'gutshot.club1@yahoo.com', '$2a$08$AaEOW7PZtV0vNqcxw4JEO.Jnx2HmKDNzQMuBpnvLGbPUA.HMorOIa', 'N', 2, 'ir', NULL, NULL, 16, '6104', '333778', 'gggg', 'mmmm', '', 4080, 'Y', 'Y', 'N', 0),
(92, 'mostafa', NULL, 26782, 12, '18.50', 'Male', 'mostafa', 'yaghoobtest@yahoo.com', '$2a$08$svC79kdB1JcVWyfbFdG9keIi1UNEDjNQ4n8XZNNAzVg2DI4kjDcFG', 'N', 2, 'tehran', NULL, NULL, 16, '666666', '44444', 'fff', 'mmmm', NULL, 2506, 'N', 'N', 'Y', 0),
(95, 'jafar', '', 0, 0, '12.50', '', 'jafar riki', 'jafar.riki@yahoo.com', '$2a$08$YJarTh27qY1cRHSIEdohqOm/2Sy8ACBjycfpCI6Y/63TWa84WZtfa', 'N', 2, 'tehran gharb', 1, NULL, NULL, '0', '', '', '', NULL, 8917, 'N', 'N', 'Y', 0),
(96, 'User', '', 0, 0, '12.50', 'Male', 'User', 'user@user.com', '$2a$08$umgfVkE86azKUgAGUuo64upPGZQzQylC8xp6.jESV.ZKbvSIKel.C', 'N', 2, 'userestan', 1, NULL, NULL, '0', '', '', '', NULL, 7429, 'N', 'N', 'Y', 0),
(97, 'dathfeat', '', 16497, 11, '18.00', 'Male', 'yaghoob', 'Hossein.test2@yahoo.com', '$2a$08$wBKOYoUflVsqnsWIhQI9Mu.wmVB/sidJx2ENcyjjHG2WrGMemznMG', 'N', 2, 'Gutsho casino', 1, NULL, 16, '6037', '66', 'fgh', 'hfh', NULL, 3118, 'N', 'N', 'Y', 0),
(98, 'reza', '', 0, 25, '25.00', 'Male', 'reza', 'reza@yho.com', '$2a$08$e3dRtqftyumm5m0XsgBZrOmQVrw6tIycPRg4NIPRlc26tSiw4VH5m', 'N', 2, 'teh', 1, NULL, NULL, '0', '', '', '', NULL, 1739, 'Y', 'Y', 'N', 0),
(99, 'Corpse', '', 1257, 5, '15.00', 'Female', 'Daryoosh', 'hero@n.com', '$2a$08$dV7u3MTavMa9LoGh0XSJkuPa6zXZ429TXSYm/tEPeV5uFoD9N5MEm', 'N', 2, 'Eivagh', 1, NULL, NULL, '0', '', '', '', NULL, 1172, 'N', 'N', 'Y', 0),
(100, 'Lampard', '', 10961, 10, '17.50', '', 'Lampard', 'amirtest3@yahoo.com', '$2a$08$SaAW5Ex4eRXTCtDyQSIr1O.Uc7U6MuV9K/osPiD2/qHfsGizWxE9u', 'N', 4, 'Tehran', 1, NULL, 16, '0', '', '', '', '', 8745, 'N', 'N', 'Y', 0),
(102, 'Kamran', '', 4275, 8, '16.50', '', 'Kamran', 'Amirtest4@yahoo.com', '$2a$08$h6AgDryM3n3sW451cCAbHO7mojHWF0w5f78uqq7.kaMQsPlKgom/2', 'N', 2, 'Ghazvin ', 1, NULL, 89, '0', '', '', '', '', 5824, 'N', 'N', 'Y', 0),
(103, 'sara', '', 6010, 8, '16.50', '', 'dara', 'Amirtest@yahoo.com', '$2a$08$tHDOroUEVWI8CQ5wLag7t.XxEXaR.l6BN.3tDM0q1a13Vs5piWb9m', 'N', 2, 'bushehr', 1, NULL, 16, '0', '', '', '', '', 8865, 'N', 'N', 'Y', 0),
(104, 'mahsa', '', 50, 0, '12.50', 'Female', 'mahsa', 'mahsa@y.com', '$2a$08$evPSZn5JJsKtm09DrprMseX3XS.N1Y6fG/r.Paq4CPQxtwzGq4bnS', 'N', 2, 'tehran', 1, NULL, NULL, '0', '', '', '', '', 7307, 'N', 'N', 'Y', 0),
(107, 'miladpoker', '', 0, 0, '12.50', '', 'milad', 'mona.farazchi@yahoo.com', '$2a$08$gm6Lj3teJQuAku1L3TnOluTtJ9jUPdEdy5h98c879DBpFHVygy/Ni', 'N', 2, 'tehran', 1, NULL, 0, '0', '', '', '', '', 8045, 'N', 'N', 'Y', 0),
(109, 'RounderR', NULL, 0, 0, '12.50', NULL, 'r', 'daniyal_1360@yahoo.com', '$2a$08$RbfPcRtDpCxLaFgl8Wcg5.f9tlCQ3yDEjmo0E8rlrBTC97WmYlahK', 'N', 2, 'teh', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, 3266, 'N', 'N', 'N', 0),
(110, 'behnaaam', '', 0, 0, '12.50', 'Male', 'Behnaaam', 'test@ninini.nin', '$2a$08$XTlSo5QeOCrYsXDymHJhj.hH1Ge5nG68G2opTZ65eMhNPJPHI4lhS', 'N', 2, 'teh', 1, NULL, NULL, '', '', '', '', '', 9890, 'N', 'N', 'Y', 0),
(114, 'frank', '', 726, 4, '14.50', '', 'frank', 'frank@kfk.com', '$2a$08$elleZDy4TLrXwOneu24XPeKEFmIvyd6eodtBE.5owpRfgT47AdFzi', 'N', 4, 'chahar mahal o bakhtiari', 1, NULL, 0, '', '', '', '', '', 6620, 'N', 'N', 'Y', 0),
(115, 'Morgan', '', 92, 0, '12.50', '', 'Morgan', 'Morgan@bak.com', '$2a$08$T54uKDW5DBXN7eFFoItGCOgBprX18bnvmwCsPOTGyfOVqE4zPRaPS', 'N', 2, 'Teh', 1, NULL, 0, '', '', '', '', '', 7383, 'N', 'N', 'Y', 0),
(116, 'pokerman', '', 2135, 6, '15.50', '', 'poker man', 'asghar@pp.com', '$2a$08$EqYdr3SahBk7o7LQ0L5bY.pE7VcC4oSQ6Y02cPmfaDmSmKtYy59AC', 'N', 1, 'tehran', 1, NULL, 0, '', '', '', '', '', 7636, 'N', 'N', 'Y', 0),
(117, 'saragoli', '', 23, 0, '12.50', '', 'sara goli', 'asghar@tt.com', '$2a$08$sEQxekvJcwWKZgcTfFKNNeR/1nuln2Ir4gc8NTBRRRfZJXdIuhuvS', 'N', 4, 'tehran', 1, NULL, 0, '', '', '', '', '', 5203, 'N', 'N', 'Y', 0),
(118, 'saeed', '', 3010, 7, '16.00', '', 'saeed', 'saed@gha.com', '$2a$08$4KEZIrF67TPOR7A49Q6HO.Wt4jRIPvEKwdQY2Vr/jxa6Q2qEL9IWi', 'N', 1, 'ghazin', 1, NULL, 0, '', '', '', '', '', 9878, 'N', 'N', 'Y', 0),
(119, 'Mayhem', '', 0, 0, '12.50', '', 'Mayhem', 'Mayhem@black.com', '$2a$08$BCvdL97qpSMCMTJMrZpOLugCpctYHUrm3MdBXgM/kFO84WXBW5a52', 'N', 2, 'Teh', 1, NULL, 0, '', '', '', '', '', 9998, 'N', 'N', 'Y', 0),
(120, 'tatalebaba', '', 238, 1, '13.00', '', 'maghsudloo', 'maghsudloo@yy.com', '$2a$08$bL3MEg9fVas7FEYHLRrFIOEqnAdmMcn.YCl7YOeCA8Ib4Sz0hNCqC', 'N', 2, 'teh', 1, NULL, 0, '', '', '', '', '', 9002, 'N', 'N', 'Y', 0),
(121, 'manizhe', '', 1389, 5, '15.00', '', 'manizh', 'maghsudloo@yy.co', '$2a$08$CFMdXXQVtQrCwvjm5iOqoOOeftdsEWmLQiZLLlKnBioVjaN7tkr8e', 'N', 2, 'ghazvin', 1, NULL, 0, '', '', '', '', '', 6827, 'N', 'N', 'Y', 0),
(122, 'ahmadreza', '', 0, 0, '12.50', '', 'ahmadreza', 'dddd@ttt.co', '$2a$08$z7NEKg2PnxJzOHw8v3k5ie2pZQ9rhkL4aaQD1LF6THCOUDvxT0s2.', 'N', 2, 'tehran', 1, NULL, 0, '', '', '', '', '', 5142, 'N', 'N', 'Y', 0),
(123, 'jalal', '', 4, 0, '12.50', '', 'jalal hemati', 'jjjj@hhhh.co', '$2a$08$VdY4NnpOqdcF30ytTqrVV.GtGFUUyx.8F51X8HXtsQHs797n0PWXu', 'N', 2, 'teh', 1, NULL, 0, '', '', '', '', '', 6425, 'N', 'N', 'Y', 0),
(124, 'hamidam', '', 23, 0, '12.50', '', 'hamin', 'hamid@fff.com', '$2a$08$jCQNElEVUPf6g5TZrvep4OeAZf7ZOOPgsstRjlvtwsywO7wdxrPvG', 'N', 4, 'shahrak', 1, NULL, 0, '', '', '', '', '', 1778, 'N', 'N', 'Y', 1462539577),
(125, 'chilavert', '', 866, 4, '14.50', '', 'SURENA', 'JHVH@GF.YHH.JN', '$2a$08$KYHOuizbdLqgu69nGEpxyuF7UViRxFLZngW4wXPxrLt1Q/nB3Vj1O', 'N', 2, 'teh', 1, NULL, 0, '', '', '', '', '', 8312, 'N', 'N', 'Y', 1462552624),
(126, 'sepehr', '', 416, 2, '13.50', '', 'sepehr', 'yaghoobtest7@yahoo.com', '$2a$08$JypRtkLb6fDQASUt5brrSufK1.OZ7jQWFtwwx8fJkCH5QmOFvpXte', 'N', 2, 'Tehran', 1, NULL, 117, '', '', '', '', '', 5320, 'N', 'N', 'Y', 1462562584),
(127, 'mosi', '', 247, 1, '13.00', 'Male', 'User', 'yaghoobtest9@yahoo.com', '$2a$08$TxGRbQFxbJgWUDqXH1jvr.l1AGBNnMAmsqt9Vc5m69h/H2u/vREoW', 'N', 2, 'Tehran', 1, NULL, 118, '', '', '', '', '', 6791, 'N', 'N', 'Y', 1462562892);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`createdAt`);

--
-- Indexes for table `balance_histories`
--
ALTER TABLE `balance_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashouts`
--
ALTER TABLE `cashouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`createdAt`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`createdAt`);

--
-- Indexes for table `email_confirmations`
--
ALTER TABLE `email_confirmations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_logins`
--
ALTER TABLE `failed_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `active` (`active`);

--
-- Indexes for table `hand_histories`
--
ALTER TABLE `hand_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `honors`
--
ALTER TABLE `honors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`createdAt`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_changes`
--
ALTER TABLE `password_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profilesId` (`groupsId`);

--
-- Indexes for table `rakes`
--
ALTER TABLE `rakes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`createdAt`);

--
-- Indexes for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `reset_passwords`
--
ALTER TABLE `reset_passwords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

--
-- Indexes for table `rings`
--
ALTER TABLE `rings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profilesId` (`pw`);

--
-- Indexes for table `success_logins`
--
ALTER TABLE `success_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

--
-- Indexes for table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`createdAt`);

--
-- Indexes for table `tourneys`
--
ALTER TABLE `tourneys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`createdAt`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profilesId` (`groupsId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `balance_histories`
--
ALTER TABLE `balance_histories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1991;
--
-- AUTO_INCREMENT for table `cashouts`
--
ALTER TABLE `cashouts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=695;
--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=687;
--
-- AUTO_INCREMENT for table `email_confirmations`
--
ALTER TABLE `email_confirmations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT for table `failed_logins`
--
ALTER TABLE `failed_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hand_histories`
--
ALTER TABLE `hand_histories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6741;
--
-- AUTO_INCREMENT for table `honors`
--
ALTER TABLE `honors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;
--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `password_changes`
--
ALTER TABLE `password_changes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2491;
--
-- AUTO_INCREMENT for table `rakes`
--
ALTER TABLE `rakes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;
--
-- AUTO_INCREMENT for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `reset_passwords`
--
ALTER TABLE `reset_passwords`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `rings`
--
ALTER TABLE `rings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `success_logins`
--
ALTER TABLE `success_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1181;
--
-- AUTO_INCREMENT for table `support`
--
ALTER TABLE `support`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `tourneys`
--
ALTER TABLE `tourneys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
