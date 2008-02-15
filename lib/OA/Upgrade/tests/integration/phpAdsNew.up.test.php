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


require_once MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 */
class Test_OA_phpAdsNew extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_phpAdsNew()
    {
        $this->UnitTestCase();
    }

    function test_init()
    {
        $oPAN = new OA_phpAdsNew();

        $oPAN->init();
        $this->assertFalse($oPAN->detected,'phpAdsNew falsely detected');

        $this->_putPanConfigFile();
        $oPAN->init();
        $this->assertTrue($oPAN->detected,'failed to detect phpAdsNew');

        if ($GLOBALS['_MAX']['CONF']['database']['type']=='mysql')
        {
            $this->assertEqual($oPAN->engine,'PANENGINE','mysql storage engine not detected');
        }
//      no longer matters if engine type is found
//      the sql statements should be separated so as to ensure that the engine is not used for pgsql
//        else if ($GLOBALS['_MAX']['CONF']['database']['type']=='pgsql')
//        {
//            $this->assertEqual($oPAN->engine,'','engine incorrectly detected for pgsql');
//        }
        $this->assertEqual($oPAN->prefix,'panprefix_','prefix not detected');

    }

    function test_migratePANConfig()
    {
        $oPAN = new OA_phpAdsNew();

        $this->_putPanConfigFile();
        $aResult = $oPAN->_migratePANConfig($oPAN->_getPANConfig());
        $this->_deletePanConfigFile();
        $this->assertEqual($aResult['database']['host'],'pan_host','host not set');
        $this->assertEqual($aResult['database']['port'],'9999','port not set');
        $this->assertEqual($aResult['database']['username'],'pan_user','username not set');
        $this->assertEqual($aResult['database']['password'],'pan_password','password not set');
        $this->assertEqual($aResult['database']['name'],'pan_database','database not set');
        $this->assertFalse($aResult['database']['persistent'],'persistent incorrect');

        $this->assertTrue($aResult['ui']['enabled'],'"UI Enabled" incorrect');
        $this->assertFalse($aResult['openads']['requireSSL'], 'requireSSL incorrect');
        $this->assertTrue($aResult['maintenance']['autoMaintenance'], 'autoMaintenance incorrect');
        $this->assertFalse($aResult['logging']['reverseLookup'], 'reverseLookup incorrect');
        $this->assertFalse($aResult['logging']['proxyLookup'],  'proxyLookup incorrect');
        $this->assertTrue($aResult['logging']['adImpressions'],'adImpressions incorrect');
        $this->assertTrue($aResult['logging']['adClicks'],'adClicks incorrect');
//        $this->assertFalse($aResult[''][''] = $phpAds_config['log_beacon'],' incorrect');;
//        $this->assertFalse($aResult[''][''] = $phpAds_config['ignore_hosts'],' incorrect');;
        $this->assertEqual($aResult['logging']['blockAdImpressions'],0, 'blockAdImpressions incorrect');
        $this->assertEqual($aResult['logging']['blockAdClicks'], 0, 'blockAdClicks incorrect');
        $this->assertTrue($aResult['p3p']['policies'],'policies incorrect');
        $this->assertEqual($aResult['p3p']['compactPolicy'],'NOI CUR ADM OUR NOR STA NID', 'compactPolicy incorrect');
        $this->assertEqual($aResult['p3p']['policyLocation'],'pan_p3p_policy_location','policyLocation incorrect');
        $this->assertTrue($aResult['delivery']['acls'],'acls incorrect');


    }


    function _putPanConfigFile()
    {
        $fileTo     = MAX_PATH.'/var/config.inc.php';
        $fileFrom   = MAX_PATH.'/lib/OA/Upgrade/tests/data/pan.config.inc.php';

        if (file_exists($fileTo))
        {
            unlink($fileTo);
        }
        $this->assertTrue(file_exists($fileFrom),'pan test config does not exist');
        $this->assertTrue(copy($fileFrom, $fileTo),'failed to copy pan test config file');
        $this->assertTrue(file_exists($fileTo),'pan test config does not exist');
    }

    function _deletePanConfigFile()
    {
        $fileTo     = MAX_PATH.'/var/config.inc.php';

        if (file_exists($fileTo))
        {
            unlink($fileTo);
        }
        $this->assertFalse(file_exists($fileTo),'pan test config file not deleted');
    }

/* need to mock PAN db installation
    ...but, the dbh is called via static method
    function test_getPANversion()
    {
        $oPAN = new OA_phpAdsNew();

        $this->_putPanConfigFile();

        Mock::generatePartial(
            'MDB2_Driver_Common',
            $mockDbh = 'MDB2_Driver_Common'.rand(),
            array('')
        );

        $oUpgrade->mockDbh = new $mockDbh($this);
        $result = $oPAN->getPANversion();
        $this->_deletePanConfigFile();
    }
*/
}

?>
