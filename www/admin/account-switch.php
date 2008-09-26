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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once LIB_PATH . '/Admin/Redirect.php';

phpAds_registerGlobalUnslashed('return_url', 'account_id');

if (!empty($account_id)) {
    OA_Permission::enforceAccess($account_id);
    OA_Permission::switchAccount($account_id);
}

if (empty($return_url) && !empty($_SERVER['HTTP_REFERER'])) {
    $return_url = $_SERVER['HTTP_REFERER'];
}

if (empty($return_url) || preg_match('/[\r\n]/', $_SERVER['HTTP_REFERER'])) {
    $return_url = MAX::constructURL(MAX_URL_ADMIN, 'index.php');
} else {
    $session['accountSwitch'] = 1;
    phpAds_SessionDataStore();
}

// Ensure that we never return to this account-switch.php page, in the
// event that the session timed out, and then the user changed account
// manually...
$aUrlComponents = parse_url($return_url);
$aPathInformation = pathinfo($aUrlComponents['path']);
if ($aPathInformation['filename'] == 'account-switch') {
    $sectionID = $aPathInformation['filename'];
    OX_Admin_Redirect::redirect();
}

// Re-direct...
header('Location: ' . $return_url);
exit;

?>