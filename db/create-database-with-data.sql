-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 15, 2013 at 11:03 AM
-- Server version: 5.5.32-cll
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `opixuser_opix`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_person`
--

CREATE TABLE IF NOT EXISTS `contact_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contactperson_customer` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `contact_person`
--

INSERT INTO `contact_person` (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES
(1, 'Aittomaa', 'Heikki', NULL, NULL, 'hannu@bellevue.fi', 5),
(2, 'Testaaja', 'Tiina', 'suunnittelija', NULL, 'tiina@finedoors.com', 3),
(3, 'Enola', 'Eemeli', NULL, NULL, NULL, 3),
(4, 'Tallaaja', 'Tauno', NULL, NULL, NULL, 6),
(5, 'Aitomaa', 'Antti', 'testaaja', '12345', 'antti@mikkostone.fi', 4),
(6, 'Aaltonen', 'Aimo', NULL, NULL, NULL, 4),
(7, 'Laffer', 'Larry', NULL, NULL, NULL, 2),
(8, 'Croft', 'Lara', NULL, NULL, NULL, 2),
(9, 'klcidhsl', 'klcidhsl', 'mUcjFwxnWrbrKCMBB', '89093371902', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_description` varchar(1000) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `www` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_name`, `customer_description`, `street_address`, `post_code`, `city`, `www`) VALUES
(2, 'SoftDrink Oy', 'Limsan valmistaja', 'Koulukatu 10', '90100', 'Oulu', 'www.softdrink.fi'),
(3, 'FineDoors Oy', 'Puuovia', 'Hallituskatu 5', '98100', 'Kemijärvi', 'www.finedoors.fi'),
(4, 'MikkoStone', NULL, 'Aleksanterinkatu 17', '96100', 'Rovaniemi', 'www.mikkostone.fi'),
(5, 'BelleVue', NULL, 'Nahkurinkatu 20', '03100', 'Nummela', 'www.bellevue.fi'),
(6, 'GrafiArt', 'graafista suunnittelua', '', '', 'Iisalmi', 'www.grafiart.fi'),
(8, 'FinnArt Oy', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE IF NOT EXISTS `item_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type_name` varchar(255) NOT NULL,
  `item_type_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`id`, `item_type_name`, `item_type_description`) VALUES
