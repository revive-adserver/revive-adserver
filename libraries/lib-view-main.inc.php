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


// Seed the random number generator
//mt_srand((double)microtime() * 1000000);
mt_srand(floor((isset($n) && strlen($n) > 5 ? hexdec($n[0].$n[2].$n[3].$n[4].$n[5]): 1000000) * (double)microtime()));


/*********************************************************/
/* Select the banner that needs to be displayed          */
/*********************************************************/

function view_raw($what, $clientid = 0, $target = '', $source = '', $withtext = 0, $context = 0, $richmedia = true)
{
	global $phpAds_config, $HTTP_SERVER_VARS;
	global $phpAds_followedChain;
	
	
	// If $clientid consists of alpha-numeric chars it is
	// not the clientid, but the target parameter.
	if(!preg_match('#^[0-9]+$#', $clientid))
	{
		$target = $clientid;
		$clientid = 0;
	}
	
	
	$found = false;
	
	// Reset followed zone chain
	$phpAds_followedChain = array();
	
	$first = true;
	
	while (($first || $what != '') && $found == false)
	{
		$first = false;
		if (substr($what,0,5) == 'zone:')
		{
			if (!defined('LIBVIEWZONE_INCLUDED'))
				require (phpAds_path.'/libraries/lib-view-zone.inc.php');
			
			$row = phpAds_fetchBannerZone($what, $clientid, $context, $source, $richmedia);
		}
		else
		{
			if (!defined('LIBVIEWDIRECT_INCLUDED'))
				require (phpAds_path.'/libraries/lib-view-direct.inc.php');
			
			$row = phpAds_fetchBannerDirect($what, $clientid, $context, $source, $richmedia);
		}
		
		if (is_array ($row))
			$found = true;
		else
			$what  = $row;
	}
	
	
	if ($found)
	{
		// Prepare impression logging
		if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
			phpAds_logImpression ($row['bannerid'], $row['clientid'], $row['zoneid'], $source);
	
		$row = array_merge($row, phpAds_getBannerDetails($row['bannerid']));
	
		return phpAds_prepareOutput($row, $target, $source, $withtext);
	}
	else
	{
		// An error occured, or there are no banners to display at all
		// Use the default banner if defined
		
		if ($phpAds_config['default_banner_target'] != '' && $phpAds_config['default_banner_url'] != '')
		{
			// Determine target
			if ($target == '') $target = '_blank';  // default
			
			// Show default banner
			$outputbuffer = '<a href=\''.$phpAds_config['default_banner_target'].'\' target=\''.$target.'\'><img src=\''.$phpAds_config['default_banner_url'].'\' border=\'0\' alt=\'\'></a>';
			
			// Return banner
			return( array('html' => $outputbuffer, 
						  'bannerid' => '')
				  );
		}
		
		return false;

	}
}



/*********************************************************/
/* Get all the information we need to display a banner   */
/*********************************************************/

function phpAds_getBannerDetails ($bannerid)
{
	global $phpAds_config;
	
	$cacheid = 'bannerid='.$bannerid;
	
	// Get cache
	if (!defined('LIBVIEWCACHE_INCLUDED'))
		@include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
	
	$cache = @phpAds_cacheFetch ($cacheid);
	
	if (!$cache)
	{
		$select = "
			SELECT
				".$phpAds_config['tbl_banners'].".bannerid as bannerid,
				".$phpAds_config['tbl_banners'].".clientid as clientid,
				".$phpAds_config['tbl_banners'].".priority as priority,
				".$phpAds_config['tbl_banners'].".contenttype as contenttype,
				".$phpAds_config['tbl_banners'].".storagetype as storagetype,
				".$phpAds_config['tbl_banners'].".filename as filename,
				".$phpAds_config['tbl_banners'].".imageurl as imageurl,
				".$phpAds_config['tbl_banners'].".url as url,
				".$phpAds_config['tbl_banners'].".htmlcache as htmlcache,
				".$phpAds_config['tbl_banners'].".width as width,
				".$phpAds_config['tbl_banners'].".height as height,
				".$phpAds_config['tbl_banners'].".weight as weight,
				".$phpAds_config['tbl_banners'].".seq as seq,
				".$phpAds_config['tbl_banners'].".target as target,
				".$phpAds_config['tbl_banners'].".alt as alt,
				".$phpAds_config['tbl_banners'].".block as block,
				".$phpAds_config['tbl_banners'].".capping as capping,
				".$phpAds_config['tbl_banners'].".compiledlimitation as compiledlimitation
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				".$phpAds_config['tbl_banners'].".bannerid = ".$bannerid;
			
		$res = phpAds_dbQuery ($select);
		$row = phpAds_dbFetchArray ($res);
		phpAds_cacheStore ($cacheid, $row);
	}
	else
	{
		// Unpack cache
		$row = $cache;
	}
	
	
	return $row;	
}



/*********************************************************/
/* Create the HTML needed to display the banner          */
/*********************************************************/

