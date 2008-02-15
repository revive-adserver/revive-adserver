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
$Id: Variable.plugin.php 8911 2007-08-10 09:47:46Z andrew.hill@openads.org $
*/

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris.nutting@openx.org>
 *
 */

require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';
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
        return MAX_Plugin_Translation::translate('Variable', $this->module, $this->package);
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


    function _getSqlLimitation($comparison, $data)
    {
        return false; // Hard to implement, so must be postponed.
    }

    /**
     * A method to compare two comparison and data groups of the same delivery
     * limitation type, and determine if the delivery limitations have any
     * overlap, or not.
     *
     * By default checks for the string overlap.
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
        $aData1 = $this->_expandData($aLimitation1['data']);
        $aData2 = $this->_expandData($aLimitation2['data']);

        $sVarName1 = $aData1[0];
        $sVarName2 = $aData2[0];

        if ($sVarName1 != $sVarName2) {
            return false;
        }

        $sVarValue1 = $aData1[1];
        $sVarValue2 = $aData2[1];

        return MAX_limitationsGetOverlapForStrings(
            $aLimitation1['comparison'], $sVarValue1,
            $aLimitation2['comparison'], $sVarValue2);
    }


    function getSUpgrade($op, $sData)
    {
        return MAX_limitationsGetAUpgradeForVariable($op, $sData);
    }
}

?>
