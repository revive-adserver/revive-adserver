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
require_once MAX_PATH . '/plugins/deliveryLimitations/tests/unit/DeliveryLimitationsTestCase.plg.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/Client/Language.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Language class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Language extends Plugins_DeliveryLimitations_TestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Client_Language()
    {
        $this->Plugins_DeliveryLimitations_TestCase();
    }

    /**
     * A method to test the _getSqlLimitation() method.
     */
    function test_getSqlLimitation()
    {
        $oDbh = OA_DB::singleton();
        if ($oDbh->dbsyntax == 'pgsql') {
            $regexp = '~';
            $not_regexp = '!~';
        } else {
            $regexp = 'REGEXP';
            $not_regexp = 'NOT REGEXP';
        }

        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Client', 'Language');
        $result = $oPlugin->_getSqlLimitation('=~', 'en-gb');
        $this->assertEqual($result, "LOWER(language) {$regexp} ('(en-gb)')");
        $result = $oPlugin->_getSqlLimitation('!~', 'en-gb,foo');
        $this->assertEqual($result, "LOWER(language) {$not_regexp} ('(en-gb)|(foo)')");
    }

    function testOverlap()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Client', 'Language');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew

        $this->checkOverlapFalse($oPlugin, '=~', 'en', '=~', 'pl');
        $this->checkOverlapTrue($oPlugin, '=~', 'en,pl', '=~', 'pl,fr');
        $this->checkOverlapFalse($oPlugin, '=~', 'en,pl', '=~', 'en-us,fr');
        $this->checkOverlapFalse($oPlugin, '!~', 'en', '=~', 'en');
        $this->checkOverlapFalse($oPlugin, '!~', 'en,pl', '=~', 'en,pl');
        $this->checkOverlapTrue($oPlugin, '!~', 'en,pl', '=~', 'en,en-us,fr');
        $this->checkOverlapTrue($oPlugin, '!~', 'en,pl', '!~', 'en,en-us,fr');
    }

    function testMAX_checkClient_Language()
    {
        $this->assertTrue(MAX_checkClient_Language('en', '=~', array('language' => 'en')));
        $this->assertFalse(MAX_checkClient_Language('en', '!~', array('language' => 'en')));
        $this->assertTrue(MAX_checkClient_Language('en,pl,fr,de', '=~', array('language' => 'en')));
        $this->assertTrue(MAX_checkClient_Language('en,pl,fr,de', '=~', array('language' => 'jp,en')));
        $this->assertFalse(MAX_checkClient_Language('en,pl,fr,de', '=~', array('language' => 'jp,en-us')));
        $this->assertTrue(MAX_checkClient_Language('en', '=~', array('language' => 'jp,en')));
        $GLOBALS['_MAX']['CLIENT']['language'] = 'en-us,en,pl';
        $this->assertFalse(MAX_checkClient_Language('af', '=~'));
        $this->assertTrue(MAX_checkClient_Language('af,pl', '=~'));
        unset($GLOBALS['_MAX']['CLIENT']['language']);
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'pl-PL,pl;q=0.9,en;q=0.8';
        $this->assertFalse(MAX_checkClient_Language('fr', '=~'));
        $this->assertTrue(MAX_checkClient_Language('pl', '=~'));
        $this->assertFalse(MAX_checkClient_Language('pl', '!~'));
    }
}

?>
