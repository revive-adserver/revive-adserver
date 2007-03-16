<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Figure out our location
define ('phpAds_path', '.');


// Set invocation type
define ('phpAds_invocationType', 'adcontent');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/libraries/lib-io.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");
require	(phpAds_path."/libraries/lib-view-main.inc.php");
require (phpAds_path."/libraries/lib-cache.inc.php");



/*********************************************************/
/* Register input variables                              */
/*********************************************************/

phpAds_registerGlobal ('bannerid', 'zoneid', 'source', 'timeout');



/*********************************************************/
/* Main code                                             */
/*********************************************************/


if (!isset($bannerid)) $bannerid = 0;


if (isset($zoneid) && $zoneid > 0)
{
	if (!defined('LIBVIEWCACHE_INCLUDED'))
		@include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
	
	$cache = phpAds_cacheFetch ('what=zone:'.(int)$zoneid);
	
	list ($zoneid,, $what, $prioritysum, $chain, $prepend, $append) = $cache;
	
	$row['bannerid'] = (int)$bannerid;
	$row['zoneid'] = $zoneid;
	$row['prepend'] = $prepend;
	$row['append'] = $append;
}
else
{
	$row['bannerid'] = (int)$bannerid;
	$row['zoneid'] = 0;
}


// Get the data we need to display the banner
$details = phpAds_getBannerDetails($row['bannerid']);

// Exit if no banner was found
if (!is_array($details)) die();

$row = array_merge($row, $details);
$output = phpAds_prepareOutput($row, '_blank', $source, false);

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . 
     "\n" .
      '<html xmlns="http://www.w3.org/1999/xhtml">';
echo "\n";
echo "<head>\n";
echo "\t<title>".($row['alt'] ? $row['alt'] : 'Advertisement')."</title>\n";
		
if (isset($timeout) && $timeout > 0)
{
	echo '<script type="text/javascript">', "\n";
	echo '<!--// <![CDATA[';
	echo "\n";
	echo "\twindow.setTimeout(\"window.close()\", ".($timeout * 1000).");\n";
	echo '// ]]> -->', "\n";	    
	echo "</script>\n";			
}
echo '<style type="text/css"><!--', "\n", 'body{margin:0;}', "\n", '--></style>', "\n";
echo "</head>\n";
echo "<body>\n";

echo $output['html'];
echo "\n</body>\n";
echo "</html>\n";

?>