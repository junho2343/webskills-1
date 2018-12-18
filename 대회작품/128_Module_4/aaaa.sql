-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 18-10-29 10:20
-- 서버 버전: 10.1.32-MariaDB
-- PHP 버전: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `aaaa`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `contract`
--

CREATE TABLE `contract` (
  `c_idx` int(11) NOT NULL,
  `c_member` int(11) NOT NULL,
  `c_phone` text NOT NULL,
  `c_weight` int(11) NOT NULL,
  `c_area` text NOT NULL,
  `c_date` date NOT NULL,
  `c_rdate` date NOT NULL,
  `c_code` text NOT NULL,
  `c_state` varchar(200) NOT NULL DEFAULT '접수대기'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `contract`
--

INSERT INTO `contract` (`c_idx`, `c_member`, `c_phone`, `c_weight`, `c_area`, `c_date`, `c_rdate`, `c_code`, `c_state`) VALUES
(1, 1, '000-0000-0001', 1, '경기', '2018-10-28', '2018-10-09', '20181009-0001', '배송완료'),
(2, 1, '000-0000-0001', 4, '충북', '2018-10-28', '2018-10-09', '20181009-0002', '배송완료'),
(3, 1, '000-0000-0001', 1, '전북', '2018-10-28', '2018-10-09', '20181009-0003', '배송완료'),
(4, 1, '000-0000-03', 1, '경남', '2018-10-28', '2018-10-09', '20181009-0004', '배송완료'),
(5, 1, '000-0000-0001', 1, '충북', '2018-10-28', '2018-10-09', '20181009-0005', '배송완료'),
(6, 1, '000-0000-0001', 4, '전남', '2018-10-28', '2018-10-09', '20181009-0006', '배송완료'),
(7, 1, '000-0000-0001', 1, '경북', '2018-10-28', '2018-10-09', '20181009-0007', '배송완료'),
(8, 1, '000-0000-0001', 4, '강원', '2018-10-29', '2018-10-28', '20181028-0008', '배송대기'),
(9, 2, '000-0000-0002', 8, '경남', '2018-10-29', '2018-10-28', '20181028-0009', '배송대기'),
(10, 3, '000-0000-0003', 1, '충북', '2018-10-29', '2018-10-28', '20181028-0010', '배송완료'),
(11, 3, '000-0000-0003', 8, '대전', '2018-10-29', '2018-10-28', '20181028-0011', '배송완료'),
(12, 2, '000-0000-0002', 1, '충남', '2018-10-29', '2018-10-28', '20181028-0012', '배송완료');

-- --------------------------------------------------------

--
-- 테이블 구조 `insu`
--

CREATE TABLE `insu` (
  `i_idx` int(11) NOT NULL,
  `i_car` int(11) NOT NULL,
  `i_contract` int(11) NOT NULL,
  `i_path` text NOT NULL,
  `i_min` int(11) NOT NULL,
  `i_max` int(11) NOT NULL,
  `i_me` int(11) NOT NULL,
  `i_suc` int(11) NOT NULL,
  `i_state` varchar(200) NOT NULL DEFAULT '배송대기',
  `i_box` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `insu`
--

INSERT INTO `insu` (`i_idx`, `i_car`, `i_contract`, `i_path`, `i_min`, `i_max`, `i_me`, `i_suc`, `i_state`, `i_box`) VALUES
(1, 6, 6, '전남-충북', 120, 8, 0, 1, '배송완료', '2018-10-09 16:04:54'),
(2, 6, 2, '전남-충북', 120, 8, 1, 1, '배송완료', '2018-10-09 16:04:54'),
(3, 6, 3, '전북-경남-경북-충북-경기', 360, 5, 0, 1, '배송완료', '2018-10-09 16:11:36'),
(4, 6, 4, '전북-경남-경북-충북-경기', 360, 5, 1, 1, '배송완료', '2018-10-09 16:11:36'),
(5, 6, 7, '전북-경남-경북-충북-경기', 360, 5, 2, 1, '배송완료', '2018-10-09 16:11:36'),
(6, 6, 5, '전북-경남-경북-충북-경기', 360, 5, 3, 1, '배송완료', '2018-10-09 16:11:36'),
(7, 6, 1, '전북-경남-경북-충북-경기', 360, 5, 4, 1, '배송완료', '2018-10-09 16:11:36'),
(8, 8, 8, '강원', 0, 4, 0, 0, '배송대기', '2018-10-28 17:23:24'),
(9, 7, 9, '경남', 0, 8, 0, 0, '배송대기', '2018-10-28 17:25:16'),
(10, 7, 11, '대전-충북-충남', 100, 10, 0, 1, '배송완료', '2018-10-28 17:28:33'),
(11, 7, 10, '대전-충북-충남', 100, 10, 1, 1, '배송완료', '2018-10-28 17:28:33'),
(12, 7, 12, '대전-충북-충남', 100, 10, 2, 1, '배송완료', '2018-10-28 17:28:33');

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE `member` (
  `m_idx` int(11) NOT NULL,
  `m_id` text NOT NULL,
  `m_pw` text NOT NULL,
  `m_name` text NOT NULL,
  `m_phone` text NOT NULL,
  `m_weight` int(11) NOT NULL,
  `m_grade` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `member`
--

INSERT INTO `member` (`m_idx`, `m_id`, `m_pw`, `m_name`, `m_phone`, `m_weight`, `m_grade`) VALUES
(1, 'user1', '1234', '고객사1', '000-0000-0001', 0, '고객사'),
(2, 'user2', '1234', '고객사2', '000-0000-0002', 0, '고객사'),
(3, 'user3', '1234', '고객사3', '000-0000-0003', 0, '고객사'),
(4, 'zip1', '1234', '지입차량주1', '001-0000-0001', 1, '지입차량주'),
(5, 'zip2', '1234', '지입차량주2', '001-0000-0002', 4, '지입차량주'),
(6, 'zip3', '1234', '지입차량주3', '001-0000-0003', 8, '지입차량주'),
(7, 'zip4', '1234', '지입차량주4', '001-0000-0004', 15, '지입차량주'),
(8, 'zip5', '1234', '지입차량주5', '001-0000-0005', 24, '지입차량주'),
(9, 'admin', '1234', '', '', 0, '관리자');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`c_idx`);

--
-- 테이블의 인덱스 `insu`
--
ALTER TABLE `insu`
  ADD PRIMARY KEY (`i_idx`);

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`m_idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `contract`
--
ALTER TABLE `contract`
  MODIFY `c_idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 테이블의 AUTO_INCREMENT `insu`
--
ALTER TABLE `insu`
  MODIFY `i_idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `m_idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
