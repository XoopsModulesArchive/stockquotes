#
# Table structure for table ustocks
#

CREATE TABLE ustocks (
  uid int(8) unsigned NOT NULL default '0',
  stocks varchar(128) default NULL,
  PRIMARY KEY  (uid)
) TYPE=MyISAM;

INSERT INTO ustocks (uid, stocks) SELECT uid, stocks FROM xoops_vlusers;

