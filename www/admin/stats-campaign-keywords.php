<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-data-statistics.inc.php';

// Register input variables
phpAds_registerGlobal ('period','expand','bannershidden','hideinactive','listorder','orderdirection');


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);


// Set default values
if (!isset($period))
	$period = '';

$tabindex = 1;

//-------------------------------
// declare temp vars

$start_date = '2003-10-01';
$end_date	= '2003-10-27';

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/


if (phpAds_isUser(phpAds_Client))
{
	if (phpAds_getUserID() == phpAds_getCampaignParentClientID ($campaignid))
	{
		$res = phpAds_dbQuery(
			"SELECT *".
			" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
			" WHERE clientid = ".phpAds_getUserID().
			phpAds_getCampaignListOrder ($navorder, $navdirection)
		) or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			phpAds_PageContext (
				phpAds_buildName ($row['campaignid'], $row['campaignname']),
				"stats.php?entity=campaign&breakdown=history&clientid=".$clientid."&campaignid=".$row['campaignid'],
				$campaignid == $row['campaignid']
			);
			
		}
		
		phpAds_PageHeader("1.2.1");
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getCampaignName($campaignid)."</b><br /><br /><br />";
			
			if (phpAds_isAllowed(phpAds_ViewTargetingStats)) 
				phpAds_ShowSections(array("1.2.1", "1.2.2", "1.2.3", "1.2.4"));
			else 
				phpAds_ShowSections(array("1.2.1", "1.2.2", "1.2.3"));
			
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}
elseif (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency))
{
	if (phpAds_isUser(phpAds_Admin))
	{
		$query = "SELECT campaignid,campaignname".
			" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
			" WHERE clientid='".$clientid."'".
			phpAds_getCampaignListOrder ($navorder, $navdirection);
	}
	elseif (phpAds_isUser(phpAds_Agency))
	{
		$query = "SELECT m.campaignid,m.campaignname".
			" FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
			",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
			" WHERE m.clientid=c.clientid".
			" AND m.clientid='".$clientid."'".
			" AND c.agencyid=".phpAds_getUserID().
			phpAds_getCampaignListOrder ($navorder, $navdirection);
	}
	$res = phpAds_dbQuery($query)
		or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildName ($row['campaignid'], $row['campaignname']),
			"stats.php?entity=campaign&breakdown=history&clientid=".$clientid."&campaignid=".$row['campaignid'],
			$campaignid == $row['campaignid']
		);
	}
	
	phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');
	phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
	phpAds_PageHeader("2.1.2.2");
		echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getParentClientName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getCampaignName($campaignid)."</b><br /><br /><br />";
		phpAds_ShowSections(array("2.1.2.1", "2.1.2.2", "2.1.2.3", "2.1.2.4", "2.1.2.5"));
}




/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive))
{
	if (isset($session['prefs']['stats.php?entity=campaign&breakdown=keywords']['hideinactive'])) {
		$hideinactive = $session['prefs']['stats.php?entity=campaign&breakdown=keywords']['hideinactive'];
	} else {
	    $pref = &$GLOBALS['_MAX']['PREF'];
		$hideinactive = ($pref['gui_hide_inactive'] == 't');
	}
}

if (!isset($listorder))
{
	if (isset($session['prefs']['stats.php?entity=campaign&breakdown=keywords']['listorder']))
		$listorder = $session['prefs']['stats.php?entity=campaign&breakdown=keywords']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($session['prefs']['stats.php?entity=campaign&breakdown=keywords']['orderdirection']))
		$orderdirection = $session['prefs']['stats.php?entity=campaign&breakdown=keywords']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($session['prefs']['stats.php?entity=campaign&breakdown=keywords']['stats_tree']))
	$stats_tree = $session['prefs']['stats.php?entity=campaign&breakdown=keywords']['stats_tree'];
else
	$stats_tree = array();
	
	



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

