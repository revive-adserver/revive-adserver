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
	else
	{
		$buffer  = "<a href='{targeturl}' target='{target}' ";
		$buffer .= "[status]onMouseOver=\"self.status='{status}'; return true;\" onMouseOut=\"self.status='';return true;\"[/status]>";
		$buffer .= "<img src='{imageurl}' width='{width}' height='{height}' alt='{alt}' title='{alt}' border='0'>";
		$buffer .= "</a>";
	}
	
	// Text below banner
	$buffer .= "[bannertext]<br><a href='{targeturl}' target='{target}'>{bannertext}</a>[/bannertext]";
	
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
			// Automatic remove all target='...'
			$buffer = eregi_replace (" target=['|\"]{0,1}[^'|\"|[:space:]]+['|\"]{0,1}", " ", $buffer);
			
			// Determine which types are present in the HTML
			$formpresent = eregi('<form', $buffer);
			$linkpresent = eregi('<a', $buffer);
			
			if ($formpresent)
			{
				// Add hidden field to forms
				$buffer = eregi_replace ("(<form([^>]*)action=['|\"]{0,1})([^'|\"|[:space:]]+)(['|\"]{0,1}([^>]*)>)", 
						  			     "\\1".$phpAds_config['url_prefix']."/adclick.php\\4".
									     "<input type='hidden' name='dest' value='\\3'>".
									     "<input type='hidden' name='bannerid' value='{bannerid}'>".
									     "<input type='hidden' name='source' value='{source}'>".
									     "<input type='hidden' name='zoneid' value='{zoneid}'>", $buffer);
				
				// Add target to all URLs
				$buffer = eregi_replace ("<form ", "<form target='{target}' ", $buffer);
			}
			
			// Process link
			if ($linkpresent)
			{
				// Replace all links with adclick.php
				
				$newbanner	 = '';
				$prevhrefpos = '';
				
				$lowerbanner = strtolower($buffer);
				$hrefpos	 = strpos($lowerbanner, 'href=');
				
				while ($hrefpos > 0)
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
						
						if (substr ($buffer, $quotepos+1, 10) != '{targeturl')
						{
							$newbanner = $newbanner . 
									substr($buffer, $prevhrefpos, $hrefpos - $prevhrefpos) . 
									$quotechar . $phpAds_config['url_prefix'] . '/adclick.php?bannerid=' . 
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
						
						if (substr($buffer, $hrefpos, 10) != '{targeturl')
						{
							$newbanner = $newbanner . 
									substr($buffer, $prevhrefpos, $hrefpos - $prevhrefpos) . 
									'"' . $phpAds_config['url_prefix'] . '/adclick.php?bannerid=' . 
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
					
					$hrefpos = strpos($lowerbanner, 'href=', $hrefpos + 1);
				}
				
				$buffer = $newbanner.substr($buffer, $prevhrefpos);
				
				
				// Add target to all URLs
				$buffer = eregi_replace ("<a ", "<a target='{target}' ", $buffer);
			}
			
			if (!$formpresent && !$linkpresent && $banner['url'] != '')
			{
				// No link or form
				$buffer = "<a href='".$phpAds_config['url_prefix']."/adclick.php?bannerid={bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;ismap=' target='{target}'>".$buffer."</a>";
			}
		}
		
		
		if (strpos ($buffer, "{targeturl:") > 0)
		{
			while (eregi("\{targeturl:([^\}]*)\}", $buffer, $regs))
			{
				$buffer = str_replace ($regs[0], $phpAds_config['url_prefix'].'/adclick.php?bannerid={bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;dest='.urlencode($regs[1]).'&amp;ismap=', $buffer);
			}
		}
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
		$buffer = eregi_replace ("\[status\](.*)\[\/status\]", '', $buffer);
	
	
	// Set bannertext
	if (isset($banner['bannertext']) && $banner['bannertext'] != '')
		$buffer = str_replace ('{bannertext}', $banner['bannertext'], $buffer);
	else
		$buffer = eregi_replace ("\[bannertext\](.*)\[\/bannertext\]", '', $buffer);
	
	
	
	// Set imageurl
	if ($banner['storagetype'] == 'sql' || $banner['storagetype'] == 'web' || $banner['storagetype'] == 'url')
		$buffer = str_replace ('{imageurl}', $banner['imageurl'], $buffer);
	
	
	// Set flash variables
	if ($banner['contenttype'] == 'swf')
	{
		if ($banner['url'] != '')
			$buffer = str_replace ('{swf_param}', "clickTAG=".$phpAds_config['url_prefix'].'/adclick.php%3Fbannerid={bannerid}%26amp;zoneid={zoneid}%26amp;source={source}%26amp;dest='.urlencode($banner['url']), $buffer);
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
			$buffer = str_replace ($matches[0],
								   $phpAds_config['url_prefix'].'/adclick.php%3Fbannerid={bannerid}%26amp;zoneid={zoneid}%26amp;source={source}%26amp;dest='.urlencode($matches[1]),
								   $buffer);
		}
	}
	
	
	// Replace targeturl
	if (isset($banner['url']) && $banner['url'] != '')
		$buffer = str_replace ('{targeturl}', $phpAds_config['url_prefix'].'/adclick.php?bannerid={bannerid}&amp;zoneid={zoneid}&amp;source={source}&amp;dest='.urlencode($banner['url']), $buffer);
	else
		$buffer = str_replace ('{targeturl}', '', $buffer);
	
	
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
	
	return ($buffer);
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