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
	return ("[id$clientid] $clientName");
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
				clientid = $clientid
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

// Order for $phpAds_config['tbl_banners']
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
				clientid = $clientid
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
				clientid = $clientid
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
		$name = "[id$bannerid] ".$name;
	
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
				bannerid = $bannerid
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
	return ("[id$zoneid] $zonename");
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
				zoneid = $zoneid
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
	return ("[id$affiliateid] $name");
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
				affiliateid = $affiliateid
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
/* Fetch the HTML needed to display a banner from the db */
/*********************************************************/

function phpAds_getBannerCode ($bannerid)
{
	global $phpAds_config;
	global $bannerCache;
	
	if (is_array($bannerCache[$bannerid]))
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
				bannerid = $bannerid
		") or phpAds_sqlDie();
		
		$row = phpAds_dbFetchArray($res);
		
		$bannerCache[$bannerid] = $row;
	}
	
	return (phpAds_buildBannerCode ($bannerid, $row['banner'], $row['active'], $row['format'], $row['width'], $row['height'], $row['bannertext']));
}


/*********************************************************/
/* Build the HTML needed to display a banner             */
/*********************************************************/

function phpAds_buildBannerCode ($bannerid, $banner, $active, $format, $width, $height, $bannertext)
{
	global $strShowBanner;
	global $phpAds_config;
	
	if ($active == "t")
	{
		if ($format == "html")
		{
			$htmlcode 	= str_replace ("\n", '', stripslashes ($banner));
			$htmlcode   = strlen($htmlcode) > 500 ? substr ($htmlcode, 0, 500)."..." : $htmlcode;
			$htmlcode	= chunk_split ($htmlcode, 65, "\n");
			$htmlcode   = str_replace("\n", "<br>\n", htmlspecialchars ($htmlcode));
			
			$buffer		= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
			$buffer    .= "<td width='80%' valign='top' align='left'>\n";
			$buffer	   .= $htmlcode;
			$buffer    .= "\n</td>";
			$buffer    .= "<td width='20%' valign='top' align='right' nowrap>&nbsp;&nbsp;";
			$buffer	   .= "<a href='banner-htmlpreview.php?bannerid=$bannerid' target='_new' ";
			$buffer	   .= "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=$bannerid', '', 'status=no,scrollbars=no,resizable=no,width=".($width+64).",height=".($bannertext ? $height+80 : $height+64)."');\">";
			$buffer    .= "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;".$strShowBanner."</a>&nbsp;&nbsp;</td>";
			$buffer	   .= "</tr></table>";
		}
		elseif($format == "url" || $format == "web")
		{
			if (eregi("swf$", $banner))
			{
				$buffer  = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' ";
				$buffer .= "codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/";
				$buffer .= "swflash.cab#version=5,0,0,0' width='$width' height='$height'>";
				$buffer .= "<param name='movie' value='$banner'>";
				$buffer .= "<param name='quality' value='high'>";
				$buffer .= "<embed src='$banner' quality=high ";
				$buffer .= "bgcolor='#FFFFFF' width='$width' height='$height' type='application/x-shockwave-flash' ";
				$buffer .= "pluginspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>";
				$buffer .= "</object>";
			}
			else
				$buffer = "<img src='$banner' width='$width' height='$height'>";
		}
		elseif($format == "swf")
		{
			$buffer  = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' ";
			$buffer .= "codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/";
			$buffer .= "swflash.cab#version=5,0,0,0' width='$width' height='$height'>";
			$buffer .= "<param name='movie' value='../adview.php?bannerid=$bannerid'>";
			$buffer .= "<param name='quality' value='high'>";
			$buffer .= "<embed src='../adview.php?bannerid=$bannerid' quality=high ";
			$buffer .= "bgcolor='#FFFFFF' width='$width' height='$height' type='application/x-shockwave-flash' ";
			$buffer .= "pluginspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>";
			$buffer .= "</object>";
		}
		else
			$buffer = "<img src='../adview.php?bannerid=$bannerid' width='$width' height='$height'>";
	}
	else
	{
		if ($format == "html")
		{
			$htmlcode 	= str_replace ("\n", '', stripslashes ($banner));
			$htmlcode   = strlen($htmlcode) > 500 ? substr ($htmlcode, 0, 500)."..." : $htmlcode;
			$htmlcode	= chunk_split ($htmlcode, 65, "\n");
			$htmlcode   = str_replace("\n", "<br>\n", htmlspecialchars ($htmlcode));
			
			$buffer		= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
			$buffer    .= "<td width='80%' valign='top' align='left' style='filter: Alpha(Opacity=50)'>\n";
			$buffer	   .= $htmlcode;
			$buffer    .= "\n</td>";
			$buffer    .= "<td width='20%' valign='top' align='right' nowrap>&nbsp;&nbsp;";
			$buffer	   .= "<a href='banner-htmlpreview.php?bannerid=$bannerid' target='_new' ";
			$buffer	   .= "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=$bannerid', '', 'status=no,scrollbars=no,resizable=no,width=$width,height=$height');\">";
			$buffer    .= "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;".$strShowBanner."</a>&nbsp;&nbsp;</td>";
			$buffer	   .= "</tr></table>";
		}
		elseif($format == "url" || $format == "web")
		{
			if (eregi("swf$", $banner))
			{
				$buffer  = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' ";
				$buffer .= "codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/";
				$buffer .= "swflash.cab#version=5,0,0,0' width='$width' height='$height'>";
				$buffer .= "<param name='movie' value='$banner'>";
				$buffer .= "<param name='quality' value='high'>";
				$buffer .= "<embed src='$banner' quality=high ";
				$buffer .= "bgcolor='#FFFFFF' width='$width' height='$height' type='application/x-shockwave-flash' ";
				$buffer .= "pluginspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>";
				$buffer .= "</object>";
			}
			else
				$buffer = "<img src='$banner' width='$width' height='$height' style='filter: Alpha(Opacity=50)'>";
		}
		elseif($format == "swf")
		{
			$buffer  = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' ";
			$buffer .= "codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/";
			$buffer .= "swflash.cab#version=5,0,0,0' width='$width' height='$height'>";
			$buffer .= "<param name='movie' value='../adview.php?bannerid=$bannerid'>";
			$buffer .= "<param name='quality' value='high'>";
			$buffer .= "<embed src='../adview.php?bannerid=$bannerid' quality=high ";
			$buffer .= "bgcolor='#FFFFFF' width='$width' height='$height' type='application/x-shockwave-flash' ";
			$buffer .= "pluginspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>";
			$buffer .= "</object>";
		}
		else
			$buffer = "<img src='../adview.php?bannerid=$bannerid' width='$width' height='$height' style='filter: Alpha(Opacity=50)'>";
	}
	
	if (!$bannertext == "")
		$buffer .= "<br>".$bannertext;
	
	return ($buffer);
}



/*********************************************************/
/* Build Click-Thru ratio                                */
/*********************************************************/

function phpAds_buildCTR ($views, $clicks)
{
	global $phpAds_config;
	
	if ($views > 0)
		$ctr = number_format(($clicks*100)/$views, $phpAds_config['percentage_decimals'])."%";
	else
		$ctr="0.00%";
		
	return ($ctr);
}



/*********************************************************/
/* Delete statistics							         */
/*********************************************************/

function phpAds_deleteStats($bannerid)
{
    global $phpAds_config;
	
    phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adviews']." WHERE bannerid = $bannerid") or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adclicks']." WHERE bannerid = $bannerid") or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adstats']." WHERE bannerid = $bannerid") or phpAds_sqlDie();
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
        	$where = "WHERE bannerid = $bannerid";
	    
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
				$begin = date('Ymd', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')));
				$end   = date('Ymd', mktime(0, 0, 0, date('m'), date('d') - 6, date('Y')));
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
	        $where = "WHERE bannerid = $bannerid";
	    
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
				$begin = date('YmdHis', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')));
				$end   = date('YmdHis', mktime(0, 0, 0, date('m'), date('d') - 6, date('Y')));
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

?>
