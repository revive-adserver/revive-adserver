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

require_once(MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php');

/**
 * An acceptor that takes into account roles that are required to access the section.
 * - if the list of allowed accounts associated with the acceptor is empty, section gets accepted
 * - if the list is not empty current user must be of one of the account types required by this acceptor
 */
class OA_Admin_SectionAccountChecker implements OA_Admin_Menu_IChecker
{
    public $aAccountTypes; //list of account types accepted by this acceptor

    public function __construct($aAccountTypes = [])
    {
        if (!is_array($aAccountTypes)) {
            $aAccountTypes = [$aAccountTypes];
        }
        $this->aAccountTypes = $aAccountTypes;
    }


    public function check($oSection)
    {
        $aAccounts = $this->_getAllowedAccountTypes();

        //no required accounts to show it
        if (empty($aAccounts)) {
            return true;
        }
        $isAllowedAccount = false;
        foreach ($aAccounts as $i => $aAccount) {
            $isAllowedAccount = OA_Permission::isAccount($aAccount);
            if ($isAllowedAccount) {
                break;
            }
        }

        return $isAllowedAccount;
    }


    public function _getAllowedAccountTypes()
    {
        return $this->aAccountTypes;
    }
}
