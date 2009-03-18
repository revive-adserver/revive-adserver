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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the updateCampaignsEcpms() method
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class Test_OA_Dal_Maintenance_Priority_updateCampaignsEcpms extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_updateCampaignsEcpms()
    {
        $this->UnitTestCase();
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
