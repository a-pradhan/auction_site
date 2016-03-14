-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 04, 2016 at 04:19 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `AuctionSite`
--

-- --------------------------------------------------------

--
-- Table structure for table `Auction`
--

CREATE TABLE IF NOT EXISTS `Auction` (
  `auctionID` int(11) NOT NULL AUTO_INCREMENT,
  `auctionReservePrice` int(11) NOT NULL,
  `auctionStart` datetime DEFAULT NULL,
  `auctionEnd` datetime DEFAULT NULL,
  `auctionSuccessful` tinyint(1) NOT NULL DEFAULT '0',
  `auctionLive` tinyint(4) NOT NULL DEFAULT '1',
  `bidID` int(11) DEFAULT NULL,
  `itemID` int(11) NOT NULL,
  PRIMARY KEY (`auctionID`),
  UNIQUE KEY `bidID` (`bidID`),
  KEY `itemID` (`itemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4005 ;

--
-- Dumping data for table `Auction`
--

INSERT INTO `Auction` (`auctionID`, `auctionReservePrice`, `auctionStart`, `auctionEnd`, `auctionSuccessful`, `auctionLive`, `bidID`, `itemID`) VALUES
(4000, 500, '2016-03-02 11:10:48', '2016-03-04 15:00:00', 0, 1, 146, 3001),
(4001, 200, '2016-03-02 11:10:48', '2016-03-04 15:00:00', 0, 1, NULL, 3000),
(4002, 800, '2016-03-02 11:10:48', '2016-03-04 15:00:00', 0, 1, 144, 3002),
(4003, 300, '2016-03-02 11:10:48', '2016-03-04 15:00:00', 0, 1, 145, 3003),
(4004, 110, '2016-03-02 11:10:48', '2016-03-04 15:00:00', 0, 1, NULL, 3004);

-- --------------------------------------------------------

--
-- Table structure for table `Bid`
--

CREATE TABLE IF NOT EXISTS `Bid` (
  `bidID` int(11) NOT NULL AUTO_INCREMENT,
  `auctionID` int(11) NOT NULL,
  `bidTimestamp` varchar(10) NOT NULL,
  `bidAmount` int(11) NOT NULL,
  `finalBid` tinyint(1) NOT NULL,
  `roleID` int(11) NOT NULL,
  PRIMARY KEY (`bidID`),
  KEY `roleID` (`roleID`),
  KEY `auctionID` (`auctionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=147 ;

--
-- Dumping data for table `Bid`
--

INSERT INTO `Bid` (`bidID`, `auctionID`, `bidTimestamp`, `bidAmount`, `finalBid`, `roleID`) VALUES
(138, 4000, '1999', 27000, 0, 2000),
(143, 4002, '1999', 500, 0, 2000),
(144, 4002, '1999', 501, 0, 2000),
(145, 4003, '1999', 500, 0, 2000),
(146, 4000, '1999', 28000, 0, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `Item`
--

CREATE TABLE IF NOT EXISTS `Item` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(255) NOT NULL,
  `itemPhoto` varchar(255) DEFAULT NULL,
  `itemDescription` varchar(255) NOT NULL,
  `itemQuantity` int(11) NOT NULL,
  `itemCategory` enum('Car','Mobile Phone','Bike','Laptop','Miscellaneous','Jewellry') NOT NULL,
  `itemTimestamp` int(11) NOT NULL,
  `sold` tinyint(1) NOT NULL DEFAULT '0',
  `roleID` int(11) NOT NULL,
  `itemCondition` enum('Used','Used - Like New','New') NOT NULL,
  PRIMARY KEY (`itemID`),
  KEY `roleID` (`roleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3005 ;

--
-- Dumping data for table `Item`
--

INSERT INTO `Item` (`itemID`, `itemName`, `itemPhoto`, `itemDescription`, `itemQuantity`, `itemCategory`, `itemTimestamp`, `sold`, `roleID`, `itemCondition`) VALUES
(3000, 'BMX Bike', 'BMX.png', 'The bike chooses the rider. Experience required.', 1, 'Bike', 130216, 0, 2000, 'Used - Like New'),
(3001, 'Rick Ross Chain', 'rickrosschain.png', 'Money motivation, gold/silver plated rick ross chain, only for the real mandem', 1, 'Jewellry', 130216, 0, 2000, 'Used'),
(3002, '16inch Alloy Wheels original', 'alloywheels.png', 'Alloy wheels, only serious buyers, well maintained, luxurious', 4, 'Car', 130216, 0, 2000, 'Used'),
(3003, 'Samsung S6 Edge', 'samsungs6.png', 'Boxed, in original box, unlocked, warranty for another year. Only serious offers.', 1, 'Mobile Phone', 130216, 0, 2000, 'Used - Like New'),
(3004, 'Muhammad Ali poster', 'momoaliposter.png', 'A1 Muhammad Ali poster, original and unboxed. Good quality material, leather!', 1, 'Miscellaneous', 130216, 0, 2000, 'New');

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

CREATE TABLE IF NOT EXISTS `Rating` (
  `ratingID` int(11) NOT NULL AUTO_INCREMENT,
  `roleID` int(11) NOT NULL,
  `auctionID` int(11) NOT NULL,
  PRIMARY KEY (`ratingID`),
  KEY `roleID` (`roleID`),
  KEY `auctionID` (`auctionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
  `roleID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `typeID` enum('Buyer','Seller') NOT NULL,
  PRIMARY KEY (`roleID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2002 ;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`roleID`, `userID`, `typeID`) VALUES
(2000, 1000, 'Seller'),
(2001, 1001, 'Buyer');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `lName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `userPassword` varchar(255) CHARACTER SET utf8 NOT NULL,
  `userEmail` varchar(255) CHARACTER SET utf8 NOT NULL,
  `userHouseNo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `userStreetName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `userCity` varchar(255) CHARACTER SET utf8 NOT NULL,
  `userPostcode` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contactNo` int(11) NOT NULL,
  `userCreationDate` datetime NOT NULL,
  `userDOB` int(11) NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1002 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userID`, `userName`, `fName`, `lName`, `userPassword`, `userEmail`, `userHouseNo`, `userStreetName`, `userCity`, `userPostcode`, `contactNo`, `userCreationDate`, `userDOB`) VALUES
(1000, 'TheSid', 'Sidney', 'Stars', 'money', 'MM@ucl.ac.uk', '1', 'Diamond Avenue', 'Dollar', '99', 101, '0000-00-00 00:00:00', 999),
(1001, 'Sidney_Stars', 'Sid', 'Stars', 'needtobehashed', 'dunno@productions.ltd', '999', 'Planet Earth', 'Gotham', 'M4N D3M', 101999666, '0000-00-00 00:00:00', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `WatchList`
--

CREATE TABLE IF NOT EXISTS `WatchList` (
  `watchID` int(11) NOT NULL AUTO_INCREMENT,
  `auctionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`watchID`),
  KEY `auctionID` (`auctionID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Auction`
--
ALTER TABLE `Auction`
  ADD CONSTRAINT `Auction_ibfk_2` FOREIGN KEY (`bidID`) REFERENCES `Bid` (`bidID`),
  ADD CONSTRAINT `Auction_ibfk_3` FOREIGN KEY (`itemID`) REFERENCES `Item` (`itemID`);

--
-- Constraints for table `Bid`
--
ALTER TABLE `Bid`
  ADD CONSTRAINT `Bid_ibfk_2` FOREIGN KEY (`roleID`) REFERENCES `Role` (`roleID`),
  ADD CONSTRAINT `Bid_ibfk_3` FOREIGN KEY (`auctionID`) REFERENCES `Auction` (`auctionID`);

--
-- Constraints for table `Item`
--
ALTER TABLE `Item`
  ADD CONSTRAINT `Item_ibfk_2` FOREIGN KEY (`roleID`) REFERENCES `Role` (`roleID`);

--
-- Constraints for table `Rating`
--
ALTER TABLE `Rating`
  ADD CONSTRAINT `Rating_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `Role` (`roleID`),
  ADD CONSTRAINT `Rating_ibfk_2` FOREIGN KEY (`auctionID`) REFERENCES `Auction` (`auctionID`);

--
-- Constraints for table `Role`
--
ALTER TABLE `Role`
  ADD CONSTRAINT `Role_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `User` (`userID`);

--
-- Constraints for table `WatchList`
--
ALTER TABLE `WatchList`
  ADD CONSTRAINT `WatchList_ibfk_1` FOREIGN KEY (`auctionID`) REFERENCES `Auction` (`auctionID`),
  ADD CONSTRAINT `WatchList_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `User` (`userID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;