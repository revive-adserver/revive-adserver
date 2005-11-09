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
if ($result = phpAds_revisionCheck())
{
	list ($direct, $fatal, $message) = $result;
	
	if ($direct)
		echo "This message should be shown without loading the gui, just plain text:\n\n";
	
	if ($fatal)
		echo "Error:\n";
	else
		echo "Warning:\n";
	
	
	echo implode("\n- ", $message)."\n";
}
else
{
	echo "All files are okay!\n";
}

?>