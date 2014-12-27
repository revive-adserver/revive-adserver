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

if (!defined('SIM_PATH')) {
    define('SIM_PATH', MAX_PATH.'/www/devel/simulation/');
}
define('SIM_TMP', SIM_PATH.'/tmp');
define('SIM_TEMPLATES', SIM_PATH.'/templates');
define('SCENARIOS', 'scenarios');
define('SCENARIOS_DATASETS', SIM_PATH.SCENARIOS.'/datasets/');
define('SCENARIOS_REQUESTSETS', SIM_PATH.SCENARIOS.'/requestsets/');

error_reporting(E_ALL ^ E_NOTICE);
define('TEST_ENVIRONMENT_RUNNING', true);

require_once 'lib.inc.php';

$conf['simdb'] = $conf['database'];
$conf['realConfig'] = OX_getHostName();

global $is_simulation;
$is_simulation = true;

?>
