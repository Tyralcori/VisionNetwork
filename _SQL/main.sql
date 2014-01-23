-- CREATE THE DATABASE
CREATE DATABASE IF NOT EXISTS vision;
-- USE THE DATABASE
USE vision;

-- LOGIN TABLE 2014/01/20
CREATE TABLE IF NOT EXISTS login (
`id` int(5) AUTO_INCREMENT,
`email` varchar(255) NOT NULL,
`password` varchar(255) NOT NULL,
`username` varchar(255) NOT NULL,
`firstLogin` datetime,
`lastLogin` datetime,
`banned` int(1) NOT NULL DEFAULT 0,
`bannedUnitl` datetime,
`bannedReason` varchar(500),
`banCounter` int(5),
`globalPermission` int(5),
PRIMARY KEY(id)
);

-- CHANNEL TABLE 2013/11/08
CREATE TABLE IF NOT EXISTS channels (
`id` int(10) AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`topic` varchar(255),
`slots` int(10) DEFAULT 50,
`joinlevel` int(10) DEFAULT 0,
`writelevel` int(10) DEFAULT 0,
PRIMARY KEY(`id`)
);

-- CONNECTION TABLE 2013/11/08
CREATE TABLE IF NOT EXISTS connections (
`id` int(10) AUTO_INCREMENT,
`userID` int(5) NOT NULL,
`channelID` int(10) NOT NULL,
`lastActivity` datetime,
PRIMARY KEY(`id`)
);

-- PERMISSION TABLE 2013/11/08
CREATE TABLE IF NOT EXISTS permissions (
`id` int(10) AUTO_INCREMENT,
`userID` int(5) NOT NULL,
`channelID` int(10) NOT NULL,
`permissionLevel` int(5) DEFAULT 1,
PRIMARY KEY(`id`)
);

-- MESSAGE TABLE 2013/11/12
CREATE TABLE IF NOT EXISTS messages (
`id` int(10) AUTO_INCREMENT,
`userID` int(5) NOT NULL,
`channelID` int(10) NOT NULL,
`message` varchar(500) NOT NULL,
`timestamp` datetime,
PRIMARY KEY(`id`)
);

-- PROFILE TABLE 2014/01/20
CREATE TABLE IF NOT EXISTS profiles (
`id` int(5) AUTO_INCREMENT,
`userID` int(5) NOT NULL,
`bio` text,
`birthdate` datetime,
`avatar` varchar(255),
`visits` int(10),
`realName` varchar(255),
PRIMARY KEY(id)
);

-- REDDBOX TABLE 2014/01/23
CREATE TABLE IF NOT EXISTS redbox (
`id` int(5) AUTO_INCREMENT,
`timeLoad` varchar(255) NOT NULL,
`user` varchar(255) NOT NULL,
`userAgent` varchar(255) NOT NULL,
`ip` varchar(50) NOT NULL,
`time` datetime,
`site` varchar(100),
`port` int(3) NOT NULL DEFAULT 80,
`status` int(5) NOT NULL DEFAULT 200,
PRIMARY KEY(id)
);