


-- Table structure for table 'phpads_userlog'


CREATE TABLE phpads_userlog (
   userlogid mediumint(9) NOT NULL AUTO_INCREMENT,
   timestamp int(11) DEFAULT '0' NOT NULL,
   usertype tinyint(4) DEFAULT '0' NOT NULL,
   userid mediumint(9) DEFAULT '0' NOT NULL,
   action mediumint(9) DEFAULT '0' NOT NULL,
   object mediumint(9),
   details blob,
   PRIMARY KEY (userlogid)
);


-- Table structure for table 'phpads_affiliates'


CREATE TABLE phpads_affiliates (
   affiliateid mediumint(9) NOT NULL AUTO_INCREMENT,
   name varchar(255) NOT NULL,
   contact varchar(255),
   email varchar(64) NOT NULL,
   website varchar(255),   
   username varchar(64),
   password varchar(64),
   permissions mediumint(9),
   language varchar(64),
   publiczones enum('t','f') DEFAULT 'f' NOT NULL,
   PRIMARY KEY (affiliateid)
);


-- Table structure for table 'phpads_cache'


CREATE TABLE phpads_cache (
   cacheid varchar(255) NOT NULL,
   content blob NOT NULL,
   PRIMARY KEY (cacheid)
);


-- Table structure for table 'phpads_zones'


CREATE TABLE phpads_zones (
   zoneid mediumint(9) NOT NULL AUTO_INCREMENT,
   affiliateid mediumint(9),
   zonename varchar(245) NOT NULL,
   description varchar(255) NOT NULL,
   delivery smallint(6) DEFAULT '0' NOT NULL,
   zonetype smallint(6) DEFAULT '0' NOT NULL,
   what blob NOT NULL,
   width smallint(6) DEFAULT '0' NOT NULL,
   height smallint(6) DEFAULT '0' NOT NULL,
   chain blob NOT NULL,
   prepend blob NOT NULL,
   append blob NOT NULL,
   appendtype tinyint(4) DEFAULT '0' NOT NULL,
   PRIMARY KEY (zoneid),
   KEY zonenameid (zonename,zoneid)
);



-- Table structure for table 'phpads_adclicks'


CREATE TABLE phpads_adclicks (
   bannerid mediumint(9) DEFAULT '0' NOT NULL,
   zoneid mediumint(9) DEFAULT '0' NOT NULL,
   t_stamp timestamp,
   host varchar(255) NOT NULL,
   source varchar(50) NOT NULL,
   country char(2) NOT NULL,
   KEY bannerid_date (bannerid,t_stamp),
   KEY date (t_stamp),
   KEY zoneid (zoneid)
);



-- Table structure for table 'phpads_adviews'


CREATE TABLE phpads_adviews (
   bannerid mediumint(9) DEFAULT '0' NOT NULL,
   zoneid mediumint(9) DEFAULT '0' NOT NULL,
   t_stamp timestamp,
   host varchar(255) NOT NULL,
   source varchar(50) NOT NULL,
   country char(2) NOT NULL,
   KEY bannerid_date (bannerid,t_stamp),
   KEY date (t_stamp),
   KEY zoneid (zoneid)
);



-- Table structure for table 'phpads_images'


CREATE TABLE phpads_images (
   filename varchar(128) NOT NULL,
   contents mediumblob NOT NULL,
   t_stamp timestamp,
   PRIMARY KEY (filename)
);


-- Table structure for table 'phpads_banners'


CREATE TABLE phpads_banners (
   bannerid mediumint(9) NOT NULL AUTO_INCREMENT,
   clientid mediumint(9) DEFAULT '0' NOT NULL,
   active enum('t','f') DEFAULT 't' NOT NULL,
   priority int(11) DEFAULT '0' NOT NULL,
   contenttype enum('gif','jpeg','png','html','swf','dcr','rpm','mov','txt') DEFAULT 'gif' NOT NULL,
   pluginversion mediumint(9) DEFAULT '0' NOT NULL,
   storagetype enum('sql','web','url','html','network','txt') DEFAULT 'sql' NOT NULL,
   filename varchar(255) NOT NULL,
   imageurl varchar(255) NOT NULL,
   htmltemplate blob NOT NULL,
   htmlcache blob NOT NULL,
   width smallint(6) DEFAULT '0' NOT NULL,
   height smallint(6) DEFAULT '0' NOT NULL,
   weight tinyint(4) DEFAULT '1' NOT NULL,
   seq tinyint(4) DEFAULT '0' NOT NULL,
   target varchar(24) NOT NULL,
   url varchar(255) NOT NULL,
   alt varchar(255) NOT NULL,
   status varchar(255) NOT NULL,
   keyword varchar(255) NOT NULL,
   bannertext blob NOT NULL,
   description varchar(255) NOT NULL,
   autohtml enum('t','f') DEFAULT 't' NOT NULL,
   block int(11) DEFAULT '0' NOT NULL,
   capping int(11) DEFAULT '0' NOT NULL,
   compiledlimitation blob NOT NULL,
   append blob NOT NULL,
   appendtype tinyint(4) DEFAULT '0' NOT NULL,
   bannertype tinyint(4) DEFAULT '0' NOT NULL,
   transparent enum('t','f') DEFAULT 'f' NOT NULL,
   PRIMARY KEY (bannerid)
);



