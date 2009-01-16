<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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
$Id$
*/

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/OA.php';


require_once OX_PATH . '/lib/OX.php';
require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * The non-DB specific Common Data Access Layer (DAL) class for obtaining
 * statistics data from the database.
 *
 * @package    MaxDal
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Dal_Statistics extends MAX_Dal_Common
{

    /**
     * The constructor method.
     *
     * @return MAX_Dal_Statistics
     */
    function MAX_Dal_Statistics()
    {
        parent::MAX_Dal_Common();
    }

    /**
     * A method to determine the day/hour that a placement first became active,
     * based on the first record of its children ads delivering.
     *
     * @param integer $placementId The placement ID.
     * @return mixed PEAR:Error on database error, null on no result, or a
     *               PEAR::Date object representing the time the placement started
     *               delivery, or, if not yet active, the current date/time.
     */
    function getPlacementFirstStatsDate($placementId)
    {
        // Test the input values
        if (!is_numeric($placementId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $adTable = $this->oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['banners'],true);
        $dsahTable = $this->oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'],true);
        $query = "
            SELECT
                DATE_FORMAT(dsah.date_time, '%Y-%m-%d') AS day,
                HOUR(dsah.date_time) AS hour
            FROM
                $adTable AS a,
                $dsahTable AS dsah
            WHERE
                a.campaignid = ". $this->oDbh->quote($placementId, 'integer') ."
                AND
                a.bannerid = dsah.ad_id
            ORDER BY
                day ASC, hour ASC
            LIMIT 1";
        $message = "Finding start date of placement ID $placementId based on delivery statistics.";
        OA::debug($message, PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return $rc;
        }
        // Was a result found?
        if ($rc->numRows() == 0) {
            // Return the current time
            $oDate = new Date();
        } else {
            // Store the results
            $aRow = $rc->fetchRow();
            $oDate = new Date($aRow['day'] . ' ' . $aRow['hour'] . ':00:00');
        }
        return $oDate;
    }

}