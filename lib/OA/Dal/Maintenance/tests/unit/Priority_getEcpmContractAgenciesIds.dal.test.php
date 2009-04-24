<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';

/**
 * A class for testing the getEcpmContractAgenciesIds() method of
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class Test_OA_Dal_Maintenance_Priority_getEcpmContractAgenciesIds extends UnitTestCase
{
    public $aExpectedData = array();

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getEcpmContractAgenciesIds()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the getEcpmAgenciesIds method.
     */
    function testGetEcpmContractAgenciesIds()
    {
        $this->_generateTestData();
        $da = new OA_Dal_Maintenance_Priority();
        $ret = $da->getEcpmContractAgenciesIds();
        $this->assertEqual($this->aExpectedData, $ret);

        DataGenerator::cleanUp();
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateTestData()
    {
        // Add agencies
        $agencyId1 = DataGenerator::generateOne('agency', true);
        $agencyId2 = DataGenerator::generateOne('agency', true);
        $agencyId3 = DataGenerator::generateOne('agency', true);
        $this->aExpectedData = array($agencyId1, $agencyId2);

        // Add clients
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId1;
        $clientId1 = DataGenerator::generateOne($doClients);
        
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId2;
        $clientId2 = DataGenerator::generateOne($doClients);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId2;
        $clientId3 = DataGenerator::generateOne($doClients);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId3;
        $clientId4 = DataGenerator::generateOne($doClients);

        // Add campaigns
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Test eCPM Campaign 1';
        $doCampaigns->priority = 1;
        $doCampaigns->ecpm_enabled = 1;
        $doCampaigns->clientid = $clientId1;
        $idCampaign1 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Test non eCPM Campaign 2';
        $doCampaigns->ecpm = 0.2;
        $doCampaigns->min_impressions = 200;
        $doCampaigns->priority = 1;
        $doCampaigns->ecpm_enabled = 0;
        $doCampaigns->clientid = $clientId2;
        $idCampaign1 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Test eCPM Campaign 2';
        $doCampaigns->ecpm = 0.5;
        $doCampaigns->min_impressions = 300;
        $doCampaigns->priority = 4;
        $doCampaigns->ecpm_enabled = 1;
        $doCampaigns->clientid = $clientId3;
        $idCampaign2 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Test non eCPM Campaign 2';
        $doCampaigns->ecpm = 0.2;
        $doCampaigns->min_impressions = 200;
        $doCampaigns->priority = 7;
        $doCampaigns->ecpm_enabled = 0;
        $doCampaigns->clientid = $clientId4;
        $idCampaign1 = DataGenerator::generateOne($doCampaigns);
    }
}

?>