<?php

class OX_M2M_PearXmlRpcExecutor
	implements OX_M2M_XmlRpcExecutor 
{
	/**
	 * @var XML_RPC_Client
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
	
	
	function __construct($server)
	{
		$this->rpcClient = new XML_RPC_Client("" ,$server);
	}
	
	
	function call($methodName, $params)
	{
		return $this->rpcClient->call($this->getPrefix() . $methodName, $params);	
	}
}

?>
