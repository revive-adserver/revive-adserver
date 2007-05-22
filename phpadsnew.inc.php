<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

// Globalize context
// (just in case phpadsnew.inc.php is called from a function)
global $phpAds_context;

if (!defined('PHPADSNEW_INCLUDED'))
{
	// Figure out our location
	if (strlen(__FILE__) > strlen(basename(__FILE__)))
	    define ('MAX_PATH', substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__)) - 1));
	else
	    define ('MAX_PATH', '.');

	// Require the initialisation file
	require MAX_PATH . '/init-delivery.php';

	// Required files
	require MAX_PATH . '/lib/max/Delivery/adSelect.php';

	function view_raw($what, $clientid = 0, $target = '', $source = '', $withtext = 0, $context = 0, $richmedia = true)
	{
		$output = MAX_adSelect($what, $clientid, $target, $source, $withtext, $context, $richmedia, '', '', '');

		return $output;
	}

	// Prevent duplicate includes
	define ('PHPADSNEW_INCLUDED', true);
}

?>
