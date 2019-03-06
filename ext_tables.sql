#
# Table structure for table 'tx_eventcalendar_domain_model_event'
#
CREATE TABLE tx_eventcalendar_domain_model_event (

	title varchar(255) DEFAULT '' NOT NULL,
	date_time_start int(11) DEFAULT '0' NOT NULL,
	date_time_end int(11) DEFAULT '0' NOT NULL,

);
