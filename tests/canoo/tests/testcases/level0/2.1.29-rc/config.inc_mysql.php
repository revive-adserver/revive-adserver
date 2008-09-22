<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Uncomment the following to enable PHP warnings when developing,
// as some of the phpAdsNew code that hasn't been rewritten yet
// and still generates warnings...
// error_reporting(E_ALL ^ E_NOTICE);

/*********************************************************/
/* Database configuration                                */
/*********************************************************/

// Database
$phpAds_config['dbhost']         = '@db.host';
$phpAds_config['dbport']         = @db.port;
$phpAds_config['dbuser']         = '@db.login';
$phpAds_config['dbpassword']     = '@db.password';
$phpAds_config['dbname']         = '@db.name';

// Constants
define('phpAds_adminDb', 1);
define('phpAds_rawDb',   2);

// Database table names
$phpAds_config['tbl_acls']                 = 'ox_acls';
$phpAds_config['tbl_adclicks']             = 'ox_adclicks';
$phpAds_config['tbl_adconversions']        = 'ox_adconversions';
$phpAds_config['tbl_adstats']              = 'ox_adstats';
$phpAds_config['tbl_adviews']              = 'ox_adviews';
$phpAds_config['tbl_affiliates']           = 'ox_affiliates';
$phpAds_config['tbl_agency']               = 'ox_agency';
$phpAds_config['tbl_application_variable'] = 'ox_application_variable';
$phpAds_config['tbl_banners']              = 'ox_banners';
$phpAds_config['tbl_cache']                = 'ox_cache';
$phpAds_config['tbl_campaigns']            = 'ox_campaigns';
$phpAds_config['tbl_campaigns_trackers']   = 'ox_campaigns_trackers';
$phpAds_config['tbl_clients']              = 'ox_clients';
$phpAds_config['tbl_config']               = 'ox_config';
$phpAds_config['tbl_conversionlog']        = 'ox_conversionlog';
$phpAds_config['tbl_images']               = 'ox_images';
$phpAds_config['tbl_session']              = 'ox_session';
$phpAds_config['tbl_targetstats']          = 'ox_targetstats';
$phpAds_config['tbl_trackers']             = 'ox_trackers';
$phpAds_config['tbl_userlog']              = 'ox_userlog';
$phpAds_config['tbl_variables']            = 'ox_variables';
$phpAds_config['tbl_variablevalues']       = 'ox_variablevalues';
$phpAds_config['tbl_zones']                = 'ox_zones';

// Database table name prefix
$phpAds_config['table_prefix'] = 'ox_';

// Database table type
$phpAds_config['table_type'] = 'MYISAM';

// Use persistent connections to the database
$phpAds_config['persistent_connections'] = false;

// Use INSERT DELAYED in logging functions?
$phpAds_config['insert_delayed'] = false;

// Database compatibility mode to insure Max
// won't disturb an available database connection
$phpAds_config['compatibility_mode'] = false;


/*********************************************************/
/* Max configuration                                     */
/*********************************************************/

// The URL to your Max installation
$phpAds_config['url_prefix'] = '@wt.host:@wt.port/@wt.basepath';

// The URL to your Max installation (via SSL)
$phpAds_config['ssl_url_prefix'] = '@wt.host:@wt.port/@wt.basepath';

// The URL to the Admin Interface
$phpAds_config['admin_url_prefix'] = '@wt.host:@wt.port/@wt.basepath';

// Is the admin interface enabled
$phpAds_config['ui_enabled'] = true;

// Only allow access to the admin interface if SSL is used
$phpAds_config['ui_forcessl'] = false;

// Instant prioritisation settings
$phpAds_config['admin_instant_update']    = true;
$phpAds_config['instant_update_priority'] = true;
$phpAds_config['instant_update_cache']    = true;


/*********************************************************/
/* Remote host and Geotracking configuration             */
/*********************************************************/

// Reverse DNS lookup remotes hosts?
$phpAds_config['reverse_lookup'] = false;

// Find the correct IP for users behind a proxy
$phpAds_config['proxy_lookup'] = false;

// Obfuscate source
$phpAds_config['obfuscate'] = false;

// Type of geotracking database
// Possible options: geoip, ip2country, mod_geoip or an empty string
$phpAds_config['geotracking_type'] = '';

