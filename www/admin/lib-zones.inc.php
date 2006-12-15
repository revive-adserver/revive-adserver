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

// Set define to prevent duplicate include
define ('LIBZONES_INCLUDED', true);

// Define zonetypes
define ("phpAds_ZoneBanners", 0);
define ("phpAds_ZoneInteractive", 1);
define ("phpAds_ZoneRaw", 2);
define ("phpAds_ZoneCampaign", 3);

// delivery
define ("phpAds_ZoneBanner", 0);
define ("phpAds_ZoneInterstitial", 1);
define ("phpAds_ZonePopup", 2);
define ("phpAds_ZoneText", 3);
define ("MAX_ZoneEmail", 4);
define ("MAX_ZoneClick", 5);

// Define appendtypes
define ("phpAds_ZoneAppendRaw", 0);
define ("phpAds_ZoneAppendZone", 1);

/*-------------------------------------------------------*/
/* Determine if a banner included in a zone              */
/*-------------------------------------------------------*/

function phpAds_IsBannerInZone($bannerid, $zoneid, $what = '')
{
	$conf = $GLOBALS['_MAX']['CONF'];
	if ($what == '') {
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$conf['table']['prefix'].$conf['table']['zones']."
			WHERE
				zoneid = '$zoneid'
		") or phpAds_sqlDie();

		if ($zone = phpAds_dbFetchArray($res))
			$what = $zone['what'];
	}
	$what_array = explode(",", $what);
	for ($k=0; $k < count($what_array); $k++) {
		if (substr($what_array[$k],0,9) == "bannerid:" &&
		    substr($what_array[$k],9) == $bannerid) {
			return (true);
		}
	}
	return false;
}

/*-------------------------------------------------------*/
/* Determine if a campaign included in a zone            */
/*-------------------------------------------------------*/

function phpAds_IsCampaignInZone($campaignid, $zoneid, $what = '')
{
	$conf = $GLOBALS['_MAX']['CONF'];
	if ($what == '')
	{
		$res = phpAds_dbQuery(
			"SELECT what".
			" FROM ".$conf['table']['prefix'].$conf['table']['zones'].
			" WHERE zoneid='".$zoneid."'"
		) or phpAds_sqlDie();

		if ($zone = phpAds_dbFetchArray($res))
			$what = $zone['what'];
	}


	$what_array = explode(",", $what);

	for ($k=0; $k < count($what_array); $k++)
	{
		if (substr($what_array[$k],0,11) == "campaignid:" &&
		    substr($what_array[$k],11) == $campaignid)
		{
			return (true);
		}
	}

	return (false);
}

/*-------------------------------------------------------*/
/* Add a banner to a zone                                */
/*-------------------------------------------------------*/

function phpAds_ToggleBannerInZone($bannerid, $zoneid)
{
	$conf = $GLOBALS['_MAX']['CONF'];


	if (isset($zoneid) && $zoneid != '')
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$conf['table']['prefix'].$conf['table']['zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();

		if (phpAds_dbNumRows($res))
		{
			$zone = phpAds_dbFetchArray($res);

			if ($zone['what'] != '')
				$what_array = explode(",", $zone['what']);
			else
				$what_array = array();

			$available = false;
			$changed = false;

			for ($k=0; $k < count($what_array); $k++)
			{
				if (substr($what_array[$k],0,9) == "bannerid:" &&
				    substr($what_array[$k],9) == $bannerid)
				{
					// Remove from array
					unset ($what_array[$k]);
					$available = true;
					$changed = true;
				}
			}

			if ($available == false)
			{
				// Add to array
				$what_array[] = 'bannerid:'.$bannerid;
				$changed = true;
			}

			if ($changed == true)
			{
				// Convert back to a string
				$zone['what'] = implode (",", $what_array);

				// Store string back into database
				$res = phpAds_dbQuery("
					UPDATE
						".$conf['table']['prefix'].$conf['table']['zones']."
					SET
						what = '".$zone['what']."',
						updated = '".date('Y-m-d H:i:s')."'
					WHERE
						zoneid = '$zoneid'
					") or phpAds_sqlDie();

				// Rebuild Cache
				// require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
				// phpAds_cacheDelete('what=zone:'.$zoneid);
			}
		}
	}

	return (false);
}

/*-------------------------------------------------------*/
/* Add a campaign to a zone                              */
/*-------------------------------------------------------*/

function phpAds_ToggleCampaignInZone($campaignid, $zoneid)
{
	$conf = $GLOBALS['_MAX']['CONF'];

	if (isset($zoneid) && $zoneid != '')
	{
		$res = phpAds_dbQuery(
			"SELECT what".
			" FROM ".$conf['table']['prefix'].$conf['table']['zones'].
			" WHERE zoneid='".$zoneid."'"
		) or phpAds_sqlDie();

		if (phpAds_dbNumRows($res))
		{
			$zone = phpAds_dbFetchArray($res);

			if ($zone['what'] != '')
				$what_array = explode(",", $zone['what']);
			else
				$what_array = array();

			$available = false;
			$changed = false;

			for ($k=0; $k < count($what_array); $k++)
			{
				if (substr($what_array[$k],0,11) == "campaignid:" &&
				    substr($what_array[$k],11) == $campaignid)
				{
					// Remove from array
					unset ($what_array[$k]);
					$available = true;
					$changed = true;
				}
			}

			if ($available == false)
			{
				// Add to array
				$what_array[] = "campaignid:".$campaignid;
				$changed = true;
			}

			if ($changed == true)
			{
				// Convert back to a string
				$zone['what'] = implode (",", $what_array);

				// Store string back into database
				$res = phpAds_dbQuery(
					"UPDATE ".$conf['table']['prefix'].$conf['table']['zones'].
					" SET what = '".$zone['what']."'".
					", updated = '".date('Y-m-d H:i:s')."'".
					" WHERE zoneid='".$zoneid."'"
				) or phpAds_sqlDie();

				// Rebuild cache
				// require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
				// phpAds_cacheDelete('what=zone:'.$zoneid);

			}
		}
	}
	return false;
}

/*-------------------------------------------------------*/
/* Fetch parameters from append code                     */
/*-------------------------------------------------------*/

function phpAds_ZoneParseAppendCode($append)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	$ret = array(
		array('zoneid' => '', 'delivery' => phpAds_ZonePopup),
		array()
	);
	if (ereg("ad(popup|layer)\.php\?([^'\"]+)['\"]", $append, $match)) {
		if (!empty($match[2])) {
			$ret[0]['delivery'] = ($match[1] == 'popup') ? phpAds_ZonePopup : phpAds_ZoneInterstitial;
			$append = str_replace('&amp;', '&', $match[2]);
			if (ereg('[?&]what=zone:([0-9]+)(&|$)', $append, $match)) {
				$ret[0]['zoneid'] = $match[1];
				$append = explode('&', $append);
				while (list(, $v) = each($append)) {
					$v = explode('=', $v);
					if (count($v) == 2) {
						$ret[1][urldecode($v[0])] = urldecode($v[1]);
					}
				}
			}
		}
	}
	return $ret;
}

?>
