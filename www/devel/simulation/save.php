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
    if (preg_match('/[\W\d]+/', $_REQUEST['name']))
    {
        display_error('Not Saved: Scenario name must not contain spaces, numerals or punctuation', $_REQUEST['name']);
    }
    else
    {
        $conf = write_sim_ini_file($conf);
        save_scenario($_REQUEST['name'], $conf);
    }
}

require_once MAX_PATH.'/www/admin/js/jscalendar/calendar.php';
// make simlink to calendar in the simulation folder
// ln -sf ../www/admin/js/jscalendar calendar
$calobj = new DHTML_Calendar();

include TPL_PATH.'/frameheader.html';
$calobj->load_files();
include TPL_PATH.'/body_save_scenario.html';
?>