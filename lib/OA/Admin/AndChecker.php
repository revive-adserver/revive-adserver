<?php
/**
 * Compound checker whose result is a logical AND between the results of all the enclosed checkers.
 * Checking is stopped at first failure so invokations should not assume that every checker will be invoked. 
 */
class OA_Admin_AndChecker
{
    var $aCheckers; 
  
    function OA_Admin_AndChecker($aCheckers = array())
    {
        $this->aCheckers = $aCheckers;
    }
  
  
    function check($oSection) 
    {
    	$aCheckers = $this->_getCheckers();
    	
      if (empty($aCheckers)) {
        return true;
      }
      
      $checkOK = false;
	  	for ($i = 0; $i < count($aCheckers); $i++) {
         $checkOK = $aCheckers[$i]->check($oSection);
	       if (!$checkOK) {
	           break;
	       }
	  	}
  	
      return $checkOK;
    }
    
    
    function _getCheckers() 
    {
        return $this->aCheckers;      
    }    
}
?>