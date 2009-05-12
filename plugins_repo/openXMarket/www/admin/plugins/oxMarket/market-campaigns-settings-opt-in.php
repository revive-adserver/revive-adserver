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

require_once 'market-common.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

phpAds_registerGlobalUnslashed('optInType', 'toOptIn', 'campaignType', 'minCpm');

// TODO: Opt-in campaigns based on the submitted values
if ($optInType == 'remnant') {
//    echo 'Opt in all remnant campaigns at ' . $minCpm;

    // TODO: Put the number of actually opted-in campaigns here
    $campaignsOptedIn = 45;
    OA_Admin_UI::queueMessage($campaignsOptedIn . ' remnant campaigns have been opted in to OpenX Market with minimum CPM of ' . $minCpm . ' USD', 
        'local', 'confirm', 0);
} else {
    foreach ($toOptIn as $campaignId) {
//    echo 'Opt in campaign ' . $campaignId . ' at ' . $_REQUEST['cpm' . $campaignId] . '<br />';
    }
    
    // TODO: Put the number of actually opted-in campaigns here
    $campaignsOptedIn = count($toOptIn);
    OA_Admin_UI::queueMessage($campaignsOptedIn . ' campaigns have been opted in to OpenX Market', 'local', 'confirm', 0);
}


// Redirect back to the opt-in page
$params = array('optInType' => $optInType, 'campaignType' => $campaignType);
OX_Admin_Redirect::redirect('plugins/oxMarket/market-campaigns-settings.php?' . http_build_query($params));
?>