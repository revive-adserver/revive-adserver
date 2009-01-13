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
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Continent.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Continent class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Continent extends UnitTestCase
{
    function setUp()
    {
        $aConf = & $GLOBALS['_MAX']['CONF'];
        $aConf['pluginGroupComponents']['Geo'] = 1;
        $aConf['pluginPaths']['extensions'] = '/plugins_repo/openXDeliveryLimitations/extensions/';
        unset($GLOBALS['_MAX']['_GEOCACHE']['continent']);
    }

    function tearDown()
    {
        TestEnv::restoreConfig();
    }

    function test_checkGeoContinent()
    {
        $this->assertTrue(MAX_checkGeo_Continent('af,pl', '=~', array('country_code' => 'pl')));
    }

    function test_getRes()
    {
        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Geo', 'Continent');

        $aResult = $oPlugin->_getRes();

        $this->_assertResourceData();

        $this->assertIsA($aResult,'array');
        $this->assertTrue(count($aResult)>0);

    }

    function test_compile()
    {
        $current_quotes_runtime = get_magic_quotes_runtime();
        set_magic_quotes_runtime(1);

        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Geo', 'Continent');
        $oPlugin->init(array('data' => 'EU', 'comparison' => '!~'));

        $this->_assertResourceData();

        $result = $oPlugin->compile();

        $this->assertEqual("MAX_checkGeo_Continent('eu,yu,gb,uk,ua,ch,se,sj,es,si,sk,sm,ru,ro,pt,pl,no,nl,mc,md,mt,mk,lu,lt,li,lv,it,ie,is,hu,va,gr,gi,de,ge,fx,fr,fi,fo,ee,dk,cz,cy,hr,bg,ba,be,by,at,am,ad,al', '!~')", $result);

        set_magic_quotes_runtime($current_quotes_runtime);
    }

    function _assertResourceData()
    {
        $file = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['extensions']."/deliveryLimitations/Geo/Continent.res.inc.php";

        $this->assertTrue(file_exists($file), 'Resource file does not exist '.$file);
        $this->assertTrue(is_readable($file), 'Resource file does is not readable '.$file);

        global $OA_Geo_continent, $OA_Geo_cont_name;

        $this->assertIsA($OA_Geo_continent,'array', 'Global continent array invalid type');
        $this->assertTrue(count($OA_Geo_continent)>0, 'Global continent array empty');

        $this->assertIsA($OA_Geo_cont_name,'array', 'Global continent name array invalid type');
        $this->assertTrue(count($OA_Geo_cont_name)>0, 'Global continent name array is empty');
    }

}

?>
