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
 * The package allows for some advanced operations on files and directories.
 * It requires PEAR_Error to be included as well.
 * 
 * @package Util
 * @subpackage File
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */

/**
 * Attempts to remove the file indicated by the $sFilename path from the
 * filesystem. If the $filename indicates non-empty directory the function
 * will remove it along with all its content.
 *
 * @param string $sFilename
 * @return boolean True if the operation is successful, PEAR_Error if there
 * was a failure.
 */
function Util_File_remove($sFilename)
{
    if (file_exists($sFilename)) {
        if (is_dir($sFilename)) {
            $directory = opendir($sFilename);
            if (false === $directory) {
                $error = new PEAR_Error("Can't open the directory: '$sFilename'.");
                return $error;
            }
            while(($sChild = readdir($directory)) !== false) {
                if ($sChild == '.' or $sChild == '..') {
                    continue;
                }
                $result = Util_File_remove($sFilename . '/' . $sChild);
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
            closedir($directory);
            $result = rmdir($sFilename);
            if ($result === false) {
                $error = new PEAR_Error("Can't delete the directory: '$sFilename'.");
                return $error;
            }
            return true;
        }
        else {
            return Util_File_returnPearErrorIfFalse(
                unlink($sFilename), "Can't remove the file: '$sFilename'.");
        }
    }
}


/**
 * Returns true if the $result evaluates to true. Otherwise, creates
 * an instance of PEAR_Error class with a $message and returns it.
 *
 * @param boolean $result
 * @param string $message
 * @param int $code
 * @param int $mode
 * @param mixed $options
 * @param string $userinfo
 * @return boolean True or PEAR_Error if the $result evaluates to false.
 */
function Util_File_returnPearErrorIfFalse($result, $message = 'Unknown error',
    $code = null, $mode = null, $options = null, $userinfo = null)
{
    if ($result) {
        return true;
    }
    else {
        $error = new PEAR_Error($message, $code, $mode, $options, $userinfo);
        return $error;
    }
}

?>