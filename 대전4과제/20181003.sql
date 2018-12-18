-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 18-10-31 12:56
-- 서버 버전: 10.1.29-MariaDB
-- PHP 버전: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `20181003`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE `member` (
  `m_idx` int(11) NOT NULL,
  `m_id` text NOT NULL,
  `m_name` text NOT NULL,
  `m_pw` text NOT NULL,
  `m_grade` text NOT NULL,
  `m_phone` text NOT NULL,
  `m_x` int(11) NOT NULL,
  `m_y` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `member`
--

INSERT INTO `member` (`m_idx`, `m_id`, `m_name`, `m_pw`, `m_grade`, `m_phone`, `m_x`, `m_y`) VALUES
(1, 'master', '', '1234', '관리자', '', 0, 0),
(2, 'test', '한글', 'qwer1234', '일반회원', '0000-0000-0000', 707, 345),
(3, 'qwer', '주문', 'qwer1234', '가맹회원', '0000-0000-0000', 549, 255),
(4, 'asdf', '한글', 'qwer1234', '가맹회원', '0000-0000-0000', 364, 289);

-- --------------------------------------------------------

--
-- 테이블 구조 `menu`
--

CREATE TABLE `menu` (
  `me_idx` int(11) NOT NULL,
  `me_shop` int(11) NOT NULL,
  `me_name` text NOT NULL,
  `me_price` int(11) NOT NULL,
  `me_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `menu`
--

INSERT INTO `menu` (`me_idx`, `me_shop`, `me_name`, `me_price`, `me_date`) VALUES
(3, 1, 'test3', 1000, '2018-10-03'),
(4, 1, 'test4', 2000, '2018-10-03'),
(5, 2, 'a', 1000, '2018-10-03'),
(6, 2, 'b', 2000, '2018-10-03'),
(7, 2, 'c', 3000, '2018-10-03');

-- --------------------------------------------------------

--
-- 테이블 구조 `orderbox`
--

CREATE TABLE `orderbox` (
  `ob_idx` int(11) NOT NULL,
  `ob_member` int(11) NOT NULL,
  `ob_menu` int(11) NOT NULL,
  `ob_count` int(11) NOT NULL,
  `ob_shop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `orderlist`
--

CREATE TABLE `orderlist` (
  `o_idx` int(11) NOT NULL,
  `o_member` int(11) NOT NULL,
  `o_shop` int(11) NOT NULL,
  `o_menu` int(11) NOT NULL,
  `o_count` int(11) NOT NULL,
  `o_state` varchar(200) NOT NULL DEFAULT '배송중',
  `o_date` date NOT NULL,
  `o_box` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `orderlist`
--

INSERT INTO `orderlist` (`o_idx`, `o_member`, `o_shop`, `o_menu`, `o_count`, `o_state`, `o_date`, `o_box`) VALUES
(1, 2, 1, 3, 1, '배송완료', '2018-10-03', '2018-10-03 20:44:25'),
(2, 2, 1, 3, 5, '배송완료', '2018-10-03', '2018-10-03 20:44:25'),
(3, 2, 1, 4, 1, '배송완료', '2018-10-03', '2018-10-03 20:44:25'),
(4, 2, 1, 4, 5, '배송완료', '2018-10-03', '2018-10-03 20:44:25'),
(5, 2, 2, 5, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(6, 2, 2, 5, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(7, 2, 2, 5, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(8, 2, 2, 6, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(9, 2, 2, 6, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(10, 2, 2, 6, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(11, 2, 2, 6, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(12, 2, 2, 6, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(13, 2, 2, 6, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(14, 2, 2, 7, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(15, 2, 2, 7, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(16, 2, 2, 7, 1, '배송완료', '2018-10-03', '2018-10-03 20:45:25'),
(17, 2, 1, 3, 1, '배송완료', '2018-10-01', '2018-10-01 20:51:40'),
(18, 2, 1, 4, 1, '배송완료', '2018-10-01', '2018-10-01 20:51:40'),
(19, 2, 1, 3, 1, '배송완료', '2018-10-31', '2018-10-31 20:53:55'),
(20, 2, 1, 4, 1, '배송완료', '2018-10-31', '2018-10-31 20:53:55');

-- --------------------------------------------------------

--
-- 테이블 구조 `review`
--

CREATE TABLE `review` (
  `r_idx` int(11) NOT NULL,
  `r_shop` int(11) NOT NULL,
  `r_member` int(11) NOT NULL,
  `r_box` datetime NOT NULL,
  `r_cnt` int(11) NOT NULL,
  `r_date` date NOT NULL,
  `r_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `review`
--

INSERT INTO `review` (`r_idx`, `r_shop`, `r_member`, `r_box`, `r_cnt`, `r_date`, `r_content`) VALUES
(1, 1, 2, '0000-00-00 00:00:00', 1, '2018-10-03', 'asd'),
(2, 2, 2, '0000-00-00 00:00:00', 5, '2018-10-03', 'asdas'),
(3, 1, 1, '2018-10-01 20:51:40', 1, '2018-10-31', 'ㅁㄴㅇㅁㄴㅇㅁ');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop`
--

CREATE TABLE `shop` (
  `s_idx` int(11) NOT NULL,
  `s_member` int(11) NOT NULL,
  `s_type` text NOT NULL,
  `s_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `shop`
--

INSERT INTO `shop` (`s_idx`, `s_member`, `s_type`, `s_name`) VALUES
(1, 3, 'a', '!@#$\\\'\"'),
(2, 4, 'b', 'aaaa');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`m_idx`);

--
-- 테이블의 인덱스 `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`me_idx`);

--
-- 테이블의 인덱스 `orderbox`
--
ALTER TABLE `orderbox`
  ADD PRIMARY KEY (`ob_idx`);

--
-- 테이블의 인덱스 `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`o_idx`);

--
-- 테이블의 인덱스 `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`r_idx`);

--
-- 테이블의 인덱스 `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`s_idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `m_idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `menu`
--
ALTER TABLE `menu`
  MODIFY `me_idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 테이블의 AUTO_INCREMENT `orderbox`
--
ALTER TABLE `orderbox`
  MODIFY `ob_idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 테이블의 AUTO_INCREMENT `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `o_idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 테이블의 AUTO_INCREMENT `review`
--
ALTER TABLE `review`
  MODIFY `r_idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `shop`
--
ALTER TABLE `shop`
  MODIFY `s_idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
