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
     * Tests a dummy config file is written out correctly.
     *
     */
    function testWriteConfigChange()
    {
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
        
    }
}

?>