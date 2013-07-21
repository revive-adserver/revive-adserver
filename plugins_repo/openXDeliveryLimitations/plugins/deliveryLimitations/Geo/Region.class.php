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

/**
 * A Geo delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's country and region.
 *
 * Works with:
 * A string of format "CC|list" where "CC" is a valid country code and "list"
 * is a comma separated list of valid region codes. See the Region.res.inc.php
 * resource file for details of the valid country and region codes that can be
 * used with this plugin. (Note that the Country.res.inc.php resource file
 * contains a DIFFERENT list of valid country codes.)
 *
 * Valid comparison operators:
 * ==, !=
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 *
 * @TODO Does this need to be updated to use =~ and !~ comparison operators?
 */
class Plugins_DeliveryLimitations_Geo_Region extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Geo - Country / Region';
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
        return isset($GLOBALS['_MAX']['GEO_DATA']['region'])
            || $GLOBALS['_MAX']['CONF']['geotargeting']['showUnavailable'];
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

        // The region plugin is slightly different since we need to allow for multiple regions in different countries
        echo "
            <table border='0' cellpadding='2'>
                <tr>
                    <th>" . $this->translate('Country') . "</th>
                    <td>
                        <select name='acl[{$this->executionorder}][data][]' {$disabled}>";
                        foreach ($this->res as $countryCode => $countryName) {
                            if (count($countryName) === 1) { continue; }
                            $selected = ($this->data[0] == $countryCode) ? 'selected="selected"' : '';
                            echo "<option value='{$countryCode}' {$selected}>{$countryName[0]}</option>";
                        }
                        echo "
                        </select>
                    &nbsp;<input type='image' name='action[none]' src='" . OX::assetPath() . "/images/{$GLOBALS['phpAds_TextDirection']}/go_blue.gif' border='0' align='absmiddle' alt='{$GLOBALS['strSave']}'></td>
                </tr>";

        if (!empty($this->data[0])) {
            // A country has been selected, show city list for this country...
            // Note: Since a disabled field does not pass it's value through, we need to pass the selected country in...
            echo "<tr><th>" . $this->translate('Region(s)') . "</th><td><div class='box'>";
            $aRegions = $this->res[$this->data[0]];
            unset($aRegions[0]);
            $aSelectedRegions = $this->data;
            unset ($aSelectedRegions[0]);
            foreach ($aRegions as $sCode => $sName) {
                echo "<div class='boxrow'>";
                echo "<input tabindex='".($tabindex++)."' ";
                echo "type='checkbox' id='c_{$this->executionorder}_{$sCode}' name='acl[{$this->executionorder}][data][]' value='{$sCode}'".(in_array($sCode, $aSelectedRegions) ? ' CHECKED' : '').">{$sName}</div>";
            }
            echo "</div></td></tr>";
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
     * Flattens the country and region array into string format.
     *
     * @access private
     * @param mixed $data An optional, expanded form delivery limitation.
     * @return string The delivery limitation in flattened format.
     */
    function _flattenData($data = null)
    {
        if (is_null($data)) {
            $data = $this->data;
        }
        if (is_array($data)) {
            $country = $data[0];
            unset($data[0]);
            return $country . '|' . implode(',', $data);

        }
        return $data;
    }

    /**
     * A private method to "expand" a delivery limitation from the string format that
     * is saved in the database (ie. in the acls or acls_channel table) into its
     * "expanded" form.
     *
     * Expands the string format into an array with the country code in the first
     * element, and the region codes in the remaining elements.
     *
     * @access private
     * @param string $data An optional, flat form delivery limitation data string.
     * @return mixed The delivery limitation data in expanded format.
     */
    function _expandData($data = null)
    {
        if (is_null($data)) {
            $data = $this->data;
        }
        if (!is_array($data)) {
            $aData = strlen($data) ? explode('|', $data) : array();
            $aRegions = MAX_limitationsGetAFromS($aData[1]);
            return array_merge(array($aData[0]), $aRegions);
        }
        return $data;
    }

    function compile()
    {
        return $this->compileData($this->_preCompile($this->data));
    }

    function _preCompile($sData)
    {
        $aData = $this->_expandData($sData);
        $aData = MAX_limitationsGetPreprocessedArray($aData);
        return $this->_flattenData($aData);
    }
}

?>
