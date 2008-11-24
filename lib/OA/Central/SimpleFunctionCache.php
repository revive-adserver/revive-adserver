<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Central/M2M.php';
require_once MAX_PATH . '/lib/OA/Dal/Central/AdNetworks.php';

require_once MAX_PATH . '/lib/max/Admin_DA.php';

require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

require_once('Cache/Lite.php');

/**
 * OXP binding to the currency FX feed OXC API
 *
 */
class SimpleFunctionCache
{
	/**
     * @var Cache_Lite
     */
	private $oCache;
	private $permamentCache;
	public $cacheId;
    public $groupId;
    public $fullId; 
    public $object;
    public $method;
    
    public function SimpleFunctionCache(&$oCache, &$oPermamentCache, &$object, $method, $groupId, $cacheId)
    {
		$this->groupId = $groupId; 
		$this->cacheId = $cacheId;
		$this->fullId = $groupId . "::" . $cacheId;
		$this->oCache = &$oCache;
		$this->permamentCache = &$oPermamentCache;
		$this->object = &$object;
		$this->method = $method;
    }
	
    
    function getFromCache($checkValidity)
    {
    	return unserialize($this->oCache->get($this->cacheId, $this->groupId, !$checkValidity));
    }
    
    
    function getFromPermamentCache()
    {
    	$result = $this->getFromCache(false);
    	return $result ? $result : $this->permamentCache->get($this->fullId);
    }
    
    
    function getFromUserFunction()
    {
    	$result = $this->object->{$this->method}();
		if ($result) {
			$this->oCache->save(serialize($result), $this->cacheId, $this->groupId);
			return $result;
		}
    	return $this->getFromPermamentCache();
    }
    
    
    function get()
    {
    	return ($result = $this->getFromCache(true)) ? $result : $this->getFromUserFunction();
    }
	
    
    function removeCache()
    {
    	$this->oCache->remove($this->cacheId, $this->groupId);
    }
}
?>
