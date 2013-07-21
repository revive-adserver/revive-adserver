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
 * @package    Max
 * @subpackage SimulationSuite
 * @author
 */

require_once '../../../init.php';
if (!defined('PKG_PATH')) {
    define('PKG_PATH', MAX_PATH.'/etc/changes/');
}
$patVersion = '[\d]+\.[\d]+';
if (!defined('PKG_MILESTONE')) {
    define('PKG_MILESTONE', '/openads_upgrade_[\.\d\w]+_to_[\.\_\d\w]+\.xml/');
}
if (!defined('PKG_INCREMENTAL')) {
    define('PKG_INCREMENTAL', '/openads_upgrade_[\w\W]+\.xml/');
}
if (!defined('PKG_CHANGESET')) {
    define('PKG_CHANGESET', '/changes_tables_core_[\d]+\.xml/');
}

error_reporting(E_ALL ^ E_NOTICE);
define('TEST_ENVIRONMENT_RUNNING', true);

function get_package_array()
{
    $dh = opendir(PKG_PATH);
    if ($dh)
    {
        while (false !== ($file = readdir($dh)))
        {
            if (preg_match(PKG_CHANGESET, $file, $aMatches))
            {
                $aFiles['changeset'][] = $file;
            }
            else if (preg_match(PKG_MILESTONE, $file, $aMatches))
            {
                $aFiles['milestone'][] = $file;
            }
            else if (preg_match(PKG_INCREMENTAL, $file, $aMatches))
            {
                $aFiles['incremental'][] = $file;
            }
        }
        closedir($dh);
        natcasesort($aFiles['changeset']);
        natcasesort($aFiles['incremental']);
        natcasesort($aFiles['milestone']);
    }
    return $aFiles;
}

function get_packages_array_from_text()
{
    $file = PKG_PATH.'openads_upgrade_array.txt';
    $array = file_get_contents($file);
    $aResult = unserialize($array);
    return $aResult;
}




?>
