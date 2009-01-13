<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once(MAX_PATH . '/lib/pear/Config.php');

class MDB2ConfigWriter
{
    function configureTest($type, $host, $port, $username, $password, $name, $tableType)
    {
        $fTestConfigSource = MAX_PATH . '/tests/mdb2/mdb2_test_setup.php';
        $fTestConfigDestination = MAX_PATH . '/lib/pear/MDB2/tests/test_setup.php';
        
        if ($this->configureTestFile($fTestConfigSource, $fTestConfigDestination,
            $type, $host, $port, $username, $password, $name, $tableType) == false) {
            return false;
        }
        
        $fTestConfigSource = MAX_PATH . '/tests/mdb2/mdb2schema_test_setup.php';
        $fTestConfigDestination = MAX_PATH . '/lib/pear/MDB2_Schema/tests/test_setup.php';
        
        return $this->configureTestFile($fTestConfigSource, $fTestConfigDestination,
            $type, $host, $port, $username, $password, $name, $tableType);
    }
    
    
    function configureTestFile($fTestConfigSource, $fTestConfigDestination,
        $type, $host, $port, $username, $password, $name, $tableType)
    {
        $sConfig = file_get_contents($fTestConfigSource);
        $sConfig = str_replace('%db.type%', $type, $sConfig);
        $sConfig = str_replace('%db.username%', $username, $sConfig);
        $sConfig = str_replace('%db.password%', $password, $sConfig);
        $sConfig = str_replace('%db.host%', $host, $sConfig);
        $sConfig = str_replace('%db.port%', $port, $sConfig);
        
        $sOptions = '';
        if ('mysql' == $type) {
           $useTransactions = 'INNODB' == $tableType ? 'true' : 'false';
           $sOptions = "'options' => array(" . "'use_transactions' => $useTransactions" . ")";
        }
        $sConfig = str_replace('%options%', $sOptions, $sConfig);
        
        $file = fopen($fTestConfigDestination, 'wt');
        if (!$file) {
            return false;
        }
        if (fwrite($file, $sConfig) === false) {
            return false;
        }
        return fclose($file);
    }
}

?>
