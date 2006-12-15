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

$GLOBALS['strDeliveryEngine']				= "전달유지 엔진";
$GLOBALS['strMaintenance']					= "유지보수";
$GLOBALS['strAdministrator']				= "관리자";


$GLOBALS['strUserlog'] = array (
	phpAds_actionAdvertiserReportMailed 	=> "광고주 {id}에게 보고서를 이메일로 보냅니다.",
	phpAds_actionPublisherReportMailed 		=> "광고게시자 {id}에게 보고서를 이메일로 보냅니다.",
	phpAds_actionWarningMailed				=> "캠페인 {id}에 대한 활성화해제를 이메일로 경고합니다.",
	phpAds_actionDeactivationMailed			=> "캠페인 {id}에 대한 활성화해제를 이메일로 알립니다.",
	phpAds_actionPriorityCalculation		=> "우선순위 다시 계산",
	phpAds_actionPriorityAutoTargeting		=> "캠페인 대상 재계산",
	phpAds_actionDeactiveCampaign			=> "캠페인 {id} 활성화해제",
	phpAds_actionActiveCampaign				=> "캠페인 {id} 활성화",
	phpAds_actionAutoClean					=> "데이터베이스 자동 정리"
);

?>