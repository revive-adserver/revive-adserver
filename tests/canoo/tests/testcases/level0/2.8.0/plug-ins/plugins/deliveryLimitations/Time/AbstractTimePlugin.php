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
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
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
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
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
        $this->Plugins_DeliveryLimitations_ArrayData();
        $this->setAValues(range($min, $max));
    }
}