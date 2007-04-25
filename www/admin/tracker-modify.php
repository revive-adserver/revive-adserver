<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Register input variables
phpAds_registerGlobal (
     'duplicate'
    ,'moveto'
    ,'returnurl'
);


// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);
MAX_Permission::checkAccessToObject('trackers', $trackerid);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($trackerid))
{
    if (!empty($moveto))
    {
        // Delete any campaign-tracker links
        $doCampaign_trackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaign_trackers->trackerid = $trackerid;
        $doCampaign_trackers->delete();

        // Move the campaign
        $doTrackers = OA_Dal::factoryDO('trackers');
        if ($doTrackers->get($trackerid)) {
            $doTrackers->clientid = $moveto;
            $doTrackers->update();
        }

        Header ("Location: ".$returnurl."?clientid=".$moveto."&trackerid=".$trackerid);
        exit;
    }
    elseif (isset($duplicate) && $duplicate == 'true')
    {
        $doTrackers = OA_Dal::factoryDO('trackers');
        if ($doTrackers->get($trackerid))
        {
            $new_trackerid = $doTrackers->duplicate();
            Header ("Location: ".$returnurl."?clientid=".$clientid."&trackerid=".$new_trackerid);
            exit;
        }
    }
}

Header ("Location: ".$returnurl."?clientid=".$clientid."&trackerid=".$trackerid);

?>