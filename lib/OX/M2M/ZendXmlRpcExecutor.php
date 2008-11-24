<?php

class OX_M2M_ZendXmlRpcExecutor
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
	
	
	function __construct($server, $prefix = "")
	{
		$this->rpcClient = new Zend_XmlRpc_Client($server);
		$this->prefix = $prefix;
	}
	
	
	function call($methodName, $params)
	{
		return $this->rpcClient->call($this->getPrefix() . $methodName, $params);	
	}
}

?>
