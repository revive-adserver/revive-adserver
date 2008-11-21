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


// Set translation strings

$GLOBALS['strDeliveryEngine']				= "Kiszolgáló motor";
$GLOBALS['strMaintenance']					= "Karbantartás";
$GLOBALS['strAdministrator']				= "Adminisztrátor";


$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Jelentés küldése (id) hirdető részére e-mailben";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Jelentés küldése (id) kiadó részére e-mailben";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "{id} kampány inaktiválásra való figyelmeztetés küldése emailben";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "{id} kampány inaktiválásra való figyelmeztetés küldése emailben";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Prioritás újraszámolva";
$GLOBALS['strUserlog'][phpAds_actionPriorityAutoTargeting] = "Kampány célok újraszámolva";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "A(z) {id} kampány deaktiválva";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "A(z) {id} kampány aktiválva";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Adatbázis automatikus tisztítása";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strAdvertiser'] = "Hirdető";
$GLOBALS['strDeleted'] = "Töröl";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "{id} kampány inaktiválásra való figyelmeztetés küldése emailben";
?>