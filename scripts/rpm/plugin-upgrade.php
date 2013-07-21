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

/**
 * A script to upgrade plugins for rpm install
 *
 * @package    OpenXScripts
 * @subpackage Tools
 * @author     Lun Li <lun.li@openx.org>
 */

unset($session);
$GLOBALS['installing'] = true;
define('phpAds_installing', true);

require_once dirname(__FILE__) . '/../../init.php';
require_once MAX_PATH . '/scripts/rpm/lib-rpm.php';

// Setup oUpgrader
$oUpgrader = new OA_Upgrade();

if (file_exists('/opt/ox/adserver/etc/id') && trim(file_get_contents('/opt/ox/adserver/etc/id')) == 'masterconfig') {
    if (empty($GLOBALS['argv'][1]) || $GLOBALS['argv'][1] == 'default') {
    $customersFile = '/opt/ox/adserver/customers.xml';
    if (file_exists($customersFile)) {
        $customers = getCustomersArrayFromXMLFile($customersFile);
        foreach ($customers as $idx => $customer) {
            if (empty($customer['admin']) || !is_readable(MAX_PATH . '/var/' . $customer['admin'] . '.conf.php')) { continue; }
                // Call self with exec (to put the upgrade in a seperate memory-space
                passthru('php ' . MAX_PATH . "/scripts/rpm/plugin-upgrade.php {$customer['admin']} {$GLOBALS['argv'][2]}");
            }
        } else {    
            // Just upgrade/install for the 'current' customer
            upgradeplugin($GLOBALS['argv'][2], true);
        }
    } else {
        // script was called with a customer's domain, init should have bootstrapped correctly
            // Skip uninitialized customers
            if (empty($GLOBALS['_MAX']['CONF']['openads']['installed'])) { continue; } 

            // Verify that we can sucessfully connect to the database for this customer
            $dbh = &OA_DB::singleton();
            if (PEAR::isError($dbh)) {
                echo "WARNING: Unable to connect to the db for {$GLOBALS['argv'][1]}... skipping this customer\n";
                continue;
            }
        echo "Installing {$GLOBALS['argv'][2]} for {$GLOBALS['argv'][1]}\n";
        upgradeplugin($GLOBALS['argv'][2], true);
    }
} else { 
    // This machine is just a slave, unpack the plugin onto the filesystem only
    $result = unpackPlugin($argv[2]);
    
    cacheAllDataObjects();
}

?>
