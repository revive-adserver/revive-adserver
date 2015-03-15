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
 * basis of the viewer's area code (US only).
 *
 * Works with:
 * A valid numeric area code.
 *
 * Valid comparison operators:
 * ==, !=, =~, !=, =x, !x
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Geo_Areacode extends Plugins_DeliveryLimitations
{

    function __construct()
    {
        parent::__construct();
        $this->columnName = 'geo_area_code';
        $this->nameEnglish = 'Geo - US Area code';
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed($page = false)
    {
        return ((isset($GLOBALS['_MAX']['GEO_DATA']['area_code']))
            || $GLOBALS['_MAX']['CONF']['geotargeting']['showUnavailable']);
    }

}

?>
