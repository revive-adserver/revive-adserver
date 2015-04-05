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
 * basis of the viewer's continent.
 *
 * Works with:
 * A comma separated list of valid continent codes (eg. "AF" for Africa). See
 * the Continent.res.inc.php resource file for more details of the valid
 * continent codes.
 *
 * Valid comparison operators:
 * =~, !~
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Geo_Continent extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Geo - Continent';
    }


    function init($data)
    {
        parent::init($data);
        $this->setAValues(array_keys($this->res));
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
        foreach ($this->res as $continent => $countries) {
            echo "<div class='boxrow'>";
            echo "<input tabindex='".($tabindex++)."' ";
            echo "type='checkbox' id='c_{$this->executionorder}_{$continent}' name='acl[{$this->executionorder}][data][]' value='{$continent}'".(in_array($continent, $this->data) ? ' checked="checked"' : '').">{$countries[0]}</div>";
        }
        echo "</div>";
    }


    function compile()
    {
        $sData = $this->_preCompile($this->data);
        return $this->compileData($sData);
    }


    function _preCompile($sData)
    {
        $aContinentCodes = MAX_limitationsGetAFromS($sData);
        $aCountries = array();
        foreach ($aContinentCodes as $continentCode) {
            $aContinentCountries = $this->res[$continentCode];
            unset($aContinentCountries[0]); // Remove the name of the continent
            $aCountries = array_merge($aCountries, $aContinentCountries);
        }
        return parent::_preCompile(MAX_limitationsGetSFromA($aCountries));
    }

}

?>
