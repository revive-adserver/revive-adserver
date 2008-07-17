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