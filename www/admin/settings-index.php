<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';

// Redirect to admin settings page
if (phpAds_isUser(phpAds_Admin)) {
    MAX_Admin_Redirect::redirect('settings-admin.php');
} elseif (phpAds_isUser(phpAds_Agency)) {
    MAX_Admin_Redirect::redirect('settings-banner.php');
} elseif (phpAds_isUser(phpAds_Client)) {
    MAX_Admin_Redirect::redirect('settings-defaults.php?affiliateid='.phpAds_getUserId());
} elseif (phpAds_isUser(phpAds_Affiliate)) {
    MAX_Admin_Redirect::redirect('settings-defaults.php?affiliateid='.phpAds_getUserId());
}

?>
