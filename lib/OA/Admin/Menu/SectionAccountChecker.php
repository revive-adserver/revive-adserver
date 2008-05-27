<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

    function OA_Admin_SectionAccountChecker($aAccountTypes = array())
    {
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