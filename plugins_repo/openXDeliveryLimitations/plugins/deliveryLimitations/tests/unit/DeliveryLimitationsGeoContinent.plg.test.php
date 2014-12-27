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

require_once LIB_PATH . '/Plugin/Component.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Continent.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Continent class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Continent extends UnitTestCase
{
    function setUp()
    {
        $aConf = & $GLOBALS['_MAX']['CONF'];
        $aConf['pluginGroupComponents']['Geo'] = 1;
        $aConf['pluginPaths']['plugins'] = '/plugins_repo/openXDeliveryLimitations/plugins/';
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
        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Geo', 'Continent');
        $oPlugin->init(array('data' => 'EU', 'comparison' => '!~'));

        $this->_assertResourceData();

        $result = $oPlugin->compile();

        $this->assertEqual("MAX_checkGeo_Continent('eu,ad,al,at,ba,be,bg,by,ch,cz,de,dk,ee,es,fi,fo,fr,gb,gi,gr,hr,hu,ie,is,it,li,lt,lu,lv,mc,md,mk,mt,nl,no,pl,pt,ro,ru,se,si,sj,sk,sm,tr,ua,va,rs,me,ax,gg,im,je', '!~')", $result);
    }

    function _assertResourceData()
    {
        $file = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['plugins']."/deliveryLimitations/Geo/Continent.res.inc.php";

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
