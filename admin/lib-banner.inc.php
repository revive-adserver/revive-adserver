<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


function phpAds_getBannerTemplate($type)
{
	if ($type == 'swf')
	{
		$buffer  = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' ";
		$buffer .= "codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/";
		$buffer .= "swflash.cab#version={pluginversion:4,0,0,0}' width='{width}' height='{height}'>";
		$buffer .= "<param name='movie' value='{imageurl}{swf_con}{swf_param}'>";
		$buffer .= "<param name='quality' value='high'>";
		$buffer .= "<embed src='{imageurl}{swf_con}{swf_param}' quality=high ";
		$buffer .= "width='{width}' height='{height}' type='application/x-shockwave-flash' ";
		$buffer .= "pluginspace='http://www.macromedia.com/go/getflashplayer'></embed>";
		$buffer .= "</object>";
	}
	elseif ($type == 'dcr')
	{
		$buffer  = "<object classid='clsid:166B1BCA-3F9C-11CF-8075-444553540000' ";
		$buffer .= "codebase='http://download.macromedia.com/pub/shockwave/cabs/director/";
		$buffer .= "swdir85r321.cab#version={pluginversion:8,5,0,321}' width='{width}' height='{height}'>";
		$buffer .= "<param name='src' value='{imageurl}'>";
		$buffer .= "<param name='swStretchStyle' value='fill'>";
		$buffer .= "<param name='quality' value='high'>";
		$buffer .= "<param name='swRemote' value=\"swSaveEnabled='false' swVolume='false' swRestart='false' swPausePlay='false' swFastForward='false' swContextMenu='false'\">";
		$buffer .= "<param name='bgColor' value='#FFFFFF'>";
		$buffer .= "<param name='progress' value='false'>";
 		$buffer .= "<param name='logo' value='false'>";
 		$buffer .= "<embed src='{imageurl}' quality=high ";
		$buffer .= "width='{width}' height='{height}' type='application/x-director' ";
		$buffer .= "bgColor='#FFFFFF' progress='false' logo=false' swRemote=\"swSaveEnabled='false' swVolume='false' swRestart='true' swPausePlay='true' swFastForward='true' swContextMenu='true'\" swStretchStyle=fill ";
		$buffer .= "pluginspace='http://www.macromedia.com/shockwave/download/'></embed>";
		$buffer .= "</object>";
	}
	elseif ($type == 'rpm')
	{
		$buffer  = "<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' ";
		$buffer .= "width='{width}' height='{height}'>";
		$buffer .= "<param name='src' value='{imageurl}'>";
		$buffer .= "<param name='controls' value='ImageWindow'>";
		$buffer .= "<param name='autostart' value='true'>";
		$buffer .= "<embed src='{imageurl}' controls='ImageWindow' autostart='true' ";
		$buffer .= "width='{width}' height='{height}' type='audio/x-pn-realaudio-plugin'></embed>";
		$buffer .= "</object>";
	}
	elseif ($type == 'mov')
	{
		$buffer  = "<object classid='clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B' ";
		$buffer .= "codebase='http://www.apple.com/qtactivex/qtplugin.cab' ";
		$buffer .= "width='{width}' height='{height}'>";
		$buffer .= "<param name='src' value='{imageurl}'>";
		$buffer .= "<param name='controller' value='false'>";
		$buffer .= "<param name='autoplay' value='true'>";
		$buffer .= "<embed src='{imageurl}' controller='false' autoplay='true' ";
		$buffer .= "width='{width}' height='{height}' pluginspace='http://www.apple.com/quicktime/download/'></embed>";
		$buffer .= "</object>";
	}
	elseif ($type == 'txt')
	{
		$buffer  = "[targeturl]<a href='{targeturl}' target='{target}'";
		$buffer .= "[status] onMouseOver=\"self.status='{status}'; return true;\" onMouseOut=\"self.status='';return true;\"[/status]>";
		$buffer .= "[/targeturl]{bannertext}[targeturl]</a>[/targeturl]";
	}
	else
	{
		$buffer  = "[targeturl]<a href='{targeturl}' target='{target}'";
		$buffer .= "[status] onMouseOver=\"self.status='{status}'; return true;\" onMouseOut=\"self.status='';return true;\"[/status]>";
		$buffer .= "[/targeturl]<img src='{imageurl}' width='{width}' height='{height}' alt='{alt}' title='{alt}' border='0'";
		$buffer .= "[nourl][status] onMouseOver=\"self.status='{status}'; return true;\" onMouseOut=\"self.status='';return true;\"";
		$buffer .= "[/status][/nourl]>[targeturl]</a>[/targeturl]";
	}
	
	// Text below banner
	if ($type != 'txt')
	{
		$buffer .= "[bannertext]<br>[targeturl]<a href='{targeturl}' target='{target}'";
		$buffer .= "[status] onMouseOver=\"self.status='{status}'; return true;\" onMouseOut=\"self.status='';return true;\"[/status]>";
		$buffer .= "[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]";
	}
	
	return ($buffer);
}