function phpAds_prepareOutput($row, $target, $source, $withtext)
{
	global $phpAds_config, $HTTP_SERVER_VARS;
	
	$outputbuffer = '';
		
	// Prepend
	if (isset($row['prepend']))
		$outputbuffer .= $row['prepend'];
		
	
	// Add HTML to the output buffer. If the HTML contains ActiveX code we need
	// to use a JavaScript workaround because the outcome of the Eolas lawsuit
	// agains Microsoft. Without these changes the user would get a warning dialogbox.
	if (!(strpos (strtolower($row['htmlcache']), "<object") === false) &&
	   (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'MSIE') && !strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Opera')))
	{
		if (!defined("phpAds_invocationType") || (phpAds_invocationType != 'adjs' && phpAds_invocationType != 'adlayer'))
			$outputbuffer .= "<script language='JavaScript' type='text/javascript' src='{url_prefix}/adx.js'></script>";
		
		$outputbuffer .= "<script language='JavaScript' type='text/javascript'>\n";
		$outputbuffer .= "<!--\n";
		$outputbuffer .= "var phpads_activex = \"";
		$outputbuffer .= str_replace('</', '<"+"/', addcslashes($row['htmlcache'], "\0..\37\"\\"));
		$outputbuffer .= "\";\n";
 		$outputbuffer .= "phpads_deliverActiveX(phpads_activex);\n";
 		$outputbuffer .= "//-->\n";
 		$outputbuffer .= "</script>";
	}
	else
	{
		$outputbuffer .= $row['htmlcache'];
	}
		
		
	// Append
	if (isset($row['append']))
		$outputbuffer .= $row['append'];
		
		
	// Determine target
	if ($row['target'] == '')
	{
		if ($target == '') $target = '_blank';  // default
	}
	else
		$target = $row['target'];
		
		
	// Determine source
	$source = urlencode($source);
		
		
	// Set basic variables
	$outputbuffer = str_replace ('{bannerid}', $row['bannerid'], $outputbuffer);
	$outputbuffer = str_replace ('{zoneid}', $row['zoneid'], $outputbuffer);
	$outputbuffer = str_replace ('{target}', $target, $outputbuffer);
	$outputbuffer = str_replace ('{source}', $source, $outputbuffer);
		
	// If SSL is used, make sure to use the https:// protocol
	if ($HTTP_SERVER_VARS['SERVER_PORT'] == 443) $phpAds_config['url_prefix'] = str_replace ('http://', 'https://', $phpAds_config['url_prefix']);
		
	// Replace url_prefix with the domain name that is actually used
		
	/**************************************************************************/
	/* WARNING: DO NOT MODIFY THESE LINES!                                    */
	/**************************************************************************/
	/* On the forums you might encounter posts suggesting that removing these */
	/* lines will solve problems regarding running local mode on a different  */
	/* virtual server. While it may seem that this is indeed true, it will    */
	/* cause problems with MANY other features. You simply can't run local    */
	/* mode on a different (virtual) server, so do not even try.              */
	/**************************************************************************/
	
	if (isset($HTTP_SERVER_VARS['HTTP_HOST']))
	{
		if (preg_match('#//[^/]+:[0-9]+/#', $phpAds_config['url_prefix']))
		{
			// The port was set using url_prefix, make sure this port
			// is used and not the port used by HTTP_HOST
			if (strpos($HTTP_SERVER_VARS['HTTP_HOST'], ':') > 0)
				list($real_host,) = explode(':', $HTTP_SERVER_VARS['HTTP_HOST']);
			else
				$real_host = $HTTP_SERVER_VARS['HTTP_HOST'];
		
			$phpAds_config['url_prefix'] = preg_replace ('#//[^/]+:([0-9]+)/#', '//'.$real_host.':\\1/', $phpAds_config['url_prefix']);			
		}
		else
			$phpAds_config['url_prefix'] = preg_replace ('#//[^/]+/#', '//'.$HTTP_SERVER_VARS['HTTP_HOST'].'/', $phpAds_config['url_prefix']);		
	}
	
	$outputbuffer = str_replace ('{url_prefix}', $phpAds_config['url_prefix'], $outputbuffer);
	
	
	// Add text below banner
	if ($withtext)
	{
		$outputbuffer = str_replace ('[bannertext]', '', $outputbuffer);
		$outputbuffer = str_replace ('[/bannertext]', '', $outputbuffer);
	}
	else
		$outputbuffer = preg_replace ("#\[bannertext\](.*)\[\/bannertext\]#", '', $outputbuffer);
	
	
	// HTML/URL banner options
	if ($row['storagetype'] == 'html' || 
		$row['storagetype'] == 'url' || 
		$row['storagetype'] == 'network')
	{
		// Replace timestamp
		$outputbuffer = str_replace ('{timestamp}',	time(), $outputbuffer);
		$outputbuffer = str_replace ('%7Btimestamp%7D',	time(), $outputbuffer);
		
		// Replace random
		while (preg_match ('#(%7B|\{)random((%3A|:)([0-9]+)){0,1}(%7D|})#i', $outputbuffer, $matches))
		{
			if ($matches[4])
				$randomdigits = $matches[4];
			else
				$randomdigits = 8;
			
			if (isset($lastdigits) && $lastdigits == $randomdigits)
				$randomnumber = $lastrandom;
			else
			{
				$randomnumber = '';
				
				for ($r=0; $r<$randomdigits; $r=$r+9)
					$randomnumber .= (string)mt_rand (111111111, 999999999);
				
				$randomnumber  = substr($randomnumber, 0 - $randomdigits);
			}
			
			$outputbuffer = str_replace ($matches[0], $randomnumber, $outputbuffer);
			
			$lastdigits = $randomdigits;
			$lastrandom = $randomnumber;
		}
	}
	
		
	// Parse PHP code inside HTML banners
	if ($row['storagetype'] == 'html')
	{
		if ($phpAds_config['type_html_php'] && preg_match_all ("#(\<(\?php|\?=|\?)(.*)\?\>)#Usi", $outputbuffer, $parser_regs, PREG_SET_ORDER))
		{
			while (list(,$parser_reg) = each($parser_regs))
			{
				// Extract PHP script
				if ($parser_reg[2] == '?php' || (ini_get ('short_open_tag') && ($parser_reg[2] == '?' || $parser_reg[2] == '?=')))
				{
					if ($parser_reg[2] == '?=')
					{
						@eval ('$parser_result = '.trim($parser_reg[3]).';');
					}
					else
					{
						$parser_php 	= $parser_reg[3].';';
						$parser_result 	= '';
							
						// Replace output function
						$parser_php = preg_replace ("#echo([^;]*);#i", '$parser_result .=\\1;', $parser_php);
						$parser_php = preg_replace ("#printf([^;]*);#i", '$parser_result .= sprintf\\1;', $parser_php);
						$parser_php = preg_replace ("#print([^;]*);#i", '$parser_result .=\\1;', $parser_php);
						
						// Split the PHP script into lines
						$parser_lines = explode (";", $parser_php);
						for ($parser_i = 0; $parser_i < sizeof($parser_lines); $parser_i++)
						{
							if (trim ($parser_lines[$parser_i]) != '')
								@eval (trim ($parser_lines[$parser_i]).';');
						}
					}
					
					// Replace the script with the result
					$outputbuffer = str_replace ($parser_reg[1], $parser_result, $outputbuffer);
				}
			}
		}
	}
		
		
	// Add beacon image for logging and setting cookies
	if (isset($HTTP_SERVER_VARS['HTTP_USER_AGENT']) && preg_match("#Mozilla/(1|2|3|4)#", $HTTP_SERVER_VARS['HTTP_USER_AGENT']) && !preg_match("#compatible#", $HTTP_SERVER_VARS['HTTP_USER_AGENT']))
	{
		$outputbuffer .= '<layer id="beacon_'.$row['bannerid'].'" width="0" height="0" border="0" visibility="hide">';
		$outputbuffer .= '<img src=\''.$phpAds_config['url_prefix'].'/adlog.php?bannerid='.$row['bannerid'].'&amp;clientid='.$row['clientid'].'&amp;zoneid='.$row['zoneid'].'&amp;source='.$source.'&amp;block='.$row['block'].'&amp;capping='.$row['capping'].'&amp;cb='.md5(uniqid('', 1)).'\' width=\'0\' height=\'0\' alt=\'\'>';
		$outputbuffer .= '</layer>';
	}
	else
	{
		$outputbuffer .= '<div id="beacon_'.$row['bannerid'].'" style="position: absolute; left: 0px; top: 0px; visibility: hidden;">';
		$outputbuffer .= '<img src=\''.$phpAds_config['url_prefix'].'/adlog.php?bannerid='.$row['bannerid'].'&amp;clientid='.$row['clientid'].'&amp;zoneid='.$row['zoneid'].'&amp;source='.$source.'&amp;block='.$row['block'].'&amp;capping='.$row['capping'].'&amp;cb='.md5(uniqid('', 1)).'\' width=\'0\' height=\'0\' alt=\'\' style=\'width: 0px; height: 0px;\'>';
		$outputbuffer .= '</div>';
	}
		
		
	// Return banner
	return( array('html' => $outputbuffer, 
				  'bannerid' => $row['bannerid'],
				  'alt' => $row['alt'],
				  'width' => $row['width'],
				  'height' => $row['height'],
				  'url' => $row['url'],
				  'clientid' => $row['clientid'],
				  'campaignid' => $row['clientid'])
	);
	
}



/*********************************************************/
/* Display a banner                                      */
/*********************************************************/

function view($what, $clientid = 0, $target = '', $source = '', $withtext = 0, $context = 0, $richmedia = true)
{
	$output = view_raw($what, $clientid, "$target", "$source", $withtext, $context, $richmedia);

	if (is_array($output))
	{
		echo $output['html'];
		return $output['bannerid'];
	}
	
	return false;
}

?>