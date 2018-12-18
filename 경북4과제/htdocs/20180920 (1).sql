-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 18-10-03 06:01
-- 서버 버전: 10.1.35-MariaDB
-- PHP 버전: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `20180920`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `contract`
--

CREATE TABLE `contract` (
  `c_idx` int(11) NOT NULL,
  `c_member` int(11) NOT NULL,
  `c_weight` int(11) NOT NULL,
  `c_area` text NOT NULL,
  `c_date` date NOT NULL,
  `c_rdate` date NOT NULL,
  `c_state` varchar(200) NOT NULL DEFAULT '접수대기',
  `c_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `delivery`
--

CREATE TABLE `delivery` (
  `d_idx` int(11) NOT NULL,
  `d_contract` int(11) NOT NULL,
  `d_car` int(11) NOT NULL,
  `d_path` text NOT NULL,
  `d_me` int(11) NOT NULL,
  `d_state` varchar(200) NOT NULL DEFAULT '배송대기',
  `d_max` int(11) NOT NULL,
  `d_dis` int(11) NOT NULL,
  `d_suc` int(11) NOT NULL,
  `d_box` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`c_idx`);

--
-- 테이블의 인덱스 `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`d_idx`);

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
  MODIFY `c_idx` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `delivery`
--
ALTER TABLE `delivery`
  MODIFY `d_idx` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `m_idx` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
