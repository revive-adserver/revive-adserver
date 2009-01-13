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
$Id$
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
