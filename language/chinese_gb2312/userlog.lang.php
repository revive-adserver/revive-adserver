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

$GLOBALS['strDeliveryEngine']				= "发送引擎";
$GLOBALS['strMaintenance']				= "维护";
$GLOBALS['strAdministrator']				= "管理员";


$GLOBALS['strUserlog'] = array (
	phpAds_actionAdvertiserReportMailed 		=> "通过电子邮件发送报告给客户{id}",
	phpAds_actionPublisherReportMailed 		=> "通过电子邮件发送报告给发布人{id}",
	phpAds_actionWarningMailed			=> "通过电子邮件发送项目{id}停用警告",
	phpAds_actionDeactivationMailed			=> "通过电子邮件发送项目{id}停用通知",
	phpAds_actionPriorityCalculation		=> "重新计算优先权",
	phpAds_actionPriorityAutoTargeting		=> "重新计算项目目标",
	phpAds_actionDeactiveCampaign			=> "项目{id}已经停用",
	phpAds_actionActiveCampaign			=> "项目{id}已经启用",
	phpAds_actionAutoClean				=> "数据库自动清理"
);

?>