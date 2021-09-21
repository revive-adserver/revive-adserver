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
 * A Geo delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's postal code (US/Canada only).
 *
 * Valid comparison operators:
 * ==, !=,=~,!~,=x,!x
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Geo_Postalcode extends Plugins_DeliveryLimitations
{
    use \RV\Extension\DeliveryLimitations\GeoLimitationTrait;

    public function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Geo - US/Canada Postal Code';
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    public function isAllowed($page = false)
    {
        return $this->hasCapability('postal_code');
    }
}
