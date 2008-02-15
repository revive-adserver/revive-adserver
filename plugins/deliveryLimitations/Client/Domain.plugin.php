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

require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitations.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * A Client delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's domain URL.
 *
 * Works with a string which is matched with the viewer's domain URL.
 * The mechanism of the matching depends on the operator being used.
 *
 * Valid comparison operators:
 * ==, !=, =~, !~, =x, ~x
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_Client_Domain extends Plugins_DeliveryLimitations
{
    function Plugins_DeliveryLimitations_Client_Domain()
    {
        $this->Plugins_DeliveryLimitations();
        $this->nameEnglish = 'Domain';
    }


    /**
     * A private method to return this delivery limitation plugin as a SQL limiation.
     *
     * @access private
     * @param string $comparison As for Plugins_DeliveryLimitations::_getSqlLimitation(),
     *                           but only '=' and '!=' permitted.
     * @param string $data The full name of the client's domain name to match.
     * @return mixed As for Plugins_DeliveryLimitations::_getSqlLimitation().
     *
     * @TODO Needs to be changed to deal with databases other than MySQL.
     */
    function _getSqlLimitation($comparison, $data)
    {
        $rightLength = strlen($data);
        if (MAX_limitationsIsOperatorSimple($comparison)) {
            $columnName = "RIGHT(host_name, $rightLength)";
        }
        else {
            $columnName = 'host_name';
        }
        $sData = $this->_preCompile($data);
        return MAX_limitationsGetSqlForString($comparison, $sData, $columnName);
    }
}

?>
