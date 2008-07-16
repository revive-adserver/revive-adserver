<?php
/**
 * An acceptor that takes into account roles that are required to access the section.
 * - if the list of allowed accounts associated with the acceptor is empty, section gets accepted
 * - if the list is not empty current user must be of one of the account types required by this acceptor 
 */
class OA_Admin_SectionAccountChecker
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