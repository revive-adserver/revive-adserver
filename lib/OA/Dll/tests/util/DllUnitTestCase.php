<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A base class for DLL test class.
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
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