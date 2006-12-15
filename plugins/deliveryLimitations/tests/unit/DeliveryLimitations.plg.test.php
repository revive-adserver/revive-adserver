<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: GeoIP.plg.test.php 4405 2006-03-10 10:25:58Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitations.php';

class Dummy_Plugins_DeliveryLimitations extends Plugins_DeliveryLimitations
{
    function getName()
    {
        return 'bla';
    }
}

/**
 * A class for testing the Plugins_DeliveryLimitations class.
 *
 * @package    MaxPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_Test extends UnitTestCase
{
     function Plugins_DeliveryLimitations_TestCase()
    {
        $this->UnitTestCase();
    }

    function testCompile()
    {
        $oPlugin = new Dummy_Plugins_DeliveryLimitations();
        set_magic_quotes_runtime(1);
        $oPlugin->init(array('data' => 'Mozil\\la', 'package' => 'Pkg', 'comparison' => '==', 'name' => 'bla'));
        $this->assertEqual('MAX_checkPkg_bla(\'Mozil\\la\', \'==\')', $oPlugin->compile());
        set_magic_quotes_runtime(0);
        $oPlugin->init(array('data' => 'Mozilla', 'package' => 'Pkg', 'comparison' => '==', 'name' => 'bla'));
        $this->assertEqual('MAX_checkPkg_bla(\\\'Mozilla\\\', \\\'==\\\')', $oPlugin->compile());
        $oPlugin->init(array('data' => 'Mozil\\la', 'package' => 'Pkg', 'comparison' => '==', 'name' => 'bla'));
        $this->assertEqual('MAX_checkPkg_bla(\\\'Mozil\\\\la\\\', \\\'==\\\')', $oPlugin->compile());
    }
}