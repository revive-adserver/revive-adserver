<?php

/*********************************************************/
/* Database configuration                                */
/*********************************************************/

// Database hostname
$phpAds_config['dbhost'] = 'localhost';

// Database username
$phpAds_config['dbuser'] = 'mysqlusername';

// Database password
$phpAds_config['dbpassword'] = 'mysqlpassword';

// Database name
$phpAds_config['dbname'] = 'phpads';

// Database table names
$phpAds_config['tbl_adclicks'] = 'phpads_adclicks';
$phpAds_config['tbl_adviews'] = 'phpads_adviews';
$phpAds_config['tbl_adstats'] = 'phpads_adstats';
$phpAds_config['tbl_banners'] = 'phpads_banners';
$phpAds_config['tbl_clients'] = 'phpads_clients';
$phpAds_config['tbl_session'] = 'phpads_session';
$phpAds_config['tbl_acls'] = 'phpads_acls';
$phpAds_config['tbl_zones'] = 'phpads_zones';
$phpAds_config['tbl_config'] = 'phpads_config';
$phpAds_config['tbl_affiliates'] = 'phpads_affiliates';
$phpAds_config['tbl_images'] = 'phpads_images';
$phpAds_config['tbl_userlog'] = 'phpads_userlog';

// Database table name prefix
$phpAds_config['table_prefix'] = 'phpads_';

// Use persistent connections to the database
$phpAds_config['persistent_connections'] = false;

// Use INSERT DELAYED in logging functions?
$phpAds_config['insert_delayed'] = false;

// Database compatibility mode to insure phpAdsNew
// won't disturb an available database connection
$phpAds_config['compatibility_mode'] = false;



/*********************************************************/
/* phpAdsNew configuration                               */
/*********************************************************/

// The URL to your phpAdsNew-installation
$phpAds_config['url_prefix'] = 'http://www.your-url.com/phpAdsNew';

// Is the admin interface enabled
$phpAds_config['ui_enabled'] = true;

// The Language of the Interface (eg. english, german, spanish) 
// for the right string look for the directory name in the language subdirectory
$phpAds_config['language'] = 'english';



/*********************************************************/
/* P3P Privacy Policies                                  */
/*********************************************************/

// Use P3P Polices
$phpAds_config['p3p_policies'] = true;

// Compact policy
$phpAds_config['p3p_compact_policy'] = 'CUR ADM OUR NOR STA NID';

// Policy file location
// For example:
// $phpAds_config['p3p_policy_location'] = 'http://www.your-url.com/w3c/p3p.xml';
$phpAds_config['p3p_policy_location'] = '';



/*********************************************************/
/* Statistics and logging                                */
/*********************************************************/

// Use compact or verbose statistics
$phpAds_config['compact_stats'] = false;

// Use beacons to log adviews
$phpAds_config['log_beacon'] = true;


// Enabled logging of adviews?
$phpAds_config['log_adviews'] = true;

// Block logging of views for xx seconds after the last entry
// This is to prevent logging after each page reload
$phpAds_config['block_adviews'] = 0;

// Enabled logging of adclicks?
$phpAds_config['log_adclicks'] = true;

// Block logging of clicks for xx seconds after the last entry
// This is to prevent users from boosting the stats by clicking multiple times
$phpAds_config['block_adclicks'] = 0;


// Reverse DNS lookup remotes hosts?
$phpAds_config['reverse_lookup'] = false;

// Find the correct IP for users behind a proxy
$phpAds_config['proxy_lookup'] = false;

// Hosts to ignore (don't count adviews coming from them)
$phpAds_config['ignore_hosts'] = array ();   // Example: array('slashdot.org', 'microsoft.com');


// E-mail admin when clicks/views get low?
$phpAds_config['warn_admin'] = true;

// E-mail client when clicks/views get low?
$phpAds_config['warn_client'] = true;

// Minimum clicks/views before warning e-mail is sent
$phpAds_config['warn_limit'] = 100; 



/*********************************************************/
/* Banner retrieval                                      */
/*********************************************************/

// Use conditional keywords?
$phpAds_config['con_key'] = true;

// Use multiple keywords for banners in banner table?
$phpAds_config['mult_key'] = true;

// Use display limitations?
$phpAds_config['acl'] = true;

// Default banner, it is show when phpAdsNew can't connect to the database or
// there are absolutely no banner to display. The banner is not logged.
// Enter the complete url (incl. http://) for the image and the target,
// or leave them empty if you don't want to show a banner when this happens.
$phpAds_config['default_banner_url'] = '';
$phpAds_config['default_banner_target'] = '';

// Cache zones, this should speed things up when using zones
$phpAds_config['zone_cache'] = true;

// Time between cache updates (in seconds)
// Once this limit has been reached the cache will be rebuild
$phpAds_config['zone_cache_limit'] = 300; // Reload every 5 minutes



/*********************************************************/
/* Banner storage and types                              */
/*********************************************************/

// Automatically change HTML banners in order to force
// click logging.
$phpAds_config['type_html_auto'] = true;

// Allow php expressions to be executed from within a 
// HTML banner
$phpAds_config['type_html_php'] = false;






/*********************************************************/
/* phpAdsNew self configuration code - don't change      */
/*********************************************************/

define('phpAds_installed', false);

// Disable magic_quotes_runtime
set_magic_quotes_runtime(0);

?>
