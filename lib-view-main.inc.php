<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Seed the random number generator
//mt_srand((double)microtime() * 1000000);
mt_srand(floor((isset($n) ? hexdec($n[0].$n[2].$n[3].$n[4].$n[5]): 1000000) * (double)microtime()));


/*********************************************************/
/* Create the HTML needed to display the banner          */
/*********************************************************/

function view_raw($what, $clientid=0, $target='', $source='', $withtext=0, $context=0)
{
	global $phpAds_config;
	
	
	// Include the need sub-libraries
	if (substr($what,0,5) == 'zone:')
	{
		if (!defined('LIBVIEWZONE_INCLUDED'))
			require (phpAds_path.'/lib-view-zone.inc.php');
	}
	else
	{
		if (!defined('LIBVIEWQUERY_INCLUDED'))
			require (phpAds_path.'/lib-view-query.inc.php');
		
		if (!defined('LIBVIEWDIRECT_INCLUDED'))
			require (phpAds_path.'/lib-view-direct.inc.php');
	}
	
	
	
	// If $clientid consists of alpha-numeric chars it is
	// not the clientid, but the target parameter.
	if(!ereg('^[0-9]+$', $clientid))
	{
		$target = $clientid;
		$clientid = 0;
	}
	
	
	// Open database connection
	phpAds_dbConnect();
	
	
	// Get one valid banner
	$row = phpAds_fetchBanner($what, $clientid, $context, $source);
	
	
	if (is_array($row) && $row['bannerid'] != '')
	{
		// Get HTML cache
		$outputbuffer = $row['htmlcache'];
		
		
		// Determine target
		if ($row['target'] == '')
		{
			if ($target == '') $target = '_blank';  // default
		}
		else
			$target = $row['target'];
		
		
		// Set basic variables
		$outputbuffer = str_replace ('{bannerid}', $row['bannerid'], $outputbuffer);
		$outputbuffer = str_replace ('{zoneid}', $row['zoneid'], $outputbuffer);
		$outputbuffer = str_replace ('{target}', $target, $outputbuffer);
		$outputbuffer = str_replace ('{source}', $source, $outputbuffer);
		
		
		// Add text below banner
		if ($withtext)
		{
			$outputbuffer = str_replace ('[bannertext]', '', $outputbuffer);
			$outputbuffer = str_replace ('[/bannertext]', '', $outputbuffer);
		}
		else
			$outputbuffer = eregi_replace ("\[bannertext\](.*)\[\/bannertext\]", '', $outputbuffer);
		
		
		// HTML/URL banner options
		if ($row['storagetype'] == 'html' || 
			$row['storagetype'] == 'url' || 
			$row['storagetype'] == 'network')
		{
			// Replace timestamp
			$outputbuffer = str_replace ('{timestamp}',	time(), $outputbuffer);
			$outputbuffer = str_replace ('%7Btimestamp%7D',	time(), $outputbuffer);
			
			// Replace random
			while (eregi ('(%7B|\{)random((%3A|:)([1-9]+)){0,1}(%7D|})', $outputbuffer, $matches))
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
			if ($phpAds_config['type_html_php'])
			{
				if (eregi ("(\<\?php(.*)\?\>)", $outputbuffer, $parser_regs))
				{
					// Extract PHP script
					$parser_php 	= $parser_regs[2];
					$parser_result 	= '';
					
					// Replace output function
					$parser_php = eregi_replace ("echo([^;]*);", '$parser_result .=\\1;', $parser_php);
					$parser_php = eregi_replace ("print([^;]*);", '$parser_result .=\\1;', $parser_php);
					$parser_php = eregi_replace ("printf([^;]*);", '$parser_result .= sprintf\\1;', $parser_php);
					
					// Split the PHP script into lines
					$parser_lines = explode (";", $parser_php);
					for ($parser_i = 0; $parser_i < sizeof($parser_lines); $parser_i++)
					{
						if (trim ($parser_lines[$parser_i]) != '')
							eval (trim ($parser_lines[$parser_i]).';');
					}
					
					// Replace the script with the result
					$outputbuffer = str_replace ($parser_regs[1], $parser_result, $outputbuffer);
				}
			}
		}
		
		
		// Prepare impression logging
		if ($phpAds_config['log_adviews'])
		{
			if (!$phpAds_config['log_beacon'])
			{
				// Log now
				phpAds_logImpression ($row['bannerid'], $row['clientid'], $row['zoneid'], $source);
			}
			else
			{
				// Add beacon image for logging
				if (ereg ("Mozilla/(1|2|3|4)", $GLOBALS['HTTP_USER_AGENT']) && !ereg("compatible", $GLOBALS['HTTP_USER_AGENT']))
				{
					$outputbuffer .= '<layer id="beacon_'.$row['bannerid'].'" width="0" height="0" border="0" visibility="hide">';
					$outputbuffer .= '<img src=\''.$phpAds_config['url_prefix'].'/adlog.php?bannerid='.$row['bannerid'].'&clientid='.$row['clientid'].'&zoneid='.$row['zoneid'].'&source='.$source.'&cb='.md5(uniqid('')).'\' width=\'0\' height=\'0\'>';
					$outputbuffer .= '</layer>';
				}
				else
					$outputbuffer .= '<img src=\''.$phpAds_config['url_prefix'].'/adlog.php?bannerid='.$row['bannerid'].'&clientid='.$row['clientid'].'&zoneid='.$row['zoneid'].'&source='.$source.'&cb='.md5(uniqid('')).'\' width=\'0\' height=\'0\' style=\'width: 0px; height: 0px;\'>';
			}
		}
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
			$outputbuffer = '<a href=\''.$phpAds_config['default_banner_target'].'\' target=\''.$target.'\'><img src=\''.$phpAds_config['default_banner_url'].'\' border=\'0\'></a>';
			
			return( array('html' => $outputbuffer, 
						  'bannerid' => '')
				  );
		}
	}
	
	phpAds_dbClose();
	
	return( array('html' => $outputbuffer, 
				  'bannerid' => $row['bannerid'],
				  'alt' => $row['alt'],
				  'width' => $row['width'],
				  'height' => $row['height'],
				  'url' => $row['url'],
				  'clientid' => $row['clientid'])
		  );
}



/*********************************************************/
/* Display a banner                                      */
/*********************************************************/

function view($what, $clientid=0, $target='', $source='', $withtext=0, $context=0)
{
	$output = view_raw($what, $clientid, "$target", "$source", $withtext, $context);
	print($output['html']);
	return($output['bannerid']);
}

?>
