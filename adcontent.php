<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
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

		
echo "<html>\n";
echo "<head>\n";
echo "\t<title>".($row['alt'] ? $row['alt'] : 'Advertisement')."</title>\n";
		
if (isset($timeout) && $timeout > 0)
{
	echo "<script language='JavaScript'>\n";
	echo "<!--\n";
	echo "\twindow.setTimeout(\"window.close()\", ".($timeout * 1000).");\n";
	echo "// -->\n";
	echo "</script>\n";			
}
		
echo "</head>\n";
echo "<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>\n";

echo $output['html'];
echo "\n</body>\n";
echo "</html>\n";

?>