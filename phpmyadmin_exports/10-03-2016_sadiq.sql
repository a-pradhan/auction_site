-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2016 at 02:44 PM
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
  `auctionViewings` int(11) DEFAULT '0',
  `auctionSuccessful` tinyint(4) DEFAULT '0',
  `buyerRated` tinyint(1) NOT NULL DEFAULT '0',
  `sellerRated` tinyint(1) NOT NULL DEFAULT '0',
  `auctionUnsuccessful` tinyint(1) DEFAULT '0',
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

INSERT INTO `Auction` (`auctionID`, `auctionReservePrice`, `auctionStart`, `auctionEnd`, `auctionViewings`, `auctionSuccessful`, `buyerRated`, `sellerRated`, `auctionUnsuccessful`, `auctionLive`, `bidID`, `itemID`) VALUES
(4000, 500, '2016-03-02 11:10:48', '2016-03-08 22:28:00', 12, 1, 1, 1, 0, 0, 21, 3001),
(4001, 200, '2016-03-02 11:10:48', '2016-03-10 14:55:00', 49, 0, 0, 0, 0, 1, 25, 3000),
(4002, 800, '2016-03-02 11:10:48', '2016-03-19 21:39:00', 3, 0, 0, 0, 0, 1, NULL, 3002),
(4003, 300, '2016-03-02 11:10:48', '2016-03-19 21:39:00', 11, 0, 0, 0, 0, 1, NULL, 3003),
(4004, 110, '2016-03-02 11:10:48', '2016-03-19 21:39:00', 1, 0, 0, 0, 0, 1, NULL, 3004);

-- --------------------------------------------------------

--
-- Table structure for table `Bid`
--