-- Table structure for table 'phpads_clients'


CREATE TABLE phpads_clients (
   clientid mediumint(9) NOT NULL AUTO_INCREMENT,
   clientname varchar(255) NOT NULL,
   contact varchar(255),
   email varchar(64) NOT NULL,
   views int(11),
   clicks int(11),
   clientusername varchar(64) NOT NULL,
   clientpassword varchar(64) NOT NULL,
   expire date DEFAULT '0000-00-00',
   activate date DEFAULT '0000-00-00',
   permissions mediumint(9),
   language varchar(64),
   active enum('t','f') DEFAULT 't' NOT NULL,
   weight tinyint(4) DEFAULT '1' NOT NULL,
   target int(11) DEFAULT '0' NOT NULL,   
   parent mediumint(9) DEFAULT '0' NOT NULL,
   report enum('t','f') DEFAULT 't' NOT NULL,
   reportinterval mediumint(9) DEFAULT '7' NOT NULL,
   reportlastdate date DEFAULT '0000-00-00' NOT NULL,
   reportdeactivate enum('t','f') DEFAULT 't' NOT NULL,
   PRIMARY KEY (clientid)
);


-- Table structure for table 'phpads_session'


CREATE TABLE phpads_session (
   sessionid varchar(32) NOT NULL,
   sessiondata blob NOT NULL,
   lastused timestamp,
   PRIMARY KEY (sessionid)
);



-- Table structure for table 'phpads_acls'

CREATE TABLE phpads_acls (
   bannerid mediumint(9) DEFAULT '0' NOT NULL,
   logical set('and','or') NOT NULL,
   type varchar(16) NOT NULL,
   comparison char(2) DEFAULT '==' NOT NULL,
   data text NOT NULL,
   executionorder int(10) unsigned DEFAULT '0' NOT NULL,
   KEY bannerid (bannerid),
   UNIQUE bannerid_executionorder (bannerid,executionorder)
);



-- Table structure for table 'phpads_adstats'


CREATE TABLE phpads_adstats (
  views int(11) DEFAULT '0' NOT NULL,
  clicks int(11) DEFAULT '0' NOT NULL,
  day date DEFAULT '0000-00-00' NOT NULL,
  hour tinyint(4) DEFAULT '0' NOT NULL,
  bannerid smallint(6) DEFAULT '0' NOT NULL,
  zoneid smallint(6) DEFAULT '0' NOT NULL,
  source varchar(50) NOT NULL,
  PRIMARY KEY (day,hour,bannerid,zoneid,source),
  KEY bannerid_day (bannerid,day),
  KEY zoneid (zoneid)
);



-- Table structure for table 'phpads_targetstats'

CREATE TABLE phpads_targetstats (
   day date DEFAULT '0000-00-00' NOT NULL,
   clientid smallint(6) DEFAULT '0' NOT NULL,
   target int(11) DEFAULT '0' NOT NULL,
   views int(11) DEFAULT '0' NOT NULL,
   modified tinyint(4) DEFAULT '0' NOT NULL,
   PRIMARY KEY (day,clientid)
);



-- Table structure for table 'phpads_config'


