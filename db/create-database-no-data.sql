-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2014 at 09:05 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;


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
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_short` varchar(10) DEFAULT NULL,
  `language_long` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


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
-- Table structure for table `person_role`
--

CREATE TABLE IF NOT EXISTS `person_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `role_description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


--
-- Table structure for table `product_backlog`
--

CREATE TABLE IF NOT EXISTS `product_backlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `backlog_name` varchar(255) NOT NULL,
  `product_visio` varchar(1000) DEFAULT NULL,
  `product_current_state` varchar(1000) DEFAULT NULL,
  `product_owner` int(11) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_backlog_project` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;


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
-- Table structure for table `task_type`
--

CREATE TABLE IF NOT EXISTS `task_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_type_name` varchar(255) NOT NULL,
  `task_type_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


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
