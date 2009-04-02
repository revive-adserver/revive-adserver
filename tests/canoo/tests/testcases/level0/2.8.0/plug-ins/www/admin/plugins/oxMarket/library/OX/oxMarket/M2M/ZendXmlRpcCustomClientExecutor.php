<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: ZendXmlRpcCustomClientExecutor.php 34116 2009-03-23 10:41:43Z lukasz.wikierski $
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
