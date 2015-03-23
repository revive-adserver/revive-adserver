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


require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Common.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OX/Maintenance/Priority/Campaign.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';

require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * Definition of how far back in time the DAL will look for
 * data relating to when an ad last delivered.
 */
define('MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT', MINUTES_PER_WEEK);

/**
 * Definitions for different types of Maintenance Priority process
 * log information.
 */
define('DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION', 1);
define('DAL_PRIORITY_UPDATE_ECPM', 2);

/**
 * The non-DB specific Data Abstraction Layer (DAL) class for the
 * Maintenance Priority Engine (MPE).
 *
 * @package    OpenXDal
 * @subpackage MaintenancePriority
 */
class OA_Dal_Maintenance_Priority extends OA_Dal_Maintenance_Common
{

    /**
     * Local locking object for ensuring MPE only runs once.
     *
     * @var OA_DB_AdvisoryLock
     */
    var $oLock;

    /**
     * The class constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * A method to store details on the last time that the maintenance priority
     * process ran.
     *
     * @param Date $oStart The time that the maintenance priority run started.
     * @param Date $oEnd The time that the maintenance priority run ended.
     * @param Date $oUpdateTo The end of the last operation interval ID that
     *                        has been updated. NULL is permitted, in the
     *                        case that this information does not actually
     *                        apply, should only the start/end dates of the
     *                        process run be relevant.
     * @param integer $type The type of priority run performed.
     */
    function setMaintenancePriorityLastRunInfo($oStart, $oEnd, $oUpdateTo, $type)
    {
        return $this->setProcessLastRunInfo($oStart, $oEnd, $oUpdateTo, 'log_maintenance_priority', true, 'run_type', $type);
    }

