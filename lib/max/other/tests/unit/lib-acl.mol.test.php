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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once LIB_PATH . '/Plugin/PluginManager.php';

Language_Loader::load();

/*
 * A class for testing the lib-geometry.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class LibAclTest extends DalUnitTestCase
{
    public function __construct()
    {
        parent::__construct();

        OA_DB::createFunctions();
    }

    /**
     * This setUp method is being used to install a package which contains (at the moment only one)
     * test (Dummy) plugins which are then used by the test scripts to test the extension point integrations.
     *
     */
    public function setUp()
    {
        $oPkgMgr = new OX_PluginManager();

        //install the package of test (dummy) plugins for testing the extension points
        unset($GLOBALS['_MAX']['CONF']['plugins']['openXTests']);
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['Dummy']);

        TestEnv::installPluginPackage('openXTests');
    }

    public function tearDown()
    {
        // Uninstall
        TestEnv::uninstallPluginPackage('openXTests');

        DataGenerator::cleanUp();
    }

    public function test_MAX_AclSave()
    {
        // insert a channel
        $doChannel = OA_Dal::factoryDO('channel');
        $channelId = DataGenerator::generateOne($doChannel);
        $doChannel->channelid = $channelId;

        // insert a banner
        $doBanners = OA_Dal::factoryDO('banners');
        $bannerId = DataGenerator::generateOne($doBanners);
        $doBanners->bannerid = $bannerId;
        $doBanners->acls_updated = OA::getNow();
        $doBanners->update();
        $updated1 = $doBanners->acls_updated;

        // save a banner limited by date/time
        $aAcls[1]['data'] = '0,1';
        $aAcls[1]['logical'] = 'and';
        $aAcls[1]['type'] = 'Dummy:Dummy';
        $aAcls[1]['comparison'] = '=~';
        $aAcls[1]['executionorder'] = 1;
        $sLimitation = "MAX_checkDummy_Dummy('0,1', '=~')";
        $aEntities = ['bannerid' => $bannerId];

        $this->assertTrue(MAX_AclSave([$aAcls[1]], $aEntities, 'banner-acl.php'));

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertTrue($doBanners);
        $this->assertEqual($sLimitation, $doBanners->compiledlimitation);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->whereAdd('bannerid = ' . $bannerId);
        $this->assertTrue($doAcls->find(true));
        $this->assertEqual($doAcls->bannerid, $bannerId);
        $this->assertEqual($doAcls->logical, $aAcls[1]['logical']);
        $this->assertEqual($doAcls->type, $aAcls[1]['type']);
        $this->assertEqual($doAcls->comparison, $aAcls[1]['comparison']);
        $this->assertEqual($doAcls->data, $aAcls[1]['data']);
        $this->assertEqual($doAcls->executionorder, $aAcls[1]['executionorder']);
        $this->assertFalse($doAcls->fetch());
    }

    public function test_OA_aclGetComponentFromRow()
    {
        $row = ['type' => 'Dummy:Dummy', 'logical' => 'and', 'data' => 'AaAaA'];
        $plugin = &OA_aclGetComponentFromRow($row);
        $this->assertTrue(is_a($plugin, 'Plugins_DeliveryLimitations_Dummy_Dummy'));
        $this->assertEqual('and', $plugin->logical);
        $this->assertEqual('AaAaA', $plugin->data);
    }

    public function test_MAX_aclRecompileAll()
    {
        DataGenerator::cleanUp(['acls']);

        $doBanners = OA_Dal::factoryDO('banners');
        $bannerId = DataGenerator::generateOne($doBanners);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->bannerid = $bannerId;
        $doAcls->logical = 'and';
        $doAcls->type = 'Dummy:Dummy';
        $doAcls->comparison = '=~';
        $doAcls->data = '0,1';
        $doAcls->executionorder = 1;
        $aclsId1 = DataGenerator::generateOne($doAcls);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->bannerid = $bannerId;
        $doAcls->logical = 'and';
        $doAcls->type = 'Dummy:Dummy';
        $doAcls->comparison = '!~';
        $doAcls->data = 'openx.org';
        $doAcls->executionorder = 0;
        $aclsId2 = DataGenerator::generateOne($doAcls);

        $this->assertTrue(MAX_AclReCompileAll());

        $doBanners = &OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertEqual(
            "MAX_checkDummy_Dummy('openx.org', '!~') and MAX_checkDummy_Dummy('0,1', '=~')",
            $doBanners->compiledlimitation,
        );
        $this->assertEqual("Dummy:Dummy", $doBanners->acl_plugins);
    }
}
