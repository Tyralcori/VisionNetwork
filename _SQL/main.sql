-- CREATE THE DATABASE
CREATE DATABASE IF NOT EXISTS vision;
-- USE THE DATABASE
USE vision;

-- LOGIN TABLE 2013/11/08
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
PRIMARY KEY(id)
);

