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
$Id: maintenance-source-edit.php 4349 2006-03-06 17:51:10Z matteo@beccati.com $
*/

// Require the initialisation file
require_once '../../init.php';

require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

// Register Input Variables
phpAds_registerGlobal (
	 'collapse'
	,'expand'
	,'listorder'
	,'orderdirection'
	,'parent'
	,'source_del'
	,'source_new'
	,'source_old'
	,'source_parent_del'
	,'submit'
);


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.3");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_MaintenanceSelection("source-edit");


$pageID = "maintenance-source-edit.php";

// Check if Posting Information
if (isset($submit))
{
	// Make sure that this process finishes...
	@set_time_limit (300);
	@ignore_user_abort(1);
	if ( isset($source_old) & isset($source_new))
	{
		for ($i=0; $i<sizeof($source_old); $i++)
		{
			if ($source_old[$i] != $source_new[$i])
			{
				$old_source = (strlen($parent) > 0) ? $parent.'/'.$source_old[$i] : $source_old[$i];
				$new_source = (strlen($parent) > 0) ? $parent.'/'.$source_new[$i] : $source_new[$i];

				phpAds_updateSources($old_source, $new_source);
			}
		}
	}
	if ( isset($source_del) )
	{
		for ($i=0; $i<sizeof($source_del); $i++)
		{
			$old_source = (strlen($parent) > 0) ? $parent.'/'.$source_del[$i] : $source_del[$i];
			$new_source = (strlen($parent) > 0) ? $parent.'/' : '';

			phpAds_updateSources($old_source, $new_source);
		}
	}
	if ( isset($source_parent_del) )
	{
		for ($i=0; $i<sizeof($source_parent_del); $i++)
		{
			$pos = strrpos($parent, '/');
			if ($pos === false)
			{
				$new_parent = '';
			}
			else
			{
				$new_parent = substr($parent, 0, $pos+1);
			}

			$old_source = (strlen($parent) > 0) ? $parent.'/'.$source_parent_del[$i] : $source_parent_del[$i];
			$new_source = (strlen($parent) > 0) ? $new_parent.'/'.$source_parent_del[$i] : $source_parent_del[$i];

			phpAds_updateSources($old_source, $new_source);
		}
	}

	echo "<a href='".$pageID."?parent=".$parent.">Continue.</a><br />";
	exit;
}
else
{
	// Get Data
	//require_once("source-edit-businesslayer.inc.php");
	$source_arr = phpAds_getPageData($pageID);

	// Display Data
	//require_once("source-edit-display.inc.php");
	phpAds_displayData($source_arr, $pageID);

	// Store Preferences
	phpAds_setPref($page, 'parent', $parent);
	phpAds_SessionDataStore();
}

function phpAds_updateSources($old_source, $new_source)
{
	$conf = $GLOBALS['_MAX']['CONF'];

	$old_source_len = strlen($old_source);

	echo "Converting: ".$old_source." to ".$new_source." ...";

	$query = "UPDATE ".$conf['table']['prefix'].$conf['table']['data_raw_ad_click'].
		" SET page=CONCAT('".$new_source."',SUBSTRING(page,".($old_source_len+1).")) WHERE page LIKE '".$old_source."%'";

	$res = phpAds_dbQuery($query)
		or phpAds_sqlDie();

	$query = "UPDATE ".$conf['table']['prefix'].$conf['table']['conversionlog'].
		" SET action_source=CONCAT('".$new_source."',SUBSTRING(action_source,".($old_source_len+1).")) WHERE action_source LIKE '".$old_source."%'";

	$res = phpAds_dbQuery($query)
		or phpAds_sqlDie();

	$query = "UPDATE ".$conf['table']['prefix'].$conf['table']['data_raw_ad_impression'].
		" SET page=CONCAT('".$new_source."',SUBSTRING(page,".($old_source_len+1)."))".
		" WHERE page='".$old_source."%'".
		" OR page LIKE '".$old_source."/%'";

	$res = phpAds_dbQuery($query)
		or phpAds_sqlDie();

	echo "Done.<br />";
}

function phpAds_getPageData($pageID)
{
	global $parent;

	// GET PREFERENCES
	require_once("lib-prefs.inc.php");
	if (!isset($parent))
		$parent = phpAds_getPref($pageID, 'parent');

	// GET DATA
	require_once('lib-data-sources.inc.php');
	$source_arr = phpAds_getSources('SOURCES', $parent);

	return $source_arr;
}

