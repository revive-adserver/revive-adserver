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

$GLOBALS['strDeliveryEngine']				= "發送引擎";
$GLOBALS['strMaintenance']				= "維護";
$GLOBALS['strAdministrator']				= "管理員";


$GLOBALS['strUserlog'] = array (
	phpAds_actionAdvertiserReportMailed 		=> "通過電子郵件發送報告給客戶{id}",
	phpAds_actionPublisherReportMailed 		=> "通過電子郵件發送報告給發佈人{id}",
	phpAds_actionWarningMailed			=> "通過電子郵件發送項目{id}停用警告",
	phpAds_actionDeactivationMailed			=> "通過電子郵件發送項目{id}停用通知",
	phpAds_actionPriorityCalculation		=> "重新計算優先權",
	phpAds_actionPriorityAutoTargeting		=> "重新計算項目目標",
	phpAds_actionDeactiveCampaign			=> "項目{id}已經停用",
	phpAds_actionActiveCampaign			=> "項目{id}已經啟用",
	phpAds_actionAutoClean				=> "資料庫自動清理"
);

?>