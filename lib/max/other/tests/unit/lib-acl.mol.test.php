<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
}
?>