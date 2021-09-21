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

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitationsArrayData.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * An abstract subclass of Plugins_DeliveryLimitations which implements
 * _flattenData() and _explodeData() methods for comma-separated data
 * (for example: '0, 1, 2, 3, 5' or 'IE,FF'').
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_CommaSeparatedData extends Plugins_DeliveryLimitations_ArrayData
{
}
