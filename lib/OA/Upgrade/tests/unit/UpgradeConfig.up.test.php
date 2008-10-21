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


require_once(MAX_PATH.'/lib/OA/Upgrade/Configuration.php');

/**
 * A class for testing the OpenX Upgrade Configuration class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
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
        $this->assertIsA($oUpConfig->oSettings,'OA_Admin_Settings','class mismatch: OA_Admin_Settings');
    }

    function test_setupConfigDatabase()
    {
        $oUpConfig = new OA_Upgrade_Config();

        $aConfig['username'] = 'myname';
        $aConfig['password'] = 'mypass';
        $aConfig['name'] = 'mydb';
        $aConfig['persistent'] = '0';
        $aConfig['mysql4_compatibility'] = '0';

        $aConfig['type'] = 'mysql';

        $aConfig['host'] = 'localhost';
        $aConfig['socket'] = '';
        $aConfig['port'] = '3306';
        $aConfig['protocol'] = 'tcp';
        $oUpConfig->setupConfigDatabase($aConfig);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['type']     , $aConfig['type']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['protocol'] , $aConfig['protocol']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['host']     , $aConfig['host']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['socket']   , $aConfig['socket']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['port']     , $aConfig['port']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['username'] , $aConfig['username']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['password'] , $aConfig['password']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['name']     , $aConfig['name']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['persistent'] , $aConfig['persistent']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['mysql4_compatibility'] , $aConfig['mysql4_compatibility']);

        $aConfig['host'] = '';
        $aConfig['socket'] = '';
        $aConfig['port'] = '';
        $aConfig['protocol'] = 'unix';
        $oUpConfig->setupConfigDatabase($aConfig);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['type']     , $aConfig['type']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['protocol'] , $aConfig['protocol']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['host']     , 'localhost');
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['socket']   , $aConfig['socket']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['port']     , '3306');
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['username'] , $aConfig['username']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['password'] , $aConfig['password']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['name']     , $aConfig['name']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['persistent'] , $aConfig['persistent']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['mysql4_compatibility'] , $aConfig['mysql4_compatibility']);

        $aConfig['host'] = '';
        $aConfig['socket'] = '/var/lib/mysql/mysql.sock';
        $aConfig['port'] = '';
        $aConfig['protocol'] = 'unix';
        $oUpConfig->setupConfigDatabase($aConfig);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['type']     , $aConfig['type']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['protocol'] , $aConfig['protocol']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['host']     , 'localhost');
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['socket']   , $aConfig['socket']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['port']     , '3306');
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['username'] , $aConfig['username']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['password'] , $aConfig['password']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['name']     , $aConfig['name']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['persistent'] , $aConfig['persistent']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['mysql4_compatibility'] , $aConfig['mysql4_compatibility']);

        $aConfig['type'] = 'pgsql';

        $aConfig['host'] = 'localhost';
        $aConfig['socket'] = '';
        $aConfig['port'] = '5432';
        $aConfig['protocol'] = 'tcp';
        $oUpConfig->setupConfigDatabase($aConfig);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['type']     , $aConfig['type']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['protocol'] , $aConfig['protocol']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['host']     , $aConfig['host']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['socket']   , $aConfig['socket']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['port']     , $aConfig['port']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['username'] , $aConfig['username']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['password'] , $aConfig['password']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['name']     , $aConfig['name']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['persistent'] , $aConfig['persistent']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['mysql4_compatibility'] , $aConfig['mysql4_compatibility']);

        $aConfig['host'] = '';
        $aConfig['socket'] = '';
        $aConfig['port'] = '';
        $aConfig['protocol'] = 'unix';
        $oUpConfig->setupConfigDatabase($aConfig);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['type']     , $aConfig['type']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['protocol'] , $aConfig['protocol']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['host']     , 'localhost');
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['socket']   , $aConfig['socket']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['port']     , '5432');
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['username'] , $aConfig['username']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['password'] , $aConfig['password']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['name']     , $aConfig['name']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['persistent'] , $aConfig['persistent']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['mysql4_compatibility'] , $aConfig['mysql4_compatibility']);

        $aConfig['host'] = '';
        $aConfig['socket'] = '/tmp/pgsql.sock';
        $aConfig['port'] = '';
        $aConfig['protocol'] = 'unix';
        $oUpConfig->setupConfigDatabase($aConfig);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['type']     , $aConfig['type']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['protocol'] , $aConfig['protocol']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['host']     , 'localhost');
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['socket']   , $aConfig['socket']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['port']     , '5432');
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['username'] , $aConfig['username']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['password'] , $aConfig['password']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['name']     , $aConfig['name']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['persistent'] , $aConfig['persistent']);
        $this->assertEqual($oUpConfig->oSettings->aConf['database']['mysql4_compatibility'] , $aConfig['mysql4_compatibility']);
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
        $this->assertFalse($oUpConfig->checkForConfigAdditions($new), 'New config items have NOT been added to working test.conf.php');

        // Assert no new items detected when $new === $old
        $new = $oUpConfig->aConfig;
        $this->assertFalse($oUpConfig->checkForConfigAdditions($new), 'New dist.conf.php items mistakenly detected');

        // Add a new item to an existing sub-array
        $new = $oUpConfig->aConfig;
        $new['database']['key'] = 'value';
        $this->assertTrue($oUpConfig->checkForConfigAdditions($new), 'New dist.conf.php items (added to existing section) not detected');

        // Add a completely new empty sub-array
        $new = $oUpConfig->aConfig;
        $new['newSubArray'] = array();
        $this->assertTrue($oUpConfig->checkForConfigAdditions($new), 'New dist.conf.php items (empty section) not detected');

        // Add a new sub-array with a new item
        $new = $oUpConfig->aConfig;
        $new['newSubArray'] = array('key' => 'value');
        $this->assertTrue($oUpConfig->checkForConfigAdditions($new), 'New dist.conf.php items (new section with value) not detected');

        // Add a new item not in a sub-array (so top level)
        $new = $oUpConfig->aConfig;
        $new['key'] = 'value';
        $this->assertTrue($oUpConfig->checkForConfigAdditions($new), 'New (top level) dist.conf.php items not detected');

    }
}

?>
