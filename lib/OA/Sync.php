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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
require_once MAX_PATH . '/lib/OA/Central.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class to deal with the services provided by OpenX Sync
 *
 * @package    OpenX
 * @author     Matteo Beccati <matteo@beccati.com>
 */
class OA_Sync
{
    var $aConf;
    var $aPref;
    var $_conf;

    /**
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    /**
     * Constructor
     *
     * @param array $conf array, if null reads the global variable
     * @param array $pref array, if null reads the global variable
     */
    function OA_Sync($conf = null, $pref = null)
    {
        $this->aConf = is_null($conf) ? $GLOBALS['_MAX']['CONF'] : $conf;
        $this->aPref = is_null($pref) ? $GLOBALS['_MAX']['PREF'] : $pref;

        $this->_conf = $this->aConf['oacSync'];

        $this->oDbh =& OA_DB::singleton();
    }


    /**
     * Returns phpAdsNew style config version.
     *
     * The OpenX version "number" is converted to an int using the following table:
     *
     * 'beta-rc' => 0.1
     * 'beta'    => 0.2
     * 'rc'      => 0.3
     * ''        => 0.4
     *
     * i.e.
     * v0.3.29-beta-rc10 becomes:
     *  0   *   1000 +
     *  3   *    100 +
     * 29   *      1 +    // Cannot exceed 100 patch releases!
     *  0.1          +
     * 10   /   1000 =
     * -------------
     *        3293.1
     */
    function getConfigVersion($version)
    {
        $a = array(
            'dev'     => -0.001,
            'beta-rc' => 0.1,
            'beta'    => 0.2,
            'rc'      => 0.3,
            'stable'  => 0.4
        );

        $version = OA::stripVersion($version, array('dev', 'stable'));

        if (preg_match('/^v/', $version)) {
            $v = preg_split('/[.-]/', substr($version, 1));
        } else {
            $v = preg_split('/[.-]/', $version);
        }

        if (count($v) < 3) {
            return false;
        }

        // Prepare value from the first 3 items
        $returnValue = $v[0] * 1000 + $v[1] * 100 + $v[2];

        // How many items were there?
        if (count($v) == 5) {
            // Check that it is a beta-rc release
            if ((!$v[3] == 'beta') || (!preg_match('/^rc(\d+)/', $v[4], $aMatches))) {
                return false;
            }
            // Add the beta-rc
            $returnValue += $a['beta-rc'] + $aMatches[1] / 1000;
            return $returnValue;
        } else if (count($v) == 4) {
            // Check that it is a tag or rc numer
            if (isset($a[$v[3]])) {
                // Add the beta
                $returnValue += $a[$v[3]];
                return $returnValue;
            } else if (preg_match('/^rc(\d+)/', $v[3], $aMatches)) {
                // Add the rc
                $returnValue += $a['rc'] + $aMatches[1] / 1000;
                return $returnValue;
            }
            return false;
        }
        // Stable release
        $returnValue += $a['stable'];
        return $returnValue;
    }

