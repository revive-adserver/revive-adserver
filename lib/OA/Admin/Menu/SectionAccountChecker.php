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
class OA_Admin_SectionAccountChecker
    implements OA_Admin_Menu_IChecker 
{
    var $aAccountTypes; //list of account types accepted by this acceptor

    function __construct($aAccountTypes = array())
    {
        if (!is_array($aAccountTypes)) {
            $aAccountTypes = array($aAccountTypes);
        }
        $this->aAccountTypes = $aAccountTypes;
    }


    function check($oSection)
    {
        $aAccounts = $this->_getAllowedAccountTypes();

  	    //no required accounts to show it
  	    if (empty($aAccounts)) {
  		    return true;
  	    }
        $isAllowedAccount = false;
	  	for ($i = 0; $i < count($aAccounts); $i++) {
	       $isAllowedAccount = OA_Permission::isAccount($aAccounts[$i]);
	       if ($isAllowedAccount) {
	           break;
	       }
	  	}

        return $isAllowedAccount;
    }


    function _getAllowedAccountTypes()
    {
        return $this->aAccountTypes;
    }
}
?>