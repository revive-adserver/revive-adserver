<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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


require_once(MAX_PATH.'/lib/OA/Upgrade/Configuration.php');

/**
 * A class for testing the Openads Upgrade Configuration class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class Test_OA_Upgrade_Config extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Upgrade_Config()
    {
        $this->UnitTestCase();
    }

    function test_constructor()
    {
        $oUpConfig = new OA_Upgrade_Config();
        $this->assertIsA($oUpConfig,'OA_Upgrade_Config','class mismatch: OA_Upgrade_Config');
        $this->assertIsA($oUpConfig->aConfig,'array','class mismatch: array');
        $this->assertIsA($oUpConfig->oConfig,'OA_Admin_Config','class mismatch: OA_Admin_Config');
    }

    function test_getInitialConfig()
    {
        $oUpConfig = new OA_Upgrade_Config();
        $oUpConfig->getInitialConfig();
    }

    /**
     * This function checks for any new items in the config dist file
     */
    function test_checkForConfigAdditions()
    {
        $oUpConfig = new OA_Upgrade_Config();
        // First check that the working config file agrees with the dist config file
        $this->assertFalse($oUpConfig->checkForConfigAdditions($new), 'New config items have not been added to test.conf.php');

        // Assert no new items detected when $new === $old
        $new = $oUpConfig->aConfig;
        $this->assertFalse($oUpConfig->checkForConfigAdditions($new), 'New config items mistakenly detected');

        // Add a new item to an existing sub-array
        $new = $oUpConfig->aConfig;
        $new['database']['key'] = 'value';
        $this->assertTrue($oUpConfig->checkForConfigAdditions($new), 'New config items (added to existing sub-array) not detected');

        // Add a completely new empty sub-array
        $new = $oUpConfig->aConfig;
        $new['newSubArray'] = array();
        $this->assertTrue($oUpConfig->checkForConfigAdditions($new), 'New config items (empty sub-array) not detected');

        // Add a new sub-array with a new item
        $new = $oUpConfig->aConfig;
        $new['newSubArray'] = array('key' => 'value');
        $this->assertTrue($oUpConfig->checkForConfigAdditions($new), 'New config items (new sub array with value) not detected');

        // Add a new item not in a sub-array (so top level)
        $new = $oUpConfig->aConfig;
        $new['key'] = 'value';
        $this->assertTrue($oUpConfig->checkForConfigAdditions($new), 'New (top level) config items not detected');

    }
}

?>
