<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.8                                                                |
| ==========                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: userlog.lang.php 81772 2012-09-11 00:07:29Z chris.nutting $
*/

// Set translation strings

$GLOBALS['strDeliveryEngine']				= "投放引擎";
$GLOBALS['strMaintenance']					= "维护";
$GLOBALS['strAdministrator']				= "管理员";

// Audit
$GLOBALS['strLogging']                      = "Logging";
$GLOBALS['strAudit']                        = "Audit Log";
$GLOBALS['strDebugLog']                     = "Debug Log";
$GLOBALS['strEvent']                        = "事件";
$GLOBALS['strTimestamp']                    = "时间";
$GLOBALS['strDeleted']                      = "删除";
$GLOBALS['strInserted']                     = "添加";
$GLOBALS['strUpdated']                      = "更新";
$GLOBALS['strDelete']                       = "Delete";
$GLOBALS['strInsert']                       = "Insert";
$GLOBALS['strUpdate']                       = "Update";
$GLOBALS['strHas']                          = "has";
$GLOBALS['strFilters']                      = "过滤";
$GLOBALS['strAdvertiser']                   = "客户";
$GLOBALS['strPublisher']                    = "媒体";
$GLOBALS['strCampaign']                     = "项目";
$GLOBALS['strZone']                         = "版位";
$GLOBALS['strType']                         = "类型";
$GLOBALS['strAction']                       = "操作";
$GLOBALS['strParameter']                    = "参数";
$GLOBALS['strValue']                        = "值";
$GLOBALS['strDetailedView']                 = "Detailed View";
$GLOBALS['strReturnAuditTrail']             = "返回";
$GLOBALS['strAuditTrail']                   = "Audit trail";
$GLOBALS['strMaintenanceLog']               = "Maintenance log";
$GLOBALS['strAuditResultsNotFound']         = "No events found matching the selected criteria";
$GLOBALS['strCollectedAllEvents']           = "所有";
$GLOBALS['strClear']                        = "重置";

$GLOBALS['strUserlog'] = array (
	phpAds_actionAdvertiserReportMailed 	=> "Report for advertiser {id} send by email",
	phpAds_actionActiveCampaign				=> "Campaign {id} activated",
	phpAds_actionAutoClean					=> "Auto clean of database",
	phpAds_actionBatchStatistics			=> "Statistics compiled",
	phpAds_actionDeactivationMailed			=> "Deactivation notification for campaign {id} send by email",
	phpAds_actionDeactiveCampaign			=> "Campaign {id} deactivated",
	phpAds_actionPriorityCalculation		=> "Priority recalculated",
	phpAds_actionPublisherReportMailed 		=> "Report for website {id} send by email",
	phpAds_actionWarningMailed				=> "Deactivation warning for campaign {id} send by email"
);
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Activation notification for campaign {id} send by email";

?>
