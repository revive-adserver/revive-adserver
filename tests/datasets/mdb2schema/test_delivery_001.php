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
 *
 * @abstract A class for generating/loading a dataset for delivery testing
 * @package Test Classes
 */

//require_once MAX_PATH . '/tests/testClasses/OATestData_DataObjects.php';
//class OA_Test_Data_delivery_001 extends OA_Test_Data_DataObjects
require_once MAX_PATH . '/tests/testClasses/OATestData_MDB2Schema.php';
class OA_Test_Data_delivery_001 extends OA_Test_Data_MDB2Schema
{

    /**
     * method for extending OA_Test_Data_MDB2Schema
     */
    function generateTestData()
    {
        if (!parent::init('test_delivery_001.xml'))
        {
            return false;
        }
        if (!parent::generateTestData())
        {
            return false;
        }
        return true;
    }

}

?>