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
 * @package    Max
 * @subpackage SimulationSuite
 * @author
 */

if (!defined('SIM_PATH')) {
    define('SIM_PATH', $_SERVER['DOCUMENT_ROOT']);
}
define('TMP_PATH', SIM_PATH.'/tmp');
define('TPL_PATH', SIM_PATH.'/templates');
define('FOLDER_SAVE', 'SavedScenarios');
define('FOLDER_DATA', 'data');

$cwd = getcwd();
chdir(SIM_PATH.'/../');
define('MAX_PATH', getcwd());
chdir($cwd);
ini_set('include_path', MAX_PATH.'/lib/pear');
error_reporting(E_ALL ^ E_NOTICE);
require_once SIM_PATH.'/lib.inc.php';
require_once MAX_PATH.'/constants.php';

$conf = get_conf();
$configError = (isset($conf['realConfig']) && $conf['realConfig'] ? false: true);

if (array_key_exists('submit', $_REQUEST))
{
    $conf = write_sim_ini_file($conf);
    $configError = (isset($conf['realConfig']) && $conf['realConfig'] ? false: true);
    include 'templates/frameheader.html';
    include 'templates/initial.html';
    exit;
}

global $is_simulation;
$is_simulation = true;

setupConstants();
require_once 'PEAR.php';

?>
