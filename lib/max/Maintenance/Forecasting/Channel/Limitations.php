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
$Id: Limitations.php 4722 2006-04-21 17:08:16Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Forecasting.php';

/**
 * A class to store and manipulate channels (ie. collections of delivery limitations)
 * for the purpose of forecasting requests/impressions/clicks in a channel.
 *
 * Note: Always do the multiplication before the division in the code, to try to
 * avoid rounding errors.
 *
 * @package    MaxMaintenance
 * @subpackage Forecasting
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class MAX_Maintenance_Forecasting_Channel_Limitations
{

    /**
     * A local instance of the MAX_Dal_Maintenance_Forecasting class.
     *
     * @var MAX_Dal_Maintenance_Forecasting
     */
    var $oDalMaintenanceForecasting;

    /**
     * A variable to store the ID of the channel the class is currently storing.
     *
     * @var integer
     */
    var $channelId;

    /**
     * An array for storing the delivery limitations of the channel.
     *
     * @var array
     */
    var $aLimitations;

    /**
     * An array for storing the SQL form of the delivery limitations
     * of the channel.
     *
     * @var array
     */
    var $aSqlLimitations;

    /**
     * The constructor method.
     */
    function MAX_Maintenance_Forecasting_Channel_Limitations()
    {
        $this->oDalMaintenanceForecasting = &$this->_getDal();
    }

    /**
     * A private method to create/register/return the Maintenance
     * Forecasting Data Access Layer.
     *
     * @access private
     */
    function &_getDal()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = $oServiceLocator->get('MAX_Dal_Maintenance_Forecasting');
        if (!$oDal) {
            $oDal = new MAX_Dal_Maintenance_Forecasting();
            $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oDal);
            }
        return $oDal;
    }

    /**
     * A method to prepare the class with the appropriate channel, and to build the
     * channel's delivery limitations into the required SQL or PHP forms so that
     * forecasting can be carried out.
     *
     * Note that SQL limitations can only be useful when ALL the delivery limitations
     * in the channel have SQL form, or when ALL the delivery limitations in an "OR"
     * grouped section of a channel have SQL form.
     *
     * @param integer $channelId The ID of the channel to prepare.
     * @return boolean True on success, false otherwise.
     */
    function buildLimitations($channelId)
    {
        $this->channelId = $channelId;
        $this->aLimitations = array();
        $this->aSqlLimitations = array();
        // Get the delivery limitations that make up the channel
        $this->aLimitations[0] = $this->oDalMaintenanceForecasting->getAllDeliveryLimitationsByTypeId($this->channelId, 'channel');
        if (PEAR::isError($this->aLimitations[0])) {
                return false;
            }
        if (is_null($this->aLimitations[0])) {
        	return false;
    	}
        // Split the limitations up into their "OR" grouped parts, if required
        $orExists = false;
        $aOrNumbers = array();
        foreach ($this->aLimitations[0] as $aDeliveryLimitation) {
            if (strtolower($aDeliveryLimitation['logical']) == 'or') {
                $orExists = true;
                $aOrNumbers[] = $aDeliveryLimitation['executionorder'];
            }
        }
        if ($orExists) {
            // Split the channel into its constituent "OR" groups
            $lastNumber = 0;
            $currentGroup = 0;
            foreach ($aOrNumbers as $number) {
                $splitPoint = $number - $lastNumber;
                $this->aLimitations[$currentGroup + 1] = array_slice($this->aLimitations[$currentGroup], $splitPoint);
                array_splice($this->aLimitations[$currentGroup], $splitPoint);
                $lastNumber = $number;
                $currentGroup++;
            }
        }
        // For each "OR" grouped set of limitations
        foreach ($this->aLimitations as $groupNumber => $aLimitationGroup) {
            // Prepare the SQL limitations for this grouping
            $result = $this->_buildSqlLimitations($groupNumber);
            if (!$result) {
                return false;
            }
        }
        return true;
    }

    /**
     * A method to include and return a plugin, based on a delivery limitation "type".
     *
     * @access private
     * @param string $type A colon separated delivery limitation plugin package and name.
     * @return object The delivery limitation plugin.
     */
    function &_getLimitationPlugin($type)
    {
        $typeExploded = explode(':', $type);
        $package = $typeExploded[0];
        $name = $typeExploded[1];
        return MAX_Plugin::factory('deliveryLimitations', $package, $name);
    }

    /**
     * A private method to create the SQL form of an "AND" grouped set of delivery limitations.
     *
     * @access private
     * @param integer $groupNumber The group number of the limitations, ie. the index number of
     *                             $this->aLimitations to convert.
     * @return boolean True on success, false otherwise.
     */
    function _buildSqlLimitations($groupNumber)
    {
        $this->aSqlLimitations[$groupNumber] = array();
        if (is_null($this->aLimitations[$groupNumber]) || !is_array($this->aLimitations[$groupNumber])) {
            return false;
        }
        foreach ($this->aLimitations[$groupNumber] as $aDeliveryLimitation) {
            $oLimitationPlugin = &$this->_getLimitationPlugin($aDeliveryLimitation['type']);
            if ($oLimitationPlugin === false) {
                // Plugin wasn't initialised
                return false;
    		}
            $oLimitationPlugin->init(array());
            $sqlLimitation = $oLimitationPlugin->getAsSql(
                $aDeliveryLimitation['comparison'],
                $aDeliveryLimitation['data']
            );
            // Did the plugin fail to return a valid SQL form?
            if (is_null($sqlLimitation)) {
                return false;
            }
            // Do not store the limitation if always true (eg. when data == '*'),
            // as there is no need to test the limitation when counting - it's
            // always true, silly!
            if ($sqlLimitation !== true) {
                $this->aSqlLimitations[$groupNumber][] = $sqlLimitation;
        	}
        }
        return true;
    }

}

?>
