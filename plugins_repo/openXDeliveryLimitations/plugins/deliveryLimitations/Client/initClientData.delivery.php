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

/**
 * @package    Plugin
 * @subpackage openxDeliveryLimitation
 */

MAX_Dal_Delivery_Include();

// Plugin_deliveryLog_oxLogClick_logClick_Delivery_logClick
function Plugin_deliveryLimitations_Client_initClientData_Delivery_postInit()
{
    if (!empty($GLOBALS['_MAX']['CONF']['Client']['sniff']) && isset($_SERVER['HTTP_USER_AGENT'])) { 
        if (!class_exists('phpSniff')) { 
            include dirname(__FILE__) . '/lib/phpSniff/phpSniff.class.php'; 
        } 
        $client = new phpSniff($_SERVER['HTTP_USER_AGENT']); 
        $GLOBALS['_MAX']['CLIENT'] = $client->_browser_info; 
    } 
}

?>
