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