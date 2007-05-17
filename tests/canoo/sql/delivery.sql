CREATE TABLE `zones` (
  `zoneid` mediumint(9) NOT NULL auto_increment,
  `affiliateid` mediumint(9) default NULL,
  `zonename` varchar(245) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `delivery` smallint(6) NOT NULL default '0',
  `zonetype` smallint(6) NOT NULL default '0',
  `category` text NOT NULL,
  `width` smallint(6) NOT NULL default '0',
  `height` smallint(6) NOT NULL default '0',
  `ad_selection` text NOT NULL,
  `chain` text NOT NULL,
  `prepend` text NOT NULL,
  `append` text NOT NULL,
  `appendtype` tinyint(4) NOT NULL default '0',
  `forceappend` enum('t','f') default 'f',
  `inventory_forecast_type` smallint(6) NOT NULL default '0',
  `comments` text,
  `cost` decimal(10,4) default NULL,
  `cost_type` smallint(6) default NULL,
  `cost_variable_id` varchar(255) default NULL,
  `technology_cost` decimal(10,4) default NULL,
  `technology_cost_type` smallint(6) default NULL,
  `updated` datetime NOT NULL,
  `block` int(11) NOT NULL default '0',
  `capping` int(11) NOT NULL default '0',
  `session_capping` int(11) NOT NULL default '0',
  `what` text NOT NULL,
  PRIMARY KEY  (`zoneid`),
  KEY `zonenameid` (`zonename`,`zoneid`),
  KEY `affiliateid` (`affiliateid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `zones` VALUES (1,1,'Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,NULL,NULL,NULL,'2007-04-27 15:37:19',0,0,0,''),(2,2,'Agency Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,NULL,NULL,NULL,'2007-05-15 13:41:44',0,0,0,'');
CREATE TABLE `acls` (
  `bannerid` mediumint(9) NOT NULL default '0',
  `logical` varchar(3) NOT NULL default 'and',
  `type` varchar(32) NOT NULL default '',
  `comparison` char(2) NOT NULL default '==',
  `data` text NOT NULL,
  `executionorder` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `bannerid_executionorder` (`bannerid`,`executionorder`),
  KEY `bannerid` (`bannerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `acls` VALUES (1,'and','Site:Channel','=~','7',0);
CREATE TABLE `preference` (
  `agencyid` mediumint(9) NOT NULL default '0',
  `config_version` decimal(7,3) NOT NULL default '0.000',
  `my_header` varchar(255) default NULL,
  `my_footer` varchar(255) default NULL,
  `my_logo` varchar(255) default NULL,
  `language` varchar(32) default 'english',
  `name` varchar(32) default NULL,
  `company_name` varchar(255) default 'mysite.com',
  `override_gd_imageformat` varchar(4) default NULL,
  `begin_of_week` tinyint(2) default '1',
  `percentage_decimals` tinyint(2) default '2',
  `type_sql_allow` enum('t','f') default 't',
  `type_url_allow` enum('t','f') default 't',
  `type_web_allow` enum('t','f') default 'f',
  `type_html_allow` enum('t','f') default 't',
  `type_txt_allow` enum('t','f') default 't',
  `banner_html_auto` enum('t','f') default 't',
  `admin` varchar(64) default 'phpadsuser',
  `admin_pw` varchar(64) default 'phpadspass',
  `admin_fullname` varchar(255) default 'Your Name',
  `admin_email` varchar(64) default 'your@email.com',
  `warn_admin` enum('t','f') default 't',
  `warn_agency` enum('t','f') default 't',
  `warn_client` enum('t','f') default 't',
  `warn_limit` mediumint(9) NOT NULL default '100',
  `admin_email_headers` varchar(64) default NULL,
  `admin_novice` enum('t','f') default 't',
  `default_banner_weight` tinyint(4) default '1',
  `default_campaign_weight` tinyint(4) default '1',
  `default_banner_url` varchar(255) default NULL,
  `default_banner_destination` varchar(255) default NULL,
  `client_welcome` enum('t','f') default 't',
  `client_welcome_msg` text,
  `publisher_welcome` enum('t','f') default 't',
  `publisher_welcome_msg` text,
  `content_gzip_compression` enum('t','f') default 'f',
  `userlog_email` enum('t','f') default 't',
  `gui_show_campaign_info` enum('t','f') default 't',
  `gui_show_campaign_preview` enum('t','f') default 'f',
  `gui_campaign_anonymous` enum('t','f') default 'f',
  `gui_show_banner_info` enum('t','f') default 't',
  `gui_show_banner_preview` enum('t','f') default 't',
  `gui_show_banner_html` enum('t','f') default 'f',
  `gui_show_matching` enum('t','f') default 't',
  `gui_show_parents` enum('t','f') default 'f',
  `gui_hide_inactive` enum('t','f') default 'f',
  `gui_link_compact_limit` int(11) default '50',
  `gui_header_background_color` varchar(7) default NULL,
  `gui_header_foreground_color` varchar(7) default NULL,
  `gui_header_active_tab_color` varchar(7) default NULL,
  `gui_header_text_color` varchar(7) default NULL,
  `gui_invocation_3rdparty_default` smallint(6) default '0',
  `qmail_patch` enum('t','f') default 'f',
  `updates_enabled` enum('t','f') default 't',
  `updates_cache` text,
  `updates_timestamp` int(11) default '0',
  `updates_last_seen` decimal(7,3) default NULL,
  `allow_invocation_plain` enum('t','f') default 'f',
  `allow_invocation_plain_nocookies` enum('t','f') default 't',
  `allow_invocation_js` enum('t','f') default 't',
  `allow_invocation_frame` enum('t','f') default 'f',
  `allow_invocation_xmlrpc` enum('t','f') default 'f',
  `allow_invocation_local` enum('t','f') default 't',
  `allow_invocation_interstitial` enum('t','f') default 't',
  `allow_invocation_popup` enum('t','f') default 't',
  `allow_invocation_clickonly` enum('t','f') default 't',
  `auto_clean_tables` enum('t','f') default 'f',
  `auto_clean_tables_interval` tinyint(2) default '5',
  `auto_clean_userlog` enum('t','f') default 'f',
  `auto_clean_userlog_interval` tinyint(2) default '5',
  `auto_clean_tables_vacuum` enum('t','f') default 't',
  `autotarget_factor` float default '-1',
  `maintenance_timestamp` int(11) default '0',
  `compact_stats` enum('t','f') default 't',
  `statslastday` date NOT NULL default '0000-00-00',
  `statslasthour` tinyint(4) NOT NULL default '0',
  `default_tracker_status` tinyint(4) NOT NULL default '1',
  `default_tracker_type` int(10) unsigned default '1',
  `default_tracker_linkcampaigns` enum('t','f') NOT NULL default 'f',
  `publisher_agreement` enum('t','f') default 'f',
  `publisher_agreement_text` text,
  `publisher_payment_modes` text,
  `publisher_currencies` text,
  `publisher_categories` text,
  `publisher_help_files` text,
  `publisher_default_tax_id` enum('t','f') default 'f',
  `publisher_default_approved` enum('t','f') default 'f',
  `more_reports` varchar(1) default NULL,
  `gui_column_id` text,
  `gui_column_requests` text,
  `gui_column_impressions` text,
  `gui_column_clicks` text,
  `gui_column_ctr` text,
  `gui_column_conversions` text,
  `gui_column_conversions_pending` text,
  `gui_column_sr_views` text,
  `gui_column_sr_clicks` text,
  `gui_column_revenue` text,
  `gui_column_cost` text,
  `gui_column_bv` text,
  `gui_column_num_items` text,
  `gui_column_revcpc` text,
  `gui_column_costcpc` text,
  `gui_column_technology_cost` text,
  `gui_column_income` text,
  `gui_column_income_margin` text,
  `gui_column_profit` text,
  `gui_column_margin` text,
  `gui_column_erpm` text,
  `gui_column_erpc` text,
  `gui_column_erps` text,
  `gui_column_eipm` text,
  `gui_column_eipc` text,
  `gui_column_eips` text,
  `gui_column_ecpm` text,
  `gui_column_ecpc` text,
  `gui_column_ecps` text,
  `gui_column_epps` text,
  `instance_id` varchar(64) default NULL,
  `maintenance_cron_timestamp` int(11) default NULL,
  PRIMARY KEY  (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `preference` VALUES (0,'0.000',NULL,NULL,NULL,'english',NULL,'www.openads.org',NULL,0,2,'t','t','f','t','t','t','admin','5f4dcc3b5aa765d61d8327deb882cf99','Andrew Hill','andrew.hill@openads.org','t','t','t',100,NULL,'t',1,1,NULL,NULL,'t',NULL,'t',NULL,'f','t','t','t','t','t','t','t','t','t','t',50,NULL,NULL,NULL,NULL,0,'f','t',NULL,0,NULL,'f','t','t','f','f','t','t','t','t','f',5,'f',5,'t',-1,1179411168,'t','0000-00-00',0,1,1,'f','f',NULL,'','','','','t','t',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1179299106),(1,'0.000',NULL,NULL,NULL,'','Test Agency','www.openads.org',NULL,0,2,'t','t','f','t','t','t','admin','5f4dcc3b5aa765d61d8327deb882cf99','Andrew Hill','andrew.hill@openads.org','t','t','t',100,NULL,'t',1,1,NULL,NULL,'t',NULL,'t',NULL,'f','t','t','t','t','t','t','t','t','t','t',50,NULL,NULL,NULL,NULL,0,'f','t',NULL,0,NULL,'f','t','t','f','f','t','t','t','t','f',5,'f',5,'t',-1,1179411168,'t','0000-00-00',0,1,1,'f','f',NULL,'','','','','t','t',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1179299106);
CREATE TABLE `affiliates_extra` (
  `affiliateid` mediumint(9) NOT NULL,
  `address` text,
  `city` varchar(255) default NULL,
  `postcode` varchar(64) default NULL,
  `country` varchar(255) default NULL,
  `phone` varchar(64) default NULL,
  `fax` varchar(64) default NULL,
  `account_contact` varchar(255) default NULL,
  `payee_name` varchar(255) default NULL,
  `tax_id` varchar(64) default NULL,
  `mode_of_payment` varchar(64) default NULL,
  `currency` varchar(64) default NULL,
  `unique_users` int(11) default NULL,
  `unique_views` int(11) default NULL,
  `page_rank` int(11) default NULL,
  `category` varchar(255) default NULL,
  `help_file` varchar(255) default NULL,
  PRIMARY KEY  (`affiliateid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `affiliates_extra` VALUES (1,'','','','','','','','','','Cheque by post','GBP',0,0,0,'',''),(2,'','','','','','','','','','Cheque by post','GBP',0,0,0,NULL,NULL);
CREATE TABLE `campaigns` (
  `campaignid` mediumint(9) NOT NULL auto_increment,
  `campaignname` varchar(255) NOT NULL default '',
  `clientid` mediumint(9) NOT NULL default '0',
  `views` int(11) default '-1',
  `clicks` int(11) default '-1',
  `conversions` int(11) default '-1',
  `expire` date default '0000-00-00',
  `activate` date default '0000-00-00',
  `active` enum('t','f') NOT NULL default 't',
  `priority` int(11) NOT NULL default '0',
  `weight` tinyint(4) NOT NULL default '1',
  `target_impression` int(11) NOT NULL default '0',
  `target_click` int(11) NOT NULL default '0',
  `target_conversion` int(11) NOT NULL default '0',
  `anonymous` enum('t','f') NOT NULL default 'f',
  `companion` smallint(1) default '0',
  `comments` text,
  `revenue` decimal(10,4) default NULL,
  `revenue_type` smallint(6) default NULL,
  `updated` datetime NOT NULL,
  `block` int(11) NOT NULL default '0',
  `capping` int(11) NOT NULL default '0',
  `session_capping` int(11) NOT NULL default '0',
  PRIMARY KEY  (`campaignid`),
  KEY `campaigns_clientid` (`clientid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `campaigns` VALUES (1,'Advertiser 1 - Default Campaign',1,100000000,-1,-1,'2007-07-01','0000-00-00','t',10,0,0,0,0,'f',0,'',NULL,NULL,'2007-05-15 09:54:06',0,0,0),(2,'test campaign',1,-1,-1,-1,'0000-00-00','0000-00-00','t',-1,1,0,0,0,'t',0,'',NULL,NULL,'2007-05-16 12:55:24',0,0,0),(3,'campaign 2 (gif)',1,-1,-1,-1,'0000-00-00','0000-00-00','t',0,1,0,0,0,'t',0,'',NULL,NULL,'2007-05-17 13:14:43',0,0,0);
CREATE TABLE `ad_zone_assoc` (
  `ad_zone_assoc_id` mediumint(9) NOT NULL auto_increment,
  `zone_id` mediumint(9) default NULL,
  `ad_id` mediumint(9) default NULL,
  `priority` double default '0',
  `link_type` smallint(6) NOT NULL default '1',
  `priority_factor` double default '0',
  `to_be_delivered` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`ad_zone_assoc_id`),
  KEY `ad_zone_assoc_zone_id` (`zone_id`),
  KEY `ad_id` (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `ad_zone_assoc` VALUES (1,0,1,1,0,1670960,1),(2,1,1,0.9,1,1,1),(3,0,2,0,0,1,1),(4,1,2,0,1,1,1),(5,2,1,0.9,1,1,1),(6,0,3,0,0,0,1),(7,1,3,0,1,1,1);
CREATE TABLE `images` (
  `image_id` int(11) NOT NULL auto_increment,
  `filename` varchar(128) NOT NULL default '',
  `contents` longblob NOT NULL,
  `t_stamp` datetime default NULL,
  PRIMARY KEY  (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `images` VALUES (1,'468x60.gif','GIF89aÔ<\0³\0\0uuuºººDDDîîîÎÎÎ™™™000ŞŞŞ   eee‰‰‰UUUªªªÿÿÿ\0\0\0!ù\0\0\0\0\0,\0\0\0\0Ô<\0\0ÿğÉI«½8ëÍ»ÿ`(dihª®lë¾p,Ïtmßx®ï|ï?„cH\nPÅ\"€(\nBŠÀX6\rÀá§JZPéªÊ$Q®zÍnW\ZÅø±$0ÄïÃÆ–$€ãï\0bnuqz\'	B‡C	„’“”.s\"	xƒ›x\0•¢£EŸ$\0ª¬§³´µA˜#\n¯°C ¼½À”»ÄD¿!~ÉË¶ÑÒ’Î™ÉqĞ\nÚwÜ”Ùß¾ÆäæÓîï6—×vê¾÷E§ö÷>ü#Áƒ.pÍ`Sç®8t\0QRÃ‰5xsØ¡Ç(ÿª¢§AÀD\"‘0\\<ÉN’É“R¦$È›81leó‰dÀ¨SÇ[4ã\0 @@•¤E2®ùÙI(\0¢P‰Å0î\0¤s0§Ù³d•ãaåYÜŞ ÓÑ\0’\"$÷\\	}‹ĞéHª°\\hßä«g…¨tÄà‚^Á{,;’©2É©<ùT	ú5PÌ\Z¡hk^SÔ\04ÎÖ	Œñœ¦@6Ù»\'Ôæ—a8‘\0.áÜºy-µÄS‹Á†×e+8j7¡ëà<¨ïÕ€CG Q¡wÎ¾VîÆÎJ!µ™\0KwÊAn6òE¶ÿ}Cœ‘_il \"í5H‰l¾‘·\00 \0s‚Ü/ı·†lÜÅe!†ˆäÄu‡æàŠk@—Œt˜xœPmX’i@ˆ@ˆ€uršŒCØÈBVàIĞ!™±¨$ï± [éB“fP8ÒOÆ±À€ğ7”-ˆiç¬·ä™9¼Fà0Šy™+¨¹•D˜·–Òei†nÆ§\nG²ÉAahZƒ‹ß=€X$©BŸ3f(qu9b‚Zà’.€ÈA\Z*j –µ(¦wTp\0Qø°€\"(÷H}YIäC¬yÇj¡9¢*«ø½ê¨•‡t\0ªBª,\nr*z¥ÿŞÅ¡¢Æ\r\0}ñe@’¸rÈ–\ZôvÈ°zØN´‚M@­WØjp¬Æúºì¼&èŠ«§^p,r©t‚ÀŸ\ZlJ\n~å–ÃÁ¤ÛT\0¡cû>Ğ¯¥\0ë›b=òÒkqz\n™¯ûp§– qù8Â«¸«¡ÇÄ€«òÉ¢\ZÇÅ4·gWP.ßq›ÜI\0$O×Éââá¥;÷lÛÄÜë³5Wm½CH•30QêÁºÄ\\«ÉZ¡‹Ô]ÏšAÔ±mm5Í[à6¾igıÁ\"É4\0c¥ª™Œvİà±Ml„o[-Ú\0Îíl/à§ÊŞ˜\rK\0$npë(¼ş\rKÿãïÑ“à(R]xÍXÏ&·èô\0g`ÿ±´ªÕö2@ÄáÆnWÑª³nûë‹ã!uŠ.jÜ©£~zUÃñ.í°<Q»~Ã¼v£<ËsÛÆ¿ìá•+şø9åşî™ï¯Ğ¹ÓOİ‹ËƒòD¾†ÚûÎ=áŞ/[zàİsmTô‡ Ñå\ZÀœÈİcŒ+\Zİñ³\n l‰£ßàğ°·ü±Û[[ÿ&0Šäél>x \Z(à„@ÔÑ@ĞA”«] “Ğ-¸$É!NŠ{×¥Bç	í‡‡x¨\\Lˆ#èğ~~ña˜*\Z*ëĞóş”¸ÄUÑaÁ‹]‘Jä/ÿ¼ëw” µC\r\\Î‰ÊÚW«Ö¸F²°1YïÚ¢ e-…ı’s\0ï^F(#öqtt@%ğ®x¢ZßIìXÄø%ˆ·’ãDÁƒ2‹Š*ÖNf aˆ4”\"\'ÂÈ?H²wMœ@¹ÚÇÁq} tàPà€³ÉCR@6(_(EY·GìšKå)XË)b\0ƒïû€OéÉJ8lä.—4J‡<&†Ñôå0ÕàI 3ä\r65¨MÔ(\0fš&5{‰Änõ¹c+ÿÀJ xS„)Rà;;Pº×ó\"Ä¤:SÍ}X@VäÀ3#5OğBœÀùz‘¹\r 4ÿ&\nãUÃÄt\rtìœYˆ9æQ*ÇÚã-›yË\"Š#ıçN:Ó	}’£URAïq‹ÒæºhD%;•J`¡E8LŠ†jÏ|n vCê`\ZHÀ4§­9@S¶ÊÕ®zu™^ÕÌ!P8K›ªkœ1ı ×²%©†Š%«§.x–,€XŞ=ÿ—«¬TTèd`œgÌzE.•#>IHØ]%G¦ÍsÄ_óZ5o> s”SØZlâRC©°ëJ5Ñ8”Cc·6KÓM\0´Ä¤lá,‹Ï ]Å\0¶Cj;\0(4\0B³*Ğ:?gv‰GµEÖmsFÔZ\n,bÿé’lGgÙ€S˜¼®6ŒZ°YÀ¥Å­)LNÛÚèLw¶áäMpaQ$dNÄzĞZRä;?Œ Qd=ï²ª§	v@şíÄUË(Ÿfù¥ÀEUQı^Œ¿Í[ïX=p€ÜªâªI›Kˆ\\:Ù«Iø	®ÀNÏæ`«AXyä8%`Gl-¸}¥-ÂUWœâ,Øu§-ñ¨N˜\0# ‚h]/<ŒNtXSUaê,}äÀvÑ1ÍxØÕ’eÆP€„\rã›Ë.m.o¬¼,s [Ó›”×ìdõå	«[A`€2(c)%%àf0Ä™|¶ó:Ğ g6úĞˆN´\n¢ÍèF;\Z\0\0;','2007-05-17 12:01:02');
CREATE TABLE `agency` (
  `agencyid` mediumint(9) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL default '',
  `username` varchar(64) default NULL,
  `password` varchar(64) default NULL,
  `permissions` mediumint(9) default NULL,
  `language` varchar(64) default NULL,
  `logout_url` varchar(255) default NULL,
  `active` smallint(1) default '0',
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `agency` VALUES (1,'Test Agency','Andrew Hill','andrew.hill@openads.org','agency','5f4dcc3b5aa765d61d8327deb882cf99',0,'','',0,'2007-05-15 12:54:16');
CREATE TABLE `banners` (
  `bannerid` mediumint(9) NOT NULL auto_increment,
  `campaignid` mediumint(9) NOT NULL default '0',
  `active` enum('t','f') NOT NULL default 't',
  `contenttype` enum('gif','jpeg','png','html','swf','dcr','rpm','mov','txt') NOT NULL default 'gif',
  `pluginversion` mediumint(9) NOT NULL default '0',
  `storagetype` enum('sql','web','url','html','network','txt') NOT NULL default 'sql',
  `filename` varchar(255) NOT NULL default '',
  `imageurl` varchar(255) NOT NULL default '',
  `htmltemplate` text NOT NULL,
  `htmlcache` text NOT NULL,
  `width` smallint(6) NOT NULL default '0',
  `height` smallint(6) NOT NULL default '0',
  `weight` tinyint(4) NOT NULL default '1',
  `seq` tinyint(4) NOT NULL default '0',
  `target` varchar(16) NOT NULL default '',
  `url` text NOT NULL,
  `alt` varchar(255) NOT NULL default '',
  `status` varchar(255) NOT NULL default '',
  `bannertext` text NOT NULL,
  `description` varchar(255) NOT NULL default '',
  `autohtml` enum('t','f') NOT NULL default 't',
  `adserver` varchar(50) NOT NULL default '',
  `block` int(11) NOT NULL default '0',
  `capping` int(11) NOT NULL default '0',
  `session_capping` int(11) NOT NULL default '0',
  `compiledlimitation` text NOT NULL,
  `acl_plugins` text,
  `append` text NOT NULL,
  `appendtype` tinyint(4) NOT NULL default '0',
  `bannertype` tinyint(4) NOT NULL default '0',
  `alt_filename` varchar(255) NOT NULL default '',
  `alt_imageurl` varchar(255) NOT NULL default '',
  `alt_contenttype` enum('gif','jpeg','png') NOT NULL default 'gif',
  `comments` text,
  `updated` datetime NOT NULL,
  `acls_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `keyword` varchar(255) NOT NULL default '',
  `transparent` tinyint(1) NOT NULL default '0',
  `parameters` text,
  PRIMARY KEY  (`bannerid`),
  KEY `banners_campaignid` (`campaignid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `banners` VALUES (1,1,'t','',0,'html','','','Test HTML Banner!','',468,60,1,0,'','','','','','','t','',0,0,0,'(MAX_checkSite_Channel(\'7\', \'=~\'))','Site:Channel','',0,0,'','','','','2007-05-15 15:01:43','2007-05-15 15:01:43','',0,'N;'),(2,2,'t','',0,'html','','','html test banner','html test banner',468,60,1,0,'','http://www.example.com','','','','test banner','t','',0,0,0,'',NULL,'',0,0,'','','','','2007-05-16 13:03:46','0000-00-00 00:00:00','',0,'N;'),(3,3,'t','gif',0,'sql','468x60.gif','','','',468,60,1,0,'','http://www.example.com','','','','sample gif banner','f','',0,0,0,'',NULL,'',0,0,'','','','','2007-05-17 13:15:25','0000-00-00 00:00:00','',0,'N;');
CREATE TABLE `affiliates` (
  `affiliateid` mediumint(9) NOT NULL auto_increment,
  `agencyid` mediumint(9) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `mnemonic` varchar(5) NOT NULL default '',
  `comments` text,
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL default '',
  `website` varchar(255) default NULL,
  `username` varchar(64) default NULL,
  `password` varchar(64) default NULL,
  `permissions` mediumint(9) default NULL,
  `language` varchar(64) default NULL,
  `publiczones` enum('t','f') NOT NULL default 'f',
  `last_accepted_agency_agreement` datetime default NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`affiliateid`),
  KEY `affiliates_agencyid` (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `affiliates` VALUES (1,0,'Publisher 1','','','Andrew Hill','andrew.hill@openads.org','http://www.fornax.net/blog/','publisher','5f4dcc3b5aa765d61d8327deb882cf99',0,'','f',NULL,'2007-05-15 13:29:57'),(2,1,'Agency Publisher 1','','','Andrew Hill','andrew.hill@openads.org','http://fornax.net',NULL,'',0,NULL,'f',NULL,'2007-05-15 13:41:40');
CREATE TABLE `placement_zone_assoc` (
  `placement_zone_assoc_id` mediumint(9) NOT NULL auto_increment,
  `zone_id` mediumint(9) default NULL,
  `placement_id` mediumint(9) default NULL,
  PRIMARY KEY  (`placement_zone_assoc_id`),
  KEY `placement_zone_assoc_zone_id` (`zone_id`),
  KEY `placement_id` (`placement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `placement_zone_assoc` VALUES (1,1,1),(2,1,2),(3,2,3);
CREATE TABLE `channel` (
  `channelid` mediumint(9) NOT NULL auto_increment,
  `agencyid` mediumint(9) NOT NULL default '0',
  `affiliateid` mediumint(9) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `compiledlimitation` text NOT NULL,
  `acl_plugins` text,
  `active` smallint(1) default NULL,
  `comments` text,
  `updated` datetime NOT NULL,
  `acls_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`channelid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `channel` VALUES (7,0,0,'Test Admin Channel 2','','true','true',1,'','0000-00-00 00:00:00','0000-00-00 00:00:00');
CREATE TABLE `clients` (
  `clientid` mediumint(9) NOT NULL auto_increment,
  `agencyid` mediumint(9) NOT NULL default '0',
  `clientname` varchar(255) NOT NULL default '',
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL default '',
  `clientusername` varchar(64) NOT NULL default '',
  `clientpassword` varchar(64) NOT NULL default '',
  `permissions` mediumint(9) default NULL,
  `language` varchar(64) default NULL,
  `report` enum('t','f') NOT NULL default 't',
  `reportinterval` mediumint(9) NOT NULL default '7',
  `reportlastdate` date NOT NULL default '0000-00-00',
  `reportdeactivate` enum('t','f') NOT NULL default 't',
  `comments` text,
  `updated` datetime NOT NULL,
  `lb_reporting` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`clientid`),
  KEY `clients_agencyid` (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `clients` VALUES (1,0,'Advertiser 1','advertiser','example@example.com','advertiser1','fe1f4b7940d69cf3eb289fad37c3ae40',0,'','f',7,'2007-04-27','t','','2007-05-16 12:54:09',0);
