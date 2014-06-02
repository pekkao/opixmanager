#
# TABLE STRUCTURE FOR: item_type
#

DROP TABLE IF EXISTS item_type;

CREATE TABLE `item_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type_name` varchar(255) NOT NULL,
  `item_type_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO item_type (`id`, `item_type_name`, `item_type_description`) VALUES (1, 'Epic', NULL);
INSERT INTO item_type (`id`, `item_type_name`, `item_type_description`) VALUES (2, 'Theme', NULL);


#
# TABLE STRUCTURE FOR: language
#

DROP TABLE IF EXISTS language;

CREATE TABLE `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_short` varchar(10) DEFAULT NULL,
  `language_long` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO language (`id`, `language_short`, `language_long`) VALUES (1, 'en', 'english');
INSERT INTO language (`id`, `language_short`, `language_long`) VALUES (2, 'fi', 'finnish');


#
# TABLE STRUCTURE FOR: person
#

DROP TABLE IF EXISTS person;

CREATE TABLE `person` (
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
  KEY `fk_person_language` (`language_id`),
  CONSTRAINT `fk_person_language` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO person (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES (1, 'Testaaja', 'Tauno', NULL, '', NULL, 'taunot', 'b47d824d0c818b5dbcac089e891822c9', 1, 2);
INSERT INTO person (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES (2, 'Koodaaja ', 'Kaisa', NULL, '', NULL, 'kaisak', '4a1cb7d3c88b5cdafb219b000d455f48', 1, 2);
INSERT INTO person (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES (3, 'Aaltonen', 'Alli', 'Programmer', NULL, '1234567', 'allia', '14277cc09bf79f1197e7c9deab097827', 1, 2);
INSERT INTO person (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES (4, 'Virtanen', 'Ville', NULL, '', NULL, 'villev', '233e8d7fc551fb10bed872c2c55249b5', 2, 2);
INSERT INTO person (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES (5, 'Oppilas', 'Oili', NULL, '', NULL, 'oilio', '06827678cc6805125fcab46fb38c6e25', 1, 2);
INSERT INTO person (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES (6, 'Päivänlahti', 'Paavo', NULL, '', NULL, 'paavop', 'e74457f7a95216e389d5a41ac274e6fd', 1, 2);
INSERT INTO person (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES (8, 'admin', 'admin', 'Manager', NULL, NULL, 'admin', 'bdc8341bb7c06ca3a3e9ab7d39ecb789', 2, 1);
INSERT INTO person (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES (9, 'testi', 'testi', NULL, '', '1234567', 'testi', '1c25f83b8b5676a8ad0bd280fbfcf111', 2, 2);
INSERT INTO person (`id`, `surname`, `firstname`, `title`, `email`, `phone_number`, `user_id`, `password`, `language_id`, `account_type`) VALUES (10, 'Ääninen', 'Äijä', NULL, '', NULL, 'aijaa', '03e6bab580b3e0b2b9cbb3cc8231ac49', 2, 2);


#
# TABLE STRUCTURE FOR: status
#

DROP TABLE IF EXISTS status;

CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) NOT NULL,
  `status_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO status (`id`, `status_name`, `status_description`) VALUES (1, 'Not started', NULL);
INSERT INTO status (`id`, `status_name`, `status_description`) VALUES (2, 'In Progress', NULL);
INSERT INTO status (`id`, `status_name`, `status_description`) VALUES (3, 'Done', NULL);


#
# TABLE STRUCTURE FOR: task_type
#

DROP TABLE IF EXISTS task_type;

