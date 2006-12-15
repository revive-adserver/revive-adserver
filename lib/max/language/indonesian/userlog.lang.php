<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: userlog.lang.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/


// Set translation strings

$GLOBALS['strDeliveryEngine']				= "Mesin Penyampaian";
$GLOBALS['strMaintenance']				= "Pemeliharaan";
$GLOBALS['strAdministrator']				= "Administrator";


$GLOBALS['strUserlog'] = array (
	phpAds_actionAdvertiserReportMailed 		=> "Pengiriman laporan kepada Pemasang Iklan {id} melalui E-mail dilakukan.",
	phpAds_actionPublisherReportMailed 		=> "Pengiriman laporan kepada Penerbit {id} melalui E-mail dilakukan.",
	phpAds_actionWarningMailed			=> "Pengiriman laporan tentang pemberhentian untuk kampanye {id} melalui E-mail dilakukan.",
	phpAds_actionDeactivationMailed			=> "Pengiriman notifikasi tentang pemberhentian untuk kampanye {id} melalui E-mail dilakukan.",
	phpAds_actionPriorityCalculation		=> "Rekalkulasi prioritas dilakukan.",
	phpAds_actionPriorityAutoTargeting		=> "Rekalkulasi target kampanye dilakukan.",
	phpAds_actionDeactiveCampaign			=> "Kampanye {id} dihentikan.",
	phpAds_actionActiveCampaign			=> "Kampanye {id} diaktifkan.",
	phpAds_actionAutoClean				=> "Pembersihan database secara otomatis."
);

?>
