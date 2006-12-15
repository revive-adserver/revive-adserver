<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: TestFiles.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
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
     * A method to scan a Max folder (and all sub-folders) and find all
     * tests relating to a supplied layer.
     *
     * @param string $type The type of test being run (eg. "unit").
     * @param string $code The layer's code (eg. "dal").
     * @param string $folder Base folder name to begin search from.
     * @return mixed An array containing all of the files found that
     *               match the layer test code supplied.
     */
    function getTestFiles($type, $code, $folder)
    {
        $files = array();
        $dh = opendir($folder);
        if ($dh) {
            while (false !== ($file = readdir($dh))) {
                if (($file == '.') || ($file == '..') || ($file == '.svn')) {
                    // Ignore
                    continue;
                }
                // Is the file another directory?
                if (is_dir($folder . '/' . $file)) {
                    $files = array_merge($files, TestFiles::getTestFiles($type, $code, $folder . '/' . $file));
                }
            }
            closedir($dh);
        }
        // Can we open a tests directory?
        $dh = @opendir($folder . '/' . constant($type . '_TEST_STORE'));
        if ($dh) {
            while (($file = readdir($dh)) !== false) {
                // Does the filename match?
                if (preg_match("/[^.]+\.$code\.test\.php/", $file)) {
                    // Strip the MAX_PROJECT_PATH from the folder before storing
                    $storeFolder = preg_replace('#' . str_replace('\\', '\\\\', MAX_PROJECT_PATH) . '/#', '', $folder);
                    $files[$storeFolder][] = $file;
                }
            }
            closedir($dh);
            if (count($files[$storeFolder]) > 1) {
                asort($files[$storeFolder]);
            }
        }
        return $files;
    }
    
    /**
     * A method to get all test files in the Max project.
     *
     * @param string $type The type of test being run (eg. "unit").
     * @return mixed An array containing the details of all the test files
     *               in the Max project.
     */
    function getAllTestFiles($type)
    {
        $tests = array();
        foreach ($GLOBALS['_MAX']['TEST'][$type . '_layers'] as $layer => $data) {
            foreach ($GLOBALS['_MAX']['TEST']['directories'] as $path) {
                if (empty($tests[$layer])) {
                    $tests[$layer] = array();
                }
                $tests[$layer] = array_merge($tests[$layer], TestFiles::getTestFiles($type, $layer, MAX_PROJECT_PATH.'/'.$path));
            }
        }
        return $tests;
    }
    
    /**
     * A method to get all test files in the Max project for a specified layer.
     *
     * @param string $type The type of test being run (eg. "unit").
     * @param $layer string The layer code.
     * @return mixed An array containing the details of all the test files
     *               in the Max project for the specified layer.
     */
    function getLayerTestFiles($type, $layer)
    {
        $tests = array();
        foreach ($GLOBALS['_MAX']['TEST']['directories'] as $path) {
            if (empty($tests[$layer])) {
                $tests[$layer] = array();
            }
            $tests[$layer] = array_merge($tests[$layer], TestFiles::getTestFiles($type, $layer, MAX_PROJECT_PATH.'/'.$path));
        }
        return $tests;
    }
        
}

?>