CREATE TABLE `task_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_type_name` varchar(255) NOT NULL,
  `task_type_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO task_type (`id`, `task_type_name`, `task_type_description`) VALUES (1, 'Design', NULL);
INSERT INTO task_type (`id`, `task_type_name`, `task_type_description`) VALUES (2, 'Coding', NULL);
INSERT INTO task_type (`id`, `task_type_name`, `task_type_description`) VALUES (3, 'Testing', NULL);


#
# TABLE STRUCTURE FOR: person_role
#

DROP TABLE IF EXISTS person_role;

CREATE TABLE `person_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `role_description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO person_role (`id`, `role_name`, `role_description`) VALUES (1, 'Member', NULL);
INSERT INTO person_role (`id`, `role_name`, `role_description`) VALUES (2, 'Scrum Master', NULL);
INSERT INTO person_role (`id`, `role_name`, `role_description`) VALUES (3, 'Project Manager', NULL);


#
# TABLE STRUCTURE FOR: customer
#

DROP TABLE IF EXISTS customer;

CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_description` varchar(1000) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `www` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO customer (`id`, `customer_name`, `customer_description`, `street_address`, `post_code`, `city`, `www`) VALUES (2, 'SoftDrink Oy', 'Limsan valmistaja', 'Koulukatu 10', '90100', 'Oulu', 'www.softdrink.fi');
INSERT INTO customer (`id`, `customer_name`, `customer_description`, `street_address`, `post_code`, `city`, `www`) VALUES (3, 'FineDoors Oy', 'Puuovia', 'Hallituskatu 5', '98100', 'Kemijärvi', 'www.finedoors.fi');
INSERT INTO customer (`id`, `customer_name`, `customer_description`, `street_address`, `post_code`, `city`, `www`) VALUES (4, 'MikkoStone', NULL, 'Aleksanterinkatu 17', '96100', 'Rovaniemi', 'www.mikkostone.fi');
INSERT INTO customer (`id`, `customer_name`, `customer_description`, `street_address`, `post_code`, `city`, `www`) VALUES (5, 'BelleVue', NULL, 'Nahkurinkatu 20', '03100', 'Nummela', 'www.bellevue.fi');
INSERT INTO customer (`id`, `customer_name`, `customer_description`, `street_address`, `post_code`, `city`, `www`) VALUES (6, 'GrafiArt', 'graafista suunnittelua', '', '', 'Iisalmi', 'www.grafiart.fi');
INSERT INTO customer (`id`, `customer_name`, `customer_description`, `street_address`, `post_code`, `city`, `www`) VALUES (8, 'FinnArt Oy', NULL, NULL, NULL, NULL, NULL);
INSERT INTO customer (`id`, `customer_name`, `customer_description`, `street_address`, `post_code`, `city`, `www`) VALUES (9, 'Elli-ääni Oy', NULL, 'Koulutie 1', '99123', 'Sodankylä', NULL);


#
# TABLE STRUCTURE FOR: contact_person
#

DROP TABLE IF EXISTS contact_person;

CREATE TABLE `contact_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contactperson_customer` (`customer_id`),
  CONSTRAINT `fk_contactperson_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (1, 'Aittomaa', 'Heikki', NULL, NULL, 'hannu@bellevue.fi', 5);
INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (2, 'Testaaja', 'Tiina', 'suunnittelija', NULL, 'tiina@finedoors.com', 3);
INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (3, 'Enola', 'Eemeli', NULL, NULL, NULL, 3);
INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (4, 'Tallaaja', 'Tauno', NULL, NULL, NULL, 6);
INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (5, 'Aitomaa', 'Antti', 'testaaja', '12345', 'antti@mikkostone.fi', 4);
INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (6, 'Aaltonen', 'Aimo', NULL, NULL, NULL, 4);
INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (7, 'Laffer', 'Larry', NULL, NULL, NULL, 2);
INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (8, 'Croft', 'Lara', NULL, NULL, NULL, 2);
INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (9, 'klcidhsl', 'klcidhsl', 'mUcjFwxnWrbrKCMBB', '89093371902', NULL, 3);
INSERT INTO contact_person (`id`, `surname`, `firstname`, `title`, `phone_number`, `email`, `customer_id`) VALUES (10, 'Virtanen', 'Ville', NULL, NULL, NULL, 5);


#
# TABLE STRUCTURE FOR: project
#

DROP TABLE IF EXISTS project;

CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `project_description` text,
  `project_start_date` date DEFAULT NULL,
  `project_end_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `project_type` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_customer` (`customer_id`),
  CONSTRAINT `fk_project_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO project (`id`, `project_name`, `project_description`, `project_start_date`, `project_end_date`, `customer_id`, `project_type`, `active`) VALUES (2, 'ShopTesting', 'Testing project of a web shop', '2012-08-20', NULL, 3, 1, 2);
