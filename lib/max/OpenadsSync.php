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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once 'XML/RPC.php';

/**
 * A class to deal with the services provided by Openads Sync
 *
 * @package    Max
 * @subpackage OpenadsSync
 * @author     Matteo Beccati <matteo@beccati.com>
 */
class MAX_OpenadsSync
{
    var $conf;
    var $pref;
    var $oDbh;

    var $_openadsServer = array(
        'host'   => 'sync.openads.org',
        'script' => '/xmlrpc.php',
        'port'   => 80
    );

    /**
     * PHP5-style constructor
     *
     * @param array $conf array, if null reads the global variable
     * @param array $pref array, if null reads the global variable
     */
    function __construct($conf = null, $pref = null)
    {
        $this->conf = is_null($conf) ? $GLOBALS['_MAX']['CONF'] : $conf;
        $this->pref = is_null($pref) ? $GLOBALS['_MAX']['PREF'] : $pref;

        $this->oDbh = &OA_DB::singleton();
    }

    /**
     * PHP4-style constructor
     *
     * @param array $conf array, if null reads the global variable
     * @param array $pref array, if null reads the global variable
     */
    function MAX_OpenadsSync($conf = null, $pref = null)
    {
        $this->__construct($conf, $pref);
    }

    /**
     * Return phpAdsNew style config version parsing MAX_VERSION_READABLE
     *
     * the stability tag is converted to an int using the following table:
     *
     * 'alpha'  => 1
     * 'beta'   => 2
     * 'rc'     => 3
     * 'stable' => 4
     *
     * i.e.
     * v0.3.29-alpha becomes:
     * 0  *  100 +
     * 3  *   10 +
     * 29 /  100 +
     * 1  / 1000 =
     * ---------
     *    30.291
     */
    function getConfigVersion()
    {
        $a = array(
            ''       => 0,
            'alpha'  => 1,
            'beta'   => 2,
            'rc'     => 3,
            'stable' => 4
        );

        $v = preg_split('/[.-]/', substr(MAX_VERSION_READABLE, 1));
        $v = array_pad($v, 4, '');

        return $v[0] * 100 + $v[1] * 10 + $v[2] / 100 + $a[$v[3]] / 1000;
    }

    /**
     * Connect to Openads Sync to check for updates
     *
     * @param float Only check for updates newer than this value
     * @param bool Send software details
     * @return array Two items:
     *               Item 0 is the XML-RPC error code (special meanings: 0 - no error, 800 - No updates)
     *               Item 1 is either the error message (item 1 != 0), or an array containing update info
     */
    function checkForUpdates($already_seen = 0, $send_sw_data = true)
    {
        global $XML_RPC_erruser;

        // Create client object
        $client = new XML_RPC_Client($this->_openadsServer['script'],
            $this->_openadsServer['host'], $this->_openadsServer['port']);

        $params = array(
            new XML_RPC_Value('MMM-0.3', 'string'),
            new XML_RPC_Value($this->getConfigVersion(), 'string'),
            new XML_RPC_Value($already_seen, 'string'),
            new XML_RPC_Value('', 'string'),
            new XML_RPC_Value($this->pref['instance_id'], 'string')
        );

        if ($send_sw_data) {
            // Prepare software data
            $params[] = XML_RPC_Encode(array(
                'os_type'                    => php_uname('s'),
                'os_version'                => php_uname('r'),

                'webserver_type'            => isset($_SERVER['SERVER_SOFTWARE']) ? preg_replace('#^(.*?)/.*$#', '$1', $_SERVER['SERVER_SOFTWARE']) : '',
                'webserver_version'            => isset($_SERVER['SERVER_SOFTWARE']) ? preg_replace('#^.*?/(.*?)(?: .*)?$#', '$1', $_SERVER['SERVER_SOFTWARE']) : '',

                'db_type'                    => phpAds_dbmsname,
                'db_version'                => $this->oDbh->queryOne("SELECT VERSION()"),

                'php_version'                => phpversion(),
                'php_sapi'                    => ucfirst(php_sapi_name()),
                'php_extensions'            => get_loaded_extensions(),
                'php_register_globals'        => (bool)ini_get('register_globals'),
                'php_magic_quotes_gpc'        => (bool)ini_get('magic_quotes_gpc'),
                'php_safe_mode'                => (bool)ini_get('safe_mode'),
                'php_open_basedir'            => (bool)strlen(ini_get('open_basedir')),
                'php_upload_tmp_readable'    => (bool)is_readable(ini_get('upload_tmp_dir').DIRECTORY_SEPARATOR),

                'updates_cs_data_enabled'   => ($this->pref['updates_cs_data_enabled'] != 'f' && $this->pref['updates_cs_data_enabled']),
            ));
        }

        if ($this->pref['updates_cs_data_enabled'] != 'f' && $this->pref['updates_cs_data_enabled']) {
            $iLastUpdate = 0;
            if (!empty($this->pref['ad_cs_data_last_sent']) && $this->pref['ad_cs_data_last_sent'] != '0000-00-00') {
                $iLastUpdate = strtotime($this->pref['ad_cs_data_last_sent']);
            }

            // make sure there's only one report on clicks/impressions a day
            if ($send_sw_data && $iLastUpdate+86400 < time()){

                // get ratios for clicks and views
                // move start and end timestamp one hour back in the past so it's possible to fetch
                // clicks/views generated when update was running
                $aData = $this->_getSummaries($iLastUpdate-3600, time()-3600);

                // send community-size data only if there has been some data served from this installation
                if ($aData['ad_views_sum'] || $aData['ad_clicks_sum']){
                    $aHost = parse_url('http://'.$this->pref['webpath']['admin']);
                    $params[] = XML_RPC_Encode(array(
                        'ad_views_sum'                  => $aData['ad_views_sum'],
                        'ad_clicks_sum'                 => $aData['ad_clicks_sum'],
                        'seconds_since_previous_report' => $aData['seconds_since_previous_report'],
                        'client_host'                   => $aHost['host'],
                    ));
                }
            }
        }

        // Create XML-RPC request message
        $msg = new XML_RPC_Message("Openads.Sync", $params);

        // Send XML-RPC request message
        if($response = $client->send($msg, 10)) {
            // XML-RPC server found, now checking for errors
            if (!$response->faultCode()) {
                $ret = array(0, XML_RPC_Decode($response->value()));

                // Prepare cache
                $cache = $ret[1];
            } else {
                $ret = array($response->faultCode(), $response->faultString());

                // Prepare cache
                $cache = false;
            }

            // prepare update query
            $sUpdate = "
                UPDATE
                    ".$this->conf['table']['prefix'].$this->conf['table']['preference']."
                SET
                    updates_cache = '".addslashes(serialize($cache))."',
                    updates_timestamp = ".time()."
            ";

            if ($this->pref['updates_cs_data_enabled'] != 'f' && $this->pref['updates_cs_data_enabled']) {

                if ($send_sw_data && $iLastUpdate+86400 < time()) {
                    $sUpdate .= ",
                    ad_cs_data_last_sent = '".date('Y-m-d', time())."'
                    ";
                }

                // var $response is not needed from this point so we can reuse it
                // get community-stats
                $response = $client->send(new XML_RPC_Message('Openads.CommunityStats'),10);

                // if response contains no error store community-stats values locally
                if (!$response->faultCode()){
                    $aCommunityStats = XML_RPC_Decode($response->value());

                    if($aCommunityStats['day'] != $this->pref['ad_cs_data_last_received'] && ($aCommunityStats['ad_clicks_sum'] || $aCommunityStats['ad_views_sum'])) {

                        $sUpdate .= ",
                            ad_clicks_sum = ".(int)$aCommunityStats['ad_clicks_sum'].",
                            ad_views_sum = ".(int)$aCommunityStats['ad_views_sum'].",
                            ad_clicks_per_second = ".(float)$aCommunityStats['ad_clicks_per_second'].",
                            ad_views_per_second = ".(float)$aCommunityStats['ad_views_per_second'].",
                            ad_cs_data_last_received = '".$aCommunityStats['day']."'
                        ";

                    }
                }
            }

            $sUpdate .="
                WHERE
                    agencyid = 0
            ";

            $this->oDbh->exec($sUpdate);

            return $ret;
        }

        return array(-1, 'No response from the server');
    }

