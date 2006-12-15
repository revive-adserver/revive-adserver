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
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Register input variables
phpAds_registerGlobal (
	 'bannerids'
	,'campaignid'
	,'hours'
	,'viewmin'
);


// Security check
phpAds_checkAccess(phpAds_Admin);
?>

<html>
<body>

<?PHP

// Make sure that bannerids is set
if (!isset($bannerids) || !is_array($bannerids))
	$bannerids = array();

// Make sure minimum views is set
if (!isset($viewmin))
	$viewmin = 10;

echo "<form action='".$_SERVER['PHP_SELF']."'>\n";
if ($campaignid > 0)
{
	echo ("<input type='hidden' name='campaignid' value='".$campaignid."'>"."\n");
	
	$campaign_res = phpAds_dbQuery(
		"SELECT *".
		" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
		" WHERE campaignid = '".$campaignid."'"
	) or phpAds_sqlDie();
	
	if ($campaign_row = phpAds_dbFetchArray($campaign_res))
	{
		echo ("CAMPAIGN ".$campaign_row['campaignid']." - ".$campaign_row['campaignname']."\n");
		echo ("<BR>\n");
		echo ("Don't bother when there are less than <input type='text' width='3' name='viewmin' value='".$viewmin."'> views.");
		echo ("<BR><BR>\n");
		
		
		// Build Banners Selection...
		echo ("Banners\n");
		echo ("<BR>\n");
		
		$banner_res = phpAds_dbQuery(
			"SELECT".
			" ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid AS bannerid".
			",SUM(impressions) AS sum_views".
			",SUM(clicks) AS sum_clicks".
			//",SUM(conversions) AS sum_conversions".
			",IF(SUM(impressions) > 0, SUM(clicks)/SUM(impressions)*100, 0.00) AS sum_ctr".
			//",IF(SUM(clicks) > 0, SUM(conversions)/SUM(clicks)*100, 0.00) AS sum_cnvr".
			" FROM ".$conf['table']['prefix'].$con.$conf['table']['prefix'].$conf['table']['rs'].",".$conf['table']['data_summary_ad_hourly'].
			" WHERE campaignid = '".$campaignid."'".
			" AND ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid=".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id".
			" GROUP BY bannerid".
			" ORDER BY sum_ctr DESC"
		) or phpAds_sqlDie();
		
		echo ("<table border='1'>\n");
		echo ("<tr>\n");
		echo ("\t<td>select</td>\n");
		echo ("\t<td>id</td>\n");
		echo ("\t<td>name</td>\n");
		echo ("\t<td>views</td>\n");
		echo ("\t<td>clicks</td>\n");
		echo ("\t<td>conversions</td>\n");
		echo ("\t<td>ctr</td>\n");
		echo ("\t<td>cnvr</td>\n");
		echo ("</tr>\n");

		$total_views = 0;
		$total_clicks = 0;
		$total_conversions = 0;
		
		while ($banner_row = phpAds_dbFetchArray($banner_res))
		{
			if ($banner_row['sum_views'] >= $viewmin)
			{
				$checked = '';
				for ($i=0; $i<sizeof($bannerids); $i++)
				{
					if ($bannerids[$i] == $banner_row['bannerid'])
					{
						$checked = ' checked';
						$total_views += $banner_row['sum_views'];
						$total_clicks += $banner_row['sum_clicks'];
						$total_conversions += $banner_row['sum_conversions'];
						
						break;
					}
				}
				echo ("<tr>\n");
				echo ("\t<td><input type='checkbox' name='bannerids[]' value='".$banner_row['bannerid']."'".$checked."></td>\n");
				echo ("\t<td>".$banner_row['bannerid']."</td>\n");
				echo ("\t<td>&nbsp;</td>\n");
				echo ("\t<td>".$banner_row['sum_views']."</td>\n");
				echo ("\t<td>".$banner_row['sum_clicks']."</td>\n");
				echo ("\t<td>".$banner_row['sum_conversions']."</td>\n");
				echo ("\t<td>".$banner_row['sum_ctr']."</td>\n");
				echo ("\t<td>".$banner_row['sum_cnvr']."</td>\n");
				echo ("</tr>\n");
			}
		}
		// Print Totals...
		echo("<tr>");
		echo("\t<td colspan='8'>TOTAL</td>\n");
		echo ("</tr>\n");
		echo("<tr>");
		echo ("\t<td>&nbsp;</td>\n");
		echo ("\t<td>&nbsp;</td>\n");
		echo ("\t<td>&nbsp;</td>\n");
		echo ("\t<td>".$total_views."</td>\n");
		echo ("\t<td>".$total_clicks."</td>\n");
		echo ("\t<td>".$total_conversions."</td>\n");
		echo ("\t<td>".phpAds_buildCTR($total_views, $total_clicks)."</td>\n");
		echo ("\t<td>".phpAds_buildCTR($total_clicks, $total_conversions)."</td>\n");
		echo ("</tr>\n");

		echo("</table>\n");

	
		// Build Hours Selection...
		echo ("Time of Day\n");
		echo ("<BR>\n");
		
		$hour_res = phpAds_dbQuery(
			"SELECT".
			" hour".
			",SUM(impressions) AS sum_views".
			",SUM(clicks) AS sum_clicks".
			//",SUM(conversions) AS sum_conversions".
			",IF(SUM(impressions) > 0, SUM(clicks)/SUM(impressions)*100, 0.00) AS sum_ctr".
			//",IF(SUM(clicks) > 0, SUM(conversions)/SUM(clicks)*100, 0.00) AS sum_cnvr".
			" FROM ".$conf['table']['prefix'].$conf['table']['banners'].",".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].
			" WHERE campaignid = '".$campaignid."'".
			" AND ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid=".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id".
			" AND ".phpAds_buildBannerWhereClause($bannerids).
			" GROUP BY hour".
			" ORDER BY sum_ctr DESC"
		) or phpAds_sqlDie();
		
		echo ("<table border='1'>\n");
		echo ("<tr>\n");
		echo ("\t<td>select</td>\n");
		echo ("\t<td>id</td>\n");
		echo ("\t<td>name</td>\n");
		echo ("\t<td>views</td>\n");
		echo ("\t<td>clicks</td>\n");
		echo ("\t<td>conversions</td>\n");
		echo ("\t<td>ctr</td>\n");
		echo ("\t<td>cnvr</td>\n");
		echo ("</tr>\n");

		$total_views = 0;
		$total_clicks = 0;
		$total_conversions = 0;
		
		while ($hour_row = phpAds_dbFetchArray($hour_res))
		{
			if ($hour_row['sum_views'] >= $viewmin)
			{
				$checked = '';
				for ($i=0; $i<sizeof($hours); $i++)
				{
					if ($hours[$i] == $hour_row['hour'])
					{
						$checked = ' checked';
						$total_views += $hour_row['sum_views'];
						$total_clicks += $hour_row['sum_clicks'];
						$total_conversions += $hour_row['sum_conversions'];
						
						break;
					}
				}
				echo ("<tr>\n");
				echo ("\t<td><input type='checkbox' name='hours[]' value='".$hour_row['hour']."'".$checked."></td>\n");
				echo ("\t<td>".$hour_row['hour']."</td>\n");
				echo ("\t<td>&nbsp;</td>\n");
				echo ("\t<td>".$hour_row['sum_views']."</td>\n");
				echo ("\t<td>".$hour_row['sum_clicks']."</td>\n");
				echo ("\t<td>".$hour_row['sum_conversions']."</td>\n");
				echo ("\t<td>".$hour_row['sum_ctr']."</td>\n");
				echo ("\t<td>".$hour_row['sum_cnvr']."</td>\n");
				echo ("</tr>\n");
			}
		}
		// Print Totals...
		echo("<tr>");
		echo("\t<td colspan='8'>TOTAL</td>\n");
		echo ("</tr>\n");
		echo("<tr>");
		echo ("\t<td>&nbsp;</td>\n");
		echo ("\t<td>&nbsp;</td>\n");
		echo ("\t<td>&nbsp;</td>\n");
		echo ("\t<td>".$total_views."</td>\n");
		echo ("\t<td>".$total_clicks."</td>\n");
		echo ("\t<td>".$total_conversions."</td>\n");
		echo ("\t<td>".phpAds_buildCTR($total_views, $total_clicks)."</td>\n");
		echo ("\t<td>".phpAds_buildCTR($total_clicks, $total_conversions)."</td>\n");
		echo ("</tr>\n");

		echo("</table>\n");
	

	
		// Build Source Selection...
		echo ("Source\n");
		echo ("<BR>\n");
		
		echo ("<table border='1'>\n");
		echo ("<tr>\n");
		echo ("\t<td>select</td>\n");
		echo ("\t<td>id</td>\n");
		echo ("\t<td>name</td>\n");
		echo ("\t<td>views</td>\n");
		echo ("\t<td>clicks</td>\n");
		echo ("\t<td>conversions</td>\n");
		echo ("\t<td>ctr</td>\n");
		echo ("\t<td>cnvr</td>\n");
		echo ("</tr>\n");

		$total_views = 0;
		$total_clicks = 0;
		$total_conversions = 0;

		phpAds_getSources('', 1);

		// Print Totals...
		echo("<tr>");
		echo("\t<td colspan='8'>TOTAL</td>\n");
		echo ("</tr>\n");
		echo("<tr>");
		echo ("\t<td>&nbsp;</td>\n");
		echo ("\t<td>&nbsp;</td>\n");
		echo ("\t<td>&nbsp;</td>\n");
		echo ("\t<td>".$total_views."</td>\n");
		echo ("\t<td>".$total_clicks."</td>\n");
		echo ("\t<td>".$total_conversions."</td>\n");
		echo ("\t<td>".phpAds_buildCTR($total_views, $total_clicks)."</td>\n");
		echo ("\t<td>".phpAds_buildCTR($total_clicks, $total_conversions)."</td>\n");
		echo ("</tr>\n");

		echo("</table>\n");
	
	}
}
else
{
	echo ("No campaign ID selected.");
}

