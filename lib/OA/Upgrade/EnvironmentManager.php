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

/**
 * OpenXUpgrade Class
 *
 */
define('OA_ENV_ERROR_PHP_NOERROR', 1);
define('OA_ENV_ERROR_PHP_VERSION', -1);
define('OA_ENV_ERROR_PHP_MEMORY', -2);
define('OA_ENV_ERROR_PHP_SAFEMODE', -3);
define('OA_ENV_ERROR_PHP_MAGICQ', -4);
define('OA_ENV_ERROR_PHP_TIMEZONE', -5);
define('OA_ENV_ERROR_PHP_UPLOADS', -6);
define('OA_ENV_ERROR_PHP_ARGC', -7);
define('OA_ENV_ERROR_PHP_XML', -8);
define('OA_ENV_ERROR_PHP_PCRE', -9);
define('OA_ENV_ERROR_PHP_ZLIB', -10);
define('OA_ENV_ERROR_PHP_MYSQL', -11);
define('OA_ENV_ERROR_PHP_TIMEOUT', -12);
define('OA_ENV_ERROR_PHP_SPL', -13);
define('OA_ENV_ERROR_PHP_MBSTRING', -14);
define('OA_ENV_WARNING_MEMORY', -15);

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';
require_once MAX_PATH . '/lib/OX/Admin/UI/Install/InstallUtils.php';

define('OA_MEMORY_UNLIMITED', 'Unlimited');

class OA_Environment_Manager
{
    public $aInfo = [];

    public function __construct()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (empty($GLOBALS['installing'])) {
            $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem(MAX_PATH . '/var');
            $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem(MAX_PATH . '/var/cache', true);
            $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem(MAX_PATH . '/var/plugins', true);
            $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem(MAX_PATH . '/var/templates_compiled', true);
        } else {
            $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem(MAX_PATH . '/var', true);
        }

        $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem(MAX_PATH . '/plugins', true);
        $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem(MAX_PATH . '/www/admin/plugins', true);

        // if CONF file hasn't been created yet, use the default images folder
        if (!empty($conf['store']['webDir'])) {
            $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem($conf['store']['webDir']);
        } else {
            $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem(MAX_PATH . '/www/images');
        }

        if (!empty($conf['delivery']['cachePath'])) {
            $this->aInfo['PERMS']['expected'][] = $this->buildFilePermArrayItem($conf['delivery']['cachePath']);
        }

        // Fix directory separator
        if (DIRECTORY_SEPARATOR != '/') {
            foreach ($this->aInfo['PERMS']['expected'] as $idx => $aValue) {
                $this->aInfo['PERMS']['expected'][$idx]['file'] = str_replace('/', DIRECTORY_SEPARATOR, $aValue['file']);
            }
        }

        $this->aInfo['PHP']['actual'] = [];
        $this->aInfo['PERMS']['actual'] = [];
        $this->aInfo['FILES']['actual'] = [];

        $this->aInfo['PHP']['expected']['version'] = '7.2.5';
        $this->aInfo['PHP']['expected']['file_uploads'] = '1';
        $this->aInfo['PHP']['expected']['register_argc_argv'] = '1';
        $this->aInfo['PHP']['expected']['pcre'] = true;
        $this->aInfo['PHP']['expected']['xml'] = true;
        $this->aInfo['PHP']['expected']['zlib'] = true;
        $this->aInfo['PHP']['expected']['mysql'] = true;
        $this->aInfo['PHP']['expected']['spl'] = true;
        $this->aInfo['PHP']['expected']['json'] = true;
        $this->aInfo['PHP']['expected']['zip'] = true;
        $this->aInfo['PHP']['expected']['mbstring.func_overload'] = false;
        $this->aInfo['PHP']['expected']['timeout'] = false;
        $this->aInfo['COOKIES']['expected']['enabled'] = true;