function phpAds_getBannerCache($banner)
{
	global $phpAds_config;
	
	$buffer = $banner['htmltemplate'];
	
	
	// Strip slashes from urls
	$banner['url'] 		= stripslashes($banner['url']);
	$banner['imageurl'] = stripslashes($banner['imageurl']);
	
	
	// The following properties depend on data from the invocation process
	// and can't yet be determined: {zoneid}, {bannerid}
	// These properties will be set during invocation
	
	
	// Banner Networks
	if ($banner['storagetype'] == 'network')
		$buffer = phpAds_parseNetworkInfo ($buffer);
	
	
	// Auto change HTML banner
	if ($banner['storagetype'] == 'html' || $banner['storagetype'] == 'network')
	{
		if ($banner['autohtml'] == 't' && $phpAds_config['type_html_auto'])
		{
			if ($buffer != '')
			{
				// Automatic remove all target='...'
				$buffer = eregi_replace (" target=['|\"]{0,1}[^'|\"|[:space:]]+['|\"]{0,1}", " ", $buffer);
				
				// Determine which types are present in the HTML
				$formpresent = eregi('<form', $buffer);
				$linkpresent = eregi('<a', $buffer);
				$areapresent = eregi('<area', $buffer);
				
				if ($formpresent)
				{
					// Add hidden field to forms
					$buffer = eregi_replace ("(<form([^>]*)action=['|\"]{0,1})([^'|\"|[:space:]]+)(['|\"]{0,1}([^>]*)>)", 
							  			     "\\1{url_prefix}/adclick.php\\4".
										     "<input type='hidden' name='dest' value='\\3'>".
										     "<input type='hidden' name='bannerid' value='{bannerid}'>".
										     "<input type='hidden' name='source' value='{source}'>".
										     "<input type='hidden' name='zoneid' value='{zoneid}'>", $buffer);
					
					// Add target to all URLs
					$buffer = eregi_replace ("<form ", "<form target='{target}' ", $buffer);
				}
				
				// Process link and areas
				if ($linkpresent || $areapresent)
				{
					// Replace all links with adclick.php
					
					$newbanner	 = '';
					$prevhrefpos = '';
					
					$lowerbanner = strtolower($buffer);
					$hrefpos	 = strpos($lowerbanner, 'href=');
					
					while ($hrefpos > 0)
					{
						$tagpos = $hrefpos;
						$taglength = 0;
						
						// travel back to first '<' found
						while (substr($lowerbanner, $tagpos - 1, 1) != '<')
							$tagpos--;
						
						// travel up to next space
						while (substr($lowerbanner, $tagpos + $taglength, 1) != ' ')
							$taglength++;
						
						$tag = substr($lowerbanner, $tagpos, $taglength);
						
						
						// Do not convert href's inside of link tags
						// because if external css files are used an
						// adclick is logged for every impression.
						if ($tag != 'link' &&
							$tag != 'base')
						{
							$hrefpos = $hrefpos + 5;
							$doublequotepos = strpos($lowerbanner, '"', $hrefpos);
							$singlequotepos = strpos($lowerbanner, "'", $hrefpos);
							
							if ($doublequotepos > 0 && $singlequotepos > 0)
							{
								if ($doublequotepos < $singlequotepos)
								{
									$quotepos  = $doublequotepos;
									$quotechar = '"';
								}
								else
								{
									$quotepos  = $singlequotepos;
									$quotechar = "'";
								}
							}
							else
							{
								if ($doublequotepos > 0)
								{
									$quotepos  = $doublequotepos;
									$quotechar = '"';
								}
								elseif ($singlequotepos > 0)
								{
									$quotepos  = $singlequotepos;
									$quotechar = "'";
								}
								else
									$quotepos  = 0;
							}
							
							if ($quotepos > 0)
							{
								$endquotepos = strpos($lowerbanner, $quotechar, $quotepos+1);
								
								if (substr ($buffer, $quotepos+1, 10) != '{targeturl' &&
									strtolower(substr ($buffer, $quotepos+1, 11)) != 'javascript:' &&
									strtolower(substr ($buffer, $quotepos+1, 7)) != 'mailto:')
								{
									$newbanner = $newbanner . 
											substr($buffer, $prevhrefpos, $hrefpos - $prevhrefpos) . 
											$quotechar . '{url_prefix}/adclick.php?bannerid=' . 
											'{bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;dest=' . 
											urlencode(substr($buffer, $quotepos+1, $endquotepos - $quotepos - 1)) .
											'&amp;ismap=';
								}
								else
								{
									$newbanner = $newbanner . 
											substr($buffer, $prevhrefpos, $hrefpos - $prevhrefpos) . $quotechar . 
											substr($buffer, $quotepos+1, $endquotepos - $quotepos - 1);
								}
								
								$prevhrefpos = $hrefpos + ($endquotepos - $quotepos);
							}
							else
							{
								$spacepos = strpos($lowerbanner, ' ', $hrefpos+1);
								$endtagpos = strpos($lowerbanner, '>', $hrefpos+1);
								
								if ($spacepos < $endtagpos)
									$endpos = $spacepos;
								else
									$endpos = $endtagpos;
								
								if (substr($buffer, $hrefpos, 10) != '{targeturl' &&
									strtolower(substr($buffer, $hrefpos, 11)) != 'javascript:' &&
									strtolower(substr($buffer, $hrefpos, 7)) != 'mailto:')
								{
									$newbanner = $newbanner . 
											substr($buffer, $prevhrefpos, $hrefpos - $prevhrefpos) . 
											'"' . '{url_prefix}/adclick.php?bannerid=' . 
											'{bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;dest=' . 
											urlencode(substr($buffer, $hrefpos, $endpos - $hrefpos)) .
											'&amp;ismap="';
								}
								else
								{
									$newbanner = $newbanner . 
											substr($buffer, $prevhrefpos, $hrefpos - $prevhrefpos) . '"' . 
											substr($buffer, $hrefpos, $endpos - $hrefpos) . '"';
								}
								
								$prevhrefpos = $hrefpos + ($endpos - $hrefpos);
							}
						}
						
						$hrefpos = strpos($lowerbanner, 'href=', $hrefpos + 1);
					}
					
					$buffer = $newbanner.substr($buffer, $prevhrefpos);
					
					
					// Add target to all URLs
					$buffer = eregi_replace ("<a ", "<a target='{target}' ", $buffer);
					$buffer = eregi_replace ("<area ", "<area target='{target}' ", $buffer);
				}
				
				if (!$formpresent && !$linkpresent && !$areapresent && $banner['url'] != '')
				{
					// No link, area or form
					// Check if we really want to place the HTML code inside a link...
					// Do not do this if the HTML code contains an iframe, object or script tag,
					// Because we can then safely assume the link is handled by the HTML code itself
					
					if (!eregi('<script', $buffer) && !eregi('<object', $buffer) && !eregi('<iframe', $buffer))
						$buffer = "<a href='{url_prefix}/adclick.php?bannerid={bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;ismap=' target='{target}'>".$buffer."</a>";
				}
			}
			else
			{
				if ($banner['url'] != '')
				{
					// HTML banner is left empty, but destination url is specified,
					// build an iframe with the right width and height to show the
					// destination URL
					
					$buffer = "<iframe width='".$banner['width']."' height='".$banner['height']."' framespacing='0' frameborder='no' src='".$banner['url']."'>";
					$buffer = "</iframe>";
				}
			}
		}
		
		
		if (strpos ($buffer, "{targeturl:") > 0)
		{
			while (eregi("\{targeturl:([^\}]*)\}", $buffer, $regs))
			{
				if (strpos($regs[1], '|source:') != false)
				{
					list ($url, $source) = explode ('|source:', $regs[1]);
					
					if (substr($source, 0, 1) == '+')
						$source = '{source}-'.substr($source, 1, strlen($source) - 1);
				}
				else
				{
					$source = '{source}';
					$url    = $regs[1];
				}
				
				$buffer = str_replace ($regs[0], '{url_prefix}/adclick.php?bannerid={bannerid}&amp;zoneid={zoneid}&amp;source='.$source.'&amp;dest='.urlencode($url).'&amp;ismap=', $buffer);
			}
		}
		
		$buffer = str_replace ('{targeturl=}', '{url_prefix}/adclick.php?bannerid={bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;dest=', $buffer);
	}
	
	
	// Set known properties
	$buffer = str_replace ('{width}', 	$banner['width'], $buffer);
	$buffer = str_replace ('{height}', 	$banner['height'], $buffer);
	$buffer = str_replace ('{alt}', 	$banner['alt'], $buffer);
	
	
	// Set status text
	if (isset($banner['status']) && $banner['status'] != '')
	{
		$buffer = str_replace ('{status}', $banner['status'], $buffer);
		$buffer = str_replace ('[status]', '', $buffer);
		$buffer = str_replace ('[/status]', '', $buffer);
	}
	else
		$buffer = preg_replace ("#\[status\](.*)\[\/status\]#iU", '', $buffer);
	
	
	// Set bannertext
	if (isset($banner['bannertext']) && $banner['bannertext'] != '')
		$buffer = str_replace ('{bannertext}', $banner['bannertext'], $buffer);
	else
	{
		$buffer = str_replace ('{bannertext}', '', $buffer);
		$buffer = eregi_replace ("\[bannertext\](.*)\[\/bannertext\]", '', $buffer);
	}
	
	
	// Set imageurl
	if ($banner['storagetype'] == 'sql' || $banner['storagetype'] == 'web' || $banner['storagetype'] == 'url')
		$buffer = str_replace ('{imageurl}', $banner['imageurl'], $buffer);
	
	
	// Set flash variables
	if ($banner['contenttype'] == 'swf')
	{
		if ($banner['url'] != '')
			$buffer = str_replace ('{swf_param}', 'clickTAG={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest='.urlencode($banner['url']), $buffer);
		else
		{
			$buffer = str_replace ('{swf_con}{swf_param}', '', $buffer);
			$buffer = str_replace ('{swf_param}', '', $buffer);
		}
		
		switch ($banner['storagetype'])
		{
			case 'sql' : $buffer = str_replace('{swf_con}', '&amp;', $buffer); break;
			case 'web' : $buffer = str_replace('{swf_con}', '?', $buffer); break;
			case 'url' : $buffer = str_replace('{swf_con}', '?', $buffer); break;
		}
		
		// Replace targeturl:
		while (eregi("\{targeturl:([^\}]*)\}", $buffer, $matches))
		{
			if (strpos($matches[1], '|source:') != false)
			{
				list ($url, $source) = explode ('|source:', $matches[1]);
				
				if (substr($source, 0, 1) == '+')
					$source = '{source}-'.substr($source, 1, strlen($source) - 1);
			}
			else
			{
				$source = '{source}';
				$url    = $matches[1];
			}
			
			$buffer = str_replace ($matches[0],
								   '{url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source='.$source.'%26dest='.urlencode($url),
								   $buffer);
		}
	}
	
	
	// Replace targeturl
	if (isset($banner['url']) && $banner['url'] != '')
	{
		$buffer = str_replace ('{targeturl}', '{url_prefix}/adclick.php?bannerid={bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;dest='.urlencode($banner['url']), $buffer);
		
		$buffer = str_replace ('[targeturl]', '', $buffer);
		$buffer = str_replace ('[/targeturl]', '', $buffer);
		$buffer = preg_replace ("#\[nourl\](.*)\[\/nourl\]#iU", '', $buffer);
	}
	else
	{
		$buffer = str_replace ('{targeturl}', '', $buffer);
		
		$buffer = str_replace ('[nourl]', '', $buffer);
		$buffer = str_replace ('[/nourl]', '', $buffer);
		$buffer = preg_replace ("#\[targeturl\](.*)\[\/targeturl\]#iU", '', $buffer);
	}
	
	
	
	
	// Set Player version
	if (eregi("\{pluginversion:([^\}]*)\}", $buffer, $matches))
	{
		// Get default version
		$pluginversion = $matches[1];
		
		// Flash player 3 or higher
		if ($banner['contenttype'] == 'swf' && $banner['pluginversion'] > 4)
			$pluginversion = $banner['pluginversion'].',0,0,0';
		
		$buffer = str_replace ($matches[0], $pluginversion, $buffer);
	}
	
	
	// Append
	if (isset($banner['append']) && $banner['append'] != '')
		$buffer .= $banner['append'];
	
	
	return ($buffer);
}


