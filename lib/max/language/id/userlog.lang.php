<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                          |
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

$GLOBALS['strDeliveryEngine']				= "Mesin Penyampaian";
$GLOBALS['strMaintenance']				= "Pemeliharaan";
$GLOBALS['strAdministrator']				= "Administrator";


$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Pengiriman laporan kepada Pemasang Iklan {id} melalui E-mail telah dilakukan.";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Pengiriman laporan kepada Penerbit {id} melalui E-mail telah dilakukan.";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Pengiriman laporan tentang pemberhentian untuk kampanye {id} melalui E-mail telah dilakukan.";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Pengiriman notifikasi tentang pemberhentian untuk kampanye {id} melalui E-mail telah dilakukan.";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Rekalkulasi prioritas telah dilakukan.";
$GLOBALS['strUserlog'][phpAds_actionPriorityAutoTargeting] = "Rekalkulasi target kampanye telah dilakukan.";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Kampanye {id} telah dihentikan.";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Kampanye {id} telah diaktifkan.";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Pembersihan database secara otomatis.";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strAdvertiser'] = "Pemasang Iklan";
$GLOBALS['strPublisher'] = "Penerbit";
$GLOBALS['strType'] = "Jenis";
$GLOBALS['strDeleted'] = "Hapus";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Pengiriman notifikasi tentang pemberhentian untuk kampanye {id} melalui E-mail telah dilakukan.";
?>