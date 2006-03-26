<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Figure out our location
define ('phpAds_path', '.');


// Set invocation type
define ('phpAds_invocationType', 'adlayer');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php");
require (phpAds_path."/libraries/lib-io.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");

if (($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon']) || $phpAds_config['acl'])
{
	require (phpAds_path."/libraries/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
		require (phpAds_path."/libraries/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/libraries/lib-limitations.inc.php");
}

require	(phpAds_path."/libraries/lib-view-main.inc.php");
require (phpAds_path."/libraries/lib-cache.inc.php");



/*********************************************************/
/* Java-encodes text                                     */
/*********************************************************/

function enjavanate ($str, $limit = 0)
{
	$str   = str_replace("\r", '', $str);
	
	print "var phpadsbanner = '';\n\n";
	
	while (strlen($str) > 0)
	{
		if ($limit)
		{
			$line = substr ($str, 0, $limit);
			$str  = substr ($str, $limit);
		}
		else
		{
			$line = $str;
			$str  = '';
		}
		
		$line = addcslashes($line, "\0..\37'\\");
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
	
	if (preg_match('#MSIE ([0-9].[0-9]{1,2})(.*Opera ([0-9].[0-9]{1,2}))?#', $HTTP_SERVER_VARS['HTTP_USER_AGENT'], $log_version))
	{
		if (isset($log_version[3]))
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
	elseif (preg_match('#Opera ([0-9].[0-9]{1,2})#', $HTTP_SERVER_VARS['HTTP_USER_AGENT'], $log_version))
	{
		$ver = $log_version[1];
		$agent = 'Opera';
	}
	elseif (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Safari') && preg_match('#Safari/([0-9]{1,3})#', $HTTP_SERVER_VARS['HTTP_USER_AGENT'], $log_version))
	{
		$ver = $log_version[1];
		$agent = 'Safari';
	}
	elseif (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Konqueror') && preg_match('#Konqueror/([0-9])#', $HTTP_SERVER_VARS['HTTP_USER_AGENT'], $log_version))
	{
		$ver = $log_version[1];
		$agent = 'Konqueror';
	}
	elseif (preg_match('#Mozilla/([0-9].[0-9]{1,2})#', $HTTP_SERVER_VARS['HTTP_USER_AGENT'], $log_version))
	{
		$ver = $log_version[1];
		$agent = 'Mozilla';
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
require("libraries/lib-cache.inc.php");

if (isset($clientID) && !isset($clientid)) $clientid = $clientID;
if (isset($withText) && !isset($withtext)) $withtext = $withText;

if (!isset($what)) $what = '';
if (!isset($clientid)) $clientid = 0;
if (!isset($target)) $target = '';
if (!isset($source)) $source = '';
if (!isset($withtext)) $withtext = '';
if (!isset($context)) $context = '';

// Remove referer, to be sure it doesn't cause problems with limitations
if (isset($HTTP_SERVER_VARS['HTTP_REFERER'])) unset($HTTP_SERVER_VARS['HTTP_REFERER']);
if (isset($HTTP_REFERER)) unset($HTTP_REFERER);

// Sanitize layerstyle variable
if (!isset($layerstyle) || empty($layerstyle) || preg_match('/[^a-z0-9_-]/i', $layerstyle))
	$layerstyle = 'geocities';


// Include layerstyle
require(phpAds_path.'/libraries/layerstyles/'.$layerstyle.'/layerstyle.inc.php');

$limitations = phpAds_getLayerLimitations();

if ($limitations['compatible'])
{
	$output = view_raw ($what, $clientid, $target, $source, $withtext, $context, $limitations['richmedia']);
	
	// Exit if no matching banner was found
	if (!$output) exit;
	
	$uniqid = substr(md5(uniqid('', 1)), 0, 8);
	enjavanate(phpAds_getLayerHTML($output, $uniqid));
	phpAds_putLayerJS($output, $uniqid);
}

?>