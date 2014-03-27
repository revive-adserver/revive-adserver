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

require_once MAX_PATH . '/lib/RV/Sync.php';

/**
 * A class for testing the RV_Sync class.
 *
 * @package    Revive Adserver
 * @subpackage TestSuite
 */
class Test_RV_Sync extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_RV_Sync()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the getConfigVersion() method.
     */
    function testGetConfigVersion()
    {
        $oSync = new RV_Sync();

        // Prepare sample ascending versions
        $aVersions = array(
            'v2.3.32-beta-rc10' => 2332.110,
            '2.3.32-beta-rc11'  => 2332.111,
            'v2.3.32-beta'      => 2332.200,
            '2.3.33-beta-rc1'   => 2333.101,
            'v2.3.33-beta'      => 2333.200,
            '2.4.0-rc1'         => 2400.301,
            'v2.4.0-rc2'        => 2400.302,
            '2.4.0'             => 2400.400,
            'v2.4.0-stable'     => 2400.400,
            '2.5.0-dev'         => 2499.999,

            '2.5.99-dev-custom'     => 2598.999,
            '2.6.0-beta-rc2-custom' => 2600.102,
            '2.6.0-beta-custom'     => 2600.200,
            '2.6.0-rc57-custom'     => 2600.357,
            '2.6.0-custom'          => 2600.400,

            'foo'               => false
        );

        foreach ($aVersions as $version => $config_version) {
            $this->assertEqual($oSync->getConfigVersion($version), $config_version);
        }
    }

}

?>