function phpAds_rebuildBannerCache ($bannerid)
{
	global $phpAds_config;
	
	// Retrieve current values
	$res = phpAds_dbQuery ("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = '".$bannerid."'
	") or phpAds_sqlDie();
	
	$current = phpAds_dbFetchArray($res);
	
	
	// Add slashes to status to prevent javascript errors
	// NOTE: not needed in banner-edit because of magic_quotes_gpc
	$current['status'] = addslashes($current['status']);
	
	
	// Rebuild cache
	$current['htmltemplate'] = stripslashes($current['htmltemplate']);
	$current['htmlcache']    = addslashes(phpAds_getBannerCache($current));
	
	phpAds_dbQuery("
		UPDATE
			".$phpAds_config['tbl_banners']."
		SET
			htmlcache = '".$current['htmlcache']."'
		WHERE
			bannerid = '".$current['bannerid']."'
	") or phpAds_sqlDie();
}



function phpAds_compileLimitation ($bannerid = '')
{
	global $phpAds_config;
	
	if ($bannerid == '')
	{
		// Loop through all banners
		$res = phpAds_dbQuery("
			SELECT
				bannerid
			FROM
				".$phpAds_config['tbl_banners']."
		");
		
		while ($current = phpAds_dbFetchArray($res))
			phpAds_compileLimitation ($current['bannerid']);
	}
	else
	{
		// Compile limitation
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_acls']."
			WHERE
				bannerid = '".$bannerid."'
			ORDER BY
				executionorder
		") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray ($res))
		{
			$acl[$row['executionorder']]['logical'] 	= $row['logical'];
			$acl[$row['executionorder']]['type'] 		= $row['type'];
			$acl[$row['executionorder']]['comparison'] 	= $row['comparison'];
			$acl[$row['executionorder']]['data'] 		= addslashes($row['data']);
		}
		
		
		$expression = '';
		$i = 0;
		
		if (isset($acl) && count($acl))
		{
			reset($acl);
			while (list ($key,) = each ($acl))
			{
				if ($i > 0)
					$expression .= ' '.$acl[$key]['logical'].' ';
				
				switch ($acl[$key]['type'])
				{
					case 'clientip':
						$expression .= "phpAds_aclCheckClientIP(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'browser':
						$expression .= "phpAds_aclCheckUseragent(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'os':
						$expression .= "phpAds_aclCheckUseragent(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'useragent':
						$expression .= "phpAds_aclCheckUseragent(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'language':
						$expression .= "phpAds_aclCheckLanguage(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'country':
						$expression .= "phpAds_aclCheckCountry(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'continent':
						$expression .= "phpAds_aclCheckContinent(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'region':
						$expression .= "phpAds_aclCheckRegion(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'weekday':
						$expression .= "phpAds_aclCheckWeekday(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'domain':
						$expression .= "phpAds_aclCheckDomain(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'source':
						$expression .= "phpAds_aclCheckSource(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\', $"."source)";
						break;
					case 'time':
						$expression .= "phpAds_aclCheckTime(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'date':
						$expression .= "phpAds_aclCheckDate(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					case 'referer':
						$expression .= "phpAds_aclCheckReferer(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['comparison']."\')";
						break;
					default:
						return(0);
				}
				
				$i++;
			}
		}
		
		if ($expression == '')
			$expression = 'true';
		
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_banners']."
			SET
				compiledlimitation='".$expression."'
			WHERE
				bannerid='".$bannerid."'
		") or phpAds_sqlDie();
	}
}






function phpAds_AvailableNetworks()
{
	$networks = array();
	
	if (@file_exists(phpAds_path."/admin/networks/"))
	{
		$networkdir = @opendir(phpAds_path."/admin/networks/");
		
		while ($networkfile = @readdir($networkdir))
			if (!@is_dir(phpAds_path."/admin/networks/".$networkfile))
				if (eregi("^([a-z0-9 -]+)\.html$", $networkfile, $fmatches))
				{
					$networkinfo = @fread(@fopen(phpAds_path."/admin/networks/".$networkfile, "rb"), @filesize(phpAds_path."/admin/networks/".$networkfile));
					
					if (ereg("\[title\]([^\[]*)\[\/title\]", $networkinfo, $tmatches))
						$networks[$fmatches[1]] = $tmatches[1];
				}
		
		@closedir($networkdir);
		asort($networks, SORT_STRING);
	}
	
	return $networks;
}

function phpAds_setNetworkInfo($networkinfo, $vars)
{
	for (reset($vars); $key=key($vars); next($vars))
	{
		if (ereg("\[value:".$key."\]([^\[]*)\[\/value\]", $networkinfo, $matches))
		{
			$networkinfo = str_replace($matches[0], '[value:'.$key.']'.$vars[$key].'[/value]', $networkinfo);
		}
	}
	
	return ($networkinfo);
}

function phpAds_parseNetworkInfo($networkinfo)
{
	while (ereg("\[value:([a-zA-Z0-9]*)\]([^\[]*)\[\/value\]", $networkinfo, $matches))
	{
		$networkinfo = str_replace ('{var:'.$matches[1].'}', $matches[2], $networkinfo);
		$networkinfo = str_replace ($matches[0], '', $networkinfo);
	}
	
	$networkinfo = ereg_replace ("\[properties\](.*)\[\/properties\]", '', $networkinfo);
	$networkinfo = trim ($networkinfo);
	
	return ($networkinfo);
}

function phpAds_getNetworkInfo($networkinfo)
{
	global $strMoreInformation, $strRichMedia, $strTrackAdClicks, $strYes, $strNo;
	
	$result = array();
	
	// Get basic info
	if (ereg("\[title\]([^\[]*)\[\/title\]", $networkinfo, $matches))
		$result['title'] = $matches[1];
	
	if (ereg("\[logo\](.*)\[\/logo\]", $networkinfo, $matches))
		$result['logo'] = $matches[1];
	
	if (ereg("\[signup\](.*)\[\/signup\]", $networkinfo, $matches))
		$result['signup'] = $matches[1];
	
	if (ereg("\[login\](.*)\[\/login\]", $networkinfo, $matches))
		$result['login'] = $matches[1];
	
	if (ereg("\[comments\](.*)\[\/comments\]", $networkinfo, $matches))
		$result['comments'] = $matches[1]." <a href='".$result['signup']."' target='_blank'>".$strMoreInformation."</a><br><br>";
	
	if (ereg("\[ability:dynamic\]true\[\/ability\]", $networkinfo))
		$result['comments'] .= "<img src='images/icon-filetype-swf.gif' align='absmiddle'>&nbsp;".$strRichMedia.": <b>".$strYes."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	else
		$result['comments'] .= "<img src='images/icon-filetype-swf.gif' align='absmiddle'>&nbsp;".$strRichMedia.": <b>".$strNo."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	
	if (ereg("\[ability:track-clicks\]true\[\/ability\]", $networkinfo))
		$result['comments'] .= "<img src='images/icon-mouse.gif' align='absmiddle'>&nbsp;".$strTrackAdClicks.": <b>".$strYes."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	else
		$result['comments'] .= "<img src='images/icon-mouse.gif' align='absmiddle'>&nbsp;".$strTrackAdClicks.": <b>".$strNo."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	
	
	// Get width / height
	if (ereg("\[width\](.*)\[\/width\]", $networkinfo, $matches))
		$result['width'] = $matches[1];
	
	if (ereg("\[height\](.*)\[\/height\]", $networkinfo, $matches))
		$result['height'] = $matches[1];
	
	
	// Get variables
	$vars = array();
	
	while (ereg("\[title:([a-zA-Z0-9]*)\]([^\[]*)\[\/title\]", $networkinfo, $tmatches))
	{
		if (ereg("\[value:".$tmatches[1]."\]([^\[]*)\[\/value\]", $networkinfo, $vmatches))
			$value = $vmatches[1];
		else
			$value = '';
		
		$vars[] = array('name' => $tmatches[1], 'title' => $tmatches[2], 'default' => $value);
		$networkinfo = str_replace ($tmatches[0], '', $networkinfo);
	}
	
	$result['vars'] = $vars;
	
	return ($result);
}

?>