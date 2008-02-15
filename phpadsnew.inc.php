<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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

	function view($what, $clientid = 0, $target = '', $source = '', $withtext = 0, $context = 0, $richmedia = true)
    {
        $output = view_raw($what, $clientid, "$target", "$source", $withtext, $context, $richmedia);

        if (is_array($output))
        {
        	echo $output['html'];
        	return $output['bannerid'];
        }

        return false;
    }

	// Prevent duplicate includes
	define ('PHPADSNEW_INCLUDED', true);
}

?>
