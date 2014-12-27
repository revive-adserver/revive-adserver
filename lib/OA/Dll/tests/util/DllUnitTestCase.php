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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A base class for DLL test class.
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 */


class DllUnitTestCase extends UnitTestCase
{
    /**
     * Errors
     *
     */
    var $wrongDateError = 'The start date is after the end date';

    /**
     * Return error message.
     *
     * @param $errorMessage string
     */
    function _getMethodShouldReturnError($errorMessage)
    {
        return 'Method should return: "'.$errorMessage.'"';
    }

    /**
     * Check if field equal value.
     *
     * @param object &$oObj1
     * @param object &$oObj2
     * @param string $fieldName
     */
    function assertFieldEqual(&$oObj1, &$oObj2, $fieldName)
    {
        if (is_object($oObj1->$fieldName) &&
            is_a($oObj1->$fieldName, 'Date')) {

            $this->assertEqual($oObj1->$fieldName->format("%Y-%m-%d"),
                               $oObj2->$fieldName->format("%Y-%m-%d"),
                               'Field \''.$fieldName.'\' value is incorrect');
        } else {
            if (isset($oObj1->$fieldName) || isset($oObj2->$fieldName)) {
                $this->assertEqual($oObj1->$fieldName, $oObj2->$fieldName,
                                   'Field \''.$fieldName.'\' value is incorrect');
            }
        }
    }

}

?>