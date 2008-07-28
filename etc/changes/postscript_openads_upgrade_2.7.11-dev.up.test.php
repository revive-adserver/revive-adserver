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
$Id $
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

/**
 * 2.7.11-dev upgrade test
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Bernard Lange <bernard.lange@openx.org>
 */
class Test_postscript_2_7_11_dev extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_postscript_2_7_11_dev()
    {
    }

    function test_runScript()
    {
        $aExpectation = $this->_generateTestData();

        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->initDatabaseConnection();
        $this->assertTrue($oUpgrade->runScript('postscript_openads_upgrade_2.7.11-dev.php'));

        $this->_assertTestData($aExpectation);

        DataGenerator::cleanUp();
    }

    function _assertTestData($aExpectation)
    {
        foreach ($aExpectation as $id => $aCampaign)
        {
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            $doCampaigns->campaignid = $id;
            $doCampaigns->find(true);
            $this->assertEqual($doCampaigns->campaignname, $aCampaign['campaignname']);
            $this->assertEqual($doCampaigns->revenue_type, $aCampaign['revenue_type']);
        }
    }

    function _generateTestData()
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'CPM';
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $campaignId1  = DataGenerator::generateOne($doCampaigns);
        $result[$campaignId1] = array('campaignname'=>$doCampaigns->campaignname, 'revenue_type'=>MAX_FINANCE_CPM);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'CPC';
        $doCampaigns->clicks = 10;
        $doCampaigns->conversions = 0;
        $campaignId2  = DataGenerator::generateOne($doCampaigns);
        $result[$campaignId2] = array('campaignname'=>$doCampaigns->campaignname, 'revenue_type'=>MAX_FINANCE_CPC);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'CPA';
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 10;
        $campaignId3  = DataGenerator::generateOne($doCampaigns);
        $result[$campaignId3] = array('campaignname'=>$doCampaigns->campaignname, 'revenue_type'=>MAX_FINANCE_CPA);

        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($GLOBALS['_MAX']['CONF']['table']['prefix'].'campaigns',true);
        $oDbh->exec('UPDATE '.$table.' SET revenue_type = NULL');

        return $result;
    }

}

?>