    /**
     * Connect to OpenX Sync to check for updates
     *
     * @param float $already_seen Only check for updates newer than this value.
     * @return array An array of two items:
     *
     *               Item 0 is the XML-RPC error code. Meanings:
     *                      -2  => The admin user has disabled update checking
     *                      -1  => No response from the server
     *                  0 - 799 => XML-RPC library error codes
     *                       0  => No error
     *                     800  => No updates
     *                     801+ => Error codes from the remote XML-RPC server
     *
     *               Item 1 is either the error message (item 1 != 0), or an array containing update info
     */
    function checkForUpdates($already_seen = 0)
    {
        global $XML_RPC_erruser;

        if (!$this->aConf['sync']['checkForUpdates']) {
            // Checking for updates has been disabled by the admin user,
            // so do not communicate with the OpenX server that provides
            // the details of what upgrades are available - just return
            // an 800 "error"
            $aReturn = array(-2, 'Check for updates has been disabled by the OpenX administrator.');
            return $aReturn;
        }

        // Should this server's technology stack be shared with OpenX?
        $shareTechStack = false;
        if ($this->aConf['sync']['shareStack']) {
            $shareTechStack = true;
        }

        // Should this server's aggregate impression and click statistcs
        // be shared with OpenX?
        $shareStats = false;
        if ($this->aConf['sync']['shareData']) {
            $shareStats = true;
        }

        // Create the XML-RPC client object
        $client = OA_Central::getXmlRpcClient($this->_conf);

        // Prepare the parameters required for the XML-RPC call to
        // obtain if an update is available for this OpenX installation
        $params = array(
            new XML_RPC_Value(MAX_PRODUCT_NAME, 'string'),
            new XML_RPC_Value($this->getConfigVersion(OA_Dal_ApplicationVariables::get('oa_version')), 'string'),
            new XML_RPC_Value($already_seen, 'string'),
            new XML_RPC_Value('', 'string'),
            new XML_RPC_Value(OA_Dal_ApplicationVariables::get('platform_hash'), 'string')
        );

        // Has the OpenX admin user kindly agreed to share the technology
        // stack that OpenX is running on, so that OpenX can monitor what
        // technology stacks the community users, to help with supporting
        // OpenX?
        $aTechStack = array(
            'data' => false
        );
        if ($shareTechStack) {
            // Thanks, OpenX admin user! You're a star! Prepare the
            // technology stack data and add it to the XML-RPC call
            if ($this->oDbh->dbsyntax == 'mysql') {
                $dbms = 'MySQL';
            } else if ($this->oDbh->dbsyntax == 'pgsql') {
                $dbms = 'PostgreSQL';
            } else {
                $dbms = 'UnknownSQL';
            }
            $aTechStack = array(
                'os_type'                   => php_uname('s'),
                'os_version'                => php_uname('r'),

                'webserver_type'            => isset($_SERVER['SERVER_SOFTWARE']) ? preg_replace('#^(.*?)/.*$#', '$1', $_SERVER['SERVER_SOFTWARE']) : '',
                'webserver_version'         => isset($_SERVER['SERVER_SOFTWARE']) ? preg_replace('#^.*?/(.*?)(?: .*)?$#', '$1', $_SERVER['SERVER_SOFTWARE']) : '',

                'db_type'                   => $dbms,
                'db_version'                => $this->oDbh->queryOne("SELECT VERSION()"),

                'php_version'               => phpversion(),
                'php_sapi'                  => ucfirst(php_sapi_name()),
                'php_extensions'            => get_loaded_extensions(),
                'php_register_globals'      => (bool)ini_get('register_globals'),
                'php_magic_quotes_gpc'      => (bool)ini_get('magic_quotes_gpc'),
                'php_safe_mode'             => (bool)ini_get('safe_mode'),
                'php_open_basedir'          => (bool)strlen(ini_get('open_basedir')),
                'php_upload_tmp_readable'   => (bool)is_readable(ini_get('upload_tmp_dir').DIRECTORY_SEPARATOR)
            );
        }
        $params[] = XML_RPC_Encode($aTechStack);

        // Has the OpenX admin user kindly agreed to share their
        // aggregate impression and click statistics to help
        // OpenX monitor what sizes of OpenX installations exist
        // (to ensure OpenX scales to appropriate sizes), and also
        // so that the total community size can be shown in the
        // Dashboard?
        $aStats = array();
        if ($shareStats) {
            // Thanks, OpenX admin user! You're a star! Prepare the
            // aggregate impression and click statistics data and
            // add it to the XML-RPC call
            foreach ($this->buildStats() as $k => $v) {
                $aStats[$k] = XML_RPC_encode($v);
            }
        }
        $params[] = new XML_RPC_Value($aStats, 'struct');

        // Add the OpenX package Origin ID, if appropriate
        $originID = '';
        $originFile = MAX_PATH . '/etc/origin.txt';
        if (file_exists($originFile) && is_readable($originFile)) {
            $rOriginFile = @fopen($originFile, 'r');
            if ($rOriginFile !== false) {
                $originID = fread($rOriginFile, 32);
                fclose($rOriginFile);
            }
            if ($originID === false) {
                $originID = '';
            }
        }
        $params[] = new XML_RPC_Value($originID, 'string');

        // Add the registered email address
        $params[] = new XML_RPC_Value(OA_Dal_ApplicationVariables::get('sync_registered_email'), 'string');
        
        // Create the XML-RPC request message
        $msg = new XML_RPC_Message("OpenX.Sync", $params);

        // Send the XML-RPC request message
        if ($response = $client->send($msg, 10)) {
            // XML-RPC server found, now checking for errors
            if (!$response->faultCode()) {
                // No fault! Woo! Get the response and return it!
                $aReturn = array(0, XML_RPC_Decode($response->value()));
                // Prepare cache
                $cache = $aReturn[1];
                // Update last run
                OA_Dal_ApplicationVariables::set('sync_last_run', date('Y-m-d H:i:s'));
            } else {
                // Boo! An error! (Well, maybe - it it's 800, yay!)
                $aReturn = array($response->faultCode(), $response->faultString());
                // Prepare cache
                $cache = false;
                // Update last run
                if ($response->faultCode() == 800) {
                    OA_Dal_ApplicationVariables::set('sync_last_run', date('Y-m-d H:i:s'));
                }
            }
            OA_Dal_ApplicationVariables::set('sync_cache', serialize($cache));
            OA_Dal_ApplicationVariables::set('sync_timestamp', time());
            return $aReturn;
        }

        $aReturn = array(-1, 'No response from the remote XML-RPC server.');
        return $aReturn;
    }

    /**
     * Build global statistics array to be sent through Sync
     *
     * @return array
     */
    function buildStats()
    {
        $lastRun = OA_Dal_ApplicationVariables::get('sync_last_run');

        if ($lastRun) {
            $oStart = new Date($lastRun);
        } else {
            $oStart = new Date();
            $oStart->subtractSpan(new Date_Span('1-0-0-0'));
        }
        $oStart->setMinute(0);
        $oStart->setSecond(0);

        $oEnd = new Date();
        $oEnd->setMinute(0);
        $oEnd->setSecond(0);

        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->selectAdd();
        $doDsah->selectAdd('date_time');
        $doDsah->selectAdd('SUM(impressions) AS total_impressions');
        $doDsah->selectAdd('SUM(clicks) AS total_clicks');
        $doDsah->whereAdd("date_time >= ".$this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S')));
        $doDsah->whereAdd("date_time < ".$this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S')));
        $doDsah->groupBy('date_time');
        $doDsah->orderBy('date_time');
        $doDsah->find();

        $aStats = array();

        while ($doDsah->fetch()) {
            $row = $doDsah->toArray();
            $aStats[$row['date_time']] = array(
                'impressions' => $row['total_impressions'],
                'clicks'      => $row['total_clicks']
            );
        }

        return $aStats;
    }
}

?>