    /**
     * A method to return the time that the maintenance priority scripts
     * were last run, and the operation interval that was in use at the time.
     *
     * @param integer $type Optional integer to limit the returned result to having
     *                      a specific "run_type" value.
     * @param array  $aAdditionalFields An array of strings, representing any additional
     *                                  data fields to return, along with the default
     *                                  'updated_to' and 'operation_interval' fields.
     * @return mixed False on error, null no no result, otherwise, an array containing the
     *               'updated_to' and 'operation_interval' fields, which represent the time
     *               that the Maintenance Priority process last completed updating data until
     *               and the Operation Interval length at that time, as well as any additional
     *               fields (see $aAdditionalFields parameter).
     */
    function getMaintenancePriorityLastRunInfo($type = null, $aAdditionalFields = array())
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table = $aConf['table']['log_maintenance_priority'];
        $aFields = array('operation_interval');
        if (is_array($aAdditionalFields) && !empty($aAdditionalFields)) {
            $aFields = array_merge($aFields, $aAdditionalFields);
        }
        if (!is_null($type)) {
            if ($type == DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION) {
                $whereClause = 'WHERE (run_type = ' . DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION . ')';
            } elseif ($type == DAL_PRIORITY_UPDATE_ECPM) {
                $whereClause = 'WHERE (run_type = ' . DAL_PRIORITY_UPDATE_ECPM . ')';
            } else {
                OA::debug('Invalid run_type value ' . $type, PEAR_LOG_ERR);
                OA::debug('Aborting script execution', PEAR_LOG_ERR);
                exit();
            }
        }
        return $this->getProcessLastRunInfo($table, $aFields, $whereClause);
    }

    /*
     * Set the default number of impressions to use as a forecast value when there
     * is simply no other data to use for calculation of forecasts, based on an
     * operation interval of 60 minutes (the value will be reduced for smaller OIs
     */
    static public $ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS = 10;

    /*
     * The maximum traffic fraction that has to be assigned to contract campaigns
     * where there is no forecast available. The default forecast is supposed to
     * be low to avoid allocating too many impressions to inactive campaigns.
     * However we need do consider that value as a fraction of the zone potential
     * otherwise when a zone starts to deliver contract campaigns might have a
     * very high priority number and over-deliver massively
     */
    static public $ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS_FRACTION = 0.05;

    /*
     * Returns the default forecast to use, for a given zone in a given OI.
     *
     * @return int Number of impressions
     */
    function getZoneForecastDefaultZoneImpressions()
    {
        $multiplier = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'] / 60;
        $forecast = (int) round(self::$ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS * $multiplier);
        if ($forecast < 1) {
            return 1;
        }
        return $forecast;
    }

    /*
     * Returns the default limit value for a forecast for a zone in one OI
     *
     * @return int
     */
    function getZoneForecastDefaultZoneImpressionsLimit()
    {
        return self::getZoneForecastDefaultZoneImpressions() /
            self::$ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS_FRACTION;
    }

    /**
     * A method to return an array of Campaign objects.
     *
     * @param $where array An array of arrays of WHERE statements to filter on.
     *                     The format of each where array is: array(<condition>, <logic>).
     *                     Eg, array('target_impression > 0', 'AND')
     *                     This would almost always be set, to limit the campaigns returned
     *                     to some sub-set of all the campaigns.
     * @access protected
     * @return array An array of Campaign objects.
     */
    function getCampaigns($where = array())
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        if (!empty($where) && is_array($where)) {
            foreach ($where as $condition) {
                $doCampaigns->whereAdd($condition[0], $condition[1]);
            }
        }
        $doCampaigns->find();
        $aCampaignObjects = array();
        while ($doCampaigns->fetch()) {
            $aCampaignObjects[] = new OX_Maintenance_Priority_Campaign($doCampaigns->toArray());
        }

        return $aCampaignObjects;
    }

    /**
     * A method to get basic data about campaigns.
     *
     * @param integer $id The campaign ID.
     * @return array An array containing the advertiser_id, placement_id,
     *               and name of the campaign, if the campaign is "active"
     *               or not (true/false), and the "num_children" value (the
     *               number of advertisements in the campaign).
     */
    function getCampaignData($id)
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doBanners = OA_Dal::factoryDO('banners');
        $doCampaigns->campaignid = $id;
        $doCampaigns->joinAdd($doBanners);

        $doCampaigns->selectAdd();
        $doCampaigns->selectAdd('clientid, ' . $doCampaigns->tableName() . '.campaignid, campaignname, ' .
        $doCampaigns->tableName() . '.status');

        $doCampaigns->groupBy('clientid, ' . $doCampaigns->tableName() . '.campaignid, campaignname, ' .
        $doCampaigns->tableName() . '.status');

        $doCampaigns->find(true);

        $aData = array(
            'advertiser_id' => $doCampaigns->clientid,
            'placement_id' => $doCampaigns->campaignid,
            'name' => $doCampaigns->campaignname,
            'status' => $doCampaigns->status,
            'num_children' => $doBanners->count('bannerid'));

        return $aData;
    }

    /**
     * A method to get the details of the total number of advertisements
     * delivered, to date, for a specified placement.
     *
     * @param integer $id The placement ID.
     * @return array An array of arrays, with each containing the "placement_id",
     *               "sum_requests", "sum_views", "sum_clicks" and "sum_conversions"
     *               for that placement.
     */
    function getCampaignDeliveryToDate($id)
    {
        $this->oDbh->loadModule('Reverse');
        $aConf = $GLOBALS['_MAX']['CONF'];
        $query = array();
        $table = $this->_getTablenameUnquoted('campaigns');
        $joinTable1 = $this->_getTablenameUnquoted('banners');
        $joinTable2 = $this->_getTablenameUnquoted('data_intermediate_ad');
        $query['table']    = $table;
        $query['fields']   = array(
                                "SUM($joinTable2.requests) AS sum_requests",
                                "SUM($joinTable2.impressions) AS sum_views",
                                "SUM($joinTable2.clicks) AS sum_clicks",
                                "SUM($joinTable2.conversions) AS sum_conversions",
                                "$table.campaignid AS placement_id"
        );
        $query['wheres']   = array(
        array("$table.campaignid = $id", 'AND')
        );
        $query['joins']    = array(
        array($joinTable1, "$table.campaignid = $joinTable1.campaignid"),
        array($joinTable2, "$joinTable1.bannerid = $joinTable2.ad_id")
        );
        $query['group']    = "placement_id";
        return $this->_get($query);
    }

    /**
     * A method to get the details of the total number of advertisements
     * delivered, to date, for all placements in a given agency.
     * This method returns only the campaigns which revenue_type is not
     * equal MAX_FINANCE_CPM and therefore whose eCPM needs to be calculated
     * dynamically each time the maintenance is executed.
     *
     * @param integer $id The agency ID.
     * @return array An array of arrays, with each containing the "placement_id",
     *               "sum_requests", "sum_views", "sum_clicks" and "sum_conversions"
     *               for that placement.
     */
    function getAgencyEcpmRemnantCampaignsDeliveriesToDate($id)
    {
        $table = $this->_getTablenameUnquoted('campaigns');
        $aWheres = array(
        array("$table.priority = " . DataObjects_Campaigns::PRIORITY_ECPM, 'AND'),
        array("$table.revenue_type != " . MAX_FINANCE_CPM, 'AND'),
        );
        return $this->getAgencyCampaignsDeliveriesToDate($id, $aWheres);
    }


    /**
     * A method to get the details of the total number of advertisements
     * delivered, to date, for ecpm hpc campaigns withing given priority in a given agency.
     * This method returns only the campaigns which revenue_type is not
     * equal MAX_FINANCE_CPM and therefore whose eCPM needs to be calculated
     * dynamically each time the maintenance is executed.
     *
     * @param integer $id The agency ID.
     * @param integer $priority Campaign priority.
     * @return array An array of arrays, with each containing the "placement_id",
     *               "sum_requests", "sum_views", "sum_clicks" and "sum_conversions"
     *               for that placement.
     */
    function getAgencyEcpmContractCampaignsDeliveriesToDate($id, $priority)
    {
        $priority = (int) $priority;
        $table = $this->_getTablenameUnquoted('campaigns');
        $do = OA_Dal::factoryDO('Campaigns');
        $aWheres = array(
        array("$table.priority = " . $priority, 'AND'),
        array("$table.ecpm_enabled = 1", 'AND'),
        array("$table.type = " . DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT, 'AND'),
        array("$table.revenue_type != " . MAX_FINANCE_CPM, 'AND'),
        );
        return $this->getAgencyCampaignsDeliveriesToDate($id, $aWheres);
    }

    /**
     * A method to get the details of the total number of advertisements
     * delivered, to date, for all campaigns withing given priority in a given agency.
     * This method returns only the campaigns which revenue_type is not
     * equal MAX_FINANCE_CPM and therefore whose eCPM needs to be calculated
     * dynamically each time the maintenance is executed.
     *
     * @param integer $id The agency ID.
     * @param integer $priority Campaign priority.
     * @return array An array of arrays, with each containing the "placement_id",
     *               "sum_requests", "sum_views", "sum_clicks" and "sum_conversions"
     *               for that placement.
     */
    function getAgencyPriorityCampaignsDeliveriesToDate($id, $priority)
    {
        $priority = (int) $priority;
        $table = $this->_getTablenameUnquoted('campaigns');
        $do = OA_Dal::factoryDO('Campaigns');
        $aWheres = array(
        array("$table.priority = " . $priority, 'AND'),
        array("$table.type = " . DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT, 'AND'),
        array("$table.revenue_type != " . MAX_FINANCE_CPM, 'AND'),
        );
        return $this->getAgencyCampaignsDeliveriesToDate($id, $aWheres);
    }

    /**
     * A method to get the details of the total number of advertisements
     * delivered, to date, for all placements in a given agency.
     *
     * @param integer $id The agency ID.
     * @return array An array of arrays, indexed with campaigns id with each containing the
     *               "sum_impressions", "sum_clicks" and "sum_conversions"
     *               for that campaign.
     */
    function getAgencyCampaignsDeliveriesToDate($id, $aWheres = array())
    {
        $debugDetailQuery = '';
        foreach($aWheres as $where) {
            $debugDetailQuery .= $where[0]. ' ';
        }
        if(!empty($debugDetailQuery)) {
            $debugDetailQuery = ' and '. $debugDetailQuery;
        }
        OA::debug('  - Select details of all ads delivered for Manager ID = '.$id.' '.$debugDetailQuery);

        $this->oDbh->loadModule('Reverse');
        $aConf = $GLOBALS['_MAX']['CONF'];
        $query = array();
        $table = $this->_getTablenameUnquoted('campaigns');
        $joinTable1 = $this->_getTablenameUnquoted('banners');
        $joinTable2 = $this->_getTablenameUnquoted('data_intermediate_ad');
        $joinTable3 = $this->_getTablenameUnquoted('clients');
        $query['table']    = $table;
        $query['fields']   = array(
                                "SUM($joinTable2.impressions) AS sum_impressions",
                                "SUM($joinTable2.clicks) AS sum_clicks",
                                "SUM($joinTable2.conversions) AS sum_conversions",
                                "$table.campaignid AS campaign_id"
        );
        $query['wheres']   = array(
        array("$joinTable3.agencyid = $id", 'AND'),
        array("$joinTable1.status = " . OA_ENTITY_STATUS_RUNNING, 'AND'),
        array("$table.status = " . OA_ENTITY_STATUS_RUNNING, 'AND'),
        );
        if (!empty($aWheres)) {
            $query['wheres'] = array_merge($query['wheres'], $aWheres);
        }
        $query['joins']    = array(
        array($joinTable1, "$table.campaignid = $joinTable1.campaignid"),
        array($joinTable2, "$joinTable1.bannerid = $joinTable2.ad_id"),
        array($joinTable3, "$joinTable3.clientid = $table.clientid")
        );
        $query['group']    = "campaign_id";
        $result = $this->_get($query);
        $aResult = array();
        foreach ($result as $row) {
            $aResult[$row['campaign_id']] = array(
                'sum_impressions' => $row['sum_impressions'],
                'sum_clicks'      => $row['sum_clicks'],
                'sum_conversions' => $row['sum_conversions']
            );
        }
        return $aResult;
    }

    /**
     * A method to get the details of the total number of advertisements
     * delivered, today, for a specified placement.
     *
     * @param integer $id The placement ID.
     * @param string $today A "CCYY-MM-DD" formatted representation of today's date.
     * @return array An array of arrays, with each containing the "placement_id",
     *               "sum_requests", "sum_views", "sum_clicks" and "sum_conversions"
     *               for that placement.
     */
    function getCampaignDeliveryToday($id, $today)
    {
        $tz = $this->getTimezoneForCampaign($id);

        $oStartDate = new Date($today);
        $oStartDate->setTZ($tz);
        $oStartDate->setHour(0);
        $oStartDate->setMinute(0);
        $oStartDate->setSecond(0);
        $oStartDate->toUTC();

        $oEndDate = new Date($today);
        $oEndDate->setTZ($tz);
        $oEndDate->setHour(23);
        $oEndDate->setMinute(59);
        $oEndDate->setSecond(59);
        $oEndDate->toUTC();

        $aConf = $GLOBALS['_MAX']['CONF'];
        $query = array();
        $table = $this->_getTablenameUnquoted('campaigns');
        $joinTable1 = $this->_getTablenameUnquoted('banners');
        $joinTable2 = $this->_getTablenameUnquoted('data_intermediate_ad');

        $query['table']    = $table;
        $query['fields']   = array(
                                "SUM($joinTable2.requests) AS sum_requests",
                                "SUM($joinTable2.impressions) AS sum_views",
                                "SUM($joinTable2.clicks) AS sum_clicks",
                                "SUM($joinTable2.conversions) AS sum_conversions",
                                "$table.campaignid AS placement_id"
        );
        $query['wheres']   = array(
        array("$table.campaignid = $id", 'AND')
        );
        $query['joins']    = array(
        array($joinTable1, "$table.campaignid = $joinTable1.campaignid"),
        array($joinTable2, "$joinTable1.bannerid = $joinTable2.ad_id AND $joinTable2.date_time >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "' AND $joinTable2.date_time <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'")
        );
        $query['group']    = "placement_id";
        return $this->_get($query);
    }

    /**
     * A convenience method that combines the results of the getCampaignData and
     * (getCampaignDeliveryToDate or getCampaignDeliveryToday) methods into one
     * result set.
     *
     * @param integer $id The campaign ID.
     * @param boolean $todayOnly If true, only look at what has been delivered today
     *                           for the delivery statistics (ie. use getCampaignDeliveryToday),
     *                           otherwise use the delivery statistics for the entire campaign
     *                           lifetime (ie. use getCampaignDeliveryToDate).
     * @param string $today A "CCYY-MM-DD" formatted representation of today's date, only
     *                      required when $todayOnly is true.
     * @return array An array of the campaign's details, containing the following:
     *
     * Array
     *     (
     *         [advertiser_id]   => 1
     *         [placement_id]    => 1
     *         [name]            => Placement name
     *         [active]          => t
     *         [num_children]    => 2
     *         [sum_requests]    => 0
     *         [sum_views]       => 0
     *         [sum_clicks]      => 0
     *         [sum_conversions] => 0
     *     )
     */
    function getCampaignStats($id, $todayOnly = false, $today = '')
    {
        $aPlacements = $this->getCampaignData($id);
        if ($todayOnly) {
            $aPlacementsStats = $this->getCampaignDeliveryToday($id, $today);
        } else {
            $aPlacementsStats = $this->getCampaignDeliveryToDate($id);
        }
        $items = array(
            'sum_requests',
            'sum_views',
            'sum_clicks',
            'sum_conversions'
            );
        foreach ($items as $item) {
            if (!empty($aPlacementsStats[0][$item])) {
                $aPlacements[$item] = $aPlacementsStats[0][$item] ;
            } else {
                $aPlacements[$item] = 0;
            }
        }
        return $aPlacements;
    }

    /**
     * A method to get all zones that have had advertisements allocated to their
     * impression inventory.
     *
     * @access public
     * @return mixed An array of arrays, each one representing a zone/ad pair
     *               found, in zone ID, ad ID order.
     */
    function &getAllZonesWithAllocInv()
    {
        OA::debug('  - Getting all of the zones with ad impressions allocated', PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        $query = array();
        $table              = 'tmp_ad_zone_impression';
        $tableC             = $aConf['table']['prefix'] . $aConf['table']['campaigns'];
        $tableB             = $aConf['table']['prefix'] . $aConf['table']['banners'];

        $query['table']     = $table;

        $query['joins']    = array(
        array($tableB, "$table.ad_id = $tableB.bannerid"),
        array($tableC, "$tableB.campaignid = $tableC.campaignid")
        );

        $query['fields']   = array(
                                "$table.zone_id",
                                "$table.ad_id",
                                "$table.required_impressions",
                                "$table.requested_impressions",
                                "$table.to_be_delivered"
        );
        $query['orderBys'] = array(
        array("$table.zone_id", 'ASC'),
        array("$table.ad_id", 'ASC')
        );
        $query['wheres']   = array(
        array("$tableC.priority > 0", 'AND'),
        array("$tableC.status = " . OA_ENTITY_STATUS_RUNNING, 'AND'),
        array("$tableB.status = " . OA_ENTITY_STATUS_RUNNING, 'AND'),
        );
        return $this->_get($query);
    }

    /**
     * Returns an array of forecasts for the current OI, for all zones in the system.
     * Forecast for a given zone is the number of impressions received by this zone in the previous OI.
     * @see getZonesForecasts()
     *
     * @return array|false array( zoneId => forecastImpressions, ... )
     */
    function &getZonesForecastsForAllZones()
    {
        OA::debug('  - Getting the impression inventory data for all zones', PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDate =& $oServiceLocator->get('now');
        if (!$oDate) {
            return false;
        }

        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $aResult = $this->getZonesForecasts($interval_start, $interval_end);

        // Get all possible zones in the system, plus zone 0
        $table = $this->_getTablename('zones');
        $query = "
        SELECT
            zoneid AS zone_id
        FROM
        {$table}
        UNION ALL SELECT 0
        ORDER BY zone_id";
        $rc = $this->oDbh->query($query);
        while ($aRow = $rc->fetchRow()) {
            if (!isset($aResult[$aRow['zone_id']])) {
                // No data available, forecast 0 impressions
                $aResult[$aRow['zone_id']] = 0;
            }
        }
        return $aResult;
    }

    /**
     * A method to get all active contract campaign creatives where the delivery limitations
     * of the creatives have had changes made:
     *  - In the current operation interval; or
     *  - In the previous operation interval, but after last time the Priority
     *    Compensation process started running.
     *
     * @param array An array containing the last time that the Priority Compensation
     *              process started running in the 'start_run' field (as a PEAR::Date),
     *              and the current date/time (ie. a date/time in the current
     *              operation interval) in the 'now' field (as a PEAR::Date).
     * @return array An array, indexed by creative ID, of the date/times (as strings)
     *               that the delivery limitations were altered, of those active
     *               creatives that had delivery limitations changed since the given
     *               'start_run' date.
     */
    function &getAllDeliveryLimitationChangedCreatives($aLastRun)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        OA::debug('  - Getting all creatives where delivery limitations have changed', PEAR_LOG_DEBUG);
        $aAds = array();
        // Test the input data
        if (!is_array($aLastRun) || (count($aLastRun) != 2)) {
            return $aAds;
        }
        if (is_null($aLastRun['start_run']) || (!is_a($aLastRun['start_run'], 'Date'))) {
            return $aAds;
        }
        if (is_null($aLastRun['now']) || (!is_a($aLastRun['now'], 'Date'))) {
            return $aAds;
        }
        // Select those contract campaign creatives where the delivery limitations were
        // changed in the current operation interval
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($aLastRun['now']);
        $table1 = $this->_getTablename('banners');
        $table2 = $this->_getTablename('campaigns');
        $query = "
            SELECT
                b.bannerid AS ad_id,
                b.acls_updated AS changed
            FROM
            {$table1} AS b,
            {$table2} AS c
            WHERE
                b.acls_updated >= '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                b.acls_updated <= '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                b.status = " . OA_ENTITY_STATUS_RUNNING . "
                AND
                b.campaignid = c.campaignid
                AND
                c.priority > 0
                AND
                c.status = " . OA_ENTITY_STATUS_RUNNING;
            $rc = $this->oDbh->query($query);
            while ($aRow = $rc->fetchRow()) {
                $aAds[$aRow['ad_id']] = $aRow['changed'];
            }
            // Select those contract campaign creatives where the delivery limitations were
            // changed in the previous operation interval, but after the last time Priority
            // Compensation started to run
            $oDate = new Date();
            $oDate->copy($aDates['start']);
            $oDate->subtractSeconds(1);
            $table1 = $this->_getTablename('banners');
            $table2 = $this->_getTablename('campaigns');
            $query = "
            SELECT
                b.bannerid AS ad_id,
                b.acls_updated AS changed
            FROM
            {$table1} AS b,
            {$table2} AS c
            WHERE
                b.acls_updated >= '" . $aLastRun['start_run']->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                b.acls_updated <= '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                b.status = " . OA_ENTITY_STATUS_RUNNING . "
                AND
                b.campaignid = c.campaignid
                AND
                c.priority > 0
                AND
                c.status = " . OA_ENTITY_STATUS_RUNNING;
            $rc = $this->oDbh->query($query);
            while ($aRow = $rc->fetchRow()) {
                $aAds[$aRow['ad_id']] = $aRow['changed'];
            }
            return $aAds;
    }

    /**
     * A method to get the most recent details of contract campaign creative delivery
     * for a given list of creative/zone pairs set to deliver in the current
     * operation interval. Normally, the data will be retrieved from the previous
     * operation interval, but if no data exists for that creative/zone pair, then the
     * next previous operation interval will be tried, and so on, up to a limit
     * of MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT minutes (default is one week).
     *
     * - Requires that a current day/time (as a Date object) be registered
     *   with the OA_ServiceLocator (as "now").
     *
     * - Ignores creative ID 0 and zone ID 0 items, as these are reserved for
     *   direct selection, which is considered to be outside the process of
     *   priority compensation calculations (even though priority values for
     *   all contract campaign creatives are calculated and stored for the
     *   zone ID 0).
     *
     * Note: The logic of this method seems a little convoluted, and it is.
     * However, it needs to be. The reason being:
     *
     *  - If a contract campaign creative delivered in the previous operation interval,
     *    then it should have had a priority set in ad_zone_assoc (that's how OpenX
     *    knows to deliver contract campiang creatives, natch!). This should be the most
     *    recent entry in data_summary_ad_zone_assoc. So, the first step is to get the
     *    data for all contract campiang creatives that have delivered in the previous
     *    OI, and the associated prioritisation data.
     *  - If a contract campaign creative did not deliver, the prioritisation data set
     *    in the previous OI is still needed anyway (as it might have been *supposed*
     *    to deliver), so the second step is to get those creatives that had
     *    prioiritisation data set in the previous OI, but did not deliver.
     *  - Finally, as some creatives are limited by hour (for example), we want to
     *    to be able to get past prioritisation data for creatives that were
     *    disabled in the last OI, so, we need to look for creative/zone pairs
     *    that have not yet been found, and get BOTH the prioritisation AND the
     *    delivery data from the last OI when the creatives were active in the
     *    zones.
     *
     * This is why the method uses a complex, 3 step process!
     *
     * @access public
     * @param array $aCurrentZones An array of Zones, indexed by Zone ID, with each
     *                             Zone containing the Advert objects that are linked
     *                             to deliver in the zone, in the current operation
     *                             interval.
     * @return mixed An array of arrays of arrays, each one representing a set of
     *               ad/zone delivery information, indexed by ad ID and zone ID.
     *               Each sub-sub array, if present, has the format:
     *               array (
     *                  'ad_id'                         => integer
     *                  'zone_id'                       => integer
     *                  'required_impressions'          => integer
     *                  'requested_impressions'         => integer
     *                  'priority_factor'               => double
     *                  'past_zone_traffic_fraction'    => double
     *                  'impressions'                   => integer
     *               )
     *               Returns false when the current date/time is not set in the
     *               OA_ServiceLocator.
     */
    function &getPreviousAdDeliveryInfo($aCurrentZones)
    {
        OA::debug("  - Getting details of previous creative/zone delivery", PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDate =& $oServiceLocator->get('now');
        if (!$oDate) {
            return false;
        }
        $aAds = array();
        $aZones = array();
        $aZonesAds = array();
        $aPastDeliveryResult = array();
        $aPastPriorityResult = array();
        $aNonDeliveringPastPriorityResult = array();
        $aFinalResult = array();
        // Obtain the earliest existing interval_start date found in the
        // data_summary_ad_zone_assoc table
        $table = $this->_getTablename('data_summary_ad_zone_assoc');
        $query = "
            SELECT
                interval_start AS interval_start
            FROM
            {$table}
            ORDER BY
                interval_start
            LIMIT
                1";
            $rc = $this->oDbh->query($query);
            if ((!PEAR::isError($rc)) && ($rc->numRows() == 1)) {
                $aRow = $rc->fetchRow();
                $oEarliestPastPriorityRecordDate = new Date($aRow['interval_start']);
                // Create a new date that is the limit number of minutes ago
                $oLimitDate = new Date();
                $oLimitDate->copy($oDate);
                $oLimitDate->subtractSeconds(MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT * 60);
                // Is the earliest date before this date?
                if ($oEarliestPastPriorityRecordDate->before($oLimitDate)) {
                    // Use the limit date instead
                    $oEarliestPastPriorityRecordDate = new Date();
                    $oEarliestPastPriorityRecordDate->copy($oLimitDate);
                }
            }
            // Obtain the operation interval ID, and the start and end dates of the previous
            // operation interval
            $currentOperationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
            $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($currentOperationIntervalID);
            $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
            // Obtain the ad ID, zone ID and number of impressions delivered for every ad/zone
            // combination that delivered impressions in the previous operation interval, where
            // the ad is from a contract campaign (as we don't care about other campaign types)
            OA::debug("  - Getting details of contract campaign creative/zone pairs that delivered last OI", PEAR_LOG_DEBUG);
            $sDataIntermediateAd = $this->_getTablename('data_intermediate_ad');
            $sBanners = $this->_getTablename('banners');
            $sCampaigns = $this->_getTablename('campaigns');
            $query = "
            SELECT
                ad_id AS ad_id,
                zone_id AS zone_id,
                SUM(impressions) AS impressions
            FROM
            {$sDataIntermediateAd} AS dia,
            {$sBanners} AS b,
            {$sCampaigns} AS c
            WHERE
                dia.operation_interval = {$aConf['maintenance']['operationInterval']}
                AND
                dia.operation_interval_id = $previousOperationIntervalID
                AND
                dia.interval_start = '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                dia.interval_end = '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                dia.ad_id != 0
                AND
                dia.zone_id != 0
                AND
                dia.ad_id = b.bannerid
                AND
                b.campaignid = c.campaignid
                AND
                c.priority > 0
            GROUP BY
                ad_id,
                zone_id
            ORDER BY
                ad_id,
                zone_id";
            $rc = $this->oDbh->query($query);
            while ($aRow = $rc->fetchRow()) {
                // Store the ad ID as being one that has delivered
                $aAds[$aRow['ad_id']] = $aRow['ad_id'];
                // Store the zone ID as one that had impressions in it
                $aZones[$aRow['zone_id']] = $aRow['zone_id'];
                // Store the ad IDs by zone ID
                $aZonesAds[$aRow['zone_id']][$aRow['ad_id']] = true;
                // Store the impressions delivered for the contract campaign creative/zone pair,
                // and that the past priority information for this contract campiang creative/zone
                // pair has not been found yet (it will be found later on)
                $aPastDeliveryResult[$aRow['ad_id']][$aRow['zone_id']]['impressions'] = $aRow['impressions'];
                $aPastDeliveryResult[$aRow['ad_id']][$aRow['zone_id']]['pastPriorityFound'] = false;
            }
            // Did any ads deliver last operation interval?
            if (!empty($aAds)) {
                // Is there past deliver data?
                if (isset($oEarliestPastPriorityRecordDate)) {
                    // As all of the above contract capiang creative/zone combinations delivered impressions
                    // in the previous operation interval, a priority value must have existed. However, the
                    // priority value may *not* have come from the previous interval, as maintenance may not
                    // have been run (although it should have ;-)
                    // To be sure, interate backwards over past operation intervals (up to the earliest
                    // existing record), obtaining the details of the impressions requested and the priority
                    // values used for the above combinations
                    $previousOperationIntervalIDLoop = $previousOperationIntervalID;
                    $aDatesLoop = array();
                    $aDatesLoop['start'] = new Date();
                    $aDatesLoop['start']->copy($aDates['start']);
                    $aDatesLoop['end'] = new Date();
                    $aDatesLoop['end']->copy($aDates['end']);
                    $foundAll = false;
                    while (!$foundAll) {
                        if (!empty($aAds) && !empty($aZones)) {
                            OA::debug('    - Getting past details of contract campiang creative/zone pairs for OI starting at ' .
                            $aDatesLoop['start']->format('%Y-%m-%d %H:%M:%S'), PEAR_LOG_DEBUG);
                            $table = $this->_getTablename('data_summary_ad_zone_assoc');
                            $query = "
                            SELECT
                                ad_id AS ad_id,
                                zone_id AS zone_id,
                                required_impressions AS required_impressions,
                                requested_impressions AS requested_impressions,
                                to_be_delivered AS to_be_delivered,
                                priority_factor AS priority_factor,
                                past_zone_traffic_fraction AS past_zone_traffic_fraction,
                                created AS created,
                                expired AS expired
                            FROM
                            {$table}
                            WHERE
                                ad_id IN (" . implode(', ', $aAds) . ")
                                AND
                                zone_id IN (" . implode(', ', $aZones) . ")
                                AND
                                operation_interval = {$aConf['maintenance']['operationInterval']}
                                AND
                                operation_interval_id = $previousOperationIntervalIDLoop
                                AND
                                interval_start = '" . $aDatesLoop['start']->format('%Y-%m-%d %H:%M:%S') . "'
                                AND
                                interval_end = '" . $aDatesLoop['end']->format('%Y-%m-%d %H:%M:%S') . "'
                            ORDER BY
                                ad_id,
                                zone_id";
                            $rc = $this->oDbh->query($query);
                            $aResult = $rc->fetchAll();
                            // Calculate the past priority results, using $aPastDeliveryResult in the call to
                            // _calculateAveragePastPriorityValues(), so that if this is the second (or greater)
                            // time this has been done then any contract campiang creative/zone pairs that have
                            // come up with details for a second (or greater) time (i.e. as a result of a priority
                            // value record from an earise operation interval as we iterate backwards in time) will
                            // NOT have its past priority info re-calculated with the wrong values
                            $this->_calculateAveragePastPriorityValues($aPastPriorityResult, $aResult, $oDate, $aPastDeliveryResult);
                            // Loop over the results, marking off the contract campiang banner/zone
                            // combinations in the past delivery array as having had their past prioritisation
                            // information found and/or calculated
                            if (!empty($aPastPriorityResult)) {
                                foreach ($aPastPriorityResult as $a => $aAd) {
                                    foreach ($aAd as $z => $aZone) {
                                        if ($aZone['pastPriorityFound']) {
                                            $aPastDeliveryResult[$a][$z]['pastPriorityFound'] = true;
                                        }
                                    }
                                }
                            }
                        }
                        // Look over the past delivery array to see if there are any contract campaign creative/zone
                        // combinations that do not yet have the past prioritisation information
                        $foundAll = true;
                        if (!empty($aPastDeliveryResult)) {
                            foreach ($aPastDeliveryResult as $a => $aAd) {
                                $remove = true;
                                foreach ($aAd as $z => $aZone) {
                                    if (!$aPastDeliveryResult[$a][$z]['pastPriorityFound']) {
                                        if ($foundAll) {
                                            // Need to go back in time to look for more past priority info
                                            $previousOperationIntervalIDLoop = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalIDLoop);
                                            $aDatesLoop = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDatesLoop['start']);
                                            if (!$aDatesLoop['start']->before($oEarliestPastPriorityRecordDate)) {
                                                // Haven't exceeded earliest priority info date, so okay
                                                // to go ahead with going back in time...
                                                $foundAll = false;
                                            }
                                        }
                                        $remove = false;
                                    }
                                    // Remove the contract campaign creative from the list of creatives to select
                                    // from next round, and check if this was the last creative in the zone, and,
                                    // if so, also remove the zone from the list of zones to select from
                                    // next round
                                    if ($remove) {
                                        unset($aAds[$a]);
                                        unset($aZonesAds[$z][$a]);
                                        if (count($aZonesAds[$z]) == 0) {
                                            unset($aZones[$z]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                // Merge the past priority and delivery values into the final results array
                if (!empty($aPastDeliveryResult)) {
                    foreach ($aPastDeliveryResult as $a => $aAd) {
                        foreach ($aAd as $z => $aZone) {
                            $aFinalResult[$a][$z] = array(
                            'ad_id'                         => $a,
                            'zone_id'                       => $z,
                            'required_impressions'          => $aPastPriorityResult[$a][$z]['required_impressions'],
                            'requested_impressions'         => $aPastPriorityResult[$a][$z]['requested_impressions'],
                            'to_be_delivered'               => $aPastPriorityResult[$a][$z]['to_be_delivered'],
                            'priority_factor'               => $aPastPriorityResult[$a][$z]['priority_factor'],
                            'past_zone_traffic_fraction'    => $aPastPriorityResult[$a][$z]['past_zone_traffic_fraction'],
                            'impressions'                   => $aPastDeliveryResult[$a][$z]['impressions']
                            );
                        }
                    }
                }
            }
            // Select the details of all contract campaign creative/zones that had required/requested impressions,
            // in the previous operation interval, but for which no impressions were delivered
            OA::debug('  - Getting details of contract campaign creative/zone pairs that did not deliver last OI (but should have)', PEAR_LOG_DEBUG);
            $table1 = $this->_getTablename('data_summary_ad_zone_assoc');
            $table2 = $this->_getTablename('data_intermediate_ad');

	        $oneHourInterval = OA_Dal::quoteInterval(1, 'hour');

            // we have to do this complicated MINUS query (mysql doesn't support MINUS so we do a LEFT JOIN exclude not matching)
            // and we do two subqueries in order to use the INDEXes as expected
            // note the trick that we use range lookup on the date_time field as this is the one that is indexed
            $query = "
            SELECT dsaza.*
            FROM (
                SELECT
                    ad_id AS ad_id,
                    zone_id AS zone_id,
                    required_impressions AS required_impressions,
                    requested_impressions AS requested_impressions,
                    to_be_delivered AS to_be_delivered,
                    priority_factor AS priority_factor,
                    past_zone_traffic_fraction AS past_zone_traffic_fraction,
                    created AS created,
                    expired AS expired
                FROM
                {$table1} AS dsaza
                WHERE
                    operation_interval = {$aConf['maintenance']['operationInterval']}
                    AND
                    operation_interval_id = $previousOperationIntervalID
                    AND
                    interval_start = '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "'
                    AND
                    interval_end = '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'
                    AND
                    ad_id != 0
                    AND
                    zone_id != 0
                    AND
                    required_impressions > 0
                    AND
                    requested_impressions > 0
                ORDER BY
                    ad_id,
                    zone_id
            ) as dsaza
            LEFT JOIN
            (
            	SELECT
            		ad_id,
            		zone_id
            	FROM
            	{$table2} AS dia
                WHERE
                    operation_interval = {$aConf['maintenance']['operationInterval']}
                    AND
                    operation_interval_id = $previousOperationIntervalID
                    AND
                    interval_start = '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "'
                    AND
                    interval_end = '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'
                    AND
                    date_time > DATE_SUB('" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "', $oneHourInterval)
                    AND
                    date_time < DATE_ADD('" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "', $oneHourInterval)
                ORDER BY
                    ad_id,
                    zone_id
            ) as dia
            ON
                dsaza.ad_id = dia.ad_id
                AND
                dsaza.zone_id = dia.zone_id
            WHERE
                dia.ad_id IS NULL
                AND
                dia.zone_id IS NULL
            ";

        	$rc = $this->oDbh->query($query);
        	$aResult = $rc->fetchAll();
        	$resultCount = count($aResult);
        	OA::debug('    - Found ' . $resultCount . ' contract campaign creative/zone pairs that did not deliver last OI (but should have)', PEAR_LOG_DEBUG);
        	if ($resultCount > 0) {
        	    // Calculate the past priority results, but without the optional parameter to
        	    // _calculateAveragePastPriorityValues(), as this is a single calculation on data
        	    // in the past OI, and no further looping back over time will occur
        	    OA::debug('  - Getting past details of the non-delivering contract campiang creative/zone pairs', PEAR_LOG_DEBUG);
        	    $this->_calculateAveragePastPriorityValues($aNonDeliveringPastPriorityResult, $aResult, $oDate);
        	    // Merge the past priority values into the final results array
        	    if (!empty($aNonDeliveringPastPriorityResult)) {
        	        foreach ($aNonDeliveringPastPriorityResult as $a => $aAd) {
        	            foreach ($aAd as $z => $aZone) {
        	                if (empty($aFinalResult[$a][$z])) {
        	                    $aFinalResult[$a][$z] = array(
                                'ad_id'                         => $a,
                                'zone_id'                       => $z,
                                'required_impressions'          => $aNonDeliveringPastPriorityResult[$a][$z]['required_impressions'],
                                'requested_impressions'         => $aNonDeliveringPastPriorityResult[$a][$z]['requested_impressions'],
                                'to_be_delivered'               => $aNonDeliveringPastPriorityResult[$a][$z]['to_be_delivered'],
                                'priority_factor'               => $aNonDeliveringPastPriorityResult[$a][$z]['priority_factor'],
                                'past_zone_traffic_fraction'    => $aNonDeliveringPastPriorityResult[$a][$z]['past_zone_traffic_fraction']
        	                    );
        	                }
        	            }
        	        }
        	    }
        	}
        	// Finally, now that all contract campaign creative/zone combinations that had required/requested
        	// impressions in the previous operation interval and delivered/didn't deliver issues have been
        	// dealt with, check to see if there are any contract campaign creative/zone combinations that are
        	// linked to deliver in the current operation interval, which are not covered by the above
        	OA::debug('  - Finding contract campaign creative/zone pairs set to deliver, but with no past data yet', PEAR_LOG_DEBUG);
        	$aAds = array();
        	$aZones = array();
        	$aZonesAds = array();
        	$aNotInLastOIPastDeliveryResult = array();
        	$aNotInLastOIPastPriorityResult = array();
        	if (is_array($aCurrentZones) && !empty($aCurrentZones)) {
        	    foreach ($aCurrentZones as $zoneId => $oZone) {
        	        // Ignore Zone ID 0, as data for this zone is not required (there will no be
        	        // priority compensation performed on this zone, the past data is not relevant)
        	        if ($oZone->id != 0) {
        	            if (is_array($oZone->aAdverts) && !empty($oZone->aAdverts)) {
        	                foreach ($oZone->aAdverts as $oAdvert) {
        	                    // Store that the past priority information for this contract campiagn creative/zone
        	                    // pair may not have yet been found
        	                    $aNotInLastOIPastDeliveryResult[$oAdvert->id][$zoneId]['pastPriorityFound'] = false;
        	                }
        	            }
        	        }
        	    }
        	}
        	// Remove those contract campiagn creative/zone pairs that have,
        	// in fact, already had their past priority information found
        	if (!empty($aFinalResult)) {
        	    foreach ($aFinalResult as $aResult) {
        	        if (isset($aResult['ad_id'])) {
        	            unset($aNotInLastOIPastDeliveryResult[$aResult['ad_id']][$aResult['zone_id']]);
        	        }
        	    }
        	    foreach ($aNotInLastOIPastDeliveryResult as $adKey => $aTestZone) {
        	        if (empty($aTestZone)) {
        	            unset($aNotInLastOIPastDeliveryResult[$adKey]);
        	        }
        	    }
        	}
        	// Create the sets of required creatives and zones that need their past priority
        	// information from older operation intervals found (exluding zone ID 0, as this
        	// is not required)
        	if (!empty($aNotInLastOIPastDeliveryResult)) {
        	    foreach ($aNotInLastOIPastDeliveryResult as $adKey => $aData) {
        	        // Store the creative ID as being one that needs to deliver
        	        $aAds[$adKey] = $adKey;
        	        foreach ($aData as $zoneKey => $value) {
        	            // Store the zone ID as one that has a creative that needs to deliver in it
        	            $aZones[$zoneKey] = $zoneKey;
        	            // Store the creative ID by zone ID
        	            $aZonesAds[$zoneKey][$adKey] = true;
        	        }
        	    }
        	}
        	// Are there any contract campiagn creative/zone pairs that need data?
        	if (!empty($aNotInLastOIPastDeliveryResult)) {
        	    // Is there past delivery data?
        	    if (isset($oEarliestPastPriorityRecordDate)) {
        	        // Loop over the previous operation intervals, starting with the one
        	        // *before* last, and find when (if possible) these contract campiagn
        	        // creative/zone pairs last *requested* to deliver; it doesn't matter if
        	        // they did deliver in that operation interval or not
        	        $previousOperationIntervalIDLoop = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        	        $aDatesLoop = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        	        $foundAll = false;
        	        while (!$foundAll) {
        	            if (!empty($aAds) && !empty($aZones)) {
        	                OA::debug('    - Getting past details of contract campiagn creative/zone pairs which did not deliver last OI, for OI ' .
                                         'starting at ' . $aDatesLoop['start']->format('%Y-%m-%d %H:%M:%S'), PEAR_LOG_DEBUG);
        	                $table = $this->_getTablename('data_summary_ad_zone_assoc');
        	                $query = "
                            SELECT
                                ad_id AS ad_id,
                                zone_id AS zone_id,
                                required_impressions AS required_impressions,
                                requested_impressions AS requested_impressions,
                                to_be_delivered AS to_be_delivered,
                                priority_factor AS priority_factor,
                                past_zone_traffic_fraction AS past_zone_traffic_fraction,
                                created AS created,
                                expired AS expired,
                                operation_interval AS operation_interval,
                                operation_interval_id AS operation_interval_id,
                                interval_start AS interval_start,
                                interval_end AS interval_end
                            FROM
                            {$table}
                            WHERE
                                ad_id IN (" . implode(', ', $aAds) . ")
                                AND
                                zone_id IN (" . implode(', ', $aZones) . ")
                                AND
                                operation_interval = {$aConf['maintenance']['operationInterval']}
                                AND
                                operation_interval_id = $previousOperationIntervalIDLoop
                                AND
                                interval_start = '" . $aDatesLoop['start']->format('%Y-%m-%d %H:%M:%S') . "'
                                AND
                                interval_end = '" . $aDatesLoop['end']->format('%Y-%m-%d %H:%M:%S') . "'
                            ORDER BY
                                ad_id,
                                zone_id";
                            $rc = $this->oDbh->query($query);
                            $aResult = $rc->fetchAll();

                            // Calculate the past priority results, using $aPastDeliveryResult in the call to
                            // _calculateAveragePastPriorityValues(), so that if this is the second (or greater)
                            // time this has been done then any contract campiang creative/zone pairs that have
                            // come up with details for a second (or greater) time (i.e. as a result of a priority
                            // value record from an earise operation interval as we iterate backwards in time) will
                            // NOT have its past priority info re-calculated with the wrong values
                            $this->_calculateAveragePastPriorityValues($aNotInLastOIPastPriorityResult, $aResult, $oDate, $aNotInLastOIPastDeliveryResult);
                            // Loop over the results, marking off the contract campiagn creative/zone
                            // combinations in the past delivery array as having had their past prioritisation
                            // information found and/or calculated
                            if (!empty($aNotInLastOIPastPriorityResult)) {
                                foreach ($aNotInLastOIPastPriorityResult as $a => $aAd) {
                                    foreach ($aAd as $z => $aZone) {
                                        if ($aZone['pastPriorityFound']) {
                                            $aNotInLastOIPastDeliveryResult[$a][$z]['pastPriorityFound'] = true;
                                        }
                                    }
                                }
                            }
                            // Look over the past delivery array to see if there are any contract campiagn creative/zone
                            // combinations that do not yet have the past prioritisation information
                            $foundAll = true;
                            if (!empty($aNotInLastOIPastDeliveryResult)) {
                                foreach ($aNotInLastOIPastDeliveryResult as $a => $aAd) {
                                    $remove = true;
                                    foreach ($aAd as $z => $aZone) {
                                        if (!$aNotInLastOIPastDeliveryResult[$a][$z]['pastPriorityFound']) {
                                            if ($foundAll) {
                                                // Need to go back in time to look for more past priority info
                                                $previousOperationIntervalIDLoop = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalIDLoop);
                                                $aDatesLoop = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDatesLoop['start']);
                                                if (!$aDatesLoop['start']->before($oEarliestPastPriorityRecordDate)) {
                                                    // Haven't exceeded earliest priority info date, so okay
                                                    // to go ahead with going back in time...
                                                    $foundAll = false;
                                                }
                                            }
                                            $remove = false;
                                        }
                                        // Remove the creative from the list of creatives to select from next round,
                                        // and check if this was the last creative in the zone, and, if so,
                                        // also remove the zone from the list of zones to select from
                                        // next round
                                        if ($remove) {
                                            unset($aAds[$a]);
                                            unset($aZonesAds[$z][$a]);
                                            if (count($aZonesAds[$z]) == 0) {
                                                unset($aZones[$z]);
                                            }
                                        }
                                    }
                                }
                            }
        	            } else {
        	                $foundAll = true;
        	            }
        	        }
        	    }
        	    // Now that it is known when (if) the remaining creatives last requested to deliver,
        	    // determine how many impressions were delivered (if any) during the appropriate
        	    // operation intervals
        	    if (!empty($aNotInLastOIPastPriorityResult)) {
        	        $table = $this->_getTablename('data_intermediate_ad');
        	        $oneHourInterval = OA_Dal::quoteInterval(1, 'hour');
        	        $query = "
                    SELECT
                        SUM(impressions) AS impressions
                    FROM
                    {$table}
                    WHERE
                        operation_interval = ?
                        AND
                        operation_interval_id = ?
                        AND
                        date_time > DATE_SUB(?, ".$oneHourInterval.")
                        AND
                        date_time < DATE_ADD(?, ".$oneHourInterval.")
                        AND
                        interval_start = ?
                        AND
                        interval_end = ?
                        AND
                        ad_id = ?
                        AND
                        zone_id = ?";
                    $aTypes = array(
                    'integer',
                    'integer',
                    'timestamp',
                    'timestamp',
                    'timestamp',
                    'timestamp',
                    'integer',
                    'integer',
                    );
                    $stSelectSumImpressions = $this->oDbh->prepare($query, $aTypes, MDB2_PREPARE_RESULT);

                    OA::debug('  - Looping over each zone linked to '.count($aNotInLastOIPastPriorityResult). ' ads');
                    $countQueriesSumImp = 0;
                    foreach ($aNotInLastOIPastPriorityResult as $a => $aAd) {
                        OA::debug('    - Requesting sum of impressions for ad ID '.$a.' for '.count($aAd).' zones ', PEAR_LOG_DEBUG);
                        foreach ($aAd as $z => $aZone) {
                            $aData = array(
                            $aNotInLastOIPastPriorityResult[$a][$z]['operation_interval'],
                            $aNotInLastOIPastPriorityResult[$a][$z]['operation_interval_id'],
                            $aNotInLastOIPastPriorityResult[$a][$z]['interval_start'],
                            $aNotInLastOIPastPriorityResult[$a][$z]['interval_start'],
                            $aNotInLastOIPastPriorityResult[$a][$z]['interval_start'],
                            $aNotInLastOIPastPriorityResult[$a][$z]['interval_end'],
                            $a,
                            $z
                            );
                            $rsResult = $stSelectSumImpressions->execute($aData);
                            $aResult = $rsResult->fetchAll();
                            if (isset($aResult[0]['impressions'])) {
                                $aNotInLastOIPastPriorityResult[$a][$z]['impressions'] = $aResult[0]['impressions'];
                            }
                            $countQueriesSumImp++;
                        }
                    }
                    OA::debug('  - Finished querying impressions for '.$countQueriesSumImp.' ad-zones combinations');
        	    }
        	    // Merge the past priority and delivery values into the final results array
        	    if (!empty($aNotInLastOIPastPriorityResult)) {
        	        foreach ($aNotInLastOIPastPriorityResult as $a => $aAd) {
        	            foreach ($aAd as $z => $aZone) {
        	                if (empty($aFinalResult[$a][$z])) {
        	                    $aFinalResult[$a][$z] = array(
                                'ad_id'                         => $a,
                                'zone_id'                       => $z,
                                'required_impressions'          => $aNotInLastOIPastPriorityResult[$a][$z]['required_impressions'],
                                'requested_impressions'         => $aNotInLastOIPastPriorityResult[$a][$z]['requested_impressions'],
                                'to_be_delivered'               => $aNotInLastOIPastPriorityResult[$a][$z]['to_be_delivered'],
                                'priority_factor'               => $aNotInLastOIPastPriorityResult[$a][$z]['priority_factor'],
                                'past_zone_traffic_fraction'    => $aNotInLastOIPastPriorityResult[$a][$z]['past_zone_traffic_fraction']
        	                    );
        	                    if (isset($aNotInLastOIPastPriorityResult[$a][$z]['impressions'])) {
        	                        $aFinalResult[$a][$z]['impressions'] = $aNotInLastOIPastPriorityResult[$a][$z]['impressions'];
        	                    }
        	                }
        	            }
        	        }
        	    }
        	}
        	return $aFinalResult;
    }

    /**
     * A private method for calculating the required and requested impressions,
     * priority factor, and past zone traffic fraction for an ad/zone pair, based on
     * data taken from the data_summary_ad_zone_assoc table. The values may be simply
     * those extracted from the database table, or they may be "average" values,
     * based on the length of time each of a number of different rows was active for
     * in the delivery engine.
     *
     * @access private
     *
     * @param array $aPastPriorityResult A reference to an array of arrays indexed
     *                                   by ad ID, and then zone ID, with each sub-array
     *                                   returned containing the details above.
     * @param array $aResult An array containing the results of a database query, with
     *                       the ad_id, zone_id, required_impressions, requested_impressions,
     *                       priority_factor, past_zone_traffic_fraction, created and expired
     *                       columns from the data_summary_ad_zone_assoc table, representing
     *                       these values for a complete (single) operation interval.
     *                       May optionally contain the operation_interval,
     *                       operation_interval_id, interval_start and interval_end details.
     * @param Date $oDate The current Date object, taken from the OA_ServiceLocator.
     * @param array $aPastDeliveryResult Optional array of arrays indexed by ad ID, and then
     *                                   zone ID, containing details on which ad/zone
     *                                   combinations already have had their average past
     *                                   priority information calculated (if any).
     */
    function _calculateAveragePastPriorityValues(&$aPastPriorityResult, $aResult, $oDate, $aPastDeliveryResult = null)
    {
        if (is_array($aResult) && (!empty($aResult))) {
            // Loop through the results, and ensure that an array exists for each
            // ad ID, zone ID pair, and also store the initial values of the data
            foreach ($aResult as $aRow) {
                if (!isset($aPastPriorityResult[$aRow['ad_id']])) {
                    $aPastPriorityResult[$aRow['ad_id']] = array();
                }
                if (!isset($aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']])) {
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']] = array(
                        'ad_id'                         => $aRow['ad_id'],
                        'zone_id'                       => $aRow['zone_id'],
                        'required_impressions'          => $aRow['required_impressions'],
                        'requested_impressions'         => $aRow['requested_impressions'],
                        'to_be_delivered'               => $aRow['to_be_delivered'],
                        'priority_factor'               => $aRow['priority_factor'],
                        'past_zone_traffic_fraction'    => $aRow['past_zone_traffic_fraction']
                    );
                    if (isset($aRow['operation_interval'])) {
                        $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['operation_interval']    = $aRow['operation_interval'];
                        $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['operation_interval_id'] = $aRow['operation_interval_id'];
                        $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['interval_start']        = $aRow['interval_start'];
                        $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['interval_end']          = $aRow['interval_end'];
                    }
                }
            }
            // As more than one row of past priority information may have been found
            // in the data, re-loop over the array of results, to see if the values
            // changed during operation interval the data represents
            foreach ($aResult as $aRow) {
                // Compare set values from above, and if there is a difference,
                // set values to zero, and mark as requiring calculation of the
                // averate impressions requested and priority factor
                if ((($aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['required_impressions'] != $aRow['required_impressions']) ||
                ($aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['requested_impressions'] != $aRow['requested_impressions']) ||
                ($aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['priority_factor'] != $aRow['priority_factor'])) &&
                (!$aPastDeliveryResult[$aRow['ad_id']][$aRow['zone_id']]['pastPriorityFound'])) {
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['required_impressions'] = 0;
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['requested_impressions'] = 0;
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['to_be_delivered'] = 0;
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['priority_factor'] = 0;
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['average'] = true;
                    unset($aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['pastPriorityFound']);
                } else {
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['pastPriorityFound'] = true;
                }
            }
            // Loop again, summing in the impressions, priorities (scaled by the length of time
            // they were active for) to the values, for those ad/zone combinations that require it
            foreach ($aResult as $aRow) {
                // Does this value need to be used to calculate the average?
                if (!empty($aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['average']) &&
                (!$aPastDeliveryResult[$aRow['ad_id']][$aRow['zone_id']]['pastPriorityFound'])) {
                    // Add the variable values to the array, multiplied by the number of seconds the
                    // values were active for over the "hour" (not exact, in the event that the
                    // maintenance script is not run spot on the hour, but close enough)
                    $oCreatedDate = new Date($aRow['created']);
                    if (is_null($aRow['expired'])) {
                        $oExpiredDate = new Date();
                        $oExpiredDate->copy($oDate);
                    } else {
                        $oExpiredDate = new Date($aRow['expired']);
                    }
                    $oSpan = new Date_Span();
                    $oSpan->setFromDateDiff($oCreatedDate, $oExpiredDate);
                    $seconds = $oSpan->toSeconds();
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['required_impressions'] +=
                    $aRow['required_impressions'] * $seconds;
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['requested_impressions'] +=
                    $aRow['requested_impressions'] * $seconds;
                    $aPastPriorityResult[$aRow['ad_id']][$aRow['zone_id']]['priority_factor'] +=
                    $aRow['priority_factor'] * $seconds;
                }
            }
            // Calculate the average impressions requested and priority factor used, for those
            // ad/zone combinations that require it
            if (!empty($aPastPriorityResult)) {
                foreach ($aPastPriorityResult as $a => $aAd) {
                    if (is_array($aAd) && (count($aAd) > 0)) {
                        foreach ($aAd as $z => $aZone) {
                            if (!empty($aPastPriorityResult[$a][$z]['average']) && (!$aPastPriorityResult[$a][$z]['pastPriorityFound'])) {
                                $aPastPriorityResult[$a][$z]['required_impressions'] /= SECONDS_PER_HOUR;
                                $aPastPriorityResult[$a][$z]['requested_impressions'] /= SECONDS_PER_HOUR;
                                $aPastPriorityResult[$a][$z]['priority_factor'] /= SECONDS_PER_HOUR;
                                $aPastPriorityResult[$a][$z]['pastPriorityFound'] = true;
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Updates the existing ad-zones priorities. MPE calculated these priorities
     * already so eCPM task has an easier job as its enough to simply update
     * the existing priorities.
     *
     * @param array $aData
     * @return boolean  True on success, otherwise false
     */
    public function updateEcpmPriorities(&$aData)
    {
        OA::debug('- Updating ECPM priorities ', PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        $dbHasTransactionSupport = !(strcasecmp($aConf['database']['type'], 'mysql') === 0
        && strcasecmp($aConf['table']['type'], 'myisam') === 0);
        if ($dbHasTransactionSupport) {
            $oRes = $this->oDbh->beginTransaction();
            if (PEAR::isError($oRes)) {
                // Cannot start transaction
                OA::debug('    - Error: Could not start transaction', PEAR_LOG_INFO);
                return false;
            }
        }
        $count = 0;
        if (is_array($aData) && !empty($aData)) {
            $table = $this->_getTablename('ad_zone_assoc');
            foreach($aData as $adId => $aZone) {
                foreach($aZone as $zoneId => $priority) {
                    $query = "
                        UPDATE
                        {$table}
                        SET
                            priority = {$priority},
                            priority_factor = 1
                        WHERE
                            ad_id = {$adId}
                            AND
                            zone_id = {$zoneId}";
                        $rows = $this->oDbh->exec($query);
                        if (PEAR::isError($rows)) {
                            OA::debug("    - Error updating ecpm priority, ad ID {$adId}, zone ID {$zoneId} pair priority to {$priority}.", PEAR_LOG_DEBUG);
                            if ($dbHasTransactionSupport) {
                                OA::debug('     - Error: Rolling back transaction', PEAR_LOG_DEBUG);
                                $this->oDbh->rollback();
                            }
                            return false;
                        }
                        $count++;
                }
            }
            if ($dbHasTransactionSupport) {
                $oRes = $this->oDbh->commit();
                if (PEAR::isError($oRes)) {
                    OA::debug('    - Error: Could not commit the transaction', PEAR_LOG_DEBUG);
                    return false;
                }
            }
        }
        OA::debug('- Updated ECPM priorities for '.$count.' ad/zones combinations', PEAR_LOG_INFO);
        return true;
    }

    /**
     * Updates the campaigns eCPM. MPE updates the eCPM each time it
     *
     * @param array $aCampaignsEcpms  Array - indexed with campaign Ids, contains ECPMs
     * @return boolean  True on success, otherwise false
     */
    public function updateCampaignsEcpms($aCampaignsEcpms)
    {
        OA::debug('- Updating Campaigns ECPMs', PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        $dbHasTransactionSupport = !(strcasecmp($aConf['database']['type'], 'mysql') === 0
        && strcasecmp($aConf['table']['type'], 'myisam') === 0);
        if ($dbHasTransactionSupport) {
            $oRes = $this->oDbh->beginTransaction();
            if (PEAR::isError($oRes)) {
                // Cannot start transaction
                OA::debug('    - Error: Could not start transaction', PEAR_LOG_DEBUG);
                return false;
            }
        }
        if (is_array($aCampaignsEcpms) && !empty($aCampaignsEcpms)) {
            $table = $this->_getTablename('campaigns');
            foreach($aCampaignsEcpms as $campaignId => $ecpm) {
                if(empty($ecpm)) {
                    $ecpm = 0;
                }
                $query = "
                    UPDATE
                    {$table}
                    SET
                        ecpm = {$ecpm}
                    WHERE
                        campaignid = {$campaignId}";
                    $rows = $this->oDbh->exec($query);
                    if (PEAR::isError($rows)) {
                        OA::debug("    - Error updating ecpm, campaign ID {$campaignId} to {$ecpm}.", PEAR_LOG_DEBUG);
                        if ($dbHasTransactionSupport) {
                            OA::debug('     - Error: Rolling back transaction', PEAR_LOG_DEBUG);
                            $this->oDbh->rollback();
                        }
                        return false;
                    }
            }
            if ($dbHasTransactionSupport) {
                $oRes = $this->oDbh->commit();
                if (PEAR::isError($oRes)) {
                    OA::debug('    - Error: Could not commit the transaction', PEAR_LOG_DEBUG);
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * A method to update the priority values stored in the database.
     *
     * Requires that a current day/time (as a Date object) be registered
     * with the OA_ServiceLocator (as "now").
     *
     * @access public
     * @param array $aData An array of zones, indexed by zone ID, each containing an array
     *                     "ads", which in turn is an array of hashes, each containing the
     *                     following indexes/data:
     *                      - "ad_id"                      The ad ID.
     *                      - "zone_id"                    The zone ID.
     *                      - "priority"                   The ad/zone priority value.
     *                      - "impressions_required"       The number of impressions required for the
     *                                                     placement the ad/zone link is in to delivery
     *                                                     to meet its targets.
     *                      - "impressions_requested"      The number of impressions the priority
     *                                                     should result in.
     *                      - "priority_factor"            The priority adjustment factor used to
     *                                                     compensate for filters.
     *                      - "priority_factor_limited"    If the priority factor was limited, or not.
     *                      - "past_zone_traffic_fraction" The fraction of the zone's impressions
     *                                                     given to the ad in the previous operation
     *                                                     interval.
     * @return boolean True on success, false on failure.
     *
     * @TODO Update the "created_by", "expired_by" fields once OpenX has a role-based
     *       permissions system in place.
     * @TODO Write the code that inserts non-static priorities.
     */
    function updatePriorities(&$aData)
    {
        OA::debug('- Updating priorities', PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDate =& $oServiceLocator->get('now');
        if (!$oDate) {
            OA::debug('  - Date not found in service locator', PEAR_LOG_DEBUG);
            return false;
        }
        $currentOperationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        // Delete all category-based (ie. link_type = MAX_AD_ZONE_LINK_CATEGORY) priorities
        // from ad_zone_assoc
        OA::debug('  - Zeroing category-based priorities', PEAR_LOG_DEBUG);
        $table = $this->_getTablename('ad_zone_assoc');
        $query = "
            DELETE FROM
            {$table}
            WHERE
                link_type = " . MAX_AD_ZONE_LINK_CATEGORY;
            $rows = $this->oDbh->exec($query);
            if (PEAR::isError($rows)) {
                OA::debug('  - Error zeroing category-based priorities', PEAR_LOG_DEBUG);
                return false;
            }
            // Does the database in use support transactions?
            if (
            strcasecmp($aConf['database']['type'], 'mysql') === 0
            &&
            strcasecmp($aConf['table']['type'], 'myisam') === 0
            )
            {
                // Oh noz! No transaction support? How tragic!
                OA::debug('  - Saving calculated priorities WITHOUT transaction support', PEAR_LOG_DEBUG);
                // Obtain the list of all existing normal (ie. link_type = MAX_AD_ZONE_LINK_NORMAL)
                // ad/zone pairs that are in the ad_zone_assoc table
                OA::debug('    - Getting all existing ad/zone pairs with priorities', PEAR_LOG_DEBUG);
                $table = $this->_getTablename('ad_zone_assoc');
                $query = "
                SELECT
                    ad_id,
                    zone_id
                FROM
                {$table}
                WHERE
                    link_type = " . MAX_AD_ZONE_LINK_CATEGORY;
                $aRows = $this->oDbh->queryAll($query);
                if (PEAR::isError($aRows)) {
                    OA::debug('  - Error getting all existing ad/zone pairs with priorities', PEAR_LOG_DEBUG);
                    return false;
                }
                // Iterate over the old ad/zone pair priorities, and mark any
                // that do NOT have new values (and will therefore have to be
                // set to zero)
                OA::debug('    - Calculating which existing ad/zone pair priorities need to be zeroed', PEAR_LOG_DEBUG);
                $aSetToZero = array();
                reset($aRows);
                while (list(,$aRow) = each($aRows)) {
                    if (is_null($aData[$aRow['zone_id']][$aRow['ad_id']])) {
                        // There is no new priority value for this existing ad/zone pair
                        $aSetToZero[$aRow['zone_id']][$aRow['ad_id']] = true;
                    }
                }
                // Set all required normal (ie. link_type = MAX_AD_ZONE_LINK_NORMAL) priorities to zero
                OA::debug('    - Zeroing required existing ad/zone pair priorities', PEAR_LOG_DEBUG);
                reset($aSetToZero);
                while (list($zoneId, $aAds) = each($aSetToZero)) {
                    reset($aAds);
                    while (list($adId,) = each($aAds)) {
                        OA::debug("    - Zeroing ad ID $adId, zone ID $zoneID pair priority.", PEAR_LOG_DEBUG);
                        $table = $this->_getTablename('ad_zone_assoc');
                        $query = "
                        UPDATE
                        {$table}
                        SET
                            priority = 0
                        WHERE
                            ad_id = $adId
                            AND
                            zone_id = $zoneId
                            AND
                            link_type = " . ($zoneId != 0 ? MAX_AD_ZONE_LINK_NORMAL : MAX_AD_ZONE_LINK_DIRECT);
                        $rows = $this->oDbh->exec($query);
                        if (PEAR::isError($rows)) {
                            OA::debug("  - Error zeroing ad ID $adId, zone ID $zoneID pair priority.", PEAR_LOG_DEBUG);
                            return false;
                        }
                    }
                }
                // Update the required normal (ie. link_type = MAX_AD_ZONE_LINK_NORMAL) priorities
                OA::debug('    - Updating required existing ad/zone pair priorities', PEAR_LOG_DEBUG);
                if (is_array($aData) && (count($aData) > 0)) {
                    reset($aData);
                    while (list(,$aZoneData)  = each($aData)) {
                        if (is_array($aZoneData['ads']) && (count($aZoneData['ads']) > 0)) {
                            foreach ($aZoneData['ads'] as $aAdZonePriority) {
                                $table = $this->_getTablename('ad_zone_assoc');
                                $query = "
                                UPDATE
                                {$table}
                                SET
                                    priority = ".(float)$aAdZonePriority['priority'].",
                                    priority_factor = " . (is_null($aAdZonePriority['priority_factor']) ? 'NULL' : $aAdZonePriority['priority_factor']) . ",
                                    to_be_delivered = " . ($aAdZonePriority['to_be_delivered'] ? 1 : 0) . "
                                WHERE
                                    ad_id = {$aAdZonePriority['ad_id']}
                                    AND
                                    zone_id = {$aAdZonePriority['zone_id']}
                                    AND
                                    link_type = " . ($aAdZonePriority['zone_id'] != 0 ? MAX_AD_ZONE_LINK_NORMAL : MAX_AD_ZONE_LINK_DIRECT);
                                $rows = $this->oDbh->exec($query);
                                if (PEAR::isError($rows)) {
                                    OA::debug("    - Error updating ad ID {$aAdZonePriority['ad_id']}, zone ID {$aAdZonePriority['zone_id']} pair priority to {$aAdZonePriority['priority']}.", PEAR_LOG_DEBUG);
                                    return false;
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                // Oh yeah, baby, none of that ACID-less MyISAM for me!
                OA::debug('   - Saving calculated priorities WITH transaction support', PEAR_LOG_DEBUG);
                // Start a transaction
                OA::debug('  - Starting transaction', PEAR_LOG_DEBUG);
                $oRes = $this->oDbh->beginTransaction();
                if (PEAR::isError($oRes)) {
                    // Cannot start transaction
                    OA::debug('    - Error: Could not start transaction', PEAR_LOG_DEBUG);
                    return $oRes;
                }
                // Set all normal (ie. link_type = MAX_AD_ZONE_LINK_NORMAL) priorities to zero
                OA::debug('    - Zeroing all existing ad/zone pair priorities', PEAR_LOG_DEBUG);
                $table = $this->_getTablename('ad_zone_assoc');
                $query = "
                UPDATE
                {$table}
                SET
                    priority = 0
                WHERE
                    link_type = " . MAX_AD_ZONE_LINK_DIRECT . "
                    OR
                    link_type = " . MAX_AD_ZONE_LINK_NORMAL;
                $rows = $this->oDbh->exec($query);
                if (PEAR::isError($rows)) {
                    OA::debug('     - Error: Rolling back transaction', PEAR_LOG_DEBUG);
                    $this->oDbh->rollback();
                    return false;
                }
                // Update the required normal (ie. link_type = MAX_AD_ZONE_LINK_NORMAL) priorities
                OA::debug('    - Updating required existing ad/zone pair priorities', PEAR_LOG_DEBUG);
                if (is_array($aData) && (count($aData) > 0)) {
                    reset($aData);
                    while (list(,$aZoneData)  = each($aData)) {
                        if (is_array($aZoneData['ads']) && (count($aZoneData['ads']) > 0)) {
                            foreach ($aZoneData['ads'] as $aAdZonePriority) {
                                $table = $this->_getTablename('ad_zone_assoc');
                                $query = "
                                UPDATE
                                {$table}
                                SET
                                    priority = ".(float)$aAdZonePriority['priority'].",
                                    priority_factor = " . (is_null($aAdZonePriority['priority_factor']) ? 'NULL' : $aAdZonePriority['priority_factor']) . ",
                                    to_be_delivered = " . ($aAdZonePriority['to_be_delivered'] ? 1 : 0) . "
                                WHERE
                                    ad_id = {$aAdZonePriority['ad_id']}
                                    AND
                                    zone_id = {$aAdZonePriority['zone_id']}
                                    AND
                                    link_type = " . ($aAdZonePriority['zone_id'] != 0 ? MAX_AD_ZONE_LINK_NORMAL : MAX_AD_ZONE_LINK_DIRECT);
                                $rows = $this->oDbh->exec($query);
                                if (PEAR::isError($rows)) {
                                    OA::debug('    - Error: Rolling back transaction', PEAR_LOG_DEBUG);
                                    $this->oDbh->rollback();
                                    return false;
                                }
                            }
                        }
                    }
                }
                // Commit the transaction
                $oRes = $this->oDbh->commit();
                if (PEAR::isError($oRes)) {
                    OA::debug('    - Error: Could not commit the transaction', PEAR_LOG_DEBUG);
                    return $oRes;
                }
            }
            // Expire the old priority values in data_summary_ad_zone_assoc
            OA::debug("  - Epiring old priority values in {$aConf['table']['data_summary_ad_zone_assoc']}", PEAR_LOG_DEBUG);
            $table = $this->_getTablename('data_summary_ad_zone_assoc');
            $query = "
            UPDATE
            {$table}
            SET
                expired = '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "',
                expired_by = 0
            WHERE
                expired IS NULL";
            $rows = $this->oDbh->exec($query);
            if (PEAR::isError($rows)) {
                return false;
            }
            // Add the new priority values to data_summary_ad_zone_assoc
            $tableName = $aConf['table']['data_summary_ad_zone_assoc'];
            OA::debug("  - Adding new priority values to $tableName", PEAR_LOG_DEBUG);
            if (is_array($aData) && !empty($aData)) {
                $aValues = array();
                reset($aData);
                while (list(,$aZoneData) = each($aData)) {
                    if (is_array($aZoneData['ads']) && !empty($aZoneData['ads'])) {
                        foreach ($aZoneData['ads'] as $aAdZonePriority) {

                            $aValues[] = array(
                            $aConf['maintenance']['operationInterval'],
                            $currentOperationIntervalID,
                            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
                            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
                            $aAdZonePriority['ad_id'],
                            $aAdZonePriority['zone_id'],
                            $aAdZonePriority['required_impressions'],
                            $aAdZonePriority['requested_impressions'],
                            ($aAdZonePriority['to_be_delivered'] ? 1 : 0),
                            $aAdZonePriority['priority'],
                            $aAdZonePriority['priority_factor'],
                            !empty($aAdZonePriority['priority_factor_limited']) ? 1 : 0,
                            isset($aAdZonePriority['past_zone_traffic_fraction']) ? $aAdZonePriority['past_zone_traffic_fraction'] : null,
                            $oDate->format('%Y-%m-%d %H:%M:%S'),
                            0
                            );
                        }
                    }
                }
                if (is_array($aValues) && !empty($aValues)) {
                    $tableNameUnquoted = $this->_getTablenameUnquoted('data_summary_ad_zone_assoc');
                    $fields = array(
                            'operation_interval',
                            'operation_interval_id',
                            'interval_start',
                            'interval_end',
                            'ad_id',
                            'zone_id',
                            'required_impressions',
                            'requested_impressions',
                            'to_be_delivered',
                            'priority',
                            'priority_factor',
                            'priority_factor_limited',
                            'past_zone_traffic_fraction',
                            'created',
                            'created_by'
                    );
                    $this->batchInsert($tableNameUnquoted, $aValues, $fields);
                }
            }

            return true;
    }

    /**
     * A method to get all active zones in the system.
     *
     * An active zone is a zone that is linked to at least one advertisement
     * (via the ad_zone_assoc table), where the advertisement has its "active"
     * field set to true.
     *
     * @return mixed Either:
     *      - An array of zone IDs, or
     *      - A PEAR::Error.
     */
    function getActiveZones()
    {
        $table1 = $this->_getTablename('zones');
        $table2 = $this->_getTablename('ad_zone_assoc');
        $table3 = $this->_getTablename('banners');
        $table4 = $this->_getTablename('campaigns');
        $query = "
            SELECT
                z.zoneid AS zoneid,
                z.zonename AS zonename,
                z.zonetype AS zonetype
            FROM
            {$table1} AS z,
            {$table2} AS aza,
            {$table3} as b,
            {$table4} as c
            WHERE
                z.zoneid = aza.zone_id
                AND
                b.campaignid = c.campaignid
                AND
                aza.ad_id = b.bannerid
                AND
                b.status = ".OA_ENTITY_STATUS_RUNNING."
                AND
                c.status = ".OA_ENTITY_STATUS_RUNNING."
                AND
                c.priority > 0
            GROUP BY
                zoneid,
                zonename,
                zonetype
            ORDER BY
                zoneid";
            $rc = $this->oDbh->query($query);
            if (PEAR::isError($rc)) {
                return $rc;
            }
            return $rc->fetchAll();
    }

    /**
     * A method to save the total impressions required for each advert
     * into the temporary tmp_ad_required_impression table.
     *
     * @param array $aData An array of array, each containing the
     *                     "ad_id", and its associated "required_impressions".
     */
    function saveRequiredAdImpressions($aData)
    {
        if (is_array($aData) && (count($aData) > 0)) {
            $tableNameUnquoted = 'tmp_ad_required_impression';
            $data = array();
            foreach ($aData as $aValues) {
                $data[] = array(
                $aValues['ad_id'],
                $aValues['required_impressions']
                );
            }
            $this->batchInsert($tableNameUnquoted, $data, array('ad_id', 'required_impressions'));
        }
    }

    /**
     * A method to get the required impressions for a list of advertisements
     * from the tmp_ad_required_impression table.
     *
     * @param array $aAdvertID An array of advertisement IDs.
     * @return array An array of required impressions, indexed by advertisement ID.
     */
    function getRequiredAdImpressions($aAdvertID)
    {
        if (empty($aAdvertID)) {
            return array();
        }
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Table tmp_ad_required_impression might not exist
        // It happens if there isn't any campaign for which required impressions should be calculated
        // This situation is equal to empty table, so just return empty array
        if ( !isset($GLOBALS['_OA']['DB_TABLES']['tmp_ad_required_impression'])) {
            return array();
        }

        $tableTmp = $this->oDbh->quoteIdentifier('tmp_ad_required_impression');
        $query = "
            SELECT
                ad_id AS ad_id,
                required_impressions AS required_impressions
            FROM
            {$tableTmp}
            WHERE
                ad_id IN (" . implode(', ', $aAdvertID) . ')';
            // Don't use a PEAR_Error handler
            PEAR::pushErrorHandling(null);
            // Execute the query
            $rc = $this->oDbh->query($query);
            // Resore the PEAR_Error handler
            PEAR::popErrorHandling();
            if (!PEAR::isError($rc)) {
                $aResult = array();
                while ($row = $rc->fetchRow()) {
                    $aResult[$row['ad_id']] = $row['required_impressions'];
                }
                return $aResult;
            } elseif (PEAR::isError($rc, DB_ERROR_NOSUCHTABLE)) {
                return array();
            }
            MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
    }

    /**
     * A method to get the required impressions for a list of advertisements
     * from the tmp_ad_required_impression table per each advertisement and zone.
     *
     * @param array $aAdvertID An array of advertisement IDs.
     * @return array An array of required impressions, indexed by zone ID
     *               and advertisement ID
     */
    function getRequiredAdZoneImpressions($aAdvertID)
    {
        if (empty($aAdvertID)) {
            return array();
        }
        $aConf = $GLOBALS['_MAX']['CONF'];

        $tableTmp = $this->oDbh->quoteIdentifier('tmp_ad_zone_impression');
        $query = "
            SELECT
                ad_id AS ad_id,
                zone_id AS zone_id,
                required_impressions AS required_impressions
            FROM
            {$tableTmp}
            WHERE
                ad_id IN (" . implode(', ', $aAdvertID) . ')';
        // Don't use a PEAR_Error handler
        PEAR::pushErrorHandling(null);
        // Execute the query
        $rc = $this->oDbh->query($query);
        // Resore the PEAR_Error handler
        PEAR::popErrorHandling();
        if (!PEAR::isError($rc)) {
            $aResult = array();
            while ($row = $rc->fetchRow()) {
                $aResult[$row['zone_id']][$row['ad_id']] = $row['required_impressions'];
            }
            return $aResult;
        } elseif (PEAR::isError($rc, DB_ERROR_NOSUCHTABLE)) {
            return array();
        }
        MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
    }

    /**
     * A method to get the ad/zone associations, based on a list of advertisement IDs.
     * Only returns normal ad/zone associations (ie. link_type = MAX_AD_ZONE_LINK_NORMAL),
     * not special direct selection associations, or category associations.
     *
     * @param array $aAdvertID An array of advertisement IDs.
     * @return mixed An array of arrays, indexed by advertisement ID, with each
     *               sub-array containing the zones that the adversisement is linked to.
     *               For example:
     *               array(
     *                   7 => array(
     *                            0 => array('zone_id' => 9),
     *                            1 => array('zone_id' => 42),
     *                                  .
     *                                  .
     *                                  .
     *                        )
     *                   .
     *                   .
     *                   .
     *               )
     */
    function getAdZoneAssociationsByAds($aAdvertID)
    {
        if (!is_array($aAdvertID) || empty($aAdvertID)) {
            return array();
        }
        $aConf = $GLOBALS['_MAX']['CONF'];
        $query = array();
        $table             = $this->_getTablenameUnquoted('ad_zone_assoc');
        $query['table']    = $table;
        $query['fields']   = array(
                                "$table.ad_id AS ad_id",
                                "$table.zone_id AS zone_id"
        );
        $query['wheres']   = array(
        array("$table.ad_id IN (" . implode(', ', $aAdvertID) . ')', 'AND'),
        array("$table.link_type = " . MAX_AD_ZONE_LINK_NORMAL, 'AND')
        );
        $result = $this->_get($query);
        $aResult = array();
        foreach ($result as $row) {
            $aResult[$row['ad_id']][] = array('zone_id' => $row['zone_id']);
        }
        return $aResult;
    }

    /**
     * A method to save ad/zone impression allocations to the tmp_ad_zone_impression
     * table.
     *
     * @param array An array of arrays, with each sub-array containing the "ad_id",
     *              "zone_id", "required_impressions" and "requested_impressions".
     */
    function saveAllocatedImpressions($aData)
    {
        $tableNameUnquoted = 'tmp_ad_zone_impression';
        $tableTmp = $this->oDbh->quoteIdentifier($tableNameUnquoted);
        // Make sure that the table is empty
        $query = "TRUNCATE TABLE {$tableTmp}";
        $this->oDbh->exec($query);

        if (is_array($aData) && (count($aData) > 0)) {
            $data = array();
            foreach ($aData as $aValues)
            {
                $data[] = array(
                $aValues['ad_id'],
                $aValues['zone_id'],
                $aValues['required_impressions'],
                $aValues['requested_impressions'],
                ($aValues['to_be_delivered'] ? 1 : 0)
                );
            }
            $this->batchInsert($tableNameUnquoted, $data, array('ad_id', 'zone_id', 'required_impressions', 'requested_impressions', 'to_be_delivered'));
        }
    }

    /**
     * Performs a batch insert
     *
     * @see OA_Dal::batchInsert()
     *
     * @param string $tableNameUnquoted The unquoted table name (including prefix, see _getTablenameUnquoted)
     * @param array  $data              The array of data to be inserted
     * @param array  $fields            The array of unquoted field names
     */
    function batchInsert($tableNameUnquoted, $data, $fields)
    {
        $result = OA_Dal::batchInsert($tableNameUnquoted, $fields, $data);
        if (PEAR::isError($result)) {
            Max::raiseError($result->getMessage(), PEAR_ERROR_DIE);
        }
        OA::debug('Inserted '. $result .' rows in the table '. $tableNameUnquoted, PEAR_LOG_INFO);
    }


    /**
     * A method to return the forecast impressions for a zone, indexed by operation interval,
     * from the current operation interval through the past week. If no forecast stored in
     * the database for a given OI, uses average of forecasts found.
     *
     * @param integer $zoneId The Zone ID.
     * @return mixed An array on success, false on failure. The array is of the format:
     *                   array(
     *                       [operation_interval_id] => array(
     *                                                      ['zone_id']               => zone_id,
     *                                                      ['_impressions']  => forecast_impressions,
     *                                                      ['operation_interval_id'] => operation_interval_id
     *                                                  )
     *                       [operation_interval_id] => array(
     *                                                      ['zone_id']               => zone_id,
     *                                                      ['forecast_impressions']  => forecast_impressions,
     *                                                      ['operation_interval_id'] => operation_interval_id
     *                                                  )
     *                                   .
     *                                   .
     *                                   .
     *                   )
     */
    function getPreviousWeekZoneForcastImpressions($zoneId)
    {
        if (empty($zoneId) || !is_numeric($zoneId)) {
            OA::debug('Invalid zone ID argument', PEAR_LOG_ERR);
            return false;
        }
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDate =& $oServiceLocator->get('now');
        if (!$oDate) {
            return false;
        }
        // Get previous OI
        $oPreviousOI = new Date($oDate);
        $oPreviousOI->subtractSeconds(OX_OperationInterval::getOperationInterval() * 60);
        // Get the start and end ranges of the current week, up to the previous OI
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oPreviousOI);
        $oDateWeekStart = new Date();
        $oDateWeekStart->copy($aDates['end']);
        $oDateWeekStart->subtractSeconds(SECONDS_PER_WEEK - 1);
        $oDateWeekEnd = new Date();
        $oDateWeekEnd->copy($aDates['end']);
        // Select the zone forecasts from the database
        $tableName = $this->_getTablename('data_intermediate_ad');
        $oneHourInterval = OA_Dal::quoteInterval(1, 'hour');
        $query = "
            SELECT
                SUM(impressions) AS forecast_impressions,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end
            FROM
            {$tableName}
            WHERE
                zone_id = $zoneId
                AND operation_interval = {$aConf['maintenance']['operationInterval']}
                AND interval_start >= '" . $oDateWeekStart->format('%Y-%m-%d %H:%M:%S') . "'
                AND interval_end <= '" . $oDateWeekEnd->format('%Y-%m-%d %H:%M:%S') . "'
                AND date_time > DATE_SUB('" . $oDateWeekStart->format('%Y-%m-%d %H:%M:%S') . "', $oneHourInterval)
                AND date_time < DATE_ADD('" . $oDateWeekEnd->format('%Y-%m-%d %H:%M:%S') . "', $oneHourInterval)
                AND zone_id != 0
            GROUP BY
            	interval_start,
            	interval_end,
            	operation_interval_id
            ORDER BY
                interval_start";
            $rc = $this->oDbh->query($query);

            $totalForecastImpressions = 0;
            $count = 0;
            if (!(PEAR::isError($rc))) {
                // Sort the results into an array indexed by the operation interval ID
                $aFinalResult = array();
                while ($aRow = $rc->fetchRow()) {
                    $aFinalResult[$aRow['operation_interval_id']] =
                    array(
                        'zone_id'               => $zoneId,
                        'forecast_impressions'  => $aRow['forecast_impressions'],
                        'operation_interval_id' => $aRow['operation_interval_id']
                    );
                    $count++;
                    $totalForecastImpressions += $aRow['forecast_impressions'];
                }
            }

            $averageForecastImpressions = 0;
            if($count > 0) {
                $averageForecastImpressions = floor($totalForecastImpressions / $count);
            }
            if($averageForecastImpressions == 0) {
                $averageForecastImpressions = $this->getZoneForecastDefaultZoneImpressions();
            }
            // Check each operation interval ID has a forecast impression value,
            // and if not, set to the system default.
            for ($operationIntervalID = 0; $operationIntervalID < OX_OperationInterval::operationIntervalsPerWeek(); $operationIntervalID++) {
                if (!isset($aFinalResult[$operationIntervalID])) {
                    $aFinalResult[$operationIntervalID] = array(
                    'zone_id'               => $zoneId,
                    'forecast_impressions'  => $averageForecastImpressions,
                    'operation_interval_id' => $operationIntervalID,
                    );
                }
            }
            // Overwrite current OI with previous OI to match the zone forecasting algorithm
            $currOI = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
            $prevOI = OX_OperationInterval::previousOperationIntervalID($currOI);
            $aFinalResult[$currOI]['forecast_impressions'] = $aFinalResult[$prevOI]['forecast_impressions'];
            // Return data
            return $aFinalResult;
    }

    /**
     * Obtains a database-level lock for the Maintenance Priority Engine process.
     *
     * @return boolean True if lock was obtained, false otherwise.
     */
    function obtainPriorityLock()
    {
        $this->oLock =& OA_DB_AdvisoryLock::factory();
        return $this->oLock->get('mpe', 1);
    }

    /**
     * Releases the database-level lock for the Maintenance Priority Engine process.
     *
     * @return mixed True if lock was released, a PEAR Error otherwise.
     */
    function releasePriorityLock()
    {
        if (empty($this->oLock)) {
            OA::debug('  - Lock wasn\'t acquired by the same DB connection', PEAR_LOG_ERR);
            return false;
        } elseif (!$this->oLock->hasSameId('mpe')) {
            OA::debug('  - Lock names to not match', PEAR_LOG_ERR);
            return false;
        }
        return $this->oLock->release();
    }

    /**
     * Returns an array of agencies (managers) IDs which has any
     * ecpm campaigns running.
     *
     * @return array  Array with IDs of agencies IDs
     */
    public function getEcpmAgenciesIds()
    {
        OA::debug('- Selecting Managers with ECPM priority campaigns running', PEAR_LOG_INFO);
        $query = "SELECT
                    DISTINCT cl.agencyid AS agencyid
                  FROM
                  {$this->_getTablename('campaigns')} AS c,
                  {$this->_getTablename('clients')} AS cl
                  WHERE
                    cl.clientid = c.clientid
                    AND c.status = " . OA_ENTITY_STATUS_RUNNING . "
                    AND c.priority = " . DataObjects_Campaigns::PRIORITY_ECPM;
                  return $this->getAgenciesIdsFromQuery($query);
    }

    /**
     * Returns an array of agencies (managers) IDs which has any
     * ecpm campaigns running.
     *
     * @return array  Array with IDs of agencies IDs
     */
    public function getEcpmContractAgenciesIds()
    {
        OA::debug('- Selecting Managers with ECPM contract campaigns running', PEAR_LOG_INFO);
        $query = "SELECT
                    DISTINCT cl.agencyid AS agencyid
                  FROM
                  {$this->_getTablename('campaigns')} AS c,
                  {$this->_getTablename('clients')} AS cl
                  WHERE
                    cl.clientid = c.clientid
                    AND c.ecpm_enabled = 1";
        return $this->getAgenciesIdsFromQuery($query);
    }

    /**
     * Returns an array of agencies (managers) IDs
     *
     * @return array  Array with IDs of agencies IDs
     */
    public function getAllAgenciesIds()
    {
        OA::debug('- Selecting All Managers', PEAR_LOG_INFO);
        $query = "SELECT
                    DISTINCT cl.agencyid AS agencyid
                  FROM
                  {$this->_getTablename('campaigns')} AS c,
                  {$this->_getTablename('clients')} AS cl
                  WHERE
                    cl.clientid = c.clientid";
        return $this->getAgenciesIdsFromQuery($query);
    }

    /**
     * Returns an array of agencies (managers) IDs using the provided
     * SQL query to retreive the data from the database.
     *
     * @param  string  SQL query which retreives the agencies ids
     * @return array  Array with IDs of agencies IDs
     */
    public function getAgenciesIdsFromQuery($query)
    {
        $rc = $this->oDbh->query($query);
        $aResult = array();
        if (PEAR::isError($rc)) {
            OA::debug('  - Error getting agencies IDs from database', PEAR_LOG_DEBUG);
            return $aResult;
        }
        while ($aRow = $rc->fetchRow()) {
            if (PEAR::isError($aRow)) {
                OA::debug('  - Error retreiving agency record from database', PEAR_LOG_DEBUG);
            } else {
                $aResult[] = $aRow['agencyid'];
            }
        }
        return $aResult;
    }

    /**
     * Retreives the list of all active eCPM campaigns for a given agency ID
     * (manager)
     *
     * This function is executed after other tasks in MPE, therefore we can
     * assume that most of work is already done for us. One thing we can rely
     * on is that ad_zone_assoc was already created by previous MPE tasks.
     *
     * @param integer $agencyId  Agency (manager) ID
     * @return array  Array of campaigns, zones and
     *                ads which are linked to each other for given agency.
     *                Format, see method: getCampaignsInfoByQuery()
     */
    public function getCampaignsInfoByAgencyId($agencyId)
    {
        OA::debug('  - Selecting all active ECPM campaigns for manager '.$agencyId, PEAR_LOG_INFO);
        $query = "SELECT
                      c.campaignid AS campaignid,
                      c.revenue AS revenue,
                      c.revenue_type AS revenue_type,
                      c.min_impressions AS min_impressions,
                      c.activate_time AS activate_time,
                      c.expire_time AS expire_time,
                      b.bannerid AS bannerid,
                      b.weight AS weight,
                      aza.zone_id AS zone_id
                  FROM
                  {$this->_getTablename('clients')} AS cl,
                  {$this->_getTablename('campaigns')} AS c,
                  {$this->_getTablename('banners')} AS b,
                  {$this->_getTablename('ad_zone_assoc')} AS aza
                  WHERE
                      b.campaignid = c.campaignid
                      AND aza.ad_id = b.bannerid
                      AND cl.clientid = c.clientid
                      AND c.status = ".OA_ENTITY_STATUS_RUNNING."
                      AND b.status = ".OA_ENTITY_STATUS_RUNNING."
                      AND c.priority = ".DataObjects_Campaigns::PRIORITY_ECPM."
                      AND aza.zone_id != 0
                      AND cl.agencyid = " . $agencyId;
                  return $this->getCampaignsInfoByQuery($query);
    }

    /**
     * Retreives the list of all active eCPM HPC campaigns for a given agency ID
     * (manager) within given campaign priority.
     *
     * @param integer $agencyId  Agency (manager) ID
     * @param integer $priority  Campaign priority
     * @return array  Array of campaigns, zones and
     *                ads which are linked to each other for given agency.
     *                Format, see method: getCampaignsInfoByQuery()
     */
    public function getCampaignsInfoByAgencyIdAndPriority($agencyId, $priority)
    {
        OA::debug('  - Selecting active ECPM High Priority campaigns with priority = \''.$priority.'\' for manager '.$agencyId, PEAR_LOG_INFO);
        $query = "SELECT
                      c.campaignid AS campaignid,
                      c.revenue AS revenue,
                      c.revenue_type AS revenue_type,
                      c.min_impressions AS min_impressions,
                      c.activate_time AS activate_time,
                      c.expire_time AS expire_time,
                      b.bannerid AS bannerid,
                      b.weight AS weight,
                      aza.zone_id AS zone_id
                  FROM
                  {$this->_getTablename('clients')} AS cl,
                  {$this->_getTablename('campaigns')} AS c,
                  {$this->_getTablename('banners')} AS b,
                  {$this->_getTablename('ad_zone_assoc')} AS aza
                  WHERE
                      b.campaignid = c.campaignid
                      AND aza.ad_id = b.bannerid
                      AND cl.clientid = c.clientid
                      AND c.status = ".OA_ENTITY_STATUS_RUNNING."
                      AND b.status = ".OA_ENTITY_STATUS_RUNNING."
                      AND c.priority = ".$priority."
                      AND c.ecpm_enabled = 1
                      AND aza.zone_id != 0
                      AND cl.agencyid = " . $agencyId;
                  return $this->getCampaignsInfoByQuery($query);
    }

    /**
     * Retreives the list of all active campaigns for a given agency ID
     * (manager) within given campaign priority.  This does not test
     * for ecpm_enabled or priority = ECPM.
     *
     * @param integer $agencyId  Agency (manager) ID
     * @param integer $priority  Campaign priority
     * @return array  Array of campaigns, zones and
     *                ads which are linked to each other for given agency.
     *                Format, see method: getCampaignsInfoByQuery()
     */
    public function getAllCampaignsInfoByAgencyIdAndPriority($agencyId, $priority)
    {
        OA::debug('  - Selecting active campaigns with priority = \''.$priority.'\' for manager '.$agencyId, PEAR_LOG_INFO);
        $query = "SELECT
                      c.campaignid AS campaignid,
                      c.revenue AS revenue,
                      c.revenue_type AS revenue_type,
                      c.min_impressions AS min_impressions,
                      c.activate_time AS activate_time,
                      c.expire_time AS expire_time,
                      b.bannerid AS bannerid,
                      b.weight AS weight,
                      aza.zone_id AS zone_id
                  FROM
                  {$this->_getTablename('clients')} AS cl,
                  {$this->_getTablename('campaigns')} AS c,
                  {$this->_getTablename('banners')} AS b,
                  {$this->_getTablename('ad_zone_assoc')} AS aza
                  WHERE
                      b.campaignid = c.campaignid
                      AND aza.ad_id = b.bannerid
                      AND cl.clientid = c.clientid
                      AND c.status = ".OA_ENTITY_STATUS_RUNNING."
                      AND b.status = ".OA_ENTITY_STATUS_RUNNING."
                      AND c.priority = ".$priority."
                      AND aza.zone_id != 0
                      AND cl.agencyid = " . $agencyId;
                  return $this->getCampaignsInfoByQuery($query);
    }

    /**
     * Retreives the list of campaigns for a given SQL query.
     *
     * @param integer $agencyId  Agency (manager) ID
     * @return array  Array of campaigns, zones and
     *                ads which are linked to each other for given agency.
     *                Format:
     *                array(
     *                   campaignid (integer) => array(
     *                       self::IDX_REVENUE => (float),
     *                       self::IDX_REVENUE_TYPE => (integer),
     *                       self::IDX_MIN_IMPRESSIONS => (integer)
     *                       self::IDX_ADS => array(
     *                         adid (integer) => array(
     *                           self::IDX_WEIGHT => (integer)
     *                           self::IDX_ZONES => array(zoneid (integer), ...)
     *                         )
     *                       ),...
     *                   ),...
     */
    public function getCampaignsInfoByQuery($query)
    {
        $rc = $this->oDbh->query($query);
        $aResult = array();
        if (PEAR::isError($rc)) {
            OA::debug('  - Error getting campaigns from database', PEAR_LOG_DEBUG);
            return $aResult;
        }

        require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ECPMforRemnant.php';
        $idxAds = OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant::IDX_ADS;
        $idxZones = OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant::IDX_ZONES;
        $idxWeight = OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant::IDX_WEIGHT;
        $idxRevenue = OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant::IDX_REVENUE;
        $idxRevenueType = OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant::IDX_REVENUE_TYPE;
        $idxImpr = OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant::IDX_MIN_IMPRESSIONS;
        $idxActivate = OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant::IDX_ACTIVATE;
        $idxExpire = OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant::IDX_EXPIRE;

        // Format output into desired structure (see comments in a phpdoc above)
        while ($aRow = $rc->fetchRow()) {
            if (PEAR::isError($aRow)) {
                OA::debug('  - Error retreiving campaign record from database', PEAR_LOG_DEBUG);
                continue;
            }
            if (!isset($aResult[$aRow['campaignid']])) {
                $aResult[$aRow['campaignid']] = array(
                $idxRevenue => $aRow['revenue'],
                $idxRevenueType => $aRow['revenue_type'],
                $idxActivate => $aRow['activate_time'],
                $idxExpire => $aRow['expire_time'],
                $idxAds => array(),
                );
            }
            if (!isset($aResult[$aRow['campaignid']][$idxAds][$aRow['bannerid']])) {
                $aResult[$aRow['campaignid']][$idxAds][$aRow['bannerid']][$idxWeight] = $aRow['weight'];
                $aResult[$aRow['campaignid']][$idxAds][$aRow['bannerid']][$idxZones] = array();
            }
            $aResult[$aRow['campaignid']][$idxAds][$aRow['bannerid']][$idxZones][$aRow['zone_id']]
            = $aRow['zone_id'];
        }
        return $aResult;
    }

    /**
     * Get all zones forecasts by querying last hour's impressions for each zone
     * This function will look at the hour before the specified OI
     * to determine how much traffic to expected in the specified OI.
     *
     * @param string $intervalStart  Interval start date of OI to forecast
     * @param string $intervalEnd  Interval end date of OI to forecast
     * @return array  array( zoneId => forecastForThisZone, ... )
     */
    public function getZonesForecasts($intervalStart, $intervalEnd)
    {
        OA::debug('  - Selecting Zones forecasts for all managers for OI from '.$intervalStart.' to '.$intervalEnd, PEAR_LOG_INFO);

        $operationInterval = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'];
        $oneHourInterval = OA_Dal::quoteInterval(1, 'hour');

        $query = "SELECT
                      d.zone_id AS zone_id,
                      sum(impressions) AS impressions,
                      count(DISTINCT operation_interval_id) as count
                  FROM
                  {$this->_getTablename('data_intermediate_ad')} AS d
                  WHERE
                          d.operation_interval = '{$operationInterval}'
                      AND d.date_time < '{$intervalStart}'
                      AND d.date_time >= DATE_SUB('{$intervalStart}', $oneHourInterval)
                  GROUP BY d.zone_id
                  ORDER BY zone_id
                  ";
        $rc = $this->oDbh->query($query);
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            // we divide by count in the case where we picked up several OIs that last less than one hour
            $aResult[$aRow['zone_id']] = round($aRow['impressions'] / $aRow['count']);
        }
        return $aResult;
    }

    /**
     * Get all zones allocations. Returns the number of impressions which
     * were required by high priority campaigns in each of the zones.
     *
     * @param integer $agencyId  Agency ID
     * @return array  Array of allocations per each of the zone
     */
    public function getZonesAllocationsForEcpmRemnantByAgency($agencyId)
    {
        OA::debug('  - Selecting Zones allocations for remnant campaigns (impressions required in each zone) ', PEAR_LOG_INFO);
        $query = "SELECT
                      t.zone_id AS zone_id,
                      SUM(t.required_impressions) AS sum_required_impressions
                  FROM
                  {$this->_getTablename('affiliates')} AS a,
                  {$this->_getTablename('zones')} AS z,
                  {$this->_getTablename('campaigns')} AS c,
                  {$this->_getTablename('banners')} AS b,
                      tmp_ad_zone_impression AS t
                  WHERE
                      a.agencyid = {$agencyId}
                      AND z.affiliateid = a.affiliateid
                      AND z.zoneid = t.zone_id
                      AND t.to_be_delivered = 1
                      AND b.bannerid = t.ad_id
                      AND b.status = " . OA_ENTITY_STATUS_RUNNING . "
                      AND c.campaignid = b.campaignid
                      AND c.priority = ".DataObjects_Campaigns::PRIORITY_ECPM."
                      AND c.status = " . OA_ENTITY_STATUS_RUNNING . "
                  GROUP BY
                      t.zone_id";
        return $this->getZonesAllocationsByQuery($query);
    }

    /**
     * Get all zones allocations. Returns the number of impressions which
     * were required by high priority campaigns in each of the zones
     * limited by the campaigns priority. Get only allocations by the
     * campaigns with higher priority than the passed priority.
     *
     * @param integer $agencyId  Agency ID
     * @return array  Array of allocations per each of the zone
     */
    public function getZonesAllocationsByAgencyAndCampaignPriority($agencyId, $priority)
    {
        OA::debug('  - Selecting Zones allocations for high priority campaigns (impressions required in each zone) ', PEAR_LOG_INFO);
        $query = "SELECT
                      t.zone_id AS zone_id,
                      SUM(t.required_impressions) AS sum_required_impressions
                  FROM
                  {$this->_getTablename('affiliates')} AS a,
                  {$this->_getTablename('zones')} AS z,
                  {$this->_getTablename('campaigns')} AS c,
                  {$this->_getTablename('banners')} AS b,
                      tmp_ad_zone_impression AS t
                  WHERE
                      a.agencyid = {$agencyId}
                      AND z.affiliateid = a.affiliateid
                      AND z.zoneid = t.zone_id
                      AND t.to_be_delivered = 1
                      AND b.bannerid = t.ad_id
                      AND b.status = " . OA_ENTITY_STATUS_RUNNING . "
                      AND c.campaignid = b.campaignid
                      AND c.ecpm_enabled = 1
                      AND c.priority > {$priority}
                      AND c.status = " . OA_ENTITY_STATUS_RUNNING . "
                  GROUP BY
                      t.zone_id";
        return $this->getZonesAllocationsByQuery($query);
    }

    /**
     * Get all zones allocations by SQL query.
     *
     * @param string $query  SQL query
     * @return array  Array of allocations per each of the zone
     */
    public function getZonesAllocationsByQuery($query)
    {
        $rc = $this->oDbh->query($query);
        $aResult = array();
        if (PEAR::isError($rc)) {
            OA::debug('  - Error getting zone allocations from database', PEAR_LOG_DEBUG);
            return false;
        }
        while ($aRow = $rc->fetchRow()) {
            if (PEAR::isError($aRow)) {
                OA::debug('  - Error retreiving zone contract record from database', PEAR_LOG_DEBUG);
                continue;
            }
            $aResult[$aRow['zone_id']] = $aRow['sum_required_impressions'];
        }
        return $aResult;
    }

    /**
     * Return the timezone object that the campaign is suposed to be using
     *
     * @staticvar array $aCache
     * @param int $campaignId
     * @return Date_TimeZone
     */
    public function getTimezoneForCampaign($campaignId)
    {
        static $aCache;

        $doAgency = OA_Dal::factoryDO('agency');
        $doClients = OA_Dal::factoryDO('clients');
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignid = $campaignId;
        $doClients->joinAdd($doCampaigns);
        $doAgency->joinAdd($doClients);

        if ($doAgency->find()) {
            $doAgency->fetch();

            if (!isset($aCache[$doAgency->account_id])) {
                $aPrefs = OA_Preferences::loadAccountPreferences($doAgency->account_id, true);
                $oTz = new Date_TimeZone(empty($aPrefs['timezone']) ? 'UTC' : $aPrefs['timezone']);
                $aCache[$doAgency->account_id] = $oTz;
            } else {
                $oTz = $aCache[$doAgency->account_id];
            }
        } else {
            $oTz = new Date_TimeZone('UTC');
        }

        return $oTz;
    }

}
