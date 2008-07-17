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

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Browser class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_TestCase extends UnitTestCase
{

     function Plugins_DeliveryLimitations_TestCase()
    {
        $this->UnitTestCase();
    }

    function checkOverlap(&$oPlugin, $comparison1, $data1, $comparison2, $data2, $expect)
    {
        $aLimitation1 = array(
            'comparison' => $comparison1,
            'data'       => $data1
        );
        $aLimitation2 = array(
            'comparison' => $comparison2,
            'data'       => $data2
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, $expect, "($comparison1;$data1) | ($comparison2;$data2)");
        $result = $oPlugin->overlap($aLimitation2, $aLimitation1);
        $this->assertEqual($result, $expect, "($comparison1;$data1) | ($comparison2;$data2)");
    }

    function checkOverlapTrue(&$oPlugin, $comparison1, $data1, $comparison2, $data2)
    {
        $this->checkOverlap($oPlugin, $comparison1, $data1, $comparison2, $data2, true);
    }

    function checkOverlapFalse(&$oPlugin, $comparison1, $data1, $comparison2, $data2)
    {
        $this->checkOverlap($oPlugin, $comparison1, $data1, $comparison2, $data2, false);
    }
}

?>
