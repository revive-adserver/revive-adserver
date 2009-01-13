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
