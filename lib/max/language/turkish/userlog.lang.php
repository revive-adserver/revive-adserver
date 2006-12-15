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


/* Turkish Translation by :												*/
/* 		Metin AKTA� (metin@yapayzeka.net)								*/
/* 		B�nyamin VICIL (bunyamin@yapayzeka.net)					        */
/*----------------------------------------------------------------------*/

// Set translation strings

$GLOBALS['strDeliveryEngine']				= "Teslimat Motoru";
$GLOBALS['strMaintenance']					= "Bak�m";
$GLOBALS['strAdministrator']				= "Y�netici";


$GLOBALS['strUserlog'] = array (
	phpAds_actionAdvertiserReportMailed 	=> "{id} reklamc�ya e-mail yolu ile rapor g�nder",
	phpAds_actionPublisherReportMailed 		=> "{id} yay�nc�ya e-mail yolu ile rapor g�nder",
	phpAds_actionWarningMailed				=> "{id} e-mail yolu ile kampanyalar i�in pasif etme uyar�s� g�nder",
	phpAds_actionDeactivationMailed			=> "{id} e-mail yolu ile kampanyalar i�in pasif etme bildirisi g�nder",
	phpAds_actionPriorityCalculation		=> "�ncelikler tekrar hesapland�",
	phpAds_actionPriorityAutoTargeting		=> "Kampanya hedefleri tekrar hesapland�",
	phpAds_actionDeactiveCampaign			=> "{id} kampanya pasif edildi",
	phpAds_actionActiveCampaign				=> "{id} kampanya aktif edildi",
	phpAds_actionAutoClean					=> "Veritaban�n� otomatik temizle"
);

?>