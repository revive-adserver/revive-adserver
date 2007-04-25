<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsCrossHistoryController.php';



/**
 * Controller class for displaying daily history type statistics screens
 *
 * Always use the factory method to instantiate fields -- it will create
 * the right subclass for you.
 *
 * The class inherits from StatsCrossHistoryController because it can also be used
 * to display cross-entity statistics
 *
 * @package    Max
 * @subpackage Admin_Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 *
 * @see StatsControllerFactory
 */
class StatsDailyController extends StatsCrossHistoryController
{
    /**
     * PHP5-style constructor
     */
    function __construct($params)
    {
        // Get day parameter
        $this->parseDay();
        
        // Prepare context
        $this->pageContext = array('days', $this->aDates['day_begin']);

        parent::__construct($params);
    }

    /**
     * PHP4-style constructor
     */
    function StatsDailyController($params)
    {
        $this->__construct($params);
    }

    /**
     * Output the controller object using the breakdown_by_date template
     * and hiding the breakdown selector
     */
    function output($null, $graph_mode = false)
    {
        $oDate = new Date($this->aDates['day_begin']);
        $this->_addBreadcrumb($oDate->format($GLOBALS['date_format']), 'images/icon-date.gif');
        
        if($graph_mode) {
             parent::outputGraph($elements);        
        } else {
             parent::output(false);
        }
    }
    
    /**
     * Prepare context using the last settings of the statistics day-span
     * selector, falling back to the parent class function if not applicable
     *
     * @param string Context type, it should be 'days' to get this method working
     * @param string Selected day, in the Y-m-d format
     */
    function showContext($type, $current_day)
    {
        if ($type == 'days') {
            $aDates = array(
                'day_begin' => MAX_getStoredValue('period_start', date('Y-m-d')),
                'day_end'   => MAX_getStoredValue('period_end', date('Y-m-d')),
            );
            $dates = array_reverse($this->_getDatesArray('day', $aDates, $this->startDate));
            foreach ($dates as $day  => $date_f) {
                phpAds_PageContext (
                    $date_f,
                    $this->pageURI.'day='.str_replace('-', '', $day),
                    $current_day == $day
                );
            }
        } else {
            parent::showContext($type, $current_day);
        }
    }
    
    /**
     * Parse and store the day paramer, also checking its validity
     */
    function parseDay()
    {
        $day = MAX_getValue('day', '');
        if (!preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/D', $day, $matches)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }
        
        if (!checkdate($matches[2], $matches[3], $matches[1])) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }
        
        $this->aDates = array();
        $this->aDates['day_begin'] = $this->aDates['day_end'] =
            "{$matches[1]}-{$matches[2]}-{$matches[3]}";
    }
    
    /**
     * Fetch and decorates the history stats using the specified parameters
     * forcing the breakdown type to hour
     *
     * @param array Query parameters
     */
    function prepareHistory($aParams)
    {
        $this->statsBreakdown = 'hour';
        
        parent::prepareHistory($aParams);
    }
}

?>
