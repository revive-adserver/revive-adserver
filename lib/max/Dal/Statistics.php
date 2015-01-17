<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
 */
class MAX_Dal_Statistics extends MAX_Dal_Common
{

    /**
     * The constructor method.
     *
     * @return MAX_Dal_Statistics
     */
    function __construct()
    {
        parent::__construct();
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