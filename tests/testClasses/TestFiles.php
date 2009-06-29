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

/**
 */

/**
 * A class for locating test files in different ways.
 *
 * @package    Max
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
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
    function getTestFiles($type, $code, $dir, $recursive = true)
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
                        $aFiles = array_merge($aFiles, TestFiles::getTestFiles($type, $code, $dir . '/' . $file));
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
            if (count($aFiles[$storeFolder]) > 1) {
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
    function getAllTestFiles($type)
    {
        global $conf;
        $aDirectories = explode('|', $conf['test']['directories']);
        $aTests = array();
        foreach ($GLOBALS['_MAX']['TEST'][$type . '_layers'] as $layer => $data) {
            foreach ($aDirectories as $path) {
                if (empty($aTests[$layer])) {
                    $aTests[$layer] = array();
                }
                $aTests[$layer] = array_merge($aTests[$layer], TestFiles::getTestFiles($type, $layer, MAX_PROJECT_PATH.'/'.$path));
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
    function getLayerTestFiles($type, $layer)
    {
        global $conf;
        $aDirectories = explode('|', $conf['test']['directories']);
        $aTests = array();
        foreach ($aDirectories as $path) {
            if (empty($aTests[$layer])) {
                $aTests[$layer] = array();
            }
            $aTests[$layer] = array_merge($aTests[$layer], TestFiles::getTestFiles($type, $layer, MAX_PROJECT_PATH.'/'.$path));
        }
        return $aTests;
    }

}

?>