function phpAds_displayData($source_arr, $pageID)
{
	global $parent;

	echo "<form action='".$pageID."' method='post'>\n";

	$parent_arr = explode('/', $parent);

	echo "<h1><a href='".$pageID."?parent='>Top</a> : ";
	$tmp_parent = "";
	for ($i=0; $i<sizeof($parent_arr); $i++)
	{
		if ($i != 0) echo ' / ';

		$tmp_parent = strlen($tmp_parent) > 0 ? $tmp_parent.'/'.$parent_arr[$i] : $parent_arr[$i];
		echo "<a href='".$pageID."?parent=".urlencode($tmp_parent)."'>".$parent_arr[$i]."</a>";
	}
	echo "</h1>\n";

	echo "<table cellspacing='0' cellpadding='0' border='1'>\n";
	echo "<tr class='data_header_row'>\n";
	echo "\t<td class='data_header_cell'>Views</td>\n";
	echo "\t<td class='data_header_cell'>Source</td>\n";
	echo "\t<td class='data_header_cell'>Modified Source</td>\n";
	echo "\t<td class='data_header_cell'>Remove this part</td>\n";
	echo "\t<td class='data_header_cell'>Remove parent</td>\n";
	echo "</tr>\n";

	for ($i=0; $i<sizeof($source_arr); $i++)
	{
		if (is_array($source_arr[$i]))
		{
			$source_part = $source_arr[$i]['source_part'];
			$sum_views = $source_arr[$i]['sum_views'];
			echo "<tr class='data_row".($cnt%2==0?"_alt":"")."'>\n";
			echo "\t<td class='data_cell'>".$sum_views."</td>\n";
			echo "\t<td class='data_cell'>";
			echo "<a href='".$pageID."?parent=".urlencode(strlen($parent) > 0 ? $parent.'/'.$source_part : $source_part)."'>";
			echo $source_part;
			echo "</td>\n";
			echo "<td>";
			echo "<input type='hidden' name='source_old[]' value='".$source_part."'>";
			echo "<input type='text' class='flat' size='26' name='source_new[]' value='".$source_part."' style='width:250px;'>";
			echo "</td>\n";
			echo "<td>";
			echo "<input type='checkbox' name='source_del[]' value='".$source_part."'>";
			echo "</td>\n";
			echo "<td>";
			if (strlen($parent) > 0)
			{
				echo "<input type='checkbox' name='source_parent_del[]' value='".$source_part."'>";
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</td>\n";
			echo "</tr>\n";
		}
	}

	echo "</table>\n";
	echo "<input type='hidden' name='parent' value='".$parent."'>\n";
	echo "<input type='submit' name='submit' value='Update Fields'>\n";
	echo "</form>\n";

	phpAds_PageFooter();
}

function phpAds_displayDataRow($data_arr, $level = 0)
{
	global
		 $cnt
		,$page_ID
		,$phpAds_TextDirection
	;
	$show_children = false;

	echo "<tr class='data_row".($cnt%2==0?"_alt":"").">\n";

	// Change this to a SPAN??
	if ($level > 1)
		echo "<img src='images/spacer.gif' width='".($level*15)."' height='1' border='0'>";


	if (isset($data_arr['children']) && is_array($data_arr['children']) && (sizeof($data_arr['children']) > 0) )
	{
		if (in_array($data_arr['name'], $expand_arr))
		{
			echo "<a href='".$page_ID."?collapse=".$data_arr['name']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>";
			$show_children = true;
		}
		else
			echo "<a href='".$page_ID."?expand=".$data_arr['name']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>";
	}

	if ($level == 0)
		echo "<span class='data_row_top'>".$data_arr['name']."</span></td>\n";
	else
		echo $data_arr['name']."</td>\n";

	echo "</tr>\n";

	if ($show_children)
	{
		for ($i=0; $i<sizeof($data_arr['children']); $i++)
		{
			phpAds_displayStatsRow($data_arr['children'][$i], $expand_arr, $level+1);
		}
	}

	if ($level == 0)
		$cnt++;
}

function phpAds_printTableBreak($num_columns, $offset=0, $bgcolor='')
{

	echo "\t\t\t\t<tr height='1'";

	if ($offset > 0)
	{
		if (strlen($bgcolor) > 0)
		{
			$bgcolor = " bgcolor='".$bgcolor."'";
		}

		echo $bgcolor."><td";

		if ($offset > 1)
		{
			echo " colspan='".$offset."'";
		}

		echo "><img src='images/spacer.gif' width='100%' height='1' border='0'></td>";
	}

	echo "<td colspan='".($num_columns-$offset)." bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>\n";
}

?>