(1, 'Epic', NULL),
(2, 'Theme', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_short` varchar(10) DEFAULT NULL,
  `language_long` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `language_short`, `language_long`) VALUES
(1, 'en', 'english'),
(2, 'fi', 'finnish');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `fk_person_language` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES
(1, 'Testaaja', 'Tauno', NULL, '', NULL, 'taunot', '1c25f83b8b5676a8ad0bd280fbfcf111', 1, 2),
(2, 'Koodaaja ', 'Kaisa', NULL, '', NULL, 'kaisak', '1c25f83b8b5676a8ad0bd280fbfcf111', 1, 2),
(3, 'Aaltonen ', 'Alli', NULL, '', NULL, 'allia', '1c25f83b8b5676a8ad0bd280fbfcf111', 2, 2),
(4, 'Virtanen', 'Ville', NULL, '', NULL, 'villev', '1c25f83b8b5676a8ad0bd280fbfcf111', 2, 2),
(5, 'Oppilas', 'Oili', NULL, '', NULL, 'oilio', '1c25f83b8b5676a8ad0bd280fbfcf111', 1, 2),
(6, 'Päivänlahti', 'Paavo', NULL, '', NULL, 'paavop', '1c25f83b8b5676a8ad0bd280fbfcf111', 1, 2),
(8, 'admin', 'admin', NULL, '', NULL, 'admin', 'e00cf25ad42683b3df678c61f42c6bda', 2, 1),
(9, 'testi', 'testi', NULL, '', '1234567', 'testi', 'e25cc21e72732ca1c937fbd5ce32ae8c', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `person_role`
--

CREATE TABLE IF NOT EXISTS `person_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `role_description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `person_role`
--

INSERT INTO `person_role` (`id`, `role_name`, `role_description`) VALUES
(1, 'Member', NULL),
(2, 'Scrum Master', NULL),
(3, 'Project Manager', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_backlog`
--

CREATE TABLE IF NOT EXISTS `product_backlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `backlog_name` varchar(255) NOT NULL,
  `product_visio` varchar(1000) DEFAULT NULL,
  `product_current_state` varchar(1000) DEFAULT NULL,
  `product_owner` varchar(255) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_backlog_project` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `product_backlog`
--

INSERT INTO `product_backlog` (`id`, `backlog_name`, `product_visio`, `product_current_state`, `product_owner`, `project_id`) VALUES
(4, 'testinimi', 'testivisio', 'testitila', '1', 4),
(5, 'Music Club ', 'To design and implement web pages to a music club that doesn''t have any yet.', 'Nothing has not been implemented.', '3', 6),
(6, 'testi', NULL, NULL, '2', 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_backlog_item`
--

CREATE TABLE IF NOT EXISTS `product_backlog_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_description` varchar(1000) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `business_value` int(11) DEFAULT NULL,
  `estimate_points` int(11) DEFAULT NULL,
  `effort_estimate_hours` int(11) DEFAULT NULL,
  `acceptance_criteria` varchar(1000) DEFAULT NULL,
  `release_target` varchar(255) DEFAULT NULL,
  `product_backlog_id` int(11) NOT NULL,
  `item_type_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `is_part_of_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_backlog_item_product_backlog` (`product_backlog_id`),
  KEY `fk_product_backlog_item_item_type` (`item_type_id`),
  KEY `fk_product_backlog_item_status` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `product_backlog_item`
--

INSERT INTO `product_backlog_item` (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES
(5, 'testi', 'testi', 1, 2, 3, 4, 'testi', '1. release', 4, 1, 2, NULL, '2012-12-27'),
(6, 'Find a web hotel', 'As an site owner I want to have reliable but not very expensive web hotel. ', 1, 10, NULL, 15, 'The web hotel have been chosen.', NULL, 5, 1, 1, NULL, '2013-01-06'),
(7, 'Contents of a site', 'As a person interested in the music I need to find out ....', 1, 10, NULL, NULL, 'The mid map of the contents site has been created.', NULL, 5, 1, 1, NULL, '2013-01-06'),
(8, 'The outlook of the site', 'As a user when scanning the site pages I want to see very easily the data blocks in the pages.', 1, 10, NULL, NULL, 'The fonts, colors and images of the site has been defined. ', NULL, 5, 1, 1, NULL, '2013-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) DEFAULT NULL,
  `project_description` text,
  `project_start_date` date DEFAULT NULL,
  `project_end_date` date DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `project_type` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_projecttype` (`type_id`),
  KEY `fk_project_customer` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `project_name`, `project_description`, `project_start_date`, `project_end_date`, `type_id`, `customer_id`, `project_type`, `active`) VALUES
(2, 'ShopTesting', 'Testing project of a web shop', '2012-08-20', NULL, 2, 3, 1, 2),
(4, 'GrafUx', 'User experience study', '2012-09-10', '2012-12-22', 2, 6, 2, 1),
(6, 'Music Club ', 'Web pages for a music club. ', '2013-01-06', '2013-02-28', NULL, 4, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `project_period`
--

CREATE TABLE IF NOT EXISTS `project_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period_name` varchar(250) NOT NULL,
  `period_description` varchar(1000) DEFAULT NULL,
  `period_start_date` date NOT NULL,
  `period_end_date` date NOT NULL,
  `milestone` tinyint(4) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `project_period`
--

INSERT INTO `project_period` (`id`, `period_name`, `period_description`, `period_start_date`, `period_end_date`, `milestone`, `project_id`) VALUES
(1, 'Period 1', 'something to do in the first period', '2013-01-06', '2013-01-17', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `project_staff`
--

CREATE TABLE IF NOT EXISTS `project_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `person_role_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_projectstaff_project` (`project_id`),
  KEY `fk_projectstaff_person` (`person_id`),
  KEY `fk_projectstaff_personrole` (`person_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `project_staff`
--

INSERT INTO `project_staff` (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES
(1, 4, 1, 1, '2012-09-10', NULL),
(2, 4, 2, 1, '2012-09-10', NULL),
(3, 4, 6, 3, '2012-09-10', NULL),
(4, 2, 1, 1, '2012-08-20', NULL),
(5, 2, 2, 1, '2012-08-20', NULL),
(6, 2, 3, 3, '2012-08-20', NULL),
(14, 2, 4, 1, '2012-08-20', NULL),
(15, 6, 6, 3, '2013-01-06', NULL),
(16, 6, 3, 2, '2013-01-06', NULL),
(18, 6, 1, 1, '2013-01-06', NULL),
(19, 6, 2, 1, '2013-01-06', NULL),
(20, 6, 9, 1, '2011-08-17', '2013-09-17'),
(22, 6, 8, 3, '2011-11-15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_type`
--

CREATE TABLE IF NOT EXISTS `project_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  `type_description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `project_type`
--

INSERT INTO `project_type` (`id`, `type_name`, `type_description`) VALUES
(1, 'Scrum', 'An agile project'),
(2, 'Traditional', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sprint_backlog`
--

CREATE TABLE IF NOT EXISTS `sprint_backlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_backlog_id` int(11) NOT NULL,
  `sprint_name` varchar(255) NOT NULL,
  `sprint_description` varchar(1000) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_backlog_product_backlog` (`product_backlog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sprint_backlog`
--

INSERT INTO `sprint_backlog` (`id`, `product_backlog_id`, `sprint_name`, `sprint_description`, `start_date`, `end_date`) VALUES
(1, 4, 'testi', 'testi', '2012-12-21', '2012-12-28'),
(2, 5, 'The contents and the outlook of the site', 'The contents, navigation and outlook of the site.', '2013-01-06', '2013-01-17');

-- --------------------------------------------------------

--
-- Table structure for table `sprint_backlog_item`
--

CREATE TABLE IF NOT EXISTS `sprint_backlog_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sprint_backlog_id` int(11) NOT NULL,
  `product_backlog_item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_backlog_item_sprint_backlog` (`sprint_backlog_id`),
  KEY `fk_sprint_backlog_item_product_backlog_item` (`product_backlog_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sprint_backlog_item`
--

INSERT INTO `sprint_backlog_item` (`id`, `sprint_backlog_id`, `product_backlog_item_id`) VALUES
(1, 2, 7),
(2, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `sprint_task`
--

CREATE TABLE IF NOT EXISTS `sprint_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) NOT NULL,
  `task_description` varchar(1000) DEFAULT NULL,
  `effort_estimate_hours` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `sprint_backlog_item_id` int(11) NOT NULL,
  `task_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_task_status` (`status_id`),
  KEY `fk_sprint_task_sprint_backlog_item` (`sprint_backlog_item_id`),
  KEY `fk_sprint_task_task_type` (`task_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sprint_task`
--

INSERT INTO `sprint_task` (`id`, `task_name`, `task_description`, `effort_estimate_hours`, `status_id`, `sprint_backlog_item_id`, `task_type_id`) VALUES
(1, 'Contents of the site', 'Create a mind map of the site, write notes about each node of the mind map', 15, 1, 1, 1),
(2, 'Fonts & colors of the site', 'Create at least three different outlooks for the site to choose from.', 20, 1, 2, 1),
(3, 'Images of the site', 'Collect possible images (CC licensed). ', 7, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sprint_task_person`
--

CREATE TABLE IF NOT EXISTS `sprint_task_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sprint_task_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `estimate_work_effort_hours` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_task_person_sprint_task` (`sprint_task_id`),
  KEY `fk_sprint_task_person_person` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sprint_task_person`
--

INSERT INTO `sprint_task_person` (`id`, `sprint_task_id`, `person_id`, `estimate_work_effort_hours`) VALUES
(1, 1, 1, 7),
(2, 1, 2, 7),
(3, 3, 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `sprint_work`
--

CREATE TABLE IF NOT EXISTS `sprint_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_date` date NOT NULL,
  `work_done_hours` decimal(5,1) NOT NULL,
  `work_remaining_hours` decimal(5,1) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `sprint_task_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_work_sprint_task` (`sprint_task_id`),
  KEY `fk_sprint_work_person` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) NOT NULL,
  `status_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status_name`, `status_description`) VALUES
(1, 'Not started', NULL),
(2, 'In Progress', NULL),
(3, 'Done', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(256) NOT NULL,
  `task_description` varchar(1000) DEFAULT NULL,
  `task_start_date` date NOT NULL,
  `task_end_date` date NOT NULL,
  `effort_estimate_hours` int(11) NOT NULL,
  `project_period_id` int(11) NOT NULL,
  `task_type_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_period` (`project_period_id`),
  KEY `fk_task_type` (`task_type_id`),
  KEY `fk_status` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `task_name`, `task_description`, `task_start_date`, `task_end_date`, `effort_estimate_hours`, `project_period_id`, `task_type_id`, `status_id`) VALUES
(1, 'Task1', 'task1, task1', '2013-01-06', '2013-01-10', 10, 1, 1, 1),
(2, 'Task2', 'task2, task2, task2', '2013-01-13', '2013-01-15', 4, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `task_person`
--

CREATE TABLE IF NOT EXISTS `task_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `effort_estimate_hours` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_person_task` (`task_id`),
  KEY `fk_task_person_person` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `task_person`
--

INSERT INTO `task_person` (`id`, `start_date`, `end_date`, `effort_estimate_hours`, `task_id`, `person_id`) VALUES
(1, '2013-01-06', '2013-01-10', 3, 1, 1),
(2, '2013-01-06', '2013-01-10', 2, 1, 2),
(3, '2013-01-13', '2013-01-15', 2, 2, 3),
(4, '2013-01-13', '2013-01-15', 2, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `task_type`
--

CREATE TABLE IF NOT EXISTS `task_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_type_name` varchar(255) NOT NULL,
  `task_type_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `task_type`
--

INSERT INTO `task_type` (`id`, `task_type_name`, `task_type_description`) VALUES
(1, 'Design', NULL),
(2, 'Coding', NULL),
(3, 'Testing', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_work`
--

CREATE TABLE IF NOT EXISTS `task_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_hours` decimal(5,1) NOT NULL,
  `work_date` date NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_work_task` (`task_id`),
  KEY `fk_task_work_person` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_person`
--
ALTER TABLE `contact_person`
  ADD CONSTRAINT `fk_contactperson_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `fk_person_language` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Constraints for table `product_backlog`
--
ALTER TABLE `product_backlog`
  ADD CONSTRAINT `fk_product_backlog_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_backlog_item`
--
ALTER TABLE `product_backlog_item`
  ADD CONSTRAINT `fk_product_backlog_item_item_type` FOREIGN KEY (`item_type_id`) REFERENCES `item_type` (`id`),
  ADD CONSTRAINT `fk_product_backlog_item_product_backlog` FOREIGN KEY (`product_backlog_id`) REFERENCES `product_backlog` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_backlog_item_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_project_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_project_projecttype` FOREIGN KEY (`type_id`) REFERENCES `project_type` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `project_period`
--
ALTER TABLE `project_period`
  ADD CONSTRAINT `fk_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_staff`
--
ALTER TABLE `project_staff`
  ADD CONSTRAINT `fk_projectstaff_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_projectstaff_personrole` FOREIGN KEY (`person_role_id`) REFERENCES `person_role` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_projectstaff_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sprint_backlog`
--
ALTER TABLE `sprint_backlog`
  ADD CONSTRAINT `fk_sprint_backlog_product_backlog` FOREIGN KEY (`product_backlog_id`) REFERENCES `product_backlog` (`id`);

--
-- Constraints for table `sprint_backlog_item`
--
ALTER TABLE `sprint_backlog_item`
  ADD CONSTRAINT `fk_sprint_backlog_item_product_backlog_item` FOREIGN KEY (`product_backlog_item_id`) REFERENCES `product_backlog_item` (`id`),
  ADD CONSTRAINT `fk_sprint_backlog_item_sprint_backlog` FOREIGN KEY (`sprint_backlog_id`) REFERENCES `sprint_backlog` (`id`);

--
-- Constraints for table `sprint_task`
--
ALTER TABLE `sprint_task`
  ADD CONSTRAINT `fk_sprint_task_sprint_backlog_item` FOREIGN KEY (`sprint_backlog_item_id`) REFERENCES `sprint_backlog_item` (`id`),
  ADD CONSTRAINT `fk_sprint_task_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `fk_sprint_task_task_type` FOREIGN KEY (`task_type_id`) REFERENCES `task_type` (`id`);

--
-- Constraints for table `sprint_task_person`
--
ALTER TABLE `sprint_task_person`
  ADD CONSTRAINT `fk_sprint_task_person_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_sprint_task_person_sprint_task` FOREIGN KEY (`sprint_task_id`) REFERENCES `sprint_task` (`id`);

--
-- Constraints for table `sprint_work`
--
ALTER TABLE `sprint_work`
  ADD CONSTRAINT `fk_sprint_work_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_sprint_work_sprint_task` FOREIGN KEY (`sprint_task_id`) REFERENCES `sprint_task` (`id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk_project_period` FOREIGN KEY (`project_period_id`) REFERENCES `project_period` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_task_type` FOREIGN KEY (`task_type_id`) REFERENCES `task_type` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `task_person`
--
ALTER TABLE `task_person`
  ADD CONSTRAINT `fk_task_person_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_task_person_task` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`);

--
-- Constraints for table `task_work`
--
ALTER TABLE `task_work`
  ADD CONSTRAINT `fk_task_work_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `fk_task_work_task` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;