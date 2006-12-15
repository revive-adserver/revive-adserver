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
$Id: maintenance-reports.php 6005 2006-11-17 15:48:13Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/other/lib-reports.inc.php';

MAX::debug('  Starting to send advertiser reports.', PEAR_LOG_DEBUG);
$query = "
    SELECT
        clientid,
        report,
        reportinterval,
        reportlastdate,
        UNIX_TIMESTAMP(reportlastdate) AS reportlastdate_t
    FROM
        {$conf['table']['prefix']}{$conf['table']['clients']}
    WHERE
        report = 't'";
MAX::debug('  Getting details of when advertiser reports were last sent.', PEAR_LOG_DEBUG);
$rResult = phpAds_dbQuery($query);
if (phpAds_dbNumRows($rResult) > 0) {
    while ($aAdvertiser = phpAds_dbFetchArray($rResult)) {
        // Determine date of interval days ago
        $intervaldaysago = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - ($aAdvertiser['reportinterval'] * (60 * 60 * 24));
        // Check if the date interval has been reached
        if (($aAdvertiser['reportlastdate_t'] <= $intervaldaysago && $aAdvertiser['reportlastdate'] != '0000-00-00') || ($aAdvertiser['reportlastdate'] == '0000-00-00')) {
            // Determine first and last date
            $last_unixtimestamp  = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
            $first_unixtimestamp = $aAdvertiser['reportlastdate_t'];
            // Send the advertiser's report
            phpAds_SendMaintenanceReport($aAdvertiser['clientid'], $first_unixtimestamp, $last_unixtimestamp, true);
        }
    }
}
MAX::debug('  Finished sending advertiser reports.', PEAR_LOG_DEBUG);

?>
