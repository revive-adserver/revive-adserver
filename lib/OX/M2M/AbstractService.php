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
 * OAP to OAC communication class
 *
 */
require_once (dirname(__FILE__) . "/XmlRpcErrorCodes.php");

class OX_M2M_AbstractService
{
    /**
     * @var OX_M2M_XmlRpcExecutor
     */
    protected $rpcExecutor;
	protected $prefix = "oac.";
    
	
    function OA_Dal_Central_Rpc(&$rpcExecutor)
    {
        $this->$rpcExecutor = &$rpcExecutor;
    }
	
    
    function call($methodName, $aParams = null)
    {
        return $this->rpcExecutor->call($this->prefix . $methodName, $aParams);
    }
}

?>