switch ($period)
{
	case 't':	$timestamp	= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				$limit 		= " AND day >= ".date('Ymd', $timestamp);
				break;
			
	case 'w':	$timestamp	= mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
				$limit 		= " AND day >= ".date('Ymd', $timestamp);
				break;
			
	case 'm':	$timestamp	= mktime(0, 0, 0, date('m'), 1, date('Y'));
				$limit 		= " AND day >= ".date('Ymd', $timestamp);
				break;
			
	default:	$limit = '';
				$period = '';
				break;
}


	//check whether file has been submitted
	if (isset($_POST['upload']))
	{
	
		// function that parses the content of the file and returns the two
		// columns specified in the $columnsToGet
		function parseFile($filename, $columnNamesToGet) {

			if (isset($filename) && $filename !='')
			{
			
				$fh = fopen($filename, 'r') 
					or die ("Can't open file! Error: " . $php_errormsg);
				
				$content = fread($fh, filesize($filename));
				
				fclose($fh);
					

				//figure out where this report is from
				if (preg_match("/^start date/i", $content))
				{
					$documentSource = 'Overture';
					$columnNamesRow = 0;
					$columnDelimiter = ",";
				}
				else if (preg_match("/^��K/i", $content))
				{
				
					// remove crazy characters!
					for ($f=0; $f<strlen($content);$f=$f+2)
						$newContent .= $content[$f];

					$content = $newContent;
					
					$documentSource = 'Google';
					$columnNamesRow = 6;
					// overide $columnNamesToGet due to differences in the structure of the files :S
					$columnNamesToGet = array('Keyword', 'Cost');
					$columnDelimiter = "\t";									
				}
				else if (preg_match("/^advertiser reports/i", $content))
				{
					$documentSource = 'E-Spotting';
					$columnNamesRow = 1;					
					// overide $columnNamesToGet due to differences in the structure of the files :S
					$columnNamesToGet = array('Keyword', 'Cost');
					$columnDelimiter = ",";					
				}
				else
				{
					echo "<script>alert('Wrong File Type.');</script>";
					return(false);
				}



				//store lines in an array
				$lineDelimiter = "\n";
				$records = explode($lineDelimiter, $content);
				
				// split each record into an array and then
				// store each record in the records array
				foreach($records as $recordKey=>$record)
					$records[$recordKey] = explode($columnDelimiter, $record);
			

				// get column indexes in the records array by comparing with $columnNames array
				// assume the first record contains column titles
				foreach($records[$columnNamesRow] as $recordColumnKey=>$recordColumnName)
				{

					if (trim($recordColumnName) === trim($columnNamesToGet[0]))
						$columnNamesToGet[0] = $recordColumnKey;

					else if (trim($recordColumnName) === trim($columnNamesToGet[1]))
						$columnNamesToGet[1] = $recordColumnKey;

				}
			
				// create an array in which the key is the first index in $columnNamesToGet
				// and the second will hold the value.
				// use regex to remove pound symbol from some reports.
				for ($i=$columnNamesRow+1; $i < count($records)-1; $i++)
				{
					$key 	= str_replace(" ", "+", $records[$i][$columnNamesToGet[0]]);
					$value 	= preg_replace('/^'.chr(163).'?\s?(.*?)/i','$1', $records[$i][$columnNamesToGet[1]]);
					
					$results[$key] = $value;
				}

				return($results);
			}

			return(false);

		}

		set_time_limit(60);
		
		//path to upload to
		//$path = dirname($PATH_TRANSLATED) . "/upload/";
		
		//filename
		$filenameOnTemp = $_FILES['file']['tmp_name'];
		
		// column names to get. The first element will be the key in the array
		$columnNamesToGet = array('Search Term', 'Total Cost');
		
		$resource = parseFile($filenameOnTemp, $columnNamesToGet);

		// write to the camnpaign_resources db
		if($resource != false)
		{
		
			//check whether record exists
			$result = phpAds_dbQuery("SELECT resourceid FROM ".$conf['table']['prefix'].$conf['table']['campaign_resources']." WHERE campaignid=".$campaignid);
			
			if(phpAds_dbNumRows($result) > 0)
			
				phpAds_dbQuery("UPDATE ".$conf['table']['prefix'].$conf['table']['campaign_resources']."
									SET resource = '".serialize($resource)."' 
									WHERE campaignid = '".$campaignid."'
									LIMIT 1"
									
							) or die();
						
			else
				phpAds_dbQuery("INSERT INTO ".$conf['table']['prefix'].$conf['table']['campaign_resources']."
										(campaignid,
										 resource)
									VALUES
										(".$campaignid.",
										'".serialize($resource)."')") or die();
							
									
		}
	}



// build stats array

// get banner ids for this campaign
$res_banners = phpAds_dbQuery("
			SELECT
				bannerid,
				description,
				active
			FROM
				".$conf['table']['prefix'].$conf['table']['banners']."
			WHERE
				campaignid = '".$campaignid."'"
); 

// check whether external data for this campaign exists
$res_external_data = phpAds_dbQuery("
						SELECT
							resource
						FROM
							".$conf['table']['prefix'].$conf['table']['campaign_resources']."
						WHERE
							campaignid = '".$campaignid."'"
); 


$row_external_data = phpAds_dbFetchArray($res_external_data);

if (count($row_external_data) > 0)
	$external_data = unserialize($row_external_data['resource']);

$banner_index = 0;
$bannershidden = 0;

// for each banner id...
while ($row_banners = phpAds_dbFetchArray($res_banners))
{

	$bannerid = $row_banners['bannerid'];
	
	// create banner id branch
	$stats[$banner_index]['id'] 	= $bannerid;
	$stats[$banner_index]['name'] 	= $row_banners['description'];
	
	// is banner active
	if ($row_banners['active'] == 't')
		$stats[$banner_index]['active'] = true;
	else
	{
		$stats[$banner_index]['active'] = false;
		$bannershidden++;
		
	}

	//check whether total cost is set for this banner
	$key = 'total_cost' . $bannerid;
	if(isset($_POST[$key]))
		$stats[$banner_index]['total_cost'] = $_POST[$key];

	// ...select all the clicks and group them by source
	$res_clicks = phpAds_dbQuery("
				SELECT
					ad_id AS bannerid,
					page AS source,
					count(page) as clicks
				FROM
					".$conf['table']['prefix'].$conf['table']['data_raw_ad_click']."
				WHERE
					bannerid = '".$bannerid."'
					$limit
				GROUP BY
					source"
	);

	$source_index = 0;
	
	while ($row_clicks = phpAds_dbFetchArray($res_clicks))
	{
		$stats[$banner_index]['children'][$source_index]['name']	= $row_clicks['source'];
		$stats[$banner_index]['children'][$source_index]['clicks'] 	= $row_clicks['clicks'];
		
		$res_conversions = phpAds_dbQuery("
					SELECT
						action_bannerid,
						action_source,
						count(action_bannerid) as conversions
					FROM
						".$conf['table']['prefix'].$conf['table']['conversionlog']."
					WHERE
						action_bannerid = '".$bannerid."'
						AND action_source = '".$row_clicks['source']."'
						AND cnv_logstats = 'y'
					GROUP BY
						 action_bannerid, action_source");
		
		$row_conversions = phpAds_dbFetchArray($res_conversions);
		
		$stats[$banner_index]['children'][$source_index]['conversions'] 	= $row_conversions['conversions'];
		
		
		preg_match('/^(?:[\w]+)+\/(.*?)$/i',$row_clicks['source'], $key);
		
		if(isset($external_data[$key[1]])) 
			$stats[$banner_index]['children'][$source_index]['total_cost'] 	= $external_data[$key[1]];
		else 
			$stats[$banner_index]['children'][$source_index]['total_cost'] = 0;

		$stats[$banner_index]['children'][$source_index]['cpc'] 		=  $stats[$banner_index]['children'][$source_index]['total_cost'] / $row_clicks['clicks'];
		$stats[$banner_index]['children'][$source_index]['sr'] 			=  $row_conversions['conversions'] / $row_clicks['clicks'];
		$stats[$banner_index]['children'][$source_index]['cpco'] 		=  ($row_conversions['conversions'] == 0 ? '&infin;' : $stats[$banner_index]['children'][$source_index]['total_cost'] / $row_conversions['conversions']);
				
		$source_index++;
	}

	$total_clicks_for_banner 		= 0;
	$total_conversions_for_banner 	= 0;
	$total_cost_for_banner 			= 0;

	if (isset($stats[$banner_index]['children']))
		foreach($stats[$banner_index]['children'] as $sources)
		{
			$total_clicks_for_banner 		+= $sources['clicks'];
			$total_conversions_for_banner 	+= $sources['conversions'];
			$total_cost_for_banner 			+= $sources['total_cost'];
		}
	
	$stats[$banner_index]['clicks'] 		= $total_clicks_for_banner;
	$stats[$banner_index]['conversions'] 	= $total_conversions_for_banner;
	$stats[$banner_index]['total_cost'] 	= $total_cost_for_banner;
	$stats[$banner_index]['cpc'] 			= ($stats[$banner_index]['clicks'] == 0 ? 0 : $stats[$banner_index]['total_cost'] / $stats[$banner_index]['clicks']);
	$stats[$banner_index]['sr']				= ($stats[$banner_index]['clicks'] == 0 ? 0 : $stats[$banner_index]['conversions'] / $stats[$banner_index]['clicks']);
	$stats[$banner_index]['cpco']			= ($stats[$banner_index]['conversions'] == 0 ? '&infin;' : $stats[$banner_index]['total_cost'] / $stats[$banner_index]['conversions']);
	
	$totalclicks 		+= $total_clicks_for_banner;
	$totalconversions 	+= $total_conversions_for_banner;
	$totalcost 			+= $total_cost_for_banner;
	

	$banner_index++;

}


// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
{

	switch ($expand)
	{
		case 'all' :	if (isset($stats_tree) && isset($stats))
							foreach($stats as $k=>$v)
							{	
								$stats_tree[$k] = array();
								$stats_tree[$k]['expand'] = true;
								
							}
		
						break;
						
		case 'none':	if (isset($stats_tree) && isset($stats))
							foreach($stats as $k=>$v)
							{
								$stats_tree[$k] = array();
								$stats_tree[$k]['expand'] = false;
							}

						break;
						
		default:		if (isset($stats_tree))
						{							
							$stats_tree[$expand]['expand'] = !$stats_tree[$expand]['expand'];
						}
							
							
						break;
	}
}
//-----------------------------------------------------------------------------------------------------------------------
// Sort array according to selected column and direction
//-----------------------------------------------------------------------------------------------------------------------
switch ($listorder)
{
	case $GLOBALS['strName']: 			phpAds_sortArray($stats,'name',($orderdirection == 'up' ? TRUE : FALSE));
										break;
			
	case $GLOBALS['strID']: 			phpAds_sortArray($stats,'id',($orderdirection == 'up' ? TRUE : FALSE));
										break;
					
	case $GLOBALS['strClicks']: 		phpAds_sortArray($stats,'clicks',($orderdirection == 'up' ? TRUE : FALSE));
										break;
					
					
	case $GLOBALS['strCPCShort']: 		phpAds_sortArray($stats,'cpc',($orderdirection == 'up' ? TRUE : FALSE));
										break;
					
					
	case $GLOBALS['strTotalCost']: 		phpAds_sortArray($stats,'total_cost',($orderdirection == 'up' ? TRUE : FALSE));
										break;
					
					
	case $GLOBALS['strConversions']: 	phpAds_sortArray($stats,'conversions',($orderdirection == 'up' ? TRUE : FALSE));
										break;
					
	case $GLOBALS['strCNVRShort']: 	phpAds_sortArray($stats,'sr',($orderdirection == 'up' ? TRUE : FALSE));
										break;

	case $GLOBALS['strCPCoShort']:	 	phpAds_sortArray($stats,'cpco',($orderdirection == 'up' ? TRUE : FALSE));
										break;
						
					
	default:	break;

}
//-----------------------------------------------------------------------------------------------------------------------
// Sort array according to selected column and direction END
//-----------------------------------------------------------------------------------------------------------------------

	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

	echo "<tr><td>";

	echo "<form name='choose_view' action='stats.php'>";
	echo "<input type='hidden' name ='entity' value='campaign'>";
	echo "<input type='hidden' name ='breakdown' value='banners'>";
	echo "<input type='hidden' name ='clientid' value='".$clientid."'>";
	echo "<input type='hidden' name ='campaignid' value='".$campaignid."'>";
	echo "<select name='period' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>";
	echo "<option value='banner'".($_SERVER['PHP_SELF'] == '/admin/stats.php?entity=campaign&breakdown=banners' ? ' selected' : '').">".$strBannerOverview."</option>";
	echo "<option value='keyword'".($_SERVER['PHP_SELF'] == '/admin/stats.php?entity=campaign&breakdown=keywords' ? ' selected' : '').">".$strKeywordStatistics."</option>";
	echo "</select>";
	echo "</td>";
	echo "</form>";
	echo "</tr>";
	echo "<tr><td>";
		phpAds_ShowBreak();
	echo "</td></tr>";


	echo "<tr><td>";

	echo "<form name='choose_period' action='".$_SERVER['PHP_SELF']."'>";
	echo "<input type='hidden' name ='clientid' value='".$clientid."'>";
	echo "<input type='hidden' name ='campaignid' value='".$campaignid."'>";
	echo "<select name='period' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>";
	echo "<option value=''".($period == '' ? ' selected' : '').">".$strCollectedAll."</option>";
	echo "<option value='t'".($period == 't' ? ' selected' : '').">".$strCollectedToday."</option>";
	echo "<option value='w'".($period == 'w' ? ' selected' : '').">".$strCollected7Days."</option>";
	echo "<option value='m'".($period == 'm' ? ' selected' : '').">".$strCollectedMonth."</option>";
	echo "</select>";
	echo "</td>";
	echo "</form>";
	echo "</tr>";
	echo "<tr><td>";
		phpAds_ShowBreak();
	echo "</td></tr>";
	
	echo "<tr>";
	echo "<form method='post' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>\n";
	echo "<input type='hidden' name ='clientid' value='".$clientid."'>";
	echo "<input type='hidden' name ='campaignid' value='".$campaignid."'>";
	echo "<td align='".$phpAds_TextAlignRight."'>";
	echo "<b>".$strImportStats.": </b><input type='hidden' name='MAX_FILE_SIZE' value='800000'>&nbsp;";
	echo "<input type='file' name='file' size='30'>&nbsp;";
	echo "<input type='submit' name='upload' value='Update'>";
	echo "</td>";
	echo "</form>";	
	echo "</tr>";

	echo "</table>";


if ($clientshidden > 0 || $totalviews > 0 || $totalclicks > 0 || $totalconversions > 0)
{
	echo "<br /><br />";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	
	echo "<tr>";
	echo "<td><img src='images/spacer.gif' width='200' height='1'</td>";
	echo "<td><img src='images/spacer.gif' width='50' height='1'</td>";
	echo "<td><img src='images/spacer.gif' width='50' height='1'</td>";
	echo "<td><img src='images/spacer.gif' width='50' height='1'</td>";
	echo "<td><img src='images/spacer.gif' width='50' height='1'</td>";
	echo "<td><img src='images/spacer.gif' width='50' height='1'</td>";
	echo "<td><img src='images/spacer.gif' width='50' height='1'</td>";
	echo "<td><img src='images/spacer.gif' width='50' height='1'</td>";
	echo "</tr>";

	echo "<tr height='25'>";

	// $title column
	echo '<td height="25"><b>&nbsp;&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&listorder='.$GLOBALS['strName'].'">'.$GLOBALS['strName'].'</a>';
	if ($listorder == $GLOBALS['strName'] || $listorder == "")
		echo $orderdirection == "up" 
			? ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&orderdirection=down&campaignid='.$campaignid.'"><img src="images/caret-u.gif" border="0" alt="" title=""></a>')
			: ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&orderdirection=up&campaignid='.$campaignid.'"><img src="images/caret-ds.gif" border="0" alt="" title=""></a>');
	echo '</b></td>';
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b><a href='".$_SERVER['PHP_SELF']."?listorder=".$GLOBALS['strID']."&clientid=".$clientid."&campaignid=".$campaignid."'>".$GLOBALS['strID']."</a>";
	if ($listorder == $GLOBALS['strID'])
		echo $orderdirection == "up" 
			? ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down"><img src="images/caret-u.gif" border="0" alt="" title=""></a>')
			: ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up"><img src="images/caret-ds.gif" border="0" alt="" title=""></a>');
	echo '</b></td>';
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b><a href='".$_SERVER['PHP_SELF']."?listorder=".$GLOBALS['strClicks']."&clientid=".$clientid."&campaignid=".$campaignid."'>".$GLOBALS['strClicks']."</a>";
	if ($listorder == $GLOBALS['strClicks'])
		echo $orderdirection == "up" 
			? ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down"><img src="images/caret-u.gif" border="0" alt="" title=""></a>')
			: ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up"><img src="images/caret-ds.gif" border="0" alt="" title=""></a>');
	echo '</b></td>';
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b><a href='".$_SERVER['PHP_SELF']."?listorder=".$GLOBALS['strCPCShort']."&clientid=".$clientid."&campaignid=".$campaignid."'>".$GLOBALS['strCPCShort']."</a>";
	if ($listorder == $GLOBALS['strCPCShort'])
		echo $orderdirection == "up" 
			? ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down"><img src="images/caret-u.gif" border="0" alt="" title=""></a>')
			: ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up"><img src="images/caret-ds.gif" border="0" alt="" title=""></a>');
	echo '</b></td>';
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b><a href='".$_SERVER['PHP_SELF']."?listorder=".$GLOBALS['strTotalCost']."&clientid=".$clientid."&campaignid=".$campaignid."'>".$GLOBALS['strTotalCost']."</a>";
	if ($listorder == $GLOBALS['strTotalCost'])
		echo $orderdirection == "up" 
			? ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down"><img src="images/caret-u.gif" border="0" alt="" title=""></a>')
			: ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up"><img src="images/caret-ds.gif" border="0" alt="" title=""></a>');
	echo '</b></td>';
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b><a href='".$_SERVER['PHP_SELF']."?listorder=".$GLOBALS['strConversions']."&clientid=".$clientid."&campaignid=".$campaignid."'>".$GLOBALS['strConversions']."</a>";
	if ($listorder == $GLOBALS['strConversions'])
		echo $orderdirection == "up" 
			? ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down"><img src="images/caret-u.gif" border="0" alt="" title=""></a>')
			: ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up"><img src="images/caret-ds.gif" border="0" alt="" title=""></a>');
	echo '</b></td>';
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b><a href='".$_SERVER['PHP_SELF']."?listorder=".$GLOBALS['strCNVRShort']."&clientid=".$clientid."&campaignid=".$campaignid."'>".$GLOBALS['strCNVRShort']."</a>";
	if ($listorder == $GLOBALS['strCNVRShort'])
		echo $orderdirection == "up" 
			? ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down"><img src="images/caret-u.gif" border="0" alt="" title=""></a>')
			: ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up"><img src="images/caret-ds.gif" border="0" alt="" title=""></a>');
	echo '</b></td>';
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b><a href='".$_SERVER['PHP_SELF']."?listorder=".$GLOBALS['strCPCoShort']."&clientid=".$clientid."&campaignid=".$campaignid."'>".$GLOBALS['strCPCoShort']."</a>";
	if ($listorder == $GLOBALS['strCPCoShort'])
		echo $orderdirection == "up" 
			? ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down"><img src="images/caret-u.gif" border="0" alt="" title=""></a>')
			: ('<a href="'.$_SERVER['PHP_SELF'].'?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up"><img src="images/caret-ds.gif" border="0" alt="" title=""></a>');
	echo '</b>&nbsp;&nbsp;</td>';
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='8' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	echo "<form  action='".$_SERVER['PHP_SELF']."' method='post'>";
	echo "<input type='hidden' name='clientid' value='".$clientid."'>";	
	echo "<input type='hidden' name='campaignid' value='".$campaignid."'>";
	
	$i=0;
	foreach($stats as $key=>$banner)
	{
		if ($banner['active'] == true || $hideinactive == false)
			{	
			echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			// Icon & name
			echo "<td height='25'>";
			
			// Expanding arrow on left of name
			if (isset($banner['children']))
			{
				if ($stats_tree[$key]['expand'] == '1')
					echo "&nbsp;<a href='".$_SERVER['PHP_SELF']."?period=".$period."&amp;expand=".$key."&clientid=".$clientid."&campaignid=".$campaignid."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
				else
					echo "&nbsp;<a href='".$_SERVER['PHP_SELF']."?period=".$period."&amp;expand=".$key."&clientid=".$clientid."&campaignid=".$campaignid."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
			}
			else
				echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
				
			
			echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
			echo "<a href='".$_SERVER['PHP_SELF']."?clientid=".$clientid."&campaignid=".$campaignid."'>".$banner['name']."</a>";
			echo "</td>";
			
			// ID
			echo "<td height='25' align='".$phpAds_TextAlignRight."'>".$banner['id']."</td>";
			
			// Clicks
			echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($banner['clicks'])."</td>";
			
			// CPC
			echo "<td height='25' align='".$phpAds_TextAlignRight."'>".($banner['clicks'] > 0 ? "&pound; ".phpAds_formatNumber($banner['cpc'],2) : "&infin;" )."</td>";
			
			// Total Cost
			echo "<td height='25' align='".$phpAds_TextAlignRight."'>&pound; ".$banner['total_cost']."</td>";
			
			// Conversions
			echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($banner['conversions'])."</td>";
			
			// CNVR
			echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($banner['clicks'], $banner['conversions'])."</td>";
			
			// CPCo
			echo "<td height='25' align='".$phpAds_TextAlignRight."'>".($banner['conversions'] > 0 ? "&pound; ".phpAds_formatNumber($banner['cpco'],2) : "&infin;" ) ."&nbsp;&nbsp;</td>";
	
			
			if (isset($banner['children']) && sizeof ($banner['children']) > 0 && $stats_tree[$key]['expand'] == true)
			{
			
				foreach($banner['children'] as $source_index=>$sources)
				{
					// Divider
					echo "<tr height='1'>";
					echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
					echo "<td colspan='7' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
					echo "</tr>";
					
					// Icon & name
					echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					echo "<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;";
					
					
					echo "<img src='images/icon-banner-text.gif' align='absmiddle'>&nbsp;";
					
					echo "<span style='color:#003399'>".$sources['name']."</span></td>";
					echo "</td>";
					
					// ID
					echo "<td height='25' align='".$phpAds_TextAlignRight."'></td>";
					
					// Clicks
					echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($sources['clicks'])."</td>";
					
					// CPC
					echo "<td height='25' align='".$phpAds_TextAlignRight."'>".($sources['clicks'] > 0 ? "&pound; ".$sources['cpc'] : "&infin;" )."</td>";
					
					// Total Cost
					echo "<td height='25' align='".$phpAds_TextAlignRight."'>&pound; ".$sources['total_cost']."</td>";
					
					// Conversion
					echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($sources['conversions'])."</td>";
					
					// CNVR
					echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($sources['clicks'], $sources['conversions'])."</td>";
					
					// CPCo
					echo "<td height='25' align='".$phpAds_TextAlignRight."'>". ($sources['conversions'] > 0 ? "&pound;  " . $sources['total_cost']/$sources['conversions'] : "&infin;" ) ."&nbsp;&nbsp;</td>";
					
				}
			}
			
	
			echo "<tr height='1'><td colspan='9' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			$i++;
		}
	}
	
	
	// Total
	echo "<tr height='25' ".($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "")."><td height='25'>&nbsp;&nbsp;<b>".$strTotal."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalclicks)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'></td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>&pound; ".phpAds_formatNumber($totalcost,2)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalconversions)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($totalclicks, $totalconversions)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>&pound; ".phpAds_formatNumber(($totalconversions == 0 ? 0 : $totalcost/$totalconversions), 2)."&nbsp;&nbsp;</td>";
	echo "</tr>";
	echo "<tr height='1'><td colspan='8' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	echo "<tr><td height='25' colspan='5' align='".$phpAds_TextAlignLeft."' nowrap>";
	
	if ($hideinactive == true)
	{
		echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='".$_SERVER['PHP_SELF']."?period=".$period."&amp;hideinactive=0&clientid=".$clientid."&campaignid=".$campaignid."'>".$strShowAll."</a>";
		echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$bannershidden." ".$strInactiveBannersHidden;
	}
	else
	{
		echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='".$_SERVER['PHP_SELF']."?period=".$period."&amp;hideinactive=1&clientid=".$clientid."&campaignid=".$campaignid."'>".$strHideInactiveBanners."</a>";
	}
	
	echo "</td><td height='25' colspan='4' align='".$phpAds_TextAlignRight."' nowrap>";
	echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='".$_SERVER['PHP_SELF']."?period=".$period."&amp;expand=all&clientid=".$clientid."&campaignid=".$campaignid."' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
	echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
	echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='".$_SERVER['PHP_SELF']."?period=".$period."&amp;expand=none&clientid=".$clientid."&campaignid=".$campaignid."' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>&nbsp;&nbsp;";
	echo "</td></tr>";
	
	
	/*
	
	// Spacer
	echo "<tr><td colspan='5' height='40'>&nbsp;</td></tr>";
	
	
	
	// Stats today
	$adviews  = (int)phpAds_totalViews("", "day");
	$adclicks = (int)phpAds_totalClicks("", "day");
	$ctr = phpAds_buildCTR($adviews, $adclicks);
		echo "<tr><td height='25' colspan='2'>&nbsp;&nbsp;<b>".$strToday."</b></td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adviews)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adclicks)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".$ctr."&nbsp;&nbsp;</td></tr>";
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	// Stats this week
	$adviews  = (int)phpAds_totalViews("", "week");
	$adclicks = (int)phpAds_totalClicks("", "week");
	$ctr = phpAds_buildCTR($adviews, $adclicks);
		echo "<tr><td height='25' colspan='2'>&nbsp;&nbsp;".$strLast7Days."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adviews)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adclicks)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".$ctr."&nbsp;&nbsp;</td></tr>";
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	// Stats this month
	$adviews  = (int)phpAds_totalViews("", "month");
	$adclicks = (int)phpAds_totalClicks("", "month");
	$ctr = phpAds_buildCTR($adviews, $adclicks);
		echo "<tr><td height='25' colspan='2'>&nbsp;&nbsp;".$strThisMonth."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adviews)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adclicks)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".$ctr."&nbsp;&nbsp;</td></tr>";
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	*/
	
	echo "</form>";
	echo "</table>";
	echo "<br /><br />";
}
else
{
	echo "<br /><br /><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>";
	echo $strNoStats.'</div>';
}



/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['stats.php?entity=campaign&breakdown=keywords']['hideinactive']   = $hideinactive;
$session['prefs']['stats.php?entity=campaign&breakdown=keywords']['listorder']      = $listorder;
$session['prefs']['stats.php?entity=campaign&breakdown=keywords']['orderdirection'] = $orderdirection;
$session['prefs']['stats.php?entity=campaign&breakdown=keywords']['stats_tree']     = $stats_tree;

phpAds_SessionDataStore();



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
