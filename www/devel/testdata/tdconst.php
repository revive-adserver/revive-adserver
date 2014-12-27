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
 * @package    Devel Utils
 * @subpackage Test Data
 */

if (!defined('TD_PATH')) {
    define('TD_PATH', MAX_PATH.'/www/devel/testdata/');
}
define('TD_TEMPLATES', SIM_PATH.'/templates');
define('TD_DATAPATH', MAX_PATH.'/tests/datasets/mdb2schema/');

error_reporting(E_ALL ^ E_NOTICE);
define('TEST_ENVIRONMENT_RUNNING', true);


?>
