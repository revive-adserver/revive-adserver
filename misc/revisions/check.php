<?php

// Determine the location of phpAdsNew on the server
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', ereg_replace("[/\\\\]misc[/\\\\].+$", '', __FILE__));
else
    define ('phpAds_path', '../..');


include (phpAds_path."/libraries/lib-revisions.inc.php");


// Starting scan
if ($result = phpAds_revisionCheck())
{
	list ($direct, $fatal, $message) = $result;
	
	if ($direct)
		echo "This message should be shown without loading the gui, just plain text: <hr>";
	
	if ($fatal)
		echo "<strong>Error:</strong><br>";
	else
		echo "<strong>Warning:</strong><br>";
	
	echo nl2br($message);
}
else
{
	echo "All files are okay!";
}

?>