    /**
     * Private method for getting summaries/ratios about ads
     *
     * This method generates ratios about ad views/clicks and summarizes these
     * It generates ratios based on the interval period that's counted by subtracting
     * start and enddate so the outcome is given in "per seconds" basis
     *
     * @param int $iStartDate
     * @param int $iEndDate
     *
     * @access private
     *
     * @return array counted values in form of array('ad_clicks_per_second' => 'double', 'ad_views_per_second' => 'double', 'ad_clicks_sum' => 'integer', 'ad_views_sum' => 'integer');
     */
    function _getSummaries($iStartDate, $iEndDate){

        if($iStartDate <= 0){
            $res = $this->oDbh->query("SELECT MIN(day) as start_date FROM ".$this->conf['table']['prefix'].$this->conf['table']['data_summary_ad_hourly']);
            if (PEAR::isError($res)){
                return array();
            }

            $row = $res->fetchRow();
            if ($row['start_date']){
                $iStartDate = $row['start_date'];
            }
            else {
                return array();
            }
        }

        $sMysqlStartDay = date('Y-m-d', $iStartDate );
        $sMysqlEndDay = date('Y-m-d', $iEndDate );

        $sMysqlStartHour = date('H', $iStartDate );
        $sMysqlEndHour = date('H', $iEndDate );

        $aReturn = array();

        $res = $this->dbh->query("
            SELECT
                SUM(dsah.impressions) AS ad_views_sum,
                SUM(dsah.clicks) AS ad_clicks_sum
            FROM
                ".$this->conf['table']['prefix'].$this->conf['table']['data_summary_ad_hourly']." dsah
            WHERE
                ('".$sMysqlStartDay."'<'".$sMysqlEndDay."' " .
                    "AND (" .
                        "(dsah.day = '".$sMysqlStartDay."' AND dsah.hour >= ".$sMysqlStartHour.") " .
                        "OR " .
                        "(dsah.day =  '".$sMysqlEndDay."' AND dsah.hour <= ".$sMysqlEndHour.")  " .
                        "OR " .
                        "(dsah.day > '".$sMysqlStartDay."' AND dsah.day < '".$sMysqlEndDay."')" .
                    ")" .
                ") " .
                "OR " .
                "('".$sMysqlStartDay."'>='".$sMysqlEndDay."' " .
                    "AND (" .
                        "dsah.day='".$sMysqlStartDay."' AND dsah.hour >= ".$sMysqlStartHour." AND dsah.hour <= ".$sMysqlEndHour."" .
                    ")" .
                ")
        ");

        if(!PEAR::isError($res)){

            $this->dbh->fetchInto($res, $row);
            $iTimeDiff = $iEndDate-$iStartDate;

            $aReturn['ad_clicks_sum']        = $row['ad_clicks_sum'];
            $aReturn['ad_views_sum']         = $row['ad_views_sum'];
            $aReturn['seconds_since_previous_report']   = $iTimeDiff;

        }

        return $aReturn;
    }
}

?>