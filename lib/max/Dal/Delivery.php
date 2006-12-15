<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: Delivery.php 5698 2006-10-12 16:16:22Z chris@m3.net $
*/

function MAX_Dal_Delivery_Include()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if (isset($conf['origin']['type']) && is_readable(MAX_PATH . '/lib/max/Dal/Delivery/' . strtolower($conf['origin']['type']) . '.php')) {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery/' . strtolower($conf['origin']['type']) . '.php');
    } else {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery/' . strtolower($conf['database']['type']) . '.php');
    }
}

?>