<?php
/**
 * An acceptor that can be used to filter out sections from collections.
 * For every section it invokes its related checker and returns the result of the check.
 */
class OA_Admin_SectionCheckerFilter
{
    function OA_Admin_SectionCheckerFilter()
    {
    }
  
  
    function accept($oSection) 
    {
        $checker = $oSection->getChecker();
    	
        return $checker->check($oSection);
    }
}
?>