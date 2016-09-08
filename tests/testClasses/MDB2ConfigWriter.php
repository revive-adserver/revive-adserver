<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
        if ('mysql' == $type || 'mysqli' == $type) {
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
