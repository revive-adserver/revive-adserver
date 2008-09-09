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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Targeting/Flexy.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display targeting statistics.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsTargeting
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Targeting_Common extends OA_Admin_Statistics_Targeting_Flexy
{

    /**
     * The starting day of the page's report span.
     *
     * @var PEAR::Date
     */
    var $oStartDate;

    /**
     * The number of days that the page's report spans.
     *
     * @var integer
     */
    var $spanDays;

    /**
     * The number of weeks that the page's report spans.
     *
     * @var integer
     */
    var $spanWeeks;

    /**
     * The number of months that the page's report spans.
     *
     * @var integer
     */
    var $spanMonths;

    /**
     * The type of statistics breakdown to display. One of:
     *  - hour
     *  - day
     *  - week
     *  - month
     *  - dow (ie. Day of Week)
     *
     * @var string
     */
    var $statsBreakdown;

    /**
     * Enter description here...
     *
     * @var unknown_type
     */
    var $statsKey;

    /**
     * Enter description here...
     *
     * @var unknown_type
     */
    var $averageDesc;

    /**
     * A PHP5-style constructor that can be used to perform common
     * class instantiation by children classes.
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function __construct($aParams)
    {
        // Set the output type & template directory for targeting statistcs
        $this->outputType = 'targetingHistory';
        $this->templateDir = MAX_PATH . '/lib/OA/Admin/Statistics/Targeting/themes/';

        // Get list order and direction
        $this->listOrderField     = MAX_getStoredValue('listorder', 'key');
        $this->listOrderDirection = MAX_getStoredValue('orderdirection', 'down');

        // Ensure the history class is prepared
        $this->useHistoryClass = true;

        // Disable graphs in targeting pages
        $this->aGraphData = array(
            'noGraph' => true
        );

        parent::__construct($aParams);

        // Store the preferences
        $this->aPagePrefs['listorder']      = $this->listOrderField;
        $this->aPagePrefs['orderdirection'] = $this->listOrderDirection;
    }

    /**
     * PHP4-style constructor
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function OA_Admin_Statistics_Targeting_Common($aParams)
    {
        $this->__construct($aParams);
    }

    /**
     * A private method that can be inherited and used by children classes to
     * load the required plugins during instantiation.
     *
     * @access private
     */
    function _loadPlugins()
    {
        require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Targeting/Default.php';
        $aPlugins['default'] = & new OA_StatisticsFieldsTargeting_Default();
        $this->aPlugins = $aPlugins;
    }

    /**
     * Create the error string to display when delivery statistics are not available.
     *
     * @return string The error string to display.
     */
    function showNoStatsString()
    {
        if (!empty($this->aDates['day_begin']) && !empty($this->aDates['day_end'])) {
            $startDate = new Date($this->aDates['day_begin']);
            $startDate = $startDate->format($GLOBALS['date_format']);
            $endDate   = new Date($this->aDates['day_end']);
            $endDate   = $endDate->format($GLOBALS['date_format']);
            return sprintf($GLOBALS['strNoTargetingStatsForPeriod'], $startDate, $endDate);
        }
        return $GLOBALS['strNoTargetingStats'];
    }

    /**
     * A private method that can be inherited and used by children classes to
     * calculate the CTR and SR ratios of the impressions, clicks and conversions
     * that are to be displayed.
     *
     * @access private
     * @param array Row of stats
     */
    function _summarizeStats(&$row)
    {
        foreach ($this->aPlugins as $oPlugin) {
            $oPlugin->summarizeStats($row);
        }
    }
}

?>
