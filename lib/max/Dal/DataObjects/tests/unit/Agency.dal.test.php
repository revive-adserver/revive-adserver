<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing non standard DataObjects_Agency methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_AgencyTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_AgencyTest()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testInsert()
    {
        // Insert default preferences
        $doPreference = MAX_DB::factoryDO('preference');
        $doPreference->agencyid = 0;
        $doPreference->statslastday = '2007-04-03';
        DataGenerator::generateOne($doPreference);

        // Insert an agency
        $doAgency = MAX_DB::factoryDO('agency');
        $agencyId = $doAgency->insert();

        // and check preferences were inserted.
        $doPreference = MAX_DB::staticGetDO('preference', $agencyId);

        $this->assertTrue($doPreference->getRowCount(), 1);
    }

    function testUpdate()
    {
        // Insert default prefs
        $doPreference = MAX_DB::factoryDO('preference');
        $doPreference->agencyid = 0;
        $doPreference->statslastday = '2007-04-03';
        DataGenerator::generateOne($doPreference);

        // Insert an agency
        $doAgency = MAX_DB::factoryDO('agency');
        $agencyId = $doAgency->insert();

        // Update the agency
        $doAgency = MAX_DB::staticGetDO('agency', $agencyId);
        $doAgency->language = 'foo';
        $doAgency->name = 'bar';
        $doAgency->contact = 'baz';
        $doAgency->email = 'quux';
        $doAgency->update();

        // Test the prefs were updated too
        $doPreference = MAX_DB::staticGetDO('preference', $agencyId);

        $this->assertEqual($doPreference->language, 'foo');
        $this->assertEqual($doPreference->name, 'bar');
        $this->assertEqual($doPreference->admin_fullname, 'baz');
        $this->assertEqual($doPreference->admin_email, 'quux');


    }

}
?>