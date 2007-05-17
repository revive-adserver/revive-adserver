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

require_once MAX_PATH . '/lib/max/Forecast.php';
require_once MAX_PATH . '/lib/max/Dal/Forecasting.php';

require_once 'Date.php';

/** 
 *
 * Class used to forecast channel request/impressions/clicks for an ad
 * (for ad's linked zones)
 *
 * @package    Max
 * @author     Radek Maciaszek <radek@m3.net>
 */
class MAX_Forecast_Ad
{
    var $_oForecast;
    var $startDate;
    var $endDate;
    
    var $forecastingAlgorithm;
    
    /**
     * Constructor
     */
    function MAX_Forecast_Ad()
    {
        $this->_init();
    }
    
    /**
     * Return start date
     *
     * @return string  Start date
     */
    function getStartDate()
    {
        return $this->startDate;
    }
    
    /**
     * Return end date
     *
     * @return string  End date
     */
    function getEndDate()
    {
        return $this->endDate;
    }
    
    /**
     * Return end day (only YYYY-MM-DD)
     *
     * @return string  Day
     */ 
    function getEndDay()
    {
        return substr($this->endDate, 0, 10);
    }
    
    /**
     * Initialize object. Register ServiceLocator objects
     */
    function _init()
    {
        // Register DAL
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('MAX_Dal_Forecasting');
        if (!$oDal) {
            $oDal = &MAX_Dal_Forecasting::singleton();
            $oServiceLocator->register('MAX_Dal_Forecasting', $oDal);
        }
        // Register Date
        $oServiceLocator = &ServiceLocator::instance();
        $oDate = &$oServiceLocator->get('Now');
        if (!$oDate) {
            $oDate = &new Date();
            $oServiceLocator->register('Now', $oDate);
        }
        
        $this->_oForecast = new MAX_Forecast();
        
        $this->forecastingAlgorithm = 'simple';
    }
    
    /**
     * Return MAX_Forecast object
     */
    function &_getForecast()
    {
        return $this->_oForecast;
    }
    
    /**
     * This method check dates in campaign linked with ad. If campaign doesn't have starting
     * and/or ending dates method return current date plus/minus daysBack and daysAhead
     * which are defined in config file.
     *
     * @param int $adId      Ad ID
     * @param object $oDate  PEAR::Date object (optional) If empty current date is used.
     * @return array  Array of two dates (strings) start and end, example:
     *         array(
     *              'start' => '2005-09-02 00:00:00'
     *              'end'   => '2005-09-14 00:00:00'
     */
    function getStartEndDatesForAd($adId, $oDate = null)
    {
        if (empty($oDate)) {
            $oDate = new Date();
        }
        
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('MAX_Dal_Forecasting');
        
        $campaign = $oDal->getCampaignByAdId($adId);
        if ($campaign === false) {
            return false;
        }
        
        $daysBack     = $GLOBALS['_MAX']['CONF']['maintenance']['channelForecastingDaysBack'];
        $daysAhead    = $GLOBALS['_MAX']['CONF']['maintenance']['channelForecastingDaysAhead'];
        $maxDaysAhead = $GLOBALS['_MAX']['CONF']['maintenance']['channelForecastingMaxDaysAhead'];
        $secondsInDay = 24*60*60;
        
        if (!isset($campaign['activate']) || $campaign['activate'] == '0000-00-00') {
            $oStartDate = new Date();
            $oStartDate->copy($oDate);
            $oStartDate->subtractSeconds($daysBack * $secondsInDay);
            $startDate = $oStartDate->format('%Y-%m-%d 00:00:00');
        } else {
            $startDate = $campaign['activate'].' 00:00:00';
        }
        if (!isset($campaign['expire']) || $campaign['expire'] == '0000-00-00') {
            $oEndDate = new Date();
            $oEndDate->copy($oDate);
            $oEndDate->addSeconds($daysAhead * $secondsInDay);
            $endDate = $oEndDate->format('%Y-%m-%d 00:00:00');
        } else {
            $endDate = $campaign['expire'].' 00:00:00';
        }
        
        // Check if endDate is not too ahead
        $daysTillToday = Date_Calc::dateToDays($oDate->day, $oDate->month, $oDate->year);
        
        $checkEndDate = new Date($endDate);
        $oDate->addSeconds($maxDaysAhead * $secondsInDay);
        if(Date::compare($checkEndDate, $oDate) > 0) {
            // Use maximum date
            $endDate = $oDate->format('%Y-%m-%d 00:00:00');
        }
        
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        
        $oEndDate = new Date($endDate);
        $daysTillEndDay = Date_Calc::dateToDays($oEndDate->day, $oEndDate->month, $oEndDate->year);
        
        $dates = array();
        $dates['start']        = $startDate;
        $dates['end']          = $endDate;
        $dates['forecastDays'] = (int) ($daysTillEndDay - $daysTillToday);
        
        return $dates;
    }
    
    /**
     * Method return history data for ad between dates. If $agencyId and $affiliateIds are specified
     * get history data for all channels available for agency/affiliates
     *
     * @param int    $adId         Ad ID
     * @param int    $agencyId     Agency ID
     * @param array  $affiliateIds Affiliate IDs
     * @param string $startDate    Start date (in ISO)
     * @param string $endDate      End date (in ISO)
     * @return array  Array contaning history data for every channel linked to this ad
     */
    function getChannelsHistory($adId, $startDate, $endDate, $agencyId = null, $affiliateIds = null)
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('MAX_Dal_Forecasting');
        
