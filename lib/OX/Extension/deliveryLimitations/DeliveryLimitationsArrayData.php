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
 */
class Plugins_DeliveryLimitations_ArrayData extends Plugins_DeliveryLimitations
{

    var $_aValues;
    // The character/string to delimit the data
    var $delimiter = ',';

    function __construct()
    {
        parent::__construct();
        $this->aOperations = array(
            '=~' => MAX_Plugin_Translation::translate('Is any of', $this->extension, $this->group),
            '!~' => MAX_Plugin_Translation::translate('Is not any of', $this->extension, $this->group));
    }

    /**
     * This is a placeholder for the old PHP4 constructor.
     *
     * DO NOT DELETE OTHERWISE THE PLUGIN UPGRADE WILL FAIL!
     */
    final function Plugins_DeliveryLimitations_ArrayData()
    {
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


     /**
     * Method to check input data
     *
     * @param array $data Most important to check is $data['data'] field.
     * By default the empty string check is done.
     * @return bool|string true or error message
     */
    function checkInputData($data)
    {
//        $result = parent::checkInputData($data);
//        if ($result === true) { //if parent check was OK
//            if (is_array($data['data'])) {
//                foreach ($data['data'] as $dataEntry) {
//                    if (trim($dataEntry) == '') {
//                        return MAX_Plugin_Translation::translate($this->group.' - '.$this->getName().': Please provide a non-empty limitation parameters', $this->extension, $this->group);
//                    }
//                }
//            }
//        }
//
//        return $result;

          return true;
    }


}

?>
