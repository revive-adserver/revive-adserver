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

// Require the initialisation file
require_once '../../init.php';

define('OA_SKIP_LOGIN', 1);

// Required files
require_once MAX_PATH . '/www/admin/config.php';

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

OA_Auth::logout();
