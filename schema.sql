
DROP TABLE IF EXISTS `announcements`;
DROP TABLE IF EXISTS `applications`;
DROP TABLE IF EXISTS `attacklogs`;
DROP TABLE IF EXISTS `bankxferlogs`;
DROP TABLE IF EXISTS `blacklist`;
DROP TABLE IF EXISTS `cashxferlogs`;
DROP TABLE IF EXISTS `challengebots`;
DROP TABLE IF EXISTS `challengesbeaten`;
DROP TABLE IF EXISTS `cities`;
DROP TABLE IF EXISTS `contactlist`;
DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `coursesdone`;
DROP TABLE IF EXISTS `crimegroups`;
DROP TABLE IF EXISTS `crimes`;
DROP TABLE IF EXISTS `crystalmarket`;
DROP TABLE IF EXISTS `crystalxferlogs`;
DROP TABLE IF EXISTS `dps_accepted`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `fedjail`;
DROP TABLE IF EXISTS `forum_forums`;
DROP TABLE IF EXISTS `forum_posts`;
DROP TABLE IF EXISTS `forum_topics`;
DROP TABLE IF EXISTS `friendslist`;
DROP TABLE IF EXISTS `gangevents`;
DROP TABLE IF EXISTS `gangs`;
DROP TABLE IF EXISTS `gangwars`;
DROP TABLE IF EXISTS `houses`;
DROP TABLE IF EXISTS `imarketaddlogs`;
DROP TABLE IF EXISTS `imbuylogs`;
DROP TABLE IF EXISTS `imremovelogs`;
DROP TABLE IF EXISTS `inventory`;
DROP TABLE IF EXISTS `itembuylogs`;
DROP TABLE IF EXISTS `itemmarket`;
DROP TABLE IF EXISTS `items`;
DROP TABLE IF EXISTS `itemselllogs`;
DROP TABLE IF EXISTS `itemtypes`;
DROP TABLE IF EXISTS `itemxferlogs`;
DROP TABLE IF EXISTS `jaillogs`;
DROP TABLE IF EXISTS `jobranks`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `mail`;
DROP TABLE IF EXISTS `oclogs`;
DROP TABLE IF EXISTS `orgcrimes`;
DROP TABLE IF EXISTS `papercontent`;
DROP TABLE IF EXISTS `polls`;
DROP TABLE IF EXISTS `preports`;
DROP TABLE IF EXISTS `referals`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `shopitems`;
DROP TABLE IF EXISTS `shops`;
DROP TABLE IF EXISTS `stafflog`;
DROP TABLE IF EXISTS `staffnotelogs`;
DROP TABLE IF EXISTS `surrenders`;
DROP TABLE IF EXISTS `unjaillogs`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `userstats`;
DROP TABLE IF EXISTS `votes`;
DROP TABLE IF EXISTS `willps_accepted`;

