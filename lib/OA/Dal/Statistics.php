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

/**
 * @package    OpenX
 */


/**
 * Satistics methods description class.
 *
 * @package    OpenXDal
 */
class OA_Dal_Statistics extends OA_Dal
{
    /**
     * Get SQL where for statistics methods.
     *
     *  @access public
     *
     * @param Date   $oStartDate
     * @param Date   $oEndDate
     * @param bool   $localTZ
     * @param string $dateField
     *
     * @return string
     */
    function getWhereDate($oStartDate, $oEndDate, $localTZ = false, $dateField = 's.date_time')
    {
        $where = '';
        if (isset($oStartDate)) {
            $oStart = $this->setTimeAndReturnUTC($oStartDate, $localTZ, 0, 0, 0);
            $where .= '
                AND ' .
                $dateField .' >= '.$this->oDbh->quote($oStart->getDate(DATE_FORMAT_ISO), 'timestamp');
        }

        if (isset($oEndDate)) {
            $oEnd = $this->setTimeAndReturnUTC($oEndDate, $localTZ, 23, 59, 59);
            $where .= '
                AND ' .
                $dateField .' <= '.$this->oDbh->quote($oEnd->getDate(DATE_FORMAT_ISO), 'timestamp');
        }
        return $where;
    }

    /**
     * A private method to return the current TimeZone as selected by the useUTC parameter
     *
     * @param bool $localTZ
     * @return Date_TimeZone
     */
    private function getTimeZone($localTZ = false)
    {
        if (empty($localTZ)) {
            $oTz = new Date_TimeZone('UTC');
        } else {
            $oNow = new Date();
            $oTz = $oNow->tz;
        }

        return $oTz;
    }

    /**
     * A private method used to return a copy of a Date object after altering its time. It can work using
     * either UTC or the current TZ and eventually converting the result back to UTC.
     *
     * @param Date $oDate
     * @param bool $localTZ
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return Date
     */
    private function setTimeAndReturnUTC($oDate, $localTZ = false, $hour = 0, $minute = 0, $second = 0)
    {
        $oTz = $this->getTimeZone($localTZ);

        $oDateCopy = new Date($oDate);
        $oDateCopy->setHour($hour);
        $oDateCopy->setMinute($minute);
        $oDateCopy->setSecond($second);
        $oDateCopy->setTZ($oTz);
        $oDateCopy->toUTC();

        return $oDateCopy;
    }

    /**
     * A method that runs the supplied query and returns data grouped by day either in UTC or manager's TZ
     *
     * The query needs to return "day" and "hour" fields. Any other field will be aggregated with a SUM()
     *
     * @param string $query
     * @param bool $localTZ
     * @return array
     */
    function getDailyStatsAsArray($query, $localTZ = false)
    {
        $oTz  = $this->getTimeZone($localTZ);
        if ($oTz->getShortName() == 'UTC') {
            // Disable TZ conversion
            $oTz = false;
        } else {
            $oUTC = new Date_TimeZone('UTC');
        }
        $aResult = array();
        $oResult = $this->oDbh->query($query);
        while ($aRow = $oResult->fetchRow()) {
            if ($oTz) {
                $oDate = new Date($aRow['day']);
                $oDate->setHour($aRow['hour']);
                $oDate->setTZ($oUTC);
                $oDate->convertTZ($oTz);
                $aRow['day'] = $oDate->format('%Y-%m-%d');
            }
            // Remove day & hour
            unset($aRow['hour']);
            // Add entry
            if (!isset($aResult[$aRow['day']])) {
                $aResult[$aRow['day']] = $aRow;
            } else {
                foreach ($aRow as $k => $v) {
                    // Perform SUM() GROUP BY day
                    if ($k == 'day') {
                        continue;
                    }
                    $aResult[$aRow['day']][$k] += $v;
                }
            }
        }

        return array_values($aResult);
    }

    /**
     * Add quote for table name.
     *
	 * @access public
	 *
     * @param string $tableName
     *
     * @return string  quotes table name
     */
    function quoteTableName($tableName)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        return $this->oDbh->quoteIdentifier(
                            $aConf['table']['prefix'].$aConf['table'][$tableName],
                            true);
    }

}

?>