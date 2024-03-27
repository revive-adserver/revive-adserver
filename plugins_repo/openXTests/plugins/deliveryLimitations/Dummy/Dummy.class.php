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

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Dummy_Dummy extends Plugins_DeliveryLimitations
{
    /**
     * Return name of plugin
     *
     * @return string
     */
    public function getName()
    {
        return 'Dummy';
    }

    public function isAllowed($param = false)
    {
        return $param != 'disallow';
    }
}
