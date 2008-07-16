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

require_once OX_EXTENSIONS_PATH . '/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';
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
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_Geo_Continent extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function Plugins_DeliveryLimitations_Geo_Continent()
    {
        $this->Plugins_DeliveryLimitations_ArrayData();
        $this->nameEnglish = 'Continent';
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
    function isAllowed()
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
