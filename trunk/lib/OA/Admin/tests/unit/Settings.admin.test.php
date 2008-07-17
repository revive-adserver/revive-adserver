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

require_once MAX_PATH . '/lib/OA/Admin/Settings.php';

Class Test_OA_Admin_Settings extends UnitTestCase
{
    var $basePath;

    function Test_OA_Admin_Settings()
    {
        $this->basePath = MAX_PATH . '/var/cache';
    }

    function testIsConfigWritable()
    {
        $oConf = new OA_Admin_Settings(true);

        // 1) Test we can write to an existing file.
        $path = $this->basePath;
        $filename = 'oa_test_' . rand() . '.conf.php';
        $fp = fopen($path . '/' . $filename, 'w');
        fwrite($fp, 'foo');
        fclose($fp);
        $this->assertTrue($oConf->isConfigWritable($path . '/' . $filename));
        unlink($path . '/' . $filename);

        // 2) A non-existing file in an unwriteable location.
        $this->assertFalse($oConf->isConfigWritable($this->basePath . '/non_existent_dir/non_existent_file'));

        /**
         * @todo Test fails when running the test as root
         */
        // 3) An existing file we don't have write permission for.
        $path = $this->basePath;
        $filename = 'oa_test_' . rand() . '.conf.php';
        $fp = fopen($path . '/' . $filename, 'w');
        fwrite($fp, 'foo');
        fclose($fp);
        chmod($path . '/' . $filename, 0400);
        $this->assertFalse($oConf->isConfigWritable($path . '/' . $filename));
        chmod($path . '/' . $filename, 0700);
        unlink($path . '/' . $filename);

        // 4) An empty directory we can write to.
        $this->assertTrue($oConf->isConfigWritable($this->basePath . '/non_existent_file'));

        /**
         * @todo Test fails when running the test as root or on Windows
         */
        // 5) An empty directory we cannot write to.
        $path = $this->basePath;
        $dirname = 'oa_test_' . rand();
        mkdir($path . '/'. $dirname);
        chmod($path . '/'. $dirname, 0000);
        $this->assertFalse($oConf->isConfigWritable($path . '/'. $dirname . '/non_existent_file'));
        chmod($path . '/'. $dirname, 0700);
        rmdir($path . '/'. $dirname);
    }

    function testBulkSettingChange()
    {
        $oConf = new OA_Admin_Settings(true);
        $oConf->bulkSettingChange('foo', array('one' => 'bar', 'two' => 'baz'));
        $expected = array('foo' => array('one' => 'bar', 'two' => 'baz'));
        $this->assertEqual($expected, $oConf->aConf);
    }

    function testSettingChange()
    {
        $oConf = new OA_Admin_Settings(true);
        $oConf->settingChange('group', 'item', 'value');
        $expected = array('group' => array('item' => 'value'));
        $this->assertEqual($expected, $oConf->aConf);
    }

    /**
     * 1. Tests a config file is written out correctly.
     * 2. Tests correct use of "dummy" and "real" config files.
     */
    function testWriteConfigChange()
    {
        // Test 1.
        $oConf = new OA_Admin_Settings(true);

        // Build the local conf array manually.
        $oConf->aConf['foo'] = array('one' => 'bar', 'two' => 'baz');
        $oConf->aConf['webpath']['admin'] = 'localhost';
        $oConf->aConf['webpath']['delivery'] = 'localhost';
        $oConf->aConf['webpath']['deliverySSL'] = 'localhost';
        $filename = 'oa_test_' . rand();
        $this->assertTrue($oConf->writeConfigChange($this->basePath, $filename), 'Error writing config file');

        // The new config file will have been reparsed so global conf should have correct values.
        $oNewConf = new OA_Admin_Settings();
        $this->assertEqual($oConf->conf, $oNewConf->conf);

        // Clean up
        unlink($this->basePath . '/localhost.' . $filename . '.conf.php');
        unset($oNewConf);

        // Test 2.0
        // Write out a new "single host" config file
        $oConf = new OA_Admin_Settings(true);

        // Build the local conf array manually.
        $oConf->aConf['webpath']['admin'] = 'dummy';
        $oConf->aConf['webpath']['delivery'] = 'dummy';
        $oConf->aConf['webpath']['deliverySSL'] = 'dummy';
        $this->assertTrue($oConf->writeConfigChange($this->basePath), 'Error writing config file');
        $this->assertTrue(file_exists($this->basePath . '/dummy.conf.php'), 'Config file does not exist');

        // Modify delivery settings to a different host
        $oConf->aConf['webpath']['delivery'] = 'delivery';
        $oConf->aConf['webpath']['deliverySSL'] = 'delivery';
        $this->assertTrue($oConf->writeConfigChange($this->basePath), 'Error writing config file');
        $this->assertTrue(file_exists($this->basePath . '/dummy.conf.php'), 'Dummy config file does not exist');
        $this->assertTrue(file_exists($this->basePath . '/delivery.conf.php'), 'Real config file does not exist');

        // Test both config files are correct
        $aRealConfig = parse_ini_file($this->basePath . '/delivery.conf.php', true);
        $aDummyConfig = parse_ini_file($this->basePath . '/dummy.conf.php', true);
        $this->assertEqual($oConf->aConf, $aRealConfig, 'Real config has incorrect values');
        $aExpected = array('realConfig' => 'delivery');
        $this->assertEqual($aExpected, $aDummyConfig, 'Dummy config has incorrect values');

        // Modify the delivery to use three different hosts
        $oConf->aConf['webpath']['delivery'] = 'newhost';
        $oConf->aConf['webpath']['deliverySSL'] = 'newSSLhost';
        $this->assertTrue($oConf->writeConfigChange($this->basePath), 'Error writing config file');

        // Test the files have been correctly created/deleted
        $this->assertTrue(file_exists($this->basePath . '/dummy.conf.php'), 'Dummy admin config file does not exist');
        $this->assertTrue(file_exists($this->basePath . '/newhost.conf.php'), 'Real config file does not exist');
        $this->assertTrue(file_exists($this->basePath . '/newSSLhost.conf.php'), 'Dummy SSL delivery file does not exist');
        $this->assertFalse(file_exists($this->basePath . '/delivery.conf.php'), 'Old real config file was not removed');

        // Test config files are correct
        $aRealConfig = parse_ini_file($this->basePath . '/newhost.conf.php', true);
        $aDummyAdminConfig = parse_ini_file($this->basePath . '/dummy.conf.php', true);
        $aDummySSLConfig = parse_ini_file($this->basePath . '/newSSLhost.conf.php', true);
        $this->assertEqual($oConf->aConf, $aRealConfig, 'Real config has incorrect values');
        $aExpected = array('realConfig' => 'newhost');
        $this->assertEqual($aExpected, $aDummyAdminConfig, 'Dummy admin config has incorrect values');
        $this->assertEqual($aExpected, $aDummySSLConfig, 'Dummy SSL config has incorrect values');

        // File should have been cleaned up by test.
        $this->assertFalse(file_exists(($this->basePath . '/delivery.conf.php')));

        // Clean up
        unlink($this->basePath . '/dummy.conf.php');
        unlink($this->basePath . '/default.' . $filename . '.conf.php');
        unlink($this->basePath . '/newhost.conf.php');
        unlink($this->basePath . '/newSSLhost.conf.php');
    }

    /**
     * Check that the mechanism to detect unrecognised config files works as expected
     *
     */
    function test_findOtherConfigFiles()
    {
        // Test 1.
        $oConf = new OA_Admin_Settings(true);

        // Build the local conf array manually.
        $oConf->aConf['foo'] = array('one' => 'bar', 'two' => 'baz');
        $oConf->aConf['webpath']['admin'] = 'localhost2';
        $oConf->aConf['webpath']['delivery'] = 'localhost';
        $oConf->aConf['webpath']['deliverySSL'] = 'localhost3';
        $filename = 'oa_test_' . rand();
        $folder = $this->basePath . '/oa_test_' . rand();
        mkdir($folder);
        $this->assertEqual(array(), $oConf->findOtherConfigFiles($folder, $filename), 'Unexpected un-recognised config files detected');

        //Check that if there is an admin config file, it it recognised
        touch($folder . '/' . $oConf->aConf['webpath']['admin'] . $filename . '.conf.php');
        $this->assertEqual(array(), $oConf->findOtherConfigFiles($folder, $filename), 'Unexpected un-recognised config files detected');

        // Same for a deliverySSL config file:
        touch($folder . '/' . $oConf->aConf['webpath']['deliverySSL'] . $filename . '.conf.php');
        $this->assertEqual(array(), $oConf->findOtherConfigFiles($folder, $filename), 'Unexpected un-recognised config files detected');

        $unrecognisedFilename = $folder . '/localhost4.' . $filename . '.conf.php';
        touch($unrecognisedFilename);
        $this->assertNotEqual(array(), $oConf->findOtherConfigFiles($folder, $filename), 'Expected un-recognised config files NOT detected');

        // Cleanup
        unlink($folder . '/' . $oConf->aConf['webpath']['admin'] . $filename . '.conf.php');
        unlink($folder . '/' . $oConf->aConf['webpath']['deliverySSL'] . $filename . '.conf.php');
        unlink($unrecognisedFilename);

        rmdir($folder);
    }

    function testMergeConfigChanges()
    {
        // Build a test dist.conf.php
        $oDistConf = new OA_Admin_Settings(true);

        $oDistConf->aConf['foo'] = array('one' => 'bar', 'two' => 'baz', 'new' => 'additional_value');
        $oDistConf->aConf['webpath']['admin'] = 'disthost';
        $oDistConf->aConf['webpath']['delivery'] = 'disthost';
        $oDistConf->aConf['webpath']['deliverySSL'] = 'disthost';
        $oDistConf->aConf['new'] = array('new_key' => 'new_value');

        $distFilename = 'oa_test_dist' . rand();
        $this->assertTrue($oDistConf->writeConfigChange($this->basePath, $distFilename, false), 'Error writing config file');

        // Build a test user conf
        $oUserConf = new OA_Admin_Settings(true);

        $oUserConf->aConf['foo'] = array('one' => 'bar', 'two' => 'baz', 'old' => 'old_value');
        $oUserConf->aConf['deprecated'] = array('old_key' => 'old_value');
        $oUserConf->aConf['webpath']['admin'] = 'localhost';
        $oUserConf->aConf['webpath']['delivery'] = 'localhost';
        $oUserConf->aConf['webpath']['deliverySSL'] = 'localhost';

        $userFilename = 'oa_test_user' . rand();
        $this->assertTrue($oUserConf->writeConfigChange($this->basePath, $userFilename), 'Error writing config file');

        $expected = array('foo' => array('one' => 'bar',
                                         'two' => 'baz',
                                         'new' => 'additional_value'),
                          'webpath' => array('admin' => 'localhost',
                                             'delivery' => 'localhost',
                                             'deliverySSL' => 'localhost'),
                          'new' => array('new_key' => 'new_value'));

        $this->assertEqual($expected, $oUserConf->mergeConfigChanges($this->basePath . '/disthost.' . $distFilename . '.conf.php'),
            'Config files don\'t match');

        // Clean up
        unlink($this->basePath . '/disthost.' . $distFilename . '.conf.php');
        unlink($this->basePath . '/localhost.' . $userFilename . '.conf.php');
        unlink($this->basePath . '/default.' . $distFilename . '.conf.php');
    }

    /**
     * Tests the config file is backed up.
     *
     */
    function testBackupConfig()
    {
        $oConfig = new OA_Admin_Settings(true);

        $originalFilename = 'oa_test_' . rand() . '.conf.php';
        $directory = $this->basePath;
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
        unlink($this->basePath . '/' . $originalFilename);
        unlink($this->basePath . '/' . $expected);
        unlink($this->basePath . '/' . $expected0);
        unlink($this->basePath . '/' . $expected1);

        // Test a .ini file
        $originalFilename = 'oa_test_' . rand() . '.conf.ini';
        $directory = $this->basePath;
        touch($directory . '/' . $originalFilename);
        $now = date("Ymd");
        $expected = $now.'_old.' . $originalFilename.'.php';
        $this->assertTrue($oConfig->backupConfig($directory . '/' . $originalFilename));
        $this->assertTrue(file_exists($directory . '/' . $expected));
        $this->assertEqual(';<'.'?php exit; ?>'."\r\n", file_get_contents($directory . '/' . $expected));

        // Clean up
        unlink($this->basePath . '/' . $originalFilename);
        unlink($this->basePath . '/' . $expected);
    }

    /**
     * Tests the correct backup filename is generated.
     *
     */
    function test_getBackupFilename()
    {
        // Test when backup filename doesn't already exist.
        $originalFilename = 'oa_test_' . rand() . '.conf.php';
        $directory = $this->basePath;
        $now = date("Ymd");
        touch($directory . '/' . $originalFilename);
        $expected = $now.'_old.' . $originalFilename;
        $this->assertEqual($expected, OA_Admin_Settings::_getBackupFilename($directory . '/' . $originalFilename),
            'Filenames don\'t match');

        // Test when backup filename already exists.
        $existingBackupFile = $expected;
        touch($directory . '/' . $existingBackupFile);
        //$expected = $existingBackupFile . '_0';
        $expected0 = $now.'_0_old.' . $originalFilename;
        $this->assertEqual($expected0, OA_Admin_Settings::_getBackupFilename($directory . '/' . $originalFilename),
            'Filenames don\'t match');

         // Clean up
        unlink($directory . '/' . $originalFilename);
        unlink($directory . '/' . $existingBackupFile);


        // Test when .ini backup filename doesn't already exist.
        $originalFilename = 'oa_test_' . rand() . '.conf.ini';
        $directory = $this->basePath;
        $now = date("Ymd");
        touch($directory . '/' . $originalFilename);
        $expected = $now.'_old.' . $originalFilename.'.php';
        $this->assertEqual($expected, OA_Admin_Settings::_getBackupFilename($directory . '/' . $originalFilename),
            'Filenames don\'t match');

         // Clean up
        unlink($directory . '/' . $originalFilename);
    }
}

?>