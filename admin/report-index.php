<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer <niels@creatype.nl              */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("3");



/*********************************************************/
/* Get plugins list                                      */
/*********************************************************/

function phpAds_ReportPluginList($directory)
{
	$pluginDir = opendir ($directory);
	
	while ($pluginFile = readdir ($pluginDir))
	{
		if (ereg ('^([a-zA-Z0-9\-]*)\.plugin\.php$', $pluginFile, $matches))
		{
			$plugins[$matches[1]] = phpAds_ReportGetPluginInfo($directory.$pluginFile);
		}
	}
	
	closedir ($pluginDir);
	
	return ($plugins);
}

function phpAds_ReportGetPluginInfo($filename)
{
	include ($filename);
	return  ($plugin_info_function());
}



/*********************************************************/
/* Functions to get plugin parameters                    */
/*********************************************************/

function phpAds_getCampaignArray()
{
	global $phpAds_tbl_clients;
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			$phpAds_tbl_clients
		WHERE
			parent > 0
		");
	
	while ($row = phpAds_dbFetchArray($res))
		$campaignArray[$row['clientID']] = phpAds_buildClientName ($row['clientID'], $row['clientname']);
	
	return ($campaignArray);
}

function phpAds_getClientArray()
{
	global $phpAds_tbl_clients;
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			$phpAds_tbl_clients
		WHERE
			parent = 0
		");
	
	while ($row = phpAds_dbFetchArray($res))
		$clientArray[$row['clientID']] = phpAds_buildClientName ($row['clientID'], $row['clientname']);
	
	return ($clientArray);
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
echo "<tr><td height='25' colspan='2'><b>Reports</b></td></tr>";
echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "<form name='report_selection' action='report-index.php'>";
echo "<tr><td height='35' colspan='2'>";
echo "<select name='selection' onChange='this.form.submit();'>";

$plugins = phpAds_ReportPluginList ("report-plugins/");

if (!isset($selection) || $selection == '')
{
	reset($plugins);
	$selection = key($plugins);
}

for (reset($plugins);$key=key($plugins);next($plugins))
{
	echo "<option value='".$key."' ".($selection==$key?"selected":"").">".$plugins[$key]['plugin-name']."</option>";
}

echo "</select>";
echo "&nbsp;<a href='javascript:document.report_selection.submit();'><img src='images/go_blue.gif' border='0'></a>";
echo "</td></tr>";
echo "</form>";
echo "</table>";

echo "<br><br>";

$plugin = $plugins[$selection];
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
echo "<tr><td height='25' colspan='3'>";

if ($plugin['plugin-export'] == 'csv')
	echo "<img src='images/excel.gif' align='absmiddle'>&nbsp;";

echo "<b>".$plugin['plugin-name']."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td height='25' colspan='2'>";
echo nl2br($plugin['plugin-description']);
echo "</td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

if ($fields = $plugin['plugin-import'])
{
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<form action='report-execute.php' method='get'>";
	
	for (reset($fields);$key=key($fields);next($fields))
	{
		echo "<tr><td width='30'>&nbsp;</td>";
		echo "<td width='200'>".$fields[$key]['title']."</td>";
		
		// Text field
		if ($fields[$key]['type'] == 'edit')
		{
			echo "<td width='370'><input type='text' name='".$key."' size='";
			echo isset($fields[$key]['size']) ? $fields[$key]['size'] : "";
			echo "' value='";
			echo isset($fields[$key]['default']) ? $fields[$key]['default'] : "";
			echo "'></td>";
		}
		
		// CampaignID-dropdown
		elseif ($fields[$key]['type'] == 'campaignID-dropdown')
		{
			echo "<td width='370'><select name='".$key."'>";
			
			$campaignArray = phpAds_getCampaignArray();
			for (reset($campaignArray);$ckey=key($campaignArray);next($campaignArray))
				echo "<option value='".$ckey."'>".$campaignArray[$ckey]."</option>";
			echo "</select></td>";
		}
		
		// ClientID-dropdown
		elseif ($fields[$key]['type'] == 'clientID-dropdown')
		{
			echo "<td width='370'><select name='".$key."'>";
			
			$clientArray = phpAds_getClientArray();
			for (reset($clientArray);$ckey=key($clientArray);next($clientArray))
				echo "<option value='".$ckey."'>".$clientArray[$ckey]."</option>";
			echo "</select></td>";
		}
		
		echo "</tr>";
		
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
		echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	}
	
	echo "<tr><td height='25' colspan='3'>";
	echo "<br><br>";
	echo "<input type='hidden' name='plugin' value='".$selection."'>";
	echo "<input type='submit' value='Generate'>";
	echo "</td></tr>";
	
	echo "</form>";
}

echo "</table>";




/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();







?>
