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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/max/Dal/Common.php';

require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/OA/Preferences.php';

/**
 * This class rolls up old stats - e.g. Hourly stats older than X are rolled up to daily stats
 *
 * @static
 * @package    OpenXMaintenance
 * @subpackage RollupStats
 */
class OA_Maintenance_RollupStats extends MAX_Dal_Common
{
    /**
     * The class constructor method.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function run($oDate)
    {
        $this->_rollUpHourlyStatsToDaily($oDate);
        $this->_rollUpDailyStatsToMonthly($oDate);
    }

    /**
     * This function recreates the data_summary_ad_hourly table rolls-up hourly stats to daily totals
     * The roll-up is done in accordance to the user's (currently) selected timezone
     *
     * @param PEAR_Date $oDate The date before which hourly stats should be rolled up
     */
    public function _rollUpHourlyStatsToDaily($oDate)
    {
        $sDate = $oDate->format('%Y-%m-%d 00:00:00');
        $updated = OA::getNowUTC('Y-m-d h:i:s');

        OA::debug("Beginning stats rollup for pre-{$sDate}", PEAR_LOG_INFO);

        // First create a temporary table with ad_id/offset pairs, this can then be joined in a (compled) INSERT INTO ... SELECT FROM statement
        $aTimezones = OX_Admin_Timezones::availableTimezones(false);
        $aAdminPreferences = OA_Preferences::loadAdminAccountPreferences(true);
        $aAdminTzOffset = $this->_getSqlOffsetFromString($aTimezones[$aAdminPreferences['timezone']]);

        // CREATE a timezone string => offset table (since the format we use in PHP is incompatible with the format used by MySQL)
        $this->oDbh->exec("DROP TABLE IF EXISTS {$this->prefix}tmp_tz_offset");
        $this->oDbh->exec("CREATE TABLE `{$this->prefix}tmp_tz_offset`
                               (`timezone` varchar(32) NOT NULL PRIMARY KEY, `offset` char(6) NOT NULL DEFAULT '+00:00') ENGINE={$this->conf['table']['type']}");
        foreach ($aTimezones as $tzString => $tzData) {
            $tzData = $this->_getSqlOffsetFromString($tzData);
            $this->oDbh->exec("INSERT INTO {$this->prefix}tmp_tz_offset (timezone, offset) VALUES('{$tzString}', '{$tzData}')");
        }
        OA::debug("Created timezone/offset mapping table", PEAR_LOG_DEBUG);

        // CREATE an ad_id => offset table
        $this->oDbh->exec("DROP TABLE IF EXISTS {$this->prefix}tmp_ad_offset");
        $this->oDbh->exec("CREATE TABLE `{$this->prefix}tmp_ad_offset`
                               (`ad_id` int(11) NOT NULL PRIMARY KEY, `offset` char(6) NOT NULL DEFAULT '+00:00') ENGINE={$this->conf['table']['type']}");

        $this->oDbh->exec("INSERT INTO {$this->prefix}tmp_ad_offset SELECT bannerid, '{$aAdminTzOffset}' FROM {$this->prefix}banners AS b");
        $this->oDbh->exec("UPDATE
                            {$this->prefix}tmp_ad_offset AS ao,
                            {$this->prefix}banners AS b,
                            {$this->prefix}campaigns AS c,
                            {$this->prefix}clients AS cl,
                            {$this->prefix}agency AS ag,
                            {$this->prefix}account_preference_assoc AS apa,
                            {$this->prefix}preferences AS p,
                            {$this->prefix}tmp_tz_offset AS tzo
                          SET ao.offset = tzo.offset
                          WHERE
                              p.preference_name = 'timezone'
                            AND apa.preference_id = p.preference_id
                            AND apa.account_id = ag.account_id
                            AND cl.agencyid=ag.agencyid
                            AND ao.ad_id=b.bannerid
                            AND c.campaignid=b.campaignid
                            AND cl.clientid=c.clientid
                            AND ag.agencyid=cl.agencyid
                            AND apa.value = tzo.timezone;
                        ");
        OA::debug("Created ad/offset mapping table", PEAR_LOG_DEBUG);

        // So, now we have a table tmp_ad_offset which contains every banner id, and the offset of the account it belongs to.
        // We can use this to do a complex GROUP BY to collapse data down into the user's timzone's midday
        $this->oDbh->exec("DROP TABLE IF EXISTS {$this->prefix}data_summary_ad_hourly_rolledup");
        $this->oDbh->exec("DROP TABLE IF EXISTS {$this->prefix}data_summary_ad_hourly_backup");

        // Create a new stats table, we do this because trying to delete a bunch of records from the existing table would just fragment the index
        $this->oDbh->exec("CREATE TABLE {$this->prefix}data_summary_ad_hourly_rolledup LIKE {$this->prefix}data_summary_ad_hourly;");

        // Copy stats over from the existing table to the new table, rolling up according to each ad's offset
        OA::debug("Beginning rolled-up stats copy...", PEAR_LOG_DEBUG);
        $this->oDbh->exec("INSERT INTO {$this->prefix}data_summary_ad_hourly_rolledup (
                               date_time, ad_id, creative_id, zone_id, requests, impressions, clicks, conversions,
                               total_basket_value, total_num_items, total_revenue, total_cost, total_techcost, updated )
                           SELECT
                               CONVERT_TZ(DATE_FORMAT(CONVERT_TZ(dsah.date_time, '+00:00', ao.offset), '%Y-%m-%d 12:00:00'), ao.offset, '+00:00') AS tz_date_time,
                               dsah.ad_id, dsah.creative_id, dsah.zone_id, SUM(dsah.requests), SUM(dsah.impressions), SUM(dsah.clicks), SUM(dsah.conversions),
                               SUM(dsah.total_basket_value), SUM(dsah.total_num_items), SUM(dsah.total_revenue), SUM(dsah.total_cost), SUM(dsah.total_techcost), '{$updated}'
                           FROM
                               {$this->prefix}data_summary_ad_hourly AS dsah,
                               {$this->prefix}tmp_ad_offset AS ao
                           WHERE
                               ao.ad_id=dsah.ad_id
                             AND CONVERT_TZ(dsah.date_time, '+00:00', ao.offset) < '{$sDate}'
                           GROUP BY
                               tz_date_time, ad_id, creative_id, zone_id;
                           ");
        OA::debug("Completed rolled-up stats copy...", PEAR_LOG_DEBUG);

        // Copy any un-rolled up stats records over into the new table
        OA::debug("Beginning *non* rolled-up stats copy...", PEAR_LOG_DEBUG);
        $this->oDbh->exec("INSERT INTO {$this->prefix}data_summary_ad_hourly_rolledup (
                               date_time, ad_id, creative_id, zone_id, requests, impressions, clicks, conversions,
                               total_basket_value,  total_num_items,  total_revenue, total_cost, total_techcost, updated)
                           SELECT
                               dsah.date_time AS tz_date_time, dsah.ad_id, dsah.creative_id, dsah.zone_id, dsah.requests, dsah.impressions, dsah.clicks, dsah.conversions,
                               dsah.total_basket_value, dsah.total_num_items, dsah.total_revenue, dsah.total_cost, dsah.total_techcost, '{$updated}'
                           FROM
                               {$this->prefix}data_summary_ad_hourly AS dsah,
                               {$this->prefix}tmp_ad_offset AS ao
                           WHERE
                               ao.ad_id=dsah.ad_id
                             AND CONVERT_TZ(dsah.date_time, '+00:00', ao.offset) >= '{$sDate}'
                         ");
        OA::debug("Completed *non* rolled-up stats copy...", PEAR_LOG_DEBUG);

        // Swap the old table with the new
        $this->oDbh->exec("RENAME TABLE {$this->prefix}data_summary_ad_hourly TO {$this->prefix}data_summary_ad_hourly_backup");
        $this->oDbh->exec("RENAME TABLE {$this->prefix}data_summary_ad_hourly_rolledup TO {$this->prefix}data_summary_ad_hourly");
        OA::debug("Swapped new table for old...", PEAR_LOG_DEBUG);

        // Cleanup
        $this->oDbh->exec("DROP TABLE {$this->prefix}tmp_ad_offset;");
        $this->oDbh->exec("DROP TABLE {$this->prefix}tmp_tz_offset;");
        OA::debug("Woo hoo stats rolled up for pre-{$sDate}", PEAR_LOG_INFO);
    }

    public function _rollUpDailyStatsToMonthly($oDate)
    {
        // Not implemented
        return true;
    }
    public function _getSqlOffsetFromString($string)
    {
        return substr($string, 4, 3) . ':' . substr($string, 7, 2);
    }
}