        $this->aInfo['FILES']['expected'] = [];
    }

    public function checkSystem()
    {
        $this->getAllInfo();
        $this->checkCritical();
        return $this->aInfo;
    }

    public function getAllInfo()
    {
        $this->aInfo['PHP']['actual'] = $this->getPHPInfo();
        $this->aInfo['PERMS']['actual'] = $this->getFilePermissionErrors();
        $this->aInfo['FILES']['actual'] = $this->getFileIntegInfo();
        $this->aInfo['COOKIES']['actual'] = $this->getCookieInfo();
        return $this->aInfo;
    }

    public function getCookieInfo()
    {
        $aResult['enabled'] = false;
        $this->aInfo['COOKIES']['error']['enabled'] = $GLOBALS['strEnableCookies'];

        if (isset($_COOKIE['sessionID'])
            || isset($_COOKIE[OX_Admin_UI_Install_InstallUtils::$INSTALLER_SESSION_ID])) {
            $aResult['enabled'] = true;
            unset($this->aInfo['COOKIES']['error']['enabled']);
        }
        return $aResult;
    }

    public function getPHPInfo()
    {
        $aResult['version'] = phpversion();

        $aResult['memory_limit'] = OX_getMemoryLimitSizeInBytes();
        if ($aResult['memory_limit'] == -1) {
            $aResult['memory_limit'] = OA_MEMORY_UNLIMITED;
        }

        $aResult['original_memory_limit'] = $GLOBALS['_OX']['ORIGINAL_MEMORY_LIMIT'] ?? -1;
        if ($aResult['original_memory_limit'] == -1) {
            $aResult['original_memory_limit'] = OA_MEMORY_UNLIMITED;
        }

        $aResult['safe_mode'] = ini_get('safe_mode');
        $aResult['date.timezone'] = (ini_get('date.timezone') ? ini_get('date.timezone') : getenv('TZ'));
        $aResult['register_argc_argv'] = ini_get('register_argc_argv');
        $aResult['file_uploads'] = ini_get('file_uploads');
        $aResult['xml'] = extension_loaded('xml');
        $aResult['pcre'] = extension_loaded('pcre');
        $aResult['zlib'] = extension_loaded('zlib');
        $aResult['mysqli'] = extension_loaded('mysqli');
        $aResult['pgsql'] = extension_loaded('pgsql');
        $aResult['spl'] = extension_loaded('spl');
        $aResult['json'] = extension_loaded('json');
        $aResult['zip'] = extension_loaded('zip');

        // Check mbstring.func_overload
        $aResult['mbstring.func_overload'] = false;
        if (extension_loaded('mbstring')) {
            $aResult['mbstring.func_overload'] = (bool)ini_get('mbstring.func_overload');
        }

        // set_time_limit is used throughout maintenance to increase the timeout for scripts
        // if user has disabled the set_time_limit function
        // their scripts will run in ini_get('max_execution_time')
        // if ini_get('max_execution_time') > 0 or < 300 they may have a problem
        $aResult['timeout'] = false;
        $aDisabled = explode(',', ini_get('disable_functions'));
        $timeout = ini_get('max_execution_time');
        if (in_array('set_time_limit', $aDisabled) && (($timeout > 0) && ($timeout < 300))) {
            $aResult['timeout'] = $timeout;
        }
        return $aResult;
    }

    public function getFileIntegInfo()
    {
        return false;
    }

    public function buildFilePermArrayItem($file, $recurse = false, $result = 'OK', $error = false, $string = '')
    {
        return [
                    'file' => $file,
                    'recurse' => $recurse,
                    'result' => $result,
                    'error' => $error,
                    'string' => $string,
                    ];
    }

    public function checkFilePermission($file, $recurse)
    {
        if ((!file_exists($file)) || (!$this->isWritable($file))) {
            OA::debug('Unwritable ' . ((is_dir($file) ? 'folder ' : 'file ')) . $file);
            return false;
        }
        $recurseWritable = true;
        if ($recurse) {
            $dh = @opendir($file);
            if ($dh) {
                while (false !== ($f = readdir($dh))) {
                    if (($f == '.') || ($f == '..') || ($f == '.svn')) {
                        continue;
                    }
                    $thisFile = $file . '/' . $f;
                    if (!$this->checkFilePermission($thisFile, $recurse)) {
                        $recurseWritable = false;
                    }
                }
                closedir($dh);
            }
        }
        return $recurseWritable;
    }

    /**
     * Check access to an array of required files/folders
     *
     * @return array of error messages
     */
    public function getFilePermissionErrors()
    {
        $aErrors = [];

        // Test that all of the required files/directories can
        // be written to by the webserver
        foreach ($this->aInfo['PERMS']['expected'] as $idx => $aFile) {
            if (empty($aFile['file'])) {
                continue;
            }
            if (!$this->checkFilePermission($aFile['file'], $aFile['recurse'])) {
                $aFile['result'] = $GLOBALS['strNotWriteable'];
                $aFile['error'] = true;
                $aFile['string'] = ($aFile['recurse'] ? 'strErrorFixPermissionsRCommand' : 'strErrorFixPermissionsRCommand');
                $aFile['message'] = $GLOBALS['strDirNotWriteableError'];
            }
            $aErrors[] = $aFile;
        }

        return $aErrors;
    }

    public function isWritable($file)
    {
        if (DIRECTORY_SEPARATOR == '\\') {
            // Windows hack - is_writable returns bogus results
            // see http://bugs.php.net/bug.php?id=27609
            if (@is_dir($file)) {
                $file = preg_replace('/\\\\$/', '', $file) . DIRECTORY_SEPARATOR . md5(uniqid('', true));
                $unlink = true;
            } else {
                $unlink = !file_exists($file);
            }
            if ($fp = @fopen($file, 'ab')) {
                @fclose($fp);
                if ($unlink) {
                    @unlink($file);
                }
                return true;
            } else {
                return false;
            }
        }
        return is_writable($file);
    }

    public function checkCritical()
    {
        $this->_checkCriticalPHP();
        $this->_checkCriticalFilePermissions();
        $this->_checkCriticalFiles();
        return $this->aInfo;
    }

    /**
     * A private method to test the configuration of the user's PHP environment.#
     *
     * Tests the following values, and in the event of a fatal error or a
     * warning, the value set is listed below:
     *
     *  - The PHP version
     *      Sets: $this->aInfo['PHP']['warning']['version']
     *
     *  - The PHP configuration's memory_limit value
     *      Sets: $this->aInfo['PHP']['warning']['memory_limit']
     *
     *  - The PHP configuration's safe_mode value
     *      Sets: $this->aInfo['PHP']['error']['safe_mode']
     *
     *  - The PHP configuration's file_uploads value
     *      Sets: $this->aInfo['PHP']['error']['file_uploads']
     *
     *  - The PHP configuration's pcre extension
     *      Sets: $this->aInfo['PHP']['error']['pcre']
     *
     *  - The PHP configuration's xml extension
     *      Sets: $this->aInfo['PHP']['error']['xml']
     *
     *  - The PHP configuration's zlib extension
     *      Sets: $this->aInfo['PHP']['error']['zlib']
     *
     *  - The PHP configuration's database (both mysql and pgsql) extensions
     *      Sets: $this->aInfo['PHP']['error']['mysql']
     *
     *  - The PHP configuration's spl extension
     *      Sets: $this->aInfo['PHP']['error']['spl']
     *
     *  - The PHP configuration's timeout settings
     *      Sets: $this->aInfo['PHP']['error']['timeout']
     *
     * Otherwise, if there are no errors or warnings, then $this->aInfo['PHP']['error']
     * is set to "false".
     *
     * @access private
     * @return integer One of the following values:
     *                      - OA_ENV_ERROR_PHP_NOERROR
     *                      - OA_ENV_ERROR_PHP_VERSION
     *                      - OA_ENV_ERROR_PHP_SAFEMODE
     *                      - OA_ENV_ERROR_PHP_MAGICQ
     *                 Note that sometimes an error value is returned, sometimes
     *                 not, even if there is an actual error - this appears to be
     *                 a historical hangover, where the information set in the
     *                 $this->aInfo array has gradually assumed more importance
     *                 than the return value.
     *
     * @TODO Address the return value oddness, by removing all return values, and
     *       simply rely on the $this->aInfo array, perhaps?
     */
    public function _checkCriticalPHP()
    {
        $this->aInfo['PHP']['warning'] = $this->aInfo['PHP']['error'] = [];

        // Test the PHP version
        if (version_compare(
            $this->aInfo['PHP']['actual']['version'],
            $this->aInfo['PHP']['expected']['version'],
            "<"
        )) {
            $result = OA_ENV_ERROR_PHP_VERSION;
        } else {
            $result = OA_ENV_ERROR_PHP_NOERROR;
        }

        if ($result == OA_ENV_ERROR_PHP_VERSION) {
            $this->aInfo['PHP']['warning']['version'] =
                "Version {$this->aInfo['PHP']['actual']['version']} is below the minimum supported version of {$this->aInfo['PHP']['expected']['version']}." .
                "<br />You should upgrade your PHP to at least {$this->aInfo['PHP']['expected']['version']} in order to install " . PRODUCT_NAME . ". " .
                "Please see the <a href='" . PRODUCT_DOCSURL . "/faq'>FAQ</a> for more information.";
        }

        // Test the original memory_limit
        if (!$this->checkOriginalMemory()) {
            $this->aInfo['PHP']['warning']['memory_limit'] =
                PRODUCT_NAME . " requires a minimum of " . (OX_getMemoryLimitSizeInBytes() / 1048576) . " MB to run successfully, although " .
                "some parts of the application will increase this limitation if required. The current 'memory_limit' value is set to " .
                ($this->aInfo['PHP']['actual']['original_memory_limit'] / 1048576) . " MB, so " . PRODUCT_NAME . " has automatically increased " .
                "this limit. If possible, please increase the 'memory_limit' value in your server's php.ini file to a minimum of " .
                (OX_getMemoryLimitSizeInBytes() / 1048576) . " MB before continuing.";
        }

        // Ensure that the original memory_limit is not displayed in the systems screen
        unset($this->aInfo['PHP']['actual']['original_memory_limit']);

        // Test the PHP configuration's file_uploads value
        if (!$this->aInfo['PHP']['actual']['file_uploads']) {
            $this->aInfo['PHP']['error']['file_uploads'] = 'The file_uploads option must be ON';
        }

        // Test the required PHP extensions are loaded
        if (!$this->aInfo['PHP']['actual']['json']) {
            $this->aInfo['PHP']['error']['json'] = 'The json extension must be loaded';
        }
        if (!$this->aInfo['PHP']['actual']['pcre']) {
            $this->aInfo['PHP']['error']['pcre'] = 'The pcre extension must be loaded';
        }
        if (!$this->aInfo['PHP']['actual']['spl']) {
            $this->aInfo['PHP']['error']['spl'] = 'The spl extension must be loaded';
        }
        if (!$this->aInfo['PHP']['actual']['xml']) {
            $this->aInfo['PHP']['error']['xml'] = 'The xml extension must be loaded';
        }
        if (!$this->aInfo['PHP']['actual']['zip']) {
            $this->aInfo['PHP']['error']['zip'] = 'The zip extension must be loaded';
        }
        if (!$this->aInfo['PHP']['actual']['zlib']) {
            $this->aInfo['PHP']['error']['zlib'] = 'The zlib extension must be loaded';
        }

        // Test that mbstring function overloading is disabled
        if (!empty($this->aInfo['PHP']['actual']['mbstring.func_overload'])) {
            $this->aInfo['PHP']['error']['mbstring.func_overload'] = 'mbstring function overloading must be disabled';
        }

        // Test that at least one of the required database extensions are loaded
        if (empty($this->aInfo['PHP']['actual']['mysqli']) && empty($this->aInfo['PHP']['actual']['pgsql'])) {
            $this->aInfo['PHP']['error']['mysqli'] = $this->aInfo['PHP']['error']['pgsql'] =
                'At least one of these database extensions must be loaded';
        }

        // Test the ability to set timeouts
        if ($this->aInfo['PHP']['actual']['timeout']) {
            $this->aInfo['PHP']['error']['timeout'] = 'The PHP function set_time_limit() has been disabled and '
                . 'max_execution_time is set to ' . $this->aInfo['PHP']['actual']['timeout']
                . ' which may cause problems with functionality such as maintenance';
        }

        if (!empty($this->aInfo['PHP']['error'])) {
            $this->aInfo['PHP']['error']['badPhpConfiguration'] = $GLOBALS['strSystemCheckBadPHPConfig'];
        }


        return $result;
    }

    /**
     * Check if the original memory_limit had to be worked around to allow
     * OpenX to work
     *
     * @return boolean True if the original memory_limit was okay, false otherwise
     */
    public function checkOriginalMemory()
    {
        if (empty($this->aInfo['PHP']['actual']['original_memory_limit'])) {
            return true;
        }

        if (OA_MEMORY_UNLIMITED == $this->aInfo['PHP']['actual']['original_memory_limit']) {
            return true;
        }

        return $this->aInfo['PHP']['actual']['original_memory_limit'] < 0 ||
            $this->aInfo['PHP']['actual']['original_memory_limit'] >= OX_getMinimumRequiredMemory();
    }

    /**
     * A private method to test for any critial errors resulting from "bad"
     * file or directory permissions.
     *
     * Sets $this->aInfo['PERMS']['error'] to the boolean false if all
     * permissions are acceptable, otherwise, it is set to a string containing
     * an appropriate error message to show to the user on the system check
     * page.
     *
     * @return boolean True when all permissions are okay, false otherwise.
     */
    public function _checkCriticalFilePermissions()
    {
        // Test to see if there were any file/directory permission errors
        unset($this->aInfo['PERMS']['error']['filePerms']);
        foreach ($this->aInfo['PERMS']['actual'] as $idx => $aFile) {
            if ($aFile['error']) {
                if (empty($this->aInfo['PERMS']['error']['filePerms'])) {
                    if (DIRECTORY_SEPARATOR === '\\') {
                        $this->aInfo['PERMS']['error']['filePerms'] = $GLOBALS['strErrorWritePermissionsWin'];
                    } else {
                        $this->aInfo['PERMS']['error']['filePerms'] = $GLOBALS['strErrorWritePermissions'];
                    }
                }
                if (DIRECTORY_SEPARATOR !== '\\') {
                    $this->aInfo['PERMS']['error']['filePerms'] .= "<br />" . sprintf($GLOBALS[$aFile['string']], $aFile['file']);
                }
            }
        }
        if (!empty($this->aInfo['PERMS']['error']['filePerms'])) {
            $this->aInfo['PERMS']['error']['filePerms'] .= "<br />" . $GLOBALS['strCheckDocumentation'];
            return false;
        }
        $this->aInfo['PERMS']['error'] = false;
        return true;
    }

    public function _checkCriticalFiles()
    {
        $this->aInfo['FILES']['error'] = false;
        return true;
    }
}
