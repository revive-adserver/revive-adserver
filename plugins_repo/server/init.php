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

// Plugin Repository Server
define('PRS_PATH', dirname(__FILE__));
set_include_path('.'
        . PATH_SEPARATOR . PRS_PATH.'/lib'
        . PATH_SEPARATOR . PRS_PATH.'/lib/pear');

require_once('PEAR.php');

