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
require_once LIB_PATH . '/Plugin/PluginManager.php';

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

    /**
     * This setUp method is being used to install a package which contains (at the moment only one)
     * test (Dummy) plugins which are then used by the test scripts to test the extension point integrations.
     *
     */
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();

        //install the package of test (dummy) plugins for testing the extension points
        unset($GLOBALS['_MAX']['CONF']['plugins']['openXTests']);
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['Dummy']);

        TestEnv::installPluginPackage('openXTests');
    }

    function tearDown()
    {
        // Uninstall
        TestEnv::uninstallPluginPackage('openXTests');

        DataGenerator::cleanUp();
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
        $aAcls[1]['type']             = 'Dummy:Dummy';
        $aAcls[1]['comparison']       = '=~';
        $aAcls[1]['executionorder']   = 1;
        $sLimitation                  = "MAX_checkDummy_Dummy('0,1', '=~')";
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
    }

    function test_OA_aclGetComponentFromRow()
    {
        $row = array('type' => 'Dummy:Dummy', 'logical' => 'and', 'data' => 'AaAaA');
        $plugin =& OA_aclGetComponentFromRow($row);
        $this->assertTrue(is_a($plugin, 'Plugins_DeliveryLimitations_Dummy_Dummy'));
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
        $doAcls->type = 'Dummy:Dummy';
        $doAcls->comparison = '=~';
        $doAcls->data = '0,1';
        $doAcls->executionorder = 1;
        $aclsId1 = DataGenerator::generateOne($doAcls);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->bannerid  = $bannerId;
        $doAcls->logical = 'and';
        $doAcls->type = 'Dummy:Dummy';
        $doAcls->comparison = '!~';
        $doAcls->data = 'openx.org';
        $doAcls->executionorder = 0;
        $aclsId2 = DataGenerator::generateOne($doAcls);

        $this->assertTrue(MAX_AclReCompileAll());

        $doBanners =& OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertEqual(
            "MAX_checkDummy_Dummy('openx.org', '!~') and MAX_checkDummy_Dummy('0,1', '=~')",
            $doBanners->compiledlimitation);
        $this->assertEqual("Dummy:Dummy", $doBanners->acl_plugins);
    }
}
?>
