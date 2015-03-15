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

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * A Geo delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's country.
 *
 * Works with:
 * A comma separated list of valid country codes. See the Country.res.inc.php
 * resource file for details of the valid country codes.
 *
 * Valid comparison operators:
 * =~, !~
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 *
 * @TODO Does this need to be updated to use =~ and !~ comparison operators?
 */
class Plugins_DeliveryLimitations_Geo_Country extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Geo - Country';
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed($page = false)
    {
        return ((isset($GLOBALS['_MAX']['GEO_DATA']['country_code']))
            || $GLOBALS['_MAX']['CONF']['geotargeting']['showUnavailable']);
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    function displayArrayData()
    {
        $tabindex =& $GLOBALS['tabindex'];
        echo "<div class='box'>";
        foreach ($this->res as $code => $name) {
            echo "<div class='boxrow'>";
            echo "<input tabindex='".($tabindex++)."' ";
            echo "type='checkbox' id='c_{$this->executionorder}_{$code}' name='acl[{$this->executionorder}][data][]' value='{$code}'".(in_array($code, $this->data) ? ' CHECKED' : '').">{$name}</div>";
        }
        echo "</div>";
    }
}

?>
