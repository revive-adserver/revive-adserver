<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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