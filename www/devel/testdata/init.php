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
 */

require_once '../../../init.php';
require_once 'tdconst.php';

function get_file_list($directory, $ext, $strip_ext=false)
{
    $aFiles = array();
    $dh = opendir($directory);
    if ($dh)
    {
        while (false !== ($file = readdir($dh)))
        {
            if (strpos($file, $ext)>0)
            {
                if ($strip_ext)
                {
                    $file = str_replace($ext, '', $file);
                }
                $aFiles[] = $file;
            }
        }
        closedir($dh);
    }
    natcasesort($aFiles);
    return $aFiles;
}




?>
