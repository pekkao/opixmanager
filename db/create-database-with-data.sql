DROP DATABASE IF EXISTS opixmanager;
CREATE DATABASE IF NOT EXISTS opixmanager;
USE opixmanager;

-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2014 at 09:52 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `opixmanager`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
(9, 'klcidhsl', 'klcidhsl', 'mUcjFwxnWrbrKCMBB', '89093371902', NULL, 3),
(10, 'Virtanen', 'Ville', NULL, NULL, NULL, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_name`, `customer_description`, `street_address`, `post_code`, `city`, `www`) VALUES
(2, 'SoftDrink Oy', 'Limsan valmistaja', 'Koulukatu 10', '90100', 'Oulu', 'www.softdrink.fi'),
(3, 'FineDoors Oy', 'Puuovia', 'Hallituskatu 5', '98100', 'Kemijärvi', 'www.finedoors.fi'),
(4, 'MikkoStone', NULL, 'Aleksanterinkatu 17', '96100', 'Rovaniemi', 'www.mikkostone.fi'),
(5, 'BelleVue', NULL, 'Nahkurinkatu 20', '03100', 'Nummela', 'www.bellevue.fi'),
(6, 'GrafiArt', 'graafista suunnittelua', '', '', 'Iisalmi', 'www.grafiart.fi'),
(9, 'Elli-ääni Oy', 'some text here.', 'Koulutie 1', '99123', 'Sodankylä', NULL),
(10, 'FinnArt Oy', NULL, NULL, NULL, NULL, NULL);

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
  `language_id` int(11) NOT NULL,
  `account_type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `fk_person_language` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES
(1, 'Testaaja', 'Tauno', NULL, '', NULL, 'taunot', MD5('taunot14'), 1, 2),
(2, 'Koodaaja ', 'Kaisa', NULL, '', NULL, 'kaisak', MD5('kaisak14'), 1, 2),
(3, 'Aaltonen', 'Alli', 'Programmer', NULL, '1234567', 'allia', MD5('allia14'), 2, 2),
(4, 'Virtanen', 'Ville', NULL, '', NULL, 'villev', MD5('villev14'), 2, 2),
(5, 'Oppilas', 'Oili', NULL, '', NULL, 'oilio', MD5('oikio14'), 1, 2),
(6, 'Päivänlahti', 'Paavo', NULL, '', NULL, 'paavop', MD5('paavop14'), 1, 2),
(8, 'admin', 'admin', 'Manager', NULL, NULL, 'admin', MD5('14admin'), 2, 1),
(9, 'testi', 'testi', NULL, '', '1234567', 'testi', MD5('testi14'), 2, 2),
(10, 'Ääninen', 'Äijä', NULL, '', NULL, 'aijaa', MD5('aijaa14'), 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `person_role`
--

CREATE TABLE IF NOT EXISTS `person_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `role_description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
  `product_owner` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_backlog_project` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `product_backlog`
--

INSERT INTO `product_backlog` (`id`, `backlog_name`, `product_visio`, `product_current_state`, `product_owner`, `project_id`) VALUES
(5, 'Music Club', 'To design and implement web pages to a music club that doesn''t have any yet.', 'Nothing has not been implemented. ', 3, 6),
(6, 'just testing', NULL, NULL, 2, 4),
(7, 'Test backlog', 'Just testing this application', 'Nothing has been done yet', 3, 8);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `product_backlog_item`
--

INSERT INTO `product_backlog_item` (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES
(6, 'Find a web hotel', 'As an site owner I want to have reliable but not very expensive web hotel. ', 1, 10, NULL, 15, 'The web hotel have been chosen.', NULL, 5, 1, 1, NULL, '2013-01-06'),
(7, 'Contents of a site', 'As a person interested in the music I need to find out ....', 1, 10, NULL, NULL, 'The mid map of the contents site has been created.', NULL, 5, 1, 1, NULL, '2013-01-06'),
(8, 'The outlook of the site', 'As a user when scanning the site pages I want to see very easily the data blocks in the pages.', 1, 10, NULL, NULL, 'The fonts, colors and images of the site has been defined. ', NULL, 5, 1, 1, NULL, '2013-01-13'),
(9, 'Item1', 'As a user I want hear good sounds so that ...', NULL, NULL, NULL, 10, 'something here too', NULL, 7, 1, 2, NULL, '2014-05-11'),
(10, 'Item2', 'As a user want to XXXXXXXXXXX so that YYYYYYYYYYYYYY', NULL, NULL, NULL, 20, NULL, NULL, 7, 1, 1, NULL, '2014-05-12'),
(11, 'item3', 'Third user story in the backlog', NULL, NULL, NULL, 30, NULL, NULL, 7, 1, 1, NULL, '2014-05-13'),
(12, 'item4', 'Fourth user story in the backlog', NULL, NULL, NULL, 40, NULL, NULL, 7, 1, 1, NULL, '2014-05-13'),
(13, 'Item5', 'Fifth user story in the backlog', NULL, NULL, NULL, 5, NULL, NULL, 7, 1, 1, NULL, '2014-05-18'),
(14, 'item6', 'Sixth user story in the backlog', NULL, NULL, NULL, 60, NULL, NULL, 7, 1, 1, NULL, '2014-05-04');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `project_description` text,
  `project_start_date` date DEFAULT NULL,
  `project_end_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `project_type` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_customer` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `project_name`, `project_description`, `project_start_date`, `project_end_date`, `customer_id`, `project_type`, `active`) VALUES
(2, 'ShopTesting', 'Testing project of a web shop', '2012-08-20', NULL, 3, 1, 2),
(4, 'GrafUx', 'User experience study', '2012-09-10', '2012-12-22', 6, 2, 1),
(6, 'Music Club X', 'Web pages for a music club. ', '2014-01-05', '2014-07-31', 4, 2, 2),
(8, 'Testproject Voices', 'Something about voices and videos and images', '2014-04-01', '2014-06-30', 10, 2, 2),
(9, 'Testijuttu', NULL, NULL, NULL, NULL, 2, 2);

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
  `can_edit_project_staff` tinyint(1) NOT NULL,
  `can_edit_project_data` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_projectstaff_project` (`project_id`),
  KEY `fk_projectstaff_person` (`person_id`),
  KEY `fk_projectstaff_personrole` (`person_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `project_staff`
--

INSERT INTO `project_staff` (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`, `can_edit_project_staff`, `can_edit_project_data`) VALUES
(1, 4, 1, 1, '2012-09-10', NULL, 0, 0),
(2, 4, 2, 1, '2012-09-10', NULL, 0, 0),
(3, 4, 6, 3, '2012-09-10', NULL, 0, 0),
(5, 2, 2, 1, '2012-08-20', NULL, 1, 0),
(6, 2, 3, 3, '2012-08-20', NULL, 0, 0),
(14, 2, 4, 1, '2012-08-20', NULL, 0, 0),
(15, 6, 6, 1, '2013-01-31', '2014-05-04', 0, 1),
(16, 6, 3, 2, '2013-01-06', NULL, 0, 0),
(18, 6, 1, 1, '2013-01-06', '2014-06-01', 0, 0),
(19, 6, 2, 1, '2013-01-06', NULL, 1, 0),
(22, 6, 8, 3, '2011-11-15', NULL, 0, 0),
(23, 2, 6, NULL, '2014-05-04', NULL, 0, 1),
(25, 8, 2, 1, '2014-04-27', NULL, 0, 0),
(26, 8, 3, 3, '2014-05-11', NULL, 1, 1),
(39, 8, 5, 1, '2014-04-27', NULL, 0, 0),
(42, 6, 10, 1, '2014-05-04', NULL, 0, 0),
(43, 2, 8, 1, '2014-05-04', NULL, 0, 0),
(44, 8, 4, 1, '2014-05-04', NULL, 0, 1),
(45, 8, 9, 1, '2014-05-04', NULL, 0, 0),
(46, 2, 1, 1, '2014-06-08', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sprint_backlog`
--

CREATE TABLE IF NOT EXISTS `sprint_backlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_backlog_id` int(11) NOT NULL,
  `sprint_name` varchar(255) NOT NULL,
  `sprint_description` varchar(1000) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_backlog_product_backlog` (`product_backlog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `sprint_backlog`
--

INSERT INTO `sprint_backlog` (`id`, `product_backlog_id`, `sprint_name`, `sprint_description`, `start_date`, `end_date`) VALUES
(2, 5, 'The contents and the outlook of the site', 'The contents, navigation and outlook of the site.', '2014-06-02', '2014-06-30'),
(10, 7, 'First sprint', 'some text here', '2014-05-16', '2014-05-29'),
(17, 7, 'Second sprint', NULL, '2014-05-04', '2014-05-16');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sprint_backlog_item`
--

INSERT INTO `sprint_backlog_item` (`id`, `sprint_backlog_id`, `product_backlog_item_id`) VALUES
(1, 2, 7),
(2, 2, 8),
(3, 10, 9),
(4, 10, 10),
(6, 10, 12),
(7, 17, 11),
(8, 17, 13);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sprint_task`
--

INSERT INTO `sprint_task` (`id`, `task_name`, `task_description`, `effort_estimate_hours`, `status_id`, `sprint_backlog_item_id`, `task_type_id`) VALUES
(1, 'Contents of the site', 'Create a mind map of the site, write notes about each node of the mind map', 15, 1, 1, 1),
(2, 'Fonts & colors of the site', 'Create at least three different outlooks for the site to choose from.', 20, 1, 2, 1),
(3, 'Images of the site', 'Collect possible images (CC licensed). ', 7, 1, 2, 1),
(4, 'item1, task1', NULL, 10, 1, 3, 1),
(5, 'item1, task2', NULL, 9, 1, 3, 1),
(7, 'aaaaaaaa', NULL, 12, 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sprint_task_person`
--

CREATE TABLE IF NOT EXISTS `sprint_task_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sprint_task_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `estimate_work_effort_hours` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_task_person_sprint_task` (`sprint_task_id`),
  KEY `fk_sprint_task_person_person` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `sprint_task_person`
--

INSERT INTO `sprint_task_person` (`id`, `sprint_task_id`, `person_id`, `estimate_work_effort_hours`) VALUES
(1, 1, 1, 7),
(2, 1, 2, 6),
(3, 3, 3, 7),
(4, 4, 2, 3),
(10, 4, 3, 3),
(11, 4, 5, 4),
(40, 7, 3, 4);

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
  `task_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
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
  `task_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
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
  ADD CONSTRAINT `fk_project_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL;

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
