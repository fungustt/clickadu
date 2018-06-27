CREATE DATABASE `clickadu` CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE `clickadu`.`data` (`date` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `a` decimal(12,2) NOT NULL, `b` decimal(12,2) NOT NULL, `c` decimal(12,2) NOT NULL) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
CREATE TABLE `clickadu`.`aggregation` (`date` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `a` decimal(12,2) NOT NULL, `b` decimal(12,2) NOT NULL, `c` decimal(12,2) NOT NULL, unique key(`date`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