CREATE TABLE phpads_config (
   configid tinyint(2) DEFAULT '0' NOT NULL,
   config_version decimal(7,3) DEFAULT '0.000' NOT NULL,
   instance_id varchar(64) DEFAULT '' NOT NULL,
   table_border_color varchar(7) DEFAULT '#000099' NOT NULL,
   table_back_color varchar(7) DEFAULT '#CCCCCC' NOT NULL,
   table_back_color_alternative varchar(7) DEFAULT '#F7F7F7' NOT NULL,
   main_back_color varchar(7) DEFAULT '#FFFFFF' NOT NULL,
   my_header varchar(255) DEFAULT '' NOT NULL,
   my_footer varchar(255) DEFAULT '' NOT NULL,
   language varchar(32) DEFAULT 'english' NOT NULL,
   name varchar(32) DEFAULT '' NOT NULL,
   company_name varchar(255) DEFAULT 'mysite.com' NOT NULL,
   override_gd_imageformat varchar(4) DEFAULT '' NOT NULL,
   begin_of_week tinyint(2) DEFAULT '1' NOT NULL,
   percentage_decimals tinyint(2) DEFAULT '2' NOT NULL,
   type_sql_allow enum('t','f') DEFAULT 't' NOT NULL,
   type_url_allow enum('t','f') DEFAULT 't' NOT NULL,
   type_web_allow enum('t','f') DEFAULT 'f' NOT NULL,
   type_html_allow enum('t','f') DEFAULT 't' NOT NULL,
   type_txt_allow enum('t','f') DEFAULT 't' NOT NULL,
   type_web_mode tinyint(2) DEFAULT '0' NOT NULL,
   type_web_dir varchar(255) DEFAULT '' NOT NULL,
   type_web_ftp varchar(255) DEFAULT '' NOT NULL,
   type_web_url varchar(255) DEFAULT '' NOT NULL,
   admin varchar(64) DEFAULT 'phpadsuser' NOT NULL,
   admin_pw varchar(64) DEFAULT 'phpadspass' NOT NULL,
   admin_fullname varchar(255) DEFAULT 'Your Name' NOT NULL,
   admin_email varchar(64) DEFAULT 'your@email.com' NOT NULL,
   admin_email_headers varchar(64) DEFAULT '' NOT NULL,
   admin_novice enum('t','f') DEFAULT 't' NOT NULL,
   default_banner_weight tinyint(4) DEFAULT '1' NOT NULL,
   default_campaign_weight tinyint(4) DEFAULT '1' NOT NULL,
   client_welcome enum('t','f') DEFAULT 't' NOT NULL,
   client_welcome_msg text DEFAULT '' NOT NULL,
   content_gzip_compression enum('t','f') DEFAULT 'f' NOT NULL,
   userlog_email enum('t','f') DEFAULT 't' NOT NULL,
   userlog_priority enum('t','f') DEFAULT 't' NOT NULL,
   userlog_autoclean enum('t','f') DEFAULT 't' NOT NULL,
   gui_show_campaign_info enum('t','f') DEFAULT 't' NOT NULL,
   gui_show_campaign_preview enum('t','f') DEFAULT 'f' NOT NULL,
   gui_show_banner_info enum('t','f') DEFAULT 't' NOT NULL,
   gui_show_banner_preview enum('t','f') DEFAULT 't' NOT NULL,
   gui_show_banner_html enum('t','f') DEFAULT 'f' NOT NULL,
   gui_show_matching enum('t','f') DEFAULT 't' NOT NULL,
   gui_show_parents enum('t','f') DEFAULT 'f' NOT NULL,
   gui_hide_inactive enum('t','f') DEFAULT 'f' NOT NULL,
   gui_link_compact_limit int(11) DEFAULT '50' NOT NULL,
   qmail_patch enum('t','f') DEFAULT 'f' NOT NULL,
   updates_enabled enum('t','f') DEFAULT 't' NOT NULL,
   updates_last_seen decimal(7,3) DEFAULT '0.000' NOT NULL,
   updates_cache text DEFAULT '' NOT NULL,
   updates_timestamp int(11) DEFAULT '0' NOT NULL,
   updates_dev_builds enum('t','f') DEFAULT 'f' NOT NULL,
   allow_invocation_plain enum('t','f') DEFAULT 'f' NOT NULL,
   allow_invocation_js enum('t','f') DEFAULT 't' NOT NULL,
   allow_invocation_frame enum('t','f') DEFAULT 'f' NOT NULL,
   allow_invocation_xmlrpc enum('t','f') DEFAULT 'f' NOT NULL,
   allow_invocation_local enum('t','f') DEFAULT 't' NOT NULL,
   allow_invocation_interstitial enum('t','f') DEFAULT 't' NOT NULL,
   allow_invocation_popup enum('t','f') DEFAULT 't' NOT NULL,
   auto_clean_tables enum('t','f') DEFAULT 'f' NOT NULL,
   auto_clean_tables_interval tinyint(2) DEFAULT '5' NOT NULL,
   auto_clean_userlog enum('t','f') DEFAULT 'f' NOT NULL,
   auto_clean_userlog_interval tinyint(2) DEFAULT '5' NOT NULL,
   auto_clean_tables_vacuum enum('t','f') DEFAULT 't' NOT NULL,
   autotarget_factor float DEFAULT '-1' NOT NULL,
   maintenance_timestamp int(11) DEFAULT '0' NOT NULL,
   maintenance_cron_timestamp int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (configid)
);

