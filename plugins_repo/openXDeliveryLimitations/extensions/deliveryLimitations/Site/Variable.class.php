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

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris.nutting@openx.org>
 *
 */

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * "Variable" delivery limitation plugin.
 *
 */
class Plugins_DeliveryLimitations_Site_Variable extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function Plugins_DeliveryLimitations_Site_Variable()
    {
        $this->delimiter = '|';
        $this->aOperations = MAX_limitationsGetAOperationsForString($this) + MAX_limitationsGetAOperationsForNumeric($this);
    }

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Variable', $this->extension, $this->group);
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
		echo "    <td align='left' width='50'><strong>Name:</strong></td><td><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[0])) ? $this->data[0] : '') . "' tabindex='".($tabindex++)."'></td>";
		echo "</tr>";
		echo "<tr>";
		echo "    <td align='left' width='50'><strong>Value:</strong></td><td><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[1])) ? $this->data[1] : '') . "' tabindex='".($tabindex++)."'></td>";
        echo "</tr>";
		echo "</table>";
    }
}

?>
