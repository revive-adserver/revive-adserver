<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/*
 * A class for testing the lib-geometry.
 *
 * @package    MaxPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class LibDbTest extends DalUnitTestCase
{
    function testPhpAds_dbQuery()
    {
        $cBanners = 5;
        $doZones = OA_Dal::factoryDO('zones');
        $aZoneIds = DataGenerator::generate($doZones, $cBanners);

        $queryResult = phpAds_dbQuery(" SeLeCt * from zones");
        $this->assertTrue($queryResult);

        $this->assertEqual($cBanners, phpAds_dbNumRows($queryResult));

        $idxZone = 0;
        while ($dataZone = phpAds_dbFetchArray($queryResult)) {
            $this->assertTrue(in_array($dataZone['zoneid'], $aZoneIds));
            $idxZone++;
        }
        $this->assertEqual($cBanners, $idxZone);

        $queryResult = phpAds_dbQuery("dElEtE from zones where zoneid > 30000");
        $this->assertTrue($queryResult);
        $this->assertEqual(0, phpAds_dbAffectedRows($queryResult));

        $queryResult = phpAds_dbQuery(" uPDATe zones set zonename = 'blah' where zoneid = " . $aZoneIds[0] . " or zoneid = " . $aZoneIds[1]);
        $this->assertTrue($queryResult);
        $this->assertEqual(2, phpAds_dbAffectedRows($queryResult));

        $queryResult = phpAds_dbQuery("insert into zones () values ()");
        $this->assertTrue($queryResult);
        $this->assertEqual(1, phpAds_dbAffectedRows($queryResult));
    }
}
?>