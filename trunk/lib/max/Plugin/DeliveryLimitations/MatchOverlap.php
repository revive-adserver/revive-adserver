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

require_once MAX_PATH . '/lib/max/Dal/Entities.php';

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

/**
 * A class for determining if a set of delivery limitations matches, or
 * overlaps with, a delivery limitation channel.
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Plugin_DeliveryLimitations_MatchOverlap
{

    /**
     * A variable for storing the data access layer.
     *
     * @var MAX_Dal_Entities
     */
    var $oMaxDalEntities;

    /**
     * A variable for storing the delivery limitations array set.
     *
     * @var array
     */
    var $aLimitations;

    /**
     * A variable for storing the channel ID.
     *
     * @var integer
     */
    var $channelId;

    /**
     * A variable for storing the channel delivery limitations array set.
     *
     * @var array
     */
    var $aChannelLimitations;

    /**
     * The class constructor method.
     *
     * @return MAX_Plugin_DeliveryLimitations_MatchOverlap
     */
    function MAX_Plugin_DeliveryLimitations_MatchOverlap()
    {
        $this->oMaxDalEntities = &$this->_getDal();
        $this->aLimitations = array();
        $this->aChannelLimitations = array();
    }

    /**
     * A private method for getting the data access layer.
     *
     * @access private
     * @return MAX_Dal_Entities
     */
    function &_getDal()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('MAX_Dal_Entities');
        if (!$oDal) {
            $oDal = new MAX_Dal_Entities();
            $oServiceLocator->register('MAX_Dal_Entities', $oDal);
        }
        return $oDal;
    }

    /**
     * A method to set the delivery limitations (to later test against a channel)
     * by specifying an ad ID.
     *
     * @param integer $adId The ad ID to obtain the delivery limitations of,
     *                      and to set in the class.
     * @return boolean True if the limitations were valid and set, false otherwise.
     */
    function setLimitationsByAdId($adId)
    {
        // Test the input values
        if (!is_numeric($adId)) {
            return false;
        }
        // Get the ad details from the database, and set them in the object
        return $this->setLimitationsByAdArray(
            $this->oMaxDalEntities->getDeliveryLimitationsByAdId($adId)
        );
    }

    /**
     * A method to set the delivery limitations (to later test against a channel)
     * by specifying an array of delivery limitations.
     *
     * @param array $aLimitations An array of delivery limitations to set in the
     *                            class. May be in one of two formats. For example:
     *                              array(
     *                                  0 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Hour',
     *                                      'comparison'     => '==',
     *                                      'data'           => 12,
     *                                      'executionorder' => 1
     *                                  ),
     *                                  1 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Date',
     *                                      'comparison'     => '!=',
     *                                      'data'           => '2006-10-12',
     *                                      'executionorder' => 0
     *                                  )
     *                               )
     *                            i.e. Where the limitation order in the array is NOT
     *                            related to the execution order of the limitations,
     *                            or:
     *                              array(
     *                                  0 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Date',
     *                                      'comparison'     => '!=',
     *                                      'data'           => '2006-10-12',
     *                                  ),
     *                                  1 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Hour',
     *                                      'comparison'     => '==',
     *                                      'data'           => 12,
     *                                  )
     *                              )
     *                            i.e. Where the limitation order in the array IS
     *                            the execution order.
     * @return boolean True if the limitations were valid and set, false otherwise.
     */
    function setLimitationsByAdArray($aLimitations)
    {
        return $this->_setLimitationsByArray('ad', $aLimitations);
    }

    /**
     * A method to set the channel delivery limitations (to later test against a set
     * of delivery limitations) by specifying a channel ID.
     *
     * @param integer $channelId The channel ID to obtain the delivery limitations of,
     *                           and to set in the class.
     * @return boolean True if the limitations were valid and set, false otherwise.
     */
    function setLimitationsByChannelId($channelId)
    {
        // Test the input values
        if (!is_numeric($channelId)) {
            return false;
        }
        // Get the ad details from the database, and set them in the object
        return $this->setLimitationsByChannelArray(
            $channelId,
            $this->oMaxDalEntities->getDeliveryLimitationsByChannelId($channelId)
        );
    }

    /**
     * A method to set the channel delivery limitations (to later test against a set
     * of delivery limitations) by specifying an array of delivery limitations.
     *
     * @param integer $channelId The channel ID, of which the limitations are being
     *                           passed in in $aLimitations.
     * @param array $aLimitations An array of delivery limitations to set in the
     *                            class. May be in one of two formats. For example:
     *                              array(
     *                                  0 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Hour',
     *                                      'comparison'     => '==',
     *                                      'data'           => 12,
     *                                      'executionorder' => 1
     *                                  ),
     *                                  1 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Date',
     *                                      'comparison'     => '!=',
     *                                      'data'           => '2006-10-12',
     *                                      'executionorder' => 0
     *                                  )
     *                               )
     *                            i.e. Where the limitation order in the array is NOT
     *                            related to the execution order of the limitations,
     *                            or:
     *                              array(
     *                                  0 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Date',
     *                                      'comparison'     => '!=',
     *                                      'data'           => '2006-10-12',
     *                                  ),
     *                                  1 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Hour',
     *                                      'comparison'     => '==',
     *                                      'data'           => 12,
     *                                  )
     *                              )
     *                            i.e. Where the limitation order in the array IS
     *                            the execution order.
     * @return boolean True if the limitations were valid and set, false otherwise.
     */
    function setLimitationsByChannelArray($channelId, $aLimitations)
    {
        $result = $this->_setLimitationsByArray('channel', $aLimitations);
        if ($result) {
            $this->channelId = $channelId;
        }
        return $result;
    }

    /**
     * A private method to set the limitations by array, for ether the delivery
     * limitation set, or the channel delivery limitation set.
     *
     * @param string $type Either "ad", or "channel".
     * @param array $aLimitations An array of delivery limitations to set in the
     *                            class. May be in one of two formats. For example:
     *                              array(
     *                                  0 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Hour',
     *                                      'comparison'     => '==',
     *                                      'data'           => 12,
     *                                      'executionorder' => 1
     *                                  ),
     *                                  1 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Date',
     *                                      'comparison'     => '!=',
     *                                      'data'           => '2006-10-12',
     *                                      'executionorder' => 0
     *                                  )
     *                               )
     *                            i.e. Where the limitation order in the array is NOT
     *                            related to the execution order of the limitations,
     *                            or:
     *                              array(
     *                                  0 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Date',
     *                                      'comparison'     => '!=',
     *                                      'data'           => '2006-10-12',
     *                                  ),
     *                                  1 => array(
     *                                      'logical'        => 'and',
     *                                      'type'           => 'Time:Hour',
     *                                      'comparison'     => '==',
     *                                      'data'           => 12,
     *                                  )
     *                              )
     *                            i.e. Where the limitation order in the array IS
     *                            the execution order.
     */
    function _setLimitationsByArray($type, $aLimitations)
    {
        // Test the input values
        if (!($type == 'ad' || $type == 'channel')) {
            return false;
        }
        $aValues = array('logical', 'type', 'comparison', 'data');
        if (!is_array($aLimitations) || empty($aLimitations)) {
            return false;
        }
        $requireExecutionOrder = false;
        reset($aLimitations);
        while (list($key, $aLimitation) = each($aLimitations)) {
            if (!is_array($aLimitation) || empty($aLimitation)) {
                return false;
            }
            if (!is_null($aLimitation['executionorder'])) {
                $requireExecutionOrder = true;
            }
        }
        reset($aLimitations);
        while (list($key, $aLimitation) = each($aLimitations)) {
            foreach ($aValues as $value) {
                if (is_null($aLimitation[$value])) {
                    return false;
                }
            }
            if ($requireExecutionOrder) {
                if (is_null($aLimitation['executionorder'])) {
                    return false;
                }
            } else {
                if (!is_numeric($key)) {
                    return false;
                }
            }
        }
        // Input is valid, store, as required
        $aSetLimitations = array();
        if (!$requireExecutionOrder) {
            $aSetLimitations[0] = $aLimitations;
        } else {
            reset($aLimitations);
            while (list($key, $aLimitation) = each($aLimitations)) {
                foreach ($aValues as $value) {
                    $aSetLimitations[0][$aLimitation['executionorder']][$value] = $aLimitation[$value];
                }
            }
        }
        // Do the limitations have any "OR" grouped parts?
        $aOrNumbers = array();
        reset($aSetLimitations);
        while (list($executionOrder, $aLimitation) = each($aSetLimitations[0])) {
            if (strtolower($aLimitation['logical']) == 'or') {
                $aOrNumbers[] = $executionOrder;
            }
        }
        if (count($aOrNumbers) > 0) {
            // Split the limitations up into constituent "OR" groups
            $lastNumber = 0;
            $currentGroup = 0;
            foreach ($aOrNumbers as $number) {
                $splitPoint = $number - $lastNumber;
                $aSetLimitations[$currentGroup + 1] = array_slice($aSetLimitations[$currentGroup], $splitPoint);
                array_splice($aSetLimitations[$currentGroup], $splitPoint);
                $lastNumber = $number;
                $currentGroup++;
            }
        }
        if ($type == 'ad') {
            $this->aLimitations = $aSetLimitations;
        } else {
            $this->aChannelLimitations = $aSetLimitations;
        }
        return true;
    }

    /**
     * A method to determine if the set delivery limitations match the set
     * channel delivery limitations.
     *
     * @return boolean True if the delivery limitations set matches the channel,
     *                 false otherwise.
     */
    function match()
    {
        // Is the delivery limitation set a SINGLE limitation of type
        // Site:Channel, with a matching channel ID?
        if ((count($this->aLimitations) == 1) && (count($this->aLimitations[0]) == 1)) {
            if (is_array($this->aLimitations[0][0])) {
                if (($this->aLimitations[0][0]['type'] == 'Site:Channel') &&
                    ($this->aLimitations[0][0]['comparison'] == '=~') &&
                    ($this->aLimitations[0][0]['data'] == $this->channelId)) {
                        return true;
                }
            }
        }
        // The delivery limitation may not be a channel type, but do
        // the limitations match exactly?
        if ($this->aLimitations == $this->aChannelLimitations) {
            return true;
        }
        return false;
    }

    /**
     * A method to determine if the set delivery limitations overlap with the
     * set channel delivery limitations.
     *
     * @return boolean True if the delivery limitations set overlaps with the
     *                 channel, false otherwise.
     */
    function overlap()
    {
        // In order for the limitations to NOT overlap, then it must be the
        // case that ALL combinations of OR limitations between the groups
        // must not overlap -- prepare an array of the different combinations
        // of OR groups that exist between the two limitations
        $aResults = array();
        for ($lCounter = 0; $lCounter < count($this->aLimitations); $lCounter++) {
            for ($cCounter = 0; $cCounter < count($this->aChannelLimitations); $cCounter++) {
                $aResults[$lCounter][$cCounter] = true;
            }
        }
        // If no combination pairs, one of the two is not set, so no overlap
        if (empty($aResults)) {
            return false;
        }
        // Compare ALL of the possible combinations of OR groups between the
        // to limitations, to see which (if any) of these combinations do NOT
        // overlap -- and as there will be overlap if just ONE of the sets
        // overlap, then it is safe to stop testing at that point
        reset($this->aLimitations);
        while (list($lKey, $aLimitations) = each($this->aLimitations)) {
            reset($this->aChannelLimitations);
            while (list($cKey, $aChannelLimitations) = each($this->aChannelLimitations)) {
                $result = $this->_overlapAndGroup($aLimitations, $aChannelLimitations);
                if ($result === false) {
                    $aResults[$lKey][$cKey] = false;
                } else {
                    break 2;
                }
            }
        }
        // Test the $aResults array to see if ALL combinations of OR limitations
        // between the groups do NOT overlap -- if any do overlap, then we know that
        // there IS overlap between the two limitations
        $result = false;
        for ($lCounter = 0; $lCounter < count($this->aLimitations); $lCounter++) {
            for ($cCounter = 0; $cCounter < count($this->aChannelLimitations); $cCounter++) {
                if ($aResults[$lCounter][$cCounter]) {
                    $result = true;
                    break 2;
                }
            }
        }
        return $result;
    }

    /**
     * A private method to test if an AND grouped set of delivery limitations
     * overlaps with an AND grouped set of channel delivery limitations, to
     * determine if there is any overlap.
     *
     * @access private
     * @param array $aLimitations An array of AND grouped delivery limitations.
     * @param array $aChannelLimitations An array of AND grouped channel delivery
     *                                   limitations.
     * @return boolean True if the AND grouped set of delivery limitations overlaps
     *                 with the AND grouped set of channel delivery limitations,
     *                 false otherwise.
     */
    function _overlapAndGroup($aLimitations, $aChannelLimitations)
    {
        // Do any of the limitations types match?
        $aMatchSets = array();
        reset($aLimitations);
        while (list($lKey, $aLimitation) = each($aLimitations)) {
            reset($aChannelLimitations);
            while (list($cKey, $aChannelLimitation) = each($aChannelLimitations)) {
                if ($aLimitation['type'] == $aChannelLimitation['type']) {
                    $aMatchSets[$lKey][$cKey] = true;
                }
            }
        }
        if (empty($aMatchSets)) {
            // None of the limitation types match at all, so can only assume that
            // there is some overlap between the delivery limitation sets
            return true;
        }
        // There is at least one delivery limitation type match between the two sets;
        // Test all the matches to see if there is NOT any overlap between them...
        reset($aMatchSets);
        while (list($lKey, $aData) = each($aMatchSets)) {
            reset($aData);
            while (list($cKey, $value) = each($aData)) {
                // Compare the two limitations
                $oDeliveryLimitationPlugin = &$this->_getPlugin($aLimitations[$lKey]['type']);
                $result = $oDeliveryLimitationPlugin->overlap($aLimitations[$lKey], $aChannelLimitations[$cKey]);
                if ($result) {
                    // At least one of the types overlaps, so the entire AND group
                    // of delivery limitations will overlap to some extent
                    return true;
                }
            }
        }
        // Wow, not a single one of all the matching types overlaps!
        return false;
    }

    /**
     * A private method to get an instance of the required delivery limitation type,
     * so that the plugin can be used to compare two delivery limitations of the
     * same type to see if they overlap.
     *
     * @access private
     * @param string $type The name of the delivery limitation plugin (eg. 'Time:Date').
     * @return Plugins_DeliveryLimitations A delivery limitation plugin that implements
     *                                     the "interface" defined in the
     *                                     Plugins_DeliveryLimitations class.
     */
    function &_getPlugin($type)
    {
        list($module, $package) = explode(':', $type);
        return MAX_Plugin::factory('deliveryLimitations', $module, $package);
    }

}

?>
