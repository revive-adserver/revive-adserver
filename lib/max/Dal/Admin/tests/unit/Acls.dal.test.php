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
    function MAX_Dal_Admin_AclsTest()
    {
        $this->UnitTestCase();
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
    	$dg = new DataGenerator();
    	$dg->setData('acls', $data);

    	// Add test data
    	$doAcls = OA_Dal::factoryDO('acls');
    	$doAcls->type = $type;
    	$dg->generate($doAcls, 3, true);

    	// Test that $bannerId is in two sets
        $rsChannel = $this->dalAcls->getAclsByDataValueType($channelId, $type);
    	$rsChannel->reset();
    	$this->assertEqual($rsChannel->getRowCount(), 2);
    }
}
?>