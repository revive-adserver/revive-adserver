<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Required files
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Define appendtypes
define ("phpAds_AppendRaw", 0);
define ("phpAds_AppendZone", 1);
define ("phpAds_AppendBanner", 2);

/*-------------------------------------------------------*/
/* Fetch parameters from append code                     */
/*-------------------------------------------------------*/

function phpAds_ParseAppendCode ($append)
{
	$conf = $GLOBALS['_MAX']['CONF'];

	$ret = array(
		array('zoneid' => '', 'delivery' => phpAds_ZonePopup),
		array()
	);

	if (ereg("ad(popup|layer)\.php\?([^'\"]+)['\"]", $append, $match))
	{
		if (!empty($match[2]))
		{
			$ret[0]['delivery'] = ($match[1] == 'popup') ? phpAds_ZonePopup : phpAds_ZoneInterstitial;

			$append = str_replace('&amp;', '&', $match[2]);

			if (ereg('[\?\&]?what=zone:([0-9]+)(&|$)', $append, $match))
			{
				$ret[0]['zoneid'] = $match[1];

				$append = explode('&', $append);
				while (list(, $v) = each($append))
				{
					$v = explode('=', $v);
					if (count($v) == 2)
						$ret[1][urldecode($v[0])] = urldecode($v[1]);
				}
			}
		}
	}

	return $ret;
}

?>