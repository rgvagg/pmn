-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2014 at 08:54 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `placemenow`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `AnnID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Header` text NOT NULL,
  `Content` text NOT NULL,
  `AnnTime` datetime NOT NULL,
  PRIMARY KEY (`AnnID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`AnnID`, `UserID`, `Header`, `Content`, `AnnTime`) VALUES
(1, 1, 'ann', 'ann', '2014-11-29 10:42:23'),
(2, 1, 'asdfasd', 'asdfasdf', '2014-11-30 08:50:00'),
(3, 1, 'anmn', 'ann', '2014-11-30 08:52:37'),
(4, 1, 'this is the dummy announcement', 'this is k', '2014-11-30 08:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `FBID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `FBSubject` text NOT NULL,
  `FBContent` text NOT NULL,
  `UpdatedOn` datetime NOT NULL,
  PRIMARY KEY (`FBID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FBID`, `UserID`, `FBSubject`, `FBContent`, `UpdatedOn`) VALUES
(1, 2, '', '', '2014-11-30 01:01:18'),
(2, 2, '', '', '2014-11-30 01:01:31'),
(3, 2, 'hghgh', 'hhghgh', '2014-11-30 01:02:22'),
(4, 2, 'ann', 'ann', '2014-11-30 20:14:19'),
(5, 2, 'ann', 'ann', '2014-11-30 20:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE IF NOT EXISTS `resumes` (
  `ResID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ResumeLink` text NOT NULL,
  PRIMARY KEY (`ResID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`ResID`, `UserID`, `ResumeLink`) VALUES
(1, 2, '/var/www/html/PlaceMeNow/ResumeFiles/sagar.anand@outlook.com_2014-11-30 19-52-53.pdf'),
(2, 2, '/var/www/html/PlaceMeNow/ResumeFiles/sagar.anand@outlook.com_2014-11-30 20-12-18.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserEmail` varchar(500) NOT NULL,
  `UserPwd` varchar(500) NOT NULL,
  `UserName` varchar(500) NOT NULL,
  `UserContact` varchar(100) NOT NULL,
  `UserProfile` varchar(500) NOT NULL,
  `UserType` char(1) NOT NULL DEFAULT 'B',
  `UpdatedOn` date NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserEmail` (`UserEmail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserEmail`, `UserPwd`, `UserName`, `UserContact`, `UserProfile`, `UserType`, `UpdatedOn`) VALUES
(1, 'sagar.anand@live.in', 'test', 'Test 1', '9666836106', 'http://facebook.com', 'A', '2014-11-29'),
(2, 'sagar.anand@outlook.com', 'test', 'Test 2', '9666836106', 'http://google.com', 'B', '2014-11-29'),
(3, 'sagar.anand015@gmail.com', 'test', 'test 3', '9666836106', 'http://mentored-research.com', 'B', '2014-11-29'),
(4, 'soni946@gmail.com', 'test', 'test 4', '9666836106', 'http://mentored-research.com', 'B', '2014-11-29'),
(5, 'siddharth.lenka59@gmail.com', 'test', 'test 5', '9666836106', 'http://mentored-research.com', 'A', '2014-11-29'),
(6, 'mom@mom.com', 'test', 'this ', 'this ', 'this', 'B', '2014-11-29'),
(7, 'gogog@fofof.com', 'test', 'this ', 'this', 'rhis', 'B', '2014-11-29'),
(8, 'eee@eee.com', 'test', 'this', 'this ', 'this', 'B', '2014-11-29');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
