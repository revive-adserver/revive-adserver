<?php // $Revision: 2.0 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


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