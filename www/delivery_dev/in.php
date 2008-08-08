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
require_once '../../init-delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/Delivery/marketplace.php';


if (MAX_marketplaceEnabled()) {
    if (isset($_GET['indium'])) {
        if ($_GET['indium']) {
            if (!empty($conf['marketplace']['cacheTime'])) {
                $expiry = $conf['marketplace']['cacheTime'] < 0 ? null : MAX_commonGetTimeNow + $conf['marketplace']['cacheTime'];
            } else {
                $expiry = _getTimeYearFromNow();
            }
            MAX_cookieSet('In', '1', $expiry);
        }
    } else {
        $scriptName = basename(__FILE__);
        $oxpUrl = MAX_commonGetDeliveryUrl($scriptName).'?';
        if (!empty($_SERVER['QUERY_STRING'])) {
            $oxpUrl .= $_SERVER['QUERY_STRING'].'&';
        }
        $oxpUrl .= 'indium=INDIUM_OK';
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.
        $url .= $conf['marketplace']['indiumHost'].'/redir?r='.urlencode($oxpUrl);
        $url .= '&pid=OpenXDemo';
        $url .= '&cb='.mt_rand(0, PHP_INT_MAX);
        header("Location: {$url}");
        exit;
    }
}

MAX_commonDisplay1x1();

?>