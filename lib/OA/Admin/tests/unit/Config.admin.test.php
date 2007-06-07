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
        // 1) Test an existing file.
        $oConf = new OA_Admin_Config();
        
        $path = '/tmp';
        $filename = 'oa_test_' . rand() . '.conf.php';
        $fp = fopen($path . '/' . $filename, 'w');
        fwrite($fp, 'foo');
        fclose($fp);
        
        // Check it is writable
        $this->assertTrue($oConf->isConfigWritable($path . '/' . $filename));
        unlink($path . '/' . $filename);
        
        // 2) Test a non-existing file in an unwriteable location
        $this->assertFalse($oConf->isConfigWritable('/non_existent_dir/non_existent_file'));
        
        // 3) Test an existing file we don't have permissions for
        $path = '/tmp';
        $filename = 'oa_test_' . rand() . '.conf.php';
        $fp = fopen($path . '/' . $filename, 'w');
        fwrite($fp, 'foo');
        chmod($path . '/' . $filename, 0200);
        fclose($fp);
        $this->assertFalse($oConf->isConfigWritable('/non_existent_dir/non_existent_file'));
        unlink($path . '/' . $filename);
        
        // 4) Test an empty directory we can write to
        $this->assertTrue($oConf->isConfigWritable('/tmp/non_existent_file'));
        
        // 5) Test an empty directory we cannot write to
        $dirname = 'oa_test_' . rand();
        mkdir('/tmp/' . $dirname, 0500);
        $this->assertFalse($oConf->isConfigWritable('/tmp/' . $dirname . '/non_existent_file'));
        rmdir('/tmp/' . $dirname);
    }
}

?>