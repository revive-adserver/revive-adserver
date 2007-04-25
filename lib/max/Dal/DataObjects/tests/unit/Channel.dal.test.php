<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
 * A class for testing non standard DataObjects_Channel methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_ChannelTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_ChannelTest()
    {
        $this->UnitTestCase();
    }


    function testDelete()
    {
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->acls_updated = '2007-04-03 19:29:54';
        $channelId = DataGenerator::generateOne($doChannel);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->bannerid = 1;
        $doAcls->type = 'Site:Channel';
        $doAcls->data = "$channelId";
        $doAcls->executionorder = 1;
        $doAcls->insert();
        $doAcls->data = "$channelId, 196";
        $doAcls->executionorder = 2;
        $doAcls->insert();

        $doChannel->channelid = $channelId;
        $doChannel->delete();

        $doAcls = OA_Dal::factoryDO('acls');
        $this->assertEqual(1, $doAcls->count());
    }
}
?>