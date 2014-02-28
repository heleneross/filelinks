CREATE TABLE IF NOT EXISTS `#__filelinks` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`catid` INT(11)  NOT NULL ,
`title` VARCHAR(250)  NOT NULL ,
`url` VARCHAR(255)  NOT NULL ,
`description` TEXT NOT NULL ,
`hits` VARCHAR(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`created` DATETIME NOT NULL ,
`access` INT(11)  NOT NULL ,
`language` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

