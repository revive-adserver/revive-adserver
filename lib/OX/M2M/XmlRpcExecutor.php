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
 * Classes implementing this interface are responsible for communication phase 
 * of remote call. Concrete implementation may use REST, XML-RPC, Webservices
 * or other communication protocol.
 * In case of communication problems exceptions with codes described in {@link 
 * OX_M2M_XmlRpcErrorCodes.php} should be thrown.
 */
interface OX_M2M_XmlRpcExecutor
{
	function call($methodName, $params);
}

?>
