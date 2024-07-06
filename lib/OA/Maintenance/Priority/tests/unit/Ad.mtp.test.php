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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Ad.php';

/**
 * A class for testing the OA_Maintenance_Priority_Ad class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OA_Maintenance_Priority_Ad extends UnitTestCase
{
    /**
     * The class constructor method.
     */
    public function __construct()
    {
        parent::__construct();
        Mock::generate('OA_Dal_Maintenance_Priority');
    }

    /**
     * A method to be called before every test to store default
     * mocked data access layers in the service locator.
     */
    public function setUp()
    {
        $oServiceLocator = OA_ServiceLocator::instance();
        $oMaxDalMaintenancePriority = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oMaxDalMaintenancePriority);
    }

    /**
     * A method to be called after every test to remove the
     * mocked data access layers from the service locator.
     *
     */
    public function tearDown()
    {
        $oServiceLocator = OA_ServiceLocator::instance();
        $oServiceLocator->remove('OA_Dal_Maintenance_Priority');
    }

    /**
     * A method to test the OA_Maintenance_Priority_Ad() method.
     *
     * Requirements:
     * Test 1: Test with invalid input and ensure the _abort() method is called.
     * Test 2: Test, and ensure parameters are correctly set.
     */
    public function testOA_Maintenance_Priority_Ad()
    {
        // Test 1
        $aParams = 'foo';
        $this->assertAbortIsCalled($aParams);

        $aParams = [];
        $this->assertAbortIsCalled($aParams);

        $aParams = [
            'status' => OA_ENTITY_STATUS_RUNNING,
        ];
        $this->assertAbortIsCalled($aParams);

        $aParams = [
            'status' => OA_ENTITY_STATUS_RUNNING,
            'type' => 'sql',
            'weight' => 1,
        ];
        $this->assertAbortIsCalled($aParams);

        $aParams = [
            'ad_id' => 'foo',
            'status' => OA_ENTITY_STATUS_RUNNING,
            'type' => 'sql',
            'weight' => 1,
        ];
        $this->assertAbortIsCalled($aParams);

        $aParams = [
            'ad_id' => 1,
            'type' => 'sql',
            'weight' => 1,
        ];
        $this->assertAbortIsCalled($aParams);

        $aParams = [
            'ad_id' => 1,
            'status' => OA_ENTITY_STATUS_RUNNING,
            'weight' => 1,
        ];
        $this->assertAbortIsCalled($aParams);

        $aParams = [
            'ad_id' => 1,
            'status' => OA_ENTITY_STATUS_AWAITING,
            'type' => 'sql',
        ];
        $this->assertAbortIsCalled($aParams);

        $aParams = [
            'ad_id' => 1,
            'status' => OA_ENTITY_STATUS_AWAITING,
            'type' => 'sql',
            'weight' => 'foo',
        ];
        $this->assertAbortIsCalled($aParams);

        // Test 2
        $aParams = [
            'ad_id' => 1,
        ];
        $oMaxEntityAd = new OA_Maintenance_Priority_Ad($aParams);
        $this->assertEqual($oMaxEntityAd->id, 1);
        $this->assertNull($oMaxEntityAd->active);
        $this->assertNull($oMaxEntityAd->type);
        $this->assertNull($oMaxEntityAd->weight);

        $aParams = [
            'ad_id' => 1,
            'status' => OA_ENTITY_STATUS_RUNNING,
            'type' => 'sql',
            'weight' => 2,
        ];
        $oMaxEntityAd = new OA_Maintenance_Priority_Ad($aParams);
        $this->assertEqual($oMaxEntityAd->id, 1);
        $this->assertTrue($oMaxEntityAd->active);
        $this->assertEqual($oMaxEntityAd->type, 'sql');
        $this->assertEqual($oMaxEntityAd->weight, 2);
    }

    /**
     * A method to test the getDeliveryLimitations() method.
     */
    public function testGetDeliveryLimitations()
    {
        $oServiceLocator = OA_ServiceLocator::instance();
        $oMaxDalMaintenancePriority = &$oServiceLocator->get('OA_Dal_Maintenance_Priority');
        $oMaxDalMaintenancePriority->expectArgumentsAt(0, 'getAllDeliveryLimitationsByTypeId', [1, 'ad']);
        $oMaxDalMaintenancePriority->expectCallCount('getAllDeliveryLimitationsByTypeId', 1);

        $aParams = [
            'ad_id' => 1,
        ];
        $oMaxEntityAd = new OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->getDeliveryLimitations();

        $oMaxDalMaintenancePriority->tally();
    }

    private function assertAbortIsCalled(mixed $aParams): void
    {
        $oMaxEntityAd = null;

        try {
            $oMaxEntityAd = new OA_Maintenance_Priority_Ad($aParams);
        } catch (\RuntimeException) {
        }

        $this->assertNull($oMaxEntityAd);
    }
}
