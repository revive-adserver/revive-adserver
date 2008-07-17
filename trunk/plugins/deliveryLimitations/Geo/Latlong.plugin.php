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

require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';
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
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_Geo_Latlong extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function Plugins_DeliveryLimitations_Geo_Latlong()
    {
        $this->Plugins_DeliveryLimitations_ArrayData();
        $this->aOperations = array(
            '==' => MAX_Plugin_Translation::translate('Is within', $this->module, $this->package),
            '!=' => MAX_Plugin_Translation::translate('Is not within', $this->module, $this->package));
    }

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Latitude/Longitude', $this->module, $this->package);
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed()
    {
        return ((isset($GLOBALS['_MAX']['GEO_DATA']['latitude']))
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
		echo "<table width='275' cellpadding='0' cellspacing='0' border='0'>";
		echo "<tr>";
		echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[0])) ? $this->data[0] : '0.0000') . "' tabindex='".($tabindex++)."'></td>";
		echo "    <th align='center'>&nbsp;&gt;&nbsp;".MAX_Plugin_Translation::translate('Latitude', $this->module, $this->package)."&nbsp;&lt;&nbsp;</th>";
		echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[1])) ? $this->data[1] : '0.0000') . "' tabindex='".($tabindex++)."'></td>";
		echo "</tr>";

		echo "<tr>";
		echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[2])) ? $this->data[2] : '0.0000') . "' tabindex='".($tabindex++)."'></td>";
		echo "    <th align='center'>&nbsp;&gt;&nbsp;".MAX_Plugin_Translation::translate('Longitude', $this->module, $this->package)."&nbsp;&lt;&nbsp;</th>";
		echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[3])) ? $this->data[3] : '0.0000') . "' tabindex='".($tabindex++)."'></td>";
		echo "</tr>";
		echo "</table>";
    }

    /**
     * A private method to return this delivery limitation plugin as a SQL limiation.
     *
     * @access private
     * @param string $comparison As for Plugins_DeliveryLimitations::_getSqlLimitation(),
     *                           but only '==' and '!=' permitted.
     * @param string $data A comma separated list of 4 values, the minimum and maximum
     *                     latitude, and the minimum and maximum longitude.
     * @return mixed As for Plugins_DeliveryLimitations::_getSqlLimitation().
     */
    function _getSqlLimitation($comparison, $data)
    {
        $aData = MAX_limitationsGetAFromS($data);
        if ($comparison == '==') {
            // Latitude and Longitude should be within the values,
            // which includes equaling the values
            return "(geo_latitude >= {$aData[0]} AND geo_latitude <= {$aData[1]} AND geo_longitude >= {$aData[2]} AND geo_longitude <= {$aData[3]})";
        } else {
            // Latitude and Longitude should not be within the values,
            // which does NOT include equaling the values
            return "(geo_latitude < {$aData[0]} OR geo_latitude > {$aData[1]} OR geo_longitude < {$aData[2]} OR geo_longitude > {$aData[3]})";
        }

    }

    /**
     * A method to compare two comparison and data groups of the same delivery
     * limitation type, and determine if the delivery limitations have any
     * overlap, or not.
     *
     * @param array $aLimitation1 An array containing the "comparison" and "data"
     *                            fields of the first delivery limitation.
     * @param array $aLimitation2 An array containing the "comparison" and "data"
     *                            fields of the second delivery limitation.
     * @return boolean True if there is overlap between the two delivery limitations,
     *                 false if there is NOT any overlap.
     */
    function overlap($aLimitation1, $aLimitation2)
    {
        $aRegion1 = MAX_geoReplaceEmptyWithZero(
            $this->_expandData($aLimitation1['data']));
        $comparison1 = $aLimitation1['comparison'];
        $aRegion2 = MAX_geoReplaceEmptyWithZero(
            $this->_expandData($aLimitation2['data']));
        $comparison2 = $aLimitation2['comparison'];

        if ($comparison1 == '==' && $comparison2 == '==') {
            return MAX_geoDoRegionsHaveCommonPart($aRegion1, $aRegion2);
        } elseif ($comparison1 == '==' && $comparison2 == '!=') {
            return !MAX_geoIsRegionContainedInRegion($aRegion1, $aRegion2);
        } elseif ($comparison1 == '!=' && $comparison2 == '==') {
            return !MAX_geoIsRegionContainedInRegion($aRegion2, $aRegion1);
        } else {
            // DISCUSS:
            // I would return true straightforward.
            // Below is the computation for the rare occurence
            // that both regions together cover entire planet,
            // for example regions:
            // Region1: -89.9999, -30, -179.9999, 179.9999
            // Region2: -29.9999, 89.9999, -179.9999, 179.9999
            // Very unlikely users will ever set anything like this
            // in a negative way (using !=).
            $lattitudeSouth1 = MAX_geoGetLattitudeSouth($aRegion1);
            $lattitudeNorth1 = MAX_geoGetLattitudeNorth($aRegion1);
            $longitudeWest1 = MAX_geoGetLongitudeWest($aRegion1);
            $longitudeEast1 = MAX_geoGetLongitudeEast($aRegion1);

            $lattitudeSouth2 = MAX_geoGetLattitudeSouth($aRegion2);
            $lattitudeNorth2 = MAX_geoGetLattitudeNorth($aRegion2);
            $longitudeWest2 = MAX_geoGetLongitudeWest($aRegion2);
            $longitudeEast2 = MAX_geoGetLongitudeEast($aRegion2);

            return !
                (MAX_geoDoesRegionSpanEntireWorld($aRegion1)
                    || MAX_geoDoesRegionSpanEntireWorld($aRegion2)
                    || (MAX_geoDoesRegionSpanEntireLattitude($aRegion1)
                        && MAX_geoDoesRegionSpanEntireLattitude($aRegion2)
                        && (($longitudeWest1 == GEO_MIN_LONGITUDE
                            && $longitudeEast2 == GEO_MAX_LONGITUDE
                            && ($longitudeWest2 - $longitudeEast1 <= 0.00011))
                            || ($longitudeWest2 == GEO_MIN_LONGITUDE
                            && $longitudeEast1 == GEO_MAX_LONGITUDE
                            && ($longitudeWest1 - $longitudeEast2 <= 0.00011)))
                    )
                    || (MAX_geoDoesRegionSpanEntireLongitude($aRegion1)
                        && MAX_geoDoesRegionSpanEntireLongitude($aRegion2)
                        && (($lattitudeSouth1 == GEO_MIN_LATTITUDE
                            && $lattitudeNorth2 == GEO_MAX_LATTITUDE
                            && ($lattitudeSouth2 - $lattitudeNorth1 <= 0.00011))
                            || (($lattitudeSouth2 == GEO_MIN_LATTITUDE
                            && $lattitudeNorth1 == GEO_MAX_LATTITUDE
                            && ($lattitudeSouth1 - $lattitudeNorth2 <= 0.00011)))
                        )
                    )
                );
        }
    }
}

?>
