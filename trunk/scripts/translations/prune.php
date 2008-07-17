#!/usr/bin/php -q
<?php

if (function_exists ("DebugBreak")) {
  DebugBreak ();
}

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

// Require the initialisation file
// Done this way so that it works in CLI PHP
$path = dirname(__FILE__);
require_once $path .'/../../init.php';

// Set longer time out, and ignore user abort
if (!ini_get('safe_mode')) {
    @set_time_limit($conf['maintenance']['timeLimitScripts']);
    @ignore_user_abort(true);
}

$langFilePath       = MAX_PATH . '/lib/max/language/en';
$staleTransFile     = MAX_PATH . '/var/stale.trans.log';
$allTransFile       = MAX_PATH . '/var/all.trans.log';
$existingTransFile  = MAX_PATH . '/var/existing.trans.log';
$aFilterPattern     = array('/^phpAds_hlp_/', '/^str/');
$transSourceVar     = $GLOBALS;

//  load all master translation files
$result = loadLangFiles($langFilePath);

//  filter translations
$aTranslation = $aOrigTrans = filterTranslations($aFilterPattern, $transSourceVar);

//  write list of all translation keys to file
$result = writeTranslationToFile($allTransFile, $aTranslation);

//  finds stale translation in code base
$aStaleKey = findStaleTranslations(MAX_PATH, $aTranslation);

//  create report of remaining translation keys that are not in the code base
$result = writeTranslationToFile($staleTransFile, $aTranslation);

//  create report of transaltion that exist in code base
$aResult = array_diff($aOrigTrans, $aTranslation);
$result  = writeTranslationToFile($existingTransFile, $aResult);

function array_preg($pattern, $haystack)
{
    foreach ($haystack as $key => $value) {
        if (preg_match($pattern, $key)) {
            $aMatches[] = $key;
        }
    }

    return $aMatches;
}

function filterTranslations($aFilterPattern, $aTranslation)
{
    if (!is_array($aFilterPattern) || !is_array($aTranslation)) {
        (!is_array($aFilterPattern))
            ? die('$aFilterPattern must be an array')
            : die('$aTranslation must be an array');
    } else {
        $aResult = array();
        foreach ($aFilterPattern as $pattern) {
            $aFilteredResult = array_preg($pattern, $aTranslation);
            $aResult = array_merge($aResult, $aFilteredResult);
        }
    }
    return $aResult;
}

function findStaleTranslations($dir, &$aTranslation)
{
    if (is_dir($dir) && is_array($aTranslation)) {
        //  load list of directories
        $oDir = dir($dir);

        //  interate through directories
        while (($file = $oDir->read()) !== false) {
            if ($file != "." && $file != ".." && $file != ".svn" && !strstr($file, '.lang.php')) {
                $file = $oDir->path .'/'. $file;
                if (is_dir($file) && $file != $oDir->path .'/pear' && $file != $oDir->path .'/var') {
                    //  interate through subdirectories and files
                    findStaleTranslations($file, $aTranslation);
                } else if (is_readable($file)) {
                    $aDisallowed = array(
                            '.jpg', '.png', '.gif', '.sh', '.sql', '.crt',
                            '.xml', '.bin');
                    $fileExt     = substr($file, strrpos($file, '.'));
                    if (!in_array($fileExt, $aDisallowed)) {
                        //  parse current file for use of translation keys
                        findTranslations($file, $aTranslation);
                    }
                }
            }
        }
    } else if (!is_dir($dir)) {
        die('Specified directory does not exist: '. $dir);
    } else {
        die('$aTranslation must be an array');
    }
    return true;
}

function findTranslations($file, &$aTranslation)
{
    if (!is_array($aTranslation)) {
        die('$aTranslation must be an array');
    }
    if (file_exists($file) && $fp = fopen($file, 'r')) {
        //  load file into variable
        $data = '';
        while (!feof($fp)) {
            $data .= fread($fp, 2048);
        }

        //  parse file for all remaining translation keys
        foreach ($aTranslation as $key => $value) {
            //  check if key is in file
            if (strstr($data, $value)) {
                //  remove transaltion from array of translation keys
                unset($aTranslation[$key]);
            }
        }
        fclose($fp);
    } else if (!file_exists($file)) {
        die ('File does not exits: '. $file);
    } else {
        die ('Unable to open file: '. $file);
    }
    return true;
}

function loadLangFiles($dir)
{
    //  retrieve listing of all files in directory
    if (is_dir($dir) && $oDir = dir($dir)) {
        while (($file = $oDir->read()) !== false) {
            //  ensure it's a file
            if (!is_dir($oDir->path . '/'. $file) && !($file == '.' || $file == '..')) {
                include_once $oDir->path . '/'. $file;
            }
        }
        $oDir->close();
    } else if (!is_dir($dir)) {
        die('Specified directory is not a directory: '. $dir);
    } else {
        die('Unable to access directory: '. $dir);
    }
    return true;
}

function writeTranslationToFile($file, $aTranslation)
{
    if (!is_array($aTranslation)) {
        die('$aTranslation must be an array');
    }
    if (!file_exists($file) && $fp = fopen($file, 'x+')) {
        $translation = implode("\n", $aTranslation);
        $str = 'Total Translation: '. count($aTranslation) ."\n\n";
        while (fwrite($fp, $str) === false) {
            die('Unable to write to file: '. $file);
        }
        while (fwrite($fp, $translation) === false) {
            die('Unable to write to file: '. $file);
        }
        fclose($fp);
    } else if (file_exists($file)) {
        die('File already exists: '. $file);
    }
    return true;
}

?>
