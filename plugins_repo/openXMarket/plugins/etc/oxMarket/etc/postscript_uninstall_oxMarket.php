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

$className = 'postscript_uninstall_oxMarket';

/**
 * Removes market system entities
 *
 * @package    Plugin
 * @subpackage openxMarket
 */
class postscript_uninstall_oxMarket
{

    /**
     *
     * @return boolean True
     */
    function execute()
    {
        $doClients = OA_DAl::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $doClients->find();
        while( $doClients->fetch()) {
             $doAdvertiserAccount = OA_Dal::staticGetDO('accounts',$doClients->account_id);
             $doAdvertiserAccount->delete(); // cascade delete
        }
        return true;
    }
}