INSERT INTO project (`id`, `project_name`, `project_description`, `project_start_date`, `project_end_date`, `customer_id`, `project_type`, `active`) VALUES (4, 'GrafUx', 'User experience study', '2012-09-10', '2012-12-22', 6, 2, 1);
INSERT INTO project (`id`, `project_name`, `project_description`, `project_start_date`, `project_end_date`, `customer_id`, `project_type`, `active`) VALUES (6, 'Music Club ', 'Web pages for a music club. ', '2014-01-05', '2014-07-31', 4, 2, 2);
INSERT INTO project (`id`, `project_name`, `project_description`, `project_start_date`, `project_end_date`, `customer_id`, `project_type`, `active`) VALUES (8, 'Testproject Voices', 'Something about voices and videos', '2014-04-06', '2014-05-29', 8, 2, 2);


#
# TABLE STRUCTURE FOR: project_staff
#

DROP TABLE IF EXISTS project_staff;

CREATE TABLE `project_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `person_role_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_projectstaff_project` (`project_id`),
  KEY `fk_projectstaff_person` (`person_id`),
  KEY `fk_projectstaff_personrole` (`person_role_id`),
  CONSTRAINT `fk_projectstaff_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_projectstaff_personrole` FOREIGN KEY (`person_role_id`) REFERENCES `person_role` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_projectstaff_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (1, 4, 1, 1, '2012-09-10', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (2, 4, 2, 1, '2012-09-10', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (3, 4, 6, 3, '2012-09-10', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (4, 2, 1, 1, '2012-08-20', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (5, 2, 2, 1, '2012-08-20', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (6, 2, 3, 3, '2012-08-20', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (14, 2, 4, 1, '2012-08-20', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (15, 6, 6, 1, '2013-01-31', '2014-05-04');
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (16, 6, 3, 2, '2013-01-06', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (18, 6, 1, 1, '2013-01-06', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (19, 6, 2, 1, '2013-01-06', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (22, 6, 8, 3, '2011-11-15', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (23, 2, 6, NULL, '2014-05-04', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (25, 8, 2, 1, '2014-05-11', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (26, 8, 3, 3, '2014-05-11', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (39, 8, 5, 1, '2014-04-27', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (40, 8, 9, NULL, '2014-05-04', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (42, 6, 10, 1, '2014-05-04', NULL);
INSERT INTO project_staff (`id`, `project_id`, `person_id`, `person_role_id`, `start_date`, `end_date`) VALUES (43, 2, 8, 1, '2014-05-04', NULL);


#
# TABLE STRUCTURE FOR: product_backlog
#

DROP TABLE IF EXISTS product_backlog;

CREATE TABLE `product_backlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `backlog_name` varchar(255) NOT NULL,
  `product_visio` varchar(1000) DEFAULT NULL,
  `product_current_state` varchar(1000) DEFAULT NULL,
  `product_owner` int(11) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_backlog_project` (`project_id`),
  CONSTRAINT `fk_product_backlog_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO product_backlog (`id`, `backlog_name`, `product_visio`, `product_current_state`, `product_owner`, `project_id`) VALUES (5, 'Music Club ', 'To design and implement web pages to a music club that doesn\'t have any yet.', 'Nothing has not been implemented.', 3, 6);
INSERT INTO product_backlog (`id`, `backlog_name`, `product_visio`, `product_current_state`, `product_owner`, `project_id`) VALUES (6, 'just testing', NULL, NULL, 2, 4);
INSERT INTO product_backlog (`id`, `backlog_name`, `product_visio`, `product_current_state`, `product_owner`, `project_id`) VALUES (7, 'Test backlog', 'Just testing this application', 'Nothing has been done yet', 3, 8);


#
# TABLE STRUCTURE FOR: product_backlog_item
#

DROP TABLE IF EXISTS product_backlog_item;

