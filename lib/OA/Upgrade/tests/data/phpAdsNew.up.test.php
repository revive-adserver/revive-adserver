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


require_once MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
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

        $this->assertEqual($oPAN->engine,'PANENGINE','engine not detected');
        $this->assertEqual($oPAN->prefix,'panprefix_','prefix not detected');

    }

    function test_getPANConfig()
    {
        $oPAN = new OA_phpAdsNew();

        $this->_putPanConfigFile();
        $oPAN->init();
        $this->assertTrue($oPAN->detected,'failed to detect phpAdsNew');
        $oPAN->_getPANConfig();
        $this->_deletePanConfigFile();
        $aResult  = $oPAN->aConfig;
        $this->assertEqual($aResult['dbhost'],'pan_host','host not detected');
        $this->assertEqual($aResult['dbport'],'9999','port  not detected');
        $this->assertEqual($aResult['dbuser'],'pan_user','user not detected');
        $this->assertEqual($aResult['dbpassword'],'pan_password','password not detected');
        $this->assertEqual($aResult['dbname'],'pan_database','database not detected');
    }

    function test_getPANdsn()
    {
        $oPAN = new OA_phpAdsNew();

        $this->_putPanConfigFile();
        $oPAN->init();
        $this->assertTrue($oPAN->detected,'failed to detect phpAdsNew');
        $this->_deletePanConfigFile();
        $oPAN->_getPANdsn();
        $aResult = $oPAN->aDsn;
        $this->assertEqual($aResult['database']['host'],'pan_host','host not set');
        $this->assertEqual($aResult['database']['port'],'9999','port not set');
        $this->assertEqual($aResult['database']['username'],'pan_user','username not set');
        $this->assertEqual($aResult['database']['password'],'pan_password','password not set');
        $this->assertEqual($aResult['database']['name'],'pan_database','database not set');
    }

    function _putPanConfigFile()
    {
        $fileTo     = MAX_PATH.'/var/config.inc.php';
        $fileFrom   = MAX_PATH.'/lib/OA/Upgrade/tests/integration/pan.config.inc.php';

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
