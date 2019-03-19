#
# Table structure for table 'tx_nlpageconfig_domain_model_config'
#
CREATE TABLE tx_nlpageconfig_domain_model_config (

	type int(11) DEFAULT '0' NOT NULL,
	value_key varchar(255) DEFAULT '' NOT NULL,
	page int(11) DEFAULT '0' NOT NULL,
	image int(11) unsigned NOT NULL default '0',
	text text,
	string varchar(255) DEFAULT '' NOT NULL,

);
