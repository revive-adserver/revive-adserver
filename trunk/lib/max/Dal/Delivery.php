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

$file = '/lib/max/Dal/Delivery.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

function MAX_Dal_Delivery_Include()
{
    static $included;
    if (isset($included)) {
        return;
    }
    $included = true;
    $conf = $GLOBALS['_MAX']['CONF'];
    if (isset($conf['origin']['type']) && is_readable(MAX_PATH . '/lib/OA/Dal/Delivery/' . strtolower($conf['origin']['type']) . '.php')) {
        require(MAX_PATH . '/lib/OA/Dal/Delivery/' . strtolower($conf['origin']['type']) . '.php');
    } else {
        require(MAX_PATH . '/lib/OA/Dal/Delivery/' . strtolower($conf['database']['type']) . '.php');
    }
}

?>