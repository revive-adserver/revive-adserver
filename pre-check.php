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

/**
 * @package    OpenX
 * @author     Łukasz Wikierski <lukasz.wikierski@openx.org>
 *
 * A pre-initialisation file to check if system settings allow OpenX
 * to be run or not.
 */

/**
 * A function to check system settings and display detected problems
 */
function OX_initialSystemCheck(){
    $errorUrl = 'http://www.openx.org/help/2.8/pre-init-error/';
    $installed = OX_checkSystemInstalled();
    $aErrors = array();
    if (OX_checkSystemInitialRequirements($aErrors)===false) {
        $message = "
            <html>
            <head>
            <title>OpenX</title>
            </head>
            <body>
            <p>
        ";
        if ($installed) {
            $message .= "
                Sorry, but OpenX is not able to be run.
            ";
        } else {
            $message .= "
                Sorry, but the OpenX installer system cannot be started.
            ";
        }
        $message .= "
            </p>
            <p>
            Detected problem";
        if (count($aErrors) > 1) {
            $message .= "s";
        }
        $message .= ":
            <ul>
        ";
        echo $message;
        foreach ($aErrors as $errorMessage) {
            echo "<li>{$errorMessage}</li>";
        }
        $message = "
            </ul>
            </p>
            <p>
            Please see our <a href='$errorUrl'>documentation</a> for help
            with the above error";
        if (count($aErrors) > 1) {
            $message .= "s";
        }
        $message .= ".
            </p>
            </body>
            </html>
        ";
        echo $message;
        // Terminate execution
        exit;
    }
}

/**
 * Check (roughly) to see if the system is installed without
 * any of the usual code to check this, as running in pre-init
 * mode.
 *
 * @return bool True if the system seems to be installed, false
 *              otherwise.
 */
function OX_checkSystemInstalled()
{
    $path = @dirname(__FILE__);
    if (!@empty($path)) {
        if (@file_exists($path . '/var/UPGRADE')) {
            return false;
        } else {
            return true;
        }
    }
    return false;
}

/**
 * Check for situation when installing or using software is eithe
 * imposible, or results in unformated error output, due to system
 * configuration.
 *
 * @param &$aErrors Array of error mesages.
 * @return bool True on system check OK, False on detected problems.
 */
function OX_checkSystemInitialRequirements(&$aErrors){
    // List of functions required to run OpenX, exlcuding
    // the functions "function_exists", "ini_get", "explode",
    // "trim" and "array_intersect", as these functions are
    // all treated with special tests in this method
    $aRequiredFunctions = array(
        'dirname',
        'empty',
        'file_exists',
        'parse_ini_file',
        'version_compare'
    );
    // Prepare error strings, in the simplest possible way
    $errorString1 = 'The built in PHP function "';
    $errorString2 = '" is in the "disable_functions" list in your "php.ini" file.';
    // Need "function_exists" to be able to test for functions required
    // for testing what is in the "disabled_functions" list
    if (!function_exists('function_exists')) {
        $aErrors[] = $errorString1 . 'function_exists' . $errorString2;
        return false;
    }
    // Test for existence of "ini_get", "explode", "trim" and
    // "array_intersect", which are all required as part of
    // testing what is in the "disabled_functions" list
    $isSystemOK = true;
    if (!function_exists('ini_get')) {
        $aErrors[] = $errorString1 . 'ini_get' . $errorString2;
        $isSystemOK = false;
    } else if (!function_exists('explode')) {
        $aErrors[] = $errorString1 . 'explode' . $errorString2;
        $isSystemOK = false;
    } else if (!function_exists('trim')) {
        $aErrors[] = $errorString1 . 'trim' . $errorString2;
        $isSystemOK = false;
    } else if (!function_exists('array_intersect')) {
        $aErrors[] = $errorString1 . 'array_intersect' . $errorString2;
        $isSystemOK = false;
    }
    if (!$isSystemOK) {
        return $isSystemOK;
    }
    // Test the disabled functons list with required functions list
    // defined above in $aRequiredFunctions
    $aDisabledFunctions = explode(',', ini_get('disable_functions'));
    foreach ($aDisabledFunctions as $key => $value) {
        $aDisabledFunctions[$key] = trim($value);
    }
    $aNeededFunctions = array_intersect($aDisabledFunctions, $aRequiredFunctions);
    if (count($aNeededFunctions) > 0) {
        $isSystemOK = false;
        foreach ($aNeededFunctions as $functionName) {
            $aErrors[] = $errorString1 . $functionName . $errorString2;
        }
    }
    // Check PHP version, as use of PHP 4 will result in parse errors
    $errorMessage = "PHP version 5.0.0, or greater, was not detected.";
    if (function_exists('version_compare')) {
        $result = version_compare(phpversion(), '5.0.0', '<');
        if ($result) {
            $aErrors[] = $errorMessage;
            $isSystemOK = false;
        }
    }
    return $isSystemOK;
}

OX_initialSystemCheck();
?>