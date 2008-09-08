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

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitations.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * An abstract subclass of Plugins_DeliveryLimitations which handles
 * array data overlap checking.
 *
 * Handles the following operators:
 * '=~', '!~' (see the init() method).
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrzej Swedrzynski <andrzej@m3.net>
 */
class Plugins_DeliveryLimitations_ArrayData extends Plugins_DeliveryLimitations
{

    var $_aValues;
    // The character/string to delimit the data
    var $delimiter = ',';

    function Plugins_DeliveryLimitations_ArrayData()
    {
        $this->Plugins_DeliveryLimitations();
        $this->aOperations = array(
            '=~' => MAX_Plugin_Translation::translate('Is any of', $this->extension, $this->group),
            '!~' => MAX_Plugin_Translation::translate('Is not any of', $this->extension, $this->group));
    }

    function init($data)
    {
        parent::init($data);
        if (is_array($this->data)) {
            $this->data = $this->_flattenData($this->data);
        }
    }

    /**
     * Initializes the plugin with an array of possible values.
     *
     * @param array $aValues
     */
    function setAValues($aValues)
    {
        $this->_aValues = $aValues;
    }

    /**
     * A private method to "flatten" a delivery limitation into the string format that is
     * saved to the database (either in the acls, acls_channel or banners table, when part
     * of a compiled limitation string).
     *
     * Flattens the browser code array into string format.
     *
     * @access private
     * @param mixed $data An optional, expanded form delivery limitation.
     * @return string The delivery limitation in flattened format.
     */
    function _flattenData($data = null)
    {
        $result = parent::_flattenData($data);
        if (is_array($result)) {
            return implode($this->delimiter, $result);
        }
        return $result;
    }

    /**
     * A private method to "expand" a delivery limitation from the string format that
     * is saved in the database (ie. in the acls or acls_channel table) into its
     * "expanded" form.
     *
     * Expands the string format into an array of browser codes.
     *
     * @access private
     * @param string $data An optional, flat form delivery limitation data string.
     * @return mixed The delivery limitation data in expanded format.
     */
    function _expandData($data = null)
    {
        $result = parent::_expandData($data);
        if (!is_array($result)) {
            return strlen($result) ? explode($this->delimiter, $result) : array();
        }
        return $result;
    }

    function displayData()
    {
        // An ugly hack to overcome the problem with duplicated displayData() methods.
        $this->data = $this->_expandData($this->data);
        $this->displayArrayData();
        $this->data = $this->_flattenData($this->data);
    }

    function _preCompile($sData)
    {
        $aData = $this->_expandData($sData);
        $aItems = MAX_limitationsGetPreprocessedArray($aData);
        return $this->_flattenData($aItems);
    }

    /**
     * Extracts values from the data. If the 'comparison' field
     * of $aLimitation is '!=' then returns all the values
     * within range which are not in the data.
     *
     * @param array $aLimitation
     * @return array
     * @see overlap
     */
    function _getAPositiveValues($aLimitation)
    {
        $aResult = $this->_expandData($aLimitation['data']);
        if ($aLimitation['comparison'] == '!='
            || $aLimitation['comparison'] == '!~') {
            $aResult = array_diff($this->_aValues, $aResult);
        }

        return $aResult;
    }

}

?>
