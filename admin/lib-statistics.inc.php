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



// Define defaults
$clientCache = array();
$bannerCache = array();
$zoneCache = array();
$affiliateCache = array();



/*********************************************************/
/* Limit a string to a number of characters              */
/*********************************************************/

function phpAds_breakString ($str, $maxLen, $append = "...")
{
	return strlen($str) > $maxLen 
		? rtrim(substr($str, 0, $maxLen-strlen($append))).$append 
		: $str;
}


/*********************************************************/
/* Build the client name from ID and name                */
/*********************************************************/

function phpAds_buildClientName ($clientid, $clientName)
{
	return ("<span dir='".$GLOBALS['phpAds_TextDirection']."'>[id$clientid]</span> ".$clientName);
}


/*********************************************************/
/* Fetch the client name from the database               */
/*********************************************************/

function phpAds_getClientName ($clientid)
{
	global $phpAds_config;
	global $clientCache;
	global $strUntitled;
	
	if ($clientid != '' && $clientid != 0)
	{
		if (isset($clientCache[$clientid]) && is_array($clientCache[$clientid]))
		{
			$row = $clientCache[$clientid];
		}
		else
		{
			$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				clientid = '$clientid'
			") or phpAds_sqlDie();
			
			$row = phpAds_dbFetchArray($res);
			
			$clientCache[$clientid] = $row;
		}
		
		return (phpAds_BuildClientName ($clientid, $row['clientname']));
	}
	else
		return ($strUntitled);
}


/*********************************************************/
/* Get list order status                                 */
/*********************************************************/

// Manage Orderdirection
function phpAds_getOrderDirection ($ThisOrderDirection)
{
	$sqlOrderDirection = '';
	
	switch ($ThisOrderDirection)
	{
		case 'down':
			$sqlOrderDirection .= ' ';
			$sqlOrderDirection .= 'ASC';
			break;
		case 'up':
			$sqlOrderDirection .= ' ';
			$sqlOrderDirection .= 'DESC';
			break;
		default:
			$sqlOrderDirection .= ' ';
			$sqlOrderDirection .= 'ASC';
	}
	return $sqlOrderDirection;
}

// Order for $phpAds_config['tbl_clients']
function phpAds_getListOrder ($ListOrder, $OrderDirection)
{
	$sqlTableOrder = '';
	switch ($ListOrder)
	{
		case 'name':
			$sqlTableOrder = 'ORDER BY clientname';
			break;
		case 'id':
			$sqlTableOrder = 'ORDER BY parent, clientid';
			break;
		case 'adview':
			break;
		case 'adclick':
			break;
		case 'ctr':
			break;
		default:
			$sqlTableOrder = 'ORDER BY clientname';
	}
	if 	($sqlTableOrder != '')
	{
		$sqlTableOrder .= phpAds_getOrderDirection($OrderDirection);
	}
	return ($sqlTableOrder);
}

// Order for $phpAds_config['tbl_banners']
function phpAds_getBannerListOrder ($ListOrder, $OrderDirection)
{
	$sqlTableOrder = '';
	switch ($ListOrder)
	{
		case 'name':
			$sqlTableOrder = 'ORDER BY description';
			break;
		case 'id':
			$sqlTableOrder = 'ORDER BY bannerid';
			break;
		case 'adview':
			break;
		case 'adclick':
			break;
		case 'ctr':
			break;
		default:
			$sqlTableOrder = 'ORDER BY description';
	}
	if 	($sqlTableOrder != '')
	{
		$sqlTableOrder .= phpAds_getOrderDirection($OrderDirection);
	}
	return ($sqlTableOrder);
}

// Order for $phpAds_config['tbl_zones']
function phpAds_getZoneListOrder ($ListOrder, $OrderDirection)
{
	switch ($ListOrder)
	{
		case 'name':
			$sqlTableOrder = 'ORDER BY zonename';
			break;
		case 'id':
			$sqlTableOrder = 'ORDER BY zoneid';
			break;
		case 'size':
			$sqlTableOrder = 'ORDER BY width';
			break;
		default:
			$sqlTableOrder = 'ORDER BY zonename';
	}
	if 	($sqlTableOrder != '')
	{
		$sqlTableOrder .= phpAds_getOrderDirection($OrderDirection);
	}
	return ($sqlTableOrder);
}

