<?

// MySQL hostname
$phpAds_hostname = "localhost";

// MySQL username
$phpAds_mysqluser = "mysqlusername";

// MySQL password
$phpAds_mysqlpassword = "mysqlpassword";

// The database phpAds lives in
$phpAds_db = "phpads";

// phpAds' database tables
$phpAds_tbl_adclicks = "adclicks";
$phpAds_tbl_adviews = "adviews";
$phpAds_tbl_adstats = "adstats";
$phpAds_tbl_banners = "banners";
$phpAds_tbl_clients = "clients";
$phpAds_tbl_session = "session";
$phpAds_tbl_acls = "acls";


// Use compact hourly stats or verbose (with host, etc.)
$phpAds_compact_stats = 1;

// The URL to your phpAds-installation
$phpAds_url_prefix = "http://www.your-url.com/phpAdsNew";

// Use INSERT DELAYED in logging functions?
$phpAds_insert_delayed = false;

// Your language file
$phpAds_language = "english";

// Enabled logging of adviews?
$phpAds_log_adviews = true;

// Enabled logging of adclicks?
$phpAds_log_adclicks = true;

// Admins's username
$phpAds_admin = "phpadsuser";

// Admin's password
$phpAds_admin_pw = "phpadspass";

// Admin's full name (used when sending stats via email)
$phpAds_admin_fullname = "Your Name";

// Admin's email address (used to set the FROM-address when sending email)
$phpAds_admin_email = "your@email.com";

//Mail Headers for the reflection of the sender of the daily ad reports
$phpAds_admin_email_headers = "From: $phpAds_admin_email \n";

// The name of this application
$phpAds_name = "phpAdsNew";

// Hosts to ignore (don't count adviews coming from them)
$phpAds_ignore_hosts = array();   // Example: array("slashdot.org", "microsoft.com");

// Reverse DNS lookup remotes hosts?
$phpAds_reverse_lookup = false;

// Use random or sequential banner retrieval? (0=random, 1=sequential)
$phpAds_random_retrieve = "0";

// Use conditional keywords? (0=no, 1=yes)
$phpAds_con_key = "1";

// Use multiple keywords for banners in banner table? (0=no, 1=yes)
$phpAds_mult_key = "1";

// E-mail admin when clicks/views get low? (0=no, 1=yes)
$phpAds_warn_admin = "1";

// E-mail client when clicks/views get low? (0=no, 1=yes)
$phpAds_warn_client = "1";

// Company Name
$phpAds_company_name = "mysite.com";

// Minimum clicks/views before warning e-mail is sent
$phpAds_warn_limit = "100"; 

// Disable magic_quotes_runtime - don't change
set_magic_quotes_runtime(0);

// weeks start on sundays if "0", on mondays if "1"
$phpAds_begin_of_week = "1";

// Precision of showing percentage results
$phpAds_percentage_decimals = "1";

// standard colors
$phpAds_table_border_color = "#000099";
$phpAds_table_back_color = "#CCCCCC";
$phpAds_table_back_color_alternative = "#F7F7F7";
$phpAds_main_back_color = "#FFFFFF";

$phpAds_persistent_connections = "0";


if (empty($phpAds_path)) {
    if (strlen(__FILE__) > strlen(basename(__FILE__)))
        $phpAds_path=substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__)) - 1);
    // If this path doesn't work for you, customize it here like this
    // $phpAds_path="/home/myname/www/phpAdsNew";       // Note: no trailing backslash
}

if (empty($phpAds_path))
    $phpAds_path = ".";

?>
