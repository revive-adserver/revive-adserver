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

require_once MAX_PATH . '/lib/OA/Upgrade/EnvironmentManager.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 */
class Test_OA_Environment_Manager extends UnitTestCase
{
    public function test_checkCriticalPHP()
    {
        // Test 1: Test PHP versions

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '4.3.11';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_VERSION);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, [], ['version']);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '5.2.8';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_VERSION);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, [], ['version']);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '7.1.2';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_VERSION);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, [], ['version']);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '8.0.5';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_VERSION);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, [], ['version']);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '8.1.0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid version of PHP
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '8.3.0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 2: Test memory_limit

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid memory_limit
        $oEnvironmentManager->aInfo['PHP']['actual']['original_memory_limit'] = '2048';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, [], ['memory_limit']);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid memory_limit
        $oEnvironmentManager->aInfo['PHP']['actual']['original_memory_limit'] = '134217728';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid memory_limit
        $oEnvironmentManager->aInfo['PHP']['actual']['original_memory_limit'] = '-1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid memory_limit
        $oEnvironmentManager->aInfo['PHP']['actual']['original_memory_limit'] = '';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 3: Test file_uploads

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid file_uploads
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['file_uploads'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid file_uploads
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 4: Test file_uploads

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid file_uploads
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['file_uploads'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid file_uploads
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 5: Test the zip extension

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['zip'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['zip'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['zip'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 6: Test the json extension

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['json'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['json'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['json'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 7: Test the pcre extension

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['pcre'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['pcre'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
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
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid xml extension
        $oEnvironmentManager->aInfo['PHP']['actual']['xml'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['xml'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
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
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid zlib extension
        $oEnvironmentManager->aInfo['PHP']['actual']['zlib'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['zlib'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
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
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid mysql/pgsql extension
        $oEnvironmentManager->aInfo['PHP']['actual']['mysql'] = '0';
        $oEnvironmentManager->aInfo['PHP']['actual']['pgsql'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['mysql'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
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
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
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
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
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
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid timeout setting
        $oEnvironmentManager->aInfo['PHP']['actual']['timeout'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['timeout'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
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
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['spl'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['spl'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['spl'] = '1';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);

        // Test 13: Test the tokenizer extension

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set an invalid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['tokenizer'] = '0';
        // Test critical PHP settings
        $result = $oEnvironmentManager->_checkCriticalPHP();
        // Check the results
        $this->assertEqual($result, OA_ENV_ERROR_PHP_NOERROR);
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager, ['tokenizer'], []);

        // Prepare a new OA_Environment_Manager class
        $oEnvironmentManager = $this->_getValidEnvironmentManagerObject();
        $this->_testValidEnvironmentManagerObject($oEnvironmentManager);
        // Set a valid pcre extension
        $oEnvironmentManager->aInfo['PHP']['actual']['tokenizer'] = '1';
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
    public function _getValidEnvironmentManagerObject()
    {
        // Create a new OA_Environment_Manager instance
        $oEnvironmentManager = new OA_Environment_Manager();
        // Set a valid enfironment
        $oEnvironmentManager->aInfo['PHP']['actual']['version'] = '8.1.0';
        $oEnvironmentManager->aInfo['PHP']['actual']['memory_limit'] = '';
        $oEnvironmentManager->aInfo['PHP']['actual']['file_uploads'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['pcre'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['xml'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['zlib'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['mysqli'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['pgsql'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['spl'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['json'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['zip'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['tokenizer'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['intl'] = '1';
        $oEnvironmentManager->aInfo['PHP']['actual']['timeout'] = '0';
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
    public function _testValidEnvironmentManagerObject($oEnvironmentManager, $aErrors = [], $aWarnings = [])
    {
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['warning']['version']), in_array('version', $aWarnings));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['memory_limit']), in_array('memory_limit', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['warning']['memory_limit']), in_array('memory_limit', $aWarnings));

        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['file_uploads']), in_array('file_uploads', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['pcre']), in_array('pcre', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['xml']), in_array('xml', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['zlib']), in_array('zlib', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['mysqli']), in_array('mysqli', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['spl']), in_array('spl', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['json']), in_array('json', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['zip']), in_array('zip', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['tokenizer']), in_array('tokenizer', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error']['intl']), in_array('intl', $aErrors));
        $this->assertEqual(isset($oEnvironmentManager->aInfo['PHP']['error'][OA_ENV_ERROR_PHP_TIMEOUT]), in_array('OA_ENV_ERROR_PHP_TIMEOUT', $aErrors));
    }

    public function test_buildFilePermArrayItem()
    {
        $oEnvMgr = $this->_getEnvMgrObj();
        $aResult = $oEnvMgr->buildFilePermArrayItem('test.file', $recurse = false, $result = 'OK', $error = false, $string = '');
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult), 5);
        $this->assertEqual($aResult['file'], 'test.file');
        $this->assertEqual($aResult['result'], 'OK');
        $this->assertEqual($aResult['string'], '');
        $this->assertFalse($aResult['recurse']);
        $this->assertFalse($aResult['error']);
    }

    public function test_getFilePermissionErrors()
    {
        Mock::generatePartial(
            'OA_Environment_Manager',
            $mockEnvMgr = 'OA_Environment_Manager' . rand(),
            [
                'checkFilePermission',
            ],
        );

        $oEnvMgr = new $mockEnvMgr();
        $oEnvMgr->aInfo['PERMS']['expected'][] = $oEnvMgr->buildFilePermArrayItem(MAX_PATH . '/var', true);
        $oEnvMgr->aInfo['PERMS']['expected'][] = $oEnvMgr->buildFilePermArrayItem(MAX_PATH . '/var/test.conf.php', false);

        $oEnvMgr->setReturnValueAt(0, 'checkFilePermission', true);
        $oEnvMgr->setReturnValueAt(1, 'checkFilePermission', true);
        $aErrors = $oEnvMgr->getFilePermissionErrors();

        $this->assertIsA($aErrors, 'array');
        $this->assertEqual(count($aErrors), 2);
        $this->assertFalse($aErrors[0]['error']);
        $this->assertFalse($aErrors[1]['error']);



        $oEnvMgr->setReturnValueAt(2, 'checkFilePermission', true);
        $oEnvMgr->setReturnValueAt(3, 'checkFilePermission', false);
        $aErrors = $oEnvMgr->getFilePermissionErrors();

        $this->assertIsA($aErrors, 'array');
        $this->assertEqual(count($aErrors), 2);
        $this->assertFalse($aErrors[0]['error']);
        $this->assertTrue($aErrors[1]['error']);

        $oEnvMgr->expectCallCount('checkFilePermission', 4);

        $oEnvMgr->tally();
    }

    public function test_checkCriticalFilePermissions()
    {
        $oEnvMgr = $this->_getEnvMgrObj();

        $oEnvMgr->aInfo['PERMS']['actual'][0] = [
            'file' => 'var',
            'recurse' => true,
            'result' => 'OK',
            'error' => false,
            'string' => '',
        ];

        $this->assertTrue($oEnvMgr->_checkCriticalFilePermissions(), '');

        $oEnvMgr->aInfo['PERMS']['actual'][0] = [
            'file' => 'var',
            'recurse' => true,
            'result' => 'NOT writeable',
            'error' => true,
            'string' => 'strErrorFixPermissionsRCommand',
        ];

        $this->assertFalse($oEnvMgr->_checkCriticalFilePermissions(), '');
    }

    public function test_checkCriticalFiles()
    {
        $oEnvMgr = $this->_getEnvMgrObj();
        $this->assertTrue($oEnvMgr->_checkCriticalFiles(), '');
    }

    public function _getEnvMgrObj()
    {
        $oEnvMgr = new OA_Environment_Manager();
        return $oEnvMgr;
    }
}