// Order for $phpAds_config['tbl_affiliates']
function phpAds_getAffiliateListOrder ($ListOrder, $OrderDirection)
{
	switch ($ListOrder)
	{
		case 'name':
			$sqlTableOrder = 'ORDER BY name';
			break;
		case 'id':
			$sqlTableOrder = 'ORDER BY affiliateid';
			break;
		default:
			$sqlTableOrder = 'ORDER BY name';
	}
	if 	($sqlTableOrder != '')
	{
		$sqlTableOrder .= phpAds_getOrderDirection($OrderDirection);
	}
	return ($sqlTableOrder);
}


/*********************************************************/
/* Fetch the ID of the parent of a campaign              */
/*********************************************************/

function phpAds_getParentID ($clientid)
{
	global $phpAds_config;
	global $clientCache;
	
	if (isset($clientCache[$clientid]) && is_array($clientCache[$clientid]))
	{
		$row = $clientCache[$clientid];
	}
	else
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				clientid = '$clientid'
		") or phpAds_sqlDie();
		
		$row = phpAds_dbFetchArray($res);
		
		$clientCache[$clientid] = $row;
	}
	
	return ($row['parent']);
}



/*********************************************************/
/* Fetch the name of the parent of a campaign            */
/*********************************************************/

function phpAds_getParentName ($clientid)
{
	global $phpAds_config;
	global $clientCache;
	
	if (isset($clientCache[$clientid]) && is_array($clientCache[$clientid]))
	{
		$row = $clientCache[$clientid];
	}
	else
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				clientid = '$clientid'
		") or phpAds_sqlDie();
		
		$row = phpAds_dbFetchArray($res);
		
		$clientCache[$clientid] = $row;
	}
	
	return (phpAds_getClientName ($row['parent']));
}



/*********************************************************/
/* Build the banner name from ID, Description and Alt    */
/*********************************************************/

function phpAds_buildBannerName ($bannerid, $description = '', $alt = '', $limit = 30)
{
	global $strUntitled;
	
	$name = '';
	
	if ($description != "")
		$name .= $description;
	elseif ($alt != "")
		$name .= $alt;
	else
		$name .= $strUntitled;
	
	
	if (strlen($name) > $limit)
		$name = phpAds_breakString ($name, $limit);
	
	if ($bannerid != '')
		$name = "<span dir='".$GLOBALS['phpAds_TextDirection']."'>[id$bannerid]</span> ".$name;
	
	return ($name);
}



/*********************************************************/
/* Fetch the banner name from the database               */
/*********************************************************/

function phpAds_getBannerName ($bannerid, $limit = 30, $id = true)
{
	global $phpAds_config;
	global $bannerCache;
	
	if (isset($bannerCache[$bannerid]) && is_array($bannerCache[$bannerid]))
	{
		$row = $bannerCache[$bannerid];
	}
	else
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				bannerid = '$bannerid'
		") or phpAds_sqlDie();
		
		$row = phpAds_dbFetchArray($res);
		
		$bannerCache[$bannerid] = $row;
	}
	
	if ($id)
		return (phpAds_buildBannerName ($bannerid, $row['description'], $row['alt'], $limit));
	else
		return (phpAds_buildBannerName ('', $row['description'], $row['alt'], $limit));
}


/*********************************************************/
/* Build the zone name from ID and name                  */
/*********************************************************/

function phpAds_buildZoneName ($zoneid, $zonename)
{
	return ("<span dir='".$GLOBALS['phpAds_TextDirection']."'>[id$zoneid]</span> $zonename");
}


/*********************************************************/
/* Fetch the zone name from the database                 */
/*********************************************************/

