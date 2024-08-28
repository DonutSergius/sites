-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Сер 28 2024 р., 13:39
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `sites`
--

-- --------------------------------------------------------

--
-- Структура таблиці `certificate`
--

CREATE TABLE `certificate` (
  `certificate_id` int(11) NOT NULL,
  `certificate_name` text NOT NULL,
  `certificate_date_start` datetime NOT NULL DEFAULT current_timestamp(),
  `certificate_date_end` datetime NOT NULL,
  `certificate_count_days` int(11) NOT NULL,
  `certificate_user_id` int(11) NOT NULL,
  `certificate_type` varchar(10) NOT NULL,
  `certificate_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `certificate`
--

INSERT INTO `certificate` (`certificate_id`, `certificate_name`, `certificate_date_start`, `certificate_date_end`, `certificate_count_days`, `certificate_user_id`, `certificate_type`, `certificate_status`) VALUES
(1, 'Bonus certificate toadmin', '2024-08-04 18:07:32', '2024-08-09 00:00:00', 0, 1, 'Bonus', 'Active'),
(2, 'Bonus certificate toadmin', '2024-08-08 19:54:54', '2024-08-09 00:00:00', 0, 1, 'Bonus', 'Active'),
(3, 'Bonus certificate toadmin', '2024-08-08 19:55:09', '2024-08-09 00:00:00', 3, 1, 'Bonus', 'Unactive'),
(11, 'Bonus certificate to admin', '2024-08-25 18:33:35', '2024-09-06 00:00:00', 5, 1, 'Bonus', 'Unactive'),
(12, 'Bonus certificate to user', '2024-08-26 14:12:03', '2024-08-28 00:00:00', 3, 2, 'Bonus', 'Unactive'),
(13, 'Bonus certificate to TeamLead', '2024-08-27 14:08:59', '2024-09-08 00:00:00', 1, 3, 'Bonus', 'Active'),
(14, 'Bonus certificate to admin', '2024-08-27 15:39:00', '2024-09-03 00:00:00', 1, 1, 'Bonus', 'Active');

-- --------------------------------------------------------

--
-- Дублююча структура для представлення `homepageview`
-- (Див. нижче для фактичного подання)
--
CREATE TABLE `homepageview` (
`vacation_id` int(11)
,`user_nickname` varchar(50)
,`vacation_type` varchar(20)
,`vacation_date_type` varchar(10)
,`vacation_date_start` datetime
,`vacation_date_end` datetime
,`vacation_reason` text
);

-- --------------------------------------------------------

--
-- Структура таблиці `operation`
--

CREATE TABLE `operation` (
  `operation_id` int(11) NOT NULL,
  `operation_user_id` int(11) DEFAULT NULL,
  `operation_name` text DEFAULT NULL,
  `operation_count_before` int(11) DEFAULT NULL,
  `operation_count` int(11) DEFAULT NULL,
  `operation_count_after` int(11) DEFAULT NULL,
  `operation_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `operation`
--

INSERT INTO `operation` (`operation_id`, `operation_user_id`, `operation_name`, `operation_count_before`, `operation_count`, `operation_count_after`, `operation_date`) VALUES
(1, 1, 'Gived Bonus Certificate', 0, 5, 5, '2024-08-25 18:33:35'),
(2, 2, 'Gived Bonus Certificate', 0, 3, 3, '2024-08-26 14:12:03'),
(3, 3, 'Gived Bonus Certificate', 0, 1, 1, '2024-08-27 14:08:59'),
(4, 1, 'Gived Bonus Certificate', 0, 2, 2, '2024-08-27 15:39:00'),
(5, 1, 'Gived Bonus Certificate', 0, 2, 1, '2024-08-28 12:25:02'),
(6, 1, 'Gived Bonus Certificate', 0, 1, 0, '2024-08-28 12:26:46'),
(7, 1, 'Gived Bonus Certificate', 0, 1, 2, '2024-08-28 12:26:46'),
(8, 1, 'Approved vacation', 0, 0, 0, '2024-08-28 12:28:34'),
(9, 1, 'Approved vacation', 2, 2, 0, '2024-08-28 12:28:34'),
(10, 1, 'Approved vacation', 2, 1, 1, '2024-08-28 12:28:34');

-- --------------------------------------------------------

--
-- Структура таблиці `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_vacation_day` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_vacation_day`) VALUES
(1, 'admin', 7),
(2, 'PM', 9),
(3, 'TeamLead', 9),
(4, 'JuniorDeveloper', 7);

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_nickname` varchar(50) NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_role` int(11) NOT NULL,
  `user_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_password` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`user_id`, `user_nickname`, `user_first_name`, `user_last_name`, `user_role`, `user_created`, `user_password`, `user_email`) VALUES
(1, 'admin', 'admin_name', 'admin_last', 1, '2024-07-28 17:22:20', 'admin', 'admin@admin.com'),
(2, 'user', 'first', 'last', 4, '2024-07-28 20:34:15', 'user', 'user@gmail.com'),
(3, 'TeamLead', 'TeamLeadFirst', 'TeamLeadLast', 3, '2024-07-28 20:48:26', 'TeamLead', 'TeamLead@gmail.com'),
(4, 'UserPM', 'first', 'last', 2, '2024-08-04 19:02:45', '1234', 'userPM@gmail.com');

-- --------------------------------------------------------

--
-- Дублююча структура для представлення `uservacationrequest`
-- (Див. нижче для фактичного подання)
--
CREATE TABLE `uservacationrequest` (
`vacation_id` int(11)
,`vacation_type` varchar(20)
,`vacation_date_type` varchar(10)
,`vacation_date_start` datetime
,`vacation_date_end` datetime
,`vacation_reason` text
,`vacation_status` varchar(50)
,`user_nickname` varchar(50)
);

-- --------------------------------------------------------

--
-- Дублююча структура для представлення `user_info`
-- (Див. нижче для фактичного подання)
--
CREATE TABLE `user_info` (
`user_id` int(11)
,`user_nickname` varchar(50)
,`user_role` varchar(50)
,`user_first_name` varchar(50)
,`user_last_name` varchar(50)
,`user_created` datetime
,`user_email` varchar(50)
);

-- --------------------------------------------------------

--
-- Дублююча структура для представлення `vacationtoapproval`
-- (Див. нижче для фактичного подання)
--
CREATE TABLE `vacationtoapproval` (
`vacation_id` int(11)
,`user_nickname` varchar(50)
,`vacation_type` varchar(20)
,`vacation_date_type` varchar(10)
,`vacation_date_start` datetime
,`vacation_date_end` datetime
,`vacation_reason` text
,`vacation_status` varchar(50)
);

-- --------------------------------------------------------

--
-- Дублююча структура для представлення `vacation_info`
-- (Див. нижче для фактичного подання)
--
CREATE TABLE `vacation_info` (
`vacation_id` int(11)
,`user` varchar(50)
,`vacation_type` varchar(20)
,`vacation_date_type` varchar(10)
,`vacation_date_start` datetime
,`vacation_date_end` datetime
,`vacation_reason` text
,`vacation_approval` int(11)
);

-- --------------------------------------------------------

--
-- Структура таблиці `vacation_request`
--

CREATE TABLE `vacation_request` (
  `vacation_id` int(11) NOT NULL,
  `vacation_user_id` int(11) NOT NULL,
  `vacation_type` varchar(20) NOT NULL,
  `vacation_date_type` varchar(10) NOT NULL,
  `vacation_date_start` datetime NOT NULL,
  `vacation_date_end` datetime NOT NULL,
  `vacation_reason` text NOT NULL,
  `vacation_status` varchar(50) NOT NULL,
  `vacation_approval` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `vacation_request`
--

INSERT INTO `vacation_request` (`vacation_id`, `vacation_user_id`, `vacation_type`, `vacation_date_type`, `vacation_date_start`, `vacation_date_end`, `vacation_reason`, `vacation_status`, `vacation_approval`) VALUES
(1, 1, 'paid', 'fullDay', '2024-07-28 00:00:00', '2024-07-30 00:00:00', 'sdfaaf', 'canceled', 1),
(2, 1, 'paid', 'fullDay', '2024-07-29 00:00:00', '2024-07-30 00:00:00', '1', 'canceled', 1),
(3, 3, 'unpaid', 'specificTi', '2024-07-29 12:49:00', '2024-07-29 17:50:00', 'Test vacation', '', 1),
(4, 3, 'unpaid', 'specificTi', '2024-07-30 15:10:00', '2024-07-31 15:10:00', 'пвіп', '', 1),
(5, 1, 'paid', 'fullDay', '2024-08-05 00:00:00', '2024-08-06 00:00:00', '1', 'canceled', 1),
(6, 1, 'paid', 'fullDay', '2024-08-27 00:00:00', '2024-08-28 00:00:00', 'dsf', 'canceled', 1),
(7, 1, 'paid', 'fullDay', '2024-08-26 00:00:00', '2024-08-29 00:00:00', 'dsf', 'canceled', 1),
(8, 1, 'paid', 'fullDay', '2024-08-26 00:00:00', '2024-08-29 00:00:00', 'dsf', 'canceled', 1),
(9, 1, 'paid', 'fullDay', '2024-09-02 00:00:00', '2024-09-04 00:00:00', 'Test2', 'Disapproved', 1),
(10, 1, 'paid', 'fullDay', '2024-08-28 00:00:00', '2024-08-29 00:00:00', 'Coool', 'canceled', 1),
(11, 1, 'paid', 'fullDay', '2024-08-27 00:00:00', '2024-08-28 00:00:00', 'ads', 'Pending', 1),
(12, 1, 'paid', 'fullDay', '2024-08-27 00:00:00', '2024-08-28 00:00:00', 'ads', 'Approved', 1),
(13, 1, 'paid', 'fullDay', '2024-08-28 00:00:00', '2024-08-29 00:00:00', 'test approval', 'Pending', 0),
(14, 1, 'paid', 'fullDay', '2024-08-28 00:00:00', '2024-08-29 00:00:00', 'test approval', 'Pending', 0),
(15, 1, 'paid', 'fullDay', '2024-08-27 00:00:00', '2024-08-28 00:00:00', 'testts', 'Pending', 4),
(16, 1, 'paid', 'fullDay', '2024-08-27 00:00:00', '2024-08-28 00:00:00', 'Last tdvdsa', 'Pending', 3),
(17, 1, 'paid', 'fullDay', '2024-08-27 00:00:00', '2024-08-28 00:00:00', 'Last tdvdsa', 'Pending', 3),
(18, 1, 'paid', 'fullDay', '2024-08-27 00:00:00', '2024-08-28 00:00:00', 'Last tdvdsa', 'Pending', 3),
(19, 1, 'paid', 'fullDay', '2024-09-02 00:00:00', '2024-09-06 00:00:00', 'test', 'Approved', 4),
(22, 1, 'paid', 'fullDay', '2024-09-02 00:00:00', '2024-09-03 00:00:00', '2024-09-03', 'Approved', 4),
(23, 3, 'paid', 'fullDay', '2024-09-03 00:00:00', '2024-09-04 00:00:00', '2024-09-04', 'Approved', 4),
(24, 3, 'paid', 'fullDay', '2024-09-02 00:00:00', '2024-09-03 00:00:00', 'Coool', 'Pending', 3),
(25, 1, 'paid', 'fullDay', '2024-09-03 00:00:00', '2024-09-10 00:00:00', 'test', 'Disapproved', 4),
(26, 1, 'paid', 'fullDay', '2024-09-03 00:00:00', '2024-09-04 00:00:00', 'test op', 'Disapproved', 1),
(27, 1, 'paid', 'fullDay', '2024-09-04 00:00:00', '2024-09-05 00:00:00', 'dfff', 'Disapproved', 1),
(28, 1, 'paid', 'fullDay', '2024-09-03 00:00:00', '2024-09-04 00:00:00', '2', 'Disapproved', 1),
(29, 1, 'paid', 'fullDay', '2024-09-03 00:00:00', '2024-09-04 00:00:00', '3', 'Approved', 1),
(30, 1, 'paid', 'fullDay', '2024-09-03 00:00:00', '2024-09-04 00:00:00', '3', 'Approved', 1),
(31, 1, 'paid', 'fullDay', '2024-09-04 00:00:00', '2024-09-06 00:00:00', 'test4', 'Approved', 1);

-- --------------------------------------------------------

--
-- Структура для представлення `homepageview`
--
DROP TABLE IF EXISTS `homepageview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `homepageview`  AS SELECT `vacation_request`.`vacation_id` AS `vacation_id`, `user`.`user_nickname` AS `user_nickname`, `vacation_request`.`vacation_type` AS `vacation_type`, `vacation_request`.`vacation_date_type` AS `vacation_date_type`, `vacation_request`.`vacation_date_start` AS `vacation_date_start`, `vacation_request`.`vacation_date_end` AS `vacation_date_end`, `vacation_request`.`vacation_reason` AS `vacation_reason` FROM (`vacation_request` join `user` on(`user`.`user_id` = `vacation_request`.`vacation_user_id`)) ;

-- --------------------------------------------------------

--
-- Структура для представлення `uservacationrequest`
--
DROP TABLE IF EXISTS `uservacationrequest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `uservacationrequest`  AS SELECT `vacation_request`.`vacation_id` AS `vacation_id`, `vacation_request`.`vacation_type` AS `vacation_type`, `vacation_request`.`vacation_date_type` AS `vacation_date_type`, `vacation_request`.`vacation_date_start` AS `vacation_date_start`, `vacation_request`.`vacation_date_end` AS `vacation_date_end`, `vacation_request`.`vacation_reason` AS `vacation_reason`, `vacation_request`.`vacation_status` AS `vacation_status`, `user`.`user_nickname` AS `user_nickname` FROM (`vacation_request` join `user` on(`user`.`user_id` = `vacation_request`.`vacation_approval`)) ;

-- --------------------------------------------------------

--
-- Структура для представлення `user_info`
--
DROP TABLE IF EXISTS `user_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_info`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`user_nickname` AS `user_nickname`, `r`.`role_name` AS `user_role`, `u`.`user_first_name` AS `user_first_name`, `u`.`user_last_name` AS `user_last_name`, `u`.`user_created` AS `user_created`, `u`.`user_email` AS `user_email` FROM (`user` `u` join `role` `r` on(`u`.`user_role` = `r`.`role_id`)) ;

-- --------------------------------------------------------

--
-- Структура для представлення `vacationtoapproval`
--
DROP TABLE IF EXISTS `vacationtoapproval`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vacationtoapproval`  AS SELECT `vacation_request`.`vacation_id` AS `vacation_id`, `user`.`user_nickname` AS `user_nickname`, `vacation_request`.`vacation_type` AS `vacation_type`, `vacation_request`.`vacation_date_type` AS `vacation_date_type`, `vacation_request`.`vacation_date_start` AS `vacation_date_start`, `vacation_request`.`vacation_date_end` AS `vacation_date_end`, `vacation_request`.`vacation_reason` AS `vacation_reason`, `vacation_request`.`vacation_status` AS `vacation_status` FROM (`vacation_request` join `user` on(`user`.`user_id` = `vacation_request`.`vacation_user_id`)) WHERE `vacation_request`.`vacation_status` = 'pending' ;

-- --------------------------------------------------------

--
-- Структура для представлення `vacation_info`
--
DROP TABLE IF EXISTS `vacation_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vacation_info`  AS SELECT `vr`.`vacation_id` AS `vacation_id`, `u`.`user_nickname` AS `user`, `vr`.`vacation_type` AS `vacation_type`, `vr`.`vacation_date_type` AS `vacation_date_type`, `vr`.`vacation_date_start` AS `vacation_date_start`, `vr`.`vacation_date_end` AS `vacation_date_end`, `vr`.`vacation_reason` AS `vacation_reason`, `vr`.`vacation_approval` AS `vacation_approval` FROM (`vacation_request` `vr` join `user` `u` on(`vr`.`vacation_user_id` = `u`.`user_id`)) ;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`certificate_id`),
  ADD KEY `fk_certificate_user_id` (`certificate_user_id`);

--
-- Індекси таблиці `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`operation_id`),
  ADD KEY `operation_user_id` (`operation_user_id`);

--
-- Індекси таблиці `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_nickname` (`user_nickname`),
  ADD KEY `fk_user_role` (`user_role`);

--
-- Індекси таблиці `vacation_request`
--
ALTER TABLE `vacation_request`
  ADD PRIMARY KEY (`vacation_id`),
  ADD KEY `fk_vacation_user_id` (`vacation_user_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `certificate`
--
ALTER TABLE `certificate`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблиці `operation`
--
ALTER TABLE `operation`
  MODIFY `operation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблиці `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `vacation_request`
--
ALTER TABLE `vacation_request`
  MODIFY `vacation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `fk_certificate_user_id` FOREIGN KEY (`certificate_user_id`) REFERENCES `user` (`user_id`);

--
-- Обмеження зовнішнього ключа таблиці `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `operation_ibfk_1` FOREIGN KEY (`operation_user_id`) REFERENCES `user` (`user_id`);

--
-- Обмеження зовнішнього ключа таблиці `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`user_role`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `vacation_request`
--
ALTER TABLE `vacation_request`
  ADD CONSTRAINT `fk_vacation_user_id` FOREIGN KEY (`vacation_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
