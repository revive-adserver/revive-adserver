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
 * A class for testing non standard DataObjects_Audit methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_AuditTest extends DalUnitTestCase
{
    function __construct()
    {
        parent::__construct();
        DataGenerator::cleanUp();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testBelongsToAccount()
    {
        OA_Dal::factoryDO('banners'); // Initialise the class so it can be mocked.

        Mock::generatePartial(
            'DataObjects_Banners',
            $mockBanners = 'DataObjects_Banners'.rand(),
            array('getOwningAccountIds')
        );
        $doMockBanners = new $mockBanners($this);
        $doMockBanners->init();

        $clientId = DataGenerator::generateOne('clients', true);
        $doClients = OA_Dal::staticGetDO('clients', $clientId);
        $agencyId  = $doClients->agencyid;
        $accountId = $doClients->account_id;

        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        $managerId = $doAgency->account_id;

        $dg = new DataGenerator();
        $dg->setData('campaigns', array('clientid' => array($clientId)));
        $doMockBanners->setReturnValue(
            'getOwningAccountIds',
            array(
                OA_ACCOUNT_MANAGER    => $managerId,
                OA_ACCOUNT_ADVERTISER => $accountId
            )
        );

        $this->enableAuditing(true);
        $bannerId = $dg->generateOne($doMockBanners, true);
        $this->enableAuditing(false);

        $doAudit = OA_Dal::factoryDO('audit');
        $doAudit->context = 'banners';
        $doAudit->contextid = $bannerId;
        $this->assertTrue($doAudit->find(true));
        $this->assertTrue($doAudit->belongsToAccount($accountId, false));

        // generate different audit on campaign
        $dg = new DataGenerator();
        $doMockBanners = new $mockBanners($this);
        $doMockBanners->init();

        $clientId2 = DataGenerator::generateOne('clients', true);
        $doClients = OA_Dal::staticGetDO('clients', $clientId2);
        $agencyId2  = $doClients->agencyid;
        $accountId2 = $doClients->account_id;

        $doAgency = OA_Dal::staticGetDO('agency', $agencyId2);
        $managerId2 = $doAgency->account_id;

        $dg->setData('campaigns', array('clientid' => array($clientId2)));
        $doMockBanners->setReturnValue(
            'getOwningAccountIds',
            array(
                OA_ACCOUNT_MANAGER    => $managerId2,
                OA_ACCOUNT_ADVERTISER => $accountId2
            )
        );

        $this->enableAuditing(true);
        $bannerId2 = $dg->generateOne($doMockBanners, true);
        $this->enableAuditing(false);

        $doAudit = OA_Dal::factoryDO('audit');
        $doAudit->context = 'banners';
        $doAudit->contextid = $bannerId2;
        $this->assertTrue($doAudit->find(true));
        $this->assertTrue($doAudit->belongsToAccount($accountId2, false));
        $this->assertFalse($doAudit->belongsToAccount($accountId, false));
    }

    /**
     * Turn on/off auditing
     *
     * @param boolean $audit
     */
    function enableAuditing($audit)
    {
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = $audit;
    }

}

?>