        if($agencyId && $affiliateIds) {
            $channelsIds = $oDal->getAvailableChannelsByAgencyAndAffiliates($agencyId, $affiliateIds);
        } else {
            $channelsIds = $oDal->getAdChannelsIds($adId);
        }
        if($channelsIds === false) {
            return false;
        }
        
        $zonesIds = $oDal->getZonesIdsByAdId($adId);
        if($zonesIds === false) {
            return false;
        }
        
        // Get history data for channels/zones in chosen dates
        $history = array();
        foreach ($channelsIds as $channelId) {
            $history[$channelId] = $oDal->getChannelSummaryForZones($channelId, $zonesIds, $startDate, $endDate);
        }
        
        return $history;
    }
    
    /**
     * This method group history data into days
     *
     * @param array $history  History data
     * @return array          History data grouped in days
     */
    function groupHistoryInDays($history)
    {
        $daysHistory = array();
        foreach ($history as $dayHour => $data) {
            $day = substr($dayHour, 0, 10);
            $hour = substr($dayHour, 11, 2);
            $daysHistory[$day][$hour] = $data;
        }
        return $daysHistory;
    }
    
    /**
     * Forecast data for last day
     *
     * @param array $groupedHistory  History data grouped into days
     * @param string $lastDay        Last day
     * @param int $forecastIntervals For how many intervals forecast data
     * @return bool                  True or false if any error occured
     */
    function forecastLastDay(&$groupedHistory, $lastDay, $forecastIntervals)
    {
        $dataTypes = explode(',', $GLOBALS['_MAX']['CONF']['maintenance']['channelForecasting']);
        
        $aForecastedValues = array();
        foreach ($dataTypes as $dataType)
        {
            // take a last key from previous day
            $lastKey = null;
            
            $historyData = array();
            foreach ($groupedHistory as $day => $dayData) {
                foreach ($dayData as $hour => $data) {
                    $historyData[] = $data[$dataType];
                }
                if(!$lastKey) {
                    $lastKey = $hour;
                }
            }
            
            $oForecast = $this->_getForecast();
            $oForecast->setAlgorithm($this->forecastingAlgorithm);
            $oForecast->setHistoryData($historyData);
            
            $aForecastedValues = $oForecast->forecastAsArray($forecastIntervals);
            foreach($aForecastedValues as $forecastedValue) {
                $groupedHistory[$lastDay][$lastKey][$dataType] = $forecastedValue;
                $hour++;
            }
        }
        return true;
    }
    
    /**
     * This method forecast history impressions/requests/clicks and
     * return it as an array.
     * If agencyId and affiliateId are used history data is taken for
     * all the channels in agency/affiliate else only for channels
     * already linked with an ad.
     *
     * @param int $adId            Ad ID
     * @param int $agencyId        Agency ID
     * @param array $affiliateIds  Affiliate ID
     * @return mixed     Array with forecasted values or false if any error occured
     */
    function forecastAdRawData($adId, $agencyId = null, $affiliateIds = array())
    {
        $dates = $this->getStartEndDatesForAd($adId);
        if(empty($dates)) {
            return false;
        }
        
        $history = $this->getChannelsHistory($adId, $dates['start'], $dates['end'], $agencyId, $affiliateIds);
        if($history === false) {
            return false;
        }
        
        $dataToForecast = explode(',', $GLOBALS['_MAX']['CONF']['maintenance']['channelForecasting']);
        
        $forecasts = array();
        
        foreach ($history as $channelId => $channelHistory) {
            $groupedHistory = $this->groupHistoryInDays($channelHistory);
            
            // Forecast data for last day (if necessary)
            if(count($groupedHistory) > 2) {
                $lastDay = array_pop(array_keys($groupedHistory));
                $dayBeforeLastDay = array_pop(array_keys($groupedHistory));
                if(count($groupedHistory[$lastDay]) < count($groupedHistory[$dayBeforeLastDay])) {
                    $howManyIntervals = count($groupedHistory[$dayBeforeLastDay]) - count($groupedHistory[$lastDay]);
                    $this->forecastLastDay($groupedHistory, $lastDay, $howManyIntervals);
                }
            }
            
            $oForecast = $this->_getForecast();
            $oForecast->setAlgorithm($this->forecastingAlgorithm);
            
            foreach ($dataToForecast as $forecastName) {
                // Prepare history data (summarize history data for every day)
                $summarizedHistory = array();
                foreach ($groupedHistory as $day => $dayHistory) {
                    $summarizedHistory[$day] = 0;
                    foreach ($dayHistory as $data) {
                        $summarizedHistory[$day] += $data[$forecastName];
                    }
                }
                
                foreach ($dataToForecast as $forecastType) {
                    $oForecast->setHistoryData($summarizedHistory);
                    $forecasts[$channelId][$forecastName] = $oForecast->forecast($dates['forecastDays']);
                }
            }
        }
        return $forecasts;
    }
}

?>