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

require_once MAX_PATH . '/lib/OA/Dal/Statistics/Targeting.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/History.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Targeting/Common.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display ad-level targeting statistics.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsTargeting
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Targeting_CommonAd extends OA_Admin_Statistics_Targeting_Common
{

    /**
     * The final "child" implementation of the parental abstract method,
     * to test if the appropriate data array is empty, or not.
     *
     * @see OA_Admin_Statistics_Common::_isEmptyResultArray()
     *
     * @access private
     * @return boolean True on empty, false if at least one row of data.
     */
    function _isEmptyResultArray()
    {
        if (!is_array($this->aStatsData)) {
            return true;
        }
        foreach($this->aStatsData as $aRecord) {
            if (
                $aRecord['ad_required_impressions']  != '-' ||
                $aRecord['ad_requested_impressions'] != '-' ||
                $aRecord['ad_actual_impressions']    != '-'
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * A method to prepare targeting statistcs data for display by the
     * {@link OA_Admin_Statistics_Common::output()} method.
     *
     * @param array $aParams An array containing the "ad_id".
     * @param string $link   Optional link file name for the LHC day breakdown link.
     */
    function prepare($aParams, $link = '')
    {
        // Set the span requirements
        $this->oHistory->getSpan($this, $aParams);

        // Set the current breakdown information, and get the required DAL method
        $method = $this->oHistory->setBreakdownInfo($this, 'targeting');

        $oStartDate = new Date($this->aDates['day_begin']);
        $oEndDate   = new Date($this->aDates['day_end']);
        $oDal = new OA_Dal_Statistics_Targeting();
        $aStats = $oDal->$method($aParams['ad_id'], 'ad', $oStartDate, $oEndDate);

        if (count($aStats) == 0) {
            // There are no stats!
            $this->noStatsAvailable = true;
            $this->aStatsData = array();
            return;
        }

        // Pad out any missing items in the stats array,
        // and ensure that links are correctly set
        $aDates = $this->oHistory->getDatesArray($this->aDates, $this->statsBreakdown, $this->oStartDate);
        $this->oHistory->fillGapsAndLink($aStats, $aDates, $this, $link);

        // Ensure the stats array for the range is filled
        foreach (array_keys($aStats) as $k) {
            $aStats[$k] += $this->aEmptyRow;
        }

        if (!in_array($this->listOrderField, array_merge(array($this->statsBreakdown), array_keys($this->aColumns)))) {
            $this->listOrderField = $this->statsBreakdown;
            $this->listOrderDirection = $this->statsBreakdown == 'hour' || $this->statsBreakdown == 'dow' ? 'up' : 'down';
        }

        // If required, re-format the data in the weekly breakdown format
        if ($this->statsBreakdown == 'week') {
            $this->oHistory->prepareWeekBreakdown($aStats, $this);
        }

        // Summarise the values into a the totals array & format
        $this->_summariseTotalsAndFormat($aStats, true);

        MAX_sortArray($aStats, $this->listOrderField, $this->listOrderDirection == 'up');

        // Format the rows appropriately for output
        if ($this->statsBreakdown == 'week') {
            $this->oHistory->formatWeekRows($aStats, $this);
            $this->oHistory->formatWeekRowsTotal($this->aTotal, $this);
        } else {
            $this->oHistory->formatRows($aStats, $this);
        }

        $this->aStatsData = $aStats;
    }

}

?>
