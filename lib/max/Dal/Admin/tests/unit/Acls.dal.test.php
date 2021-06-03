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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Acls.php';

/**
 * A class for testing DAL Acls methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_AclsTest extends DalUnitTestCase
{
    /**
     * @var MAX_Dal_Admin_Acls
     */
    var $dalAcls;

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function setUp()
    {
        $this->dalAcls = OA_Dal::factoryDAL('acls');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetAclsByDataValueType()
    {
        $type = 'Site:Channel';
        $bannerId = 1;
        $channelId = 1;

        // Test it returns empty set if no data exists
        $rsChannel = $this->dalAcls->getAclsByDataValueType($bannerId, $type);
    	$rsChannel->reset();
    	$this->assertEqual($rsChannel->getRowCount(), 0);

    	// Generate acls, two of them with the same $bannerId
    	$data = array(
    	   'bannerid' => array($bannerId,$bannerId,3),
    	   'data' => array("$channelId,2,3", '4,5,6', "$channelId"),
    	   'executionorder' => array(1,2,3)
    	);

        DataGenerator::setData('acls', $data);

    	// Add test data
    	$doAcls = OA_Dal::factoryDO('acls');
    	$doAcls->type = $type;
        DataGenerator::generate($doAcls, 3, true);

    	// Test that $bannerId is in two sets
        $rsChannel = $this->dalAcls->getAclsByDataValueType($channelId, $type);
    	$rsChannel->reset();
    	$this->assertEqual($rsChannel->getRowCount(), 2);
    }
}
?>