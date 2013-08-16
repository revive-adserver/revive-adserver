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
        $this->nameEnglish = 'Site - Variable';
    }

     /**
     * Method to check input data
     *
     * @param array $data Most important to check is $data['data'] field
     * @return bool|string true or error message
     */
    function checkInputData($data)
    {
        $result = parent::checkInputData($data);
        if ($result === true) { //if parent check was OK
        if (is_array($data['data'])) {
            if (strpos($data['data'][0],'|') !== false) {
                return MAX_Plugin_Translation::translate('Site:Variable: Name contains unallowed character(s)', $this->extension, $this->group);
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
    function displayArrayData()
    {
        $tabindex =& $GLOBALS['tabindex'];
		echo "<table width='275' cellpadding='0' cellspacing='0' border='0'>";
		echo "<tr>";
		echo "    <td align='left' width='50'><strong>Name:</strong></td><td><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[0])) ? htmlspecialchars($this->data[0], ENT_QUOTES) : '') . "' tabindex='".($tabindex++)."'></td>";
		echo "</tr>";
		echo "<tr>";
		echo "    <td align='left' width='50'><strong>Value:</strong></td><td><input type='text' size='10' name='acl[{$this->executionorder}][data][]' value='" . ((!empty($this->data[1])) ? htmlspecialchars($this->data[1], ENT_QUOTES) : '') . "' tabindex='".($tabindex++)."'></td>";
        echo "</tr>";
		echo "</table>";
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
        $result = array (
            substr($data, 0, strpos($data, '|')),
            substr($data, strpos($data, '|')+1)
        );
        return $result;
    }

    /**
     * Because this plugin takes user-entered data it needs to be correctly escaped when compiling it
     *
     * @return string   The compiled data string ready for use in the compiledlimitation field
     */
    function compile()
    {
        return $this->compileData($this->_preCompile($this->data));
    }

    /**
     * Override precompile not to lowercase the variable name.
     *
     * @param string $sData
     * @return string
     */
    function _preCompile($sData)
    {
        $aData = $this->_expandData($sData);
        $aData[0] = trim($aData[0]);
        $aData[1] = MAX_limitationsGetPreprocessedString($aData[1]);
        return $this->_flattenData($aData);
    }
}

?>
