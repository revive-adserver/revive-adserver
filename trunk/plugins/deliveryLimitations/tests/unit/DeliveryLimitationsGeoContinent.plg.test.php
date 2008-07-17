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

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/Geo/Continent.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Continent class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Continent extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Geo_Continent()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the _getSqlLimitation() method.
     */
    function test_getSqlLimitation()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'Continent');
        $oPlugin->init(array());
        $result = $oPlugin->_getSqlLimitation('=~', 'AF');
        $this->assertEqual($result, "LOWER(country) IN ('zw','zr','zm','eh','ug','tn','tg','tz','sz','sd','za','so','sl','sc','sn','st','rw','re','ng','ne','na','mz','ma','yt','mu','mr','ml','mw','mg','ly','lr','ls','ke','hm','gw','gn','gh','et','ci','gm','ga','tf','er','gq','eg','cd','cg','km','td','cf','cv','cm','bi','bf','bv','bw','bj','ao','dz')");
        $result = $oPlugin->_getSqlLimitation('!~', 'AF,EU');
        $this->assertEqual($result, "LOWER(country) NOT IN ('zw','zr','zm','eh','ug','tn','tg','tz','sz','sd','za','so','sl','sc','sn','st','rw','re','ng','ne','na','mz','ma','yt','mu','mr','ml','mw','mg','ly','lr','ls','ke','hm','gw','gn','gh','et','ci','gm','ga','tf','er','gq','eg','cd','cg','km','td','cf','cv','cm','bi','bf','bv','bw','bj','ao','dz','eu','yu','gb','uk','ua','ch','se','sj','es','si','sk','sm','ru','ro','pt','pl','no','nl','mc','md','mt','mk','lu','lt','li','lv','it','ie','is','hu','va','gr','gi','de','ge','fx','fr','fi','fo','ee','dk','cz','cy','hr','bg','ba','be','by','at','am','ad','al')");
    }


    function test_checkGeoContinent()
    {
        $this->assertTrue(MAX_checkGeo_Continent('af,pl', '=~', array('country_code' => 'pl')));
    }


    function test_compile()
    {
        $current_quotes_runtime = get_magic_quotes_runtime();
        set_magic_quotes_runtime(1);

        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'Continent');
        $oPlugin->init(array('data' => 'EU', 'comparison' => '!~'));
        $result = $oPlugin->compile();
        $this->assertEqual("MAX_checkGeo_Continent('eu,yu,gb,uk,ua,ch,se,sj,es,si,sk,sm,ru,ro,pt,pl,no,nl,mc,md,mt,mk,lu,lt,li,lv,it,ie,is,hu,va,gr,gi,de,ge,fx,fr,fi,fo,ee,dk,cz,cy,hr,bg,ba,be,by,at,am,ad,al', '!~')", $result);

        set_magic_quotes_runtime($current_quotes_runtime);
    }

}

?>
