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

$file = '/lib/OA/Delivery/marketplace.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

/**
 * @package    MaxDelivery
 * @subpackage marketplace
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 * This library defines functions that need to be available to
 * marketplace-enabled delivery engine scripts
 *
 */

function MAX_marketplaceEnabled()
{
    return !empty($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['bidService']);
}

/**
 * A function to check if a ping to the ID service is needed
 *
 * @todo Use a cookie
 * @return boolean
 */
function MAX_marketplaceNeedsIndium()
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    return MAX_marketplaceEnabled() && empty($_COOKIE['In']);
}

?>
