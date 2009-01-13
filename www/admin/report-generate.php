<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

// Require the initialisation file
require_once '../../init.php';

// Include required files
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Admin/Reports/Generate.php';

global $session;

if (isset($_REQUEST['submit_type']) && $_REQUEST['submit_type'] == 'change') {
    // Store any values we need to pass to the next page
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

// If the report is for a "specific" period, store the period for later user
if (!is_null($_GET['period_preset']) && ($_GET['period_preset'] == 'specific')) {
    if (!is_null($_GET['period_start'])) {
        $session['prefs']['GLOBALS']['startDate'] = $_GET['period_start'] = date('Y-m-d', strtotime($_GET['period_start']));
    }
    if (!is_null($_GET['period_end'])) {
        $session['prefs']['GLOBALS']['endDate'] = $_GET['period_end'] = date('Y-m-d', strtotime($_GET['period_end']));
    }
}

// Load the required language files
Language_Loader::load('report');

// Register input variables
phpAds_registerGlobal('plugin');

$oModule = new OA_Admin_Reports_Generate();
$oModule->generate($plugin);

?>