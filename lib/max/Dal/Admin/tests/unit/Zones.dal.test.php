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
 * A class for testing DAL Zones methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_ZonesTest extends DalUnitTestCase
{
    var $dalZones;

    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_ZonesTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->dalZones = OA_Dal::factoryDAL('zones');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetZoneByKeyword()
    {
        // Search for zones when none exist.
        $expected = 0;
        $rsZones = $this->dalZones->getZoneByKeyword('foo');
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $agencyId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $affiliateId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', null, $affiliateId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $affiliateId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId, $affiliateId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        // Add a zone (and parent objects)
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename = 'foo';
        $doZones->description = 'bar';
        $zoneId = DataGenerator::generateOne($doZones, true);
        $affiliateId1 = DataGenerator::getReferenceId('affiliates');
        $agencyId1 = DataGenerator::getReferenceId('agency');

        // Add another zone
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename = 'baz';
        $doZones->description = 'quux';
        $zoneId = DataGenerator::generateOne($doZones, true);
        $agencyId2 = DataGenerator::getReferenceId('agency');

        // Search for the zone by string
        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo');
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $rsZones = $this->dalZones->getZoneByKeyword('bar');
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        // Restrict the search to agency ID
        $expected = 0;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId = 0);
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId1);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        // Restrict the search to affiliate ID
        $expected = 0;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId, $affiliateId = 0);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId1, $affiliateId1);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $rsZones = $this->dalZones->getZoneByKeyword('bar', null, $affiliateId1);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);


        // Search for zone by zone ID
        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword($zoneId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
    }

    function testGetZoneForInvocationForm()
    {
        // Insert a publisher
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->website = 'http://example.com';
        $affiliateId = DataGenerator::generateOne($doAffiliates);

        // Insert a zone
        $doZone = OA_Dal::factoryDO('zones');
        $doZone->affiliateid = $affiliateId;
        $doZone->height = 5;
        $doZone->width = 10;
        $doZone->delivery = 1;
        $zoneId = DataGenerator::generateOne($doZone);

        $aExpected = array(
            'affiliateid' => $affiliateId,
            'height' => 5,
            'width' => 10,
            'delivery' => 1,
            'website' => 'http://example.com'
        );
        $aActual = $this->dalZones->getZoneForInvocationForm($zoneId);

        ksort($aExpected);
        ksort($aActual);

        $this->assertEqual($aActual, $aExpected);
    }
}
?>