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
$Id: lib-prefs.inc.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

function phpAds_getPref($page_name, $var)
{
	global $session;
	
	$value = '';
	
	if (isset($session['prefs'][$page_name][$var]))
		$value = $session['prefs'][$page_name][$var];
	
	return $value;
}

function phpAds_getPrefArray($page_name, $var)
{
	global $session;
	
	$value = array();
	
	if (isset($session['prefs'][$page_name][$var]))
		$value = explode (",", $session['prefs'][$page_name][$var]);

	return $value;
}

function phpAds_updateExpandArray($expand_arr, $expand, $collapse)
{
	if ( ($expand != null) && ($expand != 'none') && ($expand != 'all') && !in_array($expand, $expand_arr))
		$expand_arr[] = $expand;
		
	$index = array_search($collapse, $expand_arr);
	if (is_integer($index))
		unset($expand_arr[$index]);
		
	$index = array_search('', $expand_arr);
	if (is_integer($index))
		unset($expand_arr[$index]);

	return $expand_arr;
}

function phpAds_setPref($page_name, $var, $value)
{
	global $session;
	
	$session['prefs'][$page_name][$var] = $value;
}

?>
