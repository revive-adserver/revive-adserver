<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * A class for testing the openXMarket DataObjects
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_TestOfPDataObjects_Ext_market_website_pref extends UnitTestCase
{
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::uninstallPluginPackage('openXMarket', false);
    }
    
    function testGetRegisteredWebsitesIds(){
        $plgManager = new OX_PluginManager();
        $info = $plgManager->getPackageInfo('openXMarket');
        if (version_compare($info['version'],'1.0.0-dev','>'))
        {
            $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
            $aResult = $doWebsite->getRegisteredWebsitesIds();
            $expected = array();
            $this->assertEqual($expected, $aResult);
            
            // Prepare data
            
            $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
            $doWebsite->affiliateid = 1;
            $doWebsite->website_id = 'my-uuid1';
            DataGenerator::generateOne($doWebsite);
            $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
            $doWebsite->affiliateid = 2;
            $doWebsite->website_id = 'my-uuid2';
            DataGenerator::generateOne($doWebsite);
            $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
            $doWebsite->affiliateid = 3;
            $doWebsite->website_id = 'my-uuid3';
            DataGenerator::generateOne($doWebsite);
    
            $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
            $aResult = $doWebsite->getRegisteredWebsitesIds();
            $expected = array('my-uuid1', 'my-uuid2', 'my-uuid3');
            $this->assertEqual($expected, $aResult);
        }
    }

}

?>
