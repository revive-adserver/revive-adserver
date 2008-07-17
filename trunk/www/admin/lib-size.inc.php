<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
require_once MAX_PATH . '/lib/max/resources/res-iab.inc.php';

/*-------------------------------------------------------*/
/* Get the description for a specific size               */
/*-------------------------------------------------------*/

function phpAds_getBannerSize ($width, $height)
{
	global $phpAds_IAB, $strCustom;

	$result = $strCustom." ($width x $height)";

	foreach (array_keys($phpAds_IAB) as $key)
	{
		if ($phpAds_IAB[$key]['width'] == $width &&
			$phpAds_IAB[$key]['height'] == $height)
		{
			$result = $GLOBALS['strIab'][$key];
		}
	}

	return ($result);
}



/*-------------------------------------------------------*/
/* Find out if the selected size exists                  */
/*-------------------------------------------------------*/

function phpAds_sizeExists ($width, $height)
{
	global $phpAds_IAB;

	$result = false;

	foreach (array_keys($phpAds_IAB) as $key)
	{
		if ($phpAds_IAB[$key]['width'] == $width &&
			$phpAds_IAB[$key]['height'] == $height)
		{
			$result = true;
		}
	}

	return ($result);
}

?>