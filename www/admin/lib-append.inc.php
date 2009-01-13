<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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