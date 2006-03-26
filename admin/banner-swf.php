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



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-storage.inc.php");
require ("lib-swf.inc.php");
require ("lib-banner.inc.php");
require ("lib-zones.inc.php");


// Register input variables
phpAds_registerGlobal ('convert', 'cancel', 'compress', 'convert_links',
					   'chosen_link', 'overwrite_link', 'overwrite_target',
					   'overwrite_source');


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	if (phpAds_isAllowed(phpAds_ModifyBanner))
	{
		$result = phpAds_dbQuery("
			SELECT
				clientid
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				bannerid = '$bannerid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["clientid"] == '' || phpAds_getUserID() != phpAds_getParentID ($row["clientid"]))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$campaignid = $row["clientid"];
		}
	}
	else
	{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}




/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($convert))
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
	
	
	if ($row['storagetype'] == 'sql' || $row['storagetype'] == 'web')
		$swf_file = phpAds_ImageRetrieve ($row['storagetype'], $row['filename']);
		
	if ($swf_file)
	{
		if (phpAds_SWFVersion($swf_file) >= 3 &&
			phpAds_SWFInfo($swf_file))
		{
			if (phpAds_SWFVersion($swf_file) >= 6 && phpAds_SWFCompressed($swf_file))
			{
				$compress = true;
			}
			else
			{
				// Compress the converted file
				if (isset($compress)) 
					$compress = true;
				else
					$compress = false;
			}
						
			if (!isset($convert_links))
				$convert_links = array();
			
			list($result, $parameters) = phpAds_SWFConvert($swf_file, $compress, $convert_links);
			
			if ($result != $swf_file)
			{
				// Reload template to be sure it can be updated
				$row['htmltemplate'] = phpAds_getBannerTemplate('swf');
				
				if (count($parameters) > 0)
				{
					// Set default link
					$row['url']    = $overwrite_link[$chosen_link];
					$row['target'] = $overwrite_target[$chosen_link];
					
					// Prepare the parameters
					$parameters_complete = array();
					
					while (list($key, $val) = each($parameters))
					{
						if (isset($overwrite_source) && $overwrite_source[$val] != '')
							$overwrite_link[$val] .= '|source:'.$overwrite_source[$val];
						
						$parameters_complete[] = 'alink'.$key.'={targeturl:'.$overwrite_link[$val].'}&amp;atar'.$key.'='.$overwrite_target[$val];
					}

					$parameter = implode ('&amp;', $parameters_complete);
					$row['htmltemplate'] = str_replace ('{swf_param}', $parameter, $row['htmltemplate']);
				}
				
				$row['pluginversion'] = phpAds_SWFVersion($result);
				$row['htmlcache']     = addslashes (phpAds_getBannerCache($row));
				$row['htmltemplate']  = addslashes ($row['htmltemplate']);

				// Store the HTML Template
				$res = phpAds_dbQuery ("
					UPDATE ".$phpAds_config['tbl_banners']." 
					SET url='".$row['url']."', target='".$row['target']."', pluginversion='".$row['pluginversion']."', 
						htmltemplate='".$row['htmltemplate']."', htmlcache='".$row['htmlcache']."'
					WHERE bannerid = '".$bannerid."'
				") or die(phpAds_dbError());
				
				// Store the banner
				phpAds_ImageStore ($row['storagetype'], $row['filename'], $result, true);
				
				
				// Rebuild cache
				if (!defined('LIBVIEWCACHE_INCLUDED')) 
					include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
				
				phpAds_cacheDelete();
			}
		}
	}
	
	
	if (phpAds_isUser(phpAds_Client))
		Header('Location: stats-campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid);
	else
	{
		Header('Location: banner-acl.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
	}
	
	exit;
}

if (isset($cancel))
{
	if (phpAds_isUser(phpAds_Client))
		Header('Location: stats-campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid);
	else
	{
		Header('Location: banner-acl.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
	}
	
	exit;
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($bannerid != '')
{
	if (isset($Session['prefs']['campaign-banners.php'][$campaignid]['listorder']))
		$navorder = $Session['prefs']['campaign-banners.php'][$campaignid]['listorder'];
	else
		$navorder = '';
	
	if (isset($Session['prefs']['campaign-banners.php'][$campaignid]['orderdirection']))
		$navdirection = $Session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'];
	else
		$navdirection = '';
	
	
	// Get other banners
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			clientid = '$campaignid'
		".phpAds_getBannerListOrder($navorder, $navdirection)."
	");
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']),
			"banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$row['bannerid'],
			$bannerid == $row['bannerid']
		);
	}
	
	
	if (phpAds_isUser(phpAds_Admin))
	{
		phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
		phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
		phpAds_PageShortcut($strBannerHistory, 'stats-banner-history.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid, 'images/icon-statistics.gif');
		
		
		phpAds_PageHeader("4.1.3.4.5");
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
			echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
			phpAds_ShowSections(array("4.1.3.4.5"));
	}
	else
	{
		phpAds_PageHeader("1.2.2.3");
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
			echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
			phpAds_ShowSections(array("1.2.2.3"));
	}
	
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = '$bannerid'
		") or phpAds_sqlDie();
	$row = phpAds_dbFetchArray($res);
	
	
	if ($row['contenttype'] == 'swf')
	{
		if ($row['storagetype'] == 'sql' || $row['storagetype'] == 'web')
			$swf_file = phpAds_ImageRetrieve ($row['storagetype'], $row['filename']);
	}
	else
	{
		// Banner is not a flash banner, return to banner-edit.php
		header ("Location: banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid);
		exit;
	}
}
else
{
	// Banner does not exist, return to banner-edit.php
	header ("Location: banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid);
	exit;
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$result = phpAds_SWFInfo($swf_file);
$version = phpAds_SWFVersion($swf_file);
$compressed = phpAds_SWFCompressed($swf_file);

if ($result)
{
	echo $strConvertSWF.'<br>';
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#F6F6F6'>";
	echo "<form action='banner-swf.php' method='post'>";
	echo "<input type='hidden' name='clientid' value='$clientid'>";
	echo "<input type='hidden' name='campaignid' value='$campaignid'>";
	echo "<input type='hidden' name='bannerid' value='$bannerid'>";
	
	echo "<tr><td height='25' colspan='4' bgcolor='#FFFFFF'><img src='images/".$phpAds_TextDirection."/icon-undo.gif' align='absmiddle'>&nbsp;<b>".$strHardcodedLinks."</b></td></tr>";
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='4'>&nbsp;</td></tr>";
	
	$i=0;
	while (list($key, $val) = each($result))
	{
		list ($url, $target) = $val;
		
		if ($i > 0)
		{
			echo "<tr><td height='20' colspan='4'>&nbsp;</td></tr>";
			echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			echo "<tr><td height='10' colspan='4'>&nbsp;</td></tr>";
		}
		
		echo "<tr><td width='30'>&nbsp;</td><td width='30'><input type='checkbox' name='convert_links[]' value='".$key."' checked></td>";
		echo "<td width='200'>".$strURL."</td>";
		echo "<td><input class='flat' size='35' type='text' name='overwrite_link[".$key."]' style='width:300px;' dir='ltr' value='".phpAds_htmlQuotes($url)."'>";
		echo "<input type='radio' name='chosen_link' value='".$key."'".($i == 0 ? ' checked' : '')."></td></tr>";
		
		echo "<tr><td colspan='2'><img src='images/spacer.gif' height='1' width='100%'></td>";
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		
		echo "<tr><td width='30'>&nbsp;</td><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$strTarget."</td>";
		echo "<td><input class='flat' size='16' type='text' name='overwrite_target[".$key."]' style='width:150px;' dir='ltr' value='".phpAds_htmlQuotes($target)."'>";
		echo "</td></tr>";
		
		if (count($result) > 1)
		{
			echo "<tr><td colspan='2'><img src='images/spacer.gif' height='1' width='100%'></td>";
			echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
			
			echo "<tr><td width='30'>&nbsp;</td><td width='30'>&nbsp;</td>";
			echo "<td width='200'>".$strOverwriteSource."</td>";
			echo "<td><input class='flat' size='50' type='text' name='overwrite_source[".$key."]' style='width:150px;' dir='ltr' value=''>";
			echo "</td></tr>";
		}
		
		$i++;
	}
	
	echo "<tr><td height='20' colspan='4'>&nbsp;</td></tr>";
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
	echo "<br><br>";
	
	echo "<input type='button' name='cancel' value='".$strCancel."' onClick='location.href=\"banner-swf.php\"'>&nbsp;&nbsp;";
	echo "<input type='submit' name='convert' value='".$strConvert."'>";
	
	if (function_exists('gzcompress'))
	{
		echo "&nbsp;&nbsp;<input type='checkbox' name='compress' value='true'".($compressed ? ' checked' : '').($version >= 6 && $compressed ? ' disabled' : '').">";
		echo "&nbsp;".$strCompressSWF;
	}
	
	echo "</form>";
	echo "<br><br>";
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>