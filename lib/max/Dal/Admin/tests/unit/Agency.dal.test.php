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
 * A class for testing DAL Agency methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_AgencyTest extends DalUnitTestCase
{
    var $dalAgency;

    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_AgencyTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->dalAgency = OA_Dal::factoryDAL('agency');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetLogoutUrl()
    {
        // Insert an agency without a logout url
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->logout_url = '';
        $agencyId = DataGenerator::generateOne($doAgency);

        $path = 'serveraddress';
        $GLOBALS['_MAX']['CONF']['webpath']['admin'] = $path;
        $GLOBALS['_MAX']['CONF']['openads']['sslPort'] = 443;
        $GLOBALS['_MAX']['HTTP'] = 'http://';
        $expected = 'http://'.$path.'/index.php';
        $this->assertEqual($this->dalAgency->getLogoutUrl($agencyId), $expected);

        // Insert an agency with a logout url
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->logout_url = 'http://example.com';
        $agencyId = DataGenerator::generateOne($doAgency);

        $expected = 'http://example.com';
        $this->assertEqual($this->dalAgency->getLogoutUrl($agencyId), $expected);

    }
}
?>
