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

//hack to fix LIB_PATH inconsistency among projects
if (!defined(LIB_PATH_)) {
	define("LIB_PATH_", preg_replace("/OX$/", "", LIB_PATH));
}

require_once(LIB_PATH_ . '/Zend/Http/Client.php');
require_once(LIB_PATH_ . '/Zend/XmlRpc/Client.php');

class OX_oxMarket_M2M_ZendXmlRpcCustomClientExecutor
	implements OX_M2M_XmlRpcExecutor
{
	/**
	 * @var Zend_XmlRpc_Client
	 */
	private $rpcClient;
	private $prefix = "";

	public function getPrefix()
	{
		return $this->prefix;
	}


	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
	}


	function __construct(Zend_XmlRpc_Client $rpcClient, $prefix = "")
	{
		$this->rpcClient = $rpcClient;
		$this->prefix = $prefix;
	}


	function call($methodName, $params)
	{
		return $this->rpcClient->call($this->getPrefix() . $methodName, $params);
	}
}

?>
