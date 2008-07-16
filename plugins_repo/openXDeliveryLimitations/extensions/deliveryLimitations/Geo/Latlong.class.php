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
            '==' => MAX_Plugin_Translation::translate('Is within', $this->extension, $this->group),
            '!=' => MAX_Plugin_Translation::translate('Is not within', $this->extension, $this->group));
    }

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Latitude/Longitude', $this->extension, $this->group);
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
		echo "    <th align='center'>&nbsp;&gt;&nbsp;".MAX_Plugin_Translation::translate('Latitude', $this->extension, $this->group)."&nbsp;&lt;&nbsp;</th>";
		echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[1])) ? $this->data[1] : '0.0000') . "' tabindex='".($tabindex++)."'></td>";
		echo "</tr>";

		echo "<tr>";
		echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[2])) ? $this->data[2] : '0.0000') . "' tabindex='".($tabindex++)."'></td>";
		echo "    <th align='center'>&nbsp;&gt;&nbsp;".MAX_Plugin_Translation::translate('Longitude', $this->extension, $this->group)."&nbsp;&lt;&nbsp;</th>";
		echo "    <td align='center'><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[3])) ? $this->data[3] : '0.0000') . "' tabindex='".($tabindex++)."'></td>";
		echo "</tr>";
		echo "</table>";
    }
}

?>
