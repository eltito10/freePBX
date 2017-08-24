--
-- Table structure for table `call_cost`
--

CREATE TABLE `call_cost` (
  `cdr_id` varchar(32) NOT NULL default '' COMMENT 'uniqueid in the asteriskcdrdb''s cdr table',
  `rate_id` int(10) unsigned NOT NULL default '0' COMMENT 'id in call_rate table',
  `cost` float NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `call_rate`
--

CREATE TABLE `call_rate` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `accountcode` varchar(20) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `begin` datetime NOT NULL default '1900-01-01 00:00:00',
  `end` datetime NOT NULL default '2100-01-01 00:00:00',
  `trunk` varchar(20) NOT NULL default '',
  `zone_id` smallint(6) unsigned NOT NULL default '0' COMMENT 'id in call_zone table',
  `rate` float NOT NULL default '0',
  `min_duration` smallint(6) unsigned NOT NULL default '0',
  `block_size` smallint(6) unsigned NOT NULL default '1',
  `connect` float NOT NULL default '0',
  `disconnect` float NOT NULL default '0',
  `schedule_id` smallint(6) unsigned NOT NULL default '0' COMMENT 'id in call_schedule table',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `call_schedule`
--

CREATE TABLE `call_schedule` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `call_schedule_part`
--

CREATE TABLE `call_schedule_part` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',
  `schedule_id` smallint(6) unsigned NOT NULL default '0' COMMENT 'id in the call_schedule table',
  `weekday` tinyint(3) NOT NULL default '-1',
  `begin` time NOT NULL default '00:00:00',
  `end` time NOT NULL default '23:59:59',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `call_zone`
--

CREATE TABLE `call_zone` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned default '0' COMMENT 'id in the call_zone_group table',
  `name` varchar(40) NOT NULL default '',
  `pattern` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `call_zone_group`
--

CREATE TABLE `call_zone_group` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `asteriskcdrdb`.`cdrcost`
--

CREATE TABLE `asteriskcdrdb`.`cdrcost` (
  `uniqueid` VARCHAR(32)  NOT NULL COMMENT 'uniqueid in the cdr table',
  `rate_id` INT UNSIGNED NOT NULL COMMENT 'id in call_rate table',
  `cost` FLOAT  NOT NULL
) ENGINE = MYISAM;