CREATE TABLE `announcements` (
  `a_text` text NOT NULL,
  `a_time` int(11) NOT NULL default '0'
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `applications` (
  `appID` int(11) NOT NULL auto_increment,
  `appUSER` int(11) NOT NULL default '0',
  `appGANG` int(11) NOT NULL default '0',
  `appTEXT` text NOT NULL,
  PRIMARY KEY  (`appID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `attacklogs` (
  `log_id` int(11) NOT NULL auto_increment,
  `attacker` int(11) NOT NULL default '0',
  `attacked` int(11) NOT NULL default '0',
  `result` enum('won','lost') NOT NULL default 'won',
  `time` int(11) NOT NULL default '0',
  `stole` int(11) NOT NULL default '0',
  `attacklog` longtext NOT NULL,
  PRIMARY KEY  (`log_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `bankxferlogs` (
  `cxID` int(11) NOT NULL auto_increment,
  `cxFROM` int(11) NOT NULL default '0',
  `cxTO` int(11) NOT NULL default '0',
  `cxAMOUNT` int(11) NOT NULL default '0',
  `cxTIME` int(11) NOT NULL default '0',
  `cxFROMIP` varchar(15) NOT NULL default '127.0.0.1',
  `cxTOIP` varchar(15) NOT NULL default '127.0.0.1',
  `cxBANK` enum('bank','cyber') NOT NULL default 'bank',
  PRIMARY KEY  (`cxID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `blacklist` (
  `bl_ID` int(11) NOT NULL auto_increment,
  `bl_ADDER` int(11) NOT NULL default '0',
  `bl_ADDED` int(11) NOT NULL default '0',
  `bl_COMMENT` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`bl_ID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cashxferlogs` (
  `cxID` int(11) NOT NULL auto_increment,
  `cxFROM` int(11) NOT NULL default '0',
  `cxTO` int(11) NOT NULL default '0',
  `cxAMOUNT` int(11) NOT NULL default '0',
  `cxTIME` int(11) NOT NULL default '0',
  `cxFROMIP` varchar(15) NOT NULL default '127.0.0.1',
  `cxTOIP` varchar(15) NOT NULL default '127.0.0.1',
  PRIMARY KEY  (`cxID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `challengebots` (
  `cb_npcid` int(11) NOT NULL default '0',
  `cb_money` int(11) NOT NULL default '0'
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `challengesbeaten` (
  `userid` int(11) NOT NULL default '0',
  `npcid` int(11) NOT NULL default '0'
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cities` (
  `cityid` int(11) NOT NULL auto_increment,
  `cityname` varchar(255) NOT NULL default '',
  `citydesc` longtext NOT NULL,
  `cityminlevel` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cityid`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cities` (`cityid`, `cityname`, `citydesc`, `cityminlevel`)
  VALUES
    (1, 'London', 'A standard city added to start you off', 1);

CREATE TABLE `contactlist` (
  `cl_ID` int(11) NOT NULL auto_increment,
  `cl_ADDER` int(11) NOT NULL default '0',
  `cl_ADDED` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cl_ID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `courses` (
  `crID` int(11) NOT NULL auto_increment,
  `crNAME` varchar(255) NOT NULL default '',
  `crDESC` text NOT NULL,
  `crCOST` int(11) NOT NULL default '0',
  `crENERGY` int(11) NOT NULL default '0',
  `crDAYS` int(11) NOT NULL default '0',
  `crSTR` int(11) NOT NULL default '0',
  `crGUARD` int(11) NOT NULL default '0',
  `crLABOUR` int(11) NOT NULL default '0',
  `crAGIL` int(11) NOT NULL default '0',
  `crIQ` int(11) NOT NULL default '0',
  PRIMARY KEY  (`crID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `coursesdone` (
  `userid` int(11) NOT NULL default '0',
  `courseid` int(11) NOT NULL default '0'
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `crimegroups` (
  `cgID` int(11) NOT NULL auto_increment,
  `cgNAME` varchar(255) NOT NULL default '',
  `cgORDER` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cgID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `crimes` (
  `crimeID` int(11) NOT NULL auto_increment,
  `crimeNAME` varchar(255) NOT NULL default '',
  `crimeBRAVE` int(11) NOT NULL default '0',
  `crimePERCFORM` text NOT NULL,
  `crimeSUCCESSMUNY` int(11) NOT NULL default '0',
  `crimeSUCCESSCRYS` int(11) NOT NULL default '0',
  `crimeSUCCESSITEM` int(11) NOT NULL default '0',
  `crimeGROUP` int(11) NOT NULL default '0',
  `crimeITEXT` text NOT NULL,
  `crimeSTEXT` text NOT NULL,
  `crimeFTEXT` text NOT NULL,
  `crimeJTEXT` text NOT NULL,
  `crimeJAILTIME` int(10) NOT NULL default '0',
  `crimeJREASON` varchar(255) NOT NULL default '',
  `crimeXP` int(11) NOT NULL default '0',
  PRIMARY KEY  (`crimeID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `crystalmarket` (
  `cmID` int(11) NOT NULL auto_increment,
  `cmQTY` int(11) NOT NULL default '0',
  `cmADDER` int(11) NOT NULL default '0',
  `cmPRICE` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cmID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `crystalxferlogs` (
  `cxID` int(11) NOT NULL auto_increment,
  `cxFROM` int(11) NOT NULL default '0',
  `cxTO` int(11) NOT NULL default '0',
  `cxAMOUNT` int(11) NOT NULL default '0',
  `cxTIME` int(11) NOT NULL default '0',
  `cxFROMIP` varchar(15) NOT NULL default '127.0.0.1',
  `cxTOIP` varchar(15) NOT NULL default '127.0.0.1',
  PRIMARY KEY  (`cxID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `dps_accepted` (
  `dpID` int(11) NOT NULL auto_increment,
  `dpBUYER` int(11) NOT NULL default '0',
  `dpFOR` int(11) NOT NULL default '0',
  `dpTYPE` varchar(255) NOT NULL default '',
  `dpTIME` int(11) NOT NULL default '0',
  `dpTXN` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`dpID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `events` (
  `evID` int(11) NOT NULL auto_increment,
  `evUSER` int(11) NOT NULL default '0',
  `evTIME` int(11) NOT NULL default '0',
  `evREAD` int(11) NOT NULL default '0',
  `evTEXT` text NOT NULL,
  PRIMARY KEY  (`evID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `fedjail` (
  `fed_id` int(11) NOT NULL auto_increment,
  `fed_userid` int(11) NOT NULL default '0',
  `fed_days` int(11) NOT NULL default '0',
  `fed_jailedby` int(11) NOT NULL default '0',
  `fed_reason` text NOT NULL,
  PRIMARY KEY  (`fed_id`),
  UNIQUE (`fed_userid`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `forum_forums` (
  `ff_id` int(11) NOT NULL auto_increment,
  `ff_name` varchar(255) NOT NULL default '',
  `ff_desc` varchar(255) NOT NULL default '',
  `ff_posts` int(11) NOT NULL default '0',
  `ff_topics` int(11) NOT NULL default '0',
  `ff_lp_time` int(11) NOT NULL default '0',
  `ff_lp_poster_id` int(11) NOT NULL default '0',
  `ff_lp_poster_name` text NOT NULL,
  `ff_lp_t_id` int(11) NOT NULL default '0',
  `ff_lp_t_name` varchar(255) NOT NULL default '',
  `ff_auth` enum('public','gang','staff') NOT NULL default 'public',
  `ff_owner` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ff_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `forum_posts` (
  `fp_id` int(11) NOT NULL auto_increment,
  `fp_topic_id` int(11) NOT NULL default '0',
  `fp_forum_id` int(11) NOT NULL default '0',
  `fp_poster_id` int(11) NOT NULL default '0',
  `fp_poster_name` text NOT NULL,
  `fp_time` int(11) NOT NULL default '0',
  `fp_subject` varchar(255) NOT NULL default '',
  `fp_text` text NOT NULL,
  `fp_editor_id` int(11) NOT NULL default '0',
  `fp_editor_name` text NOT NULL,
  `fp_editor_time` int(11) NOT NULL default '0',
  `fp_edit_count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fp_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `forum_topics` (
  `ft_id` int(11) NOT NULL auto_increment,
  `ft_forum_id` int(11) NOT NULL default '0',
  `ft_name` varchar(150) NOT NULL default '',
  `ft_desc` varchar(255) NOT NULL default '',
  `ft_posts` int(11) NOT NULL default '0',
  `ft_owner_id` int(11) NOT NULL default '0',
  `ft_owner_name` text NOT NULL,
  `ft_start_time` int(11) NOT NULL default '0',
  `ft_last_id` int(11) NOT NULL default '0',
  `ft_last_name` text NOT NULL,
  `ft_last_time` int(11) NOT NULL default '0',
  `ft_pinned` tinyint(4) NOT NULL default '0',
  `ft_locked` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ft_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `friendslist` (
  `fl_ID` int(11) NOT NULL auto_increment,
  `fl_ADDER` int(11) NOT NULL default '0',
  `fl_ADDED` int(11) NOT NULL default '0',
  `fl_COMMENT` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`fl_ID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `gangevents` (
  `gevID` int(11) NOT NULL auto_increment,
  `gevGANG` int(11) NOT NULL default '0',
  `gevTIME` int(11) NOT NULL default '0',
  `gevTEXT` text NOT NULL,
  PRIMARY KEY  (`gevID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `gangs` (
  `gangID` int(11) NOT NULL auto_increment,
  `gangNAME` varchar(255) NOT NULL default '',
  `gangDESC` text NOT NULL,
  `gangPREF` varchar(12) NOT NULL default '',
  `gangSUFF` varchar(12) NOT NULL default '',
  `gangMONEY` int(11) NOT NULL default '0',
  `gangCRYSTALS` int(11) NOT NULL default '0',
  `gangRESPECT` int(11) NOT NULL default '0',
  `gangPRESIDENT` int(11) NOT NULL default '0',
  `gangVICEPRES` int(11) NOT NULL default '0',
  `gangCAPACITY` int(11) NOT NULL default '0',
  `gangCRIME` int(11) NOT NULL default '0',
  `gangCHOURS` int(11) NOT NULL default '0',
  `gangAMENT` longtext NOT NULL,
  PRIMARY KEY  (`gangID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `gangwars` (
  `warID` int(11) NOT NULL auto_increment,
  `warDECLARER` int(11) NOT NULL default '0',
  `warDECLARED` int(11) NOT NULL default '0',
  `warTIME` int(11) NOT NULL default '0',
  PRIMARY KEY  (`warID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `houses` (
  `hID` int(11) NOT NULL auto_increment,
  `hNAME` varchar(255) NOT NULL default '',
  `hPRICE` int(11) NOT NULL default '0',
  `hWILL` int(11) NOT NULL default '0',
  PRIMARY KEY  (`hID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `houses` (`hID`, `hNAME`, `hPRICE`, `hWILL`)
  VALUES
    (1, 'Default House', 0, 100);

CREATE TABLE `imarketaddlogs` (
  `imaID` int(11) NOT NULL auto_increment,
  `imaITEM` int(11) NOT NULL default '0',
  `imaPRICE` int(11) NOT NULL default '0',
  `imaINVID` int(11) NOT NULL default '0',
  `imaADDER` int(11) NOT NULL default '0',
  `imaTIME` int(11) NOT NULL default '0',
  `imaCONTENT` text NOT NULL,
  PRIMARY KEY  (`imaID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `imbuylogs` (
  `imbID` int(11) NOT NULL auto_increment,
  `imbITEM` int(11) NOT NULL default '0',
  `imbADDER` int(11) NOT NULL default '0',
  `imbBUYER` int(11) NOT NULL default '0',
  `imbPRICE` int(11) NOT NULL default '0',
  `imbIMID` int(11) NOT NULL default '0',
  `imbINVID` int(11) NOT NULL default '0',
  `imbTIME` int(11) NOT NULL default '0',
  `imbCONTENT` text NOT NULL,
  PRIMARY KEY  (`imbID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `imremovelogs` (
  `imrID` int(11) NOT NULL auto_increment,
  `imrITEM` int(11) NOT NULL default '0',
  `imrADDER` int(11) NOT NULL default '0',
  `imrREMOVER` int(11) NOT NULL default '0',
  `imrIMID` int(11) NOT NULL default '0',
  `imrINVID` int(11) NOT NULL default '0',
  `imrTIME` int(11) NOT NULL default '0',
  `imrCONTENT` text NOT NULL,
  PRIMARY KEY  (`imrID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `inventory` (
  `inv_id` int(11) NOT NULL auto_increment,
  `inv_itemid` int(11) NOT NULL default '0',
  `inv_userid` int(11) NOT NULL default '0',
  `inv_qty` int(11) NOT NULL default '0',
  PRIMARY KEY  (`inv_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `itembuylogs` (
  `ibID` int(11) NOT NULL auto_increment,
  `ibUSER` int(11) NOT NULL default '0',
  `ibITEM` int(11) NOT NULL default '0',
  `ibTOTALPRICE` int(11) NOT NULL default '0',
  `ibQTY` int(11) NOT NULL default '0',
  `ibTIME` int(11) NOT NULL default '0',
  `ibCONTENT` text NOT NULL,
  PRIMARY KEY  (`ibID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `itemmarket` (
  `imID` int(11) NOT NULL auto_increment,
  `imITEM` int(11) NOT NULL default '0',
  `imADDER` int(11) NOT NULL default '0',
  `imPRICE` int(11) NOT NULL default '0',
  `imCURRENCY` enum('money','crystals') NOT NULL default 'money',
  `imQTY` int(11) NOT NULL default '0',
  PRIMARY KEY  (`imID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `items` (
  `itmid` int(11) NOT NULL auto_increment,
  `itmtype` int(11) NOT NULL default '0',
  `itmname` varchar(255) NOT NULL default '',
  `itmdesc` text NOT NULL,
  `itmbuyprice` int(11) NOT NULL default '0',
  `itmsellprice` int(11) NOT NULL default '0',
  `itmbuyable` int(11) NOT NULL default '0',
  `effect1_on` tinyint(4) NOT NULL default '0',
  `effect1` text NOT NULL,
  `effect2_on` tinyint(4) NOT NULL default '0',
  `effect2` text NOT NULL,
  `effect3_on` tinyint(4) NOT NULL default '0',
  `effect3` text NOT NULL,
  `weapon` int(11) NOT NULL default '0',
  `armor` int(11) NOT NULL default '0',
  PRIMARY KEY  (`itmid`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `itemselllogs` (
  `isID` int(11) NOT NULL auto_increment,
  `isUSER` int(11) NOT NULL default '0',
  `isITEM` int(11) NOT NULL default '0',
  `isTOTALPRICE` int(11) NOT NULL default '0',
  `isQTY` int(11) NOT NULL default '0',
  `isTIME` int(11) NOT NULL default '0',
  `isCONTENT` text NOT NULL,
  PRIMARY KEY  (`isID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `itemtypes` (
  `itmtypeid` int(11) NOT NULL auto_increment,
  `itmtypename` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`itmtypeid`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `itemxferlogs` (
  `ixID` int(11) NOT NULL auto_increment,
  `ixFROM` int(11) NOT NULL default '0',
  `ixTO` int(11) NOT NULL default '0',
  `ixITEM` int(11) NOT NULL default '0',
  `ixQTY` int(11) NOT NULL default '0',
  `ixTIME` int(11) NOT NULL default '0',
  `ixFROMIP` varchar(255) NOT NULL default '',
  `ixTOIP` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ixID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jaillogs` (
  `jaID` int(11) NOT NULL auto_increment,
  `jaJAILER` int(11) NOT NULL default '0',
  `jaJAILED` int(11) NOT NULL default '0',
  `jaDAYS` int(11) NOT NULL default '0',
  `jaREASON` longtext NOT NULL,
  `jaTIME` int(11) NOT NULL default '0',
  PRIMARY KEY  (`jaID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jobranks` (
  `jrID` int(11) NOT NULL auto_increment,
  `jrNAME` varchar(255) NOT NULL default '',
  `jrJOB` int(11) NOT NULL default '0',
  `jrPAY` int(11) NOT NULL default '0',
  `jrIQG` int(11) NOT NULL default '0',
  `jrLABOURG` int(11) NOT NULL default '0',
  `jrSTRG` int(11) NOT NULL default '0',
  `jrIQN` int(11) NOT NULL default '0',
  `jrLABOURN` int(11) NOT NULL default '0',
  `jrSTRN` int(11) NOT NULL default '0',
  PRIMARY KEY  (`jrID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jobs` (
  `jID` int(11) NOT NULL auto_increment,
  `jNAME` varchar(255) NOT NULL default '',
  `jFIRST` int(11) NOT NULL default '0',
  `jDESC` varchar(255) NOT NULL default '',
  `jOWNER` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`jID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mail` (
  `mail_id` int(11) NOT NULL auto_increment,
  `mail_read` int(11) NOT NULL default '0',
  `mail_from` int(11) NOT NULL default '0',
  `mail_to` int(11) NOT NULL default '0',
  `mail_time` int(11) NOT NULL default '0',
  `mail_subject` varchar(255) NOT NULL default '',
  `mail_text` text NOT NULL,
  PRIMARY KEY  (`mail_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `oclogs` (
  `oclID` int(11) NOT NULL auto_increment,
  `oclOC` int(11) NOT NULL default '0',
  `oclGANG` int(11) NOT NULL default '0',
  `oclLOG` text NOT NULL,
  `oclRESULT` enum('success','failure') NOT NULL default 'success',
  `oclMONEY` int(11) NOT NULL default '0',
  `ocCRIMEN` varchar(255) NOT NULL default '',
  `ocTIME` int(11) NOT NULL default '0',
  PRIMARY KEY  (`oclID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `orgcrimes` (
  `ocID` int(11) NOT NULL auto_increment,
  `ocNAME` varchar(255) NOT NULL default '',
  `ocUSERS` int(11) NOT NULL default '0',
  `ocSTARTTEXT` text NOT NULL,
  `ocSUCCTEXT` text NOT NULL,
  `ocFAILTEXT` text NOT NULL,
  `ocMINMONEY` int(11) NOT NULL default '0',
  `ocMAXMONEY` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ocID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `papercontent` (
  `content` longtext NOT NULL
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `papercontent`
  VALUES
    ('Here you can put game news, or prehaps an update log.');

CREATE TABLE `polls` (
  `id` int(11) NOT NULL auto_increment,
  `active` enum('0','1') NOT NULL default '0',
  `question` varchar(255) NOT NULL default '',
  `choice1` varchar(255) NOT NULL default '',
  `choice2` varchar(255) NOT NULL default '',
  `choice3` varchar(255) NOT NULL default '',
  `choice4` varchar(255) NOT NULL default '',
  `choice5` varchar(255) NOT NULL default '',
  `choice6` varchar(255) NOT NULL default '',
  `choice7` varchar(255) NOT NULL default '',
  `choice8` varchar(255) NOT NULL default '',
  `choice9` varchar(255) NOT NULL default '',
  `choice10` varchar(255) NOT NULL default '',
  `voted1` int(11) NOT NULL default '0',
  `voted2` int(11) NOT NULL default '0',
  `voted3` int(11) NOT NULL default '0',
  `voted4` int(11) NOT NULL default '0',
  `voted5` int(11) NOT NULL default '0',
  `voted6` int(11) NOT NULL default '0',
  `voted7` int(11) NOT NULL default '0',
  `voted8` int(11) NOT NULL default '0',
  `voted9` int(11) NOT NULL default '0',
  `voted10` int(11) NOT NULL default '0',
  `votes` int(11) NOT NULL default '0',
  `winner` int(11) NOT NULL default '0',
  `hidden` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `preports` (
  `prID` int(11) NOT NULL auto_increment,
  `prREPORTER` int(11) NOT NULL default '0',
  `prREPORTED` int(11) NOT NULL default '0',
  `prTEXT` longtext NOT NULL,
  PRIMARY KEY  (`prID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `referals` (
  `refID` int(11) NOT NULL auto_increment,
  `refREFER` int(11) NOT NULL default '0',
  `refREFED` int(11) NOT NULL default '0',
  `refTIME` int(11) NOT NULL default '0',
  `refREFERIP` varchar(15) NOT NULL default '127.0.0.1',
  `refREFEDIP` varchar(15) NOT NULL default '127.0.0.1',
  PRIMARY KEY  (`refID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `settings` (
  `conf_id` int(11) NOT NULL auto_increment,
  `conf_name` varchar(255) NOT NULL default '',
  `conf_value` text NOT NULL,
  PRIMARY KEY  (`conf_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `settings`
  VALUES
    (NULL, 'validate_period', '15'),
    (NULL, 'validate_on', '0'),
    (NULL, 'regcap_on', '0'),
    (NULL, 'hospital_count', '0'),
    (NULL, 'jail_count', '0'),
    (NULL, 'sendcrys_on', '1'),
    (NULL, 'sendbank_on', '1'),
    (NULL, 'ct_refillprice', '12'),
    (NULL, 'ct_iqpercrys', '5'),
    (NULL, 'ct_moneypercrys', '200'),
    (NULL, 'staff_pad', 'Here you can store notes for all staff to see.'),
    (NULL, 'willp_item', '0'),
    (NULL, 'jquery_location', 'js/jquery-1.7.1.min.js'),
    (NULL, 'game_name', 'Monolegacy'),
    (NULL, 'game_description', 'Forked from davemacaulay/mccodesv2<br>Reset to v2.0.5b and reworked.'),
    (NULL, 'game_owner', 'The Monolegacy Team');

CREATE TABLE `shopitems` (
  `sitemID` int(11) NOT NULL auto_increment,
  `sitemSHOP` int(11) NOT NULL default '0',
  `sitemITEMID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`sitemID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `shops` (
  `shopID` int(11) NOT NULL auto_increment,
  `shopLOCATION` int(11) NOT NULL default '0',
  `shopNAME` varchar(255) NOT NULL default '',
  `shopDESCRIPTION` text NOT NULL,
  PRIMARY KEY  (`shopID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `stafflog` (
  `id` int(11) NOT NULL auto_increment,
  `user` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  `action` varchar(255) NOT NULL default '',
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `staffnotelogs` (
  `snID` int(11) NOT NULL auto_increment,
  `snCHANGER` int(11) NOT NULL default '0',
  `snCHANGED` int(11) NOT NULL default '0',
  `snTIME` int(11) NOT NULL default '0',
  `snOLD` longtext NOT NULL,
  `snNEW` longtext NOT NULL,
  PRIMARY KEY  (`snID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `surrenders` (
  `surID` int(11) NOT NULL auto_increment,
  `surWAR` int(11) NOT NULL default '0',
  `surWHO` int(11) NOT NULL default '0',
  `surTO` int(11) NOT NULL default '0',
  `surMSG` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`surID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `unjaillogs` (
  `ujaID` int(11) NOT NULL auto_increment,
  `ujaJAILER` int(11) NOT NULL default '0',
  `ujaJAILED` int(11) NOT NULL default '0',
  `ujaTIME` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ujaID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `userid` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `userpass` varchar(255) NOT NULL,

  `level` int(11) NOT NULL default '1',
  `exp` decimal(11,4) NOT NULL default '0.0000',

  `money` bigint unsigned NOT NULL default 100,
  `bankmoney` bigint unsigned NULL default 0,
  `cybermoney` int(11) NOT NULL default '-1',
  `crystals` int unsigned NOT NULL default '0',

  `laston` int(11) NOT NULL default '0',
  `lastip` varchar(255) NOT NULL default '',
  `job` int(11) NOT NULL default '0',

  `energy` int(11) NOT NULL default '12',
  `maxenergy` int(11) NOT NULL default '12',
  `will` int(11) NOT NULL default '100',
  `maxwill` int(11) NOT NULL default '100',
  `brave` int(11) NOT NULL default '5',
  `maxbrave` int(11) NOT NULL default '5',
  `hp` int(11) NOT NULL default '100',
  `maxhp` int(11) NOT NULL default '100',

  `location` int(11) NOT NULL default '1',
  `hospital` int(11) NOT NULL default '0',
  `jail` int(11) NOT NULL default '0',
  `jail_reason` varchar(255) NOT NULL default '',
  `fedjail` int(11) NOT NULL default '0',
  `user_level` int(11) NOT NULL default '1',
  `gender` enum('Male','Female') NOT NULL,
  `daysold` int(11) NOT NULL default '0',
  `signedup` int(11) NOT NULL,
  `gang` int(11) NOT NULL default '0',
  `daysingang` int(11) NOT NULL default '0',
  `course` int(11) NOT NULL default '0',
  `cdays` int(11) NOT NULL default '0',
  `jobrank` int(11) NOT NULL default '0',
  `donatordays` int(11) NOT NULL default '0',
  `email` varchar(255) NOT NULL,
  `login_name` varchar(255) NOT NULL default '',
  `display_pic` text NOT NULL,
  `duties` varchar(255) NOT NULL default '',
  `staffnotes` longtext NOT NULL,
  `mailban` int(11) NOT NULL default '0',
  `mb_reason` varchar(255) NOT NULL default '',
  `hospreason` varchar(255) NOT NULL default '',
  `lastip_login` varchar(255) NOT NULL default '',
  `lastip_signup` varchar(255) NOT NULL,
  `last_login` int(11) NOT NULL default '0',
  `voted` text NOT NULL,
  `crimexp` int(11) NOT NULL default '0',
  `attacking` int(11) NOT NULL default '0',
  `verified` int(11) NOT NULL default '0',
  `forumban` int(11) NOT NULL default '0',
  `fb_reason` varchar(255) NOT NULL default '',
  `posts` int(11) NOT NULL default '0',
  `forums_avatar` varchar(255) NOT NULL default '',
  `forums_signature` varchar(250) NOT NULL default '',
  `new_events` int(11) NOT NULL default '0',
  `new_mail` int(11) NOT NULL default '0',
  `friend_count` int(11) NOT NULL default '0',
  `enemy_count` int(11) NOT NULL default '0',
  `new_announcements` int(11) NOT NULL default '0',
  `boxes_opened` int(11) NOT NULL default '0',
  `user_notepad` text NOT NULL,
  `equip_primary` int(11) NOT NULL default '0',
  `equip_secondary` int(11) NOT NULL default '0',
  `equip_armor` int(11) NOT NULL default '0',
  `force_logout` tinyint(4) NOT NULL default '0',
  `pass_salt` varchar(8) NOT NULL default '',

  `strength` float NOT NULL default '10',
  `agility` float NOT NULL default '10',
  `guard` float NOT NULL default '10',
  `labour` float NOT NULL default '10',
  `IQ` float NOT NULL default '10',

  `regenerated` datetime not null default '2020-01-01 00:00:00',

  PRIMARY KEY (`userid`),
  UNIQUE  KEY ('email')
)
ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `votes` (
  `userid` int(11) NOT NULL default '0',
  `list` varchar(255) NOT NULL default ''
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `willps_accepted` (
  `dpID` int(11) NOT NULL auto_increment,
  `dpBUYER` int(11) NOT NULL default '0',
  `dpFOR` int(11) NOT NULL default '0',
  `dpAMNT` varchar(255) NOT NULL default '',
  `dpTIME` int(11) NOT NULL default '0',
  `dpTXN` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`dpID`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
