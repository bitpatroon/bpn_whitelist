#
# Table structure for table 'tx_bpnwhitelist_ipwhitelist'
#
CREATE TABLE tx_bpnwhitelist_ipwhitelist (
	uid int(11) unsigned NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	ip_mask varchar(255) DEFAULT '' NOT NULL,
	extension_key varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);
