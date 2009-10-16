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

        // Test 1: Test PHP versions

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '4.3.11';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_VERSION);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array(), array('version'));

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '5.1.3';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_VERSION);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array(), array('version'));

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '5.1.4';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '6.0.0-dev';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_VERSION_NEWER);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array(), array('version'));

        // Test 2: Test memory_limit

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid memory_limit
        $oEnvironmentManager->aInfo['PHP']['actual']['original_memory_limit'] = '2048';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array(), array('memory_limit'));

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid memory_limit
        $oEnvironmentManager->aInfo['PHP']['actual']['original_memory_limit'] = '134217728';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid memory_limit
        $oEnvironmentManager->aInfo['PHP']['actual']['original_memory_limit'] = '-1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid memory_limit
        $oEnvironmentManager->aInfo['PHP']['actual']['original_memory_limit'] = '';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 3: Test safe_mode

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid safe_mode
        $oEnvironmentManager->aInfo['PHP']['actual']['safe_mode'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_SAFEMODE);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('safe_mode'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid safe_mode
        $oEnvironmentManager->aInfo['PHP']['actual']['safe_mode'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 4: Test magic_quotes_runtime

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid magic_quotes_runtime
        $oEnvironmentManager->aInfo['PHP']['actual']['magic_quotes_runtime'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_MAGICQ);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('magic_quotes_runtime'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid magic_quotes_runtime
        $oEnvironmentManager->aInfo['PHP']['actual']['magic_quotes_runtime'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 5: Test file_uploads

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid file_uploads
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('file_uploads'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid file_uploads
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 6: Test file_uploads

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid file_uploads
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('file_uploads'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid file_uploads
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 7: Test the pcre extension

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['pcre'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('pcre'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['pcre'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 8: Test the xml extension

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid xml extension
        $oEnvironmentManager->aInfo['PHP']['actual']['xml'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('xml'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid xml extension
        $oEnvironmentManager->aInfo['PHP']['actual']['xml'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 9: Test the zlib extension

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid zlib extension
        $oEnvironmentManager->aInfo['PHP']['actual']['zlib'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('zlib'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid zlib extension
        $oEnvironmentManager->aInfo['PHP']['actual']['zlib'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 10: Test the mysql/pgsql extensions

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid mysql/pgsql extension
        $oEnvironmentManager->aInfo['PHP']['actual']['mysql'] = '0';
        $oEnvironmentManager->aInfo['PHP']['actual']['pgsql'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('mysql'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid mysql/pgsql extension
        $oEnvironmentManager->aInfo['PHP']['actual']['mysql'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['pgsql'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid mysql/pgsql extension
        $oEnvironmentManager->aInfo['PHP']['actual']['mysql'] = '0';
        $oEnvironmentManager->aInfo['PHP']['actual']['pgsql'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid mysql/pgsql extension
        $oEnvironmentManager->aInfo['PHP']['actual']['mysql'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['pgsql'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 11: Test the timeout settings

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid timeout setting
        $oEnvironmentManager->aInfo['PHP']['actual']['timeout'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('timeout'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid timeout setting
        $oEnvironmentManager->aInfo['PHP']['actual']['timeout'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 12: Test the spl extension

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['spl'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, array('spl'), array());

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = &$this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['spl'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

    }

    /**
     * A private method to return an OA_Environment_Manager instance that is valid
     * for all required PHP versions/settings to install OpenX.
     *
     * @access private
     * @return OA_Environment_Manager A valid OA_Environment_Manager instance for use in the test_checkCriticalPHP() method.
     */
    function _getValidEnvironmentManagerObject()
    {
        // Create a new OA_Environment_Manager instance
        $oEnvironmentManager = new OA_Environment_Manager();
        // Set a valid enfironment
        $oEnvironmentManager->aInfo['PHP']['actual']['version']              = '5.1.4';
        $oEnvironmentManager->aInfo['PHP']['actual']['memory_limit']         = '';
        $oEnvironmentManager->aInfo['PHP']['actual']['safe_mode']            = '0';
        $oEnvironmentManager->aInfo['PHP']['actual']['magic_quotes_runtime'] = '0';
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads']         = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['pcre']                 = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['xml']                  = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['zlib']                 = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['mysql']                = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['pgsql']                = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['spl']                  = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['timeout']              = '0';
        // Return the valid OA_Environment_Manager instance
        return $oEnvironmentManager;
    }

    /**
     * A private method to test an OA_Environment_Manager instance, either with
     * no errors or warning set, or with a set of specified expected errors or warnings.
     *
     * @access private
     * @param OA_Environment_Manager $oEnvironmentManager The instance to test.
     * @param array $aErrors An array of errors that are expected to be set.
     * @param array $aWarnings An array of warnings that are expected to be set.
     * @return void
     */
    function _testValidEnvironmentManagerObject($oEnvironmentManager, $aErrors = array(), $aWarnings = array())
    {
        if (in_array('version', $aWarnings)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['warning']['version']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['warning']['version']);
        }
        if (in_array('memory_limit', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error']['memory_limit']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error']['memory_limit']);
        }
        if (in_array('memory_limit', $aWarnings)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['warning']['memory_limit']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['warning']['memory_limit']);
        }
        if (in_array('safe_mode', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error']['safe_mode']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error']['safe_mode']);
        }
        if (in_array('magic_quotes_runtime', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error']['magic_quotes_runtime']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error']['magic_quotes_runtime']);
        }
        if (in_array('file_uploads', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error']['file_uploads']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error']['file_uploads']);
        }
        if (in_array('pcre', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error']['pcre']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error']['pcre']);
        }
        if (in_array('xml', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error']['xml']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error']['xml']);
        }
        if (in_array('zlib', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error']['zlib']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error']['zlib']);
        }
        if (in_array('mysql', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error']['mysql']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error']['mysql']);
        }
        if (in_array('spl', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error']['spl']);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error']['spl']);
        }
        if (in_array('OA_ENV_ERROR_PHP_TIMEOUT', $aErrors)) {
            $this->assertNotNull($oEnvironmentManager->aInfo['PHP']['error'][OA_ENV_ERROR_PHP_TIMEOUT]);
        } else {
            $this->assertNull($oEnvironmentManager->aInfo['PHP']['error'][OA_ENV_ERROR_PHP_TIMEOUT]);
        }
    }

    function test_buildFilePermArrayItem()
    {
        $oEnvMgr =&  $this->_getEnvMgrObj();
        $aResult = $oEnvMgr->buildFilePermArrayItem('test.file', $recurse=false, $result='OK', $error = false, $string='');
        $this->assertIsA($aResult,'array');
        $this->assertEqual(count($aResult),5);
        $this->assertEqual($aResult['file'],'test.file');
        $this->assertEqual($aResult['result'],'OK');
        $this->assertEqual($aResult['string'],'');
        $this->assertFalse($aResult['recurse']);
        $this->assertFalse($aResult['error']);
    }

    function test_getFilePermissionErrors()
    {
           Mock::generatePartial(
                                'OA_Environment_Manager',
                                $mockEnvMgr = 'OA_Environment_Manager'.rand(),
                                array(
                                      'checkFilePermission'
                                     )
                                );

        $oEnvMgr = new $mockEnvMgr;
        $oEnvMgr->aInfo['PERMS']['expected'][] = $oEnvMgr->buildFilePermArrayItem(MAX_PATH.'/var', true);
        $oEnvMgr->aInfo['PERMS']['expected'][] = $oEnvMgr->buildFilePermArrayItem(MAX_PATH.'/var/test.conf.php', false);

        $oEnvMgr->setReturnValueAt(0,'checkFilePermission', true);
        $oEnvMgr->setReturnValueAt(1,'checkFilePermission', true);
        $aErrors = $oEnvMgr->getFilePermissionErrors();

        $this->assertIsA($aErrors,'array');
        $this->assertEqual(count($aErrors),2);
        $this->assertFalse($aErrors[0]['error']);
        $this->assertFalse($aErrors[1]['error']);



        $oEnvMgr->setReturnValueAt(2,'checkFilePermission', true);
        $oEnvMgr->setReturnValueAt(3,'checkFilePermission', false);
        $aErrors = $oEnvMgr->getFilePermissionErrors();

        $this->assertIsA($aErrors,'array');
        $this->assertEqual(count($aErrors),2);
        $this->assertFalse($aErrors[0]['error']);
        $this->assertTrue($aErrors[1]['error']);

        $oEnvMgr->expectCallCount('checkFilePermission',4);

        $oEnvMgr->tally();
    }

    function test_checkCriticalFilePermissions()
    {
        $oEnvMgr =&  $this->_getEnvMgrObj();

        $oEnvMgr->aInfo['PERMS']['actual'][0] = array(
                                                    'file'      => 'var',
                                                    'recurse'   => true,
                                                    'result'    => 'OK',
                                                    'error'     => false,
                                                    'string'    => '',
                                                  );

        $this->assertTrue($oEnvMgr->_checkCriticalFilePermissions(),'');

        $oEnvMgr->aInfo['PERMS']['actual'][0] = array(
                                                    'file'      => 'var',
                                                    'recurse'   => true,
                                                    'result'    => 'NOT writeable',
                                                    'error'     => true,
                                                    'string'    => '',
                                                  );

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
