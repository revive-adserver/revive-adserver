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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsHistoryController.php';



class StatsGlobalHistoryController extends StatsHistoryController
{
    function start()
    {
        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        // Add module page parameters
        $this->pageParams['entity'] = 'global';
        $this->pageParams['breakdown'] = MAX_getValue('breakdown', '');
        $this->pageParams['period_preset'] = MAX_getStoredValue('period_preset', 'today');
        $this->pageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');

        $this->loadParams();

        // HTML Framework
        $this->pageId = '2.2';
        $this->pageSections = array('2.1', '2.4', '2.2');

        // Use the day span selector
        $this->initDaySpanSelector();

        $aParams = array();
        if (phpAds_isUser(phpAds_Agency)) {
            $aParams['agency_id'] = phpAds_getAgencyID();
        }

        $this->prepareHistory($aParams, 'stats.php?entity=global&breakdown=daily');
    }
}

?>
