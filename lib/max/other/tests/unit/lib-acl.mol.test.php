<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/*
 * A class for testing the lib-geometry.
 *
 * @package    MaxPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class LibAclTest extends DalUnitTestCase
{
    function LibAclTest()
    {
        $this->UnitTestCase();
    }


    function tearDown()
    {
        // DataGenerator::cleanUp();
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
        $doChannel = OA_Dal::factoryDO('channel');
        $channelId = DataGenerator::generateOne($doChannel, false);

        $doChannel->channelid = $channelId;

        $aEntities = array('agencyid' => 0, 'channelid' => $channelId);

        $page = 'channel-acl.php';

        $sLimitation = "MAX_checkClient_Domain('openads.org', '==')";

        $comparison = '==';
        $type = 'Client:Domain';

        $acls = array(
            array(
                'comparison' => '==',
                'data' => 'openads.org',
                'executionorder' => 1,
                'logical' => 'and',
                'type' => $type));
        $this->assertTrue(MAX_AclSave($acls, $aEntities, $page));

        $doChannel = OA_Dal::staticGetDO('channel', $channelId);
        $this->assertTrue($doChannel);
        $this->assertEqual($sLimitation, $doChannel->compiledlimitation);

        $doAclsChannel = OA_Dal::factoryDO('acls_channel');
        $doAclsChannel->channelid = $channelId;
        $doAclsChannel->logical = 'and';
        $doAclsChannel->type = $type;
        $doAclsChannel->comparison = $comparison;
        $doAclsChannel->data = 'openads.org';
        $doAclsChannel->executionorder = 1;
        $doAclsChannel->find();
        $this->assertTrue($doAclsChannel->fetch());

        $acls = array();
        $this->assertTrue(MAX_AclSave($acls, $aEntities, $page));

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
        $plugin = &OA_aclGetPluginFromRow($row);
        $this->assertEqual('Plugins_DeliveryLimitations_Time_Hour', get_class($plugin));
        $this->assertEqual('and', $plugin->logical);
        $this->assertEqual('AaAaA', $plugin->data);
    }
    
    
    function test_MAX_aclRecompileAll()
    {
        $oaTable = new OA_DB_Table();
        $oaTable->truncateTable('acls');
        
        $generator = new DataGenerator();
        $bannerid = $generator->generateOne('banners');
        
        $generator->setData('acls', array(
            'bannerid' => array($bannerid),
            'logical' => array('and'),
            'type' => array('Time:Day', 'Client:Domain'),
            'comparison' => array('=~', '!~'),
            'data' => array('0,1', 'openads.org'),
            'executionorder' => array(1,0)
        ));
        $generator->generate('acls', 2);
        
        $this->assertTrue(MAX_AclReCompileAll());
        
        $doBanners = &OA_Dal::staticGetDO('banners', $bannerid);
        $this->assertEqual(
            "MAX_checkClient_Domain('openads.org', '!~') and MAX_checkTime_Day('0,1', '=~')",
            $doBanners->compiledlimitation);
        $this->assertEqual("Client:Domain,Time:Day", $doBanners->acl_plugins);
    }
}
?>