function phpAds_getZoneName ($zoneid)
{
	global $phpAds_config;
	global $zoneCache;
	global $strUntitled;
	
	if ($zoneid != '' && $zoneid != 0)
	{
		if (isset($zoneCache[$zoneid]) && is_array($zoneCache[$zoneid]))
		{
			$row = $zoneCache[$zoneid];
		}
		else
		{
			$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();
			
			$row = phpAds_dbFetchArray($res);
			
			$zoneCache[$zoneid] = $row;
		}
		
		return (phpAds_BuildZoneName ($zoneid, $row['zonename']));
	}
	else
		return ($strUntitled);
}



/*********************************************************/
/* Build the affiliate name from ID and name             */
/*********************************************************/

function phpAds_buildAffiliateName ($affiliateid, $name)
{
	return ("<span dir='".$GLOBALS['phpAds_TextDirection']."'>[id$affiliateid]</span> $name");
}



/*********************************************************/
/* Fetch the affiliate name from the database            */
/*********************************************************/

function phpAds_getAffiliateName ($affiliateid)
{
	global $phpAds_config;
	global $affiliateCache;
	global $strUntitled;
	
	if ($affiliateid != '' && $affiliateid != 0)
	{
		if (isset($affiliateCache[$affiliateid]) && is_array($affiliateCache[$affiliateid]))
		{
			$row = $affiliateCache[$affiliateid];
		}
		else
		{
			$res = phpAds_dbQuery("
				SELECT
					*
				FROM
					".$phpAds_config['tbl_affiliates']."
				WHERE
					affiliateid = '$affiliateid'
			") or phpAds_sqlDie();
			
			$row = phpAds_dbFetchArray($res);
			
			$affiliateCache[$affiliateid] = $row;
		}
		
		return (phpAds_BuildAffiliateName ($affiliateid, $row['name']));
	}
	else
		return ($strUntitled);
}



/*********************************************************/
/* Replace variables in HTML or external banner          */
/*********************************************************/

function phpAds_replaceVariablesInBannerCode ($htmlcode)
{
	global $phpAds_config;
	
	// Parse for variables
	$htmlcode = str_replace ('{timestamp}',	time(), $htmlcode);
	$htmlcode = str_replace ('%7Btimestamp%7D',	time(), $htmlcode);
	
	while (preg_match ('#(%7B|\{)random((%3A|:)([0-9]+)){0,1}(%7D|})#i', $htmlcode, $matches))
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
		
		$htmlcode = str_replace ($matches[0], $randomnumber, $htmlcode);
		
		$lastdigits = $randomdigits;
		$lastrandom = $randomnumber;
	}
	
	
	// Parse PHP code
	if ($phpAds_config['type_html_php'])
	{
		while (preg_match ("#(\<\?php(.*?)\?\>)#si", $htmlcode, $parser_regs))
		{
			// Extract PHP script
			$parser_php 	= $parser_regs[2].';';
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
					eval (trim ($parser_lines[$parser_i]).';');
			}
			
			// Replace the script with the result
			$htmlcode = str_replace ($parser_regs[1], $parser_result, $htmlcode);
		}
	}
	
	return ($htmlcode);
}



/*********************************************************/
/* Build the HTML needed to display a banner             */
/*********************************************************/

