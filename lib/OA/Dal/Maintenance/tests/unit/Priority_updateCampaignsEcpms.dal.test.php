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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the updateCampaignsEcpms() method
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Maintenance_Priority_updateCampaignsEcpms extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Method to test the updateCampaignsEcpms method.
     */
    function testUpdateCampaignsEcpms()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDal = new OA_Dal_Maintenance_Priority();

        $aOldEcpms = array('0.1', '0.2', '0.3', '0.4', '0.5');
        $aCampaignsIds = array();
        foreach ($aOldEcpms as $ecpm) {
            $aCampaignsEcpms[$this->addCampaign($ecpm)] = $ecpm;
        }
        $testCampaignId = $this->addCampaign($testEcpm = '0.9');
        foreach ($aCampaignsEcpms as $campaignId => $ecpm) {
            $aCampaignsEcpms[$campaignId] += '0.01';
        }
        // update eCPMs
        $oDal->updateCampaignsEcpms($aCampaignsEcpms);

        // test that ecpms were correctly updates
        foreach ($aCampaignsEcpms as $campaignId => $ecpm) {
            $this->checkEcpm($campaignId, $ecpm);
        }
        // test that existing ecpms weren't changed
        $this->checkEcpm($testCampaignId, $testEcpm);

        DataGenerator::cleanUp();
    }

    function checkEcpm($campaignId, $ecpm)
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignid = $campaignId;
        $doCampaigns->find($autofetch = true);
        $this->assertEqual(round($ecpm, 3), round($doCampaigns->ecpm, 3));
    }

    function addCampaign($ecpm)
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->ecpm = $ecpm;
        return DataGenerator::generateOne($doCampaigns);
    }
}

?>
