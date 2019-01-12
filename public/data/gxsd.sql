-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2019-01-06 09:57:49
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
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '姓名',
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '密码',
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '邮箱',
  `classes` int(11) DEFAULT NULL COMMENT '上课次数',
  `isAdmin` int(11) NOT NULL COMMENT '是否管理员',
  `lasttime` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL COMMENT '最后登陆时间',
  `count` int(11) NOT NULL COMMENT '登录次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`, `email`, `classes`, `isAdmin`, `lasttime`, `count`) VALUES
(1, '教师1', 'eyJpdiI6IjV6ZVNHOXhFcnZOUUMyRzF0VnE2Unc9PSIsInZhbHVlIjoiQUtNbjJxZEFmN0lLbWxnaFRXekJDUT09IiwibWFjIjoiMzQxNTNkMDM0YWU4YzZhNzhkMzViMTdhODU5NTlmOWUxODlkMGU3NTU5MzM5NWMzZTRhZmQyOWQ4MWVjNDQwOSJ9', '1468033693@qq.com', 0, 1, '1546762899', 2),
(2, '教师2', 'eyJpdiI6InBDaksrc0lsdVVMU00zYTdtQUN6RVE9PSIsInZhbHVlIjoiOVkrNERzVnhjY3EzR0NDMHJIMzlJdz09IiwibWFjIjoiYTFjZTg4MTNiNTkxZDZkMGNmMDQ4Mzc1ZTJkMDYwMTU1YzFiNDQwMWUzOTA1YWRmYWE3NTMwNWQ0ZTVmMzIzMyJ9', '1468033694@qq.com', 0, 0, NULL, 0),
(3, '教师3', 'eyJpdiI6IkhUdVwvR1BIQVVYazF2a0xqSVwvNFByZz09IiwidmFsdWUiOiI1MmgzTTJUTzNHV1pMb0hhTFhTM1BRPT0iLCJtYWMiOiI0MTZiNDJjMTE4YWM0MDc1MDk4YzdhMGEyZjc4Njg2Y2IzOThlMGFiYWRmZWFmNDE5MGI5MzNlNjA4ZTIwMmEwIn0=', '1468033695@qq.com', 0, 0, NULL, 0),
(4, '教师4', 'eyJpdiI6Ilo5TnVldU10MG5LYVNqZHNoUjlcL0tBPT0iLCJ2YWx1ZSI6IjgyOStmM0xKNlF2QnhXSURrZlRRSkE9PSIsIm1hYyI6IjcxMmY0MDg1OTI5MTg4NGExMjgxNzcyNmVjYTgzZjhiZDg1NzU3MmJmYjc3YTg1YWYzNzRlMDIwZTA2NGZlYjgifQ==', '1468033696@qq.com', 0, 0, NULL, 0),
(5, '教师5', 'eyJpdiI6IlJXSFVFdkhuTTZwUDd0NUlvc2JRSUE9PSIsInZhbHVlIjoiTDNSK1pVK3QyWkZwbFA4WmNaTVwvNEE9PSIsIm1hYyI6IjI0NzkwYjMwMWM4OTYxZmRhZmI3M2U4ZjE1NTlhOGM0Y2M1ZmFhZTMyYTRlN2M3MDYwN2I3YWQ0NTUwZGIwY2UifQ==', '1468033697@qq.com', 0, 0, NULL, 0),
(6, '教师6', 'eyJpdiI6ImtBZWNORFwvbVRLQkFrUThlTDVUVzh3PT0iLCJ2YWx1ZSI6IlV3Mnl2ZWIyZUV0eVYwalhkdzJ4M1E9PSIsIm1hYyI6Ijc2NzRkMTIwN2IyZjU1NzFlYzY1MTZjNTIzN2Q2ODUzNzAyNDFhNWFlYjQyYWRjYmQ4YmFmYWRiY2Y0ZTE0MDkifQ==', '1468033698@qq.com', 0, 0, NULL, 0),
(7, '教师7', 'eyJpdiI6ImtDcEVXa0dxV0czWm9sK0hJSUlEYkE9PSIsInZhbHVlIjoiazZVZmUzOElZeHlZV0x3eVdCdnN3Zz09IiwibWFjIjoiNDgyNWQ4YWQ1MjhhNThhZTEyNjkyYjYzNWM3NWI4OWQwNjhjMmRmZTM1YjA0ZTVmZWFkNGVmZTQ5Y2MzOTNhYSJ9', '1468033699@qq.com', 0, 0, NULL, 0),
(8, '教师8', 'eyJpdiI6IjRGeFJOeklOemJEc2trNlhJQUJPTXc9PSIsInZhbHVlIjoibnpZbzB6SUJ6QUlHcTU2K25KUStydz09IiwibWFjIjoiZDY0M2Y2Njc2NjVmNzBlMTBmZDNmNDY5OWU3YTU2ODg2OTY2YTQ2MmE1NjQ2OTkxZjZjNzkxOTQ3NDRmYmNjNCJ9', '1468033700@qq.com', 0, 0, NULL, 0),
(9, '教师9', 'eyJpdiI6IjJuMUxwUm9zajRGSVV5a1hsM3FkUHc9PSIsInZhbHVlIjoienQyNFVYWVRxUGlrODJGQzVhWnl4Zz09IiwibWFjIjoiMDJhZTU1YjM2ZjM5ZDNkYWM3NDVkOTk0NWQ0MmQzMWMxOTQ5NWU4MjZjYzcxZDdkY2I2MmZlYTljOTA3NTE0MSJ9', '1468033701@qq.com', 0, 0, NULL, 0),
(10, '教师10', 'eyJpdiI6IlwvdUJVZkxQUEVBdnBkV3pxQWFlUjVnPT0iLCJ2YWx1ZSI6IkozSEs4WlNHNzJ3SE10TzJtcGplVGc9PSIsIm1hYyI6IjAzNWIzMTBlNTQ0MGRhOWRlZDY0OTk4YWZiN2ZiNTA1YzYwYmRmMmE1OTkzODY2NWJiZGU4N2M0YWQ1ZmM0ZjkifQ==', '1468033702@qq.com', 0, 0, NULL, 0),
(11, '教师11', 'eyJpdiI6IlFoOTExRkFsRXRLNUlBSVJRQUFuaEE9PSIsInZhbHVlIjoiazBPaUhyNHNITHlWTmFHaDJhdXMrUT09IiwibWFjIjoiZTY1MzVkNTAxODY1Mzk0MzJmNTk2NmI3ODE2YjE4YjMyMDJlZTIzN2RkZTVhNzAyMzliNDhkZDMxMWRiNzllNCJ9', '1468033703@qq.com', 0, 0, NULL, 0),
(12, '教师12', 'eyJpdiI6IklxdzRKbkt0OGJDaGFqOW5ia0hyYUE9PSIsInZhbHVlIjoiZnVpek9MVmwybUNjMzlNV1kxc1psZz09IiwibWFjIjoiMTdkNTM0NWU2Y2VkMjcwOWJlYTc1OTBjMDk2YTllZjExNmUwODBkNGNmYWE0OWMwMDAzMThjNTg3M2JhYzJhNSJ9', '1468033704@qq.com', 0, 0, NULL, 0),
(13, '教师13', 'eyJpdiI6IldNR2lXQW9XTEVkSXk1R0tnM3lGQmc9PSIsInZhbHVlIjoiUFlvZzE1MTlMMnlQaFwvVzNhRit4blE9PSIsIm1hYyI6IjA4ODc5ZTY4MjFlN2Y2OTQ5NGFjN2I3NGExODU1NThmMDRiNDJlZWQxN2M4OGJmZWRlODkwY2FkNjQzZDVmMzIifQ==', '1468033705@qq.com', 0, 0, NULL, 0),
(14, '教师14', 'eyJpdiI6InFuR1lINGFcL1NGU2tpRUJFcFwvS1Vxdz09IiwidmFsdWUiOiJXbGJza0VYWGpNbkNzT09ubmtONnBnPT0iLCJtYWMiOiIxNTZkZjEzNjJkZGU0ODc0ODRjMTNhZTE3NjZiZmIxMzg5NmJkMWE2N2QyNjdkY2NkZjcxZWUzMjc2NWI0ZjM2In0=', '1468033706@qq.com', 0, 0, NULL, 0),
(15, '教师15', 'eyJpdiI6InFaZmZnSTNJdFhlZiszWkxOTjcwUEE9PSIsInZhbHVlIjoiSVVCZWxKRTlJbEFMbXRwRUxFQkVjQT09IiwibWFjIjoiODVhMzMzNTQxY2FmNmUzYjcwYTJlMjYyZTcxMWZkMTA1Y2VjOTIxOTgwZGEzYzhhNzcwYzI0NzE4ZmIzNjQ4NiJ9', '1468033707@qq.com', 0, 0, NULL, 0),
(16, '教师16', 'eyJpdiI6IkNORGVYcXBQU0l2dGl2cTFQZmRRU2c9PSIsInZhbHVlIjoiMjF1YTdRdXRhVklxb095Y0taTG92QT09IiwibWFjIjoiOGVjYWI5YzAyYTI3MGNhNzUzNWM3Njc3YTBjY2Q0YjY4NWY4YWI5ZjBkY2YyNTBhNmQ5M2IzNjA3M2JjZGMxZSJ9', '1468033708@qq.com', 0, 0, NULL, 0),
(17, '教师17', 'eyJpdiI6IkFDWXJRQTFFTFpiU0Q1K3ZmM1hCeXc9PSIsInZhbHVlIjoiQUdFYXBEWXBvTFhKdlV2Z1Q5UVdYZz09IiwibWFjIjoiZWY4YWUwNDM4YjljYWUxNzcxZTY5NjQwNTgwOGM1NzExYWZjMjE5ZDYzMGUyZTA4OGM5YzM1NWJmNTQwZTM0MiJ9', '1468033709@qq.com', 0, 0, NULL, 0),
(18, '教师18', 'eyJpdiI6IlNyRElZMlZsMGcrajlVaVlsZTc0TkE9PSIsInZhbHVlIjoiYk9odGZmYm5pMGN3dVE5ZVRINDdjQT09IiwibWFjIjoiMjA3YTkxZTcwNTJhNTA1MGNlZmI4YWQ3MWNiYWFiMjhjY2JjZWI4M2I5N2VmNThmOTFiODc0OTA3ZTcxMzA4ZCJ9', '1468033710@qq.com', 0, 0, NULL, 0),
(19, '教师19', 'eyJpdiI6InBcL001V2c1QUJGYTNxTGd5ZnNZblNBPT0iLCJ2YWx1ZSI6IkNVK3JaMXM4bXBTR3BWek1KbWpwWHc9PSIsIm1hYyI6IjRlNjk5NGVlNjBjZGZjNWJlNjc0NjQxZjNjZTJiOTI4NzIzODc3M2MxYWM0NzRjMGI2MGM0MTYzNWM3MTk0MTUifQ==', '1468033711@qq.com', 0, 0, NULL, 0),
(20, '教师20', 'eyJpdiI6IlQ4eTY2VDRjVGJSUUpMRXQ4STF5VlE9PSIsInZhbHVlIjoiTjdMS3NBalhSY1Y3XC9vbVJwNFBlVGc9PSIsIm1hYyI6IjJjZjIxMmFkMjNkYWRiNmI4ZTVjNzEwOTE4NDY5NzlmMzRkMzNjMGYwYzZiYTAzMmE2MjhjYjk5OTYzNGI1ZGUifQ==', '1468033712@qq.com', 0, 0, NULL, 0),
(21, '教师21', 'eyJpdiI6ImJ2Q05hVmdGNFpcL2tkYUpWZHdweGlBPT0iLCJ2YWx1ZSI6InFZVDY2cGtrRjkyNlNJK0xJc295XC9BPT0iLCJtYWMiOiJlMDBhMTQzMzNjM2FhODk1ZGY0YzMyNDE3ZTI4Njc5NDJkMDRjNGY4MWY0NjQ0MjUxMmFkY2M5YjAxYmQ3Yjg2In0=', '1468033713@qq.com', 0, 0, NULL, 0),
(22, '教师22', 'eyJpdiI6IlFPd0lickhycjlzTEpPZmdDdXQzeHc9PSIsInZhbHVlIjoiS0h0aWk5NFlJZ2ZEZG0yd01oaXdzUT09IiwibWFjIjoiMjg0Y2MxY2IyNjBjODQ0OGE5OGRmZDZmZDBjMTRlN2YyNzVhMTY0NjlhZWU5YmEzNjBlYjZiZTExZWE5ZTA2OCJ9', '1468033714@qq.com', 0, 0, NULL, 0),
(23, '教师23', 'eyJpdiI6IjlkcG1kVUpWeUZlaTBVK21GT0pPZnc9PSIsInZhbHVlIjoieEZJYldiZG12YUs3blg3NXU0b2lxUT09IiwibWFjIjoiMGQ0MmJkY2IzZWNiYjEyYWZjNWQ1MDliY2FjNTg1OWM0MDAxNmU2ZmUzMzlmNjk5MTgwNmYwNTQyMTNjYjk0ZiJ9', '1468033715@qq.com', 0, 0, NULL, 0),
(24, '教师24', 'eyJpdiI6IlE4OTlDdTE3R3BWUkhwMTk2UVIyYmc9PSIsInZhbHVlIjoiVkpQMGFiSWpCV2RxYVhjdXFibGdcL1E9PSIsIm1hYyI6IjFjNWQ3NzU3MDE4MWE5NTU5OWRhM2M3MTRkZWJmZTQzMTE5MzYxNWM3YzI1ZDQzYjg3YmYwN2QwYzYwNDc0ZjUifQ==', '1468033716@qq.com', 0, 0, NULL, 0),
(25, '教师25', 'eyJpdiI6IlRxOVU2NTJvc1wvXC8xUEtPelVsbGNFUT09IiwidmFsdWUiOiJqbDNXT3JZRm9YZlNZdWZkXC80d05BQT09IiwibWFjIjoiYzVkNTZmNDAwY2E1ZTI0NmJlNmI2MGM4MzYyMmUwN2RhM2NlMDFiOGQzNzJiM2UyYWI0NDkwOTlhZTkzZGZjNCJ9', '1468033717@qq.com', 0, 0, NULL, 0),
(26, '教师26', 'eyJpdiI6ImRYK044cmlIRVdxeUx5eFFpSG1yMEE9PSIsInZhbHVlIjoiT1pUUHRMNG0rZnFiQkJMSnY4a1Jkdz09IiwibWFjIjoiMWE1MzE1ZDE5OGZkYjk4ODRhNmMyNDNiYTY2MWEzOWE5OWJlN2JkYzFmM2IyZmRkMjlmZDZhMTIxYjE1ZjhmOSJ9', '1468033718@qq.com', 0, 0, NULL, 0),
(27, '教师27', 'eyJpdiI6IlJUUWpDdjFRRTRtSlRJVDVjYlVkaUE9PSIsInZhbHVlIjoicW9xd2dcL3dHSnRVbGVlTVlZT2pDQlE9PSIsIm1hYyI6IjZjMmU5YzZjMGI3ODhiYmRmOWEzY2JjN2E4YWNhMTNhNTU3YTg5M2M3NmRiOWRkZGE3ZWY3ZDhiZmNiMjNiZTkifQ==', '1468033719@qq.com', 0, 0, NULL, 0),
(28, '教师28', 'eyJpdiI6IklWNW4yM1p2ZU0wN3BWRHFUeGk4V1E9PSIsInZhbHVlIjoiRVR6NkVxdENUb1h5NmxWTms0KzljUT09IiwibWFjIjoiNTBjZmRlOWI4MGMwMzcyOWZiMDI4NTlkNzlhZDFiYWZiMGY4MWM3YzAzMjAxNjkwYWY0ZmExOWRiNWU5ZTU1YiJ9', '1468033720@qq.com', 0, 0, NULL, 0),
(29, '教师29', 'eyJpdiI6IjI5Y2djenl0ejVxY2twUGlqZ2dkZGc9PSIsInZhbHVlIjoiNnFaNXR1SVZ1UExlUWMxcUQ5WERtZz09IiwibWFjIjoiZGFkMGIwM2Q5MWVhOTA2Y2VhNGQ0ZTI3OTA3M2EzNGQxOWZjYTg1YjM1ZjM1ODViYTUxNTU3MjNjNDk3NjU1OCJ9', '1468033721@qq.com', 0, 0, NULL, 0),
(30, '教师30', 'eyJpdiI6InBCNSs5WlhhYmlIT1wvakJQakw0c0h3PT0iLCJ2YWx1ZSI6Iit5VEhYUUtRMFV6b3RCMWJJb0JMaEE9PSIsIm1hYyI6IjhkOTY0M2ExYmJiMDRhYzVhNTJmYTM2NGU2Yzg3ZGJhOTdlYzAyOTBmMzJjNGFiNzNkYmE4YjcyZTE0NDliZWMifQ==', '1468033722@qq.com', 0, 0, NULL, 0),
(31, '教师31', 'eyJpdiI6InNjanBya3RweXVIZEhRbEdVemVWeGc9PSIsInZhbHVlIjoiR3hCYmlcLzRkR0Nzd25XWENjMzJvM2c9PSIsIm1hYyI6IjAyOTQxMTM0ZmUyNjYzN2Q0ZmExNjI4MTA0ZTllMDcyNDQyYTM3NmJmMTI5MjI1ZThmOTVjY2JkZWEyZTk0ZTAifQ==', '1468033723@qq.com', 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `application`
--

DROP TABLE IF EXISTS `application`;
CREATE TABLE IF NOT EXISTS `application` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `classname` int(11) NOT NULL COMMENT '班级',
  `content` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL COMMENT '备注内容',
  `laboratory` int(11) NOT NULL COMMENT '实验室',
  `session` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '节次',
  `teachername` int(11) NOT NULL COMMENT '申请教师',
  `time` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '学期',
  `types` int(11) NOT NULL COMMENT '课程实习',
  `week1` int(11) NOT NULL COMMENT '周数',
  `week2` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '星期',
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '课程名称',
  `apptime` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '申请时间',
  `status` int(11) NOT NULL COMMENT '申请状态',
  `_token` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '令牌',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- 表的结构 `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `className` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '班级名称',
  `classNumber` int(11) NOT NULL COMMENT '班级人数',
  `count` int(11) NOT NULL COMMENT '上课次数',
  `classTime` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL COMMENT '学期',
  `search` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '用以做搜索',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '课程名称',
  `count` int(11) NOT NULL COMMENT '上课次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- 表的结构 `laboratory`
--

DROP TABLE IF EXISTS `laboratory`;
CREATE TABLE IF NOT EXISTS `laboratory` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL COMMENT '编号',
  `lbname` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '实验室名称',
  `types` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL COMMENT '类型',
  `count` int(11) NOT NULL COMMENT '实验室使用次数',
  `isCampus` int(11) NOT NULL COMMENT '校区',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- 表的结构 `labtypes`
--

DROP TABLE IF EXISTS `labtypes`;
CREATE TABLE IF NOT EXISTS `labtypes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '名称',
  `types` int(11) NOT NULL COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `labtypes`
--

INSERT INTO `labtypes` (`id`, `name`, `types`) VALUES
(1, 'xxx1', 1),
(2, 'xxx2', 1),
(3, 'xxx3', 0),
(4, 'xxx4', 0),
(5, 'xxx5', 0),
(6, 'xxx6', 0),
(7, 'xxx7', 1),
(8, 'xxx8', 1),
(9, 'xxx9', 0),
(10, 'xxx10', 0),
(11, 'xxx11', 0),
(12, 'xxx12', 0),
(13, 'xxx13', 1),
(14, 'xxx14', 0),
(15, 'xxx15', 0),
(16, 'xxx16', 0),
(17, 'xxx17', 0),
(18, 'xxx18', 0),
(19, 'xxx19', 0),
(20, 'xxx20', 1),
(21, 'xxx21', 0),
(22, 'xxx22', 1),
(23, 'xxx23', 0),
(24, 'xxx24', 0),
(25, 'xxx25', 0),
(26, 'xxx26', 0),
(27, 'xxx27', 1),
(28, 'xxx28', 0),
(29, 'xxx29', 0),
(30, 'xxx30', 0);

-- --------------------------------------------------------

--
-- 表的结构 `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '学期',
  `week1` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '周数',
  `week2` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '星期',
  `session` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '节次',
  `types` int(11) NOT NULL COMMENT '课程类型',
  `teachername` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '任课教师',
  `coursename` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '课程名称',
  `classname` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '班级名称',
  `laboratory` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '实验室',
  `_token` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL COMMENT '令牌',
  `content` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL COMMENT '备注内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- 表的结构 `termtime`
--

DROP TABLE IF EXISTS `termtime`;
CREATE TABLE IF NOT EXISTS `termtime` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `start` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '开始时间',
  `end` varchar(255) COLLATE utf8_czech_ci NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- 转存表中的数据 `termtime`
--

INSERT INTO `termtime` (`id`, `start`, `end`) VALUES
(43, '1456963200', '1468195200'),
(42, '1442016000', '1452470400'),
(44, '1504224000', '1515628800'),
(45, '1520812800', '1531353600'),
(46, '1535760000', '1547251200');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
