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

/**
 * A class for testing DAL Channel methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_ChannelTest extends DalUnitTestCase
{
    var $dalChannel;

    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_ChannelTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->dalChannel = OA_Dal::factoryDAL('channel');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetChannelsAndAffiliates()
    {
        // Insert 2 channels
        $aData = array(
            'acls_updated' => array('2007-04-04 17:27:33')
        );
        $dg = new DataGenerator();
        $dg->setData('channel', $aData);
        $aChannelId = $dg->generate('channel', 2, true);

        // Check the correct number of rows returned
        $expectedRows = 2;
        $rsChannel = $this->dalChannel->getChannelsAndAffiliates();
        $rsChannel->find();
        $actualRows = $rsChannel->getRowCount();
        $this->assertEqual($actualRows, $expectedRows);

        // Check each row has the correct number of fields
        $rsChannel->fetch();
        $aChannel = $rsChannel->export();
        $this->assertEqual(count($aChannel), 4);
    }


}
?>
