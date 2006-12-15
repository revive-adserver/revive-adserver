<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
require_once '../../init.php';

// Include required files
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/language/Report.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Admin/Reporting/ExecuteModule.php';

global $session;

if (isset($_REQUEST['submit_type']) && $_REQUEST['submit_type'] == 'change') {
    // store any values we need to pass to the next page
    switch ($_REQUEST['changed_field']) {
    case 'publisher' :
        if (isset($_REQUEST['publisherId'])) {
            $session['prefs']['GLOBALS']['report_publisher'] = $_REQUEST['publisherId'];
            phpAds_SessionDataStore();
        }
    default :
        break;
    }
    echo "<script type='text/javascript'>window.location='".$_REQUEST['refresh_page']."'</script>";
}

// Load the required language files
Language_Report::load();

// Register input variables
phpAds_registerGlobal('plugin');

$module = new ReportExecuteModule();
$module->main($plugin);

?>
