-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2013 at 06:41 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pikidb`
--

-- --------------------------------------------------------

--
-- Table structure for table `piki_product`
--

CREATE TABLE IF NOT EXISTS `piki_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `parentid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_parent` (`parentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `piki_product`
--

INSERT INTO `piki_product` (`id`, `name`, `description`, `parentid`) VALUES
(0, 'Overall', 'All Products in the World.', NULL),
(1, 'Product 01', 'Product 01 Desc', 0),
(2, 'Product 02', 'Product 02 Desc', 0),
(3, 'Product 3', 'Product 13 Descripion', 1);

-- --------------------------------------------------------

--
-- Table structure for table `piki_rfq`
--

CREATE TABLE IF NOT EXISTS `piki_rfq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rfq_user` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `piki_rfq`
--

INSERT INTO `piki_rfq` (`id`, `userid`, `created_date`) VALUES
(39, 1, '2013-07-17 13:35:03'),
(40, 1, '2013-07-17 13:36:02'),
(41, 1, '2013-07-17 13:43:09'),
(42, 1, '2013-07-17 13:43:45'),
(43, 1, '2013-07-18 15:53:04'),
(44, 1, '2013-07-18 15:53:57'),
(45, 1, '2013-07-18 15:56:15'),
(46, 1, '2013-07-18 15:58:27'),
(47, 1, '2013-07-18 16:01:36'),
(48, 1, '2013-07-18 16:21:31'),
(49, 1, '2013-07-18 16:21:42'),
(50, 1, '2013-07-18 16:23:49'),
(51, 1, '2013-07-18 16:25:43'),
(52, 1, '2013-07-18 16:46:11'),
(53, 1, '2013-07-18 16:50:52'),
(54, 1, '2013-07-18 16:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `piki_rfq_product_assignment`
--

CREATE TABLE IF NOT EXISTS `piki_rfq_product_assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rfqid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rfqid_product` (`rfqid`),
  KEY `fk_rfq_productid` (`productid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `piki_rfq_product_assignment`
--

INSERT INTO `piki_rfq_product_assignment` (`id`, `rfqid`, `productid`) VALUES
(29, 39, 2),
(30, 40, 2),
(31, 40, 3),
(32, 41, 2),
(33, 42, 3),
(34, 43, 1),
(35, 44, 2),
(36, 45, 1),
(37, 46, 1),
(38, 47, 1),
(39, 48, 1),
(40, 49, 1),
(41, 50, 3),
(42, 51, 3),
(43, 52, 2),
(44, 53, 1),
(45, 54, 2);

-- --------------------------------------------------------

--
-- Table structure for table `piki_rfq_product_user_assignment`
--

CREATE TABLE IF NOT EXISTS `piki_rfq_product_user_assignment` (
  `rfqproductid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`rfqproductid`,`userid`),
  KEY `fk_rfqproduct_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `piki_rfq_product_user_assignment`
--

INSERT INTO `piki_rfq_product_user_assignment` (`rfqproductid`, `userid`) VALUES
(32, 1),
(35, 1),
(43, 1),
(45, 1),
(32, 2),
(35, 2),
(43, 2),
(45, 2),
(32, 3),
(33, 3),
(35, 3),
(41, 3),
(42, 3),
(43, 3),
(45, 3),
(33, 4),
(41, 4),
(42, 4);

-- --------------------------------------------------------

--
-- Table structure for table `piki_user`
--

CREATE TABLE IF NOT EXISTS `piki_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `business_reg_id` varchar(255) NOT NULL,
  `role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `piki_user`
--

INSERT INTO `piki_user` (`id`, `email`, `password`, `company_name`, `business_reg_id`, `role`) VALUES
(1, 'test1@bizweb.sg', '0dd718c7c22af281751277830b6f610a', 'Bizweb1', 'Bizweb1', 'admin'),
(2, 'test2@bizweb.sg', 'b62255639685bc31e55c7862014a1246', 'Bizweb2', 'Bizweb2', 'owner'),
(3, 'test3@bizweb.sg', '2398111e255d6c5c91545483f5568111', 'Bizweb3', 'Bizweb3', 'member'),
(4, 'test4@bizweb.sg', 'b2a21d6c0e93b762f9382a4bee89cd37', 'Bizweb4', 'Bizweb4', 'reader');

-- --------------------------------------------------------

--
-- Table structure for table `piki_user_product_assignment`
--

CREATE TABLE IF NOT EXISTS `piki_user_product_assignment` (
  `userid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`userid`,`productid`),
  KEY `fk_user_productid` (`productid`),
  KEY `fk_product_user_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `piki_user_product_assignment`
--

INSERT INTO `piki_user_product_assignment` (`userid`, `productid`, `role`) VALUES
(2, 2, 'owner'),
(3, 2, 'owner'),
(3, 3, 'owner'),
(4, 3, 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `tbl_auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `fk_auth_assignment_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_auth_assignment`
--

INSERT INTO `tbl_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', 1, 'return true;', 'N;'),
('admin', 2, 'return isset($params["product"]) && $params["product"]->allowCurrentUser("admin");', 'N;'),
('admin', 3, 'return isset($params["product"]) && $params["product"]->allowCurrentUser("admin");', 'N;'),
('member', 4, 'return isset($params["product"]) && $params["product"]->allowCurrentUser("member");', 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_item`
--

CREATE TABLE IF NOT EXISTS `tbl_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_auth_item`
--

INSERT INTO `tbl_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('admin', 2, '', NULL, 'N;'),
('createProduct', 0, 'create a new product', NULL, 'N;'),
('createRfq', 0, 'create a new rfq', NULL, 'N;'),
('createUser', 0, 'create a new user', NULL, 'N;'),
('deleteProduct', 0, 'delete a product', NULL, 'N;'),
('deleteRfq', 0, 'delete an rfq from a product', NULL, 'N;'),
('deleteUser', 0, 'remove a user from a product', NULL, 'N;'),
('member', 2, '', NULL, 'N;'),
('owner', 2, '', NULL, 'N;'),
('reader', 2, '', NULL, 'N;'),
('readProduct', 0, 'read product information', NULL, 'N;'),
('readRfq', 0, 'read rfq information', NULL, 'N;'),
('readUser', 0, 'read user profile information', NULL, 'N;'),
('updateProduct', 0, 'update product', NULL, 'N;'),
('updateRfq', 0, 'update rfq information', NULL, 'N;'),
('updateUser', 0, 'update a users in-formation', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `tbl_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `fk_auth_item_child_child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_auth_item_child`
--

INSERT INTO `tbl_auth_item_child` (`parent`, `child`) VALUES
('admin', 'createProduct'),
('member', 'createRfq'),
('admin', 'createUser'),
('admin', 'deleteProduct'),
('admin', 'deleteRfq'),
('admin', 'deleteUser'),
('admin', 'member'),
('owner', 'member'),
('admin', 'owner'),
('admin', 'reader'),
('member', 'reader'),
('owner', 'reader'),
('reader', 'readProduct'),
('reader', 'readRfq'),
('reader', 'readUser'),
('admin', 'updateProduct'),
('admin', 'updateRfq'),
('admin', 'updateUser');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1373447209),
('m130710_085820_create_all_tables', 1373447213),
('m130711_101050_create_rbac_tables', 1373538162),
('m130711_115453_add_role_to_piki_product_user_assignment', 1373543850),
('m130712_132622_create_user_assignment_tables', 1373636120);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `piki_product`
--
ALTER TABLE `piki_product`
  ADD CONSTRAINT `fk_product_parent` FOREIGN KEY (`parentid`) REFERENCES `piki_product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `piki_rfq`
--
ALTER TABLE `piki_rfq`
  ADD CONSTRAINT `fk_rfq_user` FOREIGN KEY (`userid`) REFERENCES `piki_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `piki_rfq_product_assignment`
--
ALTER TABLE `piki_rfq_product_assignment`
  ADD CONSTRAINT `fk_rfqid_product` FOREIGN KEY (`rfqid`) REFERENCES `piki_rfq` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rfq_productid` FOREIGN KEY (`productid`) REFERENCES `piki_product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `piki_rfq_product_user_assignment`
--
ALTER TABLE `piki_rfq_product_user_assignment`
  ADD CONSTRAINT `fk_rfqproductid_user` FOREIGN KEY (`rfqproductid`) REFERENCES `piki_rfq_product_assignment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rfqproduct_userid` FOREIGN KEY (`userid`) REFERENCES `piki_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `piki_user`
--
ALTER TABLE `piki_user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `piki_user_product_assignment`
--
ALTER TABLE `piki_user_product_assignment`
  ADD CONSTRAINT `fk_product_user_role` FOREIGN KEY (`role`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userid_product` FOREIGN KEY (`userid`) REFERENCES `piki_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_productid` FOREIGN KEY (`productid`) REFERENCES `piki_product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_auth_assignment`
--
ALTER TABLE `tbl_auth_assignment`
  ADD CONSTRAINT `fk_auth_assignment_itemname` FOREIGN KEY (`itemname`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_auth_assignment_userid` FOREIGN KEY (`userid`) REFERENCES `piki_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_auth_item_child`
--
ALTER TABLE `tbl_auth_item_child`
  ADD CONSTRAINT `fk_auth_item_child_child` FOREIGN KEY (`child`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_auth_item_child_parent` FOREIGN KEY (`parent`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
