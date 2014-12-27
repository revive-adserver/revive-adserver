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

require_once MAX_PATH . '/tests/testClasses/DbTestCase.php';

/**
 * Tests for OA_DB_Sql class.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 */
class Test_OA_DB_Sql extends DbTestCase
{
    function testSqlForInsert()
    {
        $sql = OA_DB_Sql::sqlForInsert('zones', array('zonetype' => 1, 'name' => "120x72"));
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($this->getPrefix().'zones',true);
        $this->assertEqual("INSERT INTO {$table} (zonetype,name) VALUES (1,'120x72')", $sql);
    }

    function testDeleteWhereOne()
    {
        $this->oaTable->createTable('audit');
        $this->oaTable->createTable('acls');

        $dg = new DataGenerator();
        $dg->setData('acls', array('bannerid' => array(1,2,3), 'executionorder' => array(0,0,0,1,1,1,2,2,2)));
        $dg->generate('acls', 5);

        OA_DB_Sql::deleteWhereOne('acls', 'bannerid', 1);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->bannerid = 1;
        $doAcls->find();
        $this->assertEqual(0, $doAcls->getRowCount());

        $doAcls->bannerid = 2;
        $doAcls->find();
        $this->assertEqual(2, $doAcls->getRowCount());

        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->oaTable->dropTable($aConf['table']['prefix'].'acls');
    }

    function testSelectWhereOne()
    {
        $this->initTables(array('banners', 'ad_zone_assoc', 'placement_zone_assoc', 'zones'));

        $id = DataGenerator::generateOne('banners');
        $rsBanners = OA_DB_Sql::selectWhereOne('banners', 'bannerid', $id);
        $this->assertTrue($rsBanners->fetch());
        $this->assertFalse($rsBanners->fetch());

        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->oaTable->dropTable($aConf['table']['prefix'].'banners');
        $this->oaTable->dropTable($aConf['table']['prefix'].'ad_zone_assoc');
        $this->oaTable->dropTable($aConf['table']['prefix'].'placement_zone_assoc');
        $this->oaTable->dropTable($aConf['table']['prefix'].'zones');
    }


    function testUpdateWhereOne()
    {
        $this->initTables(array('campaigns', 'trackers'));

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'First';
        $doCampaigns->views = 10;
        $campaignId1 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Third';
        $doCampaigns->views = 30;
        $campaignId2 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Fifth';
        $doCampaigns->views = 50;
        $campaignId3 = DataGenerator::generateOne($doCampaigns);

        $cUpdated = OA_DB_Sql::updateWhereOne('campaigns', 'campaignid', $campaignId2,
            array('campaignname' => 'Second', 'views' => 20));

        $this->assertEqual(1, $cUpdated);
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId2);
        $this->assertEqual('Second', $doCampaigns->campaignname);
        $this->assertEqual(20, $doCampaigns->views);
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId1);
        $this->assertEqual('First', $doCampaigns->campaignname);
        $this->assertEqual('10', $doCampaigns->views);


        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->oaTable->dropTable($aConf['table']['prefix'].'campaigns');
        $this->oaTable->dropTable($aConf['table']['prefix'].'trackers');
    }
}

?>