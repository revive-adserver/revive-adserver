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
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * A Geo delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's country and city.
 *
 * Works with:
 * A string of format "CC|list" where "CC" is a valid country code and "list"
 * is a comma separated list of city names. See the City.res.inc.php
 * resource file for details of the valid country codes that can be used
 * with this plugin. (Note that the Country.res.inc.php resource file contains
 * a DIFFERENT list of valid country codes.)
 *
 * Valid comparison operators:
 * ==
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_Geo_City extends Plugins_DeliveryLimitations
{
    function Plugins_DeliveryLimitations_Geo_City()
    {
        parent::Plugins_DeliveryLimitations();
        $this->nameEnglish = 'Geo - Country / City';
    }

    function init($data)
    {
        parent::init($data);
        if (is_array($this->data)) {
            $this->data = $this->_flattenData($this->data);
        }
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed()
    {
        return ((isset($GLOBALS['_MAX']['GEO_DATA']['city']))
            || $GLOBALS['_MAX']['CONF']['geotargeting']['showUnavailable']);
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    function displayData()
    {
        $this->data = $this->_expandData($this->data);
        $tabindex =& $GLOBALS['tabindex'];


        // The city plugin is slightly different since we need to allow for multiple city names in different countries
        echo "
            <table border='0' cellpadding='2'>
                <tr>
                    <th>" . $this->translate('Country') . "</th>
                    <td>
                        <select name='acl[{$this->executionorder}][data][]' {$disabled}>";
                        foreach ($this->res as $countryCode => $countryName) {
                            $selected = ($this->data[0] == $countryCode) ? 'selected="selected"' : '';
                            echo "<option value='{$countryCode}' {$selected}>{$countryName}</option>";
                        }
                        echo "
                        </select>
                    &nbsp;<input type='image' name='action[none]' src='" . OX::assetPath() . "/images/{$GLOBALS['phpAds_TextDirection']}/go_blue.gif' border='0' align='absmiddle' alt='{$GLOBALS['strSave']}'></td>
                </tr>";

        if (isset($this->data[0])) {
            // A country has been selected, show city list for this country...
            // Note: Since a disabled field does not pass it's value through, we need to pass the selected country in...
            echo "<tr><th>" . $this->translate('City(s)') . "</th><td>";
            echo "<input type='text' name='acl[{$this->executionorder}][data][]' value='".htmlspecialchars($this->data[1], ENT_QUOTES)."' tabindex='".($tabindex++)."' />";
            echo "</td></tr>";
        }
        echo "
            </table>
        ";
        $this->data = $this->_flattenData($this->data);
    }

    /**
     * A private method to "flatten" a delivery limitation into the string format that is
     * saved to the database (either in the acls, acls_channel or banners table, when part
     * of a compiled limitation string).
     *
     * Flattens the country and city list array into string format.
     *
     * @access private
     * @param mixed $data An optional, expanded form delivery limitation.
     * @return string The delivery limitation in flattened format.
     */
    function _flattenData($data = null)
    {
        $data = parent::_flattenData($data);
        return MAX_limitationsGeoCitySerialize($data);
    }

    /**
     * A private method to "expand" a delivery limitation from the string format that
     * is saved in the database (ie. in the acls or acls_channel table) into its
     * "expanded" form.
     *
     * Expands the string format into an array of the country, and a comma separated
     * string of cities.
     *
     * @access private
     * @param string $data An optional, flat form delivery limitation data string.
     * @return mixed The delivery limitation data in expanded format.
     */
    function _expandData($data = null)
    {
        $data = parent::_expandData($data);
        return MAX_limitationsGeoCityUnserialize($data);
    }

    function compile()
    {
        return $this->compileData($this->_preCompile($this->data));
    }

    /**
     * A private method to pre-compile limitaions.
     *
     * @access private
     * @param mixed $data An optional, expanded form delivery limitation.
     * @return string The delivery limitation in pre-compiled form, with any changes to the format
     *                of the data stored in the database having been made, ready to be used for
     *                either compiling the limitation into final form, or converting the limitation
     *                into SQL form.
     */
    function _preCompile($sData)
    {
        $aData = MAX_limitationsGeoCityUnserialize($sData);
        $sCountry = MAX_limitationsGetCountry($aData);
        MAX_limitationsSetCountry($aData, MAX_limitationsGetPreprocessedString($sCountry));
        $sCities = MAX_limitationsGetSCities($aData);
        $aCities = MAX_limitationsGetAFromS($sCities);
        $aCities = MAX_limitationsGetPreprocessedArray($aCities);
        MAX_limitationsSetSCities($aData, MAX_limitationsGetSFromA($aCities));
        return MAX_limitationsGeoCitySerialize($aData);
    }
}


/* City delivery limitation plugin utility functions */

function MAX_limitationsGeoCitySerialize($aCityLimitation)
{
    $sCountry = MAX_limitationsGetCountry($aCityLimitation);
    $sCities = MAX_limitationsGetSCities($aCityLimitation);
    return $sCountry . '|' . $sCities;
}

function MAX_limitationsGeoCityUnserialize($sCityLimitation)
{
    return array (
                substr($sCityLimitation, 0, strpos($sCityLimitation, '|')),
                substr($sCityLimitation, strpos($sCityLimitation, '|')+1)
            );
}

function MAX_limitationsGetSCities($aData)
{
    return $aData[1];
}

function MAX_limitationsSetSCities(&$aData, $sCities)
{
    $aData[1] = $sCities;
}

?>
