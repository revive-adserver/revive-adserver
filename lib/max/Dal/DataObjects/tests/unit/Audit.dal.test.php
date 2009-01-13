<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * A class for testing non standard DataObjects_Audit methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_AuditTest extends DalUnitTestCase
{
    function DataObjects_AuditTest()
    {
        $this->UnitTestCase();
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