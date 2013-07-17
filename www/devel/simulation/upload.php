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

check_environment();

if (array_key_exists('submit', $_REQUEST))
{
    upload_scenarios();
}

include TPL_PATH.'/frameheader.html';

include TPL_PATH.'/body_upload_scenario.html';
?>