// Location of the geotracking database
$phpAds_config['geotracking_location'] = '';

// Store the location of the user in the statistics
$phpAds_config['geotracking_stats'] = false;

// Store the result in a cookie for future reference (only in combination with beacon logging)
$phpAds_config['geotracking_cookie'] = false;


/*********************************************************/
/* Statistics and logging                                */
/*********************************************************/

// Enabled logging of adviews?
$phpAds_config['log_adviews'] = true;

// Enabled logging of adclicks?
$phpAds_config['log_adclicks'] = true;

// Enabled logging of adclicks?
$phpAds_config['log_adconversions'] = true;

// Log the source parameter
$phpAds_config['log_source'] = true;

// Log the hostname or IP address
$phpAds_config['log_hostname'] = true;

// Log only the IP address even if a hostname is available
$phpAds_config['log_iponly'] = true;

// Use beacons to log adviews
$phpAds_config['log_beacon'] = true;

// Hosts to ignore (don't count adviews coming from them)
$phpAds_config['ignore_hosts'] = array ();   // Example: array('slashdot.org', 'microsoft.com');

// Block logging of views for xx seconds after the last entry
// This is to prevent logging after each page reload
$phpAds_config['block_adviews'] = 0;

// Block logging of clicks for xx seconds after the last entry
// This is to prevent users from boosting the stats by clicking multiple times
$phpAds_config['block_adclicks'] = 0;

// Block logging of conversions for xx seconds after the last entry
// This is to prevent users from boosting the stats by clicking multiple times
$phpAds_config['block_adconversions'] = 0;

// Window for logging of conversions for xx seconds after a click
$phpAds_config['default_conversion_clickwindow'] = 0;

// Window for logging of conversions for xx seconds after a view
$phpAds_config['default_conversion_viewwindow'] = 0;


/*********************************************************/
/* P3P Privacy Policies                                  */
/*********************************************************/

// Use P3P Polices
$phpAds_config['p3p_policies'] = true;

// Compact policy
$phpAds_config['p3p_compact_policy'] = 'CUR ADM OUR NOR STA NID';

// Policy file location
// For example:
// $phpAds_config['p3p_policy_location'] = 'http://example.com/w3c/p3p.xml';
$phpAds_config['p3p_policy_location'] = '';


/*********************************************************/
/* Banner retrieval                                      */
/*********************************************************/

// Delivery caching type?
// Possible options: none, db, file or shm
$phpAds_config['delivery_caching'] = 'none';

// 3rd party click tracking - delimiter for our variables
$phpAds_config['click_tracking_delimiter'] = '__';

// Cache expiry in seconds
$phpAds_config['cacheExpire'] = 1200; // 20 minutes in seconds

// Use keywords for banner selection?
$phpAds_config['use_keywords'] = true;

// Use conditional keywords?
$phpAds_config['con_key'] = true;

// Use multiple keywords for banners in banner table?
$phpAds_config['mult_key'] = true;

// Use delivery limitations?
$phpAds_config['acl'] = true;

// Default banner, it is show when Max can't connect to the database or
// there are absolutely no banner to display. The banner is not logged.
// Enter the complete url (incl. http://) for the image and the target,
// or leave them empty if you don't want to show a banner when this happens.
$phpAds_config['default_banner_url'] = '';
$phpAds_config['default_banner_target'] = '';

// The URL to your web server banner type image directory
// For example:
// $phpAds_config['type_web_url'] = 'http://example.com/MaxMediaManager/images';
$phpAds_config['type_web_url'] = '';

// The URL to the web server for SSL images
// For example:
// $phpAds_config['type_web_ssl_url'] = 'https://example.com/MaxMediaManager/images';
$phpAds_config['type_web_ssl_url'] = '';


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
/* Max self configuration code - don't change            */
/*********************************************************/

define('phpAds_installed', true);

// Disable magic_quotes_runtime
set_magic_quotes_runtime(0);


/*********************************************************/
/* PHP compatibility tests - don't change                */
/*********************************************************/

// Deal with older versions of PHP
if (!function_exists('version_compare') || version_compare(phpversion(), "4.3.0", 'lt')) {
    include_once 'libraries/bc.php';
}

// Deal with PHP5
if (function_exists('version_compare') && version_compare(phpversion(), "5.0.0", 'ge')) {
    include_once 'libraries/5.php';
}

?>
