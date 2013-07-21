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

require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitationsArrayData.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * A base class for delivery limitations plugins which uses a resource array
 * to limit the delivery.
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrzej Swedrzynski <andrzej@m3.net>
 */
class Plugins_DeliveryLimitations_ResourceData extends Plugins_DeliveryLimitations_ArrayData
{
    function init($data)
    {
        parent::init($data);
        $this->setAValues(array_keys($this->res));
    }
}
?>