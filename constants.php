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

/**
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 *
 * A file to set up the environment constants for Openads.
 */

/**
 * The environmental constants initialisation function for Openads.
 */
function setupConstants()
{
    // Define this version of Openads's constants
    define('MAX_VERSION',           '2.3');
    define('OA_VERSION' ,           '2.3.32');
    define('MAX_VERSION_READABLE',  'v2.3.32-beta');
    define('MAX_PRODUCT_NAME',      'Openads');
    define('MAX_PRODUCT_URL',       'www.openads.org');

    // This old PAN constant is used in a couple places but could well conflict with the configured DB
    // TODO: find any uses of this constant and re-think their place.
    define('phpAds_dbmsname', 'MySQL');

    // Database connection constants
    define('MAX_DSN_ARRAY',                 0);
    define('MAX_DSN_STRING',                1);
    $GLOBALS['_OA']['CONNECTIONS'] =        array();

    // Error codes to use with MAX::raiseError()
    // Start at -100 in order not to conflict with PEAR::DB error codes
    define('MAX_ERROR_INVALIDARGS',         -101);  // Wrong args to function
    define('MAX_ERROR_INVALIDCONFIG',       -102);  // Something wrong with the config
    define('MAX_ERROR_NODATA',              -103);  // No data available
    define('MAX_ERROR_NOCLASS',             -104);  // No class exists
    define('MAX_ERROR_NOMETHOD',            -105);  // No method exists
    define('MAX_ERROR_NOAFFECTEDROWS',      -106);  // No rows where affected by update/insert/delete
    define('MAX_ERROR_NOTSUPPORTED'  ,      -107);  // Limit queries on unsuppored databases
    define('MAX_ERROR_INVALIDCALL',         -108);  // Overload getter/setter failure
    define('MAX_ERROR_INVALIDAUTH',         -109);
    define('MAX_ERROR_EMAILFAILURE',        -110);
    define('MAX_ERROR_DBFAILURE',           -111);
    define('MAX_ERROR_DBTRANSACTIONFAILURE',-112);
    define('MAX_ERROR_BANNEDUSER',          -113);
    define('MAX_ERROR_NOFILE',              -114);
    define('MAX_ERROR_INVALIDFILEPERMS',    -115);
    define('MAX_ERROR_INVALIDSESSION',      -116);
    define('MAX_ERROR_INVALIDPOST',         -117);
    define('MAX_ERROR_INVALIDTRANSLATION',  -118);
    define('MAX_ERROR_FILEUNWRITABLE',      -119);
    define('MAX_ERROR_INVALIDMETHODPERMS',  -120);
    define('MAX_ERROR_INVALIDREQUEST',      -121);
    define('MAX_ERROR_INVALIDTYPE',         -122);
    define('MAX_ERROR_INVALIDOPERATIONINT', -123);
    define('MAX_ERROR_INVALIDBANNERSIZE',   -124);
    define('MAX_ERROR_INVALIDBANNERTYPE',   -125);
    define('MAX_ERROR_ALREADYLINKED',       -126);
    define('MAX_ERROR_EXISTINGCAMPAIGNFORDATES',-127);
    define('MAX_ERROR_EMAILNODATES',-128);

    // Ad/Zone association link types
    define('MAX_AD_ZONE_LINK_DIRECT',   0);
    define('MAX_AD_ZONE_LINK_NORMAL',   1);
    define('MAX_AD_ZONE_LINK_CATEGORY', 2);

    // URL construction constants
    define('MAX_URL_ADMIN',          0);
    define('MAX_URL_IMAGE',          1);
    define('MAX_URL_DEL_SCRIPT',     2);
    define('MAX_URL_DEL_SCRIPT_SSL', 3);
    define('MAX_URL_DEL_IMG',        4);
    define('MAX_URL_DEL_IMG_SSL',    5);

    // Connection action type constants
    define('MAX_CONNECTION_AD_IMPRESSION',      0);
    define('MAX_CONNECTION_AD_CLICK',           1);
    define('MAX_CONNECTION_AD_ARRIVAL',         2);
    define('MAX_CONNECTION_MANUAL',             4);

    // Campaign deactivation reasons
    // Values must be x^2, as used as binary flags
    define('MAX_PLACEMENT_DISABLED_IMPRESSIONS',  2);
    define('MAX_PLACEMENT_DISABLED_CLICKS',       4);
    define('MAX_PLACEMENT_DISABLED_CONVERSIONS',  8);
    define('MAX_PLACEMENT_DISABLED_DATE',        16);

    // Active, inactive agency values
    define('MAX_AGENCY_INACTIVE', 1);
    define('MAX_AGENCY_ACTIVE', 1);

    // Time contstants
    define('SECONDS_PER_WEEK', 604800);
    define('MINUTES_PER_WEEK', 10080);
    define('SECONDS_PER_DAY',  86400);
    define('SECONDS_PER_HOUR', 3600);
    define('MINUTES_PER_DAY',  1440);

    // Connection status types. Only the default conversion
    // status (MAX_CONNECTION_STATUS_APPROVED) is defined (4), which
    // is a conversion type that is approved by default.
    // Note also that only ignore, pending and approved
    // are used as possible starting values (ie. in the
    // campaigns_trackers table.
    define('MAX_CONNECTION_STATUS_IGNORE',      1);
    define('MAX_CONNECTION_STATUS_PENDING',     2);
    define('MAX_CONNECTION_STATUS_ONHOLD',      3);
    define('MAX_CONNECTION_STATUS_APPROVED',    4);
    define('MAX_CONNECTION_STATUS_DISAPPROVED', 5);
    define('MAX_CONNECTION_STATUS_DUPLICATE',   6);

    // Connection action type constants
    define('MAX_CONNECTION_TYPE_SALE',   1);
    define('MAX_CONNECTION_TYPE_LEAD',   2);
    define('MAX_CONNECTION_TYPE_SIGNUP', 3);

    // Financial constants
    define('MAX_FINANCE_CPM',    1);
    define('MAX_FINANCE_CPC',    2);
    define('MAX_FINANCE_CPA',    3);
    define('MAX_FINANCE_MT',     4); // Monthly Tennancy
    define('MAX_FINANCE_RS',     5); // % Revenue split     (zone-only)
    define('MAX_FINANCE_BV',     6); // % Basket value      (zone-only)
    define('MAX_FINANCE_AI',     7); // Amount per item     (zone-only)
    define('MAX_FINANCE_ANYVAR', 8); // % of any variable   (zone-only)
    define('MAX_FINANCE_VARSUM', 9); // % of a variable sum (zone-only)

    $GLOBALS['_MAX']['STATUSES'] = array(
        MAX_CONNECTION_STATUS_IGNORE      => 'strStatusIgnore',       // start value
        MAX_CONNECTION_STATUS_PENDING     => 'strStatusPending',      // start value
        MAX_CONNECTION_STATUS_ONHOLD      => 'strStatusOnHold',
        MAX_CONNECTION_STATUS_APPROVED    => 'strStatusApproved',     // start value
        MAX_CONNECTION_STATUS_DISAPPROVED => 'strStatusDisapproved',
        MAX_CONNECTION_STATUS_DUPLICATE   => 'strStatusDuplicate',
    );

    $GLOBALS['_MAX']['CONN_TYPES'] = array(
        MAX_CONNECTION_TYPE_SALE   => 'strConnTypeSale',
        MAX_CONNECTION_TYPE_LEAD   => 'strConnTypeLead',
        MAX_CONNECTION_TYPE_SIGNUP => 'strConnTypeSignUp',
    );

    define('MAX_DELIVERY_1x1', 'R0lGODlhAQABAIAAAP///wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==');
    define('MAX_DELIVERY_MULTIPLE_DELIMITER', '|');
    define('MAX_COOKIELESS_PREFIX', '__');

    // IP Address used to determine which (if any) MaxMind databases are installed
    define('MAX_MIND_TEST_IP', '24.24.24.24');

    // Maximum random number
    define('MAX_RAND',     mt_getrandmax());
    define('MAX_RAND_INV', 1 / MAX_RAND);

    // Maintenance Engine Plugin Types
    define('MAINTENANCE_PLUGIN_PRE',  0);
    define('MAINTENANCE_PLUGIN_POST', 1);

    // Maintenance Engine Plugin Hooks Points
    define('MSE_PLUGIN_HOOK_AdServer_summariseIntermediateRequests',    0);
    define('MSE_PLUGIN_HOOK_AdServer_summariseIntermediateImpressions', 1);
    define('MSE_PLUGIN_HOOK_AdServer_summariseIntermediateClicks',      2);
    define('MSE_PLUGIN_HOOK_AdServer_summariseIntermediateConnections', 3);
    define('MSE_PLUGIN_HOOK_AdServer_saveIntermediateSummaries',        4);
    define('MSE_PLUGIN_HOOK_AdServer_saveHistory',                      5);
    define('MSE_PLUGIN_HOOK_AdServer_saveSummary',                      6);
    define('MSE_PLUGIN_HOOK_AdServer_deleteOldData',                    7);
    define('MSE_PLUGIN_HOOK_Tracker_deleteOldData',                     8);

    // LegalAgreement Plugin Types
    define('LEGALAGREEMENT_PLUGIN_PRE',         0);
    define('LEGALAGREEMENT_PLUGIN_POST_DENY',   1);
    define('LEGALAGREEMENT_PLUGIN_POST_ACCEPT', 2);

    define('MAX_LIMITATION_EQUAL', 0);
    define('MAX_LIMITATION_NOT_EQUAL', 1);
    define('MAX_LIMITATION_BITWISE', 2);

    // Ensure that the initialisation has not been run before
    if (!(isset($GLOBALS['_MAX']['CONF']))) {
        // Define the Openads installation base path if not defined
        // since Local mode will pre-define this value
        if (!defined('MAX_PATH')) {
            define('MAX_PATH', dirname(__FILE__));
        }
        // Define the PEAR installation path
        $existingPearPath = ini_get('include_path');
        $newPearPath = MAX_PATH . '/lib/pear';
        if (!empty($existingPearPath)) {
            $newPearPath .= PATH_SEPARATOR . $existingPearPath;
        }
        ini_set('include_path', $newPearPath);
        // Define the week to start on Sunday (0) so that the PEAR::Date and
        // PEAR::Date_Calc classes agree on what day is the start of the week
        define('DATE_CALC_BEGIN_WEEKDAY', 0);
        // Ensure that the TZ environment variable is set for PHP < 5.1.0, so
        // that PEAR::Date class knows which timezone we are in, and doesn't
        // screw up the dates after using the PEAR::compare() method -  also,
        // ensure that an appropriate timezone is set, if required, to allow
        // the time zone to be other than the time zone of the server
        if (version_compare(phpversion(), '5.1.0', '>=')) {
            if (isset($GLOBALS['_MAX']['CONF']['timezone']['location'])) {
                // Set new time zone
                date_default_timezone_set($GLOBALS['_MAX']['CONF']['timezone']['location']);
            }
        } else {
            if (isset($GLOBALS['_MAX']['CONF']['timezone']['location'])) {
                // Set new time zone
                putenv("TZ={$GLOBALS['_MAX']['CONF']['timezone']['location']}");
            } else {
                // Ensure that at TZ variable is set, regardless
                if (getenv('TZ') === false) {
                    $diff = date('O') / 100;
                    putenv('TZ=GMT'.($diff > 0 ? '-' : '+').abs($diff));
                }
            }
        }
        // Parse the Openads configuration file
        $GLOBALS['_MAX']['CONF'] = parseIniFile();
        // Define the Openads Cache File location path (required trailing slash)
        if (empty($GLOBALS['_MAX']['CONF']['delivery']['cachePath'])) {
            define('MAX_CACHE', MAX_PATH . '/var/cache/');
        } else {
            define('MAX_CACHE', $GLOBALS['_MAX']['CONF']['delivery']['cachePath']);
        }
        // Define the Openads Plugins Cache File location path (required trailing slash)
        if (empty($GLOBALS['_MAX']['CONF']['delivery']['pluginsCachePath'])) {
            define('MAX_PLUGINS_CACHE', MAX_PATH . '/var/plugins/');
        } else {
            define('MAX_PLUGINS_CACHE', $GLOBALS['_MAX']['CONF']['delivery']['pluginsCachePath']);
        }
        // Set the URL access mechanism
        if ($GLOBALS['_MAX']['CONF']['max']['requireSSL']) {
            $GLOBALS['_MAX']['HTTP'] = 'https://';
        } else {
            if (isset($_SERVER['SERVER_PORT'])) {
                if ($_SERVER['SERVER_PORT'] == $GLOBALS['_MAX']['CONF']['max']['sslPort']) {
                    $GLOBALS['_MAX']['HTTP'] = 'https://';
                } else {
                    $GLOBALS['_MAX']['HTTP'] = 'http://';
                }
            }
        }
        // Set the True Type Font path
        if (isset($GLOBALS['_MAX']['CONF']['graphs']['ttfDirectory'])) {
            define('IMAGE_CANVAS_SYSTEM_FONT_PATH', $GLOBALS['_MAX']['CONF']['graphs']['ttfDirectory']);
        }
    }
}

/**
 * This function is used to merge two config files
 * Any values in the second array will either overwrite or replace corresponding values in the first
 *
 * @param array $realConfig The base config file
 * @param array $fakeConfig The additional elements to add to the base config array
 * @return array The merged config files
 */
function mergeConfigFiles($realConfig, $fakeConfig)
{
    //unset($fakeConfig['realConfig']);
    foreach ($fakeConfig as $key => $value) {
        if (is_array($value)) {
            if (!isset($realConfig[$key])) {
                $realConfig[$key] = array();
            }
            $realConfig[$key] = mergeConfigFiles($realConfig[$key], $value);
        } else {
            if (isset($realConfig[$key]) && is_array($realConfig[$key])) {
                $realConfig[$key][0] = $value;
            } else {
                if (isset($realConfig) && !is_array($realConfig)) {
                    $temp = $realConfig;
                    $realConfig = array();
                    $realConfig[0] = $temp;
                }
                $realConfig[$key] = $value;
            }
        }
    }
    return $realConfig;
}

// Run the setupConstants() function
//setupConstants();

?>
