<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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
require_once '../../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';

// Register input variables
phpAds_registerGlobal ('country', 'language');

// Security check
MAX_Permission::checkAccess(phpAds_Admin);

$oAdNetworks = new OA_Central_AdNetworks();
$aOtherNetworks = $oAdNetworks->getOtherNetworks();

// If a country was selected, filter on country
if (!empty($country) && ($country != 'undefined')) {
    foreach ($aOtherNetworks as $networkName => $networkDetails) {
        // If this network is not global
        if (!$networkDetails['is_global']) {
            if (!isset($networkDetails['countries'][strtolower($country)])) {
                // No country specific URL for this non-global network so remove it from the list
                unset($aOtherNetworks[$networkName]);
            } else {
                // There is a specific URL for this country, so set this for use in the templated
                $aOtherNetworks[$networkName]['url'] = $networkDetails['countries'][strtolower($country)];
            }
        }
    }
}

// If a language was selected, filter on language
if (!empty($language) && ($language != 'undefined')) {
    foreach ($aOtherNetworks as $networkName => $networkDetails) {
        // If this network is not global
        if (!$networkDetails['is_global']) {
            if (!isset($networkDetails['languages'][$language])) {
                // No language entry for the selected non-global network
                unset($aOtherNetworks[$networkName]);
            }
        }
    }
}

// Create the output template
$oTpl = new OA_Admin_Template('ajax/find-other-networks.html');

$oTpl->assign('aOtherNetworks', $aOtherNetworks);

$oTpl->display();

?>