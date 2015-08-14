-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

CREATE TABLE `tl_hofff_solr_index_source` (

  `handler` int(10) unsigned NOT NULL default '0',
  `source` int(10) unsigned NOT NULL default '0',
  
  PRIMARY KEY  (`handler`, `source`),
  KEY `source` (`source`),
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_hofff_solr_page` (

  `page` int(10) unsigned NOT NULL default '0',
  `hash` char(32) NOT NULL default '',
  `base` varchar(1024) NOT NULL default '',
  `request` varchar(1024) NOT NULL default '',
  `root` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  
  PRIMARY KEY  (`page`, `hash`),
  KEY `tstamp` (`tstamp`),
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
