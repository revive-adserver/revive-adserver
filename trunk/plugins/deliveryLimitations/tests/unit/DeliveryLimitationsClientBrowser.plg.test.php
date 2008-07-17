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
require_once MAX_PATH . '/plugins/deliveryLimitations/Client/Browser.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Browser class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Browser extends Plugins_DeliveryLimitations_TestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Client_Browser()
    {
        $this->Plugins_DeliveryLimitations_TestCase();
    }


    function testMAX_checkClient_Browser()
    {
        $GLOBALS['_MAX']['CLIENT']['browser'] = 'FF';
        $this->assertFalse(MAX_checkClient_Browser('LX,LI', '=~'));
        $this->assertTrue(MAX_checkClient_Browser('LX,FF', '=~'));
    }


    function testOverlap()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Client', 'Browser');

        $this->checkOverlapFalse($oPlugin, '==', 'IE', '==', 'FF');
        $this->checkOverlapTrue($oPlugin, '==', 'FF,IE', '==', 'IE,FF');
        $this->checkOverlapFalse($oPlugin, '==', 'NS,IE', '==', 'FF,OP');
        $this->checkOverlapFalse($oPlugin, '!=', 'NS', '==', 'NS');
        $this->checkOverlapTrue($oPlugin, '!=', 'NS', '==', 'NS,IE');
        $this->checkOverlapTrue($oPlugin, '!=', 'NS', '!=', 'NS,IE');
        $this->checkOverlapTrue($oPlugin, '!=', 'NS,IE,FF,OP', '!=', 'IE');
    }
}
?>
