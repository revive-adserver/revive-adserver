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

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/SummariseIntermediate.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_MigrateBucketData class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OX_Maintenance_Statistics_Task_MigrateBucketData extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $this->assertTrue(is_a($oSummariseIntermediate, 'OX_Maintenance_Statistics_Task_MigrateBucketData'));
    }

}

?>