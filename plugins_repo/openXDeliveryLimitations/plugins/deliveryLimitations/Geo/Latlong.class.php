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
require_once MAX_PATH . '/lib/max/other/lib-geo.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * A Geo delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's Latitude and Longitude.
 *
 * Works with:
 * A comma separated list of four float values, being, in order, the lower
 * Latitude bound, the upper Latitude bound, the lower Longitude bound, and
 * the upper Longitude bound.
 *
 * Valid comparison operators:
 * ==, !=
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Geo_Latlong extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    use \RV\Extension\DeliveryLimitations\GeoLimitationTrait;

    public function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Geo - Latitude/Longitude';
    }

    public function init($data)
    {
        parent::init($data);
        $this->aOperations = [
            '==' => $this->translate('Is within'),
            '!=' => $this->translate('Is not within'),
        ];
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    public function isAllowed($page = false)
    {
        return $this->hasCapability('latitude');
    }

    /**
    * Method to check input data
    *
    * @param array $data Most important to check is $data['data'] field
    * @return bool|string true or error message
    */
    public function checkInputData($data)
    {
        if (is_array($data['data'])) {
            foreach ($data['data'] as $number) {
                if (!is_numeric($number) || str_contains($data['data'][0], ',')) {
                    return $this->translate('Geo:Latitude/Longitude: One of the parameter is not a number', $this->extension, $this->group);
                }
            }
        }
        return true;
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    public function displayArrayData()
    {
        $tabindex = &$GLOBALS['tabindex'];
        echo "<table width='275' cellpadding='0' cellspacing='0' border='0'>";
        echo "<tr>";
        echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((empty($this->data[0])) ? '0.0000' : htmlspecialchars($this->data[0], ENT_QUOTES)) . "' tabindex='" . ($tabindex++) . "'></td>";
        echo "    <th align='center'>&nbsp;&gt;&nbsp;" . $this->translate('Latitude') . "&nbsp;&lt;&nbsp;</th>";
        echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((empty($this->data[1])) ? '0.0000' : htmlspecialchars($this->data[1], ENT_QUOTES)) . "' tabindex='" . ($tabindex++) . "'></td>";
        echo "</tr>";

        echo "<tr>";
        echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((empty($this->data[2])) ? '0.0000' : htmlspecialchars($this->data[2], ENT_QUOTES)) . "' tabindex='" . ($tabindex++) . "'></td>";
        echo "    <th align='center'>&nbsp;&gt;&nbsp;" . $this->translate('Longitude') . "&nbsp;&lt;&nbsp;</th>";
        echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((empty($this->data[3])) ? '0.0000' : htmlspecialchars($this->data[3], ENT_QUOTES)) . "' tabindex='" . ($tabindex++) . "'></td>";
        echo "</tr>";
        echo "</table>";
    }
}