CREATE TABLE `product_backlog_item` (
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
  KEY `fk_product_backlog_item_status` (`status_id`),
  CONSTRAINT `fk_product_backlog_item_item_type` FOREIGN KEY (`item_type_id`) REFERENCES `item_type` (`id`),
  CONSTRAINT `fk_product_backlog_item_product_backlog` FOREIGN KEY (`product_backlog_id`) REFERENCES `product_backlog` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_product_backlog_item_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO product_backlog_item (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES (6, 'Find a web hotel', 'As an site owner I want to have reliable but not very expensive web hotel. ', 1, 10, NULL, 15, 'The web hotel have been chosen.', NULL, 5, 1, 1, NULL, '2013-01-06');
INSERT INTO product_backlog_item (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES (7, 'Contents of a site', 'As a person interested in the music I need to find out ....', 1, 10, NULL, NULL, 'The mid map of the contents site has been created.', NULL, 5, 1, 1, NULL, '2013-01-06');
INSERT INTO product_backlog_item (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES (8, 'The outlook of the site', 'As a user when scanning the site pages I want to see very easily the data blocks in the pages.', 1, 10, NULL, NULL, 'The fonts, colors and images of the site has been defined. ', NULL, 5, 1, 1, NULL, '2013-01-13');
INSERT INTO product_backlog_item (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES (9, 'Item1', 'As a user I want hear good sounds so that ...', NULL, NULL, NULL, 10, NULL, NULL, 7, 1, 1, NULL, '2014-05-11');
INSERT INTO product_backlog_item (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES (10, 'Item2', 'As a user want to XXXXXXXXXXX so that YYYYYYYYYYYYYY', NULL, NULL, NULL, 20, NULL, NULL, 7, 1, 1, NULL, '2014-05-12');
INSERT INTO product_backlog_item (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES (11, 'item3', 'Third user story in the backlog', NULL, NULL, NULL, 30, NULL, NULL, 7, 1, 1, NULL, '2014-05-13');
INSERT INTO product_backlog_item (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES (12, 'item4', 'Fourth user story in the backlog', NULL, NULL, NULL, 40, NULL, NULL, 7, 1, 1, NULL, '2014-05-13');
INSERT INTO product_backlog_item (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES (13, 'Item5', 'Fifth user story in the backlog', NULL, NULL, NULL, 5, NULL, NULL, 7, 1, 1, NULL, '2014-05-18');
INSERT INTO product_backlog_item (`id`, `item_name`, `item_description`, `priority`, `business_value`, `estimate_points`, `effort_estimate_hours`, `acceptance_criteria`, `release_target`, `product_backlog_id`, `item_type_id`, `status_id`, `is_part_of_id`, `start_date`) VALUES (14, 'item6', 'Sixth user story in the backlog', NULL, NULL, NULL, 60, NULL, NULL, 7, 1, 1, NULL, '2014-05-04');


#
# TABLE STRUCTURE FOR: sprint_backlog
#

DROP TABLE IF EXISTS sprint_backlog;

CREATE TABLE `sprint_backlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_backlog_id` int(11) NOT NULL,
  `sprint_name` varchar(255) NOT NULL,
  `sprint_description` varchar(1000) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_backlog_product_backlog` (`product_backlog_id`),
  CONSTRAINT `fk_sprint_backlog_product_backlog` FOREIGN KEY (`product_backlog_id`) REFERENCES `product_backlog` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO sprint_backlog (`id`, `product_backlog_id`, `sprint_name`, `sprint_description`, `start_date`, `end_date`) VALUES (2, 5, 'The contents and the outlook of the site', 'The contents, navigation and outlook of the site.', '2014-06-02', '2014-06-30');
INSERT INTO sprint_backlog (`id`, `product_backlog_id`, `sprint_name`, `sprint_description`, `start_date`, `end_date`) VALUES (10, 7, 'First sprint', NULL, '2014-05-16', '2014-05-29');
INSERT INTO sprint_backlog (`id`, `product_backlog_id`, `sprint_name`, `sprint_description`, `start_date`, `end_date`) VALUES (17, 7, 'Second sprint', NULL, '2014-05-04', '2014-05-16');


#
# TABLE STRUCTURE FOR: sprint_backlog_item
#

DROP TABLE IF EXISTS sprint_backlog_item;

CREATE TABLE `sprint_backlog_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sprint_backlog_id` int(11) NOT NULL,
  `product_backlog_item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_backlog_item_sprint_backlog` (`sprint_backlog_id`),
  KEY `fk_sprint_backlog_item_product_backlog_item` (`product_backlog_item_id`),
  CONSTRAINT `fk_sprint_backlog_item_product_backlog_item` FOREIGN KEY (`product_backlog_item_id`) REFERENCES `product_backlog_item` (`id`),
  CONSTRAINT `fk_sprint_backlog_item_sprint_backlog` FOREIGN KEY (`sprint_backlog_id`) REFERENCES `sprint_backlog` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO sprint_backlog_item (`id`, `sprint_backlog_id`, `product_backlog_item_id`) VALUES (1, 2, 7);
INSERT INTO sprint_backlog_item (`id`, `sprint_backlog_id`, `product_backlog_item_id`) VALUES (2, 2, 8);
INSERT INTO sprint_backlog_item (`id`, `sprint_backlog_id`, `product_backlog_item_id`) VALUES (3, 10, 9);
INSERT INTO sprint_backlog_item (`id`, `sprint_backlog_id`, `product_backlog_item_id`) VALUES (4, 10, 10);
INSERT INTO sprint_backlog_item (`id`, `sprint_backlog_id`, `product_backlog_item_id`) VALUES (6, 10, 12);
INSERT INTO sprint_backlog_item (`id`, `sprint_backlog_id`, `product_backlog_item_id`) VALUES (7, 17, 11);
INSERT INTO sprint_backlog_item (`id`, `sprint_backlog_id`, `product_backlog_item_id`) VALUES (8, 17, 13);


#
# TABLE STRUCTURE FOR: sprint_task
#

DROP TABLE IF EXISTS sprint_task;

CREATE TABLE `sprint_task` (
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
  KEY `fk_sprint_task_task_type` (`task_type_id`),
  CONSTRAINT `fk_sprint_task_sprint_backlog_item` FOREIGN KEY (`sprint_backlog_item_id`) REFERENCES `sprint_backlog_item` (`id`),
  CONSTRAINT `fk_sprint_task_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_sprint_task_task_type` FOREIGN KEY (`task_type_id`) REFERENCES `task_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO sprint_task (`id`, `task_name`, `task_description`, `effort_estimate_hours`, `status_id`, `sprint_backlog_item_id`, `task_type_id`) VALUES (1, 'Contents of the site', 'Create a mind map of the site, write notes about each node of the mind map', 15, 1, 1, 1);
INSERT INTO sprint_task (`id`, `task_name`, `task_description`, `effort_estimate_hours`, `status_id`, `sprint_backlog_item_id`, `task_type_id`) VALUES (2, 'Fonts & colors of the site', 'Create at least three different outlooks for the site to choose from.', 20, 1, 2, 1);
INSERT INTO sprint_task (`id`, `task_name`, `task_description`, `effort_estimate_hours`, `status_id`, `sprint_backlog_item_id`, `task_type_id`) VALUES (3, 'Images of the site', 'Collect possible images (CC licensed). ', 7, 1, 2, 1);
INSERT INTO sprint_task (`id`, `task_name`, `task_description`, `effort_estimate_hours`, `status_id`, `sprint_backlog_item_id`, `task_type_id`) VALUES (4, 'item1, task1', NULL, 10, 1, 3, 1);
INSERT INTO sprint_task (`id`, `task_name`, `task_description`, `effort_estimate_hours`, `status_id`, `sprint_backlog_item_id`, `task_type_id`) VALUES (5, 'item1, task2', NULL, 9, 1, 3, 1);
INSERT INTO sprint_task (`id`, `task_name`, `task_description`, `effort_estimate_hours`, `status_id`, `sprint_backlog_item_id`, `task_type_id`) VALUES (7, 'aaaaaaaa', NULL, 12, 1, 3, 1);


#
# TABLE STRUCTURE FOR: sprint_task_person
#

DROP TABLE IF EXISTS sprint_task_person;

CREATE TABLE `sprint_task_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sprint_task_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `estimate_work_effort_hours` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_task_person_sprint_task` (`sprint_task_id`),
  KEY `fk_sprint_task_person_person` (`person_id`),
  CONSTRAINT `fk_sprint_task_person_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  CONSTRAINT `fk_sprint_task_person_sprint_task` FOREIGN KEY (`sprint_task_id`) REFERENCES `sprint_task` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

INSERT INTO sprint_task_person (`id`, `sprint_task_id`, `person_id`, `estimate_work_effort_hours`) VALUES (1, 1, 1, 7);
INSERT INTO sprint_task_person (`id`, `sprint_task_id`, `person_id`, `estimate_work_effort_hours`) VALUES (2, 1, 2, 6);
INSERT INTO sprint_task_person (`id`, `sprint_task_id`, `person_id`, `estimate_work_effort_hours`) VALUES (3, 3, 3, 7);
INSERT INTO sprint_task_person (`id`, `sprint_task_id`, `person_id`, `estimate_work_effort_hours`) VALUES (4, 4, 2, 3);
INSERT INTO sprint_task_person (`id`, `sprint_task_id`, `person_id`, `estimate_work_effort_hours`) VALUES (10, 4, 3, 3);
INSERT INTO sprint_task_person (`id`, `sprint_task_id`, `person_id`, `estimate_work_effort_hours`) VALUES (11, 4, 5, 4);
INSERT INTO sprint_task_person (`id`, `sprint_task_id`, `person_id`, `estimate_work_effort_hours`) VALUES (40, 7, 3, 4);


#
# TABLE STRUCTURE FOR: sprint_work
#

DROP TABLE IF EXISTS sprint_work;

CREATE TABLE `sprint_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_date` date NOT NULL,
  `work_done_hours` decimal(5,1) NOT NULL,
  `work_remaining_hours` decimal(5,1) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `sprint_task_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sprint_work_sprint_task` (`sprint_task_id`),
  KEY `fk_sprint_work_person` (`person_id`),
  CONSTRAINT `fk_sprint_work_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  CONSTRAINT `fk_sprint_work_sprint_task` FOREIGN KEY (`sprint_task_id`) REFERENCES `sprint_task` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: project_period
#

DROP TABLE IF EXISTS project_period;

CREATE TABLE `project_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period_name` varchar(250) NOT NULL,
  `period_description` varchar(1000) DEFAULT NULL,
  `period_start_date` date NOT NULL,
  `period_end_date` date NOT NULL,
  `milestone` tinyint(4) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project` (`project_id`),
  CONSTRAINT `fk_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO project_period (`id`, `period_name`, `period_description`, `period_start_date`, `period_end_date`, `milestone`, `project_id`) VALUES (1, 'Period 1', 'something to do in the first period', '2013-01-06', '2013-01-17', 1, 2);


#
# TABLE STRUCTURE FOR: task
#

DROP TABLE IF EXISTS task;

CREATE TABLE `task` (
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
  KEY `fk_status` (`status_id`),
  CONSTRAINT `fk_project_period` FOREIGN KEY (`project_period_id`) REFERENCES `project_period` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_task_type` FOREIGN KEY (`task_type_id`) REFERENCES `task_type` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO task (`id`, `task_name`, `task_description`, `task_start_date`, `task_end_date`, `effort_estimate_hours`, `project_period_id`, `task_type_id`, `status_id`) VALUES (1, 'Task1', 'task1, task1', '2013-01-06', '2013-01-10', 10, 1, 1, 1);
INSERT INTO task (`id`, `task_name`, `task_description`, `task_start_date`, `task_end_date`, `effort_estimate_hours`, `project_period_id`, `task_type_id`, `status_id`) VALUES (2, 'Task2', 'task2, task2, task2', '2013-01-13', '2013-01-15', 4, 1, 1, 1);


#
# TABLE STRUCTURE FOR: task_person
#

DROP TABLE IF EXISTS task_person;

CREATE TABLE `task_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `effort_estimate_hours` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_person_task` (`task_id`),
  KEY `fk_task_person_person` (`person_id`),
  CONSTRAINT `fk_task_person_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  CONSTRAINT `fk_task_person_task` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO task_person (`id`, `start_date`, `end_date`, `effort_estimate_hours`, `task_id`, `person_id`) VALUES (1, '2013-01-06', '2013-01-10', 3, 1, 1);
INSERT INTO task_person (`id`, `start_date`, `end_date`, `effort_estimate_hours`, `task_id`, `person_id`) VALUES (2, '2013-01-06', '2013-01-10', 2, 1, 2);
INSERT INTO task_person (`id`, `start_date`, `end_date`, `effort_estimate_hours`, `task_id`, `person_id`) VALUES (3, '2013-01-13', '2013-01-15', 2, 2, 3);
INSERT INTO task_person (`id`, `start_date`, `end_date`, `effort_estimate_hours`, `task_id`, `person_id`) VALUES (4, '2013-01-13', '2013-01-15', 2, 2, 4);


#
# TABLE STRUCTURE FOR: task_work
#

DROP TABLE IF EXISTS task_work;

CREATE TABLE `task_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_hours` decimal(5,1) NOT NULL,
  `work_date` date NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_work_task` (`task_id`),
  KEY `fk_task_work_person` (`person_id`),
  CONSTRAINT `fk_task_work_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  CONSTRAINT `fk_task_work_task` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