function phpAds_buildBannerCode ($bannerid, $fullpreview = false)
{
	global $strShowBanner, $strLogin;
	global $phpAds_config, $HTTP_SERVER_VARS;
	global $phpAds_TextAlignLeft, $phpAds_TextAlignRight;
	
	
	$res = phpAds_dbQuery ("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = '".$bannerid."'
	");
	
	$row = phpAds_dbFetchArray($res);
	
	
	if ($fullpreview || $phpAds_config['gui_show_banner_preview'])
	{
		// Determine target
		if ($row['target'] == '')
		{
			if (!isset($target) || $target == '') $target = '_blank';  // default
		}
		else
			$target = $row['target'];
		
		
		// Replace url_prefix
		$row['htmlcache'] = str_replace ('{url_prefix}', $phpAds_config['url_prefix'], $row['htmlcache']);
		
		
		switch ($row['storagetype'])
		{
			case 'html':
				if ($fullpreview || $phpAds_config['gui_show_banner_html'])
				{
					$htmlcode = $row['htmlcache'];
					$htmlcode = str_replace ('{bannerid}', $bannerid, $htmlcode);
					$htmlcode = str_replace ('{zoneid}', '', $htmlcode);
					$htmlcode = str_replace ('{source}', '', $htmlcode);
					$htmlcode = str_replace ('{target}', $target, $htmlcode);
					$htmlcode = str_replace ('[bannertext]', '', $htmlcode);
					$htmlcode = str_replace ('[/bannertext]', '', $htmlcode);
					$htmlcode = phpAds_replaceVariablesInBannerCode ($htmlcode);
					
					$buffer =  $htmlcode;
				}
				else
				{
					$htmlcode   = str_replace ("\n", '', stripslashes ($row['htmltemplate']));
					$htmlcode   = strlen($htmlcode) > 500 ? substr ($htmlcode, 0, 500)."..." : $htmlcode;
					$htmlcode   = chunk_split ($htmlcode, 65, "\n");
					$htmlcode   = str_replace("\n", "<br>\n", htmlspecialchars ($htmlcode));
					
					$buffer     = "<img src='images/break-el.gif' height='1' width='100%' vspace='5'><br>";
					$buffer	   .= "<table border='0' cellspacing='0' cellpadding='0'><tr>";
					$buffer    .= "<td width='80%' valign='top' align='".$phpAds_TextAlignLeft."'>\n";
					$buffer	   .= $htmlcode;
					$buffer    .= "\n</td>";
					$buffer    .= "<td width='20%' valign='top' align='".$phpAds_TextAlignLeft."' nowrap>&nbsp;&nbsp;";
					$buffer	   .= "<a href='banner-htmlpreview.php?bannerid=$bannerid' target='_new' ";
					$buffer	   .= "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=".$bannerid."', '', 'status=no,scrollbars=no,resizable=no,width=".($row['width']+64).",height=".($row['bannertext'] ? $row['height']+80 : $row['height']+64)."');\">";
					$buffer    .= "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;".$strShowBanner."</a>&nbsp;&nbsp;</td>";
					$buffer	   .= "</tr></table>";
				}
				break;
			
			case 'network':
				if (ereg("\[title\]([^\[]*)\[\/title\]", $row['htmltemplate'], $matches))
					$title = $matches[1];
				
				if (ereg("\[logo\](.*)\[\/logo\]", $row['htmltemplate'], $matches))
					$logo = $matches[1];
				
				if (ereg("\[login\](.*)\[\/login\]", $row['htmltemplate'], $matches))
					$login = $matches[1];
				
				$buffer  = "<img src='images/break-l.gif' height='1' width='468' vspace='6'>";
				$buffer .= "<table width='468' cellpadding='0' cellspacing='0' border='0'><tr>";
				$buffer .= "<td valign='bottom'><img src='networks/logos/".$logo."'>&nbsp;&nbsp;&nbsp;</td>";
				$buffer .= "<td valign='bottom' align='".$phpAds_TextAlignRight."'><br><b>".$title."</b>&nbsp;&nbsp;&nbsp;<a href='".$login."' target='_blank'>";
				$buffer .= "<img src='images/icon-zoom.gif' align='absmiddle' border='0' vspace='2'> ".$strLogin."</a></td>";
				$buffer .= "</tr></table>";
				$buffer .= "<img src='images/break-l.gif' height='1' width='468' vspace='6'>";
				break;
			
			default:
				$htmlcode = $row['htmlcache'];
				
				// Set basic variables
				$htmlcode = str_replace ('{bannerid}', $row['bannerid'], $htmlcode);
				$htmlcode = str_replace ('{zoneid}', '', $htmlcode);
				$htmlcode = str_replace ('{source}', '', $htmlcode);
				$htmlcode = str_replace ('{target}', $target, $htmlcode);
				$htmlcode = str_replace ('[bannertext]', '', $htmlcode);
				$htmlcode = str_replace ('[/bannertext]', '', $htmlcode);
				
				if ($row['storagetype'] == 'url')
					$htmlcode = phpAds_replaceVariablesInBannerCode ($htmlcode);
				
				$buffer  = $htmlcode;
				break;
		}
		
		// Remove appended HTML for the preview
		if (strlen($row['append']))
			$buffer = str_replace ($row['append'], '', $buffer);
		
		
		// If the HTML contains ActiveX code we need
		// to use a JavaScript workaround because the outcome of the Eolas lawsuit
		// agains Microsoft. Without these changes the user would get a warning dialogbox.
		if ($fullpreview &&
			!(strpos (strtolower($row['htmlcache']), "<object") === false) &&
	   		(strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'MSIE') && !strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Opera')))
		{
			$activexbuffer  = "<script language='JavaScript' type='text/javascript' src='{url_prefix}/adx.js'></script>";
			$activexbuffer .= "<script language='JavaScript' type='text/javascript'>\n";
			$activexbuffer .= "<!--\n";
			$activexbuffer .= "var phpads_activex = \"";
			$activexbuffer .= str_replace('</', '<"+"/', addcslashes($buffer, "\0..\37\"\\@\177..\377"));
			$activexbuffer .= "\";\n";
 			$activexbuffer .= "phpads_deliverActiveX(phpads_activex);\n";
 			$activexbuffer .= "//-->\n";
 			$activexbuffer .= "</script>";
 			
 			$buffer = $activexbuffer;
		}

		
		
	}
	else
	{
		if ($row['contenttype'] == 'txt')
		{
			$width	= 300;
			$height = 200;
		}
		else
		{
			$width  = $row['width'] + 64;
			$height = $row['bannertext'] ? $row['height'] + 90 : $row['height'] + 64;
		}
		
		$buffer     = "<img src='images/break-el.gif' height='1' width='100%' vspace='5'><br>";
		$buffer	   .= "<a href='banner-htmlpreview.php?bannerid=$bannerid' target='_new' ";
		$buffer	   .= "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=".$bannerid."', '', 'status=no,scrollbars=no,resizable=no,width=".$width.",height=".$height."');\">";
		$buffer    .= "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;".$strShowBanner."</a>&nbsp;&nbsp;";
	}
	
	
	// Disable logging of adclicks
	$buffer = str_replace ('adclick.php?', 'adclick.php?log=no&', $buffer);
	$buffer = str_replace ('adclick.php%3F', 'adclick.php%3Flog=no%26', $buffer);
	
	$buffer = str_replace ('{url_prefix}', $phpAds_config['url_prefix'], $buffer);
	
	return ($buffer);
}



/*********************************************************/
/* Build Click-Thru ratio                                */
/*********************************************************/

function phpAds_buildCTR ($views, $clicks)
{
	global $phpAds_config, $phpAds_DecimalPoint, $phpAds_ThousandsSeperator;
	
	if ($views > 0)
		$ctr = number_format(($clicks*100)/$views, $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%";
	else
		$ctr="0".$phpAds_DecimalPoint."00%";
		
	return ($ctr);
}



/*********************************************************/
/* Delete statistics							         */
/*********************************************************/

function phpAds_deleteStats($bannerid)
{
    global $phpAds_config;
	
    phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adviews']." WHERE bannerid = '$bannerid'") or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adclicks']." WHERE bannerid = '$bannerid'") or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adstats']." WHERE bannerid = '$bannerid'") or phpAds_sqlDie();
}


/*********************************************************/
/* Get overview statistics						         */
/*********************************************************/

function phpAds_totalStats($table, $column, $bannerid, $timeconstraint="")
{
    global $phpAds_config;
    
	if ($phpAds_config['compact_stats'])
	{
	    $where = "";
		
	    if (!empty($bannerid)) 
        	$where = "WHERE bannerid = '$bannerid'";
	    
		if (!empty($timeconstraint))
		{
			if (!empty($bannerid))
				$where .= " AND ";
			else
				$where = "WHERE ";
			
			if ($timeconstraint == "month")
			{
				$begin = date('Ymd', mktime(0, 0, 0, date('m'), 1, date('Y')));
				$end   = date('Ymd', mktime(0, 0, 0, date('m') + 1, 1, date('Y')));
				$where .= "day >= $begin AND day < $end";
			}
			elseif ($timeconstraint == "week")
			{
				$begin = date('Ymd', mktime(0, 0, 0, date('m'), date('d') - 6, date('Y')));
				$end   = date('Ymd', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')));
				$where .= "day >= $begin AND day < $end";
			}
			else
			{
				$begin = date('Ymd', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
			    
				$where .= "day = $begin";
			}
		}
		
	    $res = phpAds_dbQuery("SELECT SUM($column) as qnt FROM ".$phpAds_config['tbl_adstats']." $where") or phpAds_sqlDie();
	    
		if (phpAds_dbNumRows ($res))
	    { 
	        $row = phpAds_dbFetchArray($res);
			return ($row['qnt']);
		}
		else
			return (0);
	}
	else
	{
	    $where = "";
		
	    if (!empty($bannerid)) 
	        $where = "WHERE bannerid = '$bannerid'";
	    
		if (!empty($timeconstraint))
		{
			if (!empty($bannerid))
				$where .= " AND ";
			else
				$where = "WHERE ";
			
			if ($timeconstraint == "month")
			{
				$begin = date('YmdHis', mktime(0, 0, 0, date('m'), 1, date('Y')));
				$end   = date('YmdHis', mktime(0, 0, 0, date('m') + 1, 1, date('Y')));
				$where .= "t_stamp >= $begin AND t_stamp < $end";
			}
			elseif ($timeconstraint == "week")
			{
				$begin = date('YmdHis', mktime(0, 0, 0, date('m'), date('d') - 6, date('Y')));
				$end   = date('YmdHis', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')));
				$where .= "t_stamp >= $begin AND t_stamp < $end";
			}
			else
			{
				$begin = date('YmdHis', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
				$end   = date('YmdHis', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')));
				$where .= "t_stamp >= $begin AND t_stamp < $end";
			}
		}
		
	    $res = phpAds_dbQuery("SELECT count(*) as qnt FROM $table $where") or phpAds_sqlDie();
    	
		if (phpAds_dbNumRows ($res))
	    {
    	    $row = phpAds_dbFetchArray($res);
			return ($row['qnt']);
		}
		else
			return (0);
    }
}

function phpAds_totalClicks($bannerid="", $timeconstraint="")
{
	global $phpAds_config;
	
    return phpAds_totalStats($phpAds_config['tbl_adclicks'], "clicks", $bannerid, $timeconstraint);
}

function phpAds_totalViews($bannerid="", $timeconstraint="")
{
	global $phpAds_config;
	
    return phpAds_totalStats($phpAds_config['tbl_adviews'], "views", $bannerid, $timeconstraint);
}

function phpAds_htmlQuotes ($string)
{
	$string = stripslashes ($string);
	$string = str_replace ('"', '&quot;', $string);
	$string = str_replace ("'", '&#039;', $string);
	
	return $string;
}

function phpAds_formatNumber ($number)
{
	global $phpAds_ThousandsSeperator;
	
	if (!strcmp($number, '-'))
		return '-';
	
	return (number_format($number, 0, '', $phpAds_ThousandsSeperator));
}



/*********************************************************/
/* Calculates timestamp taking DST into account          */
/*********************************************************/

function phpAds_makeTimestamp($start, $offset = 0)
{
	if (!$offset)
		return $start;
	
	return $start + $offset + (date('I', $start) - date('I', $start + $offset)) * 60;
}

?>