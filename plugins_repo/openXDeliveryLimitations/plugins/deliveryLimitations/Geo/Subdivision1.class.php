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
 *
 * @TODO Does this need to be updated to use =~ and !~ comparison operators?
 */
class Plugins_DeliveryLimitations_Geo_Subdivision1 extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    use \RV\Extension\DeliveryLimitations\GeoLimitationTrait;

    public function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Geo - Level 1 Subdivision';
    }

    public function init($data)
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
    public function isAllowed($page = false)
    {
        return $this->hasCapability('subdivision_1');
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    public function displayData()
    {
        $this->data = $this->_expandData($this->data);
        $tabindex = &$GLOBALS['tabindex'];

        // The region plugin is slightly different since we need to allow for multiple regions in different countries
        echo "
            <table border='0' cellpadding='2'>
                <tr>
                    <th>" . $this->translate('Country') . "</th>
                    <td>
                        <select name='acl[{$this->executionorder}][data][]'>
        ";

        foreach ($this->res[0] as $countryCode => $countryName) {
            $countryName = htmlspecialchars($countryName);
            $selected = ($this->data[0] == $countryCode) ? 'selected="selected"' : '';
            echo "<option value='{$countryCode}' {$selected}>{$countryName}</option>";
        }

        echo "
                        </select>
                    &nbsp;<input type='image' name='action[none]' src='" . OX::assetPath() . "/images/{$GLOBALS['phpAds_TextDirection']}/go_blue.gif' border='0' align='absmiddle' alt='{$GLOBALS['strSave']}'></td>
                </tr>
        ";

        if (!empty($this->data[0])) {
            // A country has been selected, show level 1 subdivisions list for this country...
            echo "<tr><th>" . $this->translate('Subdivision(s)') . "</th><td><div class='box'>";

            $aSelectedRegions = array_flip($this->data);
            array_shift($aSelectedRegions);

            foreach ($this->getSubdivisions($this->data[0]) as $sCode => $sName) {
                $sName = htmlspecialchars($sName);
                echo "<div class='boxrow'>";
                echo "<input tabindex='" . ($tabindex++) . "' ";
                echo "type='checkbox' id='c_{$this->executionorder}_{$sCode}' name='acl[{$this->executionorder}][data][]' value='{$sCode}'" . (isset($aSelectedRegions[$sCode]) ? ' CHECKED' : '') . ">{$sName}</div>";
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
    public function _flattenData($data = null)
    {
        if (is_null($data)) {
            $data = $this->data;
        }
        if (is_array($data)) {
            $country = array_shift($data);

            // Strip country code and hyphen
            $data = array_map(function ($code) {
                return substr($code, 3);
            }, $data);

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
    public function _expandData($data = null)
    {
        if (is_null($data)) {
            $data = $this->data;
        }
        if (!is_array($data)) {
            $aData = strlen($data) ? explode('|', $data) : [];
            $country = $aData[0];

            // Add country code and hyphen
            $aRegions = array_map(function ($code) use ($country) {
                return "{$country}-{$code}";
            }, MAX_limitationsGetAFromS($aData[1]));

            return array_merge([$aData[0]], $aRegions);
        }
        return $data;
    }

    public function compile()
    {
        return $this->compileData($this->_preCompile($this->data));
    }

    public function _preCompile($sData)
    {
        $aData = $this->_expandData($sData);

        $country = array_shift($aData);

        return $this->_flattenData(array_merge([$country], $aData));
    }

    protected function getSubdivisions($countryCode)
    {
        $aSubdivisions = $this->res[1][$countryCode];

        asort($aSubdivisions);

        return $aSubdivisions;
    }
}
