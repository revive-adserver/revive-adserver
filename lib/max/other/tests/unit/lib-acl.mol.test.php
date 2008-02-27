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
$Id$
*/

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/*
 * A class for testing the lib-geometry.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class LibAclTest extends DalUnitTestCase
{
    function LibAclTest()
    {
        $this->UnitTestCase();

        OA_DB::createFunctions();
    }


    function tearDown()
    {
         DataGenerator::cleanUp();
    }


    function testMAX_aclAStripslashed()
    {
//        set_magic_quotes_runtime(0);
//        $aValue = array('aabb', 'aa\\\\bb', 'aa\\\'bb');
//        $aExpected = array('aabb', 'aa\\bb', 'aa\'bb');
//        $aActual = MAX_aclAStripslashed($aValue);
//        $this->assertEqual($aExpected, $aActual);
//
//        $aValue = array('aabb', 'aa\\\\bb', array('aa\\\'bb', 'cc\\\\dd'));
//        $aExpected = array('aabb', 'aa\\bb', array('aa\'bb', 'cc\\dd'));
//        $aActual = MAX_aclAStripslashed($aValue);
//        $this->assertEqual($aExpected, $aActual);
//
//        set_magic_quotes_runtime(1);
//        $aValue = array('aabb', 'aa\\\\bb', 'aa\\\'bb');
//        $aExpected = $aValue;
//        $aActual = MAX_aclAStripslashed($aValue);
//        $this->assertEqual($aExpected, $aActual);
//        set_magic_quotes_runtime(0);
    }


    function test_MAX_AclSave()
    {
        // insert a channel
        $doChannel = OA_Dal::factoryDO('channel');
        $channelId = DataGenerator::generateOne($doChannel);
        $doChannel->channelid = $channelId;

        // insert a banner
        $doBanners = OA_Dal::factoryDO('banners');
        $bannerId  = DataGenerator::generateOne($doBanners);
        $doBanners->bannerid = $bannerId;
        $doBanners->acls_updated = OA::getNow();
        $doBanners->update();
        $updated1  = $doBanners->acls_updated;

        // save a banner limited by date/time
        $aAcls[1]['data']             = '0,1';
        $aAcls[1]['logical']          = 'and';
        $aAcls[1]['type']             = 'Time:Day';
        $aAcls[1]['comparison']       = '=~';
        $aAcls[1]['executionorder']   = 1;
        $sLimitation                  = "MAX_checkTime_Day('0,1', '=~')";
        $aEntities                    = array('bannerid' => $bannerId);

        $this->assertTrue(MAX_AclSave(array($aAcls[1]), $aEntities, 'banner-acl.php'));

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertTrue($doBanners);
        $this->assertEqual($sLimitation, $doBanners->compiledlimitation);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->whereAdd('bannerid = '.$bannerId);
        $this->assertTrue($doAcls->find(true));
        $this->assertEqual($doAcls->bannerid, $bannerId);
        $this->assertEqual($doAcls->logical, $aAcls[1]['logical']);
        $this->assertEqual($doAcls->type, $aAcls[1]['type']);
        $this->assertEqual($doAcls->comparison, $aAcls[1]['comparison']);
        $this->assertEqual($doAcls->data, $aAcls[1]['data']);
        $this->assertEqual($doAcls->executionorder, $aAcls[1]['executionorder']);
        $this->assertFalse($doAcls->fetch());

        // save a banner limited by channel
        $aAcls[2]['data']              = $channelId;
        $aAcls[2]['logical']           = 'and';
        $aAcls[2]['type']              = 'Site:Channel';
        $aAcls[2]['comparison']        = '=~';
        $aAcls[2]['executionorder']    = 1;
        $sLimitation                   = "(MAX_checkSite_Channel('1', '=~'))";
        $aEntities                     = array('bannerid' => $bannerId);

        $this->assertTrue(MAX_AclSave(array($aAcls[2]), $aEntities, 'banner-acl.php'));

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertTrue($doBanners);
        $this->assertEqual($sLimitation, $doBanners->compiledlimitation);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->whereAdd('bannerid = '.$bannerId);
        $this->assertTrue($doAcls->find(true));
        $this->assertEqual($doAcls->bannerid, $bannerId);
        $this->assertEqual($doAcls->logical, $aAcls[2]['logical']);
        $this->assertEqual($doAcls->type, $aAcls[2]['type']);
        $this->assertEqual($doAcls->comparison, $aAcls[2]['comparison']);
        $this->assertEqual($doAcls->data, $aAcls[2]['data']);
        $this->assertEqual($doAcls->executionorder, $aAcls[2]['executionorder']);
        $this->assertFalse($doAcls->fetch());

        // save a channel limited by domain
        $aAcls['data']              = 'openx.org';
        $aAcls['logical']           = 'and';
        $aAcls['type']              = 'Client:Domain';
        $aAcls['comparison']        = '==';
        $aAcls['executionorder']    = 1;
        $sLimitation                = "MAX_checkClient_Domain('openx.org', '==')";
        $aEntities                  = array('channelid' => $channelId);

        // pause to allow time to pass for acls_updated
        sleep(1);
        $this->assertTrue(MAX_AclSave(array($aAcls), $aEntities, 'channel-acl.php'));

        $doChannel = OA_Dal::staticGetDO('channel', $channelId);
        $this->assertTrue($doChannel);
        $this->assertEqual($sLimitation, $doChannel->compiledlimitation);

        $doAclsChannel = OA_Dal::factoryDO('acls_channel');
        $doAclsChannel->whereAdd('channelid = '.$channelId);
        $this->assertTrue($doAclsChannel->find(true));
        $this->assertEqual($doAclsChannel->channelid, $channelId);
        $this->assertEqual($doAclsChannel->logical, $aAcls['logical']);
        $this->assertEqual($doAclsChannel->type, $aAcls['type']);
        $this->assertEqual($doAclsChannel->comparison, $aAcls['comparison']);
        $this->assertEqual($doAclsChannel->data, $aAcls['data']);
        $this->assertEqual($doAclsChannel->executionorder, $aAcls['executionorder']);
        $this->assertFalse($doAclsChannel->fetch());

        // changing a channel limitation should timestamp the banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->bannerid = $bannerId;
        $doBanners->find(true);
        $updated2  = $doBanners->acls_updated;
        $this->assertTrue(strtotime($updated2) > strtotime($updated1));

        // remove the channel limitation
        $aAcls = array();
        $this->assertTrue(MAX_AclSave($aAcls, $aEntities, 'channel-acl.php'));

        $doChannel = OA_Dal::staticGetDO('channel', $channelId);
        $this->assertTrue($doChannel);
        $this->assertEqual('true', $doChannel->compiledlimitation);
        $this->assertEqual('', $doChannel->acl_plugins);

        $doAclsChannel = OA_Dal::factoryDO('acls_channel');
        $this->assertEqual(0, $doAclsChannel->count());
    }


    function test_MAX_AclCopy()
    {
        $block = 125;

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->block = $block;
        $bannerId = DataGenerator::generateOne($doBanners);
    }

    function OLD_test_MAX_AclCopy()
    {
        $block = 125;

        $dg = new DataGenerator();
        $dg->setDataOne('banners', array('block' => $block));
        $bannerId = $dg->generateOne('banners');

        $cAcls = 5;
        $aDataAcls = array('bannerid' => array($bannerId), 'executionorder' => array());
        for($idxAcl = 1; $idxAcl <= 5; $idxAcl++) {
            $aDataAcls['executionorder'][] = $idxAcl;
        }
        $dg->setData('acls', $aDataAcls);
        $dg->generate('acls', 5);

        $dg->setDataOne('banners', array('data' => ''));
        $bannerIdNew = $dg->generateOne('banners');
        MAX_AclCopy('', $bannerId, $bannerIdNew);

        $doBanners = OA_DAL::staticGetDO('banners', $bannerIdNew);
        $this->assertEqual($block, $doBanners->block);

        $o = new DB_DataObjectCommon();
        $doAcls = OA_DAL::staticGetDO('acls', 'bannerid', $bannerId);
        $aDataAcls = $doAcls->getAll(array('logical', 'type', 'comparison', 'data', 'executionorder'));
        $doAcls = OA_DAL::staticGetDO('acls', 'bannerid', $bannerIdNew);
        $aDataAclsNew = $doAcls->getAll(array('logical', 'type', 'comparison', 'data', 'executionorder'));
        $this->assertEqual($aDataAcls, $aDataAclsNew);
    }


    function test_OA_aclGetPluginFromRow()
    {
        $row = array('type' => 'Time:Hour', 'logical' => 'and', 'data' => 'AaAaA');
        $plugin =& OA_aclGetPluginFromRow($row);
        $this->assertTrue(is_a($plugin, 'Plugins_DeliveryLimitations_Time_Hour'));
        $this->assertEqual('and', $plugin->logical);
        $this->assertEqual('AaAaA', $plugin->data);
    }


    function test_MAX_aclRecompileAll()
    {
        DataGenerator::cleanUp(array('acls'));

        $doBanners = OA_Dal::factoryDO('banners');
        $bannerId = DataGenerator::generateOne($doBanners);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->bannerid  = $bannerId;
        $doAcls->logical = 'and';
        $doAcls->type = 'Time:Day';
        $doAcls->comparison = '=~';
        $doAcls->data = '0,1';
        $doAcls->executionorder = 1;
        $aclsId1 = DataGenerator::generateOne($doAcls);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->bannerid  = $bannerId;
        $doAcls->logical = 'and';
        $doAcls->type = 'Client:Domain';
        $doAcls->comparison = '!~';
        $doAcls->data = 'openx.org';
        $doAcls->executionorder = 0;
        $aclsId2 = DataGenerator::generateOne($doAcls);

        $this->assertTrue(MAX_AclReCompileAll());

        $doBanners =& OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertEqual(
            "MAX_checkClient_Domain('openx.org', '!~') and MAX_checkTime_Day('0,1', '=~')",
            $doBanners->compiledlimitation);
        $this->assertEqual("Client:Domain,Time:Day", $doBanners->acl_plugins);
    }

}
?>