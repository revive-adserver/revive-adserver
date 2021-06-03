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
 * A class for locating test files in different ways.
 *
 * @package    Max
 * @subpackage TestSuite
 */
class TestFiles
{

    /**
     * A method to scan a directory (and, optionally, all sub-directories)
     * and find all OpenX tests of the appropriate type and relating to
     * a supplied test "layer" code.
     *
     * @param string  $type      The type of test being run (eg. "unit").
     * @param string  $code      The layer's code (eg. "dal").
     * @param string  $dir       Base directory name to begin search from.
     * @param boolean $recursive Optional. If true, searches sub-folders
     *                           recursively.
     * @return array An array containing all of the files found that
     *               match the layer test code supplied.
     */
    static function getTestFiles($type, $code, $dir, $recursive = true)
    {
        $aFiles = array();
        // Search recursively?
        if ($recursive) {
            // Open the base directory
            $dh = opendir($dir);
            if ($dh) {
                while (false !== ($file = readdir($dh))) {
                    // Ignore the parent, self and subversion directories
                    if (($file == '.') || ($file == '..') || ($file == '.svn')) {
                        continue;
                    }
                    // Is the file another directory?
                    if (is_dir($dir . '/' . $file)) {
                        // In recursive mode, so add in all tests found in this sub-directory
                        $aFiles = array_merge($aFiles, self::getTestFiles($type, $code, $dir . '/' . $file));
                    }
                }
                closedir($dh);
            }
        }
        // Can we open a tests directory?
        $dh = @opendir($dir . '/' . constant($type . '_TEST_STORE'));
        if ($dh) {
            while (($file = readdir($dh)) !== false) {
                // Does the filename match?
                if (preg_match("/[^.]+\.$code\.test\.php/", $file)) {
                    // Strip the MAX_PROJECT_PATH from the folder before storing
                    $storeFolder = preg_replace('#' . str_replace('\\', '\\\\', MAX_PROJECT_PATH) . '/#', '', $dir);
                    $aFiles[$storeFolder][] = $file;
                }
            }
            closedir($dh);
            if ($aFiles[$storeFolder]) {
                asort($aFiles[$storeFolder]);
            }
        }
        return $aFiles;
    }

    /**
     * A method to get all test files in the OpenX project.
     *
     * @param string $type The type of test being run (eg. "unit").
     * @return array An array containing the details of all the test files
     *               in the OpenX project.
     */
    static function getAllTestFiles($type)
    {
        global $conf;
        $aDirectories = explode('|', $conf['test']['directories']);
        $aTests = array();
        foreach ($GLOBALS['_MAX']['TEST'][$type . '_layers'] as $layer => $data) {
            foreach ($aDirectories as $path) {
                if (empty($aTests[$layer])) {
                    $aTests[$layer] = array();
                }
                $aTests[$layer] = array_merge($aTests[$layer], self::getTestFiles($type, $layer, MAX_PROJECT_PATH.'/'.$path));
            }
        }
        return $aTests;
    }

    /**
     * A method to get all test files in the OpenX project for a specified layer.
     *
     * @param string $type The type of test being run (eg. "unit").
     * @param $layer string The layer code.
     * @return mixed An array containing the details of all the test files
     *               in the OpenX project for the specified layer.
     */
    static function getLayerTestFiles($type, $layer)
    {
        global $conf;
        $aDirectories = explode('|', $conf['test']['directories']);
        $aTests = array();
        foreach ($aDirectories as $path) {
            if (empty($aTests[$layer])) {
                $aTests[$layer] = array();
            }
            $aTests[$layer] = array_merge($aTests[$layer], self::getTestFiles($type, $layer, MAX_PROJECT_PATH.'/'.$path));
        }
        return $aTests;
    }

}

?>
