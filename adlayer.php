<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php");
require (phpAds_path."/lib-io.inc.php");
require (phpAds_path."/lib-db.inc.php");

if (($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon']) || $phpAds_config['acl'])
{
	require (phpAds_path."/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
		require (phpAds_path."/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/lib-acl.inc.php");
}

require	(phpAds_path."/lib-view-main.inc.php");
require (phpAds_path."/lib-cache.inc.php");



/*********************************************************/
/* Java-encodes text                                     */
/*********************************************************/

function enjavanate ($str, $limit = 60)
{
	$str   = str_replace("\r", '', $str);
	
	print "var phpadsbanner = '';\n\n";
	
	while (strlen($str) > 0)
	{
		$line = substr ($str, 0, $limit);
		$str  = substr ($str, $limit);
		
		$line = str_replace('\\', "\\\\", $line);
		$line = str_replace('\'', "\\'", $line);
		$line = str_replace("\r", '', $line);
		$line = str_replace("\n", "\\n", $line);
		$line = str_replace("\t", "\\t", $line);
		$line = str_replace('<', "<'+'", $line);
		
		print "phpadsbanner += '$line';\n";
	}
	
	print "\ndocument.write(phpadsbanner);\n";
}



/*********************************************************/
/* Return browser type, version and platform             */
/*********************************************************/

function phpAds_getUserAgent()
{
	global $HTTP_SERVER_VARS;
	
	if (ereg('MSIE ([0-9].[0-9]{1,2})(.*Opera ([0-9].[0-9]{1,2}))?', $HTTP_SERVER_VARS['HTTP_USER_AGENT'], $log_version))
	{
		if ($log_version[3])
		{
			$ver = $log_version[3];
			$agent = 'Opera';
		}
		else
		{
			$ver = $log_version[1];
			$agent = 'IE';
		}
	}
	elseif (ereg('Opera ([0-9].[0-9]{1,2})', $HTTP_SERVER_VARS['HTTP_USER_AGENT'], $log_version))
	{
		$ver = $log_version[1];
		$agent = 'Opera';
	}
	elseif (ereg('Mozilla/([0-9].[0-9]{1,2})', $HTTP_SERVER_VARS['HTTP_USER_AGENT'], $log_version))
	{
		$ver = $log_version[1];
		$agent = 'Mozilla';
	}
	elseif (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Konqueror') && ereg('([0-9].[0-9]{1,2})', $HTTP_SERVER_VARS['HTTP_USER_AGENT'], $log_version))
	{
		$ver = $log_version[1];
		$agent = 'Konqueror';
	}
	else
	{
		$ver = 0;
		$agent = 'Other';
	}
	
	if (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Win'))
		$platform = 'Win';
	else if (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Mac'))
		$platform = 'Mac';
	else if (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Linux'))
		$platform = 'Linux';
	else if (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Unix'))
		$platform = 'Unix';
	else
		$platform = 'Other';
	
	return array(
		'agent' => $agent,
		'version' => $ver,
		'platform' => $platform
	);
}



/*********************************************************/
/* Register input variables                              */
/*********************************************************/

phpAds_registerGlobal ('what', 'clientid', 'clientID', 'context',
					   'target', 'source', 'withtext', 'withText',
					   'layerstyle');



/*********************************************************/
/* Main code                                             */
/*********************************************************/

header("Content-type: application/x-javascript");
require("lib-cache.inc.php");

if (isset($clientID) && !isset($clientid)) $clientid = $clientID;
if (isset($withText) && !isset($withtext)) $withtext = $withText;

if (!isset($what)) $what = '';
if (!isset($clientid)) $clientid = 0;
if (!isset($target)) $target = '';
if (!isset($source)) $source = '';
if (!isset($withtext)) $withtext = '';
if (!isset($context)) $context = '';

if (!isset($layerstyle) || empty($layerstyle)) $layerstyle = 'geocities';


// Include layerstyle
require(phpAds_path.'/misc/layerstyles/'.$layerstyle.'/layerstyle.inc.php');

$limitations = phpAds_getLayerLimitations();

if ($limitations['compatible'])
{
	$output = view_raw ($what, $clientid, $target, $source, $withtext, $context, $limitations['richmedia']);
	
	// Exit if no matching banner was found
	if (!$output) exit;
	
	$uniqid = substr(md5(uniqid('')), 0, 8);
	enjavanate(phpAds_getLayerHTML($output, $uniqid));
	phpAds_putLayerJS($output, $uniqid);
}

?>