CREATE TABLE IF NOT EXISTS `Bid` (
  `bidID` int(11) NOT NULL AUTO_INCREMENT,
  `auctionID` int(11) NOT NULL,
  `bidTimestamp` varchar(10) NOT NULL,
  `bidAmount` int(11) NOT NULL,
  `roleID` int(11) NOT NULL,
  PRIMARY KEY (`bidID`),
  KEY `roleID` (`roleID`),
  KEY `auctionID` (`auctionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `Bid`
--

INSERT INTO `Bid` (`bidID`, `auctionID`, `bidTimestamp`, `bidAmount`, `roleID`) VALUES
(18, 4000, '1999', 500, 2008),
(19, 4000, '1999', 501, 2004),
(20, 4000, '1999', 520, 2008),
(21, 4000, '1999', 525, 2004),
(22, 4001, '1999', 2312, 2004),
(23, 4001, '1999', 2400, 2004),
(24, 4001, '1999', 2500, 2008),
(25, 4001, '1999', 2600, 2010);

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
  `roleID` int(11) NOT NULL,
  `itemCondition` enum('Used','Used - Like New','New') NOT NULL,
  PRIMARY KEY (`itemID`),
  KEY `roleID` (`roleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3005 ;

--
-- Dumping data for table `Item`
--

INSERT INTO `Item` (`itemID`, `itemName`, `itemPhoto`, `itemDescription`, `itemQuantity`, `itemCategory`, `roleID`, `itemCondition`) VALUES
(3000, 'BMX Bike', 'BMX.png', 'The bike chooses the rider. Experience required.', 1, 'Bike', 2003, 'Used - Like New'),
(3001, 'Rick Ross Chain', 'rickrosschain.png', 'Money motivation, gold/silver plated rick ross chain, only for the real mandem', 1, 'Jewellry', 2003, 'Used'),
(3002, '16inch Alloy Wheels original', 'alloywheels.png', 'Alloy wheels, only serious buyers, well maintained, luxurious', 4, 'Car', 2003, 'Used'),
(3003, 'Samsung S6 Edge', 'samsungs6.png', 'Boxed, in original box, unlocked, warranty for another year. Only serious offers.', 1, 'Mobile Phone', 2005, 'Used - Like New'),
(3004, 'Muhammad Ali poster', 'momoaliposter.png', 'A1 Muhammad Ali poster, original and unboxed. Good quality material, leather!', 1, 'Miscellaneous', 2003, 'New');

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

CREATE TABLE IF NOT EXISTS `Rating` (
  `ratingID` int(11) NOT NULL AUTO_INCREMENT,
  `roleID` int(11) NOT NULL,
  `auctionID` int(11) NOT NULL,
  `ratingValue` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ratingID`),
  KEY `roleID` (`roleID`),
  KEY `auctionID` (`auctionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4006 ;

--
-- Dumping data for table `Rating`
--

INSERT INTO `Rating` (`ratingID`, `roleID`, `auctionID`, `ratingValue`) VALUES
(4001, 2004, 4000, 4),
(4002, 2003, 4000, 5),
(4003, 2004, 4001, 3),
(4004, 2004, 4001, 5),
(4005, 2004, 4001, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2012 ;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`roleID`, `userID`, `typeID`) VALUES
(2000, 1000, 'Seller'),
(2001, 1001, 'Buyer'),
(2002, 1002, 'Buyer'),
(2003, 1002, 'Seller'),
(2004, 1003, 'Buyer'),
(2005, 1003, 'Seller'),
(2006, 1004, 'Buyer'),
(2007, 1004, 'Seller'),
(2008, 1005, 'Buyer'),
(2009, 1005, 'Seller'),
(2010, 1006, 'Buyer'),
(2011, 1006, 'Seller');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1007 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userID`, `userName`, `fName`, `lName`, `userPassword`, `userEmail`, `userHouseNo`, `userStreetName`, `userCity`, `userPostcode`, `contactNo`, `userCreationDate`, `userDOB`) VALUES
(1000, 'TheSid', 'Sidney', 'Stars', 'money', 'MM@ucl.ac.uk', '1', 'Diamond Avenue', 'Dollar', '99', 101, '0000-00-00 00:00:00', 999),
(1001, 'Sidney_Stars', 'Sid', 'Stars', 'needtobehashed', 'dunno@productions.ltd', '999', 'Planet Earth', 'Gotham', 'M4N D3M', 101999666, '0000-00-00 00:00:00', 2000),
(1002, 'baklava', ' Don', 'Baqlawi', '$2y$10$N2MzOTZmZTQyYjA5MWRkN.gx841kvtuSCLHuC9BbLjs51htaxfKP6', 'Baqlawi@productions.com', '', '', '', '', 0, '0000-00-00 00:00:00', 0),
(1003, 'Mannen', 'Mannen ', 'Ibla', '$2y$10$NzFhMTEyOTAwY2Q5ZTNlNe/QTKd80S3fmryOFTHQMHbqP9Xf6Rn8y', 'dunnopro@proudctio.com', '', '', '', '', 0, '0000-00-00 00:00:00', 0),
(1004, 'Gold Tony', 'Polisen ', 'Bla', '$2y$10$MTM1MjFlNjk3NjlhNzI4MuxMwQIMWTRaJEGkY2DyCHfvL4lNOZAS6', 'Pengar@hotmail.comney', '', '', '', '', 0, '0000-00-00 00:00:00', 0),
(1005, 'Krona', ' Ulrika', 'Sven', '$2y$10$OGIwYjlhZDliYmFkYzc4ZOT7gVHW2xWeWJmHgAdkA8kyYj/IWFXey', 'TreKron@gmail.com', '', '', '', '', 0, '0000-00-00 00:00:00', 0),
(1006, 'TheShiekh', 'Shiekh ', 'Al-Deen', '$2y$10$ZDU3MjIzNDExY2U1NzM4NuJPla4hpwaXlQDjMkUASIXT1.ID920Gm', 'PetroMoney@kingdom.com', '', '', '', '', 0, '0000-00-00 00:00:00', 0);

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
