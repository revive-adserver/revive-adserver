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

/**
 *  OpenX Market plugin - delivery functions
 *
 * @package    OpenXPlugin
 * @subpackage openXMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */

/**
 * delivery postAdRender hook for OpenX Market
 *
 * @param string $code
 * @param array $aBanner
 */
function Plugin_deliveryAdRender_oxMarket_oxMarket_Delivery_postAdRender(&$code, $aBanner)
{
    // This is only mockup.
    // There should be:
    //  - check if plugin is enabled and status of publisher account association is valid
    //  - call to marketplace
    //  - run dependent market plugin(s)?
    /* 
    if ($html = MAX_oxMarketProcess($GLOBALS['_OA']['invocationType'], $code, $aBanner)) {
        $code = $html;
    }
    */
}

?>