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
require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

/**
 * 2.7.11-dev upgrade test
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 */
class Test_postscript_2_7_11_dev extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
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

        // Add another record of each type to make sure that multiple records get tested

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'CPM';
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $campaignId4  = DataGenerator::generateOne($doCampaigns);
        $result[$campaignId4] = array('campaignname'=>$doCampaigns->campaignname, 'revenue_type'=>MAX_FINANCE_CPM);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'CPC';
        $doCampaigns->clicks = 10;
        $doCampaigns->conversions = 0;
        $campaignId5  = DataGenerator::generateOne($doCampaigns);
        $result[$campaignId5] = array('campaignname'=>$doCampaigns->campaignname, 'revenue_type'=>MAX_FINANCE_CPC);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'CPA';
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 10;
        $campaignId6  = DataGenerator::generateOne($doCampaigns);
        $result[$campaignId6] = array('campaignname'=>$doCampaigns->campaignname, 'revenue_type'=>MAX_FINANCE_CPA);


        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($GLOBALS['_MAX']['CONF']['table']['prefix'].'campaigns',true);
        $oDbh->exec('UPDATE '.$table.' SET revenue_type = NULL');

        return $result;
    }

}

?>
