<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Table/Core.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php'; // Needed for the constants at the top of the file...
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';
require_once MAX_PATH . '/lib/max/Plugin.php';

/**
 * A class to perform upgrades from phpAdsNew 2.0 or greater, and from previous
 * version of Max.
 *
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Admin_Upgrade
{
    var $conf;
    var $dbh;
    var $tables;
    var $upgradeFrom;
    var $upgradeTo;
    var $errors;

    /**
     * An array to store delivery limitation plugins objects, so that it is
     * not necessary to create objects of the same type over and over, every
     * time one is needed.
     *
     * @var array
     */
    var $aPlugins;

    /**
     * The class constructor method.
     */
    function MAX_Admin_Upgrade($prefix = null)
    {
        $this->conf = $GLOBALS['_MAX']['CONF'];
        if (!is_null($prefix)) {
            $this->conf['table']['prefix'] = $prefix;
        }
        // Set time limit and ignore user abort, as upgrade can take some itme
        if (!ini_get('safe_mode')) {
            @set_time_limit(600);
            @ignore_user_abort(true);
        }
        $this->dbh =& MAX_DB::singleton();
        $this->tables = MAX_Table_Core::singleton($this->conf['database']['type']);
        $this->aPlugins = array();
    }

    /**
     * A method to determine if an older version of Max (or phpAdsNew)
     * is currently installed.
     *
     * @param string $version The version of Max currently being installed.
     * @return boolean True if a previous version of Max is installed,
     *                 false otherwise.
     */
    function previousVersionExists($version)
    {
        $this->upgradeTo = $version;
        // Does the application variables table exists? Inore any errors
        // while executing the SQL to find the version that is installed
        PEAR::pushErrorHandling(null);
        $data = $this->dbh->tableInfo($this->conf['table']['prefix'].'application_variable');
        PEAR::popErrorHandling();
        if (PEAR::isError($data)) {
            // Could not find the application variables table,
            // so definately need to upgrade
            return true;
        } else {
            // What is the current version of Max that is installed?
            $query = "
                SELECT
                    value AS max_version
                FROM
                    {$this->conf['table']['prefix']}application_variable
                WHERE
                    name = 'max_version'
                ";
            $row = $this->dbh->getRow($query);
            if (!PEAR::isError($row)) {
                $this->upgradeFrom = $row['max_version'];
                return $this->_compareVersions($this->upgradeTo, $this->upgradeFrom);
            }
        }
        // Versions were the same, or less, or there was an error.
        // Don't upgrade.
        return false;
    }

    /**
     * A method to perform the necessary upgrade steps to update Max
     * to the necessary database format.
     *
     * @return array Array of errors encountered during upgrade
     */
    function upgradeDatabase()
    {
        $this->errors = array();
        // Is the upgrageFrom variable defined?
        if (isset($this->upgradeFrom)) {
            // We are upgrading from Max after v0.1.16-beta,
            // so just do the required upgrade actions
            if ($this->_compareVersions('v0.2.0-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.2.0-alpha
                $this->_upgradeToTwoZeroAlpha();
            }
            if ($this->_compareVersions('v0.2.1-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.2.1-alpha
                $this->_upgradeToTwoOneAlpha();
            }
            if ($this->_compareVersions('v0.2.3-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.2.3-alpha
                $this->_upgradeToTwoThreeAlpha();
            }
            if ($this->_compareVersions('v0.2.4-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.2.4-alpha
                $this->_upgradeToTwoFourAlpha();
            }
            if ($this->_compareVersions('v0.3.00-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.00-alpha
                $this->_upgradeToThreeZeroAlpha();
            }
            if ($this->_compareVersions('v0.3.02-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.02-alpha
                $this->_upgradeToThreeTwoAlpha();
            }
            if ($this->_compareVersions('v0.3.04-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.04-alpha
                $this->_upgradeToThreeFourAlpha();
            }
            if ($this->_compareVersions('v0.3.05-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.05-alpha
                $this->_upgradeToThreeFiveAlpha();
            }
            if ($this->_compareVersions('v0.3.09-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.09-alpha
                $this->_upgradeToThreeNineAlpha();
            }
            if ($this->_compareVersions('v0.3.10-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.10-alpha
                $this->_upgradeToThreeTenAlpha();
            }
            if ($this->_compareVersions('v0.3.11-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.11-alpha
                $this->_upgradeToThreeElevenAlpha();
            }
            if ($this->_compareVersions('v0.3.13-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.13-alpha
                $this->_upgradeToThreeThirteenAlpha();
            }
            if ($this->_compareVersions('v0.3.15-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.15-alpha
                $this->_upgradeToThreeFifteenAlpha();
            }
            if ($this->_compareVersions('v0.3.16-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.16-alpha
                $this->_upgradeToThreeSixteenAlpha();
            }
            if ($this->_compareVersions('v0.3.17-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.17-alpha
                $this->_upgradeToThreeSeventeenAlpha();
            }
            if ($this->_compareVersions('v0.3.19-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.19-alpha
                $this->_upgradeToThreeNineteenAlpha();
            }
            if ($this->_compareVersions('v0.3.21-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.21-alpha
                $this->_upgradeToThreeTwentyOneAlpha();
            }
            if ($this->_compareVersions('v0.3.22-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.22-alpha
                $this->_upgradeToThreeTwentyTwoAlpha();
            }
            if ($this->_compareVersions('v0.3.23-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.23-alpha
                $this->_upgradeToThreeTwentyThreeAlpha();
            }
            if ($this->_compareVersions('v0.3.24-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.24-alpha
                $this->_upgradeToThreeTwentyFourAlpha();
            }
            if ($this->_compareVersions('v0.3.25-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.25-alpha
                $this->_upgradeToThreeTwentyFiveAlpha();
            }
            if ($this->_compareVersions('v0.3.26-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.26-alpha
                $this->_upgradeToThreeTwentySixAlpha();
            }
            if ($this->_compareVersions('v0.3.27-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.27-alpha
                $this->_upgradeToThreeTwentySevenAlpha();
            }
            if ($this->_compareVersions('v0.3.28-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.28-alpha
                $this->_upgradeToThreeTwentyEightAlpha();
            }
            if ($this->_compareVersions('v0.3.29-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.29-alpha
                $this->_upgradeToThreeTwentyNineAlpha();
            }
            if ($this->_compareVersions('v0.3.30-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.30-alpha
                $this->_upgradeToThreeThirtyAlpha();
            }
            if ($this->_compareVersions('v0.3.31-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.31-alpha
                $this->_upgradeToThreeThirtyOneAlpha();
            }
            if ($this->_compareVersions('v0.3.32-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.32-alpha
                $this->_upgradeToThreeThirtyTwoAlpha();
            }
        } else {
            // Perfom *all* possible upgrade actions, in order
            $this->_upgradeEarly();                   // Upgrade to v0.1.16-beta
            $this->_upgradeToTwoZeroAlpha();          // Upgrade to v0.2.0-alpha
            $this->_upgradeToTwoOneAlpha();           // Upgrade to v0.2.1-alpha
            $this->_upgradeToTwoThreeAlpha();         // Upgrade to v0.2.3-alpha
            $this->_upgradeToTwoFourAlpha();          // Upgrade to v0.2.4-alpha
            $this->_upgradeToThreeZeroAlpha();        // Upgrade to v0.3.00-alpha
            $this->_upgradeToThreeTwoAlpha();         // Upgrade to v0.3.02-alpha
            $this->_upgradeToThreeFourAlpha();        // Upgrade to v0.3.04-alpha
            $this->_upgradeToThreeFiveAlpha();        // Upgrade to v0.3.05-alpha
            $this->_upgradeToThreeNineAlpha();        // Upgrade to v0.3.09-alpha
            $this->_upgradeToThreeTenAlpha();         // Upgrade to v0.3.10-alpha
            $this->_upgradeToThreeElevenAlpha();      // Upgrade to v0.3.11-alpha
            $this->_upgradeToThreeThirteenAlpha();    // Upgrade to v0.3.13-alpha
            $this->_upgradeToThreeFifteenAlpha();     // Upgrade to v0.3.15-alpha
            $this->_upgradeToThreeSixteenAlpha();     // Upgrade to v0.3.16-alpha
            $this->_upgradeToThreeSeventeenAlpha();   // Upgrade to v0.3.17-alpha
            $this->_upgradeToThreeNineteenAlpha();    // Upgrade to v0.3.19-alpha
            $this->_upgradeToThreeTwentyOneAlpha();   // Upgrade to v0.3.21-alpha
            $this->_upgradeToThreeTwentyTwoAlpha();   // Upgrade to v0.3.22-alpha
            $this->_upgradeToThreeTwentyThreeAlpha(); // Upgrade to v0.3.23-alpha
            $this->_upgradeToThreeTwentyFourAlpha();  // Upgrade to v0.3.24-alpha
            $this->_upgradeToThreeTwentyFiveAlpha();  // Upgrade to v0.3.25-alpha
            $this->_upgradeToThreeTwentySixAlpha();   // Upgrade to v0.3.26-alpha
            $this->_upgradeToThreeTwentySevenAlpha(); // Upgrade to v0.3.27-alpha
            $this->_upgradeToThreeTwentyEightAlpha(); // Upgrade to v0.3.28-alpha
            $this->_upgradeToThreeTwentyNineAlpha();  // Upgrade to v0.3.29-alpha
            $this->_upgradeToThreeThirtyAlpha();      // Upgrade to v0.3.30-alpha
            $this->_upgradeToThreeThirtyOneAlpha();   // Upgrade to v0.3.31-alpha
            $this->_upgradeToThreeThirtyTwoAlpha();   // Upgrade to v0.3.32-alpha
        }
        if (count($this->errors) == 0) {
            // Always upgrade the installed version number
            $this->_upgradeInstalledVersion();
        }
        return $this->errors;
    }

    /**
     * A private method for comparing version numbers.
     *
     * @access private
     * @param string $first The first version number.
     * @param string $second The second version number.
     * @return boolean True if the first version number is greater than the second,
     *                 false otherwise.
     */
    function _compareVersions($first, $second)
    {
        if ((!isset($first)) || (!isset($second))) {
            return false;
        }
        // Obtain the parts of the verison numbers
        $matches = array();
        if (preg_match('/(\d+)\.(\d+)\.(\d+)(?:-([a-z]+))?/', $first, $matches)) {
            $firstMajor = $matches[1];
            $firstMinor = $matches[2];
            $firstPatch = $matches[3];
            $firstType  = $matches[4];
        }
        if (preg_match('/(\d+)\.(\d+)\.(\d+)(?:-([a-z]+))?/', $second, $matches)) {
            $secondMajor = $matches[1];
            $secondMinor = $matches[2];
            $secondPatch = $matches[3];
            $secondType  = $matches[4];
        }
        // Compare the major versions
        if (isset($firstMajor) && isset($secondMajor) && ($firstMajor > $secondMajor)) {
            return true;
        }
        // Compare the minor versions
        if (isset($firstMajor) && isset($secondMajor) && ($firstMajor == $secondMajor)) {
            if (isset($firstMinor) && isset($secondMinor) && ($firstMinor > $secondMinor)) {
                return true;
            }
        }
        // Compare the patch levels
        if (isset($firstMajor) && isset($secondMajor) && ($firstMajor == $secondMajor)) {
            if (isset($firstMinor) && isset($secondMinor) && ($firstMinor == $secondMinor)) {
                if (isset($firstPatch) && isset($secondPatch) && ($firstPatch > $secondPatch)) {
                    return true;
                }
            }
        }
        // Compare the release types
        if (isset($firstMajor) && isset($secondMajor) && ($firstMajor == $secondMajor)) {
            if (isset($firstMinor) && isset($secondMinor) && ($firstMinor == $secondMinor)) {
                if (isset($firstPatch) && isset($secondPatch) && ($firstPatch == $secondPatch)) {
                    if (isset($firstType) && isset($secondType)) {
                        if (($secondType == 'alpha') && ($firstType != 'alpha')) {
                            return true;
                        } elseif (($secondType == 'beta') && (($firstType != 'alpha') || ($firstType != 'beta'))) {
                            return true;
                        } elseif (($secondType == 'rc') && ($firstType == 'stable')) {
                            return true;
                        }
                    }
                }
            }
        }
        // Version was the same, less
        return false;
    }

    /**
     * A method for seting (not updating) the (initial) version number
     *
     * @return boolean True if the version was set correctly, false otherwise.
     */
    function setInstalledVersion()
    {
        $query = "INSERT INTO {$this->conf['table']['prefix']}application_variable (name, value) VALUES ('max_version', '" . MAX_VERSION_READABLE . "')";
        if (PEAR::isError($this->dbh->query($query))) {
            return false;
        }
        return true;
    }

    /**
     * A private method for updating the version number
     *
     * @access private
     */
    function _upgradeInstalledVersion()
    {
        $query = "UPDATE {$this->conf['table']['prefix']}application_variable SET value = '{$this->upgradeTo}' WHERE name = 'max_version'";
        $this->_runQuery($query);
    }

    /**
     * A private method to upgrade the database from the v0.3.31-alpha
     * format to the v0.3.32-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeThirtyTwoAlpha()
    {
        // Add new fields for storing connection channel_ids
        $cols = array(
            'data_raw_ad_request'       => array('column'=>'channel_ids','after'=>'channel'),
            'data_raw_ad_impression'    => array('column'=>'channel_ids','after'=>'channel'),
            'data_raw_ad_click'         => array('column'=>'channel_ids','after'=>'channel'),
            'data_raw_tracker_click'    => array('column'=>'channel_ids','after'=>'channel'),
            'data_raw_tracker_impression'  => array('column'=>'channel_ids','after'=>'channel'),
            'data_intermediate_ad_connection' => array('column'=>'connection_channel_ids','after'=>'connection_channel'),
            'data_intermediate_ad_connection' => array('column'=>'tracker_channel_ids','after'=>'connection_channel'),
        );
        $queries = array();
        foreach ($cols as $k => $v) {
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}{$k} ADD COLUMN {$v}['column'] VARCHAR(64) AFTER {$v}['after']";
        }
        $this->_runQueries($queries);

        // Add extra index to the data_summary_zone_impression_history table
        $query = "CREATE INDEX data_summary_zone_impression_history_zone_id ON {$this->conf['table']['prefix']}data_summary_zone_impression_history (zone_id)";
        $this->_runQuery($query);
    }

     /** A private method to upgrade the database from the v0.3.30-alpha
     * format to the v0.3.31-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeThirtyOneAlpha()
    {
        // Create daily channel summary table required for channel forecasting
        $this->tables->createTable('data_summary_channel_daily');

        // Drop old channel summary table
        $query = "DROP TABLE IF EXISTS {$this->conf['table']['prefix']}data_summary_channel_hourly";
        $this->_runQuery($query);

        // Add technology_cost & technology_cost_type to zones table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD technology_cost DECIMAL(10,4) AFTER cost_variable_id";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD technology_cost_type INT(11) AFTER technology_cost";
        $this->_runQueries($queries);

        // Add total_techcost to data_sum_ad_hourly
        $query = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_hourly ADD total_techcost  DECIMAL(10,4) AFTER total_cost";
        $this->_runQuery($query);

        // Add Openads Sync support
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD instance_id VARCHAR(64)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference MODIFY updates_last_seen decimal(7,3)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD updates_cache TEXT AFTER updates_frequency";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD updates_enabled enum('t','f') DEFAULT 't' AFTER updates_frequency";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference DROP updates_frequency";
        $this->_runQueries($queries);

        // Update preference table with new GUI vars from technology_cost
        $cols = array(
            'gui_column_technology_cost'            => true,
            'gui_column_income'                     => true,
            'gui_column_income_margin'              => true,
            'gui_column_profit'                     => true,
            'gui_column_margin'                     => true,
            'gui_column_erpm'                       => true,
            'gui_column_erpc'                       => true,
            'gui_column_erps'                       => true,
            'gui_column_eipm'                       => true,
            'gui_column_eipc'                       => true,
            'gui_column_eips'                       => true,
            'gui_column_ecpm'                       => true,
            'gui_column_ecpc'                       => true,
            'gui_column_ecps'                       => true,
            'gui_column_epps'                       => true
        );
        $queries = array();
        foreach ($cols as $k => $v) {
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN {$k} TEXT";
        }
        $this->_runQueries($queries);

        /////////////////////////////////////////////////////////////////////
        // Mods from previsou versions that were being called incorrectly.
        // They will fail nicely if already there, but will allow people
        // already past that version to get the changes.

        // Mods from _upgradeToThreeThirteenAlpha()
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD COLUMN unique_window INTEGER NOT NULL DEFAULT '0' AFTER is_unique";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_invocation_3rdparty_default SMALLINT DEFAULT '0' AFTER gui_header_text_color";
        $this->_runQueries($queries);

        // Mods from _upgradeToThreeFifteenAlpha()
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates ADD updated DATETIME NOT NULL AFTER publiczones";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}agency ADD updated DATETIME NOT NULL AFTER active";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD updated DATETIME NOT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD updated DATETIME NOT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients ADD updated DATETIME NOT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}trackers ADD updated DATETIME NOT NULL AFTER appendcode";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD updated DATETIME NOT NULL AFTER is_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD updated DATETIME NOT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad ADD updated DATETIME NOT NULL AFTER total_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection ADD updated DATETIME NOT NULL AFTER connection_status";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_hourly ADD updated DATETIME NOT NULL AFTER total_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}channel ADD updated DATETIME NOT NULL AFTER compiledlimitation";
        $this->_runQueries($queries);
        /////////////////////////////////////////////////////////////////////

        // Remove the "optimise" column from the campaigns table, if it exitst
        $query = "ALTER TABLE {$this->conf['table']['prefix']}campaigns DROP optimise";
        $this->_runQuery($query);

        // Upgrade the delivery limitations to match recent changes
        $this->_upgradeDeliveryLimitationsToThreeThirtyOneAlpha("bannerid", "{$this->conf['table']['prefix']}acls");
        $this->_upgradeDeliveryLimitationsToThreeThirtyOneAlpha("channelid", "{$this->conf['table']['prefix']}acls_channel");
        require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
        MAX_AclReCompileAll();
    }

    /**
     * A private method to update the delivery limitations in the database from the
     * v0.3.29-alpha to the v0.3.31-alpha format.
     *
     * @param string $keyColumn The "key" column of the $table table. Either
     *                          "bannerid", or "channelid".
     * @param string $table The table to update. Either "acls" or "acls_channel".
     */
    function _upgradeDeliveryLimitationsToThreeThirtyOneAlpha($keyColumn, $table)
    {
        $this->_upgradeDeliveryLimitations($keyColumn, $table, 'getDeliveryLimitationPluginUpgradeThreeThirtyOneAlpha');
    }

    /**
     * A private method to upgrade the database from the v0.3.29-alpha
     * format to the v0.3.30-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeThirtyAlpha()
    {
        // Fix cost_variable_id type
        $query = "ALTER TABLE {$this->conf['table']['prefix']}zones MODIFY cost_variable_id varchar(255)";
        $this->_runQuery($query);
    }

    /**
     * A private method to upgrade the database from the v0.3.28-alpha
     * format to the v0.3.29-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwentyNineAlpha()
    {
        $queries = array();

        // Extend the log_maintenance_priority table
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}log_maintenance_priority ADD run_type TINYINT UNSIGNED NOT NULL AFTER duration";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables MODIFY trackerid mediumint(9) NOT NULL default '0'";

        // Extend the zones table with capping columns
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD block INT(11) NOT NULL DEFAULT '0' AFTER updated";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD capping INT(11) NOT NULL DEFAULT '0' AFTER block";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD session_capping INT(11) NOT NULL DEFAULT '0' AFTER capping";

        // Increase channel data field to VARCHAR(255)
        // and reduce host_name down to VARCHAR(255)
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection CHANGE tracker_channel tracker_channel VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection CHANGE connection_channel connection_channel VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection CHANGE tracker_host_name tracker_host_name VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection CHANGE connection_host_name connection_host_name VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_ad_click CHANGE channel channel VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_ad_click CHANGE host_name host_name VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_ad_impression CHANGE channel channel VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_ad_impression CHANGE host_name host_name VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_ad_request CHANGE channel channel VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_ad_request CHANGE host_name host_name VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_tracker_click CHANGE channel channel VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_tracker_click CHANGE host_name host_name VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_tracker_impression CHANGE channel channel VARCHAR(255) NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_tracker_impression CHANGE host_name host_name VARCHAR(255) NULL";

        // Add an index on the expired column of data_summary_ad_zone_assoc
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_zone_assoc ADD INDEX expired (expired)";

        // Add facility to enable/disable 'more reports' link
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD more_reports VARCHAR(1) DEFAULT NULL AFTER publisher_default_approved";

        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.27-alpha
     * format to the v0.3.28-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwentyEightAlpha()
    {
        $this->tables->createTable('variable_publisher');

        $queries = array();

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD gui_column_num_items TEXT AFTER gui_column_bv";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD publisher_welcome enum('t', 'f') DEFAULT 't' AFTER client_welcome_msg";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD publisher_welcome_msg TEXT AFTER publisher_welcome";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD cost_variable_id INT(11) AFTER cost_type";

        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.26-alpha
     * format to the v0.3.27-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwentySevenAlpha()
    {
        $queries = array();

        $queries[] = "UPDATE {$this->conf['table']['prefix']}zones SET inventory_forecast_type = 4 WHERE inventory_forecast_type = 3";

        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.25-alpha
     * format to the v0.3.26-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwentySixAlpha()
    {
        $queries = array();

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_domain_page_daily ADD clicks int(10) unsigned default NULL AFTER impressions";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_country_daily ADD clicks int(10) unsigned default NULL AFTER impressions";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_source_daily ADD clicks int(10) unsigned default NULL AFTER impressions";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_site_keyword_daily ADD clicks int(10) unsigned default NULL AFTER impressions";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_domain_page_monthly ADD clicks int(10) unsigned default NULL AFTER impressions";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_domain_page_monthly MODIFY yearmonth mediumint(6) NOT NULL default '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_country_monthly ADD clicks int(10) unsigned default NULL AFTER impressions";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_country_monthly MODIFY yearmonth mediumint(6) NOT NULL default '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_source_monthly ADD clicks int(10) unsigned default NULL AFTER impressions";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_source_monthly MODIFY yearmonth mediumint(6) NOT NULL default '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_site_keyword_monthly ADD clicks int(10) unsigned default NULL AFTER impressions";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_zone_site_keyword_monthly MODIFY yearmonth mediumint(6) NOT NULL default '0'";

        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.24-alpha
     * format to the v0.3.25-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwentyFiveAlpha()
    {
        $this->tables->createTable('password_recovery');

        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}trackers ADD status SMALLINT(1) UNSIGNED NOT NULL DEFAULT '4' AFTER blockwindow";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}trackers ADD linkcampaigns ENUM('t','f') NOT NULL DEFAULT 'f' AFTER status";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD default_tracker_linkcampaigns ENUM('t','f') NOT NULL DEFAULT 'f' AFTER default_tracker_status";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD reject_if_empty SMALLINT(1) UNSIGNED NOT NULL DEFAULT '0'";

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection CHANGE connection_type connection_action INT(10) UNSIGNED NULL";

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}trackers ADD type SMALLINT(1) UNSIGNED NULL DEFAULT '1' AFTER status";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD default_tracker_type INT(10) UNSIGNED NULL DEFAULT '1' AFTER default_tracker_status";

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD purpose ENUM('basket_value', 'num_items', 'post_code') AFTER datatype";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}variables SET purpose = 'basket_value' WHERE is_basket_value = 1";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}variables SET purpose = 'num_items' WHERE is_num_items = 1";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables DROP is_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables DROP is_num_items";

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}trackers ADD variablemethod ENUM('default', 'js', 'dom', 'custom') NOT NULL DEFAULT 'default' AFTER linkcampaigns";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD variablecode VARCHAR(255) NOT NULL DEFAULT '' AFTER unique_window";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}tracker_append ADD autotrack ENUM('t', 'f') NOT NULL DEFAULT 'f'";

        // Set default variablecode for existing trackers/variables
        $queries[] = "UPDATE {$this->conf['table']['prefix']}variables v, {$this->conf['table']['prefix']}trackers t SET v.variablecode = CONCAT('var ', v.name, ' = escape(\'%%', upper(replace(v.name, ' ', '_')), '_VALUE%%\')') WHERE v.trackerid = t.trackerid AND t.variablemethod = 'default';";

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD hidden ENUM('t', 'f') NOT NULL DEFAULT 'f' AFTER variablecode";

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection ADD inside_window TINYINT(1) NOT NULL DEFAULT '0' AFTER connection_status";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}data_intermediate_ad_connection SET inside_window = 1";

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD COLUMN acls_updated datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER updated";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}channel ADD COLUMN acls_updated datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER comments";

        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables CHANGE datatype datatype ENUM('numeric', 'string', 'date') NOT NULL DEFAULT 'numeric'";

        $this->_runQueries($queries);

        // Fix append codes
        require_once MAX_PATH . '/lib/max/Dal/Inventory/Trackers.php';
        $tr = & new MAX_Dal_Inventory_Trackers();
        $tr->recompileAppendCodes();
    }

    /**
     * A private method to upgrade the database from the v0.3.23-alpha
     * format to the v0.3.24-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwentyFourAlpha()
    {
        $this->tables->createTable('data_summary_zone_domain_page_daily');
        $this->tables->createTable('data_summary_zone_country_daily');
        $this->tables->createTable('data_summary_zone_source_daily');
        $this->tables->createTable('data_summary_zone_site_keyword_daily');
        $this->tables->createTable('data_summary_zone_domain_page_monthly');
        $this->tables->createTable('data_summary_zone_country_monthly');
        $this->tables->createTable('data_summary_zone_source_monthly');
        $this->tables->createTable('data_summary_zone_site_keyword_monthly');
        $this->tables->createTable('data_summary_zone_domain_page_forecast');
        $this->tables->createTable('data_summary_zone_country_forecast');
        $this->tables->createTable('data_summary_zone_source_forecast');
        $this->tables->createTable('data_summary_zone_site_keyword_forecast');

        // Create the table for the tracker append codes
        $this->tables->createTable('tracker_append');

        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_variable_value ADD INDEX data_intermediate_ad_connection_id (data_intermediate_ad_connection_id)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}trackers ADD INDEX clientid (clientid)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD INDEX trackerid (trackerid)";
        $queries[] = "DROP TABLE IF EXISTS {$this->conf['table']['prefix']}data_summary_zone_impression_domain_page";
        $queries[] = "DROP TABLE IF EXISTS {$this->conf['table']['prefix']}data_summary_zone_impression_domain_keyword";
        $queries[] = "DROP TABLE IF EXISTS {$this->conf['table']['prefix']}data_summary_ad_domain";

        // Copy existing append codes in the new table
        $queries[] = "INSERT INTO {$this->conf['table']['prefix']}tracker_append (tracker_id, rank, tagcode) ".
                        "SELECT trackerid, 1, appendcode FROM trackers WHERE appendcode IS NOT NULL AND appendcode <> ''";

        // Change int variables datatype to numeric
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables CHANGE datatype datatype ENUM('int', 'string', 'numeric') NOT NULL DEFAULT 'numeric'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}variables SET datatype = 'numeric' WHERE datatype = 'int'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables CHANGE datatype datatype ENUM('numeric', 'string') NOT NULL DEFAULT 'numeric'";

        // Drop the no-longer used cache table
        $queries[] = "DROP TABLE IF EXISTS {$this->conf['table']['prefix']}cache";

        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.22-alpha
     * format to the v0.3.23-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwentyThreeAlpha()
    {
        // Columns preferences changes
        $cols = array(
            'gui_column_id'                  => null,
            'gui_column_requests'            => 'gui_show_requests',
            'gui_column_impressions'         => 'gui_show_impressions',
            'gui_column_clicks'              => 'gui_show_clicks',
            'gui_column_ctr'                 => 'gui_show_ctr',
            'gui_column_conversions'         => 'gui_show_conversions',
            'gui_column_conversions_pending' => null,
            'gui_column_sr_views'            => null,
            'gui_column_sr_clicks'           => 'gui_show_sr',
            'gui_column_revenue'             => 'gui_show_revenue',
            'gui_column_cost'                => 'gui_show_cost',
            'gui_column_bv'                  => 'gui_show_bv',
            'gui_column_revcpc'              => 'gui_show_revcpc',
            'gui_column_costcpc'             => 'gui_show_costcpc',
        );

        $queries = array();
        foreach ($cols as $k => $v) {
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN {$k} TEXT";
            if (!is_null($v)) {
                $queries[] = "UPDATE {$this->conf['table']['prefix']}preference SET {$k} = {$v}";
                $queries[] = "UPDATE {$this->conf['table']['prefix']}preference_advertiser SET preference = '{$k}' WHERE preference = '{$v}'";
                $queries[] = "UPDATE {$this->conf['table']['prefix']}preference_publisher SET preference = '{$k}' WHERE preference = '{$v}'";
                $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference DROP COLUMN {$v}";
            }
        }

        // Num items
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD is_num_items INTEGER NOT NULL DEFAULT 0 AFTER is_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad ADD total_num_items INTEGER UNSIGNED NULL AFTER total_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_hourly ADD total_num_items INTEGER UNSIGNED NULL AFTER total_basket_value";

        // Comment column for conversions
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection ADD comments TEXT DEFAULT NULL AFTER connection_status";

        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.21-alpha
     * format to the v0.3.22-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwentyTwoAlpha()
    {
        // Create the preference tables for advertisers and publishers
        $this->tables->createTable('affiliates_extra');
        $this->tables->createTable('preference_advertiser');
        $this->tables->createTable('preference_publisher');

        // Add agreement column to affiliates table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates ADD COLUMN last_accepted_agency_agreement datetime default NULL AFTER publiczones";
        $this->_runQueries($queries);

        // Add fields to preferences
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_requests SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_impressions SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_clicks SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_ctr SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_conversions SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_sr SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN publisher_agreement ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN publisher_agreement_text TEXT";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN publisher_payment_modes TEXT";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN publisher_currencies TEXT";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN publisher_categories TEXT";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN publisher_help_files TEXT";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN publisher_default_tax_id ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN publisher_default_approved ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_revenue SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_cost SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_bv SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_revcpc SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_show_costcpc SMALLINT(4) DEFAULT 15";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference CHANGE gui_invocation_3rdparty_default gui_invocation_3rdparty_default VARCHAR(64) DEFAULT 0";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.19-alpha
     * format to the v0.3.21-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwentyOneAlpha()
    {
        // Make sure that agencyid for publisher owned channels matches the publisher's agencyid
        $queries = array();
        $queries[] = "
            UPDATE
                {$this->conf['table']['prefix']}channel,
                {$this->conf['table']['prefix']}affiliates
            SET
                {$this->conf['table']['prefix']}channel.agencyid = {$this->conf['table']['prefix']}affiliates.agencyid
            WHERE
                {$this->conf['table']['prefix']}channel.affiliateid <> 0
              AND {$this->conf['table']['prefix']}channel.affiliateid = {$this->conf['table']['prefix']}affiliates.affiliateid
        ";
        $this->_runQueries($queries);

        // A change was made to the PageURL delivery limitation to provide support for "Exact" (regex) matches
        // Unfortunatly, this requires changing all the existing ACL "operator" fields, and recompiling all ACLs
        $queries = array();
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET comparison = '=~' WHERE type = 'Site:Pageurl' AND comparison = '=='";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET comparison = '!~' WHERE type = 'Site:Pageurl' AND comparison = '!='";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET comparison = '=~' WHERE type = 'Site:Pageurl' AND comparison = '=='";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET comparison = '!~' WHERE type = 'Site:Pageurl' AND comparison = '!='";
        $this->_runQueries($queries);

        require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
        MAX_AclReCompileAll();
    }

    /**
     * A private method to upgrade the database from the v0.3.17-alpha
     * format to the v0.3.19-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeNineteenAlpha()
    {
        // Add the priority_factor_limited column
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_zone_assoc ADD COLUMN priority_factor_limited SMALLINT NOT NULL DEFAULT 0 AFTER priority_factor";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.16-alpha
     * format to the v0.3.17-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeSeventeenAlpha()
    {
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD COLUMN inventory_forecast_type SMALLINT(6) NOT NULL DEFAULT '0' AFTER forceappend";
        $this->_runQueries($queries);

        // Add new indexes for queries to main tables
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates ADD INDEX agencyid (agencyid)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD INDEX clientid (clientid)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients ADD INDEX agencyid (agencyid)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD INDEX affiliateid (affiliateid)";
        $this->_runQueries($queries);

        // Add new indexes for queries to raw tables
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_ad_click ADD INDEX data_raw_ad_click_zone_id (zone_id)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_ad_impression ADD INDEX data_raw_ad_impression_zone_id (zone_id)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_raw_ad_request ADD INDEX data_raw_ad_request_zone_id (zone_id)";
        $this->_runQueries($queries);

        // Changes to the data_summary_ad_zone_assoc table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_zone_assoc CHANGE impressions_requested requested_impressions INTEGER UNSIGNED NOT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_zone_assoc ADD COLUMN required_impressions INTEGER UNSIGNED NOT NULL AFTER zone_id";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.15-alpha
     * format to the v0.3.16-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeSixteenAlpha()
    {
        // Add basic financial columns to campaigns and zones
        $querys = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD COLUMN revenue DECIMAL(10,4) DEFAULT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD COLUMN revenue_type SMALLINT DEFAULT NULL AFTER revenue";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD COLUMN cost DECIMAL(10,4) DEFAULT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD COLUMN cost_type SMALLINT DEFAULT NULL AFTER cost";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_hourly ADD COLUMN total_revenue DECIMAL(10,4) NULL AFTER total_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_hourly ADD COLUMN total_cost DECIMAL(10,4) NULL AFTER total_revenue";
        $this->_runQueries($queries);

        require_once(MAX_PATH . '/lib/max/other/lib-acl.inc.php');

        // Make 'logical' a varchar not a set()
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}acls CHANGE logical logical VARCHAR(3) NOT NULL DEFAULT 'and'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}acls_channel CHANGE logical logical VARCHAR(3) NOT NULL DEFAULT 'and'";
        $this->_runQueries($queries);

        // Add the acl_plugins field to the banner table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD COLUMN acl_plugins TEXT DEFAULT '' AFTER compiledlimitation";
        $this->_runQuery($query);

        // Increase the size of the 'type' field
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}acls CHANGE type type VARCHAR(32) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}acls_channel CHANGE type type VARCHAR(32) NOT NULL DEFAULT ''";
        $this->_runQueries($queries);

        // Rename "channel_name" -> "name" and add some fields to the channel table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}channel CHANGE channel_name name VARCHAR(255)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}channel ADD COLUMN description VARCHAR(255) AFTER name;";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}channel ADD COLUMN acl_plugins TEXT DEFAULT '' AFTER compiledlimitation";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}channel ADD COLUMN active SMALLINT(1) AFTER acl_plugins;";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}channel ADD COLUMN comments TEXT DEFAULT NULL AFTER active";
        $this->_runQueries($queries);

        // Update the ACLs table with the new plugin names
        $queries = array();
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Time:Day'  WHERE type='weekday'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Time:Hour' WHERE type='time'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Time:Date' WHERE type='date'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Client:Ip' WHERE type='clientip'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Client:Domain' WHERE type='domain'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Client:Language' WHERE type='language'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:Country' WHERE type='country_code'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:Region' WHERE type='region'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:City' WHERE type='city'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:Postalcode' WHERE type='postal_code'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:Latlong' WHERE type='latitude'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:Latlong' WHERE type='longitude'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:Dma' WHERE type='dma_code'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:Areacode' WHERE type='area_code'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:Organisation' WHERE type='organisation'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Geo:Netspeed' WHERE type='netspeed'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Client:Browser' WHERE type='browser'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Client:Os' WHERE type='os'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Client:Useragent' WHERE type='useragent'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Site:Referingpage' WHERE type='referer'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Site:Source' WHERE type='source'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Site:Channel' WHERE type='channel'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls SET type='Site:Pageurl' WHERE type='pageurl'";
        $this->_runQueries($queries);

        // Do the same for the channel acls table
        $queries = array();
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Time:Day'  WHERE type='weekday'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Time:Hour' WHERE type='time'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Time:Date' WHERE type='date'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Client:Ip' WHERE type='clientip'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Client:Domain' WHERE type='domain'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Client:Language' WHERE type='language'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:Country' WHERE type='country_code'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:Region' WHERE type='region'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:City' WHERE type='city'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:Postalcode' WHERE type='postal_code'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:Latlong' WHERE type='latitude'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:Latlong' WHERE type='longitude'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:Dma' WHERE type='dma_code'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:Areacode' WHERE type='area_code'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:Organisation' WHERE type='organisation'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Geo:Netspeed' WHERE type='netspeed'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Client:Browser' WHERE type='browser'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Client:Os' WHERE type='os'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Client:Useragent' WHERE type='useragent'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Site:Referingpage' WHERE type='referer'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Site:Source' WHERE type='source'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}acls_channel SET type='Site:Pageurl' WHERE type='pageurl'";
        $this->_runQueries($queries);

        // Upgrade any existing ACLs that require data restructuring, and recomile all compiledlimiation strings
        $regex_browsers = array(
            '(MSIE 4.*\)$)'                     => 'IE',
            '(MSIE 5.*\)$)'                     => 'IE',
            '(MSIE 6.*\)$)'                     => 'IE',
            '(^Mozilla/3.*\([^c][^o][^m].*\)$)' => 'NS',
            '(^Mozilla/4.*\([^c][^o][^m].*\)$)' => 'NS',
            '(^Mozilla/5.*Gecko)'               => 'NS',
            '(Safari)'                          => 'SF',
            '(Omni)'                            => 'OW',
            '(iCab)'                            => 'IC',
            '(Opera)'                           => 'OP',
            '(Konqueror)'                       => 'KQ',
        );
        $regex_os = array(
            '(Win)'         =>  'xp,2k,98,95,m3,nt,nt4.0,nt5.2',
            '(Windows CE)'  =>  'ce',
            '(Mac)'         =>  'osx,ppc',
            '(Linux)'       =>  'linux',
            '(BSD)'         =>  'freebsd',
            '(SunOS)'       =>  'sun',
            '(AIX)'         =>  'aix',
        );

        // Since we need to do almost identical things for both banner and channel ACLs...
        $actions = array(
            'banners'   => array(
                'table'     => 'acls',
                'id_field'  => 'bannerid',
                'page'      => 'banner-acl.php',
            ),
            'channels'  => array(
                'table'     => 'acls_channel',
                'id_field'  => 'channelid',
                'page'      => 'channel-acl.php',
            ),
        );
        foreach ($actions as $action) {
            $recompile = array();
            $acls = array();
            $query = "SELECT * FROM {$this->conf['table']['prefix']}{$action['table']} ORDER BY {$action['id_field']}, executionorder";
            $result = $this->_runQuery($query);
            if (!PEAR::isError($result)) {
                while ($row = $result->fetchRow()) {
                    $acls[$row[$action['id_field']]][$row['executionorder']] = $row;
                    $newData = false;
                    switch($row['type']) {
                        case 'Client:Browser':
                            if (substr($row['data'], 0, 1) == '(') {
                                $oldData = explode('|', $row['data']);
                                $newData = array();
                                foreach ($oldData as $regEx) {
                                    if (!in_array($regex_browsers[$regEx], $newData) && !empty($regex_browsers[$regEx])) {
                                        $newData[] = $regex_browsers[$regEx];
                                    }
                                }
                                $newData = implode(',', $newData);
                            }
                            break;
                        case 'Client:Os':
                            if (substr($row['data'], 0, 1) == '(') {
                                $oldData = explode('|', $row['data']);
                                $newData = array();
                                foreach ($oldData as $regEx) {
                                    if (!in_array($regex_os[$regEx], $newData) && !empty($regex_os[$regEx])) {
                                        $newData[] = $regex_os[$regEx];
                                    }
                                }
                                $newData = implode(',', $newData);
                            }
                            break;
                        default:
                            break;
                    }
                    if ($newData !== false) {
                        $innerQuery = "UPDATE {$this->conf['table']['prefix']}{$action['table']} SET data='{$newData}' WHERE {$action['id_field']}={$row[$action['id_field']]} AND executionorder={$row['executionorder']}";
                        $this->_runQuery($innerQuery);
                    }
                }
            }
            // OK so we've updated all the data values, now the hard part, we need to recompile limitations for all banners
            foreach ($acls as $id => $acl) {
                $aEntities = array($action['id_field'] => $id);
                MAX_AclSave($acl, $aEntities, $action['page']);
            }
            // All other banners should have the compiledlimitation set to "true"
            $ids = implode(',', array_keys($acls));
            $query = "UPDATE {$action['table']} SET compiledlimitation = 'true' WHERE {$action['id_field']} NOT IN ({$ids})";
            $this->_runQuery($query);
        }
    }

    /**
     * A private method to upgrade the database from the v0.3.13-alpha
     * format to the v0.3.15-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeFifteenAlpha()
    {
        // Add timestamps fileds for last "updated" info
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates ADD updated DATETIME NOT NULL AFTER publiczones";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}agency ADD updated DATETIME NOT NULL AFTER active";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD updated DATETIME NOT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD updated DATETIME NOT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients ADD updated DATETIME NOT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}trackers ADD updated DATETIME NOT NULL AFTER appendcode";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD updated DATETIME NOT NULL AFTER is_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD updated DATETIME NOT NULL AFTER comments";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad ADD updated DATETIME NOT NULL AFTER total_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection ADD updated DATETIME NOT NULL AFTER connection_status";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_hourly ADD updated DATETIME NOT NULL AFTER total_basket_value";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}channel ADD updated DATETIME NOT NULL AFTER compiledlimitation";
        $this->_runQueries($queries);

        // Fix the data_intermediate_ad table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad CHANGE COLUMN data_intermediate_keyword_id data_intermediate_ad_id BIGINT NOT NULL AUTO_INCREMENT";
        $this->_runQuery($query);
    }

    /**
     * A private method to upgrade the database from the v0.3.11-alpha
     * format to the v0.3.13-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeThirteenAlpha()
    {
        // Add unique_window column to variables table that was left out of the v0.3.12-alpha release,
        // add new column to preferences to set if 3rd party click tracking is on or off by default
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD COLUMN unique_window INTEGER NOT NULL DEFAULT '0' AFTER is_unique";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_invocation_3rdparty_default SMALLINT DEFAULT '0' AFTER gui_header_text_color";
        $this->_runQueries($queries);

    }

    /**
     * A private method to upgrade the database from the v0.3.10-alpha
     * format to the v0.3.11-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeElevenAlpha()
    {
        // Add changes required for dedup conversions
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD COLUMN is_unique INTEGER NOT NULL DEFAULT 0";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD INDEX (is_unique)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_variable_value ADD INDEX (tracker_variable_id)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_variable_value ADD INDEX (value)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection ADD INDEX (viewer_id)";
        $this->_runQueries($queries);

        // Add changes required for ChannelForecasting
        $this->tables->createTable('acls_channel');
        $this->tables->createTable('channel');
        $this->tables->createTable('log_maintenance_forecasting');

        // Add geoip columns to raw tables
        $rawTables = array(
            'data_raw_ad_request',
            'data_raw_ad_impression',
            'data_raw_ad_click',
            'data_raw_tracker_impression',
            'data_raw_tracker_click'
        );
        foreach ($rawTables as $rawTable) {
            $queries = array();
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_region VARCHAR(50) NULL";
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_city VARCHAR(50) NULL";
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_postal_code VARCHAR(10) NULL";
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_latitude decimal(8,4) NULL";
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_longitude decimal(8,4) NULL";
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_dma_code VARCHAR(50) NULL";
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_area_code VARCHAR(50) NULL";
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_organisation VARCHAR(50) NULL";
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_netspeed VARCHAR(20) NULL";
            $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}$rawTable ADD COLUMN geo_continent VARCHAR(13) NULL";
            $this->_runQueries($queries);
        }
    }

    /**
     * A private method to upgrade the database from the v0.3.09-alpha
     * format to the v0.3.10-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTenAlpha()
    {
        // Add new columns to tables to support comments
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients ADD COLUMN comments TEXT DEFAULT NULL AFTER reportdeactivate";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates ADD COLUMN comments TEXT DEFAULT NULL AFTER mnemonic";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD COLUMN comments TEXT DEFAULT NULL AFTER alt_contenttype";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD COLUMN comments TEXT DEFAULT NULL AFTER companion";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD COLUMN comments TEXT DEFAULT NULL AFTER forceappend";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.05-alpha
     * format to the v0.3.09-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeNineAlpha()
    {
        // Create the log_maintenance_priority table left out of v0.3.04-alpha update
        $this->tables->createTable('log_maintenance_priority');

        // Add new columns to preference table left out of v0.3.04-alpha update
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN allow_invocation_clickonly ENUM('t', 'f') DEFAULT 't' NOT NULL AFTER allow_invocation_popup";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN my_logo VARCHAR(255) AFTER my_footer";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.04-alpha
     * format to the v0.3.05-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeFiveAlpha()
    {
        // Add new columns to preference table left out of v0.3.04-alpha update
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_header_active_tab_color VARCHAR(7) DEFAULT '' AFTER gui_header_foreground_color";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN gui_header_text_color VARCHAR(7) DEFAULT '' AFTER gui_header_active_tab_color";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.3.02-alpha
     * format to the v0.3.04-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeFourAlpha()
    {
        // Add default_tracker_status column to preference table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN default_tracker_status TINYINT(4) NOT NULL DEFAULT '1'";
        $this->_runQuery($query);

        // Add new status column to campaign_trackers table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}campaigns_trackers ADD COLUMN status smallint(1) UNSIGNED NOT NULL DEFAULT '4'";
        $this->_runQuery($query);
        // Convert old style logstats to the new style status
        $query = "UPDATE {$this->conf['table']['prefix']}campaigns_trackers SET status = 0 WHERE logstats = 'n'";
        $this->_runQuery($query);
        // Drop the old campaigns_trackers logstats column
        $query = "ALTER TABLE {$this->conf['table']['prefix']}campaigns_trackers DROP COLUMN logstats";
        $this->_runQuery($query);

        // Add new connection_status column to data_intermediate_ad_connection table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection ADD COLUMN connection_status INTEGER UNSIGNED NOT NULL DEFAULT '1'";
        $this->_runQuery($query);
        // Convert old style conversion to the new style connection_status
        $queries = array();
        $queries[] = "UPDATE {$this->conf['table']['prefix']}data_intermediate_ad_connection SET connection_status = 1 WHERE conversion = 'n'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}data_intermediate_ad_connection SET connection_status = 4 WHERE conversion = 'y'";
        $this->_runQueries($queries);
        // Drop the old data_intermediate_ad_connection conversion column
        $query = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad_connection DROP COLUMN conversion";
        $this->_runQuery($query);

        // Add new campaign companion column
        $query = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD COLUMN companion SMALLINT(1) DEFAULT '0'";
        $this->_runQuery($query);

        // Create the data_summary_ad_zone_assoc table
        $this->tables->createTable('data_summary_ad_zone_assoc');

        // Update the ad_zone_assoc table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}ad_zone_assoc CHANGE COLUMN priority priority DOUBLE NULL DEFAULT '0'";
        $this->_runQuery($query);

        // Add active tab color column to preference
        $query = "ALTER TABLE {$this->prefix}preference ADD COLUMN gui_header_active_tab_color VARCHAR(7) DEFAULT ''";
        $this->_runQuery($query);

        // Add header text color column to preference
        $query = "ALTER TABLE {$this->prefix}preference ADD COLUMN gui_header_text_color VARCHAR(7) DEFAULT ''";
        $this->_runQuery($query);

        // Add logout URL field to the agency table
        $query = "ALTER TABLE {$this->prefix}agency ADD COLUMN logout_url VARCHAR(255) DEFAULT ''";
        $this->_runQuery($query);

        // Add active to agency table
        $query = "ALTER TABLE {$this->prefix}agency ADD COLUMN active SMALLINT(1) DEFAULT '0'";
        $this->_runQuery($query);

        // Change/add fields in/to the campaigns table to allow daily manual limit of clicks or
        // conversions, in addition to impressions
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns CHANGE COLUMN target target_impression INT(11) NOT NULL DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD COLUMN target_click INT(11) NOT NULL DEFAULT '0' AFTER target_impression";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD COLUMN target_conversion INT(11) NOT NULL DEFAULT '0' AFTER target_impression";
        $this->_runQueries($queries);

        // Change all direct selection ad/zone associations (zone_id = 0) to a link_type of MAX_AD_ZONE_LINK_DIRECT
        $query = "UPDATE {$this->prefix}ad_zone_assoc SET link_type = " . MAX_AD_ZONE_LINK_DIRECT . ' WHERE zone_id = 0';
        $this->_runQuery($query);
    }

    /**
     * A private method to upgrade the database from the v0.3.01-alpha
     * format to the v0.3.02-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeTwoAlpha()
    {
        // Create the plugins_channel_delivery tables
        $this->tables->createTable('plugins_channel_delivery_assoc');
        $this->tables->createTable('plugins_channel_delivery_domains');
        $this->tables->createTable('plugins_channel_delivery_rules');

        // Add new campaign priority column
        $query = "ALTER TABLE {$this->conf['table']['prefix']}campaigns ADD COLUMN new_priority INT(11) NOT NULL DEFAULT '0' AFTER priority";
        $this->_runQuery($query);

        // Convert old style priorities to the new style
        $queries = array();
        $queries[] = "UPDATE {$this->conf['table']['prefix']}campaigns SET new_priority = 0 WHERE priority = 'l'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}campaigns SET new_priority = 1 WHERE priority = 'm'";
        $queries[] = "UPDATE {$this->conf['table']['prefix']}campaigns SET new_priority = 2 WHERE priority = 'h'";
        $this->_runQueries($queries);

        // Drop the old campaign priority column & rename the new one
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns DROP COLUMN priority";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}campaigns CHANGE COLUMN new_priority priority INT(11) NOT NULL DEFAULT '0'";
        $this->_runQueries($queries);

        // Fix any badly created userlog tables
        $query = "ALTER TABLE {$this->conf['table']['prefix']}userlog CHANGE COLUMN TIMESTAMP timestamp INT(11) NOT NULL DEFAULT '0'";
        $this->_runQuery($query);
    }

    /**
     * A private method to upgrade the database from the v0.3.00-alpha
     * format to the v0.3.01-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeOneAlpha()
    {
        // Add new column to the preference table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN default_banner_url VARCHAR(255) DEFAULT NULL";
        $this->_runQuery($query);
    }

    /**
     * A private method to upgrade the database from the v0.2.4-alpha
     * format to the v0.3.00-alpha format.
     *
     * @access private
     */
    function _upgradeToThreeZeroAlpha()
    {
        // Rename the config table to preference
        $query = "ALTER TABLE {$this->conf['table']['prefix']}config RENAME {$this->conf['table']['prefix']}preference";
        $this->_runQuery($query);

        // Alter columns in the preference table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}preference CHANGE updates_last_seen updates_last_seen TEXT";
        $this->_runQuery($query);

        // Drop unused columns from the preference table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference DROP userlog_priority";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference DROP userlog_autoclean";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference DROP type_web_mode";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference DROP type_web_dir";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference DROP type_web_ftp";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference DROP type_web_url";
        $this->_runQueries($queries);

        // Add new columns to the preference table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN default_banner_url VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN default_banner_destination VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}preference ADD COLUMN banner_html_auto enum('t','f') DEFAULT 't'";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.2.3-alpha
     * format to the v0.2.4-alpha format.
     *
     * @access private
     */
    function _upgradeToTwoFourAlpha()
    {
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config DROP COLUMN table_border_color";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config DROP COLUMN table_back_color";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config DROP COLUMN table_back_color_alternative";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config DROP COLUMN main_back_color";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD COLUMN gui_header_background_color VARCHAR(7) DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD COLUMN gui_header_foreground_color VARCHAR(7) DEFAULT ''";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.2.1-alpha
     * format to the v0.2.3-alpha format.
     *
     * @access private
     */
    function _upgradeToTwoThreeAlpha()
    {
        // Fix the config table's gui_link_compact_limit field
        $query = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE gui_link_compact_limit gui_link_compact_limit INTEGER DEFAULT '50'";
        $this->_runQuery($query);

        // Create the ad_zone_assoc table
        $this->tables->createTable('ad_zone_assoc');

        // Create the placement_zone_assoc table
        $this->tables->createTable('placement_zone_assoc');

        // Create the category table
        $this->tables->createTable('category');

        // Create the ad_category table
        $this->tables->createTable('ad_category_assoc');

        // Transfer keywords from the banners table to the category table
        $query = "SELECT bannerid, keyword FROM {$this->conf['table']['prefix']}banners WHERE keyword != ''";
        $result = $this->_runQuery($query);
        if (!PEAR::isError($result)) {
            while ($row = $result->fetchRow()) {
                $adId = $row['bannerid'];
                $keywords = split(' ', $row['keyword']);
                foreach ($keywords as $keyword) {
                    $innerQuery = "SELECT category_id FROM {$this->conf['table']['prefix']}category WHERE name = '$keyword'";
                    $innerResult = $this->_runQuery($innerQuery);
                    if (!PEAR::isError($innerResult)) {
                        if ($innerRow = $innerResult->fetchRow()) {
                            $categoryId = $innerRow['category_id'];
                        } else {
                            $categoryId = Admin_DA::addCategory(array('name' => $keyword));
                        }
                        Admin_DA::addAdCategory(array('ad_id' => $adId, 'category_id' => $categoryId));
                    }
                }
            }
        }

        // Transfer the contents of the 'what' column to the ad_zone_assoc and placement_zone_assoc tables
        $query = "SELECT zoneid, what FROM {$this->conf['table']['prefix']}zones WHERE what != ''";
        $result = $this->_runQuery($query);
        if (!PEAR::isError($result)) {
            while ($row = $result->fetchRow()) {
                $zoneId = $row['zoneid'];
                $keywords = split(',', $row['what']);
                $newkeywords = array();
                foreach ($keywords as $keyword) {
                    if (substr($keyword, 0, 9) == 'bannerid:') {
                        $adId = substr($keyword, 9);
                        Admin_DA::addAdZone(array('zone_id' => $zoneId, 'ad_id' => $adId));
                    } elseif (substr($keyword, 0, 11) == 'campaignid:') {
                        $placementId = substr($keyword, 11);
                        Admin_DA::addPlacementZone(array('zone_id' => $zoneId, 'placement_id' => $placementId));
                        MAX_addLinkedAdsToZone($zoneId, $placementId);
                    } else {
                        $newkeywords[] = $keyword;
                    }
                }
                $keywords = addslashes(implode(',',$newkeywords));
                $innerQuery = "UPDATE {$this->conf['table']['prefix']}zones SET what = '$keywords' WHERE zoneid = $zoneId";
                $innerResult = $this->_runQuery($innerQuery);
            }
        }

        // Always have a '0' node in ad_zone for each banner so that direct selection works.
        $query = "INSERT INTO {$this->conf['table']['prefix']}ad_zone_assoc (ad_id, zone_id) SELECT bannerid, 0 FROM {$this->conf['table']['prefix']}banners";
        $this->_runQuery($query);

        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config DROP COLUMN gui_link_compact_limit";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners DROP COLUMN keyword";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners DROP COLUMN priority";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones CHANGE what ad_selection TEXT NOT NULL DEFAULT ''";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.2.0-alpha
     * format to the v0.2.1-alpha format.
     *
     * @access private
     */
    function _upgradeToTwoOneAlpha()
    {
        // Add support for ad request summarising
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_intermediate_ad ADD COLUMN requests INTEGER UNSIGNED NOT NULL DEFAULT 0 AFTER zone_id";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}data_summary_ad_hourly ADD COLUMN requests INTEGER UNSIGNED NOT NULL DEFAULT 0 AFTER zone_id";
        $this->_runQueries($queries);
    }

    /**
     * A private method to upgrade the database from the v0.1.x format
     * to the v0.2.0-alpha format.
     *
     * @access private
     */
    function _upgradeToTwoZeroAlpha()
    {
        // Add support for default anonymous campaigns to the config table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}config ADD COLUMN gui_campaign_anonymous ENUM('t','f') AFTER gui_show_campaign_preview";
        $this->_runQuery($query);

        // Create the data_intermediate_ad table
        $this->tables->createTable('data_intermediate_ad');

        // Create the data_intermediate_ad_connection table
        $this->tables->createTable('data_intermediate_ad_connection');

        // Create the data_intermediate_ad_variable_value table
        $this->tables->createTable('data_intermediate_ad_variable_value');

        // Create the data_raw_ad_click table
        $this->tables->createTable('data_raw_ad_click');

        // Create the data_raw_ad_impression table
        $this->tables->createTable('data_raw_ad_impression');

        // Create the data_raw_ad_request table
        $this->tables->createTable('data_raw_ad_request');

        // Create the data_raw_tracker_click table
        $this->tables->createTable('data_raw_tracker_click');

        // Create the data_raw_tracker_impression table
        $this->tables->createTable('data_raw_tracker_impression');

        // Create the data_raw_tracker_variable_value table
        $this->tables->createTable('data_raw_tracker_variable_value');

        // Create the data_summary_ad_hourly table
        $this->tables->createTable('data_summary_ad_hourly');

        // Create the data_summary_zone_impression_history table
        $this->tables->createTable('data_summary_zone_impression_history');

        // Create the log_maintenance_statistics table
        $this->tables->createTable('log_maintenance_statistics');

        // Increase the size of details in the userlog table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}userlog CHANGE details details MEDIUMTEXT";
        $this->_runQuery($query);

        // Drop the variabletype column from the variables table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}variables DROP variabletype";
        $this->_runQuery($query);

        // Add the is_basket_value column to the variables table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}variables ADD is_basket_value INTEGER NOT NULL DEFAULT '0'";
        $this->_runQuery($query);
    }

    /**
     * A private method to upgrade the database for all versions
     * prior to v0.1.16-beta. Note that in some cases, a check is
     * performed to test if the chages have already been made, as
     * the changes cannot be applied twice. In other cases, no check
     * is made, as the changes can simply be ignored by MySQL if
     * they are applied for a second time.
     *
     * @access private
     */
    function _upgradeEarly()
    {
        // acls table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}acls CHANGE logical logical set('and','or') NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}acls CHANGE type type VARCHAR(16) NOT NULL DEFAULT ''";
        $this->_runQueries($queries);

        // adclicks table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adclicks DROP INDEX bannerid_date";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adclicks ADD userid VARCHAR(32) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adclicks CHANGE t_stamp t_stamp TIMESTAMP(14) NOT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adclicks CHANGE host host VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adclicks CHANGE source source VARCHAR(50) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adclicks CHANGE country country char(2) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adclicks ADD INDEX bannerid(bannerid)";
        $this->_runQueries($queries);

        // adstats table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adstats DROP PRIMARY KEY";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adstats DROP KEY bannerid_day";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adstats ADD conversions INT(11) NOT NULL DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adstats CHANGE bannerid bannerid MEDIUMINT(9) NOT NULL DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adstats CHANGE zoneid zoneid MEDIUMINT(9) NOT NULL DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adstats ADD KEY day(day)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adstats ADD KEY bannerid(bannerid)";
        $this->_runQueries($queries);

        // adviews table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adviews DROP INDEX bannerid_date";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adviews ADD userid VARCHAR(32) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adviews CHANGE t_stamp t_stamp TIMESTAMP(14) NOT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adviews CHANGE host host VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adviews CHANGE source source VARCHAR(50) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adviews CHANGE country country char(2) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}adviews ADD INDEX bannerid(bannerid)";
        $this->_runQueries($queries);

        // affiliates table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates ADD agencyid MEDIUMINT(9) NOT NULL DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates ADD mnemonic VARCHAR(5) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates CHANGE name name VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates CHANGE contact contact VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates CHANGE email email VARCHAR(64) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates CHANGE website website VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates CHANGE username username VARCHAR(64) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates CHANGE password password VARCHAR(64) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates CHANGE permissions permissions MEDIUMINT(9) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}affiliates CHANGE language language VARCHAR(64) DEFAULT NULL";
        $this->_runQueries($queries);

        // agency table
        $this->tables->createTable('agency');

        // application_variable table
        $this->tables->createTable('application_variable');
        $query = "
            INSERT INTO
                {$this->conf['table']['prefix']}application_variable
                (
                    name,
                    value
                )
            VALUES
                (
                    'max_version',
                    '{$this->upgradeTo}'
                )
            ";
        $this->_runQuery($query);

        // banners table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE clientid campaignid MEDIUMINT(9) NOT NULL DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE filename filename VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE imageurl imageurl VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE htmltemplate htmltemplate TEXT NOT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE htmlcache htmlcache TEXT NOT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE target target VARCHAR(16) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE url url TEXT NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE alt alt VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE status status VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE keyword keyword VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE bannertext bannertext TEXT NOT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE description description VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD adserver VARCHAR(50) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE compiledlimitation compiledlimitation TEXT NOT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners CHANGE append append TEXT NOT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD alt_filename VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD alt_imageurl VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD alt_contenttype ENUM('gif','jpeg','png') NOT NULL DEFAULT 'gif'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD KEY campaignid (campaignid)";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD capping INT(11) NOT NULL DEFAULT '0' AFTER block";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}banners ADD session_capping INT(11) NOT NULL DEFAULT '0' AFTER capping";
        $this->_runQueries($queries);

        // cache table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}cache CHANGE content content blob NOT NULL";
        $this->_runQuery($query);

        // campaigns table
        $this->tables->createTable('campaigns');
        $query = "
            INSERT INTO
                {$this->conf['table']['prefix']}campaigns
            SELECT
                clientid AS campaignid,
                clientname AS campaignname,
                parent AS clientid,
                views AS views,
                clicks AS clicks,
                '-1' AS conversions,
                expire AS expire,
                activate AS activate,
                active AS active,
                'h' AS priority,
                weight AS weight,
                target AS target_impression,
                0 AS target_click,
                0 AS target_conversion,
                'f' AS anonymous,
                0 AS companion
            FROM
                {$this->conf['table']['prefix']}clients
            WHERE
                parent > 0
        ";
        // There may be an error copying the data from the old phpAdsNew
        // clients table into the new Max campaigns table, because this
        // might be an upgrade from an early version of Max, in which case
        // the data has already been copied. So, don't use a PEAR_Error
        // handler at all for this query.
        PEAR::pushErrorHandling(null);
        $result = $this->dbh->query($query);
        PEAR::popErrorHandling();
        if (PEAR::isError($result)) {
            // Was this the table doesn't exist error?
            if ($result->code != DB_ERROR_NOSUCHTABLE) {
                // No, the old phpAdsNew clients table existed, so it was
                // a real error that happened
                $this->errors[] = MAX::errorObjToString($result);
            }
        } else {
            // The copy of data worked, so now update the data in the
            // campaigns table
            $query = "
                UPDATE
                    {$this->conf['table']['prefix']}campaigns
                SET
                    priority = 'l'
                WHERE
                    weight > 0
                    AND views = -1
                    AND clicks = -1
                    AND conversions = -1
                ";
            $this->dbh->query($query);
        }

        // campaigns_trackers table
        $this->tables->createTable('campaigns_trackers');

        // clients table
        $queries = array();
        $queries[] = "DELETE FROM {$this->conf['table']['prefix']}clients WHERE parent > 0";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients ADD agencyid MEDIUMINT(9) NOT NULL DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients CHANGE clientname clientname VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients CHANGE contact contact VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients CHANGE email email VARCHAR(64) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients CHANGE clientusername clientusername VARCHAR(64) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients CHANGE clientpassword clientpassword VARCHAR(64) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients CHANGE permissions permissions MEDIUMINT(9) default NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients CHANGE language language VARCHAR(64) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients DROP active";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients DROP weight";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients DROP target";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}clients DROP parent";
        $this->_runQueries($queries);

        // config table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config DROP PRIMARY KEY";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE configid agencyid MEDIUMINT(9) DEFAULT '0' NOT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE my_header my_header VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE my_footer my_footer VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE language language VARCHAR(32) DEFAULT 'english'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE name name VARCHAR(32) default NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE override_gd_imageformat override_gd_imageformat VARCHAR(4) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE begin_of_week begin_of_week TINYINT(2) DEFAULT '1'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE percentage_decimals percentage_decimals TINYINT(2) DEFAULT '2'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE type_sql_allow type_sql_allow ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE type_url_allow type_url_allow ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE type_web_allow type_web_allow ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE type_html_allow type_html_allow ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE type_txt_allow type_txt_allow ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE type_web_mode type_web_mode TINYINT(2) DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE type_web_dir type_web_dir VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE type_web_ftp type_web_ftp VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE type_web_url type_web_url VARCHAR(255) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE admin admin VARCHAR(64) DEFAULT 'phpadsuser'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE admin_pw admin_pw VARCHAR(64) default 'phpadspass'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE admin_fullname admin_fullname VARCHAR(255) DEFAULT 'Your Name'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE admin_email admin_email VARCHAR(64) DEFAULT 'your@email.com'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD warn_admin ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD warn_agency ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD warn_client ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD warn_limit MEDIUMINT(9) NOT NULL DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE admin_email_headers admin_email_headers VARCHAR(64) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE admin_novice admin_novice ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE default_banner_weight default_banner_weight TINYINT(4) DEFAULT '1'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE default_campaign_weight default_campaign_weight TINYINT(4) DEFAULT '1'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE client_welcome client_welcome ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE client_welcome_msg client_welcome_msg TEXT";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE content_gzip_compression content_gzip_compression ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE userlog_email userlog_email ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE userlog_priority userlog_priority ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE userlog_autoclean userlog_autoclean ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE gui_show_campaign_info gui_show_campaign_info ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE gui_show_campaign_preview gui_show_campaign_preview ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE gui_show_banner_info gui_show_banner_info ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE gui_show_banner_preview gui_show_banner_preview ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE gui_show_banner_html gui_show_banner_html ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE gui_show_matching gui_show_matching ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE gui_show_parents gui_show_parents ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE gui_hide_inactive gui_hide_inactive ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE qmail_patch qmail_patch ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE updates_frequency updates_frequency TINYINT(2) DEFAULT '7'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE updates_timestamp updates_timestamp INT(11) DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE updates_last_seen updates_last_seen decimal(7,3) DEFAULT '0.000'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE allow_invocation_plain allow_invocation_plain ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD allow_invocation_plain_nocookies ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE allow_invocation_js allow_invocation_js ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE allow_invocation_frame allow_invocation_frame ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE allow_invocation_xmlrpc allow_invocation_xmlrpc ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE allow_invocation_local allow_invocation_local ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE allow_invocation_interstitial allow_invocation_interstitial ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE allow_invocation_popup allow_invocation_popup ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE auto_clean_tables auto_clean_tables ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE auto_clean_tables_interval auto_clean_tables_interval TINYINT(2) DEFAULT '5'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE auto_clean_userlog auto_clean_userlog ENUM('t','f') DEFAULT 'f'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE auto_clean_userlog_interval auto_clean_userlog_interval TINYINT(2) DEFAULT '5'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE auto_clean_tables_vacuum auto_clean_tables_vacuum ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE autotarget_factor autotarget_factor float DEFAULT '-1'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config CHANGE maintenance_timestamp maintenance_timestamp INT(11) DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD compact_stats ENUM('t','f') DEFAULT 't'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD statslastday DATE NOT NULL DEFAULT '0000-00-00'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD statslasthour TINYINT(4) NOT NULL DEFAULT '0'";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}config ADD PRIMARY KEY(agencyid)";
        $this->_runQueries($queries);

        // conversionlog table
        $this->tables->createTable('conversionlog');

        // images table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}images CHANGE filename filename VARCHAR(128) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}images CHANGE t_stamp t_stamp TIMESTAMP(14) NOT NULL";
        $this->_runQueries($queries);

        // session table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}session CHANGE sessionid sessionid VARCHAR(32) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}session CHANGE lastused lastused TIMESTAMP(14) NOT NULL";
        $this->_runQueries($queries);

        // Sometimes phpAdsNew installs the targetstats table without
        // the correct prefix, and instead uses "tbl_" as the prefix.
        // Run some SQL to fix this, but ignore all errors.
        PEAR::pushErrorHandling(null);
        $query = "ALTER TABLE tbl_targetstats RENAME {$this->conf['table']['prefix']}targetstats";
        $this->dbh->query($query);
        PEAR::popErrorHandling();

        // targetstats table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}targetstats DROP PRIMARY KEY";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}targetstats CHANGE clientid campaignid MEDIUMINT(9) NOT NULL DEFAULT '0'";
        $this->_runQueries($queries);

        // trackers table
        $this->tables->createTable('trackers');

        // userlog table
        $query = "ALTER TABLE {$this->conf['table']['prefix']}userlog CHANGE details details TEXT";
        $this->dbh->query($query);

        // variables table
        $this->tables->createTable('variables');

        // variablevalues table
        $this->tables->createTable('variablevalues');

        // zones table
        $queries = array();
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones CHANGE affiliateid affiliateid MEDIUMINT(9) DEFAULT NULL";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones CHANGE zonename zonename VARCHAR(245) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones CHANGE description description VARCHAR(255) NOT NULL DEFAULT ''";
        $queries[] = "ALTER TABLE {$this->conf['table']['prefix']}zones ADD COLUMN forceappend ENUM ('t','f') DEFAULT 'f'";
        $this->_runQueries($queries);

        // Fix the 'what' column which links campaigns (used to be clients)
        $query = "
            SELECT
                *
            FROM
                {$this->conf['table']['prefix']}zones
            ";
        $result = $this->dbh->query($query);
        if (!PEAR::isError($result)) {
            while ($row = $result->fetchRow()) {
                $newWhat = preg_replace('/clientid:/', 'campaignid:', $row['what']);
                if ($newWhat!= $row['what']) {
                    $innerQuery = "
                        UPDATE
                            {$this->conf['table']['prefix']}zones
                        SET
                            what = '$newWhat'
                        WHERE
                        ";
                    foreach ($row as $key => $value) {
                        if (preg_match('/\d+/', $key)) {
                            continue;
                        } elseif ($key == 'what') {
                            continue;
                        } elseif ($value != '') {
                            $innerQuery .= "$key = '$value' AND ";
                        }
                    }
                    $innerQuery = preg_replace('/ AND $/', '', $innerQuery);
                    if (!preg_match('/WHERE $/', $innerQuery)) {
                        $this->dbh->query($innerQuery);
                    }
                }
            }
        }
    }

    /**
     * A private method for running a query and returning the result.
     *
     * @access private
     * @param string $query A SQL query to run.
     * @return mixed A {@link DB_Result} or {@link DB_Error} object.
     */
    function _runQuery($query)
    {
        // Use the Upgrade class' PEAR_Error handler
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array($this, 'pearErrorHandler'));
        // Execute the upgrade SQL statements
        $result = $this->dbh->query($query);
        // Restore the normal PEAR_Error handler
        PEAR::popErrorHandling();
        // Return the result
        return $result;
    }

    /**
     * A private method for running a series of queries.
     *
     * @access private
     * @param array $queries An array of SQL queries to run.
     */
    function _runQueries($queries)
    {
        // Use the Upgrade class' PEAR_Error handler
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array($this, 'pearErrorHandler'));
        // Execute the upgrade SQL statements
        foreach ($queries as $query) {
            $this->dbh->query($query);
        }
        // Restore the normal PEAR_Error handler
        PEAR::popErrorHandling();
    }

    /**
     * A callback method for setting the default PEAR_Error handling behaviour
     * when running the upgrade SQL statements.
     *
     * @param PEAR_Error $oError A {@link PEAR_Error} object.
     */
    function pearErrorHandler($oError)
    {
        if (preg_match('/^ALTER\s+TABLE\s+\w+\s+ADD\s+(?!INDEX)(?!KEY)(?!PRIMARY\s+KEY)/', $oError->userinfo)) {
            // May caused by trying to re-add a column, if so, ignore
            if ($oError->code == DB_ERROR) {
                return;
            }
        } elseif (preg_match('/^ALTER\s+TABLE\s+\w+\s+ADD\s+(INDEX|KEY)/', $oError->userinfo)) {
            // May caused by trying to re-add an index or key, if so, ignore
            if ($oError->code == DB_ERROR_ALREADY_EXISTS) {
                return;
            }
        } elseif (preg_match('/^ALTER\s+TABLE\s+\w+\s+ADD\s+PRIMARY\s+KEY/', $oError->userinfo)) {
            // May caused by trying to re-add a primary key, if so, ignore
            if ($oError->code == DB_ERROR_ALREADY_EXISTS) {
                return;
            }
        } elseif (preg_match('/^ALTER\s+TABLE\s+\w+\s+CHANGE/', $oError->userinfo)) {
            // May caused by trying to change a non-existant column, if so, ignore
            if ($oError->code == DB_ERROR_NOSUCHFIELD) {
                return;
            }
        } elseif (preg_match('/^ALTER\s+TABLE\s+\w+\s+DROP(?!PRIMARY\s+KEY)/', $oError->userinfo)) {
            // May caused by trying to drop a non-existant index, key, or column, if so, ignore
            if ($oError->code == DB_ERROR) {
                return;
            }
        } elseif (preg_match('/^DELETE\s+FROM/', $oError->userinfo)) {
            // May caused by tring to delete where a column has already been dropped, if so, ignore
            if ($oError->code == DB_ERROR_CANNOT_DELETE) {
                return;
            }
        }
        // This is a real error - add it to the array of errors
        $this->errors[] = MAX::errorObjToString($oError);
    }

    /**
     * A private method to run a specified upgrade or downgrade on the
     * delivery limitation plugins.
     *
     * @param string $keyColumn
     * @param string $table
     * @param string $upgradeMethod
     */
    function _upgradeDeliveryLimitations($keyColumn, $table, $upgradeMethod)
    {
        $query = "SELECT $keyColumn, type, comparison, data, executionorder FROM $table";
        $rResult = $this->dbh->query($query);
        $aQueriesUpgrade = array();
        $i = 0;
        while ($limitation = $rResult->fetchRow()) {
            $key = $limitation[$keyColumn];
            $executionOrder = $limitation['executionorder'];
            $oPlugin = $this->_getDeliveryLimitationPlugin($limitation['type']);
            $aResult = $oPlugin->$upgradeMethod(
                $limitation['comparison'],
                $limitation['data']
            );
            $op = $aResult['op'];
            $sData = MAX_limitationsGetQuotedString($aResult['data']);
            $queryUpgrade = "
                UPDATE
                    $table
                SET
                    comparison = '$op',
                    data = '$sData'
                WHERE
                    $keyColumn = $key
                    AND
                    executionorder = $executionOrder";
            $this->_runQuery($queryUpgrade);
        }
    }

    /**
     * A private method to instantiate a delivery limitation plugin object.
     *
     * @param string $sType The delivery limitation plugin package and name,
     *                      separated with a colon ":". For example, "Geo:Country".
     * @return
     */
    function _getDeliveryLimitationPlugin($sType)
    {
        $oPlugin = $this->aPlugins[$sType];
        if (is_null($oPlugin)) {
            $aType = explode(':', $sType);
            $oPlugin = &MAX_Plugin::factory('deliveryLimitations', $aType[0], $aType[1]);
            $this->aPlugins[$sType] = $oPlugin;
        }
        return $oPlugin;
    }

    /**
     * return the currently installed database schema version
     *
     * @return string version
     */
    function getVersionSchema()
    {
        PEAR::pushErrorHandling(null);
        $data = $this->dbh->tableInfo($this->conf['table']['prefix'].'application_variable');
        PEAR::popErrorHandling();
        if (PEAR::isError($data)) {
            // Could not find the application variables table
            return false;
        } else {
            $query = "
                SELECT
                    value AS max_version
                FROM
                    {$this->conf['table']['prefix']}application_variable
                WHERE
                    name = 'max_version'
                ";
            $row = $this->dbh->getRow($query);
            if (!PEAR::isError($row)) {
                return $row['max_version'];
            }
        }
        return false;
    }

    /**
     * return the currently installed code version
     *
     * @return string version
     */
    function getVersionConstant()
    {
        if (defined('MAX_VERSION_READABLE'))
        {
            return MAX_VERSION_READABLE;
        }
        return false;
    }

    /**
     * A method to return the name of the required upgrade function
     * to the necessary database format.
     *
     * @return array Array of errors encountered during upgrade
     */
    function getUpgradeFunction()
    {
        if (isset($this->upgradeFrom)) {
            if ($this->_compareVersions('v0.2.0-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.2.0-alpha
                return array("version"=>"v0.2.0-alpha", "function"=>"_upgradeToTwoZeroAlpha");
            }
            if ($this->_compareVersions('v0.2.1-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.2.1-alpha
                return array("version"=>"v0.2.1-alpha", "function"=>"_upgradeToTwoOneAlpha");
            }
            if ($this->_compareVersions('v0.2.3-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.2.3-alpha
                return array( "version"=>"v0.2.3-alpha", "function"=>"_upgradeToTwoThreeAlpha");
            }
            if ($this->_compareVersions('v0.2.4-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.2.4-alpha
                return array( "version"=>"v0.2.4-alpha", "function"=>"_upgradeToTwoFourAlpha");
            }
            if ($this->_compareVersions('v0.3.00-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.00-alpha
                return array( "version"=>"v0.3.00-alpha", "function"=>"_upgradeToThreeZeroAlpha");
            }
            if ($this->_compareVersions('v0.3.02-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.02-alpha
                return array( "version"=>"v0.3.02-alpha", "function"=>"_upgradeToThreeTwoAlpha");
            }
            if ($this->_compareVersions('v0.3.04-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.04-alpha
                return array( "version"=>"v0.3.04-alpha", "function"=>"_upgradeToThreeFourAlpha");
            }
            if ($this->_compareVersions('v0.3.05-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.05-alpha
                return array( "version"=>"v0.3.05-alpha", "function"=>"_upgradeToThreeFiveAlpha");
            }
            if ($this->_compareVersions('v0.3.09-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.09-alpha
                return array( "version"=>"v0.3.09-alpha", "function"=>"_upgradeToThreeNineAlpha");
            }
            if ($this->_compareVersions('v0.3.10-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.10-alpha
                return array( "version"=>"v0.3.10-alpha", "function"=>"_upgradeToThreeTenAlpha");
            }
            if ($this->_compareVersions('v0.3.11-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.11-alpha
                return array( "version"=>"v0.3.11-alpha", "function"=>"_upgradeToThreeElevenAlpha");
            }
            if ($this->_compareVersions('v0.3.13-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.13-alpha
                return array( "version"=>"v0.3.13-alpha", "function"=>"_upgradeToThreeThirteenAlpha");
            }
            if ($this->_compareVersions('v0.3.15-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.15-alpha
                return array( "version"=>"v0.3.15-alpha", "function"=>"_upgradeToThreeFifteenAlpha");
            }
            if ($this->_compareVersions('v0.3.16-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.16-alpha
                return array( "version"=>"v0.3.16-alpha", "function"=>"_upgradeToThreeSixteenAlpha");
            }
            if ($this->_compareVersions('v0.3.17-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.17-alpha
                return array( "version"=>"v0.3.17-alpha", "function"=>"_upgradeToThreeSeventeenAlpha");
            }
            if ($this->_compareVersions('v0.3.19-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.19-alpha
                return array( "version"=>"v0.3.19-alpha", "function"=>"_upgradeToThreeNineteenAlpha");
            }
            if ($this->_compareVersions('v0.3.21-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.21-alpha
                return array( "version"=>"v0.3.21-alpha", "function"=>"_upgradeToThreeTwentyOneAlpha");
            }
            if ($this->_compareVersions('v0.3.22-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.22-alpha
                return array( "version"=>"v0.3.22-alpha", "function"=>"_upgradeToThreeTwentyTwoAlpha");
            }
            if ($this->_compareVersions('v0.3.23-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.23-alpha
                return array( "version"=>"v0.3.23-alpha", "function"=>"_upgradeToThreeTwentyThreeAlpha");
            }
            if ($this->_compareVersions('v0.3.24-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.24-alpha
                return array( "version"=>"v0.3.24-alpha", "function"=>"_upgradeToThreeTwentyFourAlpha");
            }
            if ($this->_compareVersions('v0.3.25-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.25-alpha
                return array( "version"=>"v0.3.25-alpha", "function"=>"_upgradeToThreeTwentyFiveAlpha");
            }
            if ($this->_compareVersions('v0.3.26-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.26-alpha
                return array( "version"=>"v0.3.26-alpha", "function"=>"_upgradeToThreeTwentySixAlpha");
            }
            if ($this->_compareVersions('v0.3.27-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.27-alpha
                return array( "version"=>"v0.3.27-alpha", "function"=>"_upgradeToThreeTwentySevenAlpha");
            }
            if ($this->_compareVersions('v0.3.28-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.28-alpha
                return array( "version"=>"v0.3.28-alpha", "function"=>"_upgradeToThreeTwentyEightAlpha");
            }
            if ($this->_compareVersions('v0.3.29-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.29-alpha
                return array( "version"=>"v0.3.29-alpha", "function"=>"_upgradeToThreeTwentyNineAlpha");
            }
            if ($this->_compareVersions('v0.3.30-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.30-alpha
                return array( "version"=>"v0.3.30-alpha", "function"=>"_upgradeToThreeThirtyAlpha");
            }
            if ($this->_compareVersions('v0.3.31-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.31-alpha
                return array( "version"=>"v0.3.31-alpha", "function"=>"_upgradeToThreeThirtyOneAlpha");
            }
            if ($this->_compareVersions('v0.3.32-alpha', $this->upgradeFrom)) {
                // Upgrade to v0.3.32-alpha
                return array( "version"=>"v0.3.32-alpha", "function"=>"_upgradeToThreeThirtyTwoAlpha");
            }
        }
        return array("version"=>"", "function"=>"");
    }

}

?>
