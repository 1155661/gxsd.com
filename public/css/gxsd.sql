-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-11-26 11:08:03
-- 服务器版本： 5.7.21
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gxsd`
--
CREATE DATABASE IF NOT EXISTS `gxsd` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
USE `gxsd`;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `jobtitle` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `isAdmin` int(11) NOT NULL,
  `lasttime` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`, `email`, `jobtitle`, `isAdmin`, `lasttime`, `count`) VALUES
(1, '低洼地', 'eyJpdiI6IkhtYWkrWjJoWU52RDdXSlQ0RmRaVmc9PSIsInZhbHVlIjoiWk1KVVwvOWtXN3V0SkFOb29pOU01cWc9PSIsIm1hYyI6Ijg4OTMyNmMyM2NlNmU1ZDBiZjAzMjY4MmMwMjdjMWI5ZjVhZWZjN2NjZmFlMjI5MWJkNDM1NDVkMTIwMzkzOTYifQ==', '15151515@qq.com', NULL, 0, '1543063569', 34),
(8, '史忠杰', 'eyJpdiI6ImY2QStLT1o0OGIyUW5Kd1RxTVFDbVE9PSIsInZhbHVlIjoiNzB1UEdJY0dvVHFQSUoxY3JTSURmQT09IiwibWFjIjoiYzMyOTdhOGY5YzhkOGVmN2E2YmUwNDNiMDM4Y2Q1YTgyMzQwYjI0ODNlYjE1M2IwNDZkMTRhODE5YzhiYjM1ZCJ9', '1515152152@qq.com', NULL, 1, '1543042771', 2),
(3, '邓丽萍2222', 'eyJpdiI6IlBwUllCdHJUSkpJSWdjWVJ4N3ZIcFE9PSIsInZhbHVlIjoiN2pUQjc3NEtnVlBVRUZYTHRBaDB4dz09IiwibWFjIjoiMTFkYjdmMWY3YWE2YjA0MDc4ZTg0Y2JlZjJjOWNkNWIxMDBlYjM3MGMzYzYwYWMwOTQ3NjM4YzQ2YmQxM2U3NyJ9', '1977600554@qq.com', NULL, 0, '', 0),
(9, '莫祖能', 'eyJpdiI6IloweFpBWm9tQ2tuMnlMNU9IVm9rb1E9PSIsInZhbHVlIjoiekUzYktXbHpmcjB2MmJnejJWVlhzQT09IiwibWFjIjoiOGQ3OGNhM2ZkZGU1ZTZhZjdhMWU3YzNjOGEyYjUzZTc0YjI1MjJlMjI0MDBlNjgwZDZkYzQwNDEwNmYwMWQzMCJ9', '1468033693@qq.com', NULL, 1, '1543226787', 19),
(5, '龙祖连', 'eyJpdiI6ImdEZEw3MGZNR2tKYVVmZ3pGN1wvZ0xRPT0iLCJ2YWx1ZSI6IlprRnhMVE9TWkFYZENnQkMzMnpldXc9PSIsIm1hYyI6Ijc5NmQ4NDdkZmNhM2NlMTYzMWU4OTc1MzcxZTNhYjVlNmZkZTBkMmVmMGM1ZDNhYmYwYTA3ODc4N2M3MWNlMTYifQ==', '1522151515@qq.com', NULL, 0, '1543215982', 1),
(7, '刘荣才', 'eyJpdiI6IkNXUWRcL3dSQWkwOXpFSkZHa0pZM1NnPT0iLCJ2YWx1ZSI6ImdDWDcxQ2txTUhVZnBKVHdEXC9QRDZ3PT0iLCJtYWMiOiJjOTJkOTJkNGJlMWMzYWYwOTk5YjQ3MDY5NGU0MWViY2FjMzE4YzRlOGQwYmUwODAwMGU0NmUwMmRkNzdkNjMyIn0=', '151515152@qq.com', NULL, 1, '', 0),
(11, '黎明明', 'eyJpdiI6IklCVU40TExMZ0l1T3VNUkh5bUZ4NFE9PSIsInZhbHVlIjoiR2ZVUkY3VUNEVkZRVkFXa3dzQVVNZz09IiwibWFjIjoiZDBkOTk5YThhOGFmZGIyYjg5MDNjZjc2N2NhMjNjMGQ5NzQxZjM2OWVkMTliMzZhYmNkMDNlYTMzNTE3NjllNiJ9', '14680332226293@qq.com', NULL, 0, '', 0),
(10, '董英', 'eyJpdiI6IkhaVHJTZ1p1M0xoQ0Zzcjh4d2l0YkE9PSIsInZhbHVlIjoiVlJvZFNKVzZYWlhSUm9XcjFReHNUQT09IiwibWFjIjoiMjJjYTlkNzk5NTdlMzYxN2U4ZmYxNjhiYTE1ZmQ2ZTUyODExNmFlZDExZmYyZjQ5ZDVkZmMwYzBjYmRkY2E3MiJ9', '14680336293@qq.com', NULL, 0, NULL, 0),
(12, '蔡永强', 'eyJpdiI6IkdGRnl0ZDBZcDhwWlFQVTdNZnQxQVE9PSIsInZhbHVlIjoia3FNWGNvT2FtaFZ0OGU3bGFcL3hUNEE9PSIsIm1hYyI6IjlmY2M1ZmY2MzJlNTAzZDdjNzg5NjQ5ZjFlZWY4NDQ3ZDcwOTljNDJlMmRlOWFkOTc2NzM5ZDBmYzEyZGEzNzQifQ==', '6293@qq.com', NULL, 0, '1543042740', 1),
(13, '农朝勇', 'eyJpdiI6IjIxRlpma0x6YVpxUmpucUZGK1JQaEE9PSIsInZhbHVlIjoiTTlxQTVzVk9zUGU0M0lKK3VmY2RWUT09IiwibWFjIjoiOWU0ZWE0ZmUxMzU2NzRjNzYwNTVkMmE0MDcwZTgzYWM0OTViZTg0Y2FlMWIxZGY5NzVmMjYzM2UwYmRjMzkwMCJ9', '2326293@qq.com', NULL, 1, '', 0),
(14, '苗志峰', 'eyJpdiI6Ino1OWNnQWMxR0t3Y2lOeUJyQ0pLZUE9PSIsInZhbHVlIjoib0syV1wvakVuUWlcL0ZqYnlYN0x0bjZRPT0iLCJtYWMiOiJlYWIxY2FlMzAwYWY0Y2Y2NmZmZDkzMzUwMTZkMGU3MjIyYmQwNWNjMTEyY2Y1YjFmZmU4MzAyZTM5YjkxY2Q0In0=', '232622293@qq.com', NULL, 1, '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `className` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `classNumber` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `class`
--

INSERT INTO `class` (`id`, `className`, `classNumber`) VALUES
(1, '计算机应用3班222', 20),
(2, '计算机应用3班', 500),
(3, '计算机应用339', 36),
(4, 'jsj', 43);

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `aid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`id`, `name`, `aid`) VALUES
(1, '请输入课程名称dwdwawa', 0),
(2, '请输入课程名称344', 0),
(27, '123', 0),
(4, '请输入课程名称dwadawd', 0),
(26, 'PHP22299', 0),
(8, '请输入课程名称1113434343', 0),
(10, '请输入课程名称22', 0),
(25, 'PHP2', 0),
(17, '计算机应用123', 0);

-- --------------------------------------------------------

--
-- 表的结构 `coursetask`
--

DROP TABLE IF EXISTS `coursetask`;
CREATE TABLE IF NOT EXISTS `coursetask` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `time` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `wid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `clid` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `coursetask`
--

INSERT INTO `coursetask` (`id`, `time`, `wid`, `tid`, `cid`, `clid`, `content`) VALUES
(1, '2018-2019', 1, 14, 26, 3, NULL),
(3, '2014-2015', 3, 11, 4, 1, '1'),
(4, '2017-2019', 15, 13, 26, 2, 'aaaaaaa'),
(5, '2018-2019', 1, 14, 26, 3, NULL),
(6, '2015-2016', 4, 8, 10, 1, '达瓦达瓦'),
(8, '2018-2019', 1, 14, 27, 4, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `laboratory`
--

DROP TABLE IF EXISTS `laboratory`;
CREATE TABLE IF NOT EXISTS `laboratory` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `lbname` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `types` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `aid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `isCampus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `laboratory`
--

INSERT INTO `laboratory` (`id`, `number`, `lbname`, `types`, `aid`, `status`, `isCampus`) VALUES
(2, '啊啊啊', '计算机技术实训楼2', 'dwadwaadwadwa', 0, 0, 1),
(21, '啊啊啊', 'dwadwa', 'dwadwaadwadwa', 0, 0, 0),
(4, 'dwadwakiki', '（长堽）401', '啊订单', 0, 0, 0),
(6, 'dwadwa', '达瓦', 'dwadwa444', 0, 0, 0),
(26, '低洼地123231', '计算机技术实训楼6', '计算机5', 0, 0, 1),
(9, '啊啊啊达瓦达瓦', '达瓦wwew', '啊订单', 0, 0, 1),
(16, '啊啊啊达瓦达瓦', '达瓦232321111', 'dwadwa444', 0, 0, 0),
(12, 'dwadwakiki', '达瓦23232', 'dwadwa123', 0, 0, 1),
(25, 'dwadwa', '计算机', '计算机567', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `labtypes`
--

DROP TABLE IF EXISTS `labtypes`;
CREATE TABLE IF NOT EXISTS `labtypes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `types` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `labtypes`
--

INSERT INTO `labtypes` (`id`, `name`, `types`) VALUES
(103, '啊订单', 1),
(104, '低洼地123231', 0),
(105, 'dwadwa123', 1),
(118, '计算机56', 0),
(119, '计算机567', 1),
(115, '计算机5', 1),
(85, 'dwadwakiki', 0),
(84, '低洼地12323131', 0),
(81, 'aaaa', 1),
(110, 'dwadwa444', 1),
(101, '低洼地', 0),
(78, 'dwadwaaaaa', 0),
(77, 'dwadwa', 0),
(107, 'dwadwaadwadwa', 1),
(74, '啊啊啊达瓦达瓦', 0),
(108, '低洼地23232', 1);

-- --------------------------------------------------------

--
-- 表的结构 `practice`
--

DROP TABLE IF EXISTS `practice`;
CREATE TABLE IF NOT EXISTS `practice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `wid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `clid` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `practice`
--

INSERT INTO `practice` (`id`, `time`, `wid`, `tid`, `cid`, `clid`, `content`) VALUES
(15, '2015-2016', 18, 13, 24, 2, '1232313122222'),
(18, '2014-2015', 14, 11, 10, 2, NULL),
(19, '2015-2016', 4, 14, 26, 3, '11111'),
(13, '2014-2015', 6, 8, 8, 2, 'e\'q\'e\'q'),
(17, '2018-2019', 1, 8, 17, 2, '1232313122222222');

-- --------------------------------------------------------

--
-- 表的结构 `termtime`
--

DROP TABLE IF EXISTS `termtime`;
CREATE TABLE IF NOT EXISTS `termtime` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `start` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `end` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `termtime`
--

INSERT INTO `termtime` (`id`, `start`, `end`) VALUES
(16, '1536710400', '1547251200'),
(15, '1473638400', '1483833600'),
(14, '1442016000', '1452211200'),
(13, '1410480000', '1421107200'),
(12, '1499299200', '1547251200'),
(17, '1536278400', '1547251200');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