function phpAds_buildBannerWhereClause($bannerids)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	
	$str = ' (';
	if (!isset($bannerids) || !is_array($bannerids) || sizeof($bannerids) < 1)
	{
		$str .= "1=0";
	}
	else
	{
		for ($i=0; $i<sizeof($bannerids); $i++)
		{
			if ($i != 0)
				$str .= " OR ";
			
			$str .= $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id=".$bannerids[$i];
		}
	}
	$str .= ")";

	return $str;
}
function phpAds_buildHourWhereClause($hours)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	
	$str = ' (';
	if (!isset($hours) || !is_array($hours) || sizeof($hours) < 1)
	{
		$str .= "1=0";
	}
	else
	{
		for ($i=0; $i<sizeof($hours); $i++)
		{
			if ($i != 0)
				$str .= " OR ";
			
			$str .= "hour=".$hours[$i];
		}
	}
	$str .= ")";

	return $str;
}
function phpAds_getSources($parent, $level)
{
    $conf = $GLOBALS['_MAX']['CONF'];
	global
		 $bannerids
		,$campaignid
		,$hours
		,$sources
		,$total_views
		,$total_clicks
		,$total_conversions
		,$viewmin
	;
	
	$source_sql =
		"SELECT".
		" SUBSTRING_INDEX(source,'/',".$level.") AS source_part".
		",SUM(impressions) AS sum_views".
		",SUM(clicks) AS sum_clicks".
		//",SUM(conversions) AS sum_conversions".
		",IF(SUM(impressions) > 0, SUM(clicks)/SUM(impressions)*100, 0.00) AS sum_ctr".
		//",IF(SUM(clicks) > 0, SUM(conversions)/SUM(clicks)*100, 0.00) AS sum_cnvr".
		" FROM ".$conf['table']['prefix'].$conf['table']['banners'].",".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].
		" WHERE campaignid = '".$campaignid."'";
	
	if ($level > 1)
		$source_sql .= " AND SUBSTRING_INDEX(source,'/',".($level-1).")='".$parent."'";
	
	$source_sql .=
		" AND ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid=".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id".
		" AND ".phpAds_buildBannerWhereClause($bannerids).
		" AND ".phpAds_buildHourWhereClause($hours).
		" GROUP BY SUBSTRING_INDEX(source,'/',".$level.")".
		" ORDER BY sum_ctr DESC"
	;
	
	$source_res = phpAds_dbQuery($source_sql)
		or phpAds_sqlDie();
	
	while ($source_row = phpAds_dbFetchArray($source_res))
	{
		$same = $source_row['source_part'] == $parent;
		
		if ($source_row['sum_views'] >= $viewmin)
		{
			$checked = false;
			for ($i=0; $i<sizeof($sources); $i++)
			{
				$found = false;
				if ($sources[$i] == $source_row['source_part'])
					$found = true;
				elseif ( (strrchr($sources[$i], '*') > -1) && (strrchr($sources[$i], '*') == strlen($sources[$i]) ) )
					$found = true;

				if ($found)
				{
					$checked = true;
					$total_views += $source_row['sum_views'];
					$total_clicks += $source_row['sum_clicks'];
					$total_conversions += $source_row['sum_conversions'];
					
					break;
				}
			}
			echo ("<tr>\n");
			echo ("\t<td><input type='checkbox' name='sources[]' value='".$source_row['source_part'].($same ? '' : '*')."'".($checked ? ' checked' : '')."></td>\n");
			echo ("\t<td>");
			
			for ($i=0; $i<$level-1; $i++)
				echo("&nbsp;&nbsp;&nbsp;&nbsp;");
				
			echo ($source_row['source_part'].($same ? '' : '*')."</td>\n");
			echo ("\t<td>&nbsp;</td>\n");
			echo ("\t<td>".$source_row['sum_views']."</td>\n");
			echo ("\t<td>".$source_row['sum_clicks']."</td>\n");
			echo ("\t<td>".$source_row['sum_conversions']."</td>\n");
			echo ("\t<td>".$source_row['sum_ctr']."</td>\n");
			echo ("\t<td>".$source_row['sum_cnvr']."</td>\n");
			echo ("</tr>\n");
			
			if ($checked && !$same)
				phpAds_getSources($source_row['source_part'], $level+1);
		}
	}
}
?>
<input type='submit' value='Update Fields'>
</form>
</body>
</html>

