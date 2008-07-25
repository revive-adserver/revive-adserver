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

require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Domain class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_demoBannerTypeHtml extends UnitTestCase
{
    var $pkgName;
    var $pkgVersion;

    function setUp()
    {
        $this->pkgName = 'demoExtension';
        $this->pkgVersion = '_0.0.1-beta';

        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage($this->pkgName, false);
        TestEnv::installPluginPackage($this->pkgName, $this->pkgName.$this->pkgVersion, '/plugins_repo/', false);
    }

    function tearDown()
    {
        TestEnv::uninstallPluginPackage('demoExtension', false);
    }

    function test_genericHtml_class()
    {
        // test the class implementation
        $oComponent = &OX_Component::factory('bannerTypeHtml', 'demoBannerTypeHtml', 'demoHtml');
        // common extension methods
        $this->_assertClass($oComponent, 'bannerTypeHtml', 'demoBannerTypeHtml', 'demoHtml');
        // plugin-specific methods
        $this->assertTrue(method_exists($oComponent, '_buildHtmlTemplate'), $sender.' missing method _buildHtmlTemplate');
        $this->assertTrue(method_exists($oComponent, 'exportData'), $sender.' missing method exportData');

        // generate test data
        $doBanners = OA_Dal::factoryDO('banners');
        $oDG = new DataGenerator();
        $oDG->setData('banners', array('ext_bannertype' => array($oComponent->getComponentIdentifier())));
        $aIds = $oDG->generate($doBanners, 5, false);

        // test the processForm method
        // this method joins the banners and banners_demo tables
        // by creating a banners_demo record where
        // banners_demo.banners_demo_id = banners.bannerid
        foreach ($aIds as $i => $bannerId)
        {
            $aFields['description'] = 'description_'.$bannerId;
            $this->assertTrue($oComponent->processForm(true, $bannerId, $aFields));
            $doBannersDemo = OA_Dal::factoryDO('banners_demo');
            $doBannersDemo->banners_demo_id = $bannerId;
            $this->assertTrue($doBannersDemo->find(true));
            $this->assertEqual($doBannersDemo->banners_demo_desc,$aFields['description']);
        }

        // test the exportData method
        $aTables    = $oComponent->exportData();
        $this->assertIsA($aTables,'array');
        $this->assertEqual(count($aTables),2);
        $prefix     = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $pattern    = '/'.$prefix.'z_'.$oComponent->component.'[\d]{8}_[\d]{6}'.$prefix.'banners/';
        $this->assertPattern($pattern,$aTables[0]);
        $pattern    = '/'.$prefix.'z_'.$oComponent->component.'[\d]{8}_[\d]{6}'.$prefix.'banners_demo/';
        $this->assertPattern($pattern,$aTables[1]);
        $oDbh       = OA_DB::singleton();
        $query      = "SELECT * FROM ".$oDbh->quoteIdentifier($aTables[0]);
        $aResult    = $oDbh->queryAll($query, null, MDB2_FETCHMODE_ASSOC);
        foreach ($aResult as $i => $aFrom)
        {
            $this->assertEqual($aFrom['bannerid'], $aIds[$i]);
        }
        $query      = "SELECT * FROM ".$oDbh->quoteIdentifier($aTables[1]);
        $aResult    = $oDbh->queryAll($query, null, MDB2_FETCHMODE_ASSOC);
        foreach ($aResult as $i => $aFrom)
        {
            $this->assertEqual($aFrom['banners_demo_id'], $aIds[$i]);
        }
    }

    function _assertClass($oComponent, $extension, $group, $plugin)
    {
        $sender = $group.'_'.$plugin;
        $this->assertIsA($oComponent, 'Plugins_'.$extension.'_'.$group.'_'.$plugin, $sender.' invalid class');
        $this->assertIsA($oComponent, 'Plugins_'.$extension.'_'.$group.'_'.$plugin, $sender.' invalid parent class');
        $this->assertTrue(method_exists($oComponent, 'getStorageType'), $sender.' missing method getStorageType');
        $this->assertTrue(method_exists($oComponent, 'getContentType'), $sender.' missing method getContentType');
        $this->assertTrue(method_exists($oComponent, 'getOptionDescription'), $sender.' missing method getOptionDescription');
        $this->assertTrue(method_exists($oComponent, 'buildForm'), $sender.' missing method buildForm');
        $this->assertTrue(method_exists($oComponent, 'validateForm'), $sender.' missing method validateForm');
        $this->assertTrue(method_exists($oComponent, 'preprocessForm'), $sender.' missing method processForm');
        $this->assertTrue(method_exists($oComponent, 'processForm'), $sender.' missing method processForm');
    }
}

?>
