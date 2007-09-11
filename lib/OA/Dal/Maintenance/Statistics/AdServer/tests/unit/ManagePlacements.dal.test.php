<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Factory.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

// pgsql execution time before refactor: 67.073s
// pgsql execution time after refactor: s

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_ManagePlacements extends UnitTestCase
{
    var $doCampaigns = null;
    var $doBanners = null;
    var $doDIA = null;
    var $doClients = null;
    var $oDbh = null;
    var $tblCampaigns;

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_ManagePlacements()
    {
        $this->UnitTestCase();
        $this->doCampaigns = OA_Dal::factoryDO('campaigns');
        $this->doClients = OA_Dal::factoryDO('clients');
        $this->doBanners   = OA_Dal::factoryDO('banners');
        $this->doDIA = OA_Dal::factoryDO('data_intermediate_ad');
        $this->oDbh = &OA_DB::singleton();
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;
        $this->tblCampaigns = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true);
    }

    function _insertCampaign($aData)
    {
        $this->doCampaigns->campaignname = 'Test Placement';
        $this->doCampaigns->clientid = 1;
        $this->doCampaigns->weight = 1;
        $this->doCampaigns->priority = -1;
        $this->doCampaigns->views = -1;
        $this->doCampaigns->clicks = -1;
        $this->doCampaigns->conversions = -1;
        $this->doCampaigns->target_impression = -1;
        $this->doCampaigns->target_click = -1;
        $this->doCampaigns->target_conversion = -1;
        $this->doCampaigns->active='t';
        $this->doCampaigns->updated = null;
        $this->doCampaigns->expire = OA_Dal::noDateValue();
        $this->doCampaigns->activate = OA_Dal::noDateValue();
        foreach ($aData AS $key => $val)
        {
            $this->doCampaigns->$key = $val;
        }
        return DataGenerator::generateOne($this->doCampaigns);
    }

    function _insertClient($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doClients->$key = $val;
        }
        return DataGenerator::generateOne($this->doClients);
    }

    function _insertBanner($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doBanners->$key = $val;
        }
        return DataGenerator::generateOne($this->doBanners);
    }

    function _insertDataIntermediateAd($aData)
    {
        $this->doDIA->operation_interval = 60;
        $this->doDIA->operation_interval_id = 17;
        $this->doDIA->creative_id = 0;
        $this->doDIA->zone_id = 0;
        $this->doDIA->hour = 17;
        foreach ($aData AS $key => $val)
        {
            $this->doDIA->$key = $val;
        }
        return DataGenerator::generateOne($this->doDIA);
    }

    function _getCampaignByCampaignId($idCampaign)
    {
        $query = "
            SELECT
                *
            FROM
                {$this->tblCampaigns}
            WHERE
                campaignid = ".$idCampaign;
        return $this->oDbh->queryRow($query);
    }

    /**
     * Tests the managePlacements() method.
     */
    function testManagePlacements()
    {
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $oDate = new Date();

        // Insert the base test data

        $aData = array(
                       'contact'=>'Test Contact',
                       'email'=>'postmaster@localhost'
                       );
        $idClient1 = $this->_insertClient($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 1',
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignname'=>'Test Campaign 2',
            'clientid'=>$idClient1,
            'views'=>10,
        );
        $idCampaign2 = $this->_insertCampaign($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 3',
            'clientid'=>$idClient1,
            'clicks'=>10,
        );
        $idCampaign3 = $this->_insertCampaign($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 4',
            'clientid'=>$idClient1,
            'conversions'=>10,
        );
        $idCampaign4 = $this->_insertCampaign($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 5',
            'clientid'=>$idClient1,
            'views'=>10,
            'clicks'=>10,
            'conversions'=>10
        );
        $idCampaign5 = $this->_insertCampaign($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 6',
            'clientid'=>$idClient1,
            'views'=>-1,
            'expire'=>'2004-06-06',
        );
        $idCampaign6 = $this->_insertCampaign($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 7',
            'clientid'=>$idClient1,
            'activate'=>'2004-06-06',
            'active'=>'f'
        );
        $idCampaign7 = $this->_insertCampaign($aData);

        $aData = array(
                        'campaignid'=>$idCampaign1,
                      );
        $idBanner1 = $this->_insertBanner($aData);

        $aData = array(
                        'campaignid'=>$idCampaign2,
                      );
        $idBanner2 = $this->_insertBanner($aData);

        $aData = array(
                        'campaignid'=>$idCampaign2,
                      );
        $idBanner3 = $this->_insertBanner($aData);

        $aData = array(
                        'campaignid'=>$idCampaign2,
                      );
        $idBanner4 = $this->_insertBanner($aData);

        $aData = array(
                        'campaignid'=>$idCampaign3,
                      );
        $idBanner5 = $this->_insertBanner($aData);

        $aData = array(
                        'campaignid'=>$idCampaign4,
                      );
        $idBanner6 = $this->_insertBanner($aData);

        $aData = array(
                        'campaignid'=>$idCampaign5,
                      );
        $idBanner7 = $this->_insertBanner($aData);

        $aData = array(
                        'campaignid'=>$idCampaign6,
                      );
        $idBanner8 = $this->_insertBanner($aData);

        $aData = array(
                        'campaignid'=>$idCampaign7,
                      );
        $idBanner9 = $this->_insertBanner($aData);

        // Test with no summarised data
        $report = $dsa->managePlacements($oDate);

        $aRow = $this->_getCampaignByCampaignId($idCampaign1);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');

        $aRow = $this->_getCampaignByCampaignId($idCampaign2);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');

        $aRow = $this->_getCampaignByCampaignId($idCampaign3);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');

        $aRow = $this->_getCampaignByCampaignId($idCampaign4);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');

        $aRow = $this->_getCampaignByCampaignId($idCampaign5);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');

        $aRow = $this->_getCampaignByCampaignId($idCampaign6);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 'f');

        $aRow = $this->_getCampaignByCampaignId($idCampaign7);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['active'], 't');

        // Insert the summary test data - Part 1

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner1,
                        'impressions'=>1,
                        'clicks'=>1,
                        'conversions'=>1
                      );
        $idDIA1 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner2,
                        'impressions'=>1,
                        'clicks'=>1,
                        'conversions'=>1
                      );
        $idDIA2 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner3,
                        'impressions'=>1,
                        'clicks'=>0,
                        'conversions'=>0
                      );
        $idDIA3 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner4,
                        'impressions'=>8,
                        'clicks'=>0,
                        'conversions'=>0
                      );
        $idDIA4 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner5,
                        'impressions'=>1000,
                        'clicks'=>5,
                        'conversions'=>1000
                      );
        $idDIA5 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner6,
                        'impressions'=>1000,
                        'clicks'=>1000,
                        'conversions'=>1000
                      );
        $idDIA6 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner7,
                        'impressions'=>0,
                        'clicks'=>4,
                        'conversions'=>6
                      );
        $idDIA7 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner8,
                        'impressions'=>0,
                        'clicks'=>4,
                        'conversions'=>6
                      );
        $idDIA8 = $this->_insertDataIntermediateAd($aData);

        // Test with summarised data
        $report = $dsa->managePlacements($oDate);

        $aRow = $this->_getCampaignByCampaignId($idCampaign1);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');

        $aRow = $this->_getCampaignByCampaignId($idCampaign2);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 'f');

        $aRow = $this->_getCampaignByCampaignId($idCampaign3);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');

        $aRow = $this->_getCampaignByCampaignId($idCampaign4);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 'f');

        $aRow = $this->_getCampaignByCampaignId($idCampaign5);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');

        $aRow = $this->_getCampaignByCampaignId($idCampaign6);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 'f');

        $aRow = $this->_getCampaignByCampaignId($idCampaign7);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['active'], 't');
        DataGenerator::cleanUp();

        // Final test to ensure that placements expired as a result of limitations met are
        // not re-activated in the event that their expiration date has not yet been reached

        $aData = array(
                        'campaignname'=>'Test Campaign 1',
                        'clientid'=>1,
                        'views'=>10,
                        'clicks'=>-1,
                        'conversions'=>-1,
                        'expire'=>'2005-12-09',
                        'activate'=>'2005-12-07',
                        'active'=>'f'
                      );
        $idCampaign1 = $this->_insertCampaign($aData);

        $aData = array(
                       'contact'=>'Test Contact',
                       'email'=>'postmaster@localhost'
                       );
        $idClient1 = $this->_insertClient($aData);

        $aData = array(
                        'campaignid'=>1,
                      );
        $idBanner1 = $this->_insertBanner($aData);

        $aData = array(
                        'operation_interval_id'=>25,
                        'interval_start'=>'2005-12-08 00:00:00',
                        'interval_end'=>'2004-12-08 00:59:59',
                        'hour'=>0,
                        'ad_id'=>1,
                        'impressions'=>100,
                        'clicks'=>1,
                        'conversions'=>0
                      );
        $idDIA1 = $this->_insertDataIntermediateAd($aData);

        $oDate = new Date('2005-12-08 01:00:01');
        $report = $dsa->managePlacements($oDate);

        $aRow = $this->_getCampaignByCampaignId($idCampaign1);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2005-12-09');
        $this->assertEqual($aRow['activate'], '2005-12-07');
        $this->assertEqual($aRow['active'], 'f');
        DataGenerator::cleanUp();
        TestEnv::restoreConfig();
    }
}

?>
