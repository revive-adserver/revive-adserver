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


require_once MAX_PATH.'/lib/OA/Upgrade/EnvironmentManager.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 */
class Test_OA_Environment_Manager extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Environment_Manager()
    {
        $this->UnitTestCase();
    }

    function test_checkCriticalPHP()
    {
        $oEnvMgr =&  $this->_getEnvMgrObj();

        $oEnvMgr->aInfo['PHP']['actual']['memory_limit'] = '';
        $oEnvMgr->aInfo['PHP']['actual']['safe_mode'] = '0';
        $oEnvMgr->aInfo['PHP']['actual']['magic_quotes_runtime'] = '0';
        //$oEnvMgr->aInfo['PHP']['actual']['date.timezone'] = 'Europe/London';

        $oEnvMgr->aInfo['PHP']['actual']['version'] = '4.3.9';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_VERSION,'version 4.3.9');

        $oEnvMgr->aInfo['PHP']['actual']['version'] = '4.3.10';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_VERSION,'version 4.3.10');

        $oEnvMgr->aInfo['PHP']['actual']['version'] = '4.3.11';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_NOERROR,'version 4.3.11');

        $oEnvMgr->aInfo['PHP']['actual']['version'] = '5.0.1';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_NOERROR,'version 5.0.1');

        $oEnvMgr->aInfo['PHP']['actual']['memory_limit'] = '2048';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_MEMORY,'memory_limit too low');

        $oEnvMgr->aInfo['PHP']['actual']['memory_limit'] = '16384';
        $GLOBALS['_MAX']['REQUIRED_MEMORY']['PHP4'] = '16384';
        $GLOBALS['_MAX']['REQUIRED_MEMORY']['PHP5'] = '16384';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_NOERROR,'memory_limit');

        $oEnvMgr->aInfo['PHP']['actual']['memory_limit'] = '';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_NOERROR,'memory_limit not set');

        $oEnvMgr->aInfo['PHP']['actual']['safe_mode'] = '1';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_SAFEMODE,'safe_mode on');

        $oEnvMgr->aInfo['PHP']['actual']['safe_mode'] = '0';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_NOERROR,'safe_mode off');

        $oEnvMgr->aInfo['PHP']['actual']['magic_quotes_runtime'] = '1';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_MAGICQ,'magic_quotes_runtime on');

        $oEnvMgr->aInfo['PHP']['actual']['magic_quotes_runtime'] = '0';
        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_NOERROR,'magic_quotes_runtime off');

//        $oEnvMgr->aInfo['PHP']['actual']['date.timezone'] = '';
//        $this->assertEqual($oEnvMgr->_checkCriticalPHP(),OA_ENV_ERROR_PHP_TIMEZONE,'date.timezone unset');
    }

    function test_checkCriticalFilePermissions()
    {
        $oEnvMgr =&  $this->_getEnvMgrObj();

        $oEnvMgr->aInfo['PERMS']['actual'] = array('/var'=>'OK');
        $this->assertTrue($oEnvMgr->_checkCriticalFilePermissions(),'');

        $oEnvMgr->aInfo['PERMS']['actual'] = array('/var'=>'NOT writeable');
        $this->assertFalse($oEnvMgr->_checkCriticalFilePermissions(),'');
    }

    function test_checkCriticalFiles()
    {
        $oEnvMgr =&  $this->_getEnvMgrObj();
        $this->assertTrue($oEnvMgr->_checkCriticalFiles(),'');
    }

    function _getEnvMgrObj()
    {
        $oEnvMgr = new OA_Environment_Manager();
        return $oEnvMgr;
    }
}

?>
