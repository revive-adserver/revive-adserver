# phpMyAdmin MySQL-Dump
# http://www.htmlwizard.net/phpMyAdmin/
#
# Host: localhost:3300 Database : phpads

# --------------------------------------------------------
#
# Table structure for table 'adclicks'
#

CREATE TABLE adclicks (
   bannerID mediumint(9) DEFAULT '0' NOT NULL,
   t_stamp timestamp(14),
   host varchar(255) NOT NULL,
   KEY clientID (bannerID)
);


# --------------------------------------------------------
#
# Table structure for table 'adviews'
#

CREATE TABLE adviews (
   bannerID mediumint(9) DEFAULT '0' NOT NULL,
   t_stamp timestamp(14),
   host varchar(255) NOT NULL,
   KEY clientID (bannerID)
);


# --------------------------------------------------------
#
# Table structure for table 'banners'
#

CREATE TABLE banners (
   bannerID mediumint(9) NOT NULL auto_increment,
   clientID mediumint(9) DEFAULT '0' NOT NULL,
   banner blob NOT NULL,
   width smallint(6) DEFAULT '0' NOT NULL,
   height smallint(6) DEFAULT '0' NOT NULL,
   format enum('gif','jpeg','png','html','url','web') DEFAULT 'gif' NOT NULL,
   url varchar(255) NOT NULL,
   alt varchar(255) NOT NULL,
   keyword varchar(255) NOT NULL,
   bannertext varchar(255) NOT NULL,
   active enum('true','false') NOT NULL,
   weight tinyint(4) default '1' NOT NULL,
   seq tinyint(4) default '0' NOT NULL,
   target varchar(8) default '' NOT NULL,
   description varchar(255) DEFAULT '' NOT NULL,
   PRIMARY KEY (bannerID)
);



# --------------------------------------------------------
#
# Table structure for table 'clients'
#

CREATE TABLE clients (
   clientID mediumint(9) DEFAULT '0' NOT NULL auto_increment,
   clientname varchar(255) NOT NULL,
   contact varchar(255),
   email varchar(64) NOT NULL,
   views mediumint(9),
   clicks mediumint(9),
   clientusername varchar(64) NOT NULL,
   clientpassword varchar(64) NOT NULL,
   expire date DEFAULT '0000-00-00',
   activate date DEFAULT '0000-00-00',
   permissions mediumint(9),
   language varchar(64),
   active enum('true','false') NOT NULL,
   weight tinyint(4) default '1' NOT NULL,   
   parent mediumint(9) DEFAULT '0' NOT NULL,
   report enum('true','false') NOT NULL,
   reportinterval mediumint(9) DEFAULT '7' NOT NULL,
   reportlastdate date DEFAULT '0000-00-00' NOT NULL,
   reportdeactivate enum('true','false') NOT NULL,
   PRIMARY KEY (clientID)
);


# --------------------------------------------------------
#
# Table structure for table 'session'
#

CREATE TABLE session (
   SessionID varchar(32) NOT NULL,
   SessionData blob NOT NULL,
   LastUsed timestamp(14),
   PRIMARY KEY (SessionID)
);

# --------------------------------------------------------
#
# Table structure for table 'acls'
#

CREATE TABLE acls (
   bannerID mediumint(9) DEFAULT '0' NOT NULL,
   acl_type enum('clientip','useragent','weekday','domain','source','time') NOT NULL,
   acl_data varchar(255) NOT NULL,
   acl_ad set('allow','deny') NOT NULL,
   acl_order int(10) unsigned DEFAULT '0' NOT NULL,
   KEY bannerID (bannerID),
   UNIQUE bannerID_2 (bannerID, acl_order)
);

# --------------------------------------------------------
#
# Table structure for table 'adstats'
#
CREATE TABLE adstats (
  views int(11) DEFAULT '0' NOT NULL,
  clicks int(11) DEFAULT '0' NOT NULL,
  day date DEFAULT '0000-00-00' NOT NULL,
  BannerID smallint(6) DEFAULT '0' NOT NULL,
  PRIMARY KEY (day,BannerID)
);

