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
 * basis of the viewer's IP address.
 *
 * Works with:
 * A string that describes a valid IP address, or a range or IP addresses, eg:
 *   10.0.0.*
 *
 * Valid comparison operators:
 * ==, !=
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_Client_Ip extends Plugins_DeliveryLimitations
{
    var $aPatternOps;
    var $aStandardOps;

    function Plugins_DeliveryLimitations_Client_Ip()
    {
        $this->aOperations = array(
            '==' => $GLOBALS['strEqualTo'],
            '!=' => $GLOBALS['strDifferentFrom']);
        $this->aPatternOps = array('==' => 'LIKE', '!=' => 'NOT LIKE');
        $this->aStandardOps = array('==' => '=', '!=' => '!=');
    }

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('IP address', $this->module, $this->package);
    }

    /**
     * A private method to return this delivery limitation plugin as a SQL limiation.
     *
     * @access private
     * @param string $comparison As for Plugins_DeliveryLimitations::_getSqlLimitation(),
     *                           but only '=' and '!=' permitted.
     * @param string $data The full IP address of the client to match.
     * @return mixed As for Plugins_DeliveryLimitations::_getSqlLimitation().
     *
     * @TODO Not yet implemented, due to complexity of IP address plugin...
     */
    function _getSqlLimitation($comparison, $data)
    {
        if (substr($data, strlen($data) - 1) == '*') {
            $data = str_replace('*', '%', $data);
            $op = $this->aPatternOps[$comparison];
        } else {
            $op = $this->aStandardOps[$comparison];
        }
        return "ip_address $op '$data'";
    }

    function overlap($aLimitation1, $aLimitation2)
    {
        $op1 = $aLimitation1['comparison'];
        $sData1 = $aLimitation1['data'];
        $op2 = $aLimitation2['comparison'];
        $sData2 = $aLimitation2['data'];

        if (strpos($sData1, '*') !== false || strpos($sData2, '*') !== false) {
            $sData1 = MAX_ipWithLastComponentReplacedByStar($sData1);
            $sData2 = MAX_ipWithLastComponentReplacedByStar($sData2);
        }

        if ($op1 == '==' && $op2 == '==') {
            return $sData1 == $sData2;
        } elseif ($op1 == '!=' && $op2 == '!=') {
            return true;
        } else {
            return $sData1 != $sData2;
        }
    }

    /**
     * A method to upgrade the Client:Ip delivery limitation plugin from v0.3.29-alpha
     * to v0.3.31-alpha format.
     *
     * @param string $op The comparison string for the limitation in v0.3.29-alpha format.
     * @param string $sData The comparison data for the limitation in v0.3.29-alpha format.
     * @return array An array of two items, indexed by "op" and "data", which are the new
     *               v0.3.31-alpha format versions of the parameters above.
     */
    function getDeliveryLimitationPluginUpgradeThreeThirtyOneAlpha($op, $sData)
    {
        return array('op' => $op, 'data' => $sData);
    }

    /**
     * A method to downgrade the Client:Ip delivery limitation plugin from v0.3.29-alpha
     * to v0.3.31-alpha format.
     *
     * @param string $op The comparison string for the limitation in v0.3.31-alpha format.
     * @param string $sData The comparison data for the limitation in v0.3.31-alpha format.
     * @return array An array of two items, indexed by "op" and "data", which are the old
     *               v0.3.29-alpha format versions of the parameters above.
     */
    function getDeliveryLimitationPluginDowngradeThreeTwentyNineAlpha($op, $sData)
    {
        return array('op' => $op, 'data' => $sData);
    }

}

?>
