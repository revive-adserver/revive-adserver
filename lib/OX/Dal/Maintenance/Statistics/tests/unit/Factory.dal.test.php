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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OX/Dal/Maintenance/Statistics/Factory.php';

/**
 * A class for testing the OX_Dal_Maintenance_Statistics_Factory class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OX_Dal_Maintenance_Statistics_Factory extends UnitTestCase
{

    /**
     * The database type in use.
     *
     * @var string
     */
    var $dbType = '';

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
        $oDbh = OA_DB::singleton();
        $this->dbType = $oDbh->dsn['phptype'];
    }

    /**
     * Test the creation.
     */
    function testCreate()
    {
        $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
        $classname = $oFactory->deriveClassName();
        $this->assertEqual($classname, 'OX_Dal_Maintenance_Statistics_' . ucfirst(strtolower($this->dbType)));
    }

}

?>