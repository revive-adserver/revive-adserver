<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitations.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */

/**
 * A Time delivery limitation plugin base class.
 *
 * Works with:
 * A comma separated list of numbers, in the range specified in the constructor.
 *
 * Valid comparison operators:
 * ==, !=
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_AbstractTimePlugin extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    /**
     * Initializes the object with range $min - $max.
     *
     * @param int $min
     * @param int $max
     * @return Plugins_DeliveryLimitations_Time_Base
     */
    function Plugins_DeliveryLimitations_Time_Base($min, $max)
    {
        parent::__construct();
        $this->setAValues(range($min, $max));
    }

    /**
     * A method that returnes the currently stored timezone for the limitation
     *
     * @return string
     */
    function getStoredTz()
    {
        $offset = strpos($this->data, '@');
        if ($offset !== false) {
            return substr($this->data, $offset + 1);
        }
        return 'UTC';
    }

    /**
     * A private method that returnes the current timezone as set in the user preferences
     *
     * @return string
     */
    function _getCurrentTz()
    {
        if (isset($GLOBALS['_MAX']['PREF']['timezone'])) {
            $tz = $GLOBALS['_MAX']['PREF']['timezone'];
        } else {
            $tz = 'UTC';
        }

        return $tz;
    }

    function _flattenData($data = null)
    {
        return parent::_flattenData($data).'@'.$this->_getCurrentTz();
    }

    function _expandData($data = null)
    {
        if (!empty($data) && is_string($data)) {
            $offset = strpos($data, '@');
            if ($offset !== false) {
                $data = substr($data, 0, $offset);
            }
        }
        return parent::_expandData($data);
    }
}