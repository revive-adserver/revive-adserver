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
    function __construct()
    {
        parent::__construct();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testInsert()
    {
        // Insert an agency

        $agencyName = 'Agency name';
        $agencyContact = 'Agency contact';
        $agencyContactEmail = 'agencycontact@example.com';

        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = $agencyName;
        $doAgency->contact = $agencyContact;
        $doAgency->email = $agencyContactEmail;

        $agencyId = $doAgency->insert();

        $doAgencyResult = OA_Dal::factoryDO('agency');
        $doAgencyResult->get($agencyId);

        $this->assertTrue($doAgencyResult->getRowCount(), 1);
        $this->assertEqual($agencyName, $doAgencyResult->name);
        $this->assertEqual($agencyContact, $doAgencyResult->contact);
        $this->assertEqual($agencyContactEmail, $doAgencyResult->email);

        DataGenerator::cleanUp(array('agency'));
    }

    function testUpdate()
    {
        // Insert an agency
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId = $doAgency->insert();

        // Update the agency
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        $doAgency->name = 'bar';
        $doAgency->contact = 'baz';
        $doAgency->email = 'quux';
        $doAgency->update();

        $doAgencyResult = OA_Dal::staticGetDO('agency', $agencyId);

        $this->assertTrue($doAgencyResult->getRowCount(), 1);
        $this->assertEqual($doAgencyResult->name, 'bar');
        $this->assertEqual($doAgencyResult->contact, 'baz');
        $this->assertEqual($doAgencyResult->email, 'quux');

        DataGenerator::cleanUp(array('agency'));

    }

}
?>