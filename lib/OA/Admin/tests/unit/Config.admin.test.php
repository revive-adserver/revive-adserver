<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

require_once MAX_PATH . '/lib/OA/Admin/Config.php';

Class Test_OA_Admin_Config extends UnitTestCase
{
    function testIsConfigWritable()
    {
        $oConf = new OA_Admin_Config(true);

        // 1) Test we can write to an existing file.
        $path = '/tmp';
        $filename = 'oa_test_' . rand() . '.conf.php';
        $fp = fopen($path . '/' . $filename, 'w');
        fwrite($fp, 'foo');
        fclose($fp);
        $this->assertTrue($oConf->isConfigWritable($path . '/' . $filename));
        unlink($path . '/' . $filename);

        // 2) A non-existing file in an unwriteable location.
        $this->assertFalse($oConf->isConfigWritable('/non_existent_dir/non_existent_file'));

        // 3) An existing file we don't have write permission for.
        $path = '/tmp';
        $filename = 'oa_test_' . rand() . '.conf.php';
        $fp = fopen($path . '/' . $filename, 'w');
        fwrite($fp, 'foo');
        chmod($path . '/' . $filename, 0200);
        fclose($fp);
        $this->assertFalse($oConf->isConfigWritable('/non_existent_dir/non_existent_file'));
        unlink($path . '/' . $filename);

        // 4) An empty directory we can write to.
        $this->assertTrue($oConf->isConfigWritable('/tmp/non_existent_file'));

        // 5) An empty directory we cannot write to.
        $dirname = 'oa_test_' . rand();
        mkdir('/tmp/' . $dirname, 0500);
        $this->assertFalse($oConf->isConfigWritable('/tmp/' . $dirname . '/non_existent_file'));
        rmdir('/tmp/' . $dirname);
    }

    function testSetBulkConfigChange()
    {
        $oConf = new OA_Admin_Config(true);
        $oConf->setBulkConfigChange('foo', array('one' => 'bar', 'two' => 'baz'));
        $expected = array('foo' => array('one' => 'bar', 'two' => 'baz'));
        $this->assertEqual($expected, $oConf->conf);
    }

    function testSetConfigChange()
    {
        $oConf = new OA_Admin_Config(true);
        $oConf->setConfigChange('group', 'item', 'value');
        $expected = array('group' => array('item' => 'value'));
        $this->assertEqual($expected, $oConf->conf);
    }

    /**
     * 1. Tests a config file is written out correctly.
     * 2. Tests correct use of "dummy" and "real" config files.
     */
    function testWriteConfigChange()
    {
        // Test 1.
        $oConf = new OA_Admin_Config(true);

        // Build the local conf array manually.
        $oConf->conf['foo'] = array('one' => 'bar', 'two' => 'baz');
        $oConf->conf['webpath']['admin'] = 'localhost';
        $oConf->conf['webpath']['delivery'] = 'localhost';
        $oConf->conf['webpath']['deliverySSL'] = 'localhost';
        $filename = 'oa_test_' . rand();
        $this->assertTrue($oConf->writeConfigChange('/tmp', $filename), 'Error writing config file');

        // The new config file will have been reparsed so global conf should have correct values.
        $oNewConf = new OA_Admin_Config();
        $this->assertEqual($oConf->conf, $oNewConf->conf);

        // Clean up
        unlink('/tmp/localhost.' . $filename . '.conf.php');
        unset($oNewConf);

        // Test 2.
        // Write out a new "single host" config file
        $oConf = new OA_Admin_Config(true);

        // Build the local conf array manually.
        $oConf->conf['webpath']['admin'] = 'dummy';
        $oConf->conf['webpath']['delivery'] = 'dummy';
        $oConf->conf['webpath']['deliverySSL'] = 'dummy';
        $this->assertTrue($oConf->writeConfigChange('/tmp'), 'Error writing config file');
        $this->assertTrue(file_exists('/tmp/dummy.conf.php'), 'Config file does not exist');

        // Modify delivery settings to a different host
        $oConf->conf['webpath']['delivery'] = 'delivery';
        $oConf->conf['webpath']['deliverySSL'] = 'delivery';
        $this->assertTrue($oConf->writeConfigChange('/tmp'), 'Error writing config file');
        $this->assertTrue(file_exists('/tmp/dummy.conf.php'), 'Dummy config file does not exist');
        $this->assertTrue(file_exists('/tmp/delivery.conf.php'), 'Real config file does not exist');

        // Test both config files are correct
        $aRealConfig = parse_ini_file('/tmp/delivery.conf.php', true);
        $aDummyConfig = parse_ini_file('/tmp/dummy.conf.php', true);
        $this->assertEqual($oConf->conf, $aRealConfig, 'Real config has incorrect values');
        $aExpected = array('realConfig' => 'delivery');
        $this->assertEqual($aExpected, $aDummyConfig, 'Dummy config has incorrect values');

        // Modify the delivery to use three different hosts
        $oConf->conf['webpath']['delivery'] = 'newhost';
        $oConf->conf['webpath']['deliverySSL'] = 'newSSLhost';
        $this->assertTrue($oConf->writeConfigChange('/tmp'), 'Error writing config file');

        // Test the files have been correctly created/deleted
        $this->assertTrue(file_exists('/tmp/dummy.conf.php'), 'Dummy admin config file does not exist');
        $this->assertTrue(file_exists('/tmp/newhost.conf.php'), 'Real config file does not exist');
        $this->assertTrue(file_exists('/tmp/newSSLhost.conf.php'), 'Dummy SSL delivery file does not exist');
        $this->assertFalse(file_exists('/tmp/delivery.conf.php'), 'Old real config file was not removed');

        // Test config files are correct
        $aRealConfig = parse_ini_file('/tmp/newhost.conf.php', true);
        $aDummyAdminConfig = parse_ini_file('/tmp/dummy.conf.php', true);
        $aDummySSLConfig = parse_ini_file('/tmp/newSSLhost.conf.php', true);
        $this->assertEqual($oConf->conf, $aRealConfig, 'Real config has incorrect values');
        $aExpected = array('realConfig' => 'newhost');
        $this->assertEqual($aExpected, $aDummyAdminConfig, 'Dummy admin config has incorrect values');
        $this->assertEqual($aExpected, $aDummySSLConfig, 'Dummy SSL config has incorrect values');

        // Clean up
        unlink('/tmp/dummy.conf.php');
        @unlink('/tmp/delivery.conf.php'); // File should have been cleaned up by test.
        unlink('/tmp/newhost.conf.php');
        unlink('/tmp/newSSLhost.conf.php');
    }

    function testMergeConfigChanges()
    {
        // Build a test dist.conf.php
        $oDistConf = new OA_Admin_Config(true);

        $oDistConf->conf['foo'] = array('one' => 'bar', 'two' => 'baz', 'new' => 'additional_value');
        $oDistConf->conf['webpath']['admin'] = 'disthost';
        $oDistConf->conf['webpath']['delivery'] = 'disthost';
        $oDistConf->conf['webpath']['deliverySSL'] = 'disthost';
        $oDistConf->conf['new'] = array('new_key' => 'new_value');

        $distFilename = 'oa_test_dist' . rand();
        $this->assertTrue($oDistConf->writeConfigChange('/tmp', $distFilename, false), 'Error writing config file');

        // Build a test user conf
        $oUserConf = new OA_Admin_Config(true);

        $oUserConf->conf['foo'] = array('one' => 'bar', 'two' => 'baz', 'old' => 'old_value');
        $oUserConf->conf['deprecated'] = array('old_key' => 'old_value');
        $oUserConf->conf['webpath']['admin'] = 'localhost';
        $oUserConf->conf['webpath']['delivery'] = 'localhost';
        $oUserConf->conf['webpath']['deliverySSL'] = 'localhost';

        $userFilename = 'oa_test_user' . rand();
        $this->assertTrue($oUserConf->writeConfigChange('/tmp', $userFilename), 'Error writing config file');

        $expected = array('foo' => array('one' => 'bar',
                                         'two' => 'baz',
                                         'new' => 'additional_value'),
                          'webpath' => array('admin' => 'localhost',
                                             'delivery' => 'localhost',
                                             'deliverySSL' => 'localhost'),
                          'new' => array('new_key' => 'new_value'));

        $this->assertEqual($expected, $oUserConf->mergeConfigChanges('/tmp/disthost.' . $distFilename . '.conf.php'),
            'Config files don\'t match');

        // Clean up
        unlink('/tmp/disthost.' . $distFilename . '.conf.php');
        unlink('/tmp/localhost.' . $userFilename . '.conf.php');
    }

    /**
     * Tests the config file is backed up.
     *
     */
    function testBackupConfig()
    {
        $oConfig = new OA_Admin_Config(true);

        $originalFilename = 'oa_test_' . rand() . '.conf.php';
        $directory = '/tmp';
        touch($directory . '/' . $originalFilename);
        $now = date("Ymd");
        $expected = $now.'_old.' . $originalFilename;
        $this->assertTrue($oConfig->backupConfig($directory . '/' . $originalFilename));
        $this->assertTrue(file_exists($directory . '/' . $expected));

        $this->assertTrue($oConfig->backupConfig($directory . '/' . $originalFilename));
        $expected0 = $now.'_0_old.' . $originalFilename;
        $this->assertTrue(file_exists($directory . '/' . $expected0));

        $this->assertTrue($oConfig->backupConfig($directory . '/' . $originalFilename));
        $expected1 = $now.'_1_old.' . $originalFilename;
        $this->assertTrue(file_exists($directory . '/' . $expected1));

        // Clean up
        unlink('/tmp/' . $originalFilename);
        unlink('/tmp/' . $expected);
        unlink('/tmp/' . $expected0);
        unlink('/tmp/' . $expected1);

        // Test a .ini file
        $originalFilename = 'oa_test_' . rand() . '.conf.ini';
        $directory = '/tmp';
        touch($directory . '/' . $originalFilename);
        $now = date("Ymd");
        $expected = $now.'_old.' . $originalFilename.'.php';
        $this->assertTrue($oConfig->backupConfig($directory . '/' . $originalFilename));
        $this->assertTrue(file_exists($directory . '/' . $expected));
        $this->assertEqual(';<'.'?php exit; ?>'."\r\n", file_get_contents($directory . '/' . $expected));

        // Clean up
        unlink('/tmp/' . $originalFilename);
        unlink('/tmp/' . $expected);
    }

    /**
     * Tests the correct backup filename is generated.
     *
     */
    function test_getBackupFilename()
    {
        // Test when backup filename doesn't already exist.
        $originalFilename = 'oa_test_' . rand() . '.conf.php';
        $directory = '/tmp';
        $now = date("Ymd");
        touch($directory . '/' . $originalFilename);
        $expected = $now.'_old.' . $originalFilename;
        $this->assertEqual($expected, OA_Admin_Config::_getBackupFilename($directory . '/' . $originalFilename),
            'Filenames don\'t match');

        // Test when backup filename already exists.
        $existingBackupFile = $expected;
        touch($directory . '/' . $existingBackupFile);
        //$expected = $existingBackupFile . '_0';
        $expected0 = $now.'_0_old.' . $originalFilename;
        $this->assertEqual($expected0, OA_Admin_Config::_getBackupFilename($directory . '/' . $originalFilename),
            'Filenames don\'t match');

         // Clean up
        unlink($directory . '/' . $originalFilename);
        unlink($directory . '/' . $existingBackupFile);


        // Test when .ini backup filename doesn't already exist.
        $originalFilename = 'oa_test_' . rand() . '.conf.ini';
        $directory = '/tmp';
        $now = date("Ymd");
        touch($directory . '/' . $originalFilename);
        $expected = $now.'_old.' . $originalFilename.'.php';
        $this->assertEqual($expected, OA_Admin_Config::_getBackupFilename($directory . '/' . $originalFilename),
            'Filenames don\'t match');

         // Clean up
        unlink($directory . '/' . $originalFilename);
    }
}

?>