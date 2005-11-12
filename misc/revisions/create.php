<?php

// Security check
if (php_sapi_name() != 'cli')
	die('This file is meant to be run through php-cli');



// Determine the location of phpAdsNew on the server
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', ereg_replace("[/\\\\]misc[/\\\\].+$", '', __FILE__));
else
    define ('phpAds_path', '../..');


include (phpAds_path."/libraries/lib-dbconfig.inc.php");
include (phpAds_path."/libraries/lib-revisions.inc.php");

// Starting scan
echo "Starting scan\n";

if (phpAds_revisionCreate())
{
	echo "Revision file succesfully created!\n";

	die(0);
}
else
{
	echo "<strong>Error:</strong> Failed to create a new revision file\n";

	die(1);
}

?>