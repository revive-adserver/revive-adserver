<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
